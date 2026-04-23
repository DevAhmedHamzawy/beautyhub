<?php

namespace App\Observers;

use App\Models\FlashSale;
use Illuminate\Support\Facades\Cache;

class FlashSaleaObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(FlashSale $flashSale): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(FlashSale $flashSale): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(FlashSale $flashSale): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(FlashSale $flashSale): void
    {
        $this->clearCaches();
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(FlashSale $flashSale): void
    {
        $this->clearCaches();
    }

    private function clearCaches(): void
    {
        Cache::forget('flash_sales');
    }
}
