<?php
/**
 * Created by IntelliJ IDEA.
 * User: Femonofsky
 * Date: 9/2/17
 * Time: 9:55 PM
 */

namespace Femonofsky\Remita;
use Femonofsky\Remita\Helper\HelperClass;

class Remita
{
    public static function  InitiateMandate($data = array()){
        try{
            $amount = $data['amount'] ?: '';
            $payerName = $data['payerName'] ?: '';
            $payerEmail = $data['payerEmail'] ?: '';
            $payerPhone = $data['payerPhone'] ?: '';
            $payerBankCode = $data['payerBankCode'] ?: '';
            $payerAccount = $data['payerAccount'] ?: '';
            $startDate = $data['startDate'] ?: '';
            $endDate = $data['endDate'] ?: '';
            $maxNoOfDebits = $data['maxNoOfDebits'] ?: '';

            $mert =  config('Remita.MERCHANTID');
            $api_key =  config('Remita.APIKEY');
            $serv_id = config('Remita.SERVICETYPEID');
            $mandateType = config('Remita.MANDATETPYE');
            $timesammp=date("dmyHis");
            $requestId = $timesammp;

            $concatString = $mert . $serv_id . $requestId . $amount . $api_key;
            $hash = hash('sha512', $concatString);

            $details = [
                "merchantId" => $mert,
                "serviceTypeId" => $serv_id,
                "hash" => $hash,
                "payerName" => $payerName,
                "payerEmail" => $payerEmail,
                "payerPhone" => $payerPhone,
                "payerBankCode" => $payerBankCode,
                "payerAccount" => $payerAccount,
                "requestId" => $requestId,
                "amount" => $amount,
                "startDate" => $startDate,
                "endDate" => $endDate,
                "mandateType" => $mandateType,
                "maxNoOfDebits" => $maxNoOfDebits
            ];

            $results= HelperClass::cURLPostJson(config('Remita.GATEWAYURL'),$details);
            $responseObj = HelperClass::jsonp_decode($results);
            $responseObj->requestId = $requestId;
            return $responseObj;

        }
        catch (\Exception $ex){
            $responseObj = new \stdClass();
            $responseObj->statuscode = "022";
            $responseObj->status = "Invalid Request,Please Check Your Parameter";
            $responseObj->requestId = "99999";
            return $responseObj;
        }



    }

    public static function  StopMandate($mandateId = "",$requestId=""){
        try{
            $mert =  config('Remita.MERCHANTID');
            $api_key =  config('Remita.APIKEY');

            $hash = HelperClass::generateHashSha512($mandateId . $mert . $requestId . $api_key);

            $details = [
                "merchantId" => $mert,
                "mandateId" => $mandateId,
                "hash" => $hash,
                "requestId" => $requestId,
            ];

            $results= HelperClass::cURLPostJson(config('Remita.STOPMANDATEURL'),$details);
            $responseObj = HelperClass::jsonp_decode($results);
            return $responseObj;

        }
        catch (\Exception $ex){
            $responseObj = new \stdClass();
            $responseObj->statuscode = "022";
            $responseObj->status = "Invalid Request,Please Check Your Parameter";
            return $responseObj;
        }



    }

    public static function ViewMandateForm($mandateId = ""){
        try{
            if(empty($mandateId)){
                $responseObj = new \stdClass();
                $responseObj->statuscode = "022";
                $responseObj->status = "Invalid Request, pass MandateId ";
                return $responseObj;
            }

            $merchantId = config("Remita.MERCHANTID");
            $key = config("Remita.APIKEY");
            $timesammp=date("dmyHis");
            $requestId = $timesammp;

            $hash = HelperClass::generateHashSha512($merchantId.$key.$requestId);

            $url = config("Remita.MANDATESURL")."/form/".$merchantId."/".$hash."/" .$mandateId. "/". $requestId ."/rest.reg";

            return \Redirect::to($url);
        }
        catch (\Exception $ex){
            $responseObj = new \stdClass();
            $responseObj->statuscode = "022";
            $responseObj->status = "Invalid Request";
            return $responseObj;
        }

    }

    public static function DirectDebit($mandateId = "",$requestId="",$totalAmount=""){
        try{
            $mert =  config('Remita.MERCHANTID');
            $api_key =  config('Remita.APIKEY');
            $serv_id = config('Remita.SERVICETYPEID');
            $fundingAccount = config('Remita.FUNDINGACCOUNT');
            $fundingBankcode = config('Remita.FUNDINGBANKCODE');

            $hash = HelperClass::generateHashSha512($mert . $serv_id . $requestId . $totalAmount . $api_key);

            $details = [
                "merchantId" => $mert,
                "serviceTypeId" => $serv_id,
                "hash" => $hash,
                "requestId" => $requestId,
                "totalAmount" => $totalAmount,
                "mandateId" => $mandateId,
                "fundingAccount" => $fundingAccount,
                "fundingBankcode" => $fundingBankcode,
            ];

            $results= HelperClass::cURLPostJson(config('Remita.DIRECTBILLINGURL'),$details);
            $responseObj = HelperClass::jsonp_decode($results);
            return $responseObj;

        }
        catch (\Exception $ex){
            $responseObj = new \stdClass();
            $responseObj->statuscode = "022";
            $responseObj->status = "Invalid Request,Please Check Your Parameter";
            return $responseObj;
        }



    }

    public static function  CancelDirectDebit($mandateId = "",$requestId="",$transactionRef=""){
        try{
            $mert =  config('Remita.MERCHANTID');
            $api_key =  config('Remita.APIKEY');

            $hash = HelperClass::generateHashSha512($transactionRef . $mert . $requestId  . $api_key);

            $details = [
                "merchantId" => $mert,
                "mandateId" => $mandateId,
                "hash" => $hash,
                "requestId" => $requestId,
                "transactionRef" => $transactionRef,
            ];

            $results= HelperClass::cURLPostJson(config('Remita.CANCELDIRECTBILLINGURL'),$details);
            $responseObj = HelperClass::jsonp_decode($results);
            return $responseObj;

        }
        catch (\Exception $ex){
            $responseObj = new \stdClass();
            $responseObj->statuscode = "022";
            $responseObj->status = "Invalid Request,Please Check Your Parameter";
            return $responseObj;
        }



    }

    public static function StatusMandate($requestId=""){
        try{

            $merchantId = config("Remita.MERCHANTID");
            $key = config("Remita.APIKEY");
            $hash = HelperClass::generateHashSha512($requestId.$key.$merchantId);
            $url = config("Remita.MANDATESURL")."/".$merchantId."/". $requestId."/" . $hash ."/status.reg";

            $results= HelperClass::cuRlGet($url);
            $responseObj = HelperClass::jsonp_decode($results);
            if(empty($responseObj)){
                $responseObj = new \stdClass();
                $responseObj->statuscode = "022";
                $responseObj->status = "Invalid Request,Wrong RequestID";
                return $responseObj;
            }
            return $responseObj;
        }
        catch (\Exception $ex){
            $responseObj = new \stdClass();
            $responseObj->statuscode = "022";
            $responseObj->status = "Invalid Request";
            return $responseObj;
        }

    }

    public static function HistoryMandate($requestId=""){
        try{
            $merchantId = config("Remita.MERCHANTID");
            $key = config("Remita.APIKEY");
            $hash = HelperClass::generateHashSha512($requestId.$key.$merchantId);
            $url = config("Remita.MANDATESURL")."/".$merchantId."/". $requestId."/" . $hash ."/history.reg";

            $results= HelperClass::cuRlGet($url);
            $responseObj = HelperClass::jsonp_decode($results);
            if(empty($responseObj)){
                $responseObj = new \stdClass();
                $responseObj->statuscode = "022";
                $responseObj->status = "Invalid Request,Wrong RequestID";
                return $responseObj;
            }
            return $responseObj;
        }
        catch (\Exception $ex){
            $responseObj = new \stdClass();
            $responseObj->statuscode = "022";
            $responseObj->status = "Invalid Request";
            return $responseObj;
        }

    }

    public static function PaymentStatusRRR($RRR=""){
        try{
            $merchantId = config("Remita.MERCHANTID");
            $key = config("Remita.APIKEY");
            $hash = HelperClass::generateHashSha512($RRR.$key.$merchantId);
            $url = config("Remita.CHECKSTATUSURL")."/".$merchantId."/". $RRR."/" . $hash ."/status.reg";

            $results= HelperClass::cuRlGet($url);
            $responseObj = HelperClass::jsonp_decode($results);
            return $responseObj;
        }
        catch (\Exception $ex){
            $responseObj = new \stdClass();
            $responseObj->statuscode = "022";
            $responseObj->status = "Invalid Request";
            return $responseObj;
        }

    }

    public static function PaymentStatusOrderID($OrderID =""){
        try{
            $merchantId = config("Remita.MERCHANTID");
            $key = config("Remita.APIKEY");
            $hash = HelperClass::generateHashSha512($OrderID.$key.$merchantId);
            $url = config("Remita.CHECKSTATUSURL")."/".$merchantId."/". $OrderID."/" . $hash ."/orderstatus.reg";

            $results= HelperClass::cuRlGet($url);
            $responseObj = HelperClass::jsonp_decode($results);
            return $responseObj;
        }
        catch (\Exception $ex){
            $responseObj = new \stdClass();
            $responseObj->statuscode = "022";
            $responseObj->status = "Invalid Request";
            return $responseObj;
        }

    }

}