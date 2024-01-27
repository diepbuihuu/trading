@extends('layouts.app')
@section('content')

<script src="/js/dynamic_graph.js"></script>
<input type="hidden" id="start" value="{{$start}}">
<section class="page-wrapper success-msg">
    <input type="hidden" id="start" value="{{$start}}">
    <div class="">
        <div class="row">
            <div class="col-md-10">
                <div id="chart" class="block text-center">

                </div>
                <div id="orders">
                    <table class="table table-strip">
                        <thead>
                            <tr>
                                <th>
                                    Orders
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Stop Loss
                                </th>
                                <th>
                                    Take Profit
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Close Price
                                </th>
                                <th>
                                    Profit
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="m1">M1</button>
                    <button type="button" class="btn btn-primary" id="m5">M5</button>
                    <button type="button" class="btn btn-primary" id="m15">M15</button>
                    <button type="button" class="btn btn-primary" id="m60">H1</button>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="x1">X1</button>
                    <button type="button" class="btn btn-primary" id="x10">X10</button>
                    <button type="button" class="btn btn-primary" id="skip10">Skip 10</button>
                </div>
                <div class="form-group">
                    <table class="table">
                        <tr>
                            <td>
                                Price
                            </td>
                            <td>
                                <input id="price" type="text" class="form-control" size="4" value="" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                SL
                            </td>
                            <td>
                                <input id="sl" type="text" class="form-control" size="4" value="2">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                TP
                            </td>
                            <td>
                                <input id="tp" type="text" class="form-control" size="4" value="4">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-primary" id="buy">Buy</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" id="sell">Sell</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.page-warpper -->
@endsection
