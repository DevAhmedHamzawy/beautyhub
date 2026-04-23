<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class OrderObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Order $order): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Order $order): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Order $order): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Order $order): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        $this->clearCaches();
    }

    private function clearCaches(): void
    {
        Cache::forget('top_selling');
        Cache::forget('weekly_top_selling');
    }
}
