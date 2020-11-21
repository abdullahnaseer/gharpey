<?php

namespace App\Models;

use App\Helpers\UserApiTokenTrait;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//use Laravel\Passport\HasApiTokens;

class Buyer extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, UserApiTokenTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'address', 'location_id', 'password', 'api_token', 'banned_reason', 'banned_by_type', 'banned_by_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The api_token is used for ckeditor image upload.
     * All images uploaded by user will be uploaded against their account.
     *
     * @return void
     */
    public function setApiToken(): void
    {
        // api_token is used for ckeditor image upload.
        // All images uploaded by user will be uploaded against their account.

        // Better use a scheduled event to handle this
//        $user->tokens()->where('name', 'api_token')->delete();

        $this->update(['api_token' => $this->createToken('api_token')->plainTextToken]);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail('buyer'));
    }

    /**
     * Get the access tokens that belong to the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token, 'buyer'));
    }

    /**
     * Get the location that owns the resource.
     */
    public function location()
    {
        return $this->belongsTo(CityArea::class, 'location_id', 'id');
    }


    public function getCart()
    {
        return Cart::session(request()->session()->get('_token'))->getContent();
    }


    /**
     * Get the balance logs for the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id')
            ->where('user_type', Buyer::class);
    }

    /**
     * Get the balance logs for the user.
     */
    public function last_transaction()
    {
        return $this
            ->hasOne(Transaction::class, 'user_id', 'id')
            ->where('user_type', Buyer::class)
            ->orderByDesc('id');
    }

    /**
     * The wishlist buyer that belong to the product.
     */
    public function hasWish($productId)
    {
        return $this->wishlist_products()
                ->where('wishlist.product_id', $productId)
                ->count() > 0;
    }

    /**
     * The wishlist products that belong to the buyer.
     */
    public function wishlist_products()
    {
        return $this->belongsToMany(Product::class, 'wishlist')
            ->withTimestamps()
            ->using(Wishlist::class);
    }

    /**
     * Get the product orders for the buyer.
     */
    public function product_orders()
    {
        return $this->hasManyThrough(ProductOrder::class, Order::class);
    }

    /**
     * Get the service_requests for the buyer.
     */
    public function service_requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    /**
     * Get all of the buyer's tickets.
     */
    public function tickets()
    {
        return $this->morphMany(\App\Models\SupportTicket::class, 'user');
    }
}
