<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Seminar;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(['email' => 'admin@seminar.test'], ['name' => 'Ban tổ chức', 'password' => Hash::make('123456'), 'role' => 'admin']);
        User::firstOrCreate(['email' => 'sinhvien@seminar.test'], ['name' => 'Nguyễn Văn A', 'password' => Hash::make('123456'), 'role' => 'user', 'student_code' => '110124001', 'phone' => '0900000000']);

        $cats = collect(['Công nghệ thông tin', 'Trí tuệ nhân tạo', 'Khởi nghiệp', 'Kỹ năng nghiên cứu'])
            ->map(fn ($n) => Category::firstOrCreate(['name' => $n]));

        $rows = [
            ['Xây dựng website với Laravel từ con số 0', 'ThS. Trần Minh Khoa', 0, 'Phòng B1.201', 3, 60],
            ['Trí tuệ nhân tạo trong giáo dục đại học', 'TS. Lê Thu Hà', 1, 'Hội trường A', 5, 120],
            ['Từ ý tưởng đến startup: kinh nghiệm của sinh viên', 'Anh Phạm Quốc Bảo', 2, 'Phòng B2.105', 8, 40],
            ['Cách viết và trình bày một bài báo khoa học', 'PGS.TS. Nguyễn Văn Sơn', 3, 'Hội trường A', 12, 100],
            ['An toàn thông tin cho ứng dụng web', 'ThS. Võ Thanh Tùng', 0, 'Phòng Lab 3', 15, 30],
        ];
        foreach ($rows as [$title, $speaker, $c, $place, $days, $cap]) {
            $start = now()->addDays($days)->setTime(14, 0);
            Seminar::firstOrCreate(['title' => $title], [
                'category_id' => $cats[$c]->id, 'created_by' => $admin->id, 'speaker' => $speaker, 'location' => $place,
                'description' => "Buổi chia sẻ dành cho sinh viên và giảng viên quan tâm đến chủ đề này.\nNội dung gồm phần trình bày của diễn giả và thời gian hỏi đáp trực tiếp.",
                'starts_at' => $start, 'ends_at' => $start->copy()->addHours(2), 'register_until' => $start->copy()->subDay(),
                'capacity' => $cap, 'status' => 'open',
            ]);
        }
    }
}
