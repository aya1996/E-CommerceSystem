<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Product::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Color::factory(10)->create();
        \App\Models\Size::factory(10)->create();
        \App\Models\Image::factory(10)->create();
        \App\Models\Tax::factory(5)->create();
        \App\Models\Transaction::factory(5)->create();
        \App\Models\Delivery::factory(5)->create();
        \App\Models\Order::factory(100)->create();



        $permissions = [
            'view-admin',
            'view-product',
            'view-category',
            'view-color',
            'view-size',
            'view-image',
            'view-tax',
            'view-transaction',
            'view-order',
            'view-user',
            'create-admin',
            'create-product',
            'create-category',
            'create-color',
            'create-size',
            'create-image',
            'create-tax',
            'create-transaction',
            'create-order',
            'create-user',
            'edit-admin',
            'edit-product',
            'edit-category',
            'edit-color',
            'edit-size',
            'edit-image',
            'edit-tax',
            'edit-transaction',
            'edit-order',
            'edit-user',
            'delete-admin',
            'delete-product',
            'delete-category',
            'delete-color',
            'delete-size',
            'delete-image',
            'delete-tax',
            'delete-transaction',
            'delete-order',
            'delete-user',
            'view-delivery',
            'create-delivery',
            'edit-delivery',
            'delete-delivery',





        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $role = Role::create(['name' => 'admin']);
        $role->syncPermissions($permissions);

        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $admin->assignRole($role->id);


        $permissions = [
            'view-invoice',
            'create-invoice',
            'update-invoice',
            'delete-invoice',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $role = Role::create(['name' => 'invoice']);

        $accountant = Admin::create([
            'name' => 'Accountant',
            'email' => 'accountant@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $accountant->assignRole($role->id);




        // \App\Models\ProductCategory::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
