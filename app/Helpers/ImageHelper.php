<?php

namespace App\Helpers;

/**
 * Class ImageHelper
 *
 * @package App\Helpers
 */
class ImageHelper
{

    /**
     * @param string $data
     *
     * @return string
     * @throws \Exception
     */
    public static function saveFromBase64(string $data,string $depot) : string {
        list($type, $data) = explode(';', $data);
        list(,$extension) = explode('/',$type);
        list(,$data)      = explode(',', $data);
        $name = bin2hex(random_bytes(32)).'.'.$extension;
        $data = base64_decode($data);
        file_put_contents(storage_path(env($depot)).'/'.$name, $data);
        return $name;
    }

    /**
     * @param string $data
     * @param array  $format
     *
     * @return bool
     */
    public static function checkFormatBase64(string $data,array $format) : bool {
        $array = explode(';', $data);
        if(count($array) < 2){
            return false;
        }
        $type = $array[0];

        $array = explode('/',$type);
        if(count($array) < 2){
            return false;
        }
        list(,$extension) = explode('/',$type);
        $extension = $array[1];
        return in_array($extension,$format);
    }
}
