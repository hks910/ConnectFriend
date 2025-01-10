<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function sendMessage(Request $request, $receiver_id)
    {
        // Validate message input
        $this->validateMessage($request);

        // Save the chat message to the database
        $this->storeChatMessage($request, $receiver_id);

        return back();
    }

    // Validate the message input
    private function validateMessage(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ], [
            'message.required' => __('validation.message_required')
        ]);
    }

    // Store chat message to the database
    private function storeChatMessage(Request $request, $receiver_id)
    {
        Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $receiver_id,
            'message' => $request->message
        ]);
    }
}
