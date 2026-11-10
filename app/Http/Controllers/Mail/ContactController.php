<?php

namespace App\Http\Controllers\Mail;

use Exception;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Mail\Category;
use App\Models\Mail\ContactPerson;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ContactImport;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = ContactPerson::Type('sms')->with('category')->orderBy('id', 'desc')->paginate(10);
        return view('mail_vendor.contacts.index' , compact('contacts'));
    }

    public function mail()
    {
        $contacts = ContactPerson::Type('EMAIL')->with('category')->orderBy('id', 'desc')->paginate(10);
        $categories = Category::Type('EMAIL')->get();
        return view('mail_vendor.contacts.email' , compact('contacts', 'categories'));
    }

    public function create()
    {
        $categories = Category::Type('EMAIL')->get();
        return view('mail_vendor.contacts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"           => "required|string|max:191",
            "phone"          => "required",
            "email"          => "required|email",
            "category_id"    => "required|exists:categories,id",
            "type"           => "required"
        ]);

        $store = $this->contactSave($request);

        if(!$store){
            return back()->with('error', 'Something went wrong!');
        }

        return redirect()->route('admin.contacts.' . Str::lower($request->type) .'.index')->with('success', 'Contacts create successfully!');
    }

    protected function contactSave($request)
    {
        try{
            $contacts = new ContactPerson();
            $contacts->category_id = $request->category_id;
            $contacts->name  = $request->name;
            $contacts->title = $request->title;
            $contacts->city  = $request->city;
            $contacts->phone = $request->phone;
            $contacts->email = $request->email;
            $contacts->type  = $request->type;
            $contacts->status = 1;
            $contacts->save();

            return true;
        }catch(Exception $e){
            return false;
        }
    }
    
     public function contactBulkUpload(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'csvfile' => 'required|mimes:xlsx,xls,csv',
            'category_id' => 'required|exists:categories,id'
        ], [
            'csvfile.required' => __('Please upload a file.'),
            'csvfile.mimes' => __('The file must be a valid Excel or CSV file.'),
            'category_id.required' => __('Please select a category.'),
            'category_id.exists' => __('Selected category id does not exist.'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $file = $request->file('csvfile');

        try {
            $contactsdata = Excel::toArray(new ContactImport(), $file)[0];

            foreach (array_chunk($contactsdata, 1000) as $records) {
                DB::beginTransaction();
                try {
                    foreach ($records as $record) {
                        if(isset($record[0]) && filter_var($record[1], FILTER_VALIDATE_EMAIL) && filter_var($record[2], FILTER_SANITIZE_NUMBER_INT)){
                            $contact = preg_replace('/[^0-9]/', '', trim(str_replace('+', '', $record[2])));

                            $existingContact = ContactPerson::where('email', $record[1])->first();

                            if (!$existingContact) {
                                ContactPerson::create([
                                    'category_id'       => $request->category_id,
                                    'name'              => $record[0],
                                    'email'             => $record[1],
                                    'phone'             => $contact,
                                    'type'              => "email",
                                    'status'            => 1,
                                ]);
                            }
                        }
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json([
                        'status' => false,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'File uploaded successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
