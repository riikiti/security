<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyClusters extends Model
{
    use HasFactory;

    protected $fillable = ['cluster_id', 'user_id', 'is_redactor', 'is_reader', 'is_inviter'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }
}
