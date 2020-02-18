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

    public static function getRules($request)
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:10|max:1000',
            'featured_image' => 'required|image',
            'category_id' => 'required|numeric|exists:service_categories,id',

            'title' => 'required|array',
            'title.*' => 'required|min:3|max:255',
            'question' => 'required|array',
            'question.*' => 'required|min:3|max:255',
            'type' => 'required|array',
            'type.*' => 'required|string|in:'.
                ServiceQuestion::TYPE_BOOLEAN.','.ServiceQuestion::TYPE_TEXT.','.ServiceQuestion::TYPE_TEXT_MULTILINE.','.ServiceQuestion::TYPE_SELECT.','.ServiceQuestion::TYPE_SELECT_MULTIPLE . ','.ServiceQuestion::TYPE_FILE . ','.ServiceQuestion::TYPE_FILE_MULTIPLE . ','.ServiceQuestion::TYPE_TIME . ','.ServiceQuestion::TYPE_DATE . ','.ServiceQuestion::TYPE_DATE_TIME,

            'auth_type' => 'required|array',
            'auth_type.*' => 'required|string|in:'.
                ServiceQuestion::AUTH_ANY.','.ServiceQuestion::AUTH_GUEST.','.ServiceQuestion::AUTH_REQUIRED,

            'is_required' => 'required|array',
            'is_required.*' => 'required|string|in:0,1'
        ];

//        if(!is_null($request->input('type', null)) && ($request->input('type', null) === ServiceQuestion::TYPE_SELECT || $request->input('type', null) === ServiceQuestion::TYPE_SELECT_MULTIPLE ))
//            $rules['choices'] = 'required|array';

        $i = 0;
        foreach ($request->input('type', []) as $input)
        {
            if($input === ServiceQuestion::TYPE_SELECT || $input === ServiceQuestion::TYPE_SELECT_MULTIPLE)
            {
                $rules['choices.'.$i] = 'required|array';
                $rules['choices.'.$i.'.*'] = 'required|string|min:3|max:50';
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
        return $this->hasMany(ServiceSeller::class,'service_id');
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
