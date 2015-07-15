<?php

namespace App\Libs;


class ErrorDisplay
{

    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
    * Display validation error msg in top page in box style
    */
    public function displayAll($errors)
    {
        if (\Config::get("error_display.box"))
            return \View::make('layout.error_display.all_errors', compact("errors"));
        else
            return "";
    }

    /**
    * Display validation error msg line by line
    */
    public function displayIndividual($errors, $field)
    {
        if (\Config::get("error_display.line"))
            return \View::make('layout.error_display.field_errors', compact("errors", "field"));
        else
            return "";
    }
}
