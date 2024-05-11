<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    use HasFactory;

    protected $fillable = ['cluster_id', 'email', 'password', 'login', 'site', 'title', 'color'];

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }
}
