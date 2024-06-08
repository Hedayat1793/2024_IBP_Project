<?php

namespace App\Http\Controllers\Tutor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Message;
use Image;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    //Save class Function
    public function sendmessage(Request $request)
    {
        $user = Auth::user();

        // Validation
        $this->validate($request, [
            'reciever_id' => 'required',
            'content' => 'required',
        ]);

        $reciever_id = $request['reciever_id'];

        $content= $request['content'];

        $attach = $request->file('attach')->store('message');

        // Save Record into message DB
        $message = new Message();
        $message->user_id = $user->id;
        $message->reciever_id = $reciever_id;
        $message->content = $content;
        $message->attach = $attach;
        $message->save();

        \Session::flash('Success_message', '✔ Message Sent Successfully.');

        return redirect()->route('tutormessage');
    }

    public function deletemessage($id)
    {
        // Delete Message
        $message = Message::where('id', $id)->first();
        Storage::delete($message->attach);
        $message->delete();

        \Session::flash('Success_message', 'You Have Successfully Deleted file');

        return back();
    }
}
