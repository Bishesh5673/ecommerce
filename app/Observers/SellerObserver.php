<?php

namespace App\Observers;

use App\Mail\SellerApproved;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SellerObserver
{
    /**
     * Handle the Seller "created" event.
     */
    public function created(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "updated" event.
     */
    public function updated(Seller $seller): void
    {
        if($seller->isDirty('status') && $seller->status == 1){
            $password = rand(1000,9999);
            $seller->password = Hash::make($password);
            $seller->saveQuietly();
            $data=[
                'email' => $seller->email,
                'password' => $password
            ];
            Mail::to($seller->email)->send(new SellerApproved($data));
        }
    }

    /**
     * Handle the Seller "deleted" event.
     */
    public function deleted(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "restored" event.
     */
    public function restored(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "force deleted" event.
     */
    public function forceDeleted(Seller $seller): void
    {
        //
    }
}
