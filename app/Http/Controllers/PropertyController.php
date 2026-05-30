<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('landlord')
            ->where('is_active', true)
            ->latest()
            ->get();

        return Inertia::render('Properties/Index', [
            'properties' => $properties,
        ]);
    }

    public function show(Property $property)
    {
        $property->load('landlord');
        $alreadyApplied = false;

        if (auth()->check()) {
            $alreadyApplied = $property->applications()
                ->where('tenant_id', auth()->id())
                ->exists();
        }

        return Inertia::render('Properties/Show', [
            'property' => $property,
            'alreadyApplied' => $alreadyApplied,
        ]);
    }

    public function store(Request $request)
    {   
        abort_if(!$request->user()->isLandlord(), 403);
        
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'monthly_rent' => 'required|numeric|min:0',
            'bedrooms'     => 'required|integer|min:1',
            'description'  => 'nullable|string',
        ]);

        $request->user()->properties()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Property listed.');
    }

    public function update(Request $request, Property $property)
    {
        abort_if($request->user()->id !== $property->user_id, 403);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'address'      => 'required|string|max:255',
            'monthly_rent' => 'required|numeric|min:0',
            'bedrooms'     => 'required|integer|min:1',
            'description'  => 'nullable|string',
            'is_active'    => 'boolean',
        ]);

        $property->update($validated);

        return redirect()->route('dashboard')->with('success', 'Property updated.');
    }

    public function destroy(Request $request, Property $property)
    {
        abort_if($request->user()->id !== $property->user_id, 403);
        $property->update(['is_active' => false]);

        return redirect()->route('dashboard')->with('success', 'Property removed.');
    }
}