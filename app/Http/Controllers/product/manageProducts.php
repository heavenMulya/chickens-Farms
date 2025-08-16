<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\JSONResponseResource;
use App\Http\Requests\productsRequest;
use App\Models\products;
use Illuminate\Support\Facades\Storage;


class manageProducts extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    try {
        $products = products::paginate(10);

        if (!$products) {
            return (new JSONResponseResource(false, 400, 'Products Data Not Available', null))->response();
        }

        // Transform the image path
        $products->getCollection()->transform(function ($product) {
            if ($product->image) {
                $product->image = asset('storage/' . $product->image);
            }
            return $product;
        });

        return (new JSONResponseResource(true, 201, 'Products Data Is Available', $products))->response();

    } catch (\Exception $e) {
        return (new JSONResponseResource(false, 500, 'Internal Server Error', null))->response();
    }
}


    /**
     * Store a newly created resource in storage.
     */
   public function store(productsRequest $request)
{
    try {
        // Check and store the image file
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null;
        }

   $products = products::create([
     'name' => $request->name,
      'price' => $request->price,
       'status' => $request->status,
        'Discount' => $request->discount,
         'image' => $imagePath,
    'Description' => $request->description,
    'batch_type' => $request->batch_type,
]);

        if (!$products) {
            return (new JSONResponseResource(false, 400, 'Product Not Saved Successfully', null))->response();
        }

        return (new JSONResponseResource(true, 200, 'Product Saved Successfully', $products))->response();

    } catch (\Exception $e) {
        return (new JSONResponseResource(false, 500, 'Internal Server Error: ' . $e->getMessage(), null))->response();
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            try
        {
      $productsExists=products::find($id);

      if(!$productsExists)
      {
        return (new JSONResponseResource(false,400,'Product ID Not Available',null))->response();

      }

      return (new JSONResponseResource(true,201,'Product Data Is  Available',$productsExists))->response();

        }

        catch(\Exception $e)
    {
        return (new JSONResponseResource(false,500,'Internal Server Error',null))->response();
    }
    }

    /**
     * Update the specified resource in storage.
     */
public function update(productsRequest $request, string $id)
{
    try {
        $product = products::find($id);
        if (!$product) {
            return (new JSONResponseResource(false, 404, 'Product not found', null))->response(); // Changed to 404
        }

        // Initialize image path with existing value
        $imagePath = $product->image;

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Store new image with unique name
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Update product data
        $updateData = [
            'name' => $request->name,
            'price' => $request->price,
            'Discount' => $request->discount,
            'status' => $request->status,
            'Description' => $request->description,
            'image' => $imagePath,
            'batch_type' => $request->batch_type,
        ];

        $updated = $product->update($updateData);

        if (!$updated) {
            return (new JSONResponseResource(false, 400, 'Product update failed', null))->response();
        }

        // Refresh the model to get updated attributes
        $product->refresh();

        return (new JSONResponseResource(true, 200, 'Product updated successfully', $product))->response();

    } catch (\Illuminate\Validation\ValidationException $e) {
        return (new JSONResponseResource(false, 422, 'Validation error', $e->errors()))->response();
    } catch (\Exception $e) {
       
        return (new JSONResponseResource(false, 500, 'Server error', null))->response();
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try
        {
      $productsExists=products::find($id);
      if(!$productsExists)
      {
        return (new JSONResponseResource(false,400,'Product ID Not Available',null))->response();

      }
      $products=$productsExists->delete();
      if(!$products)
      {
        return (new JSONResponseResource(false,400,'Product ID Not Deleted Successfully',null))->response();
      }
      return (new JSONResponseResource(true,201,'Product Data Deleted Successfully',null))->response();
        }
        catch(\Exception $e)
    {
        return (new JSONResponseResource(false,500,'Internal Server Error',null))->response();
    }
    }


   public function searching(Request $request)
{
    $perPage = $request->get('per_page', 10);

    $query = products::query();

    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where('name', 'like', "%{$search}%");
    }

    $products = $query->paginate($perPage);

    // 🔁 Transform image to full URL
    $products->getCollection()->transform(function ($product) {
        if ($product->image) {
            $product->image = asset('storage/' . $product->image);
        }
        return $product;
    });

    return response()->json([
        'data' => $products
    ]);
}

}
