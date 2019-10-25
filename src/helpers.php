<?php

use Zendraxl\LaravelString\StrProxy;

if (! function_exists('str')) {
    /**
     * Create a String object from the given value.
     *
     * @param  string  $text
     * @return StrProxy
     */
    function str($text = ''): StrProxy
    {
        return new StrProxy($text);
    }
}
