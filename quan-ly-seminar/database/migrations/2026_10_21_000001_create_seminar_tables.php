<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->string('role', 10)->default('user');
            $t->string('student_code', 20)->nullable();
            $t->string('phone', 15)->nullable();
        });
        Schema::create('categories', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->timestamps();
        });
        Schema::create('seminars', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $t->string('title'); $t->text('description');
            $t->string('speaker'); $t->string('location');
            $t->dateTime('starts_at'); $t->dateTime('ends_at'); $t->dateTime('register_until');
            $t->unsignedInteger('capacity'); $t->string('status', 12)->default('open');
            $t->timestamps();
        });
        Schema::create('registrations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('seminar_id')->constrained()->cascadeOnDelete();
            $t->string('status', 12)->default('registered');
            $t->timestamp('checked_in_at')->nullable();
            $t->timestamps();
            $t->unique(['user_id', 'seminar_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('seminars');
        Schema::dropIfExists('categories');
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn(['role', 'student_code', 'phone']));
    }
};
