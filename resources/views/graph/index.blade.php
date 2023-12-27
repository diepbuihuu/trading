@extends('layouts.app')
@section('content')
<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
<script src="/js/graph.js"></script>

<section class="page-wrapper success-msg">
    <input type="hidden" id="start" value="{{$start}}">
    <div class="">
        <div class="row">
            <div class="col-md-10">
                <div id="chart" class="block text-center">

                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary" id="m1">M1</button>
                <button type="button" class="btn btn-primary" id="m5">M5</button>
            </div>
        </div>
    </div>
</section><!-- /.page-warpper -->
@endsection
