<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['name' => 'create', 'slug' => 'create'],
            ['name' => 'read', 'slug' => 'read'],
            ['name' => 'update', 'slug' => 'update'],
            ['name' => 'delete', 'slug' => 'delete'],
        ]);
    }
}
