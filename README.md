
## ** Routes **


'api.php' - have 4 routes defined. 
 
 Resource route 'products' which includes 4 available methods (index(), show(), update() and destroy()). This route is pointing to the ProductController;

 Routes 'login' and 'register' these a post routes and both of them are pointing to the AuthController where I have defined two methods 'login()' and 'register()'.

 Route product/search which is GET route and pointing to the SearchController and we have only one method inside which is the search() method searching in the Products Table by 'name' and 'price'.

 The resource routes are protected with the middleware('auth:sanctum') and are available only for authenticated users.
 


## Controllers 

I have created 4 Controllers in total. 
'BaseController' - which contains 2 methods inside 'handleResponse' which accept 2 parameters and its showing the data from the response together with the status message for success. The second method in this controller is 'handleError' which is handling the errors from the response.


'BaseController' is extended by all 3 other controllers(ProductController, SearchController, AuthController) and both methods mention above are used in each and every controller to handle the success and error responses.

'AuthController' is having only 2 methods 'register' and 'login' for login and register users

'SearchController' is having only one method which is 'search'and in this method I am using the eloquent model to search in the Products table by 'name' and 'price'. If the query is not empty the method is returning handleResponse with the class 'ProductResource::collection'. 

Errors are handle by 'handleError' which is coming from the BaseController.

Laravel's resource classes allow us to expressively and easily transform our models and collections of our into JSON

In  case where you are returning a collection of resources or you are returning a paginated response, you can use the collection method when creating the resource instance in your controller.

'ProductController' its handling the resource routes. In all the methods responses are handle by the methods inherit from the BaseController 'handleResponse' and 'handleError'. There are validations for the required fields in the 'create()' and 'update()' methods.

## Database - Migrations

For the testing purposes I create Product Model with the migration for the Products Table which contains 7 columns: 

ID, NAME, DESCRIPTION, PRICE, IS_FOR_SALE(yes, no), and the timestamps(created_at, updated_at)

# Handling Exceptions

Exceptions are handled by 'Handler.php' 
I have created a file 'ExceptionTrait.php' and I am using this trait inside the the 'Hanlder.php' Handler class.

Inside the Handler Class there is a function render() which is accepting 2 parameters : $request - the request and the exception $exception and Throwable interface which is the base interface for any object that can be thrown via a throw statement in PHP, including Error and Exception.

Inside the function render() I am checking if the request is expecting JSON I am returning the method from the ExceptionTrait  '$this->apiException($request, $exception)' which accepts 2 parameters the $request and the $exception. 

'apiException' is defined in the the 'ExceptionTrait.php' together with 2 other methods isModel($e) and isHttp($e) and both of them are accepting one parameter which is the excpetion that is coming from the render() function in the 'Handler.php' file. 

In case the exception is an instance of a ModelNotFound which I am checking this into the isModel() method I am calling this method inside the apiException() function with error and relevant status code. The same is for the isHttp() method. If the exception is an instance NotFoundHttpException the method isHttp() is showing relevant message with status code.  

## Testing

All the routes with the exceptions , errors and validations are tested with POSTMAN. 

## Seting up the environment on local machine
1.Clone
2. cd into the main folder where the files are
3.run composer install
4.cp .env.example .env
5.php artisan key:generate
6.run php artisan serve
7.make the relevant changes for the database into the .env file
8.run php artisan migrate


