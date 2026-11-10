<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\SupportTicketManager;

class SupportController extends Controller
{
    use SupportTicketManager;
    
    public function __construct()
    {
        $this->layout = 'frontend';

        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            if ($this->user) {
                $this->layout = 'master';
            }
            return $next($request);
        });

        $this->redirectLink = 'support.view';
        $this->userType     = 'user';
        $this->column       = 'user_id';
    }
}
