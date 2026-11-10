<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Http\Controllers\Controller;
use App\Traits\SupportTicketManager;

class SupportTicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('admin')->user();
            return $next($request);
        });

        $this->userType = 'admin';
        $this->column = 'admin_id';
    }

    public function tickets()
    {
        $title = 'All Tickets';
        $items = SupportTicket::orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'title'));
    }

    public function pendingTicket()
    {
        $title = 'Pending Tickets';
        $items = SupportTicket::whereIn('status', [Status::TICKET_OPEN,Status::TICKET_REPLY])->orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'title'));
    }

    public function closedTicket()
    {
        $title = 'Closed Tickets';
        $items = SupportTicket::where('status',Status::TICKET_CLOSE)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'title'));
    }

    public function answeredTicket()
    {
        $title = 'Answered Tickets';
        $items = SupportTicket::orderBy('id','desc')->with('user')->where('status',Status::TICKET_ANSWER)->paginate(getPaginate());
        return view('admin.support.tickets', compact('items', 'title'));
    }

    public function ticketReply($id)
    {
        $ticket = SupportTicket::with('user')->where('id', $id)->firstOrFail();
        $messages = SupportMessage::with('ticket','admin','attachments')->where('support_ticket_id', $ticket->id)->orderBy('id','desc')->get();
        return view('admin.support.reply', compact('ticket', 'messages'));
    }

    public function ticketDelete($id)
    {
        $message = SupportMessage::findOrFail($id);
        $path = getFilePath('ticket');
        if ($message->attachments()->count() > 0) {
            foreach ($message->attachments as $attachment) {
                fileManager()->removeFile($path.'/'.$attachment->attachment);
                $attachment->delete();
            }
        }
        $message->delete();
        $notify[] = ['success', "Support ticket deleted successfully"];
        return back()->withNotify($notify);

    }
}
