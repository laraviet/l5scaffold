<?php

namespace App\Libs;


class ValueHelper
{

    public static function getOldInput($model, $property)
    {
        if (\Session::getOldInput($property) !== null) {
            return \Session::getOldInput($property);
        }
        return $model->$property;
    }

}
