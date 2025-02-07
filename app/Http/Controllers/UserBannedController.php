<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class UserBannedController extends Controller
{
    public function ban($id)
    {
        // Gate:: ;
      if(Gate::denies('ban-user', Auth::user())){
            return redirect()->back()->with('erro', 'vous n\'etes pas un moderateur');
      }
        $user = $this->FindUserOrFail($id);
        $user->banned_at = now();
        $user->save();
        return redirect()->back()->with('success', 'compte banni');
    }

    public function unban($id)
    {
        if(Gate::denies('unban-user', Auth::user())){
            return redirect()->back()->with('erro', 'vous n\'etes pas un moderateur');
      }
        $user = $this->FindUserOrFail($id);
        $user->banned_at = null;
        $user->save();
        return redirect()->back()->with('success', 'compte débanni');
    }

    private function FindUserOrFail($id)
    {
        return User::findOrfail($id);
    }
}
