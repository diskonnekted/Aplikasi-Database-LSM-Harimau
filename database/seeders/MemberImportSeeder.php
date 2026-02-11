<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Regions
        $dki = Region::where('name', 'DKI Jakarta')->first();
        if (!$dki) {
            $national = Region::where('level', 'national')->first();
            $dki = Region::create([
                'name' => 'DKI Jakarta',
                'level' => 'province',
                'parent_id' => $national ? $national->id : null,
            ]);
        }
        
        $jabar = Region::where('name', 'Jawa Barat')->first();

        // Sample Data from extracted PDF
        $members = [
            [
                'name' => 'Neville GJ MUSKITA',
                'role_name' => 'Ketua DPW DKI',
                'nik' => '3175072812720002',
                'birth_place' => 'Jakarta',
                'birth_date' => '1972-12-28',
                'address' => 'Jl. Nusa Indah 4 Gang 9 no 51 RT 08 RW 04 Kel Malaka jaya kec duren sawit Jakarta Timur',
                'religion' => 'Islam',
                'phone' => '085286641046',
                'join_date' => '2024-05-01', // Mei 2024
                'region_id' => $dki->id,
                'photo' => 'members/page_001_img_001_Image1.png', // Assuming first image
            ],
            [
                'name' => 'Alderia Nova',
                'role_name' => 'Sekretaris DPW',
                'nik' => '3175070207730009',
                'birth_place' => 'Jakarta',
                'birth_date' => '1973-07-02',
                'address' => 'Jl. Bunga Rampai VI/1 No. 227, RT. 002 Rw. 08, Kel. Malaka jaya, Kec. Duren Sawit - Jakarta Timur',
                'religion' => 'Islam',
                'phone' => '087818004020',
                'join_date' => '2024-05-01', // Mei 2024
                'region_id' => $dki->id,
                'photo' => 'members/page_001_img_002_Image10.png', // Assuming next image
            ],
            [
                'name' => 'Alfons Yuniarto',
                'role_name' => 'Kepala Divisi Pengamanan',
                'nik' => '3174012106710009',
                'birth_place' => 'Jakarta',
                'birth_date' => '1971-06-21',
                'address' => 'Jl. R No. 32, Rt. 008 / Rw. 004, Kebon Baru, Kecamatan Tebet, Jakarta Timur',
                'religion' => 'Islam',
                'phone' => '081381510852',
                'join_date' => '2024-05-01', // Mei 2024
                'region_id' => $dki->id,
                'photo' => 'members/page_002_img_001_Image1.jpg',
            ],
            [
                'name' => 'Raymond Parastya Palit, SH',
                'role_name' => 'KETUA LBH DK JAKARTA',
                'nik' => '3201070303720018',
                'birth_place' => 'Jakarta',
                'birth_date' => '1972-03-03',
                'address' => 'Perum Metland Cileungsi CL.2/1, Rt. 003/007, Kel. Cipenjo Kecamtan Cileungsi - Kabupaten Bogor',
                'religion' => 'Kristen',
                'phone' => '000000000000', // Placeholder as it was blank/messy in snippet
                'join_date' => '2024-12-01', // Des-24
                'region_id' => $dki->id, // LBH DK JAKARTA implies DKI scope
                'photo' => 'members/page_002_img_002_Image10.jpg',
            ],
        ];

        foreach ($members as $data) {
            // Create User
            // Use NIK as email/username equivalent or generated email
            $email = Str::slug($data['name']) . '@lsmharimau.org';
            
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'), // Default password
                ]
            );

            // Assign Role (Simple approach: Assign 'member' role to all for now, 
            // maybe 'province-admin' for Ketua DPW)
            if (Str::contains(strtolower($data['role_name']), 'ketua dpw')) {
                $user->assignRole('province-admin');
            } else {
                $user->assignRole('member');
            }

            // Create Member Profile
            Member::updateOrCreate(
                ['nik' => $data['nik']],
                [
                    'user_id' => $user->id,
                    'full_name' => $data['name'],
                    'position' => $data['role_name'],
                    'birth_place' => $data['birth_place'],
                    'birth_date' => $data['birth_date'],
                    'address' => $data['address'],
                    'religion' => $data['religion'],
                    'phone_number' => $data['phone'],
                    'region_id' => $data['region_id'],
                    'image_path' => $data['photo'],
                    'join_date' => $data['join_date'],
                    'status' => 'approved',
                ]
            );
        }
    }
}
