<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function add_to_cart(Request $request) {
        $quentity=$request->qty;
        $define_product=$request->product_id;
       $product_info = DB::table('tbl_products')
               ->where('product_id',$define_product)
               ->first();
       $data['qty']=$quentity;
       $data['id']=$product_info->product_id;
       $data['name']=$product_info->product_name;
       $data['price']=$product_info->product_price;
       $data['attributes']['image']=$product_info->product_image;
       
       Cart::add($data);
       return Redirect::to('/show-cart');
    }
    
    public function show_cart() {
        $all_published_category=DB::table('tbl_category')
                ->where('publication_status',1)
                ->get();
        $manage_published_category = view('pages.add_to_cart')
                ->with('all_published_category', $all_published_category);
        return view('layout')
                        ->with('pages.add_to_cart', $manage_published_category);
    }
}
