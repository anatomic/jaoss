<?php

class Validate {
    public static function required($value, $settings = null) {
        $type = isset($settings["type"]) ? $settings["type"] : "text";
        switch ($type) {
            default:
                return (trim($value) != "");
        }
    }

    public static function email($value, $settings = null) {
        return preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$#", $value) > 0;
    }

    public static function minLength($value, $settings = null) {
        $length = isset($settings["length"]) ? $settings["length"] : 0;
        return (strlen($value) >= $length);
    }

    public static function match($value, $settings) {
        return ($value == $settings["confirm"]);
    }

    public static function unique($value, $settings) {
        $model = $settings["model"];
        $method = $settings["method"];
        $field = $settings["field"];
        $object = $model->$method("`{$field}` = ?", array($value));
        return $object ? false : true;
    }

    public static function numbersSpaces($value, $settings = null) {
        return preg_match("#^\d[\d\s]+\d$#", $value) > 0;
    }

    public static function date($value, $settings = null) {
        return preg_match("#(\d{2})/(\d{2})/(\d{2,4})#", $value) > 0;
    }
    
    public static function getMessage($function, $settings, $value = null) {
        $title = $settings["title"];
        switch ($function) {
            case "email":
                return "{$title} is not a valid email address";
            case "required":
                return "{$title} is required";
            case "minLength":
                return "{$title} must be at least {$settings["length"]} characters long";
            case "match":
                return "the two {$title}s do not match";
            case "unique":
                return "this {$title} is already in use";
            case "numbersSpaces":
                return "{$title} must contain only numbers and spaces";
            case "numbers":
                return "{$title} must contain only numbers";
            case "date":
                return "{$title} must be in the format dd/mm/yyyy"; 
            default:
                return "{$title} is not valid";
        }
    }
}
