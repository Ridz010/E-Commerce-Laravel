<?php

namespace App\Livewire;

use App\Models\Order;
use Stripe\Checkout\Session;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Stripe;

#[Title('Success - CosmoShop')]
class SuccessPage extends Component
{
    public $session_id;

    public function mount()
    {
        $this->session_id = request('session_id');
    }

    public function render()
    {
        $latest_order = Order::with('address')->where('user_id', auth()->user()->id)->latest()->first();

        if ($this->session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session_info = Session::retrieve($this->session_id);

            if ($session_info->payment_status == 'paid') {
                $latest_order->payment_status = 'paid';
                $latest_order->save();
            } else {
                $latest_order->payment_status = 'failed';
                $latest_order->save();
            }
        }

        return view('livewire.success-page', [
            'order' => $latest_order
        ]);
    }
}
