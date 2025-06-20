<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\JSONResponseResource;
use App\Http\Requests\productsRequest;
use App\Models\products;

class manageProducts extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         try
        {
      $products=products::paginate(5);
      if(!$products)
      {
        return (new JSONResponseResource(false,400,'products Data Not Available',null))->response();

      }
      return (new JSONResponseResource(true,201,'products Data Is  Available',$products))->response();
        }
        catch(\Exception $e)
    {
        return (new JSONResponseResource(false,500,'Internal Server Error',null))->response();
    }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(productsRequest $request)
    {
             try
        {
          
      $products= rooms::create([
        'name'=>$request->name,
        'weight_range'=>$request->weight_range,
        'unit_price'=>$request->unit_price,
        'total_price'=>$request->total_price,
      ]);

      if(!$products)
      {
        return ( new JSONResponseResource(false,400,'Rooms Data Not Saved Successfully',null))->response();
      }
      return (new JSONResponseResource(true,200,'Rooms Data Saved Successfully',$products))->response();
    }
    catch(\Exception $e)
    {
        return (new JSONResponseResource(false,500,'Internal Server Error'.$e,null))->response();
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
        return (new JSONResponseResource(false,400,'Rooms ID Not Available',null))->response();

      }

      return (new JSONResponseResource(true,201,'Rooms Data Is  Available',$productsExists))->response();

        }

        catch(\Exception $e)
    {
        return (new JSONResponseResource(false,500,'Internal Server Error',null))->response();
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
               try
        {
            $productsExists=products::find($id);
            if(!$productsExists)
            {
              return (new JSONResponseResource(false,400,'Rooms ID Not Available',null))->response();
      
            }

        $products= $productsExists->update([
        'name'=>$request->name,
        'weight_range'=>$request->weight_range,
        'unit_price'=>$request->unit_price,
        'total_price'=>$request->total_price,
      ]);
     // $roomsExists=rooms::find($id);

      if(!$products)
      {
        return ( new JSONResponseResource(false,400,'Rooms Data Not Updated Successfully',null))->response();
      }
      return (new JSONResponseResource(true,200,'Rooms Data Updated Successfully',$productsExists))->response();
    }
    catch(\Exception $e)
    {
        return (new JSONResponseResource(false,500,'Internal Server Error'.$e,null))->response();
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
        return (new JSONResponseResource(false,400,'Rooms ID Not Available',null))->response();

      }
      $products=$productsExists->delete();
      if(!$products)
      {
        return (new JSONResponseResource(false,400,'Rooms ID Not Deleted Successfully',null))->response();
      }
      return (new JSONResponseResource(true,201,'Rooms Data Deleted Successfully',null))->response();
        }
        catch(\Exception $e)
    {
        return (new JSONResponseResource(false,500,'Internal Server Error',null))->response();
    }
    }
}
