<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SeedTestData extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Landlord account
        $landlord = User::create([
            'name'              => 'Anna Landlord',
            'email'             => 'landlord@tenanzo.test',
            'password'          => Hash::make('password'),
            'role'              => 'landlord',
            'email_verified_at' => now(),
        ]);

        // Tenant accounts
        $tenant1 = User::create([
            'name'              => 'Tom Tenant',
            'email'             => 'tenant@tenanzo.test',
            'password'          => Hash::make('password'),
            'role'              => 'tenant',
            'email_verified_at' => now(),
        ]);

        $tenant2 = User::create([
            'name'              => 'Sara Renter',
            'email'             => 'tenant2@tenanzo.test',
            'password'          => Hash::make('password'),
            'role'              => 'tenant',
            'email_verified_at' => now(),
        ]);

        // Properties
        $p1 = Property::create([
            'user_id'      => $landlord->id,
            'title'        => 'Modern 2-bed in Schwabing',
            'address'      => 'Leopoldstraße 45, Munich',
            'monthly_rent' => 1850,
            'bedrooms'     => 2,
            'description'  => 'Bright apartment on the 3rd floor, fully renovated kitchen, close to U3.',
            'is_active'    => true,
        ]);

        $p2 = Property::create([
            'user_id'      => $landlord->id,
            'title'        => 'Cozy studio in Maxvorstadt',
            'address'      => 'Türkenstraße 12, Munich',
            'monthly_rent' => 1100,
            'bedrooms'     => 1,
            'description'  => 'Perfect for students or young professionals. 5 min walk to TU München.',
            'is_active'    => true,
        ]);

        $p3 = Property::create([
            'user_id'      => $landlord->id,
            'title'        => 'Spacious 3-bed family home',
            'address'      => 'Rosenheimer Str. 88, Munich',
            'monthly_rent' => 2600,
            'bedrooms'     => 3,
            'description'  => 'Garden access, private parking, near Ostbahnhof.',
            'is_active'    => true,
        ]);

        // Applications — one of each status
        Application::create([
            'property_id'    => $p1->id,
            'tenant_id'      => $tenant1->id,
            'message'        => 'I am a software engineer looking for a long-term rental. Stable income, no pets.',
            'monthly_income' => 4500,
            'move_in_date'   => '2026-07-01',
            'status'         => 'pending',
        ]);

        Application::create([
            'property_id'    => $p2->id,
            'tenant_id'      => $tenant1->id,
            'message'        => 'Currently finishing my master\'s thesis, very quiet tenant.',
            'monthly_income' => 2200,
            'move_in_date'   => '2026-06-15',
            'status'         => 'approved',
            'landlord_notes' => 'Great references, approved.',
        ]);

        Application::create([
            'property_id'    => $p3->id,
            'tenant_id'      => $tenant2->id,
            'message'        => 'Family of 3, both parents employed full time.',
            'monthly_income' => 6000,
            'move_in_date'   => '2026-08-01',
            'status'         => 'rejected',
            'landlord_notes' => 'Property already taken.',
        ]);
    }
}
