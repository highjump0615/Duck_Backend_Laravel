<?php

namespace App\Http\Controllers;

use App\Category;
use App\Groupbuy;
use App\Model\ProductImages;
use App\Order;
use App\Product;
use App\ProductSpec;
use App\Spec;
use Illuminate\Http\Request;

use File;

class ProductController extends Controller
{
    public function showCategory(Request $request) {
        $categories = Category::orderBy('sequence')->get();

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

    /**
     * 打开商品列表页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProductList(Request $request) {
        $categories = Category::orderBy('sequence')->get();

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
     * @return string
     */
    public function saveProduct(Request $request) {
        if($request->has('product_id')) {
            $pid = $request->input('product_id');
            $p = Product::find($pid);

            // 删除图片
            $p->images()->delete();
        } else {
            $p = new Product();
        }

        // 缩略图
        if ($request->hasFile('thumbimage')) {
            $fileImage = $request->file('thumbimage');
            if ($fileImage->isValid()) {

                // create product photo directory, if not exist
                if (!file_exists(getProductImagePath())) {
                    File::makeDirectory(getProductImagePath(), 0777, true);
                }

                // generate file name p**********.ext
                $strName = 'p' . time() . uniqid() . '.' . $fileImage->getClientOriginalExtension();

                // move file to upload folder
                $fileImage->move(getProductImagePath(), $strName);

                $p->thumbnail = $strName;
            }
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

            if($request->has($param)) {
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

        return response()->json([
            'status' => 'success',
            'product_id' => $p->id,
        ]);
    }

    /**
     * 删除商品
     * @param Request $request
     */
    public function deleteProduct(Request $request) {
        $pid = $request->input('product_id');
        Product::find($pid)->delete();
    }

    /**
     * 删除分类
     * @param Request $request
     */
    public function deleteCategory(Request $request) {
        $cid = $request->input('id');
        Category::find($cid)->delete();
    }

    /**
     * 删除规格
     * @param Request $request
     */
    public function deleteRule(Request $request) {
        $rid = $request->input('id');
        Spec::find($rid)->delete();
    }

    /**
     * 上传图片
     * @param Request $request
     * @return string
     */
    public function uploadImage(Request $request) {

        $pId = $request->input('product_id');

        $files = $request->allFiles();
        foreach ($files as $fileImage) {
            if ($fileImage->isValid()) {
                // generate file name p**********.ext
                $strName = 'p' . time() . uniqid() . '.' . $fileImage->getClientOriginalExtension();

                // move file to upload folder
                $fileImage->move(getProductImagePath(), $strName);

                // 添加到数据库
                $aryParam = [
                    'product_id'    => $pId,
                    'url'           => $strName,
                ];

                ProductImages::create($aryParam);
            }
        }

        return response()->json([
            'jsonrpc' => '2.0',
            'result' => null,
            'id' => 'id',
        ]);
    }

    /**
     * 获取商品分类API
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoriesApi(Request $request) {
        $categories = Category::orderBy('sequence')->get(['id', 'name']);

        return response()->json([
            'status' => 'success',
            'result' => $categories,
        ]);
    }

    /**
     * 获取一种商品API
     * @param $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductsApi($categoryId) {
        $products = Product::where('category_id', $categoryId)
            ->get();

        $result = [];
        foreach ($products as $product) {
            $result[] = [
                'id'        => $product->id,
                'name'      => $product->name,
                'thumbnail' => $product->getThumbnailUrl(),
                'price'     => $product->price,
                'gb_price'  => $product->gb_price,
            ];
        }

        return response()->json([
            'status' => 'success',
            'result' => $result,
        ]);
    }

    /**
     * 获取商品详细内容
     * @param $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductDetailApi(Request $request, $productId) {
        $customerId =  $request->input('customer_id');

        $product = Product::with('images')
            ->with('specs')
            ->find($productId);

        // 获取拼团
        $groubBuys = Groupbuy::whereHas('orders', function($query) use ($productId, $customerId) {
            $query->where('product_id', $productId);
        })->get();

        $result = [
            'id'                => $product->id,
            'name'              => $product->name,
            'thumbnail'         => $product->getThumbnailUrl(),
            'price'             => $product->price,
            'price_deliver'     => $product->deliver_cost,
            'remain'            => $product->remain,
            'gb_count'          => $product->gb_count,
            'gb_price'          => $product->gb_price,
            'gb_timeout'        => $product->gb_timeout,
            'rtf_content'       => $product->rtf_content,
        ];

        // 规格
        $result['specs'] = [];
        foreach ($product->specs as $spec) {
            $result['specs'][] = [
                'id'        => $spec->id,
                'name'      => $spec->name,
            ];
        }

        // 图片
        $result['images'] = [];
        foreach ($product->images as $img) {
            $result['images'][] = $img->getImageUrl();
        }

        // 拼团
        $result['groupbuys'] = [];

        foreach ($groubBuys as $gb) {
            $bSkip = false;

            // 自己开启的除外
            $gOrders = $gb->orders;
            foreach ($gOrders as $go) {
                if ($go->customer_id == $customerId) {
                    $bSkip = true;
                    break;
                }
            }

            if ($bSkip) {
                continue;
            }

            $gbInfo = [
                'id' => $gb->id,
                'persons' => $gb->getPeopleCount(),
                'time_remain' => $gb->getRemainTime(),
            ];

            // 发起人
            $starter = $gOrders->first()->customer;
            $gbInfo['customer'] = [
                'name' => $starter->name,
                'image_url' => $starter->image_url,
            ];

            $result['groupbuys'][] = $gbInfo;
        }

        return response()->json([
            'status' => 'success',
            'result' => $result,
        ]);
    }

    /**
     * 设置分类顺序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCategoryOrder(Request $request) {
        $objectId =  $request->input('object_id');
        $targetId =  $request->input('target_id');

        $nSeq = 0;

        if ($targetId > 0) {
            $nSeq = Category::find($targetId)->sequence;
        }

        // 增加顺序值
        Category::where('sequence', '>', $nSeq)->increment('sequence', 1);

        // 设置新的顺序
        Category::where('id', $objectId)->update(['sequence' => $nSeq + 1]);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
