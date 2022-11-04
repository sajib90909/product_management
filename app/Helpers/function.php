<?php

use Illuminate\Support\Str;

if (!function_exists('make_slug')){
    function make_slug($str, $id = 0): string
    {
        return Str::slug($str).'-'.strtotime(getNow()->toDateTimeString()).$id.rand(1,99999);
    }
}

if (!function_exists('getNow')){
    function getNow(): \Carbon\Carbon
    {
        return \Carbon\Carbon::now();
    }
}