<?php

use App\Models\User;
use App\Models\Property;
use App\Models\Application;

test('tenant can apply for a property', function () {
    $landlord = User::factory()->create(['role' => 'landlord']);
    $tenant   = User::factory()->create(['role' => 'tenant']);
    $property = Property::factory()->create(['user_id' => $landlord->id]);

    $response = $this->actingAs($tenant)->post("/properties/{$property->id}/apply", [
        'message'        => 'I am a great tenant',
        'monthly_income' => 3000,
        'move_in_date'   => '2026-08-01',
    ]);

    $response->assertRedirect('/my-applications');
    $this->assertDatabaseHas('applications', [
        'tenant_id'   => $tenant->id,
        'property_id' => $property->id,
        'status'      => 'pending',
    ]);
});

test('tenant cannot apply twice for the same property', function () {
    $landlord = User::factory()->create(['role' => 'landlord']);
    $tenant   = User::factory()->create(['role' => 'tenant']);
    $property = Property::factory()->create(['user_id' => $landlord->id]);

    Application::factory()->create([
        'tenant_id'   => $tenant->id,
        'property_id' => $property->id,
    ]);

    $response = $this->actingAs($tenant)->post("/properties/{$property->id}/apply", [
        'message'        => 'Trying again',
        'monthly_income' => 3000,
        'move_in_date'   => '2026-08-01',
    ]);

    $response->assertStatus(409);
});

test('landlord can approve an application', function () {
    $landlord    = User::factory()->create(['role' => 'landlord']);
    $tenant      = User::factory()->create(['role' => 'tenant']);
    $property    = Property::factory()->create(['user_id' => $landlord->id]);
    $application = Application::factory()->create([
        'property_id' => $property->id,
        'tenant_id'   => $tenant->id,
        'status'      => 'pending',
    ]);

    $response = $this->actingAs($landlord)->patch("/applications/{$application->id}/status", [
        'status' => 'approved',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('applications', [
        'id'     => $application->id,
        'status' => 'approved',
    ]);
});

test('tenant cannot approve an application', function () {
    $landlord    = User::factory()->create(['role' => 'landlord']);
    $tenant      = User::factory()->create(['role' => 'tenant']);
    $property    = Property::factory()->create(['user_id' => $landlord->id]);
    $application = Application::factory()->create([
        'property_id' => $property->id,
        'tenant_id'   => $tenant->id,
    ]);

    $response = $this->actingAs($tenant)->patch("/applications/{$application->id}/status", [
        'status' => 'approved',
    ]);

    $response->assertStatus(403);
});