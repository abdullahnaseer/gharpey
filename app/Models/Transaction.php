<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const TYPE_CREDIT = 'credit';
    const TYPE_DEBIT = 'debit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_type', 'reference_id', 'reference_type', 'type', 'amount', 'balance', 'note',
    ];


//    /**
//     * Get the user balance that owns the log record.
//     */
//    public function balance()
//    {
//        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
//    }

    /**
     * Get all of the owning transaction_able models.
     */
    public function reference()
    {
        return $this->morphTo();
    }

    public function scopeCredit()
    {
        return $this->where('type', self::TYPE_CREDIT);
    }

    public function scopeDebit()
    {
        return $this->where('type', self::TYPE_DEBIT);
    }

    public function scopeAnyType()
    {
        return $this;
    }

    public function scopeProduct()
    {
        return $this->where('reference_type', Product::class);
    }

    public function scopeService()
    {
        return $this->where('reference_type', Service::class);
    }

    public function scopeWithdrawAble()
    {
        return $this->where('created_at', '<=', Carbon::today()->subDays(15)->toDateTimeString());
    }
}
