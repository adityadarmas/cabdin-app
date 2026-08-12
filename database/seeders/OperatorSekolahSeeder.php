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

            $operator = User::firstOrNew(['email' => trim($row[5])]);
            $operator->fill([
                'name'           => trim($row[4]),
                'nama_sekolah'   => trim($row[0]),
                'npsn'           => trim($row[1]) ?: null,
                'status_sekolah' => str_contains(strtolower(trim($row[0])), 'negeri') ? 'negeri' : 'swasta',
                'bentuk_pendidikan' => strtolower(trim($row[2])) === 'smk' ? 'smk' : 'sma',
                'no_wa'          => trim($row[3]),
                'role'           => 'operator',
            ]);

            // Password dari CSV hanya dipakai saat akun baru dibuat.
            // Akun yang sudah ada tetap dapat memakai password lamanya.
            if (! $operator->exists) {
                $operator->password = Hash::make(trim($row[6]));
            }

            $operator->save();
        }

        fclose($handle);
    }
}
