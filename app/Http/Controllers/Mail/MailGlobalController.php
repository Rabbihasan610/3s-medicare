<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MailGlobalController extends Controller
{
    public function demoImportFilesms()
    {
        $path = filePath()['demo']['path'].'/demo.csv';
        $title = 'demo.csv';
        $headers = [
            'Content-Type'              => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Length'            => filesize($path),
            'Cache-Control'             => 'must-revalidate',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition'       => 'attachment; filename='.$title
        ];
        return response()->download($path, 'demo.csv', $headers);
    }


    public function demoFileDownloader($extension)
    {
        $path = filePath()['demo']['path'].'/demo.'.$extension;
        $title = slug('file').'-'.'/demo.'.$extension;
        if ($extension =='xlsx') {
            $headers = [
                'Content-Type'              => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Length'            => filesize($path),
                'Cache-Control'             => 'must-revalidate',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Disposition'       => 'attachment; filename='.$title
            ];
            return response()->download($path, 'demo.xlsx', $headers);
        }
        if ($extension=='csv'){
            return response()->download($path, 'demo.csv', ['Content-Description' =>  'File Transfer','Content-Type' => 'application/octet-stream','Content-Disposition' => 'attachment; filename=demo.csv']);
        }
        else{
            return response()->download($path, 'demo.txt', ['Content-Description' =>  'File Transfer','Content-Type' => 'application/octet-stream','Content-Disposition' => 'attachment; filename=demo.txt']);
        }

    }

}
