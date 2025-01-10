<?php

use App\Http\Controllers\AuthenthicationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NavigationController::class, 'homePage'])->name('home.page');
Route::get('/friends', [NavigationController::class, 'friendPage'])->name('friends.page');
Route::get('/profile/{user_id}/info', [NavigationController::class, 'detailPage'])->name('profile.detail');

Route::middleware(['guest'])->group(function () {
    Route::get('/auth/login', [NavigationController::class, 'loginPage'])->name('auth.loginPage');
    Route::post('/auth/login', [AuthenticationController::class, 'login'])->name('auth.login');
    
    Route::get('/auth/register', [NavigationController::class, 'registerPage'])->name('auth.registerPage');
    Route::post('/auth/register', [AuthenticationController::class, 'register'])->name('auth.register');
    
    Route::post('/payment/submit', [AuthenticationController::class, 'payment'])->name('payment.submit');
    Route::post('/payment/overpaid', [AuthenticationController::class, 'overpaidPayment'])->name('payment.overpaid');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/friends/add/{receiver_id}', [FriendController::class, 'addFriend'])->name('friends.add');
    
    Route::get('/wallet/top-up', [NavigationController::class, 'topupPage'])->name('wallet.topupPage');
    Route::post('/wallet/top-up', [CoinController::class, 'topup'])->name('wallet.topup');
    
    Route::post('/auth/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');
    
    Route::get('/user/profile', [NavigationController::class, 'myProfilePage'])->name('user.profile');
    
    Route::post('/user/visibility/toggle', [UserController::class, 'changeVisibility'])->name('user.visibility.toggle');
    
    Route::get('/market/avatar', [NavigationController::class, 'avatarMarketPage'])->name('market.avatar');
    Route::post('/market/avatar/purchase/{avatar_id}', [AvatarController::class, 'purchaseAvatar'])->name('market.avatar.purchase');
    Route::post('/user/avatar/change', [UserController::class, 'changeAvatar'])->name('user.avatar.change');
    
    Route::get('/friends/requests', [NavigationController::class, 'friendRequestPage'])->name('friends.requests');
    Route::post('/friends/requests/accept/{sender_id}', [FriendController::class, 'acceptFriend'])->name('friends.requests.accept');
    Route::post('/friends/requests/reject/{sender_id}', [FriendController::class, 'rejectFriend'])->name('friends.requests.reject');

    Route::get('/messages/chat/{current_chat_id?}', [NavigationController::class, 'chatPage'])->name('messages.chat');
    Route::post('/messages/send/{receiver_id}', [MessageController::class, 'sendMessage'])->name('messages.send');

    Route::get('/user/notifications', [NavigationController::class, 'notificationPage'])->name('user.notifications');
});

Route::get('/locale/switch/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');
