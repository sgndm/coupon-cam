<?php
namespace App\Classes;

class Converter {
    
    public static function currencyConverter($from, $to, $amount){
        
        $url = file_get_contents('https://free.currencyconverterapi.com/api/v5/convert?q=' . $from . '_' . $to . '&compact=ultra');
        $json = json_decode($url, true);
        $rate = implode(" ",$json);
        $total = $rate * $amount;
        //$rounded = round($total, 0, PHP_ROUND_HALF_DOWN); //round to an int
        $rounded = floor($total); // round to an int |ex: 1.4 -> 1, 1.7 -> 1
        return $rounded; //return converted value
    }
    
    
    
    public static function get_time_zone($latitude, $longitude){
        
        $api_key = 'AIzaSyBAGhaRi_7Fpl9z49bzX-BRyAt0h00mHAE';

        $url = file_get_contents('https://maps.googleapis.com/maps/api/timezone/json?location=' . $latitude . ',' . $longitude . '&timestamp=1524138098&key=' . $api_key);
        $json = json_decode($url, true);

        $dayLightSaving = $json['dstOffset'];
        $offset = $json['rawOffset'];
        
        $return = ($dayLightSaving + $offset);

        //return(array('dayLightSaving' => $dayLightSaving, 'timeOffset' => $offset));
        return $return;
    }
    
    public static function calculate_server_time($store_offset, $server_offset){
        // get gmt time for store at 12.00 pm
        $temp_time = (( 24 * 3600 ) - $store_offset); // gnt time for 12 pm
        
        // get server time
        $temp_server_time = ($temp_time + $server_offset);
        
        $h = floor($temp_server_time / 3600); // hours
        $i = floor( ($temp_server_time % 3600) / 60 ); // minutes
        $s = (($temp_server_time % 3600) % 60);
        
        $make_time = mktime($h, $i, $s);
        
        $server_time = date('H:i:s', $make_time);
        
        return($server_time);
    } 
    
    public static function get_server_time_by_local_time($store_time, $store_offset, $server_offset){
        // get store time in seconds
        $stm = explode(':', $store_time);
        $H = (int)$stm[0];
        $I = (int)$stm[1];
        $S = (int)$stm[2];
        
        $time_in_sec = ($H * 3600) + ($I * 60) + ($S);
        
        // 
        $temp_server_time = (($time_in_sec - $store_offset) + $server_offset);
        
        $h = floor($temp_server_time / 3600); // hours
        $i = floor( ($temp_server_time % 3600) / 60 ); // minutes
        $s = (($temp_server_time % 3600) % 60);
        
        $make_time = mktime($h, $i, $s);
        
        $server_time = date('H:i:s', $make_time);
        
        return($server_time);
        
    }

    public static function get_server_new_time($store_time, $store_offset, $server_offset) {
        $time_in_sec = strtotime($store_time);

        $temp_server_time = (($time_in_sec - $store_offset) + $server_offset);

        $server_time = date('Y-m-d H:i:s', $temp_server_time);

        return $server_time;
    }
    
    public static function get_server_location(){
        
        $ip = '35.178.153.168';
        
        $url = file_get_contents('https://ipapi.co/' . $ip . '/json/');
        $json = json_decode($url, true);

        $latitude = $json['latitude'];
        $longitude = $json['longitude'];

        return (array('latitude' => $latitude,'longitude' => $longitude));
    }
    
    public static function get_values_for_countries($st_country, $value){
        
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
    
}