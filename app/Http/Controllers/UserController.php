<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function UserDashboard()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('index', compact('user'));
    }


    public function UserLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function edit()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('dashboard', compact('user'));
    }

    public function update(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('dashboard');
    }

    public function destroy()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->delete();
        return redirect()->route('dashboard');
    }

}
