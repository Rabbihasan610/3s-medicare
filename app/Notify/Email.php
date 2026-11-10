<?php

namespace App\Notify;
use App\Notify\NotifyProcess;
use App\Notify\Notifiable;
use Mailjet\Client;
use Mailjet\Resources;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use SendGrid;
use SendGrid\Mail\Mail;

class Email extends NotifyProcess implements Notifiable{

    /**
    * Email of receiver
    *
    * @var string
    */
	public $email;

    /**
    * Assign value to properties
    *
    * @return void
    */
	public function __construct(){
		$this->statusField = 'email_status';
		$this->body = 'email_body';
		$this->globalTemplate = 'email_template';
		$this->notifyConfig = 'mail_config';

	}

    /**
    * From name configured in Admin > Email Setting, falling back to the site name.
    */
	protected function fromName(){
		return $this->setting->email_from_name ?: $this->setting->site_name;
	}

    /**
    * Reply-To configured in Admin > Email Setting, falling back to the from address.
    */
	protected function replyTo(){
		return $this->setting->email_reply_to ?: $this->setting->email_from;
	}

    /**
    * Append the configured signature, in the recipient's language when available.
    */
	protected function appendSignature(){
		$signature = app()->getLocale() === 'ar'
			? ($this->setting->email_signature_ar ?: $this->setting->email_signature)
			: $this->setting->email_signature;

		if (trim((string) $signature) !== '') {
			$this->finalMessage .= '<br><br>' . nl2br(e($signature));
		}
	}

    /**
    * Send notification
    *
    * @return void|bool
    */
	public function send(){
		//get message from parent
		$message = $this->getMessage();
		if ($this->setting->en && $message) {
			$this->appendSignature();
			//Send mail
			$methodName = $this->setting->mail_config->name;

			$method = $this->mailMethods($methodName);
			try{
				$this->$method();
				$this->createLog('email');
			}catch(\Exception $e){
				$this->createErrorLog($e->getMessage());
				session()->flash('mail_error',$e->getMessage());
			}
		}

	}

    /**
    * Send a message straight through the configured transport.
    *
    * The normal send() path needs a NotificationTemplate row and quietly does
    * nothing when one is missing, which makes it useless for verifying a mail
    * configuration. This bypasses the template lookup and lets any transport
    * exception bubble up so the caller can show the real reason.
    *
    * @throws \Exception
    * @return void
    */
	public function sendDirect($email, $subject, $body, $receiverName = null){
		$this->setSetting();
		$this->email         = $email;
		$this->toAddress     = $email;
		$this->receiverName  = $receiverName ?: explode('@', $email)[0];
		$this->subject       = $subject;
		$this->finalMessage  = $body;

		$this->appendSignature();

		$method = $this->mailMethods($this->setting->mail_config->name);
		$this->$method();
	}

    /**
    * Get the method name
    *
    * @return string
    */
	protected function mailMethods($name){
		$methods = [
			'php'=>'sendPhpMail',
			'smtp'=>'sendSmtpMail',
			'sendgrid'=>'sendSendGridMail',
			'mailjet'=>'sendMailjetMail',
		];
		return $methods[$name];
	}

	protected function sendPhpMail(){
		$general = $this->setting;
		$fromName = $this->fromName();
		$replyTo  = $this->replyTo();
		$headers = "From: $fromName <$general->email_from> \r\n";
	    $headers .= "Reply-To: $fromName <$replyTo> \r\n";
	    $headers .= "MIME-Version: 1.0\r\n";
	    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
	    @mail($this->email, $this->subject, $this->finalMessage, $headers);
	}

	protected function sendSmtpMail(){

		$mail = new PHPMailer(true);

		$general = $this->setting;


		$config = $general->mail_config;


        //Server settings
        $mail->isSMTP();

        $mail->Host       = $config->host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $config->username;
        $mail->Password   = $config->password;
        if ($config->enc == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }else{
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port       = $config->port;
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom($general->email_from, $this->fromName());
        $mail->addAddress($this->email, $this->receiverName);
        $mail->addReplyTo($this->replyTo(), $this->fromName());
        // Content
        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $mail->Body    = $this->finalMessage;

        $mail->send();
	}

	protected function sendSendGridMail(){
		$general = $this->setting;
		$sendgridMail = new Mail();
	    $sendgridMail->setFrom($general->email_from, $this->fromName());
	    $sendgridMail->setSubject($this->subject);
	    $sendgridMail->addTo($this->email, $this->receiverName);
	    $sendgridMail->addContent("text/html", $this->finalMessage);
	    $sendgrid = new SendGrid($general->mail_config->appkey);
	    $response = $sendgrid->send($sendgridMail);
	    if($response->statusCode() != 202){
	    	throw new Exception(json_decode($response->body())->errors[0]->message);

	    }
	}

	protected function sendMailjetMail()
	{
		$general = $this->setting;
	    $mj = new Client($general->mail_config->public_key, $general->mail_config->secret_key, true, ['version' => 'v3.1']);
	    $body = [
	        'Messages' => [
	            [
	                'From' => [
	                    'Email' => $general->email_from,
	                    'Name' => $this->fromName(),
	                ],
	                'To' => [
	                    [
	                        'Email' => $this->email,
	                        'Name' => $this->receiverName,
	                    ]
	                ],
	                'Subject' => $this->subject,
	                'TextPart' => "",
	                'HTMLPart' => $this->finalMessage,
	            ]
	        ]
	    ];
	    $response = $mj->post(Resources::$Email, ['body' => $body]);
	}

    /**
    * Configure some properties
    *
    * @return void
    */
	public function prevConfiguration(){
		if ($this->user) {
			$this->email = $this->user->email;
			$this->receiverName = $this->user->fullname;
		}
		$this->toAddress = $this->email;
	}
}
