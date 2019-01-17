<?php

namespace iBrand\Aliyun\Vod;

class Facade extends \Illuminate\Support\Facades\Facade
{
    public static function getFacadeAccessor()
    {
       return 'AliyunVod';
    }

}