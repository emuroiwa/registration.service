<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = storage_path("fixtures//users.csv");
        foreach (array_slice(glob($filePath), 0, 2) as $file) {
            $data = array_map('str_getcsv', file($file));

            foreach ($data as $row) {
                $user = User::create([
                        'name' => $row[1],
                        'email' => $row[2],
                        'password' => Hash::make($row[3]),
                    ]);
            }
        }
    }
}
