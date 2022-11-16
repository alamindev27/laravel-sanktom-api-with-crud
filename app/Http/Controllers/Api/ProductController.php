<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Validator;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();

        return $this->sendResponse(ProductResource::collection($products), 'All Products here');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required | string',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }
        $product = Product::create($request->all());
        return $this->sendResponse(new ProductResource($product), 'Product Added Successfully');
    }


    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product Not Found');
        }
        return $this->sendResponse(new ProductResource($product), 'product retrive');
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required | string',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }
        $product->update($request->all());
        return $this->sendResponse(new ProductResource($product), 'product updated');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse(new ProductResource($product), 'product deleted');
    }
}
