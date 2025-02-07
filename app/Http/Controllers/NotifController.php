<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifController extends Controller
{
    public function index()
    {

        $notifications = Auth::user()->notifications()->get();
         
        return view('post.index', compact('notifications'));
    }
    public function markAsRead($id)
    {
        $notifications = Auth::user()->notifications()->find($id);
        if ($notifications) {
            $notifications->delete();
        }
        return redirect()->back();
    }
}
