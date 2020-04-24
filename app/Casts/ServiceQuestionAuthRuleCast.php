<?php


namespace App\Casts;

use App\Helpers\ServiceQuestionAuthRule;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ServiceQuestionAuthRuleCast implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new ServiceQuestionAuthRule($attributes['auth_rule'] ?? null);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return [
            'auth_rule' => empty($value) ? null : $value,
        ];
    }
}
