<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    protected $guarded = [];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime', 'register_until' => 'datetime'];

    public function category() { return $this->belongsTo(Category::class); }
    public function registrations() { return $this->hasMany(Registration::class); }

    public function getSeatsLeftAttribute(): int
    {
        $used = $this->registrations_count ?? $this->registrations()->count();
        return max(0, $this->capacity - $used);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open' && now()->lt($this->register_until) && $this->seats_left > 0;
    }
}
