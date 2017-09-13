@extends('layouts.app')

@section("content")

    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form" action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
            <!-- PUT Method if we are editing -->
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-character"></i> Post Title
                                <span class="panel-desc"> The title for your post</span>
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="" required>
                        </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-book"></i> Post Content</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div id="app">
                            <textarea name="body" style="display: none"></textarea>
                            <div id="summernote"></div>
                        </div>
                    </div><!-- .panel -->


                    <!-- ### EXCERPT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Excerpt <small>Small description of this post</small></h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <textarea class="form-control" name="excerpt" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i> Post Details</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">URL slug</label>

                                <input type="text" class="form-control" id="slug" name="slug"
                                       placeholder="slug"
                                       >
                            </div>
                            <div class="form-group">
                                <label for="name">Post Status</label>
                                <select class="form-control" name="status">
                                    <option value="PUBLISHED" >published</option>
                                    <option value="DRAFT" >draft</option>
                                    <option value="PENDING">pending</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Post Category</label>
                                <select class="form-control" name="category_id">
                                    @foreach(TCG\Voyager\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Featured</label>
                                <input type="checkbox" name="featured">
                            </div>
                        </div>
                    </div>

                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Post Image</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <input type="file" name="image">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="name">Meta Description</label>
                            <textarea required class="form-control" name="meta_description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="name">Meta Keywords</label>
                            <textarea required class="form-control" name="meta_keywords"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="name">SEO Title</label>
                            <input type="text" class="form-control" name="seo_title" placeholder="SEO Title" value="">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right">
               <i class="icon wb-plus-circle"></i> Create New Post
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
    </div>
@endsection

@section('js')
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#summernote').summernote(
                {
                    callbacks: {
                        onChange:function() {
                            var content = $('textarea[name="body"]').text($('.note-editable').html());
                        },
                        onImageUpload: function(image) {
                            uploadImage(image[0]);
                        }
                    },
                    height: "500px"
                });
        });

        function uploadImage(image) {
            var data = new FormData();
            data.append("image",image);
            $.ajax ({
                data: data,
                type: "POST",
                url: "/upload/img",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    var image = data.name;
                    $('#summernote').summernote("insertImage", "/images/posts/"+image);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }


    </script>


@endsection



