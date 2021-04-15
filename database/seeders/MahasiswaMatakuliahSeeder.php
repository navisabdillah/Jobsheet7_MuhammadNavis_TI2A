<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MahasiswaMatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $mahasiswaMatkul = [
            [
                'mahasiswa_id' => '1941720021',
                'matakuliah_id' => '1',
                'nilai' => 'A'
            ],
            [
                'mahasiswa_id' => '1941720021',
                'matakuliah_id' => '2',
                'nilai' => 'A'
            ],
            [
                'mahasiswa_id' => '1941720021',
                'matakuliah_id' => '3',
                'nilai' => 'A'
            ],
            [
                'mahasiswa_id' => '1941720021',
                'matakuliah_id' => '4',
                'nilai' => 'A'
            ]

        ];
        DB::table('mahasiswa_matakuliah')->insert($mahasiswaMatkul);
    }
}
