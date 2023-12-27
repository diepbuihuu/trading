@extends('admin.layouts.app')
@section('admin-content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">{{ __("Dashboard") }}</h1>
                <hr>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body py-5">
                                <h3>
                                    <a class="small text-dark nav-link" href="{{ route("admin.products") }}">{{ "(".App\Models\Product::count().") ". __(" Products") }}
                                    </a>
                                    </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body py-5">
                                <h3>
                                    <a class="small text-dark nav-link" href="{{ route("admin.orders") }}">{{ "(".App\Models\Order::count().") ". __(" Orders") }}
                                    </a>
                                    </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body py-5">
                                <h3>
                                    <a class="small text-dark nav-link" href="{{ route("admin.users") }}">{{ "(".App\Models\User::count().") ". __(" Users") }}
                                    </a>
                                    </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body py-5">
                                <h3>
                                    <a class="small text-dark nav-link" href="{{ route("admin.messages") }}">{{ "(".App\Models\Contactus::count().") ". __(" Messages") }}
                                    </a>
                                    </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body py-5">
                                <h3>
                                    <a class="small text-dark nav-link" href="{{ route("admin.aboutUs") }}">{{ "(".App\Models\Subscriber::count().") ". __(" Subscribers") }}
                                    </a>
                                    </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

@endsection
