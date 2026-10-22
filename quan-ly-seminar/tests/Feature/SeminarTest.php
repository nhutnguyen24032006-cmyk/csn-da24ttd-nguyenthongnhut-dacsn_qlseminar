<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Seminar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeminarTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_seminars_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $cat = Category::create(['name' => 'AI']);
        Seminar::create([
            'category_id' => $cat->id,
            'created_by' => $admin->id,
            'title' => 'Hội thảo AI 2026',
            'description' => 'Mô tả hội thảo',
            'speaker' => 'TS. Nhứt',
            'location' => 'Hội trường A',
            'starts_at' => now()->addDays(2),
            'ends_at' => now()->addDays(2)->addHours(2),
            'register_until' => now()->addDay(),
            'capacity' => 50,
            'status' => 'open',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Hội thảo AI 2026');
    }

    public function test_student_can_register_and_cancel_seminar(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'user']);
        $seminar = Seminar::create([
            'created_by' => $admin->id,
            'title' => 'Workshop Laravel',
            'description' => 'Mô tả',
            'speaker' => 'Diễn giả B',
            'location' => 'Phòng Lab',
            'starts_at' => now()->addDays(3),
            'ends_at' => now()->addDays(3)->addHours(2),
            'register_until' => now()->addDays(2),
            'capacity' => 30,
            'status' => 'open',
        ]);

        // Đăng ký
        $response = $this->actingAs($student)->post(route('seminars.register', $seminar));
        $response->assertSessionHas('ok');
        $this->assertDatabaseHas('registrations', [
            'user_id' => $student->id,
            'seminar_id' => $seminar->id,
        ]);

        // Hủy đăng ký
        $response = $this->actingAs($student)->delete(route('seminars.cancel', $seminar));
        $response->assertSessionHas('ok');
        $this->assertDatabaseMissing('registrations', [
            'user_id' => $student->id,
            'seminar_id' => $seminar->id,
        ]);
    }

    public function test_non_admin_cannot_access_admin_panel(): void
    {
        $student = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($student)->get('/admin/seminars');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_panel(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/admin/seminars');
        $response->assertStatus(200);
    }
}
