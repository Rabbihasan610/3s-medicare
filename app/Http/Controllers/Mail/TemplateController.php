<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;

use App\Models\Mail\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::get();
        return view('mail_vendor.template.index', compact('templates'));
    }

    public function edit($id)
    {
        $template = Template::find($id);
        return view('mail_vendor.template.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "title"         => "required",
            "subject"       => "required",
            "message_body"  => "required",
        ]);

        $template = Template::find($id);

        $template->title        = $request->title;
        $template->subject      = $request->subject;
        $template->message_body = $request->message_body;
        $template->save();

        return redirect()->route('admin.template.index')->with('success', "Template update");
    }
}
