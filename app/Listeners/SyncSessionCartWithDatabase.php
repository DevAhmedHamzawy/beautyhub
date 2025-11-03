<?php

namespace App\Listeners;

use App\Models\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SyncSessionCartWithDatabase
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {

        $user = $event->user ?? null;

        if (!$user) {
            return;
        }

        $sessionCart = Session::get('cart', []);

        foreach ($sessionCart as $item) {
            Cart::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $item['product_id'],
                    'stock_id' => $item['stock_id'],
                ],
                [
                    'quantity' => DB::raw('quantity + ' . $item['quantity']),
                ]
            );
        }

        Session::forget('cart');
    }
}
