<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(['key' => 'site_logo'], [
            'value' => 'images/logo.png',
            'type' => 'image',
            'label' => 'Logo Situs'
        ]);

        Setting::updateOrCreate(['key' => 'hero_image'], [
            'value' => 'images/hero.jpg',
            'type' => 'image',
            'label' => 'Gambar Hero Beranda'
        ]);

        Setting::updateOrCreate(['key' => 'site_name'], [
            'value' => 'LSM Harimau',
            'type' => 'text',
            'label' => 'Nama Situs'
        ]);
        
        Setting::updateOrCreate(['key' => 'hero_title'], [
            'value' => 'Selamat Datang di LSM Harimau',
            'type' => 'text',
            'label' => 'Judul Hero'
        ]);

        Setting::updateOrCreate(['key' => 'hero_subtitle'], [
            'value' => 'Membangun Masyarakat yang Lebih Baik Bersama Kami',
            'type' => 'text',
            'label' => 'Subjudul Hero'
        ]);
    }
}
