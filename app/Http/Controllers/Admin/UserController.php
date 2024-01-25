<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //
    public function index()
    {
        $admins = User::all();
        $roles = Role::all();
        return view('admin.user.index', compact('admins', 'roles'));
    }

    public function roles()
    {
        $roles = Role::all();
        return view('admin.user.role', compact('roles'));
    }

    public function permissions()
    {
        $permissions = Permission::all();
        return view('admin.user.permission', compact('permissions'));
    }

    public function profil()
    {
        return view('admin.user.profil');
    }

    public function create(Request $request)
    {
    }
}
