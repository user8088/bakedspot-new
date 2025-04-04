<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
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

    // public function editProduct(Request $request, $id)
    // {
    //     $product = Product::with('nutrition', 'images')->findOrFail($id);

    //     // Validate the request
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'heading' => 'nullable|string|max:255',
    //         'description' => 'nullable|string',
    //         'allergy_info' => 'nullable|string',
    //         'calories' => 'nullable|numeric',
    //         'fat' => 'nullable|numeric',
    //         'carbohydrates' => 'nullable|numeric',
    //         'protein' => 'nullable|numeric',
    //         'sugar' => 'nullable|numeric',
    //         'fiber' => 'nullable|numeric',
    //         'sodium' => 'nullable|numeric',
    //         'theme_color' => 'nullable|string',
    //         'ingredients_tagline' => 'nullable|string',
    //         'ingredient_images' => 'nullable|array|max:5',
    //         'ingredient_images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    //         'home_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    //         'detail_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    //         'pack_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    //     ]);

    //     // Update product fields
    //     $product->update([
    //         'name' => $request->name,
    //         'heading' => $request->heading,
    //         'description' => $request->description,
    //         'allergy_info' => $request->allergy_info,
    //         'theme_color' => $request->theme_color,
    //         'ingredients_tagline' => $request->ingredients_tagline,
    //     ]);

    //     // ✅ Update Nutrition Data
    //     if ($product->nutrition) {
    //         $product->nutrition->update([
    //             'calories' => $request->calories,
    //             'fat' => $request->fat,
    //             'carbohydrates' => $request->carbohydrates,
    //             'protein' => $request->protein,
    //             'sugar' => $request->sugar,
    //             'fiber' => $request->fiber,
    //             'sodium' => $request->sodium,
    //         ]);
    //     } else {
    //         // If nutrition record does not exist, create a new one
    //         $product->nutrition()->create([
    //             'product_id' => $product->id,
    //             'calories' => $request->calories,
    //             'fat' => $request->fat,
    //             'carbohydrates' => $request->carbohydrates,
    //             'protein' => $request->protein,
    //             'sugar' => $request->sugar,
    //             'fiber' => $request->fiber,
    //             'sodium' => $request->sodium,
    //         ]);
    //     }

    //     // Handle image uploads
    //     if ($request->hasFile('home_image')) {
    //         $homeImagePath = $request->file('home_image_url')->store('product_images', 'public');
    //     }
    //     if ($request->hasFile('detail_image')) {
    //         $detailImagePath = $request->file('detail_image_url')->store('product_images', 'public');
    //     }
    //     if ($request->hasFile('pack_image')) {
    //         $packImagePath = $request->file('pack_image_url')->store('product_images', 'public');
    //     }

    //     // Save or update images in the ProductImage table
    //     if (isset($homeImagePath) || isset($detailImagePath) || isset($packImagePath)) {
    //         $productImage = $product->image ?: new ProductImage();
    //         $productImage->product_id = $product->id;

    //         if (isset($homeImagePath)) {
    //             $productImage->home_image_url = $homeImagePath;
    //         }
    //         if (isset($detailImagePath)) {
    //             $productImage->detail_image_url = $detailImagePath;
    //         }
    //         if (isset($packImagePath)) {
    //             $productImage->pack_image_url = $packImagePath;
    //         }

    //         $productImage->save();
    //     }

    //     // Return response or redirect
    //     return redirect()->route('get-editpage', $product->id)->with('success', 'Product updated successfully');
    // }
    public function editProduct(Request $request, $id)
{
    $product = Product::with('nutrition', 'images')->findOrFail($id);

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
        'ingredients_tagline' => 'nullable|string',
        'ingredient_images' => 'nullable|array|max:5',
        'ingredient_images.*' => 'image|mimes:jpg,jpeg,png,gif|max:5120',
        'home_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        'detail_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        'pack_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
    ]);

    // Update product fields
    $product->update([
        'name' => $request->name,
        'heading' => $request->heading,
        'description' => $request->description,
        'allergy_info' => $request->allergy_info,
        'theme_color' => $request->theme_color,
        'ingredients_tagline' => $request->ingredients_tagline,
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

        $uploadPath = public_path('assets/images/uploads');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $productImage = $product->images->first() ?: new ProductImage();
        $productImage->product_id = $product->id;

        if ($request->hasFile('home_image_url')) {
            // Delete existing file
            if ($productImage->home_image_url && file_exists(public_path('assets/' . $productImage->home_image_url))) {
                unlink(public_path('assets/' . $productImage->home_image_url));
            }

            $homeImage = $request->file('home_image_url');
            $homeImageName = time() . '_home.' . $homeImage->getClientOriginalExtension();
            $homeImage->move($uploadPath, $homeImageName);
            $productImage->home_image_url = 'images/uploads/' . $homeImageName;
        }

        if ($request->hasFile('detail_image_url')) {
            if ($productImage->detail_image_url && file_exists(public_path('assets/' . $productImage->detail_image_url))) {
                unlink(public_path('assets/' . $productImage->detail_image_url));
            }

            $detailImage = $request->file('detail_image_url');
            $detailImageName = time() . '_detail.' . $detailImage->getClientOriginalExtension();
            $detailImage->move($uploadPath, $detailImageName);
            $productImage->detail_image_url = 'images/uploads/' . $detailImageName;
        }

        if ($request->hasFile('pack_image_url')) {
            if ($productImage->pack_image_url && file_exists(public_path('assets/' . $productImage->pack_image_url))) {
                unlink(public_path('assets/' . $productImage->pack_image_url));
            }

            $packImage = $request->file('pack_image_url');
            $packImageName = time() . '_pack.' . $packImage->getClientOriginalExtension();
            $packImage->move($uploadPath, $packImageName);
            $productImage->pack_image_url = 'images/uploads/' . $packImageName;
        }

        $productImage->save();

    // Return response or redirect
    return redirect()->route('get-editpage', $product->id)->with('success', 'Product updated successfully');
}




    public function get_newproductpage()
    {
        return view('admin.modules.add_product');
    }

    // public function storeProduct(Request $request)
    // {
    //     // Validate request data
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'heading' => 'nullable|string|max:255',
    //         'description' => 'nullable|string',
    //         'allergy_info' => 'nullable|string',
    //         'ingredients_tagline'=> 'nullable|string',
    //         'price' => 'required|numeric|min:0',
    //         'calories' => 'nullable|numeric',
    //         'fat' => 'nullable|numeric',
    //         'carbohydrates' => 'nullable|numeric',
    //         'protein' => 'nullable|numeric',
    //         'sugar' => 'nullable|numeric',
    //         'fiber' => 'nullable|numeric',
    //         'sodium' => 'nullable|numeric',
    //         'theme_color' => 'nullable|string',
    //         'home_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120', // 5MB
    //         'detail_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
    //         'pack_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
    //     ]);

    //     try {
    //         // Create a new product
    //         $product = Product::create([
    //             'name' => $request->name,
    //             'heading' => $request->heading,
    //             'description' => $request->description,
    //             'allergy_info' => $request->allergy_info,
    //             'price' => $request->price,
    //             'theme_color' => $request->theme_color,
    //             'ingredients_tagline'=> $request->ingredients_tagline
    //         ]);

    //         // Create a related nutrition entry
    //         $product->nutrition()->create([
    //             'calories' => $request->calories,
    //             'fat' => $request->fat,
    //             'carbohydrates' => $request->carbohydrates,
    //             'protein' => $request->protein,
    //             'sugar' => $request->sugar,
    //             'fiber' => $request->fiber,
    //             'sodium' => $request->sodium,
    //         ]);

    //         // ✅ Handle Image Uploads
    //         $productImages = new ProductImage();
    //         $productImages->product_id = $product->id;

    //         if ($request->hasFile('home_image_url')) {
    //             $homeImagePath = $request->file('home_image_url')->store('products', 'public');
    //             $productImages->home_image_url = $homeImagePath; // remove 'storage/'
    //         }

    //         if ($request->hasFile('detail_image_url')) {
    //             $detailImagePath = $request->file('detail_image_url')->store('products', 'public');
    //             $productImages->detail_image_url = $detailImagePath;
    //         }

    //         if ($request->hasFile('pack_image_url')) {
    //             $packImagePath = $request->file('pack_image_url')->store('products', 'public');
    //             $productImages->pack_image_url = $packImagePath;
    //         }

    //         $productImages->save();

    //         return redirect()->route('get-productmanagmentpage')->with('success', 'Product added successfully.');
    //     } catch (\Exception $e) {
    //         \Log::error('Product creation error: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
    //     }
    // }

    public function storeProduct(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'heading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'allergy_info' => 'nullable|string',
            'ingredients_tagline'=> 'nullable|string',
            'price' => 'required|numeric|min:0',
            'calories' => 'nullable|numeric',
            'fat' => 'nullable|numeric',
            'carbohydrates' => 'nullable|numeric',
            'protein' => 'nullable|numeric',
            'sugar' => 'nullable|numeric',
            'fiber' => 'nullable|numeric',
            'sodium' => 'nullable|numeric',
            'theme_color' => 'nullable|string',
            'home_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120', // 5MB
            'detail_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
            'pack_image_url' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        try {
            // Create a new product
            $product = Product::create([
                'name' => $request->name,
                'heading' => $request->heading,
                'description' => $request->description,
                'allergy_info' => $request->allergy_info,
                'price' => $request->price,
                'theme_color' => $request->theme_color,
                'ingredients_tagline'=> $request->ingredients_tagline
            ]);

            // Create a related nutrition entry
            $product->nutrition()->create([
                'calories' => $request->calories,
                'fat' => $request->fat,
                'carbohydrates' => $request->carbohydrates,
                'protein' => $request->protein,
                'sugar' => $request->sugar,
                'fiber' => $request->fiber,
                'sodium' => $request->sodium,
            ]);

            // ✅ Handle Image Uploads
            $uploadPath = public_path('assets/images/uploads');

            // Ensure the uploads folder exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $productImages = new ProductImage();
            $productImages->product_id = $product->id;

            if ($request->hasFile('home_image_url')) {
                $homeImage = $request->file('home_image_url');
                $homeImageName = time() . '_home.' . $homeImage->getClientOriginalExtension();
                $homeImage->move($uploadPath, $homeImageName);
                $productImages->home_image_url = 'images/uploads/' . $homeImageName;
            }

            if ($request->hasFile('detail_image_url')) {
                $detailImage = $request->file('detail_image_url');
                $detailImageName = time() . '_detail.' . $detailImage->getClientOriginalExtension();
                $detailImage->move($uploadPath, $detailImageName);
                $productImages->detail_image_url = 'images/uploads/' . $detailImageName;
            }

            if ($request->hasFile('pack_image_url')) {
                $packImage = $request->file('pack_image_url');
                $packImageName = time() . '_pack.' . $packImage->getClientOriginalExtension();
                $packImage->move($uploadPath, $packImageName);
                $productImages->pack_image_url = 'images/uploads/' . $packImageName;
            }

            $productImages->save();

            return redirect()->route('get-productmanagmentpage')->with('success', 'Product added successfully.');
        } catch (\Exception $e) {
            \Log::error('Product creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }



    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated nutrition data if exists
        if ($product->nutrition) {
            $product->nutrition->delete();
        }

        // Delete the product
        $product->delete();

        return redirect()->route('get-productmanagmentpage')->with('success', 'Product deleted successfully.');
    }
}
