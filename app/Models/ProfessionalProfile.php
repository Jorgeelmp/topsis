<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'service_category_id', 'hourly_price', 'response_time', 'description', 'experience_years', 'acceptance_rate'])]
class ProfessionalProfile extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewed_user_id', 'user_id');
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    public function getAverageRatingAttribute(): float|null
    {
        return $this->reviews()->avg('rating');
    }
}
