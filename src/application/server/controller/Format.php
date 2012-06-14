<?php
class C_Format {

    public static function datetime($timestamp)
    {
        return date('Y-m-d H:i:s', $timestamp);
    }

    public static function datetimeReverse($datetime)
    {
        $parts = explode("-", $datetime);
        return $parts[2] . "-" . $parts[1] . "-" . $parts[0];
    }
}