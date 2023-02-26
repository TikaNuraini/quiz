<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated teachers can listen to the channel.
|
*/

Broadcast::channel('App.Models.teachers.{id}', function ($teachers, $id) {
    return (int) $teachers->id === (int) $id;
});
