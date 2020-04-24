<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'featured_image', 'slug', 'category_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

    ];

    public static function getRules($request, $isEdit = false)
    {
        $rules = [
            'service_id' => 'required|exists:services,id|unique:service_seller,service_id,NULL,id,seller_id,' . $request->user()->id,
            'price' => 'required|numeric|min:100|max:20000',
            'short_description' => 'required|min:10|max:1000',
            'long_description' => 'max:25000',
            'cities' => 'required|exists:cities,id',
            'featured_image' => 'required|file|image',

            'title' => 'required|array',
            'title.*' => 'required|min:3|max:255',
            'question' => 'required|array',
            'question.*' => 'required|min:3|max:255',
            'type' => 'required|array',
            'type.*' => 'required|string|in:' .
                ServiceQuestion::TYPE_BOOLEAN . ',' . ServiceQuestion::TYPE_TEXT . ',' . ServiceQuestion::TYPE_TEXT_MULTILINE . ',' . ServiceQuestion::TYPE_SELECT . ',' . ServiceQuestion::TYPE_SELECT_MULTIPLE . ',' . ServiceQuestion::TYPE_FILE . ',' . ServiceQuestion::TYPE_FILE_MULTIPLE . ',' . ServiceQuestion::TYPE_TIME . ',' . ServiceQuestion::TYPE_DATE . ',' . ServiceQuestion::TYPE_DATE_TIME,

            'is_required' => 'required|array',
            'is_required.*' => 'required|string|in:0,1'
        ];

        $i = 0;
        foreach ($request->input('type', []) as $input) {
            if ($input === ServiceQuestion::TYPE_SELECT || $input === ServiceQuestion::TYPE_SELECT_MULTIPLE) {
                $rules['choice_text.' . $i] = 'required|array';
                $rules['choice_text.' . $i . '.*'] = 'required|string|min:3|max:50';

                $rules['choice_price_effect.' . $i] = 'required|array';
                $rules['choice_price_effect.' . $i . '.*'] = 'required|digits_between:-10000,10000';
            } else if ($input === ServiceQuestion::TYPE_BOOLEAN) {
                $rules['price_effect_yes.' . $i] = 'required|digits_between:-10000,10000';
                $rules['price_effect_no.' . $i] = 'required|digits_between:-10000,10000';
            }
            $i++;
        }

        return $rules;
    }

    /**
     * The category that owns the service.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\ServiceCategory', 'category_id', 'id');
    }


    /**
     * The questions owns by the service.
     */
    public function questions()
    {
        return $this->hasMany(ServiceQuestion::class, 'service_id', 'id');
    }

    /**
     * The sellers that belong to the service.
     */
    public function service_sellers()
    {
        return $this->hasMany(ServiceSeller::class, 'service_id');
    }

    /**
     * The sellers that belong to the service.
     */
    public function sellers()
    {
        return $this->belongsToMany(Seller::class, 'service_seller', 'service_id', 'seller_id')
            ->using(ServiceSeller::class)
            ->withPivot([
                'id'
            ]);
    }

}
