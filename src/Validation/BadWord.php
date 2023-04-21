<?php

namespace Patoui\LaravelBadWord\Validation;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BadWord
{
    /**
     * Validates for bad words.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @param  array  $parameters
     * @param  object $validator
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        if (!is_string($value)) {
            return true;
        }

        if (config('strict')) {
            $words = !$parameters ? config('bad-word') : Arr::only(config('bad-word'), $parameters);
            return !Str::contains(strtolower($value), Arr::flatten($words));
        }

        $words = !$parameters ? implode('|', config('bad-word')) : implode('|', Arr::only(config('bad-word'), $parameters)[$parameters[0]]);

        return !preg_match("#\b(" . $words . ")\b#", strtolower($value)) > 0;
    }
}
