@extends('layouts.app')

@section("content")
<div class="container" id="posts_el">
    <br><br>
    <div class="row"  >
        <div class="col-md-3" v-for="item in items" v-html="item">

        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        axios.get('{{url('/api/get/posts')}}')
            .then(function (response) {
                console.log(response);
                list = [];
                $.each(response.data.posts, function (key, value) {
                    list.push(value);
                });
                var example1 = new Vue({
                    el: '#posts_el',
                    data: {
                        items: list
                    }
                });
            })
            .catch(function (error) {
                console.log(error.message);
            });
    </script>
@endsection


