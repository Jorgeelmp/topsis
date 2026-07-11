<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Models\ProfessionalProfile;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalController extends Controller
{
    public function showBecomeProfessionalForm()
    {
        if (Auth::user()->role === RolesEnum::PROFESSIONAL) {
            return to_route('profile')->with('info', __('You are already a professional'));
        }

        $categories = ServiceCategory::orderBy('name')->get();

        return view('professional.become', compact('categories'));
    }

    public function becomeProfessional(Request $request)
    {
        if (Auth::user()->role === RolesEnum::PROFESSIONAL) {
            return to_route('profile');
        }

        $request->validate([
            'service_category_id' => ['required', 'integer', 'exists:service_categories,id'],
            'hourly_price' => ['required', 'numeric', 'min:0'],
            'response_time_hours' => ['required', 'integer', 'min:1'],
            'experience_years' => ['required', 'integer', 'min:0'],
        ]);

        $user = Auth::user();

        ProfessionalProfile::create([
            'user_id' => $user->id,
            'service_category_id' => $request->service_category_id,
            'hourly_price' => $request->hourly_price,
            'response_time_hours' => $request->response_time_hours,
            'experience_years' => $request->experience_years,
        ]);

        $user->role = RolesEnum::PROFESSIONAL;
        $user->save();

        return to_route('profile')->with('success', __('You are now a professional on the platform!'));
    }
}
