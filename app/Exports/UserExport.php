<?php

namespace App\Exports;

use App\Models\Mail\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView
{
    public function view(): View
    {
        return view('admin.exports.users', [
            'users' => User::all()
        ]);
    }
}
