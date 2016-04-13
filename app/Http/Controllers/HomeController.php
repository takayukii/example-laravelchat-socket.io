<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

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
            $users = \App\User::select(['id', 'name'])->get()->toArray();
            $authUser = \Auth::user();
            $users = array_filter($users, function ($user) use ($authUser) {
                if ($user['id'] !== $authUser->id) {
                    return true;
                }
            });

            if (count($users) > 0) {
                $firstUser = current($users);
                $messages = \App\Message::with('fromUser')->with('toUser')
                    ->related($authUser->id, $firstUser['id'])
                    ->orderBy('created_at', 'desc')
                    ->get()->toArray();
            }
        }

        return view('home', compact('users', 'messages'));
    }
}