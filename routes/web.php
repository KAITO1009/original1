<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", "UsersController@index")->name("/");

//新規登録
Route::get("signup", "Auth\RegisterController@showRegistrationForm")->name("signup.get");
Route::post("signup", "Auth\RegisterController@register")->name("signup.post");

//ログイン
Route::get("login", "Auth\LoginController@showLoginForm")->name("login");
Route::post("login", "Auth\LoginController@login")->name("login.post");
Route::get("logout", "Auth\LoginController@logout")->name("logout.get");

//ログイン後
Route::group(["middleware" => ["auth"]], function(){
    Route::get("top", "ImgPostsController@index")->name("top");
    Route::resource("users", "UsersController" , ["only" => ["show"]]);
    Route::resource("book_posts", "BookPostsController", ["only" => ["index", "show", "create", "store", "destroy"]]);
    Route::resource("img_posts", "ImgPostsController", ["only" => ["show", "create", "store", "destroy"]]);
    
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post("offer", "UserOfferController@offer")->name("offer");
        Route::delete("refuse", "UserOfferController@refuse")->name("refuse");
        Route::post("agree", "UserOfferController@agree")->name("agree");
    });
    
    Route::get("chat/{roomid}/{me}/{you}", "UserOfferController@chat")->name("chat");
});