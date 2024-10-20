<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product', compact('product'));
    }

    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name_product');
        $order = $request->get('order', 'asc');
        $category = $request->get('category');

        $query = Product::query();

        if ($category) {
            $query->where('id_category', $category);
        }

        $products = $query->orderBy($sort, $order)->get();

        $categories = \App\Models\Category::all();

        return view('products', compact('products', 'categories'));
    }
}


