<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        
        return response()->json([
            "status" => true,
            "message" => "Product List",
            "data" => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

      // Creatig Products
    public function store(Request $request)
    {
        $request_data = $request->all();
        
        $validator = Validator::make($request_data, [
            'name' => 'required',
            'mrp' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Inputs',
                'error' => $validator->errors()
            ]);
        }

        $product = Product::create($request_data);
        
        return response()->json([
            "status" => true,
            "message" => "Product created successfully.",
            "data" => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

      // Display Products
    public function show(Product $product)
    {
        if (is_null($product)) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Product found.",
            "data" => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Update Products
    public function update(Request $request, Product $product)
    {
        $request_data = $request->all();
        
        $validator = Validator::make($request_data, [
            'mrp' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Invalid Inputs',
                'error' => $validator->errors()
            ]);      
        }

        $product->name = $request_data['name'];
        $product->mrp = $request_data['mrp'];
        $product->price = $request_data['price'];
        $product->quantity = $request_data['quantity'];
        $product->save();
        
        return response()->json([
            "status" => true,
            "message" => "Product updated successfully.",
            "data" => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Delete Products
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            "status" => true,
            "message" => "Product deleted successfully.",
            "data" => $product
        ]);
    }
}