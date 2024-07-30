<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'required|url',
        ]);

        Category::create([
            'name' => $request->name,
            'logo' => $request->image_url,
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_url' => 'required|url',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'logo' => $request->image_url,
        ]);

        return redirect('/menu')->with('success', 'Category updated successfully!');
    }





    public function destroy(Category $category){
        $category->delete();
        return redirect('/menu')->with('success', 'Category deleted successfully!');
    }

    //
}
