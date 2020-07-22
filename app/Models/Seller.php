<?php

namespace App\Models;

use App\Models\Interfaces\MustVerifyPhoneInterface as MustVerifyPhoneContract;
use App\Models\Traits\MustVerifyPhoneTrait;
use App\Models\Traits\UserApiTokenTrait;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Authenticatable implements MustVerifyEmail, MustVerifyPhoneContract
{
    use HasApiTokens, Notifiable, MustVerifyPhoneTrait, UserApiTokenTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'cnic', 'password',
        'avatar',
        'shop_name', 'shop_slug', 'shop_image',
        'warehouse_location_id', 'warehouse_address',
        'business_location_id', 'business_address',
        'return_location_id', 'return_address',
        'approved_at', 'api_token',
        'banned_reason', 'banned_by_type', 'banned_by_id',
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
        'phone_verified_at' => 'datetime',
        'approved_at' => 'datetime'
    ];


    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getWithdrawAbleAmountAttribute()
    {
        $total_withdrawn = (int) $this->withdraws()->sum('amount');
        $total_fees = (int) $this->withdraws()->sum('fee');

        return (int) $this->transactions()
            ->where('user_type', Seller::class)
            ->where('created_at', '<=', Carbon::today()->subDays(15)->toDateTimeString())
            ->where(function ($query){
                $query->where('reference_type', ProductOrder::class)
                    ->orWhere('reference_type', ServiceRequest::class);
            })->sum('amount') - $total_withdrawn - $total_fees;
    }

    public function hasAddress()
    {
        return ($this->hasWarehouseAddress() &&
            $this->hasReturnAddress() &&
            $this->hasBusinessAddress());
    }

    public function hasWarehouseAddress()
    {
        return !is_null($this->warehouse_location_id) && !is_null($this->warehouse_address);
    }

    public function hasReturnAddress()
    {
        return !is_null($this->return_location_id) && !is_null($this->return_address);
    }

    public function hasBusinessAddress()
    {
        return !is_null($this->business_location_id) && !is_null($this->business_address);
    }

    public function hasPhone()
    {
        return !is_null($this->phone);
    }

    public function isApproved()
    {
        return !is_null($this->approved_at);
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
     * @param Notification $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return $this->getPhoneForVerification();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
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
     * Get the reviews for products by seller.
     */
    public function product_reviews()
    {
        return $this->hasManyThrough(ProductReview::class, Product::class);
    }

    /**
     * Get the reviews count for products by seller.
     */
    public function getProductReviewsCountAttribute()
    {
        return $this->product_reviews()->count();
    }

    /**
     * Get the reviews average rating for products by seller.
     */
    public function getProductReviewsAverageAttribute()
    {
        return $this->product_reviews()->average('rating');
    }

    /**
     * Get the reviews average rating for seller.
     */
    public function getReviewsAverageAttribute()
    {
        $reviews = $this->service_reviews()->get();
        $reviews = $reviews->merge($this->product_reviews()->get());

        return $reviews->average('rating');
    }

    /**
     * Get the reviews average rating for seller.
     */
    public function getReviewsCountAttribute()
    {
        return ($this->product_reviews()->average('rating') + $this->service_reviews()->average('rating'));
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
            ->withPivot('id', 'short_description', 'long_description', 'price', 'featured_image')
            ->using(ServiceSeller::class);
    }

    /**
     * The withdraws that belong to the seller.
     */
    public function payment_detail()
    {
        return $this->hasOne(SellerPaymentDetail::class, 'seller_id', 'id');
    }

    /**
     * The withdraws that belong to the seller.
     */
    public function withdraws()
    {
        return $this->hasMany(SellerWithdraw::class, 'seller_id', 'id');
    }

    /**
     * The services that belong to the seller.
     */
    public function seller_services()
    {
        return $this->hasMany(Service::class, 'service_id', 'id');
    }

    /**
     * The services that belong to the seller.
     */
    public function service_sellers()
    {
        return $this->hasMany(ServiceSeller::class, 'seller_id', 'id');
    }

    /**
     * Get the service requests for the seller.
     */
    public function service_requests()
    {
        return $this->hasMany(ServiceRequest::class, 'seller_id', 'id');
    }

    /**
     * Get the reviews for services by seller.
     */
    public function service_reviews()
    {
        return $this->hasManyThrough(
            ServiceSellerReview::class,
            ServiceSeller::class,
            'seller_id',
            'service_seller_id',
            'id',
            'id'
        );
    }

    /**
     * Get the reviews count for services by seller.
     */
    public function getServiceReviewsCountAttribute()
    {
        return $this->service_reviews()->count();
    }

    /**
     * Get the reviews average rating for services by seller.
     */
    public function getServiceReviewsAverageAttribute()
    {
        return $this->service_reviews()->average('rating');
    }

    /**
     * Get the balance logs for the user.
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'user');
//        return $this->hasMany(Transaction::class, 'user_id', 'id')
//            ->where('user_type', Seller::class);
    }

    /**
     * Get the balance logs for the user.
     */
    public function last_transaction()
    {
        return $this
            ->hasOne(Transaction::class, 'user_id', 'id')
            ->where('user_type', Seller::class)
            ->orderByDesc('id');
    }

    /**
     * Get all of the buyer's tickets.
     */
    public function tickets()
    {
        return $this->morphMany(\App\Models\SupportTicket::class, 'user');
    }
}
