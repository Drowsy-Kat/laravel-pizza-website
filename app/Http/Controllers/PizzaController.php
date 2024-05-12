<?php

namespace App\Http\Controllers;
use App\Http\Requests\PizzaStoreRequest;
use App\Http\Requests\PizzaUpdateRequest;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;

class PizzaController extends Controller
{




    //ensure the user is logged in
   public function __construct()
   {
       $this->middleware('auth');
   }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pizzas = Pizza::with('category')->get(); // Retrieve all pizzas from the database
        
        return view('pizza.index', compact('pizzas')); // Pass the pizzas to the view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve categories from the categories table
        $categories = Category::pluck('name', 'id');
        
        // Pass categories to the view
        return view('pizza.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PizzaStoreRequest $request)
    {
        // Store the image in the 'storage/app/public/pizza/images' directory
        $path = $request->file('pizza_image')->store('public/pizza/images');

        // Convert the path to a URL-friendly path
        $relativePath = str_replace('public/', 'storage/', $path);

        // Create a new pizza record with the correct image path
        Pizza::create([
            'pizza_name' => $request->pizza_name,
            'pizza_desc' => $request->pizza_desc,
            'pizza_large_price' => $request->pizza_large_price,
            'pizza_medium_price' => $request->pizza_medium_price,
            'pizza_small_price' => $request->pizza_small_price,
            'pizza_category' => $request->category_id,
            'pizza_image' => $relativePath, // Store the modified path here
        ]);
        // Redirect or perform other actions after saving
        // Redirect back to the create view with a success message
        //return redirect()->route('pizza.create')->with('success', 'Pizza created successfully.');
        return redirect()->route('pizza.index')->with('message', 'Pizza added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pizza = Pizza::findOrFail($id);
        $categories = Category::pluck('name', 'id');
        // Retrieve distinct categories from the pizzas
        
        return view('pizza.edit', compact('pizza'), compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PizzaUpdateRequest $request, string $id)
    {
        // First, find the pizza record to ensure it exists
        $pizza = Pizza::find($id);

        // If the pizza doesn't exist, redirect or return an error
        if (!$pizza) {
            // For a web request, consider redirecting back with an error message
            return back()->withErrors(['message' => 'Pizza not found']);
            // For an API response, you might return a JSON response
            return response()->json(['message' => 'Pizza not found'], 404);
        }

        // Check if a new image was uploaded
        if ($request->hasFile('pizza_image')) {
            // Store the new image and get its path
            $path = $request->file('pizza_image')->store('public/pizza/images');

            // Convert the path to a URL-friendly path
            $relativePath = str_replace('public/', 'storage/', $path);

            // Update the pizza image path
            $pizza->pizza_image = $relativePath;
        }
        // No else block needed; if no new image is uploaded, we keep the current image






        // Update other pizza properties from the request
        $pizza->pizza_name = $request->pizza_name;
        $pizza->pizza_desc = $request->pizza_desc;
        $pizza->pizza_large_price = $request->pizza_large_price;
        $pizza->pizza_medium_price = $request->pizza_medium_price;
        $pizza->pizza_small_price = $request->pizza_small_price;
        $pizza->pizza_category = $request->pizza_category;

        // Save the updated pizza record
        $pizza->save();
        $catagory = Category::find($request->pizza_category);
        $pizza->pizza_category = $catagory;
        $pizza->refresh();
        

        // Redirect to a given route with a success message
        return redirect()->route('pizza.index')->with('message', 'Pizza updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pizza::find($id)->delete();
        return redirect()->route('pizza.index')->with('message','Pizza deleted successfuly');
    }
}
