<?php

use App\Models\User;
use App\Models\Property;

test('guests can view property listings', function () {
    Property::factory()->create(['title' => 'Test Apartment']);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Test Apartment');
});

test('landlord can create a property', function () {
    $landlord = User::factory()->create(['role' => 'landlord']);

    $response = $this->actingAs($landlord)->post('/properties', [
        'title'        => 'New Flat in Munich',
        'address'      => 'Marienplatz 1, Munich',
        'monthly_rent' => 1500,
        'bedrooms'     => 2,
        'description'  => 'Nice flat',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertDatabaseHas('properties', ['title' => 'New Flat in Munich']);
});

test('tenant cannot create a property', function () {
    $tenant = User::factory()->create(['role' => 'tenant']);

    $response = $this->actingAs($tenant)->post('/properties', [
        'title'        => 'Sneaky Flat',
        'address'      => 'Nowhere',
        'monthly_rent' => 1000,
        'bedrooms'     => 1,
    ]);

    $response->assertStatus(403);
});