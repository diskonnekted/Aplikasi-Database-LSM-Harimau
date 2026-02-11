<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\News;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PublicController extends Controller
{
    public function home()
    {
        $latestNews = News::where('is_published', true)->latest()->take(3)->get();
        return view('public.home', compact('latestNews'));
    }

    public function profile()
    {
        return view('public.profile');
    }

    public function rules()
    {
        return view('public.rules');
    }

    public function registration()
    {
        return view('public.registration');
    }

    public function storeRegistration(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => 'required|string|unique:members',
            'phone_number' => 'required|string',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'religion' => 'required|string',
            'province_id' => 'required|exists:indonesia_provinces,id',
            'city_id' => 'required|exists:indonesia_cities,id',
            'district_id' => 'required|exists:indonesia_districts,id',
            'village_id' => 'required|exists:indonesia_villages,id',
            'image' => 'nullable|image|max:2048',
        ]);

        // Create User
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'region_id' => null,
        ]);

        $user->assignRole('member');

        // Handle Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('member-images', 'public');
        }

        // Create Member Profile
        Member::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'full_name' => $request->full_name,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'religion' => $request->religion,
            'phone_number' => $request->phone_number,
            'image_path' => $imagePath,
            'region_id' => null,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'status' => 'pending',
            'join_date' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login dan tunggu persetujuan admin.');
    }
}
