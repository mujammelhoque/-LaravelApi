<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    private $status     =   200;
    public function fristindex()
    {
        $items = Item::all();
        $name = [];
        $value = [];
        foreach ($items as $item) {
            array_push($name, $item->name);
            array_push($value, $item->value);
        }
        $storedata = array_combine($name, $value);
        // return view('/storeconfig.index', compact('storedata'));

        return response()->json($storedata);
        // return $this->sendResponse($products., 'data');
    }

    public function index()
    {
       $students       =       Item::all();
        if(count($students) > 0) {
            return response()->json(["status" => $this->status, "success" => true, "count" => count($students), "data" => $students]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no record found"]);
        }
    }

    // public function studentsListing() {
    //     $students       =       Item::all();
    //     if(count($students) > 0) {
    //         return response()->json(["status" => $this->status, "success" => true, "count" => count($students), "data" => $students]);
    //     }
    //     else {
    //         return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no record found"]);
    //     }
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function createIce(Request $request)
    {
        $validator          =       Validator::make($request->all(),
            [
                "name"        =>      "required",
                "value"         =>      "required",
               
            ]
        );

        // if validation fails
        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }

        $student_id             =       $request->id;
         $studentArray           =       array(
            "name"            =>      $request->name,
            "value"             =>      $request->value,
            
        );

        if($student_id !="") {           
            $student              =         Item::find($student_id);
            if(!is_null($student)){
                $updated_status     =       Item::where("id", $student_id)->update($studentArray);
                if($updated_status == 1) {
                    return response()->json(["status" => $this->status, "success" => true, "message" => "IceCream detail updated successfully"]);
                }
                else {
                    return response()->json(["status" => "failed", "message" => "Whoops! failed to update, try again."]);
                }               
            }                   
        }

        else {
            $student        =       Item::create($studentArray);
            if(!is_null($student)) {            
                return response()->json(["status" => $this->status, "success" => true, "message" => "student record created successfully", "data" => $student]);
            }    
            else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
            }
        }  
    } 


    public function IceDelete($id) {
        $student        =       Item::find($id);
        if(!is_null($student)) {
            $delete_status      =       Item::where("id", $id)->delete();
            if($delete_status == 1) {
                return response()->json(["status" => $this->status, "success" => true, "message" => "student record deleted successfully"]);
            }
            else{
                return response()->json(["status" => "failed", "message" => "failed to delete, please try again"]);
            }
        }
        else {
            return response()->json(["status" => "failed", "message" => "Whoops! no student found with this id"]);
        }
    }

   
    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $product = Product::find($id);
  
    //     if (is_null($product)) {
    //         return $this->sendError('Product not found.');
    //     }
   
    //     return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    // }
    
    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Product $product)
    // {
    //     $input = $request->all();
   
    //     $validator = Validator::make($input, [
    //         'name' => 'required',
    //         'detail' => 'required'
    //     ]);
   
    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());       
    //     }
   
    //     $product->name = $input['name'];
    //     $product->detail = $input['detail'];
    //     $product->save();
   
    //     return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    // }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $product)
    {
        $product->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');
    }


}
