<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OperatorSekolahSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = database_path('seeders/data/operator_sekolah.csv');
        $handle = fopen($csvPath, 'r');

        // Skip header
        fgetcsv($handle, 0, ';');

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            if (empty(trim($row[0] ?? ''))) continue;

            User::updateOrCreate(
                ['email' => trim($row[5])],
                [
                    'name'         => trim($row[4]),
                    'nama_sekolah' => trim($row[0]),
                    'no_wa'        => trim($row[3]),
                    'password'     => Hash::make(trim($row[6])),
                    'role'         => 'operator',
                ]
            );
        }

        fclose($handle);
    }
}
