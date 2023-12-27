<?php

namespace App\Http\Livewire\UserDashboard;
use App\Models\Order;
use Livewire\Component;

class Orders extends Component
{
    public function render()
    {
        return view('livewire.user-dashboard.orders',[
            'products' => Order::where('user_id',auth()->id())->get()
        ]);
    }
}
