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
}