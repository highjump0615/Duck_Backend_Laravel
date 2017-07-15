<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductSpec;
use App\Spec;
use Illuminate\Http\Request;

use File;

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

    /**
     * 添加规格
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

        return response()->json([
            'rule' => $spec->id,
        ]);
    }

    /**
     * 保存商品
     * @param Request $request
     */
    public function saveProduct(Request $request) {
        if($request->has('product_id')) {
            $pid = $request->input('product_id');
            $p = Product::find($pid);
        } else {
            $p = new Product();
        }

        // 缩略图
        $strName = null;
        if ($request->hasFile('thumbimage')) {
            $fileImage = $request->file('thumbimage');
            if ($fileImage->isValid()) {

                // create user photo directory, if not exist
                if (!file_exists(getProductImagePath())) {
                    File::makeDirectory(getProductImagePath(), 0777, true);
                }

                // generate file name i**********.ext
                $strName = 'p' . time() . uniqid() . '.' . $fileImage->getClientOriginalExtension();

                // move file to upload folder
                $fileImage->move(getProductImagePath(), $strName);
            }
        }

        $p->name = $request->input('name');
        $p->category_id = $request->input('category_id');
        $p->thumbnail = $strName;
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
                $has = ProductSpec::where('spec_id', $s->id)->where('product_id', $p->id)->first();

                if($has == null) {
                    $ps = new ProductSpec();
                    $ps->spec_id = $s->id;
                    $ps->product_id = $p->id;
                    $ps->save();
                }
            } else {
                $has = ProductSpec::where('spec_id', $s->id)->where('product_id', $p->id)->first();

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

    /**
     * 上传图片
     * @param Request $request
     * @return string
     */
    public function uploadImage(Request $request) {
        $files = $request->allFiles();

        return response()->json([
            'jsonrpc' => '2.0',
            'result' => null,
            'id' => 'id',
        ]);
    }
}
