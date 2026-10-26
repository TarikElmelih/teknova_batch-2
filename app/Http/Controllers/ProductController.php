<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id)
    {


    return $id ;

    }

    // public function create(){

    // }

    public function store(Request $request){

    Product::create([
        "name" => $request->name,
        "price" => $request->price
    ]);
    $added_product = Product::latest()->first();
    
    
    return response()->json($added_product);
    }

    public function update($id, Request $request){
        
        Product::update();

    }

    public function AddToCart(){
        $user = User::find(1);
        $user->products()->attach([1,2]);
    }

    
}
