<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $admins = User::all();
        return view('admin.user.index', compact('admins'));
    }

    public function profil()
    {
        return view('admin.user.profil');
    }

    public function create(Request $request)
    {
    }
}
