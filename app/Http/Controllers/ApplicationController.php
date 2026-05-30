<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Property;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function store(Request $request, Property $property)
    {
        abort_if(!auth()->check(), 401);
        abort_if(auth()->user()->isLandlord(), 403, 'Landlords cannot apply for properties.');

        $alreadyApplied = $property->applications()
            ->where('tenant_id', auth()->id())
            ->exists();

        abort_if($alreadyApplied, 409, 'You have already applied for this property.');

        $validated = $request->validate([
            'message'        => 'required|string|max:1000',
            'monthly_income' => 'required|numeric|min:0',
            'move_in_date'   => 'required|date|after:today',
        ]);

        $property->applications()->create([
            ...$validated,
            'tenant_id' => auth()->id(),
            'status'    => 'pending',
        ]);

        return redirect()->route('my-applications')->with('success', 'Application submitted.');
    }

    public function updateStatus(Request $request, Application $application)
    {
        abort_if(!auth()->user()->isLandlord(), 403);
        abort_if(auth()->id() !== $application->property->user_id, 403);

        $validated = $request->validate([
            'status'          => 'required|in:approved,rejected',
            'landlord_notes'  => 'nullable|string|max:500',
        ]);

        $application->update($validated);

        return back()->with('success', 'Application ' . $validated['status'] . '.');
    }

    public function myApplications()
    {
        $applications = auth()->user()
            ->applications()
            ->with('property')
            ->latest()
            ->get();

        return Inertia::render('Dashboard/TenantView', [
            'applications' => $applications,
        ]);
    }

    public function landlordDashboard()
    {
        abort_if(!auth()->user()->isLandlord(), 403);

        $properties = auth()->user()
            ->properties()
            ->with(['applications.tenant'])
            ->latest()
            ->get();

        return Inertia::render('Dashboard/LandlordView', [
            'properties' => $properties,
        ]);
    }
}