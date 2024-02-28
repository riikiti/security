<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'password'];

    protected $casts = [
        'password' => 'hashed',
    ];
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

    public function records(): HasMany
    {
        return $this->hasMany(Record::class, 'cluster_id', 'id');
    }
}
