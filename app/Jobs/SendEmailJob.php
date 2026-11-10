<?php

namespace App\Jobs;

use App\Models\Mail\History;
use App\Models\Mail\Category;
use App\Models\Mail\Template;
use App\Traits\SmsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Traits\MailConfigTrait;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, MailConfigTrait, SmsTrait;

    public $history_id;

    /**
     * Create a new job instance.
     *
     * @param int $history_id
     * @return void
     */
    public function __construct($history_id)
    {
        $this->history_id = $history_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $history = History::where("id", $this->history_id)->first();
        
  
        if($history) {
            if($history->group_id){
                try {

                    $contactGroup = Category::with('contacts')->findOrFail($history->group_id);
                    $this->historyUpdateRunning($history);
                    foreach ($contactGroup->contacts as $contact) {

                        if($history->template_code !== null){
                            $s_code = $this->sCode($history->template_code, $contact);
                            $detail = $this->templateConfig($history->template_code, $s_code);
                            $body = $detail['message_body'];
                        }else{
                            $body = $history->message;
                        }

                        $data = [
                            "subject"        => $history->subject,
                            "email_from"     => $history->domain,
                            "site_name"      => gs('site_name'),
                            "email"          => $contact->email,
                            "receiverName"   => $contact->email,
                            "body"           => $body,
                            "attachments"    => $history->attachment
                        ];

                        $this->sendSmtpMail($history->domain, $data);

                        $this->throttle();
                    }

                    $this->historyUpdateCompleted($history);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }



            } else {
                $this->handleMailSend($history);

                $this->historyUpdateCompleted($history);
            }
        }

    }

    public function handleMailSend($history)
    {
        $this->historyUpdateRunning($history);
        foreach (json_decode($history->email, true) as $email) {

            $data = [
                "subject"        => $history->subject,
                "email_from"     => $history->domain,
                "site_name"      => gs('site_name'),
                "email"          => $email,
                "receiverName"   => $email,
                "body"           => $history->message,
                "attachments"    => $history->attachment
            ];

            $this->sendSmtpMail($history->domain, $data);

            $this->throttle();
        }
        
       
    }
    
    
    /**
     * Pause between recipients so the SMTP provider is not hit too fast.
     *
     * This used to be a hard sleep(30). With QUEUE_CONNECTION=sync the job runs
     * inside the web request, so a 10 contact campaign held the browser for five
     * minutes. The delay is configurable now and skipped entirely on the sync
     * connection, where there is no worker to pace.
     */
    protected function throttle(): void
    {
        if (config('queue.default') === 'sync') {
            return;
        }

        $seconds = (int) config('mail.campaign_throttle_seconds', 2);

        if ($seconds > 0) {
            sleep($seconds);
        }
    }

    public function historyUpdateRunning($history)
    {
        $history = History::find($history->id);

        $history->status = 1;
        $history->save();

    }


    protected function historyUpdateCompleted($history)
    {
        $history = History::find($history->id);
        $history->status = 2;
        $history->save();

        Log::info($history->status);
    }



    protected  function sCode($template_code, $contact)
    {

        $template = Template::where('code', $template_code)->first();


        $s_encodes = $template->short_code;

        $code = [];

        foreach (json_decode($s_encodes, true) as $key => $s_code){
            $cleaned_value = preg_replace('/[^\w\s]/', '', $s_code);
            $code[$cleaned_value] = $contact->name;
        }

        return $code;

    }


    public function sendSmtpMail($domain, $history){

		$mail = new PHPMailer(true);
        $config = $this->mailConfig($domain);

        // mailConfig() returns [] when the DomainConfig row is missing, which used
        // to surface as a confusing PHPMailer error about a null host.
        if (empty($config['host'])) {
            throw new \RuntimeException('No sending domain is configured for this campaign (domain id: ' . $domain . ').');
        }

        //Server settings
        $mail->isSMTP();

        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        if ($config['encryption'] == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }else{
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port       = $config['port'];
        $mail->CharSet = 'UTF-8';


        $attachments = json_decode($history['attachments'], true);

        if ($attachments !== null && is_array($attachments)) {
            foreach ($attachments as $key => $attachment) {
                $attachmentPath = public_path('/assets/documents/') . $attachment;
                $mail->addAttachment($attachmentPath, $attachment);
            }
        }

        /*
        | The from address belongs in the config's "address" field. The previous
        | version used the bare domain, which is not a valid mailbox.
        */
        $fromAddress = $config['from']['address'] ?? $config['domain'];
        $fromName    = $config['from']['name'] ?? $history['site_name'];

        //Recipients
        $mail->setFrom($fromAddress, $fromName);
        $mail->addAddress($history['email'], $history['receiverName']);
        $mail->addReplyTo($fromAddress, $fromName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $history['subject'];

        // The body is already HTML built in the campaign editor. Escaping it here
        // delivered the raw markup to the recipient instead of a formatted email.
        $mail->Body    = $history['body'];
        $mail->AltBody = trim(strip_tags($history['body']));

        $mail->send();
	}

}
