@extends('layouts.app')
@section('content')

<input type="hidden" id="start" value="{{$start}}">
<section class="page-wrapper success-msg">

    <div class="max-width-400">
        <div class="col-xs-6">
            <div class="form-group">
                <input type="text" id="day" value="{{$start}}" class="form-control datepicker">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <input type="text" id="hour" value="20" class="form-control">
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <input type="button" id="submit" value="Submit" class="btn btn-default">
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <script>
    $(document).ready(function(){
        $('#submit').click(function() {
            var timestamp = new Date($('#day').val()).setHours($('#hour').val());
            window.open('/graph/manual/' + timestamp / 1000);
        });
    });
    </script>


</section><!-- /.page-warpper -->
@endsection
