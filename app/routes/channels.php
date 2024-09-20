<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});


Broadcast::channel('store_message.{chat_id}', function ($user, $chatId) {
    return $user->chats()->where('id', $chatId)->count();
});


//Broadcast::channel('online_status.{user_id}', function ($user, $chatId) {
////    return (int) $user->id === (int) $id;
//
////    return 0;
//    return $user->chats()->where('id', $chatId)->count();
//});
