<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MessageController extends Controller
{
    //
    public function storeMessage(Request $request)
    {
        $validatedData = $request->validate([
            'text' => 'required|string',
            'recipient_id' => 'required|exists:users,id',
        ],[
            'text.required' => 'The text field is required.',
            'recipient_id.required' => 'The recipient field is required.',
        ]);

        $encryptedText = Crypt::encryptString($request->input('text'));
        $message = new Message();
        $message->text = $encryptedText;
        $message->sender_id = auth()->id();
        $message->recipient_id = $request->input('recipient_id');
        $message->created_at = now();
        $message->expiry = now()->addDays(7); 
        $message->save();

        $request->session()->flash('success', 'Message send successfully');
        // return response()->json(['message' => 'Message stored successfully']);
        return redirect()->back();
    }

    public function readMessage($id, $decryptionKey)
    {
        $message = Message::findOrFail($id);
        if ($message->expiry < now()) {
            return response()->json(['error' => 'Message has expired'], 403);
        }
        $decryptedText = Crypt::decryptString($message->text, $decryptionKey);
        $message->delete(); 
        return response()->json(['message' => $decryptedText]);
    }

    public function message_list(){
        $messages_count = Message::where('recipient_id',Auth::id())->count();
        $messages = Message::where('recipient_id',Auth::id())->get();
        return view('message-list',compact('messages', 'messages_count'));
    }

}
