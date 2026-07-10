<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'category', 'hourly_price', 'response_time_hours', 'description', 'experience_years'])]
class ProfessionalProfile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
