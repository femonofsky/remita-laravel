<?php

namespace Femonofsky\Remita\Controllers;

use App\Http\Controllers\Controller;
use Femonofsky\Remita\Helper\HelperClass;
use Femonofsky\Remita\Remita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RemitaController extends Controller {

    public function index(){
        return view("remita::welcome");
    }

    public function testMandate(Request $request){

        $data = [];
        $data['amount'] = "455";
        $data['payerName'] = "Oshadami Mike";
        $data['payerEmail'] = "oshadami@example.com";
        $data['payerPhone'] = "09055556903";
        $data['payerBankCode'] = "011";
        $data['payerAccount']  = "3055011153";
        $data['startDate'] = "12/10/2017";
        $data['endDate'] = "12/12/2017";
        $data['maxNoOfDebits'] = "3";

        $result = Remita::InitiateMandate($data);
        print_r($result);

    }

    public function testViewMandateForm($mandateId){
        return Remita::ViewMandateForm($mandateId);
    }

    public function testStopMandate($mandateId,$requestId){
        $result = Remita::StopMandate($mandateId,$requestId);
        print_r($result);
    }

    /*** Not Tested Yet *****/
    public function testDirectDebit($mandateId,$requestId,$totalAmount){
        $result = Remita::DirectDebit($mandateId,$requestId,$totalAmount);
        print_r($result);
    }

    /*** Not Tested Yet *****/
    public function testCancelDirectDebit($mandateId,$requestId,$transactionRef){

        $result = Remita::CancelDirectDebit($mandateId,$requestId,$transactionRef);
        print_r($result);
    }

    public function testStatusMandate($requestId){
        $result = Remita::StatusMandate($requestId);
        print_r($result);
    }

    public function testHistoryMandate($requestId){

        $result = Remita::HistoryMandate($requestId);
        print_r($result);
    }

    public function testPaymentStatusViaRRR($RRR){
        $result = Remita::PaymentStatusRRR($RRR);
        print_r($result);
    }
}


