<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $loggedInUserId = Auth::id();
            $users = User::whereNotIn('id', [$loggedInUserId])->get();

            $messages_count = Message::where('recipient_id',Auth::id())->count();

            return view('home',compact('users','messages_count'));
        } catch (\Exception $e) {
            \Log::error('Error in index method: ' . $e->getMessage());
            return redirect()->route('error.page')->with('error', 'An unexpected error occurred.');
        }
    }
}
