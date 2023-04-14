<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Product as ProductResource;
use App\Models\Product;
use Validator;
use Response;

class SearchController extends BaseController
{


    public function search(Request $request) {


        $search = request()->get('search');
        $price = request()->get('price');


      $products = Product::where('name', 'LIKE', "%{$search}%")
                 ->Where('price', 'LIKE', "%{$price}%" )->get();

                 if ($products->isNotEmpty()) {
                    return $this->handleResponse(ProductResource::collection($products), 'Products Retrieved.' );

                   }

       return $this->handleError('Product not found');

     }






}
