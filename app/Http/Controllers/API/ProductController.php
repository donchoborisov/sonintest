<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;
use Validator;


class ProductController extends BaseController
{

    public function index() {

        $products = Product::all();
        return $this->handleResponse(ProductResource::collection($products), 'Products has been retrieved');
    }


    public function store(Request $request) {

        $input = $request->all();
        $validator = Validator::make($input, [

            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',


        ]);

        if($validator->fails()) {
            return $this->handleError($validator->errors());
        }

        $product = Product::create($input);
        return $this->handleResponse(new ProductResource($product), 'Product created!');



    }


    public function show($id) {

        $product = Product::find($id);
        if (is_null($product)) {

            return $this->handleError('Product not found');
        }

        return $this->handleResponse(new ProductResource($product), 'Product Retrieved.' );
    }


    public function update(Request $request, Product $product) {

        $input = $request->all();
        $validator = Validator::make($input, [
              'name' => 'required',
              'description' => 'required',
              'price' => 'required|numeric',
              'is_for_sale' => 'required|in:yes,no',
        ]);

        if($validator->fails()){
           return $this->handleError($validator->errors());
        }

        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->is_for_sale = $input['is_for_sale'] ;


        $product->save();

        return $this->handleResponse(new ProductResource($product), 'Product Successfully updated!');

    }


    public function destroy(Product $product) {

        $product->delete();
        return $this->handleResponse([], 'Task Deleted');

    }





}
