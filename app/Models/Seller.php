<?php

namespace App\Models;

use App\Models\Interfaces\MustVerifyPhone as MustVerifyPhoneContract;
use App\Models\Traits\MustVerifyPhone;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable implements MustVerifyEmail, MustVerifyPhoneContract
{
    use Notifiable, MustVerifyPhone;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'cnic', 'password',
        'shop_name', 'shop_slug', 'shop_image',
        'warehouse_location_id', 'warehouse_address',
        'business_location_id', 'business_address',
        'return_location_id', 'return_address',
        'approved_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'approved_at' => 'datetime'
    ];

    public function hasWarehouseAddress()
    {
        return ! is_null($this->warehouse_location_id) && ! is_null($this->warehouse_address);
    }

    public function hasBusinessAddress()
    {
        return ! is_null($this->business_location_id) && ! is_null($this->business_address);
    }

    public function hasReturnAddress()
    {
        return ! is_null($this->return_location_id) && ! is_null($this->return_address);
    }

    public function hasAddress()
    {
        return ($this->hasWarehouseAddress() &&
                $this->hasReturnAddress() &&
                $this->hasBusinessAddress());
    }

    public function hasPhone()
    {
        return ! is_null($this->phone);
    }

    public function isApproved()
    {
        return ! is_null($this->approved_at);
    }

    /**
     * Mark the given user's account as approved.
     *
     * @return bool
     */
    public function approveAccount()
    {
        return $this->forceFill([
            'approved_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function phoneVerifyCode()
    {
        $code = random_int(10000, 99999);

        $this->forceFill([
            'verification_code' => $code
        ])->save();

        return $code;
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail('seller'));
    }

    /**
     * Route notifications for the Nexmo channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return $this->getPhoneForVerification();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, 'seller'));
    }

    /**
     * Get the location that owns the Seller.
     */
    public function business_location()
    {
        return $this->belongsTo(CityArea::class, 'business_location_id', 'id');
    }

    /**
     * Get the location that owns the Seller.
     */
    public function warehouse_location()
    {
        return $this->belongsTo(CityArea::class, 'warehouse_location_id', 'id');
    }

    /**
     * Get the location that owns the Seller.
     */
    public function return_location()
    {
        return $this->belongsTo(CityArea::class, 'return_location_id', 'id');
    }

    /**
     * Get the products for the seller.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'id');
    }

    /**
     * Get the products for the seller.
     */
    public function product_orders()
    {
        return $this->hasManyThrough(ProductOrder::class, Product::class);
    }

    /**
     * The services that belong to the seller.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class,
            'service_seller',
            'seller_id',
            'service_id')
            ->using(ServiceSeller::class);
    }

    /**
     * Get the balance logs for the user.
     */
    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class, 'user_id', 'id')
            ->where('user_type', Seller::class);
    }

    /**
     * Get the balance logs for the user.
     */
    public function last_transaction()
    {
        return $this
            ->hasOne(\App\Models\Transaction::class, 'user_id', 'id')
            ->where('user_type', Seller::class)
            ->orderByDesc('id');
    }
}
