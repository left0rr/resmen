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
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_description' => 'required|string',
            'item_price' => 'required|numeric|min:0',
        ]);

        Menuitem::create([
            'name' => $request->item_name,
            'description' => $request->item_description,
            'price' => $request->item_price,
            'category_id' => $category->id,
        ]);


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
    public function update(UpdateMenuitemRequest $request, Menuitem $menuitem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Request $request)
    {
        // Get the ID of the menu item from the request
        $menuitemId = $request->input('menuitem_id');

        // Find the menu item within the given category
        $menuitem = $category->menuitems()->findOrFail($menuitemId);

        // Delete the menu item
        $menuitem->delete();

        // Redirect back with a success message
        return redirect()->route('menu.show', ['category' => $category->id])->with('success', 'Item deleted successfully!');
    }

}
