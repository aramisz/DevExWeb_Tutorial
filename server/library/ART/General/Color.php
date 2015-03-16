<?php
/**
 * Created by PhpStorm.
 * User: aramiszrobert
 * Date: 15. 02. 27.
 * Time: 14:41
 */

namespace ART\General;


class Color
{
    public static function randomHexGenerator()
    {
        $num = mt_rand(0, 0xffffff); // trust the library, love the library...
        $output = sprintf("%06x", $num); // muchas smoochas to you, PHP!
        return $output;
    }

    public static function calc_brightness($color)
    {
        $rgb = self::hex2RGB($color);
        return sqrt(
            $rgb["red"] * $rgb["red"] * .299 +
            $rgb["green"] * $rgb["green"] * .587 +
            $rgb["blue"] * $rgb["blue"] * .114);
    }

    public static function randomHexColor($only_for_white_font = true)
    {
        $background_color = self::randomHexGenerator();

        $brightness = self::calc_brightness($background_color);

        if ($brightness < 130 && $only_for_white_font) {
            self::randomHexColor(true);
        }

        $fore_color =  $brightness < 130 ? "#FFFFFF" : "#000000";

        return array(
            "fore_color" => $fore_color,
            "background_color" => "#" . $background_color,
        );

    }

    //http://www.php.net/manual/en/function.hexdec.php#99478
    public static function hex2RGB($hexStr, $returnAsString = false, $seperator = ',')
    {
        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
        $rgbArray = array();
        if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
            $colorVal = hexdec($hexStr);
            $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue'] = 0xFF & $colorVal;
        } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
            $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        } else {
            return false; //Invalid hex color code
        }
        return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
    }
}