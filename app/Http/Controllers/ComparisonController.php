<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    public function index(Request $request)
    {
        $allProducts = Product::with(['brand', 'variants'])->get();
        
        $product1 = null;
        $product2 = null;

        if ($request->has('p1') && $request->p1 != '') {
            $product1 = Product::with(['brand', 'category', 'scents', 'variants', 'images'])->find($request->p1);
        }
        
        if ($request->has('p2') && $request->p2 != '') {
            $product2 = Product::with(['brand', 'category', 'scents', 'variants', 'images'])->find($request->p2);
        }

        return view('storefront.comparison.index', compact('allProducts', 'product1', 'product2'));
    }
}
