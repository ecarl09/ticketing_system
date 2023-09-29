<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class smsTxtMessage extends Controller{

    public function smsNotification($mobile, $message){
        $data = array(
            "app_key"        => "MIoLFf8ofGIk7YDV",
            "app_secret"     => "apiHKAhAyoyS4dVqr7lYoXBwitMmRXWS",
            "msisdn"         => $mobile,
            "content"        => $message,
            "shortcode_mask" => "MMGFED",
            "rcvd_transid"   => "12334512312312",
            "is_intl"        => false
        );
    
        $data_string = json_encode($data);
        $curl = curl_init('https://api.m360.com.ph/v3/api/broadcast');
    
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data
    
        // Send the request
        $result = curl_exec($curl);
    
        // Free up the resources $curl is using
        curl_close($curl);
    
        // echo $result;
    }
}