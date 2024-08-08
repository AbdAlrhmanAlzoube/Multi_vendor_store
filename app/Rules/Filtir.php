<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class Filtir implements ValidationRule
{
    protected $forbiddenWords;

    public function __construct(array $forbiddenWords)
    {
        $this->forbiddenWords = $forbiddenWords;
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (in_array(strtolower($value), $this->forbiddenWords)) {
            $fail('The :attribute contains a forbidden word.');
        }
    }
}
