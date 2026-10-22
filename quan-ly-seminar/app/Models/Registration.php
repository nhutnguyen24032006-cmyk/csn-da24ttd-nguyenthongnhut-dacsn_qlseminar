<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $guarded = [];
    protected $casts = ['checked_in_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function seminar() { return $this->belongsTo(Seminar::class); }
}
