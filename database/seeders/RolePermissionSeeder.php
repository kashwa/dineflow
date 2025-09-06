<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permissions (expand as you add modules)
        $perms = [
            'menu.create','menu.read','menu.update','menu.delete',
            'order.create','order.read','order.update','order.delete',
            'inventory.create','inventory.read','inventory.update','inventory.delete',
        ];
        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // Roles
        $owner   = Role::firstOrCreate(['name' => 'owner']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $staff   = Role::firstOrCreate(['name' => 'staff']);

        $owner->givePermissionTo(Permission::all());
        $manager->givePermissionTo([
            'menu.read','menu.update',
            'order.create','order.read','order.update',
            'inventory.read','inventory.update',
        ]);
        $staff->givePermissionTo(['menu.read','order.create','order.read']);

        // Example: attach first user as owner for demo tenant
        $tenant = \App\Models\Tenant::where('slug','demo')->first();
        if ($tenant) {
            $user = \App\Models\User::firstOrCreate(
                ['email' => 'owner@demo.io'],
                ['tenant_id'=>$tenant->id,'name'=>'Demo Owner','password'=>Hash::make('123123')]
            );
            $user->assignRole('owner');
        }
    }
}
