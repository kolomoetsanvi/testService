<?php


class Validator
{
    /**
     * @param $item
     * @return bool
     */
    public static function noEmptyString($item)
    {
        return isset($item) && !empty($item);
    }

    /**
     * @param $date
     * @param string $format
     * @return bool
     * @throws Exception
     */
    public static function isDateTimeFormat($date, $format = 'd.m.Y H:i')
    {
        try{
            $d = new DateTime($date);
            } catch (Exception $ex) {
               return false;
            }
            return $d && $d->format($format) === $date;
    }
}