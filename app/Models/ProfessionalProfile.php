<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'service_category_id', 'hourly_price', 'response_time_hours', 'description', 'experience_years', 'reviews_count', 'acceptance_rate'])]
class ProfessionalProfile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
