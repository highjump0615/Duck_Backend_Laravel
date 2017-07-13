<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showCategory(Request $request) {
        $categories = Category::all();

        return view('product.category', [
            'categories'=>$categories,
        ]);
    }

    public function category_add(Request $request) {
        if($request->has('cat')){
            $id = $request->input('cat');
            $c = Category::find($id);

            return view('product.category_add', [
                'category'=>$c,
            ]);
        } else {
            return view('product.category_add');
        }

    }

    public function saveCategory(Request $request) {
        if($request->has('cat')) {
            $c = Category::find($request->input('cat'));
        } else {
            $c = new Category();
        }

        $c->name = $request->input('name');
        $c->desc = $request->input('desc');

        $c->save();

        return view('product.category_add', [
            'category'=>$c,
        ]);
    }
}
