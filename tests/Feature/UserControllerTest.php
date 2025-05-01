<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Country;
use App\Models\UserContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_users()
    {
        // Create an admin user and authenticate them
        $admin = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($admin);

        // Create some test users
        User::factory()->count(3)->create();

        //login user
        $response = $this->post('login', [
            'email' => $admin->email,
            'password' => 'password'
        ]);
        $this->assertAuthenticated();

        // Send a GET request to the route
        $response = $this->get(route('manageuser.list'));

        // Assert the status is 200 and data is passed to the view
        $response->assertStatus(200);
        $response->assertViewHas('data');
    }

    /** @test */
    public function it_can_show_add_user_form()
    {
        // Create an admin and Simulate the admin user being logged in
        $admin = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($admin);

        // Insert country data directly
        DB::table('countries')->insert([
            [
                'name' => 'India',
                'code' => 'IN',
                'iso_code' => 'IND',
                'isd_code' => '+91',
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'iso_code' => 'GBR',
                'isd_code' => '+44',
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'iso_code' => 'USA',
                'isd_code' => '+1',
            ],
        ]);

        // open add user form with dropdown detils
        $response = $this->getJson(route('manageuser.add'));

        // Assert that the response is successful and contains expected data
        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    /** @test */
    public function it_can_create_a_new_user()
    {
        $this->assertEquals(0, User::count()); // Ensure no users exist initially

        // Create an admin and Simulate the admin user being logged in
        $admin = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($admin);

        // Ensure a country is created before using it in the request data
        $country = Country::create([
            'name' => 'India',
            'code' => 'IN',
            'iso_code' => 'IND',
            'isd_code' => '+91',
        ]);

        // send data via post request
        $this->post(route('manageuser.postadd'), [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123', // Make sure you hash passwords correctly in actual creation
            'role' => 'User',
            'phone' => '1234567890',
            'mobile' => '9876543210',
            'address1' => '123 Main St',
            'address2' => 'Apt 4B',
            'address3' => 'Somewhere',
            'postcode' => '12345',
            'country' => $country->id, // Use the country ID that was created
        ]);

        $this->assertEquals(1, User::count());
    }

    /** @test */
    public function it_can_show_edit_user_form()
    {
        // Create an admin and Simulate the admin user being logged in
        $admin = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($admin);

        // Create a test user whose details will be displayed
        $user = User::factory()->create();

        // Insert country data directly
        DB::table('countries')->insert([
            [
                'name' => 'India',
                'code' => 'IN',
                'iso_code' => 'IND',
                'isd_code' => '+91',
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'iso_code' => 'GBR',
                'isd_code' => '+44',
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'iso_code' => 'USA',
                'isd_code' => '+1',
            ],
        ]);

        // Retrieve an existing country
        $country = DB::table('countries')->first();

        // Create a user contact associated with the user and country
        UserContact::factory()->create([
            'user_id' => $user->id,
            'country_id' => $country->id,
        ]);

        // Send a request to the edit route
        $response = $this->getJson(route('manageuser.edit', ['id' => $user->id]));

        // Assert the response is successful
        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        // Create an admin and Simulate the admin user being logged in
        $admin = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($admin);

        // Create a test user whose details will be updated
        $user = User::factory()->create();
        UserContact::factory()->create(['user_id' => $user->id]);


        $response = $this->post(route('manageuser.update'), [
            'id_edit' => $user->id,
            'name' => 'Updated Name',
            'email' => $user->email,
            'role' => 'Admin',
            'phone' => '1122334455',
            'mobile' => '5566778899',
            'address1' => 'New Address 1',
            'address2' => 'New Address 2',
            'address3' => 'New Address 3',
            'postcode' => '54321',
            'country' => $user->contact->country_id,
        ]);
        $this->assertDatabaseHas('users', ['name' => 'Updated Name']); // Verify the database update
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        // Authenticate as admin
        $admin = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($admin);

        // Create user
        $user = User::factory()->create();
        UserContact::factory()->create(['user_id' => $user->id]);

        // Send request to delete user using GET method
        // $response = $this->get(route('manageuser.delete', ['id' => $user->id]));
        $response = $this->deleteJson(route('manageuser.delete', $user->id))->assertNoContent();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);

        // Assert the response status
        // $response->assertStatus(200); // Ensure the response is successful

        // Assert user is soft-deleted
        // $this->assertSoftDeleted('users', ['id' => $user->id]);
    }


















    public function it_can_register_a_user()
    {
        // Insert country data statically or retrieve an existing one
        $country = Country::first(); // Assumes a country exists in your table

        $requestData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'User',
            'contact' => [
                'phone' => '1234567890',
                'mobile' => '9876543210',
                'address1' => '123 Main St',
                'address2' => 'Apt 4B',
                'address3' => 'Somewhere',
                'postcode' => '12345',
                'country_id' => $country->id,
            ],
        ];

        $response = $this->postJson('/api/users/register', $requestData);

        $response->assertStatus(201)
            ->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function it_can_login_a_user()
    {
        $user = User::factory()->create(['password' => Hash::make('password123')]);
        $response = $this->postJson('/api/users/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);
    }

    public function it_can_logout_a_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->postJson('/api/users/logout');
        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);
    }
}
