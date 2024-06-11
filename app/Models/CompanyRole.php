<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyRole extends Model
{
    use HasFactory;

    protected $table = 'company_roles';
    protected $fillable = ['role', 'company_id'];

    public function getTable(): string
    {
        return 'company_roles';
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
