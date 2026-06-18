<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// Model
use App\Models\User;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([

            'name'        => 'Main Owner',
            'email'       => 'kartikssprime@gmail.com',
            'password'    =>  Hash::make('12345678'),
            'designation' => 'Owner',
            'phone'       => '8287705874',

        ]);
    }
}
