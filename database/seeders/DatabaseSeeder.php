<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'add policy']);
        Permission::create(['name' => 'delete policy']);
        Permission::create(['name' => 'edit policy']);
        Permission::create(['name' => 'view policy']);

        Permission::create(['name' => 'add cashflow']);
        Permission::create(['name' => 'delete cashflow']);
        Permission::create(['name' => 'edit cashflow']);
        Permission::create(['name' => 'view cashflow']);

        Permission::create(['name' => 'add entreprise']);
        Permission::create(['name' => 'delete entreprise']);
        Permission::create(['name' => 'edit entreprise']);
        Permission::create(['name' => 'view entreprise']);

        Permission::create(['name' => 'add cashbox']);
        Permission::create(['name' => 'delete cashbox']);
        Permission::create(['name' => 'edit cashbox']);
        Permission::create(['name' => 'view cashbox']);

        Permission::create(['name' => 'add setting']);
        Permission::create(['name' => 'delete setting']);
        Permission::create(['name' => 'edit setting']);
        Permission::create(['name' => 'view setting']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Agent']);

        $role1->givePermissionTo('add policy');
        $role1->givePermissionTo('view policy');
        $role1->givePermissionTo('add cashflow');
        $role1->givePermissionTo('view cashflow');

        $role2 = Role::create(['name' => 'Gerant']);

        $role2->givePermissionTo('add policy');
        $role2->givePermissionTo('view policy');
        $role2->givePermissionTo('delete policy');
        $role2->givePermissionTo('edit policy');
        $role2->givePermissionTo('add cashflow');
        $role2->givePermissionTo('view cashflow');
        $role2->givePermissionTo('delete cashflow');
        $role2->givePermissionTo('edit cashflow');
        $role2->givePermissionTo('add entreprise');
        $role2->givePermissionTo('view entreprise');
        $role2->givePermissionTo('delete entreprise');
        $role2->givePermissionTo('edit entreprise');
        $role2->givePermissionTo('add cashbox');
        $role2->givePermissionTo('view cashbox');
        $role2->givePermissionTo('delete cashbox');
        $role2->givePermissionTo('edit cashbox');
        $role2->givePermissionTo('add setting');
        $role2->givePermissionTo('view setting');
        $role2->givePermissionTo('delete setting');
        $role2->givePermissionTo('edit setting');

        $role3 = Role::create(['name' => 'SuperAdmin']);

        $superadmin = User::create([
            'lastname' => 'Superadmin',
            'email' => 'contact@exa.ga',
            'phone' => '074010203',
            'entreprise_id' => 0,
            'poste' => 'Gérant',
            'password' => bcrypt('12345678'),
        ]);

        $superadmin->assignRole($role3);

        $gerant = User::create([
            'lastname' => 'Gérant',
            'email' => 'gerant@exa.ga',
            'phone' => '074010204',
            'entreprise_id' => 0,
            'poste' => 'Gérant',
            'password' => bcrypt('12345678'),
        ]);

        $gerant->assignRole($role2);

        $agent = User::create([
            'lastname' => 'Agent',
            'email' => 'agent@exa.ga',
            'phone' => '074010205',
            'entreprise_id' => 0,
            'poste' => 'Agent',
            'password' => bcrypt('12345678'),
        ]);

        $agent->assignRole($role1);
    }
}
