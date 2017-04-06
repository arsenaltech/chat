<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;
use App\User;
use App\Message;
Route::get('/', function () {
    $data = [
        'event' => 'UserSignedUp',
        'data' => [
            'username' => 'JohnDoe'
        ]
    ];
    Redis::publish('test-channel', json_encode($data));
    return view('welcome');
});
Route::post('/chat', function() {
    $from = Auth::user();
    $to = User::find(Request::get('to'));
    //$to = \App\User::find(2);
    $message_txt = Request::get('message');
    $message = new Message();
    $message->from()->associate($from);
    $message->to()->associate($to);
    $message->message = $message_txt;
    $message->save();
    event(new NewMessage($message));
});

Route::get('/users', function() {
    return User::all();
});

Auth::routes();

Route::get('/home', 'HomeController@index');
