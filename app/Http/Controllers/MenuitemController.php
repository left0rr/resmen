<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discountcode;
use App\Models\Menuitem;
use App\Http\Requests\StoreMenuitemRequest;
use App\Http\Requests\UpdateMenuitemRequest;
use App\Models\MenuitemOrderCount;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuitemController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $menuitems = Menuitem::with('category')->get();

        // Fetch top 3 menu items with highest times_ordered
        $topmenuitems = Menuitem::select('menuitems.*')
            ->join('menuitem_order_counts', 'menuitems.id', '=', 'menuitem_order_counts.menuitem_id')
            ->orderBy('menuitem_order_counts.times_ordered', 'desc')
            ->groupBy('menuitems.id')
            ->limit(3)
            ->get();

        return view('category.index', [
            'categories' => $categories,
            'menuitems' => $menuitems,
            'topmenuitems' => $topmenuitems,
        ]);
    }

    public function show($categoryName)
    {
        // Retrieve the category by its name
        $categories=category::all();
        $category = Category::where('name', $categoryName)->firstOrFail();
        $menuitems=Menuitem::where('category_id', $category->id)->get();
        // Return a view and pass the category to it
        return view('category.show', [
            'categories'=>$categories,
            'category' => $category,
            'menuitems' => $menuitems
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request, Category $category)
    {
        // Validate the request data
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_description' => 'required|string',
            'item_price' => 'required|numeric|min:0',
            'image_url' => 'required|url', // Add validation for the image_url
        ]);

        // Create a new menu item
        Menuitem::create([
            'name' => $request->item_name,
            'description' => $request->item_description,
            'price' => $request->item_price,
            'image_url' => $request->image_url, // Include image_url in the create method
            'category_id' => $category->id,
        ]);

        // Redirect back with success message
        return redirect('/menu/'.$category->name)->with('success', 'Item added successfully!');
    }






    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Menuitem $menuitem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menuitem $menuitem)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_description' => 'required|string',
            'item_price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url'
        ]);

        // Update the menu item with the validated data
        $menuitem->update([
            'name' => $validatedData['item_name'],
            'description' => $validatedData['item_description'],
            'price' => $validatedData['item_price'],
            'image_url' => $validatedData['image_url'] ?? $menuitem->image_url, // Preserve existing image_url if not provided
        ]);

        // Redirect or return a response
        return redirect()->route('menu')->with('success', 'Menu item updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menuitem $menuitem)
    {
        $menuitem->delete();

        return redirect()->back()->with('success', 'Menu item deleted successfully.');
    }

}
