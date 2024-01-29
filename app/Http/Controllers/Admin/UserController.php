<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
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
        $entreprises = Entreprise::all();
        return view('admin.user.index', compact('admins', 'roles', 'entreprises'));
    }

    public function roles()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.user.role', compact('roles', 'permissions'));
    }

    public function createRole(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        if ($role) {
            return back()->with('success', 'Rôle créé avec succès.');
        } else {
            return back()->with('error', 'un problème est survenu.');
        }
    }

    public function updateRole(Request $request, Role $role)
    {

        if (isset($_POST['delete'])) {
            if ($role->delete()) {
                return back()->with('success', "Le rôle a été supprimé.");
            } else {
                return back()->with('error', "Le rôle n'a pas été supprimé.");
            }
        } else {

            $permissions = Permission::all();
            $del = true;
            //dd($request->permissions);
            foreach ($permissions as $permision) {
                foreach ($request->permissions as $per) {
                    if ($permision->name == $per) {
                        if (!$role->hasPermissionTo($per)) {
                            $role->givePermissionTo($per);
                            $del = false;
                        } else {
                            $del = false;
                        }
                    } else {
                        $del == true;
                    }
                }
                if ($del == true) {
                    $role->revokePermissionTo($permision->name);
                }
            }

            return back()->with('success', 'Rôle mis à jour.');
        }
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
        $user = new User();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->entreprise_id =  $request->entreprise_id;
        $user->poste = $request->poste;
        $user->password = bcrypt('12345678');

        if ($user->save()) {
            $user->sendPasswordResetNotification(app('auth.password.broker')->createToken($user));
            return back()->with('success', 'Utilisateur créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function select(Request $request)
    {
        $responsables = User::where('entreprise_id', $request->id)->get();
        $response = json_encode($responsables);

        return response()->json($response);
    }
}
