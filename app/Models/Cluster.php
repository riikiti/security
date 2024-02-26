<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cluster extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'password'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAttribute(): string
    {
        return date('d.m.Y', strtotime($this->created_at));
    }

    public function getUserEmailAttribute(): string
    {
        return $this->user->email;
    }
}
