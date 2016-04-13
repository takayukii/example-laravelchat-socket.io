<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = [];
        $messages = [];

        if (\Auth::check()) {
            $authUser = \Auth::user();
            $users = \App\User::select(['id', 'name'])->whereNotIn('id', [$authUser->id])->get();

            if (count($users) > 0) {
                $firstUser = $users->first();
                $messages = \App\Message::with('fromUser')->with('toUser')
                    ->related($authUser->id, $firstUser->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return view('home', compact('users', 'messages'));
    }

    public function getMessages($userId)
    {
        $userId = intval($userId);
        $messages = \App\Message::with('fromUser')->with('toUser')
            ->related(\Auth::user()->id, $userId)->orderBy('created_at', 'desc')->get();
        return $messages->toJson();
    }

    public function createMessage($userId)
    {
        $data = \Request::all();
        $data['from_user_id'] = \Auth::user()->id;
        $data['to_user_id'] = $userId;
        Message::create($data);
    }
}