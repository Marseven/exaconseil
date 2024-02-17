<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Entreprise;
use App\Models\Service;
use App\Models\Setting;
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

        Setting::create([
            'label' => 'Délais de notification',
            'key' => 'date_notification',
            'type' => 'number',
        ]);

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

        Permission::create(['name' => 'add devis']);
        Permission::create(['name' => 'delete devis']);
        Permission::create(['name' => 'edit devis']);
        Permission::create(['name' => 'view devis']);

        Permission::create(['name' => 'add sinistre']);
        Permission::create(['name' => 'delete sinistre']);
        Permission::create(['name' => 'edit sinistre']);
        Permission::create(['name' => 'view sinistre']);


        Permission::create(['name' => 'add facture']);
        Permission::create(['name' => 'delete facture']);
        Permission::create(['name' => 'edit facture']);
        Permission::create(['name' => 'view facture']);

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
        $role1->givePermissionTo('add sinistre');
        $role1->givePermissionTo('view sinistre');
        $role1->givePermissionTo('add devis');
        $role1->givePermissionTo('view devis');
        $role1->givePermissionTo('add facture');
        $role1->givePermissionTo('view facture');

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
        $role2->givePermissionTo('add sinistre');
        $role2->givePermissionTo('view sinistre');
        $role2->givePermissionTo('delete sinistre');
        $role2->givePermissionTo('edit sinistre');
        $role2->givePermissionTo('add devis');
        $role2->givePermissionTo('view devis');
        $role2->givePermissionTo('delete devis');
        $role2->givePermissionTo('edit devis');
        $role2->givePermissionTo('add facture');
        $role2->givePermissionTo('view facture');
        $role2->givePermissionTo('delete facture');
        $role2->givePermissionTo('edit facture');

        $role3 = Role::create(['name' => 'SuperAdmin']);

        $role3->givePermissionTo('add policy');
        $role3->givePermissionTo('view policy');
        $role3->givePermissionTo('delete policy');
        $role3->givePermissionTo('edit policy');
        $role3->givePermissionTo('add cashflow');
        $role3->givePermissionTo('view cashflow');
        $role3->givePermissionTo('delete cashflow');
        $role3->givePermissionTo('edit cashflow');
        $role3->givePermissionTo('add entreprise');
        $role3->givePermissionTo('view entreprise');
        $role3->givePermissionTo('delete entreprise');
        $role3->givePermissionTo('edit entreprise');
        $role3->givePermissionTo('add cashbox');
        $role3->givePermissionTo('view cashbox');
        $role3->givePermissionTo('delete cashbox');
        $role3->givePermissionTo('edit cashbox');
        $role3->givePermissionTo('add setting');
        $role3->givePermissionTo('view setting');
        $role3->givePermissionTo('delete setting');
        $role3->givePermissionTo('edit setting');
        $role3->givePermissionTo('add sinistre');
        $role3->givePermissionTo('view sinistre');
        $role3->givePermissionTo('delete sinistre');
        $role3->givePermissionTo('edit sinistre');
        $role3->givePermissionTo('add devis');
        $role3->givePermissionTo('view devis');
        $role3->givePermissionTo('delete devis');
        $role3->givePermissionTo('edit devis');
        $role3->givePermissionTo('add facture');
        $role3->givePermissionTo('view facture');
        $role3->givePermissionTo('delete facture');
        $role3->givePermissionTo('edit facture');

        Entreprise::create([
            'company_name' => 'Expertise Akom Conseil',
            'business_sector' => 'Expertise Conseil',
            'phone' => '074010203',
            'email' => 'conatct@eac.ga',
            'address' => 'Nzeng-Ayong',
        ]);

        Entreprise::create([
            'company_name' => 'EIA',
            'business_sector' => 'Conseil',
            'phone' => '074010204',
            'email' => 'conatct@eia.ga',
            'address' => 'Nzeng-Ayong',
        ]);

        Service::create([
            'name' => 'Police d\'assurance',
            'description' => 'Police d\'assurance',
        ]);
        Service::create([
            'name' => 'Sinistre',
            'description' => 'Sinistre',
        ]);
        Service::create([
            'name' => 'Devis',
            'description' => 'Devis',
        ]);
        Service::create([
            'name' => 'Caisse',
            'description' => 'Caisse',
        ]);
        Service::create([
            'name' => 'Facture',
            'description' => 'Facture',
        ]);

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
            'entreprise_id' => 1,
            'poste' => 'Gérant',
            'password' => bcrypt('12345678'),
        ]);

        $gerant->assignRole($role2);

        $agent = User::create([
            'lastname' => 'Agent',
            'email' => 'agent@exa.ga',
            'phone' => '074010205',
            'entreprise_id' => 1,
            'poste' => 'Agent',
            'password' => bcrypt('12345678'),
        ]);

        $agent->assignRole($role1);
    }
}
