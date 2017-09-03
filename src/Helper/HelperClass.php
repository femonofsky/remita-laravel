<?php
/**
 * Created by IntelliJ IDEA.
 * User: Femonofsky
 * Date: 9/3/17
 * Time: 12:58 AM
 */

namespace Femonofsky\Remita\Helper;


class HelperClass
{
    static function cuRlGet($url){
        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        return $result;

    }

    static function jsonp_decode($jsonp, $assoc = false) {
        // PHP 5.3 adds depth as third parameter to json_decode
        try{
            if($jsonp[0] !== '[' && $jsonp[0] !== '{') { // we have JSONP
                $jsonp = substr($jsonp, strpos($jsonp, '('));
            }
            return json_decode(trim($jsonp,'();'), $assoc);
        }
        catch (\Exception $ex){
            throw  new \Exception ();
        }

    }

    static function cURLPostJson($URL, $data){
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $URL,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                "accept: application/json"
            )
        );
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        $err = curl_error($curl);

        if($err){
            throw new \Exception();
        }
        curl_close($curl);

        return $resp;

    }

    static function generateHashSha512($concatString = ""){
        $hash = hash('sha512', $concatString);
        return $hash;
    }

    static function decryptHashSha512($concatString = ""){
        $hash = hash('sha512', $concatString);
        $decryptString = decrypt($hash);
        var_dump($concatString);
        var_dump("<br>");
        var_dump($hash);
        var_dump("<br>");
        var_dump($decryptString);
        var_dump("<br>");

        return $hash;
    }
}