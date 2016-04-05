@extends('admin.layout')

@section('styles')
    <link href="http://staticlongyy/plugins/pickadate/lib/themes/default.css" rel="stylesheet">
    <link href="http://staticlongyy/plugins/pickadate/lib/themes/default.date.css" rel="stylesheet">
    <link href="http://staticlongyy/plugins/pickadate/lib/themes/default.time.css" rel="stylesheet">
    <link href="http://staticlongyy/plugins/selectize/dist/css/selectize.css" rel="stylesheet">
    <link href="http://staticlongyy/plugins/selectize/dist/css/selectize.bootstrap3.css" rel="stylesheet">
@stop

@section('content')
    <div class="container-fluid">

        <div class="row page-title-row">
            <div class="col-md-12">
                <h3>Posts <small>» Add New Post</small></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">New Post Form</h3>
                    </div>
                    <div class="panel-body">

                        @include('admin.partials.errors')

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.post.store') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @include('admin.post._form')

                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="col-md-10 col-md-offset-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fa fa-disk-o"></i>
                                            Save New Post
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('scripts')
    <script src="http://staticlongyy/plugins/pickadate/lib/picker.js"></script>
    <script src="http://staticlongyy/plugins/pickadate/lib/picker.date.js"></script>
    <script src="http://staticlongyy/plugins/pickadate/lib/picker.time.js"></script>
    <script src="http://staticlongyy/plugins/selectize/dist/js/standalone/selectize.min.js"></script>
    <script>
        $(function() {
            $("#publish_date").pickadate({
                format: "mmm-d-yyyy"
            });
            $("#publish_time").pickatime({
                format: "h:i A"
            });
            $("#tags").selectize({
                create: true
            });
        });
    </script>
@stop