<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\WelcomeController::class,'welcome'] );
Route::get('/search/{item}',[\App\Http\Controllers\WelcomeController::class,'show_searched_items'])->name('show_searched_items');
Route::get('/category/{id}',[\App\Http\Controllers\WelcomeController::class,'show_searched_item_by_category'])->name('show_searched_item_by_category');
Route::get('/product/{name}',[\App\Http\Controllers\WelcomeController::class,'show_searched_item_by_name'])->name('show_searched_item_by_name');
Route::get('/show_product/{id}',[\App\Http\Controllers\WelcomeController::class,'show_single_product'])->name('single_product');

Route::get('/graph',[\App\Http\Controllers\GraphController::class, 'index']);
Route::get('/graph/data/{start}',[\App\Http\Controllers\GraphController::class, 'getDataForDate']);
Route::get('/graph/future_data/{start}',[\App\Http\Controllers\GraphController::class, 'getFutureDataForDate']);
Route::get('/graph/data',[\App\Http\Controllers\GraphController::class, 'getData']);
Route::get('/graph/manual/{start}',[\App\Http\Controllers\GraphController::class, 'manual']);
Route::get('/graph/manual',[\App\Http\Controllers\GraphController::class, 'chooseDate']);

Route::get('/strategy/{id}/graph/{start}/data',[\App\Http\Controllers\StrategyController::class, 'getData']);
Route::get('/strategy/{id}/graph/{start}',[\App\Http\Controllers\StrategyController::class, 'drawGraph']);
Route::get('/strategy/{id}/us',[\App\Http\Controllers\StrategyController::class, 'reportUS']);
Route::get('/strategy/{id}',[\App\Http\Controllers\StrategyController::class, 'index']);

Route::view('/thankYou','confirmation')->name('thanks_for_shoping');
Route::view('/addresses','addresses')->name('addresses');
Route::view('/order','orders')->name('order');
Route::view('/shop','shop')->name('shop');
Route::view('/checkout','checkout')->name('checkout');
Route::get('/about-us',[\App\Http\Controllers\WelcomeController::class,'about_us'])->name('about_us');
Route::view('/contact-us','contact_us')->name('contact_us');
Route::view('/privacy','privacy')->name('privacy');

Route::get('/faq',[\App\Http\Controllers\WelcomeController::class,'faq'])->name('faq');

/*
* Admin routes
*/
Route::middleware(['auth','checksuperadmin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::view('dashboard','admin.dashboard ')->name('admin.dashboard');
        Route::get('manage-category',App\Http\Livewire\Admin\Category::class)->name('admin.category');
        Route::get('manage-products',App\Http\Livewire\Admin\Product::class)->name('admin.products');
        Route::get('manage-orders',App\Http\Livewire\Admin\Orders::class)->name('admin.orders');
        Route::get('manage-FAQ',App\Http\Livewire\Admin\Faq::class)->name('admin.faq');
        Route::get('manage-customers',App\Http\Livewire\Admin\Users::class)->name('admin.users');
        Route::get('manage-subscribers',App\Http\Livewire\Admin\Subscribers::class)->name('admin.subscribers');
        Route::get('show-customer/{id}',[App\Http\Controllers\AdminHelperController::class,'showSingleCustomer'])->name('admin.user_details');
        Route::get('contactMessages',App\Http\Livewire\Admin\ContactedMessages::class)->name('admin.messages');
        Route::get('manage-about-us-page',[App\Http\Controllers\AdminHelperController::class,'manage_aboutUs_page'])->name('admin.aboutUs');
        Route::post('manage-about-us-page',[App\Http\Controllers\AdminHelperController::class,'store'])->name('admin.aboutUs');
        Route::post("upload_cke_image",[App\Http\Controllers\AdminHelperController::class,'uploadCKEImage'])->name('ckeditor.image-upload');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/add_to_cart/{id}',[\App\Http\Controllers\CartController::class,'store'])->name('add_product_to_cart');
    Route::view('/MyProfile','profile')->name('user_profile');
    Route::view('/MyCart','cart')->name('cart');
});

Route::get('/contact/developer',function (){
    return "contact developer";
})->name('contact_developer');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
