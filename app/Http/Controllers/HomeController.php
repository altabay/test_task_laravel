<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\Post;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function uploadImage()
    {

        if (Auth::check() && Auth::user()->role_id == 1) {
            $path = '/images/posts/';
            $arrayEx = explode('.', $_FILES['image']['name']);
            $ext = array_pop($arrayEx);
            $new_name = time() . '.' . $ext;
            $full_path = public_path() . $path . $new_name;

            if ($_FILES['image']['error'] == 0) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $full_path)) {
                    return response()->json(["name" => $new_name]);
                }
            }
        }

        return response()->json(["error" => "some error"]);
    }
    public function getSlug(Request $request)
    {
        if (isset($this->slug)) {
            $slug = $this->slug;
        } else {
            $slug = explode('.', $request->route()->getName())[1];
        }

        return $slug;
    }

    public function storePost(Request $request)
    {
        if (Auth::check()) {
            $data = $request->all();

            $post = Post::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'excerpt' => $data['excerpt'],
                'slug' => $data['slug'],
                'meta_description' => $data['meta_description'],
                'meta_keywords' => $data['meta_keywords'],
                'seo_title' => $data['seo_title'],
                'author_id' => Auth::id()
            ]);

            if (isset($post->id)) {
                return redirect()
                    ->route("posts")
                    ->with([
                        'message' => "Successfully Added New post",
                        'alert-type' => 'success',
                    ]);
            } else {
                return redirect()
                    ->route("posts")
                    ->with([
                        'message' => "Some Error",
                        'alert-type' => 'error',
                    ]);
            }

        }
    }
}
