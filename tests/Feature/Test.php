<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Pizza;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;




class ExampleTest extends TestCase
{   
    /**
     * tests if a pizza can be found in the database
     * 
     * @return void
     */
    

     public function test_correct_pizza_returned()
     {
         $id = 2;
         $pizza = Pizza::findOrFail($id);
 
         $correctResponse = new Pizza([
             'id' => '2',
             'pizza_name' => 'margarita',
             'pizza_desc' => 'just cheese',
             'pizza_large_price' => 10,
             'pizza_medium_price' => 8,
             'pizza_small_price' => 5,
             'pizza_category' => 2,
             'pizza_image' => 'storage/pizza/images/XM7MfepEbDwwcxsOoQFzdh6XpSo65IbBqKT8AKkl.jpg'
         ]);
 
         $this->assertEquals($pizza->id, $correctResponse->id);
         $this->assertEquals($pizza->pizza_name, $correctResponse->pizza_name);
         $this->assertEquals($pizza->pizza_desc, $correctResponse->pizza_desc);
         $this->assertEquals($pizza->pizza_large_price, $correctResponse->pizza_large_price);
         $this->assertEquals($pizza->pizza_medium_price, $correctResponse->pizza_medium_price);
         $this->assertEquals($pizza->pizza_small_price, $correctResponse->pizza_small_price);
         $this->assertEquals($pizza->pizza_category, $correctResponse->pizza_category);
         $this->assertEquals($pizza->pizza_image, $correctResponse->pizza_image);
 
 
         
     }

    /**
     * tests if the correct user id is returned when asked for
     * 
     * @return void
     */

     public function test_correct_user_id_returned()
     {
         // Create a user
         $user = User::factory()->create();
 
         // Login the user
         Auth::login($user);
 
         // Call Auth::user()->id and assert if it matches the expected user ID
         $this->assertEquals($user->id, Auth::user()->id);
 
         // Logout the user
         Auth::logout();
 
         // Delete the user
         $user->delete();
     }

     /**
     * tests if regular users are restricted from admin only routes
     * 
     * @return void
     */

     public function test_non_admin_cannot_access_admin_routes()
     {
         // Create a non-admin user
         $user = User::factory()->create(['is_admin' => 0]);
 
         // Login the user
         Auth::login($user);
 
         // Attempt to access admin routes
         $response = $this->get('/admin/users');
 
         // Assert that the response status is 403 (Forbidden)
         $response->assertStatus(403);

         // Logout the user
         Auth::logout();
 
         // Delete the user
         $user->delete();         

         
     }
 
     /**
      * Test if an admin user can access admin routes.
      *
      * @return void
      */
     public function test_admin_can_access_admin_routes()
     {
         // Create an admin user
         $adminUser = User::factory()->create(['is_admin' => 1]);
 
         // Login the admin user
         Auth::login($adminUser);
 
         // Attempt to access admin routes
         $response = $this->get('/admin/users');
 
         // Assert that the response status is 200 (OK)
         $response->assertStatus(200);

         // Logout the user
         Auth::logout();
 
         // Delete the user
         $adminUser->delete();         
     }

     /**
     * Test if a logged-in user can access the home page.
     *
     * @return void
     */
    public function test_logged_in_user_can_access_home_page()
    {
        // Create a user
        $user = User::factory()->create();

        // Login the user
        Auth::login($user);

        // Attempt to access the home page
        $response = $this->get('/');

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Logout the user
        Auth::logout();
 
        // Delete the user
        $user->delete();   
    }

    /**
     * Test if a guest user is redirected to the login page when trying to access the home page.
     *
     * @return void
     */
    public function test_guest_redirected_to_login_when_accessing_home_page()
    {
        // Attempt to access the home page without logging in
        $response = $this->get('/');

        // Assert that the response status is 302 (Found) indicating a redirection
        $response->assertStatus(302);

        // Assert that the user is redirected to the login page
        $response->assertRedirect(route('login'));
    }

     /**
     * Test if a pizza can be stored successfully.
     *
     * @return void
     */
    public function test_store_pizza_successfully()
    {
        Storage::fake('public');
        $adminUser = User::factory()->create(['is_admin' => 1]);
    
        // Login the admin user
        Auth::login($adminUser);
    
        

        $response = $this->post('/pizza/store', [
            'pizza_name' => 'Test Pizza',
            'pizza_desc' => 'This is a test pizza description.',
            'pizza_large_price' => 10.99,
            'pizza_medium_price' => 8.99,
            'pizza_small_price' => 6.99,
            'category_id' => 1, // Assuming category ID
            'pizza_image' => UploadedFile::fake()->image('pizza.jpg'),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/pizza');

        $this->assertDatabaseHas('pizzas', [
            'pizza_name' => 'Test Pizza',
        ]);

        // Retrieve the created pizza
        $pizza = Pizza::where('pizza_name', 'Test Pizza')->first();

        // Ensure that the pizza is found
        $this->assertNotNull($pizza);

        // Delete the pizza
        if ($pizza) {
            $pizza->delete();
        }        

        


        // Logout the user
        Auth::logout();
 
        // Delete the user
        $adminUser->delete();  

    
    }

        /**
     * Test if a pizza can be updated successfully.
     *
     * @return void
     */
    public function test_update_pizza_successfully()
    {

        // Create an admin user
        $adminUser = User::factory()->create(['is_admin' => 1]);
 
        // Login the admin user
        Auth::login($adminUser);

        Storage::fake('public');
    
        // First, create a pizza to update
        $pizza = Pizza::create([
            'pizza_name' => 'Original Pizza Name',
            'pizza_desc' => 'Original pizza description.',
            'pizza_large_price' => 9.99,
            'pizza_medium_price' => 7.99,
            'pizza_small_price' => 5.99,
            'pizza_category' => 1, // Assuming category ID
            'pizza_image' => UploadedFile::fake()->image('pizza.jpg'),
        ]);
    
        $response = $this->put('/pizza/' . $pizza->id . '/update', [
            'pizza_name' => 'Updated Pizza Name',
            'pizza_desc' => 'Updated pizza description.',
            'pizza_large_price' => 12.99,
            'pizza_medium_price' => 10.99,
            'pizza_small_price' => 8.99,
            'pizza_category' => 1, // Assuming category ID
            // 'pizza_image' => UploadedFile::fake()->image('updated_pizza.jpg'), // Assuming you're not updating the image in this test
        ]);
    
        $response->assertStatus(302);
        $response->assertRedirect('/pizza');
    
        $this->assertDatabaseHas('pizzas', [
            'id' => $pizza->id,
            'pizza_name' => 'Updated Pizza Name',
        ]);

        // Retrieve the created pizza
        $pizza = Pizza::where('pizza_name', 'Updated Pizza Name')->first();

        // Ensure that the pizza is found
        $this->assertNotNull($pizza);

        // Delete the pizza
        if ($pizza) {
            $pizza->delete();
        }        

        // Logout the user
        Auth::logout();
 
        // Delete the user
        $adminUser->delete();           
    }
    
    /**
     * Test if a pizza can be deleted successfully.
     *
     * @return void
     */
    public function test_destroy_pizza_successfully()
    {

         // Create an admin user
         $adminUser = User::factory()->create(['is_admin' => 1]);
 
         // Login the admin user
         Auth::login($adminUser);        


        // First, create a pizza to delete
        $pizza = Pizza::create([
            'pizza_name' => 'Pizza to Delete',
            'pizza_desc' => 'Description of pizza to delete.',
            'pizza_large_price' => 9.99,
            'pizza_medium_price' => 7.99,
            'pizza_small_price' => 5.99,
            'pizza_category' => 1, // Assuming category ID
            'pizza_image' => UploadedFile::fake()->image('pizza.jpg'),
        ]);

        // Retrieve the created pizza
        $pizza = Pizza::where('pizza_name', 'Pizza to Delete')->first();

        $response = $this->delete('/pizza/' . $pizza->id . '/delete');
    
        $response->assertStatus(302);
        $response->assertRedirect('/pizza');
    
        $this->assertDatabaseMissing('pizzas', [
            'id' => $pizza->id,
        ]);

        

        // Delete the pizza in case of failed test
        if ($pizza) {
            $pizza->delete();
        }        

        // Logout the user
        Auth::logout();
    
 
        // Delete the user
        $adminUser->delete();   
    }

    /**
     * Test if an admin can change someone from a non admin to an admin
     *
     * @return void
     */

    public function test_promotion()
    {
         // Create an admin user
         $adminUser = User::factory()->create(['is_admin' => 1]);
 
         // Login the admin user
         Auth::login($adminUser);   
         
         // create a user to be promoted
         $promotedUser = User::factory()->create();

         $responce = $this->put('/admin/user/'. $promotedUser->id .'/promote');

         $responce->assertStatus(302);
         $responce->assertRedirect('/admin/users');

         // Logout of the user
         Auth::logout();
 
         // Delete the user
         $adminUser->delete();  
         $promotedUser->delete();

    }



}
