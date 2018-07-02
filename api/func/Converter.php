<?php

class Converter {

    public function currencyConverter($from, $to, $amount){

        $url = file_get_contents('https://free.currencyconverterapi.com/api/v5/convert?q=' . $from . '_' . $to . '&compact=ultra');
        $json = json_decode($url, true);
        $rate = implode(" ",$json);
        $total = $rate * $amount;
        //$rounded = round($total, 0, PHP_ROUND_HALF_DOWN); //round to an int
        $rounded = floor($total); // round to an int |ex: 1.4 -> 1, 1.7 -> 1
        return $rounded; //return converted value
    }

    public function get_values_for_countries($st_country, $value){

        $val_USD = 0;
        $val_CAD = 0;
        $val_NZD = 0;
        $val_AUD = 0;
        $val_UK = 0;

        if($st_country == "GB"){

            $base_C = 'GBP';

            $val_USD = Converter::currencyConverter($base_C, 'USD', $value);
            $val_CAD = Converter::currencyConverter($base_C, 'CAD', $value);
            $val_NZD = Converter::currencyConverter($base_C, 'NZD', $value);
            $val_AUD = Converter::currencyConverter($base_C, 'AUD', $value);
            $val_UK = $value;

        } elseif($st_country == "NZ"){

            $base_C = 'NZD';

            $val_USD = Converter::currencyConverter($base_C, 'USD', $value);
            $val_CAD = Converter::currencyConverter($base_C, 'CAD', $value);
            $val_NZD = $value;
            $val_AUD = Converter::currencyConverter($base_C, 'AUD', $value);
            $val_UK = Converter::currencyConverter($base_C, 'GBP', $value);

        }elseif($st_country == "CA"){

            $base_C = 'CAD';

            $val_USD = Converter::currencyConverter($base_C, 'USD', $value);
            $val_CAD = $value;
            $val_NZD = Converter::currencyConverter($base_C, 'NZD', $value);
            $val_AUD = Converter::currencyConverter($base_C, 'AUD', $value);
            $val_UK = Converter::currencyConverter($base_C, 'GBP', $value);

        }elseif($st_country == "AU"){

            $base_C = 'AUD';

            $val_USD = Converter::currencyConverter($base_C, 'USD', $value);
            $val_CAD = Converter::currencyConverter($base_C, 'CAD', $value);
            $val_NZD = Converter::currencyConverter($base_C, 'NZD', $value);
            $val_AUD = $value;
            $val_UK = Converter::currencyConverter($base_C, 'GBP', $value);

        }else{

            $base_C = 'USD';

            $val_USD = $value;
            $val_CAD = Converter::currencyConverter($base_C, 'CAD', $value);
            $val_NZD = Converter::currencyConverter($base_C, 'NZD', $value);
            $val_AUD = Converter::currencyConverter($base_C, 'AUD', $value);
            $val_UK = Converter::currencyConverter($base_C, 'GBP', $value);

        }

        $return = [
            'val_usd' => $val_USD,
            'val_cad' => $val_CAD,
            'val_nzd' => $val_NZD,
            'val_aud' => $val_AUD,
            'val_uk' => $val_UK,
        ];

        return $return;
    }


    public function get_time_zone($latitude, $longitude){

        $api_key = 'AIzaSyBAGhaRi_7Fpl9z49bzX-BRyAt0h00mHAE';

        $url = file_get_contents('https://maps.googleapis.com/maps/api/timezone/json?location=' . $latitude . ',' . $longitude . '&timestamp=1331766000&key=' . $api_key);
        $json = json_decode($url, true);

        $dayLightSaving = $json['dstOffset'];
        $offset = $json['rawOffset'];

        return(array('dayLightSaving' => $dayLightSaving, 'timeOffset' => $offset));
    }

    public function get_server_time(){

        $ip = '18.130.82.43';

        $url = file_get_contents('https://ipapi.co/' . $ip . '/json/');
        $json = json_decode($url, true);

        $latitude = $json['latitude'];
        $longitude = $json['longitude'];

        return (array('latitude' => $latitude,'longitude' => $longitude));
    }

}
