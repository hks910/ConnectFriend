<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function addFriend($receiver_id)
    {
        $this->createFriendRequest($receiver_id);

        return back();
    }

    public function acceptFriend($sender_id)
    {
        $this->updateFriendRequestStatus($sender_id, 'Accepted');

        return back();
    }

    public function rejectFriend($sender_id)
    {
        $this->deleteFriendRequest($sender_id);

        return back();
    }

    // Helper method to create a friend request
    private function createFriendRequest($receiver_id)
    {
        Friend::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $receiver_id
        ]);
    }

    // Helper method to update the status of a friend request
    private function updateFriendRequestStatus($sender_id, $status)
    {
        Friend::where('sender_id', $sender_id)
            ->where('receiver_id', Auth::user()->id)
            ->update(['status' => $status]);
    }

    // Helper method to delete a friend request
    private function deleteFriendRequest($sender_id)
    {
        Friend::where('sender_id', $sender_id)
            ->where('receiver_id', Auth::user()->id)
            ->delete();
    }
}
