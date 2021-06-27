<?php
/**
 * Created by PhpStorm.
 * User: abhi
 * Date: 6/27/2021
 * Time: 5:11 PM
 */


class Charging extends CI_Controller
{

    private $balanceQueryUrl = 'https://api.ideamart.io/caas/balance/query';
//    private $balanceQueryUrl = 'http://localhost/ideamart_api/test/TestApi';

    private $directDebitUrl = 'https://api.ideamart.io/caas/direct/debit';
//    private $directDebitUrl = 'http://localhost/ideamart_api/test/TestApi';

    public function __construct()
    {
        parent::__construct();

    }


    public function balanceQuery()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');

        $response = array();
        $status = true;
        $message = "";
        $result = "";


        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);


            if (!isset($request->applicationId)) {
                $status = 400;
                $message = "Application id empty!";
            } elseif (!isset($request->password)) {
                $status = 400;
                $message = "Password is empty!";
            } elseif (!isset($request->subscriberId)) {
                $status = 400;
                $message = "Subscriber id empty!";
            } else {
                $data["applicationId"] = $request->applicationId;
                $data["password"] = $request->password;
                $data["subscriberId"] = $request->subscriberId;

                if(isset($request->accountId)){
                    $data["accountId"] = $request->accountId;
                }
                if(isset($request->currency)){
                    $data["currency"] = $request->currency;
                }

                $result = $this->requestApi($data, $this->balanceQueryUrl);
                $message = "Success!";
            }

        } catch (Exception $ex) {
            $status = 500;
            $message = $ex;
        }

        $response['status'] = $status;
        $response['message'] = $message;
        $response['data'] = json_decode($result);

        echo json_encode($response);
    }


    public function directDebit()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');

        $response = array();
        $status = true;
        $message = "";
        $result = "";


        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);


            if (!isset($request->applicationId)) {
                $status = 400;
                $message = "Application id empty!";
            } elseif (!isset($request->password)) {
                $status = 400;
                $message = "Password is empty!";
            } elseif (!isset($request->subscriberId)) {
                $status = 400;
                $message = "Subscriber id empty!";
            }elseif (!isset($request->externalTrxId)){
                $status = 400;
                $message = "ExternalTrx id empty!";
            }elseif (!isset($request->paymentInstrument)){
                $status = 400;
                $message = "payment Instrument is empty!";
            }elseif (!isset($request->amount)){
                $status = 400;
                $message = "Amount is empty!";
            } else {
                $data["applicationId"] = $request->applicationId;
                $data["password"] = $request->password;
                $data["subscriberId"] = $request->subscriberId;
                $data["externalTrxId"] = $request->externalTrxId;
                $data["paymentInstrument"] = $request->paymentInstrument;
                $data["amount"] = $request->amount;

                if(isset($request->accountId)){
                    $data["accountId"] = $request->accountId;
                }
                if(isset($request->currency)){
                    $data["currency"] = $request->currency;
                }

                $result = $this->requestApi($data, $this->directDebitUrl);
                $message = "Success!";
            }

        } catch (Exception $ex) {
            $status = 500;
            $message = $ex;
        }

        $response['status'] = $status;
        $response['message'] = $message;
        $response['data'] = json_decode($result);

        echo json_encode($response);
    }


    private function requestApi($data, $url)
    {
        // API URL

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }

}