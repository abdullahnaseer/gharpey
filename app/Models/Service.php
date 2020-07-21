<?php

namespace App\Models;

use App\Helpers\ServiceQuestionType\ServiceQuestionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

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

    public static function getRules($request, $editId = false)
    {
        $rules = [
            'price' => 'required|numeric|min:100|max:20000',
            'short_description' => 'required|min:10|max:1000',
            'long_description' => 'max:25000',
            'cities' => 'required|array',
            'cities.*' => 'required|exists:cities,id',
            'featured_image' => ($editId ? 'file|image' : 'required|file|image'),


            'name' => 'required_with:question,name|array',
            'name.*' => 'required_with:question.*,type.*|min:3|max:255',

            'question' => 'required_with:type,name|array',
            'question.*' => 'required_with:type.*,name.*|min:3|max:255',

            'type' => 'required_with:question,name|array',
            'type.*' => 'required_with:question.*,name.*|string|in:' .
                implode(",", ServiceQuestionType::getAllTypes()),

//            'is_required' => 'required|array',
//            'is_required.*' => 'required|string|in:0,1'
        ];

        if(!isset($editId))
            $rules['service_id'] = 'required|exists:services,id|unique:service_seller,service_id,NULL,id,seller_id,' . $request->user()->id;

        $i = 0;
        foreach ($request->input('type', []) as $input) {
            if ($input === ServiceQuestionType::SELECT || $input === ServiceQuestionType::SELECT_MULTIPLE) {
                $rules['choice_text.' . $i] = 'required|array';
                $rules['choice_text.' . $i . '.*'] = 'required|string|min:3|max:80';

                $rules['choice_price_effect.' . $i] = 'required|array';
                $rules['choice_price_effect.' . $i . '.*'] = 'required|integer|between:-100000,100000';
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
    public function reviews()
    {
        return $this->hasManyThrough(ServiceSellerReview::class, ServiceSeller::class,
            'service_id',
            'service_seller_id',
            'id',
            'id'
        );
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
