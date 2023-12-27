<?php

namespace App\Http\Livewire;
use App\Models\Cart;
use Livewire\Component;
use App\Models\Product;
class MenuCart extends Component
{
    public $total_price;

    public function delete($id)
    {
        Cart::find($id)->delete();
            return $this->products = Cart::where('user_id',auth()->id())->get();
    }
        public function render()
        {
            return view('livewire.menu-cart',[
            'products' => Cart::where('user_id',auth()->id())->get()
        ]);
    }
}
