<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Ingridient;

use Illuminate\Http\Request;

class ProductManagmentController extends Controller
{
    public function get_productmanagmentpage()
    {
        $products = Product::all();
        return view('admin.modules.product_managment', compact('products'));
    }

    public function get_editpage($id)
    {
        $product = Product::with(['ingridients', 'nutrition'])->findOrFail($id);
        return view('admin.modules.edit_product', compact('product'));
    }


    public function editProduct(Request $request, $id)
    {
        $product = Product::with('nutrition')->findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'heading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'allergy_info' => 'nullable|string',
            'calories' => 'nullable|numeric',
            'fat' => 'nullable|numeric',
            'carbohydrates' => 'nullable|numeric',
            'protein' => 'nullable|numeric',
            'sugar' => 'nullable|numeric',
            'fiber' => 'nullable|numeric',
            'sodium' => 'nullable|numeric',
            'theme_color' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'ingredient_images' => 'nullable|array|max:5',
            'ingredient_images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Update product fields
        $product->update([
            'name' => $request->name,
            'heading' => $request->heading,
            'description' => $request->description,
            'allergy_info' => $request->allergy_info,
            'theme_color' => $request->theme_color,
            'ingredients_tagline' => $request->ingredients,
        ]);

        // ✅ Update Nutrition Data
        if ($product->nutrition) {
            $product->nutrition->update([
                'calories' => $request->calories,
                'fat' => $request->fat,
                'carbohydrates' => $request->carbohydrates,
                'protein' => $request->protein,
                'sugar' => $request->sugar,
                'fiber' => $request->fiber,
                'sodium' => $request->sodium,
            ]);
        } else {
            // If nutrition record does not exist, create a new one
            $product->nutrition()->create([
                'product_id' => $product->id,
                'calories' => $request->calories,
                'fat' => $request->fat,
                'carbohydrates' => $request->carbohydrates,
                'protein' => $request->protein,
                'sugar' => $request->sugar,
                'fiber' => $request->fiber,
                'sodium' => $request->sodium,
            ]);
        }

        // Return response or redirect
        return redirect()->route('get-editpage', $product->id)->with('success', 'Product updated successfully');
    }

}
