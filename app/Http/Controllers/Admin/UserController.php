<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $user->load(['entreprise']);
        $role = $user->roles->first();

        if ($user->entreprise_id == 0) {
            $admins = User::all();
            $roles = Role::all();
            $entreprises = Entreprise::all();
        } else {
            $admins = User::where('entreprise_id', $user->entreprise_id)->get();
            $roles = Role::whereIn('name', ['Gerant', 'Agent'])->get();
            $entreprises = Entreprise::where('id', $user->entreprise_id)->get();
        }

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

    public function updateProfil(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($user->save()) {
            return back()->with('success', 'Votre profil a été mis à jour avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function resetPassword(Request $request)
    {

        $user = User::find(Auth::user()->id);

        if ($request->password_confirmation == $request->password) {
            $user->forceFill([
                'password' => Hash::make($request->password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));

            return back()->with('success', 'Votre mot de passe a été mis à jour avec succès.');
        } else {
            return back()->withErrors("Une erreur s'est produite.");
        }
    }

    public function create(Request $request)
    {
        $user = new User();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->entreprise_id =  $request->entreprise_id;
        $user->responsable =  $request->responsable_id;
        $user->poste = $request->poste;
        $user->password = bcrypt('12345678');

        if ($user->save()) {
            $role = Role::find($request->role_id);
            $user->assignRole($role);
            $user->sendPasswordResetNotification(app('auth.password.broker')->createToken($user));
            return back()->with('success', 'Utilisateur créé avec succès.');
        } else {
            return back()->with('error', 'Un problème est survenu.');
        }
    }

    public function update(Request $request, User $user)
    {
        if (isset($_POST['delete'])) {
            if ($user->delete()) {
                return back()->with('success', "L'utilisateur a été supprimé.");
            } else {
                return back()->with('error', "L'utilisateur n'a pas été supprimé.");
            }
        } else {

            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->poste = $request->poste;
            $user->responsable =  $request->responsable_id;

            if ($user->save()) {
                return back()->with('success', 'Utilisateur mis à jour avec succès.');
            } else {
                return back()->with('error', 'Un problème est survenu.');
            }
        }
    }

    public function select(Request $request)
    {
        $responsables = User::where('entreprise_id', $request->id)->get();
        foreach ($responsables as $responsable) {
            $responsable->firstname = $responsable->firstname == null ? "" : $responsable->firstname;
        }
        $response = json_encode($responsables);
        return response()->json($response);
    }
}
