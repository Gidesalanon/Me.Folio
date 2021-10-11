<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HomeModel;
use Mail;
class IndexController extends Controller
{
    public function index(){
        return view('index');
    }

    public function saveContact(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'message' => 'required'
        ]);

        $contact = new HomeModel;

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->phone_number = $request->phone_number;
        $contact->message = $request->message;

        $contact->save();

        \Mail::send('contact_email',
             array(
                 'name' => $request->get('name'),
                 'email' => $request->get('email'),
                 'phone_number' => $request->get('phone_number'),
                 'subject' => $request->get('subject'),
                 'user_message' => $request->get('message'),
             ), function($message) use ($request)
               {
                  $message->from($request->email);
                  $message->to('bijujusala@gmail.com');
               });

          return back()->with('success', 'Thank you for contact us!');

    }
}
