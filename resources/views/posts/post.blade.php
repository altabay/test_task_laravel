@extends('layouts.app')

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" id="app2">
                <h1 v-html="post_title"></h1>
                <img v-bind:src="img_src" style="width:100%">
                <p v-html="body"></p>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var app = new Vue({
            el: '#app2',
            data: {
                post_title: '{{ $post->title }}',
                img_src: '{{ Voyager::image( $post->image ) }}',
                body: '{!! $post->body !!}'
            }
        })
    </script>
@endsection


