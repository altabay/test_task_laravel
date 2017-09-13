<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get/posts', function () {
    $posts = TCG\Voyager\Models\Post::all();
    $postHtmlArray = [];
    foreach ($posts as $post) {
        $image = Voyager::image($post->image);
        $postHtmlArray[] = "<a href='/post/$post->slug '><img src='$image' style='width:100%'><span>$post->title</span></a>";
    }
    return response()->json(['posts' => $postHtmlArray]);
});