<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductSpec;
use App\Spec;
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
    
    public function showProductList(Request $request) {
        $categories = Category::all();

        if($request->has('cat')) {
            $c = Category::find($request->input('cat'));
            $products = $c->products;

            return view('product.list', [
                'categories'=>$categories,
                'products'=>$products,
                'category'=>$c,
            ]);
        } else {
            $products = Product::all();

            return view('product.list', [
                'categories' => $categories,
                'products' => $products,
            ]);
        }

    }

    public function showProduct(Request $request, $id = null) {
        $categories = Category::all();
        $specs = Spec::all();
        if($id == null) {
            return view('product.detail', [
                'categories'=>$categories,
                'specs'=>$specs,
                'valid_specs'=>'',
            ]);
        } else {
            $product = Product::find($id);

            $vs = ProductSpec::where('product_id', $id)->get();
            $str_valid_specs = "|";
            foreach($vs as $v) {
                $str_valid_specs .= $v."|";
            }
            return view('product.detail', [
                'categories'=>$categories,
                'product'=>$product,
                'specs'=>$specs,
                'valid_specs'=>$str_valid_specs,
            ]);
        }
    }

    public function addRule(Request $request) {
        $name = $request->input('name');

        $exist = Spec::where('name', $name)->get()->first();

        if($exist == null) {
            $spec = new Spec();
            $spec->name = $name;
            $spec->save();
        } else {
            abort(409);
        }


    }

    public function saveProduct(Request $request) {
        if($request->has('product_id')) {
            $pid = $request->input('product_id');
            $p = Product::find($pid);
        } else {
            $p = new Product();
        }

        $p->name = $request->input('name');
        $p->category_id = $request->input('category_id');
        $p->price = $request->input('price');
        $p->deliver_cost = $request->input('deliver_cost');
        $p->remain = $request->input('remain');
        $p->gb_count = $request->input('gb_count');
        $p->gb_price = $request->input('gb_price');
        $p->gb_timeout = $request->input('gb_timeout');
        $p->rtf_content = $request->input('rtf_content');
        $p->save();

        $specs = Spec::all();

        foreach($specs as $s) {
            $param = "spec".$s->id;
            echo $param;
            if($request->has($param)) {
                echo "has param";
                $has = ProductSpec::where('spec_id', $s->id)->where('product_id', $p->id)->get()->first();

                if($has == null) {
                    $ps = new ProductSpec();
                    $ps->spec_id = $s->id;
                    $ps->product_id = $p->id;
                    $ps->save();
                }
            } else {
                $has = ProductSpec::where('spec_id', $s->id)->where('product_id', $p->id)->get()->first();

                if($has != null) {
                    $has->delete();
                }
            }
        }


    }

    public function deleteProduct(Request $request) {
        $pid = $request->input('product_id');
        $p = Product::find($pid);
        $p->delete();
    }
}
