<?php
/**
 * Created by IntelliJ IDEA.
 * User: Femonofsky
 * Date: 9/2/17
 * Time: 10:44 PM
 */

return [
    'MERCHANTID' => env('MERCHANTID',"2547916"),
    "SERVICETYPEID" => env('SERVICETYPEID',"4430731"),
    "FUNDINGACCOUNT" => env('FUNDINGACCOUNT',"6973738333"),
    "FUNDINGBANKCODE" => env('FUNDINGBANKCODE',"011"),
    "APIKEY" => env('APIKEY',"1946"),
    "MANDATETPYE" => env('MANDATETPYE',"DD"),
    "CHECKSTATUSURL" => "http://www.remitademo.net/remita/ecomm",
    "MANDATESURL" => "http://www.remitademo.net/remita/ecomm/mandate",
    "GATEWAYURL" => "http://www.remitademo.net/remita/ecomm/mandate/setup.reg",
    "STOPMANDATEURL" => "http://www.remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/stop",
    "DIRECTBILLINGURL" => "http://www.remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/payment/send",
    "CANCELDIRECTBILLINGURL" => "http://www.remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/echannel/mandate/payment/stop",
];