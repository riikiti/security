<?php

namespace App\Models;

use App\Services\Helpers\Images\ImageHelperService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    private ImageHelperService $imageHelper;

    protected $table = 'companies';

    public function __construct()
    {
        $this->imageHelper = app(ImageHelperService::class);
        $this->imageHelper->setSavingPath('logo');
    }

    protected $fillable = ['name', 'logo', 'description'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }

    public function setLogoAttribute($value): void
    {
        $this->attributes['logo'] = $this->imageHelper->handleImageUpload(
            value: $value,
            model: $this,
            attribute: 'logo'
        );
        $this->save();
    }
}
