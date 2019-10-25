<?php

namespace Zendraxl\LaravelString;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str as LaravelStr;

class StringServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        LaravelStr::macro('make', function (string $text = '') {
            return new StrProxy($text);
        });
    }
}
