<?php

namespace App\Http\Livewire\Admin;

use App\Models\Subscriber;
use Livewire\Component;
use Livewire\WithPagination;

class Subscribers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public function delete($id)
    {
        subscriber::find($id)->delete();
    }
    public function render()
    {
        return view('livewire.admin.subscribers',[
            'subscriberss' => Subscriber::latest()->paginate(50),
        ])->layout('admin.layouts.wire_app');
    }
}
