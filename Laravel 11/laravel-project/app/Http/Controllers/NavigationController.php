<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\AvatarTransaction;
use App\Models\Chat;
use App\Models\Friend;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavigationController extends Controller
{
    public function homePage()
    {
        $userQuery = User::where('visibility', true)->take(6);

        if (Auth::check()) {
            $userQuery->where('id', '!=', Auth::user()->id);
        }

        $user = $userQuery->get();

        return view('pages.index', ['users' => $user]);
    }

    public function friendPage(Request $request)
    {
        $query = User::where('visibility', true);
        
        if (!Auth::check()) {
            $this->applyFilters($query, $request);
            return view('pages.friend', [
                'users' => $query->get(),
                'gender_filter' => $request->gender,
                'fields_of_work_filter' => $request->fields_of_work
            ]);
        }

        $excludedUserIds = $this->getExcludedUserIds();
        $this->applyFilters($query, $request);

        return view('pages.friend', [
            'users' => $query->whereNotIn('id', $excludedUserIds)->get(),
            'gender_filter' => $request->gender,
            'fields_of_work_filter' => $request->fields_of_work
        ]);
    }

    public function detailPage($user_id)
    {
        return view('pages.detail', ['user' => User::findOrFail($user_id)]);
    }

    public function registerPage()
    {
        if (session()->has('payment_expires') && now()->greaterThan(session('payment_expires'))) {
            session()->flush();
        }

        return view('authenthication.register');
    }

    public function loginPage()
    {
        return view('authenthication.login');
    }

    public function topupPage()
    {
        return view('pages.top-up');
    }

    public function myProfilePage()
    {
        $avatars = Avatar::whereIn('id', AvatarTransaction::where('buyer_id', Auth::user()->id)->pluck('avatar_id'))->get();
        return view('pages.profile', compact('avatars'));
    }

    public function avatarMarketPage()
    {
        $ownedAvatarIds = AvatarTransaction::where('buyer_id', Auth::user()->id)->pluck('avatar_id');
        $avatars = Avatar::whereNotIn('id', $ownedAvatarIds)->paginate(9);

        return view('pages.avatar-market', compact('avatars'));
    }

    public function friendRequestPage()
    {
        $authUserId = Auth::user()->id;

        $pendingRequestIds = Friend::where('receiver_id', $authUserId)
            ->where('status', 'Pending')
            ->pluck('sender_id');
        
        Friend::whereIn('sender_id', $pendingRequestIds)
            ->where('receiver_id', $authUserId)
            ->update(['seen' => true]);

        $pendingRequests = User::whereIn('id', $pendingRequestIds)->get();

        $acceptedFriendIds = $this->getAcceptedFriendIds($authUserId);
        $acceptedFriends = User::whereIn('id', $acceptedFriendIds)->get();

        return view('pages.friend-request', compact('pendingRequests', 'acceptedFriends'));
    }

    public function chatPage($current_chat_id = null)
    {
        $chats = $this->getChatsForUser();
        $userIds = $this->getChatUserIds($chats);

        $users = User::whereIn('id', $userIds)->get();

        if ($current_chat_id) {
            $this->markChatsAsSeen($current_chat_id, $chats);
            $chats = $this->getChatMessages($current_chat_id);
            if ($chats->isEmpty()) {
                $users->push(User::findOrFail($current_chat_id));
            }
        } else {
            $chats = null;
        }

        return view('pages.message', compact('chats', 'users', 'current_chat_id'));
    }

    public function notificationPage()
    {
        $authUserId = Auth::user()->id;

        $chatNotification = Message::where('receiver_id', $authUserId)
            ->where('seen', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingFriendIds = Friend::where('receiver_id', $authUserId)
            ->where('status', 'Pending')
            ->where('seen', false)
            ->pluck('sender_id');

        $friendRequestNotification = User::whereIn('id', $pendingFriendIds)->get();

        return view('pages.notification', compact('chatNotification', 'friendRequestNotification'));
    }

    // Helper functions
    private function applyFilters($query, $request)
    {
        $query->when($request->gender, function ($q) use ($request) {
            return $q->where('gender', $request->gender);
        })
        ->when($request->fields_of_work, function ($q) use ($request) {
            return $q->where('fields_of_work', 'LIKE', '%'.$request->fields_of_work.'%');
        })
        ->when($request->name, function ($q) use ($request) {
            return $q->where('name', 'LIKE', '%'.$request->name.'%');
        });
    }

    private function getExcludedUserIds()
    {
        $authUserId = Auth::user()->id;
        return Friend::where('sender_id', $authUserId)
            ->orWhere('receiver_id', $authUserId)
            ->pluck('sender_id', 'receiver_id')
            ->flatten()
            ->push($authUserId)
            ->unique()
            ->toArray();
    }

    private function getAcceptedFriendIds($authUserId)
    {
        return Friend::where(function ($query) use ($authUserId) {
                $query->where('sender_id', $authUserId)
                    ->orWhere('receiver_id', $authUserId);
            })
            ->where('status', 'Accepted')
            ->get(['sender_id', 'receiver_id'])
            ->flatMap(function ($friend) {
                return [$friend->sender_id, $friend->receiver_id];
            })
            ->unique()
            ->reject(fn($id) => $id == $authUserId)
            ->toArray();
    }

    private function getChatsForUser()
    {
        return Message::where('sender_id', Auth::user()->id)
            ->orWhere('receiver_id', Auth::user()->id)
            ->get();
    }

    private function getChatUserIds($chats)
    {
        return $chats->pluck('sender_id')
            ->merge($chats->pluck('receiver_id'))
            ->unique()
            ->reject(fn($id) => $id == Auth::user()->id);
    }

    private function markChatsAsSeen($current_chat_id, $chats)
    {
        if ($chats->isEmpty() || $chats[0]->receiver_id != Auth::user()->id) return;
        foreach ($chats as $chat) {
            $chat->seen = true;
            $chat->save();
        }
    }

    private function getChatMessages($current_chat_id)
    {
        return Message::whereIn('sender_id', [$current_chat_id, Auth::user()->id])
            ->whereIn('receiver_id', [$current_chat_id, Auth::user()->id])
            ->get();
    }
}
