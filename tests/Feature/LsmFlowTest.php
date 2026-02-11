<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\News;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LsmFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles and basic regions
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $this->seed(\Database\Seeders\RegionSeeder::class);
    }

    public function test_new_member_can_register()
    {
        Storage::fake('public');
        $region = Region::where('level', 'regency')->first();

        $response = $this->post(route('registration.store'), [
            'full_name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nik' => '1234567890123456',
            'phone_number' => '08123456789',
            'address' => 'Jl. Merdeka No. 1',
            'birth_place' => 'Jakarta',
            'birth_date' => '1990-01-01',
            'religion' => 'Islam',
            'region_id' => $region->id,
            'image' => UploadedFile::fake()->image('photo.jpg'),
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', ['email' => 'budi@example.com']);
        $this->assertDatabaseHas('members', ['nik' => '1234567890123456', 'status' => 'pending']);
    }

    public function test_super_admin_can_approve_member()
    {
        // Create pending member
        $region = Region::first();
        $user = User::factory()->create();
        $user->assignRole('member');
        $member = Member::create([
            'user_id' => $user->id,
            'region_id' => $region->id,
            'full_name' => 'Pending Member',
            'nik' => '9876543210987654',
            'phone_number' => '08987654321',
            'address' => 'Test Address',
            'birth_place' => 'Bandung',
            'birth_date' => '1995-05-05',
            'religion' => 'Islam',
            'status' => 'pending',
        ]);

        // Login as Super Admin
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $response = $this->actingAs($admin)
            ->patch(route('admin.members.status', $member), [
                'status' => 'approved',
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'status' => 'approved',
        ]);
        $member->refresh();
        $this->assertNotNull($member->kta_number);
    }

    public function test_admin_can_create_news()
    {
        Storage::fake('public');
        $region = Region::first();
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $response = $this->actingAs($admin)
            ->post(route('admin.news.store'), [
                'title' => 'Berita Terkini',
                'content' => 'Isi berita penting.',
                'region_id' => $region->id,
                'is_published' => 1,
                'image' => UploadedFile::fake()->image('news.jpg'),
            ]);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', [
            'title' => 'Berita Terkini',
            'slug' => 'berita-terkini',
            'is_published' => 1,
        ]);
    }

    public function test_public_can_view_published_news()
    {
        $region = Region::first();
        $author = User::factory()->create();
        News::create([
            'title' => 'Public News',
            'slug' => 'public-news',
            'content' => 'Content',
            'region_id' => $region->id,
            'author_id' => $author->id,
            'is_published' => true,
        ]);

        $response = $this->get(route('news.index'));
        $response->assertStatus(200);
        $response->assertSee('Public News');
    }

    public function test_approved_member_can_download_kta()
    {
        $region = Region::first();
        $user = User::factory()->create();
        $user->assignRole('member');
        $member = Member::create([
            'user_id' => $user->id,
            'region_id' => $region->id,
            'full_name' => 'Approved Member',
            'nik' => '1122334455667788',
            'phone_number' => '081122334455',
            'address' => 'Address',
            'birth_place' => 'Surabaya',
            'birth_date' => '1985-08-17',
            'religion' => 'Islam',
            'status' => 'approved',
            'kta_number' => '123.456.789',
        ]);

        // Access as Admin (owner or admin can download, logic allows admin to download too)
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $response = $this->actingAs($admin)
            ->get(route('admin.members.kta', $member));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
