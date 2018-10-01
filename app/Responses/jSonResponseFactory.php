<?php

namespace App\Responses;

use App\Exceptions\jSonResponseNotExist;

class jSonResponseFactory
{
    /**
     * @param $version
     * @return mixed
     */
    public static function create($version)
    {
        if ($version == null) {
            $version = 1;
        }

        $className = '\App\Responses\jSonResponseV' . $version;

        if (! class_exists($className))
        {
            throw new jSonResponseNotExist();
        }

        return new $className();
    }
}