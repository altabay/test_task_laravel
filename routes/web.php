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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Registration Routes...

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/upload/img', 'HomeController@uploadImage')->name('upload_img');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/posts', function () {
    $posts = TCG\Voyager\Models\Post::all();
    return view('posts.index', compact('posts'));
})->name('posts');;

Route::get('/posts/add', function (){
    if (Auth::check()) return view('posts.add_post');
    else  return redirect('/posts');
});

Route::get('post/{slug}', function($slug){
    $post =  TCG\Voyager\Models\Post::where('slug', '=', $slug)->firstOrFail();
    return view('posts.post', compact('post'));
});

Route::post('post/store', 'HomeController@storePost' )->name('store');