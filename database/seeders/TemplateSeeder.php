<?php

namespace Database\Seeders;

use App\Models\Mail\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $templates = [
            [
                "title"         => "Student Congratulations",
                "code"          => "student_code",
                "subject"       => "{{student_name}} Student congratulations",
                "message_body"  => "Dear, {{name}} congratulations for our college.
                                    Thanks for,
                                    WebLara
                                    ",
                "image"         => "null.png",
                "short_code"    => "{{name}}",
                "status"        => 1
            ],
            [
                "title"         => "Teacher Congratulations",
                "code"          => "teacher_code",
                "subject"       => "{{teacher_name}} Student congratulations",
                "message_body"  => "Dear, {{name}} congratulations for our college.

                                    Thanks for,
                                    WebLara
                                    ",
                "image"         => "null.png",
                "short_code"    => "{{name}}",
                "status"        => 1
            ]
        ];

        foreach($templates as $template){
            $tem = new Template();
            $tem->title            = $template["title"];
            $tem->code             = $template["code"];
            $tem->subject          = $template["subject"];
            $tem->message_body     = $template["message_body"];
            $tem->image            = $template["image"];
            $tem->short_code       = $template["short_code"];
            $tem->status           = $template["status"];
            $tem->save();
        }

    }
}
