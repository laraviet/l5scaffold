<?php

namespace App\Libs;


class ValueHelper
{
	/**
	* Get old input when validate has errors
	*
	* @param Model instance $model
	* @param string $property
	*/
    public static function getOldInput($model, $property)
    {
        if (\Session::getOldInput($property) !== null) {
            return \Session::getOldInput($property);
        }
        return $model->$property;
    }

}
