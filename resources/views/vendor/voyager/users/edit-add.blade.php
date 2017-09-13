@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/custom.css') !!}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> @if(isset($dataTypeContent->id)){{ 'Edit' }}@else{{ 'New' }}@endif {{ $dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <h3 class="panel-title">@if(isset($dataTypeContent->id)){{ 'Edit' }}@else{{ 'Add New' }}@endif {{ $dataType->display_name_singular }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-edit-add" role="form"
                          action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
                          method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control" name="first_name"
                                    placeholder="First Name" id="first_name"
                                    value="@if(isset($dataTypeContent->first_name)){{ old('first_name', $dataTypeContent->first_name) }}@else{{old('first_name')}}@endif">
                            </div>
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control" name="last_name"
                                       placeholder="Last Name" id="last_name"
                                       value="@if(isset($dataTypeContent->last_name)){{ old('last_name', $dataTypeContent->last_name) }}@else{{old('last_name')}}@endif">
                            </div>

                            <div class="form-group{{ $errors->has('timezone') ? ' has-error' : '' }}">
                                <label for="timezone" class="col-md-4 control-label">Select timezone</label>
                                    <select id="timezone" class="form-control" name="timezone"  required>
                                        <?php $timezonelist = \App\UserVoyager::TimeZone(); ?>
                                        @foreach($timezonelist as $timezone)
                                            <option value="{{ $timezone}}"
                                            @if($dataTypeContent->timezone() === $timezone){{ "selected" }} @endif
                                            >   {{ $timezone }} </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('timezone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('timezone') }}</strong>
                                    </span>
                                    @endif
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" name="email"
                                       placeholder="Email" id="email"
                                       value="@if(isset($dataTypeContent->email)){{ old('email', $dataTypeContent->email) }}@else{{old('email')}}@endif">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                @if(isset($dataTypeContent->password))
                                    <br>
                                    <small>Leave empty to keep the same</small>
                                @endif
                                <input type="password" class="form-control" name="password"
                                       placeholder="Password" id="password"
                                       value="">
                            </div>

                            <div class="form-group">
                                <label for="password">Avatar</label>
                                @if(isset($dataTypeContent->avatar))
                                    <img src="{{ Voyager::image( $dataTypeContent->avatar ) }}"
                                         style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                @endif
                                <input type="file" name="avatar">
                            </div>

                            <div class="form-group">
                                <label for="role">User Role</label>
                                <select name="role_id" id="role" class="form-control">
                                    <?php $roles = TCG\Voyager\Models\Role::all(); ?>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if(isset($dataTypeContent) && $dataTypeContent->role_id == $role->id) selected @endif>{{$role->display_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });

    </script>
    <script src="{{ voyager_asset('lib/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ voyager_asset('js/voyager_tinymce.js') }}"></script>
@stop
