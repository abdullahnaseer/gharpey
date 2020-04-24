<?php

namespace App\Observers;

use App\Models\ProductOrder;

class ProductOrderObserver
{
    /**
     * Handle the product order "created" event.
     *
     * @param ProductOrder $productOrder
     * @return void
     */
    public function created(ProductOrder $productOrder)
    {
        //
    }

    /**
     * Handle the product order "updated" event.
     *
     * @param ProductOrder $productOrder
     * @return void
     */
    public function updated(ProductOrder $productOrder)
    {
        //
    }

    /**
     * Handle the product order "deleted" event.
     *
     * @param ProductOrder $productOrder
     * @return void
     */
    public function deleted(ProductOrder $productOrder)
    {
        //
    }

    /**
     * Handle the product order "restored" event.
     *
     * @param ProductOrder $productOrder
     * @return void
     */
    public function restored(ProductOrder $productOrder)
    {
        //
    }

    /**
     * Handle the product order "force deleted" event.
     *
     * @param ProductOrder $productOrder
     * @return void
     */
    public function forceDeleted(ProductOrder $productOrder)
    {
        //
    }
}
