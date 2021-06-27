<?php
/**
 * Created by PhpStorm.
 * User: abhi
 * Date: 6/27/2021
 * Time: 11:12 PM
 */

class Sms extends CI_Controller
{

    private $sendUrl = 'https://api.ideamart.io/sms/send';
//    private $sendUrl = 'http://localhost/ideamart_api/test/TestApi';

//    private $receiveUrl = '';
    private $receiveUrl = 'http://localhost/ideamart_api/test/TestApi';

//    private $deliveryStatusUrl = '';
    private $deliveryStatusUrl = 'http://localhost/ideamart_api/test/TestApi';


    public function __construct()
    {
        parent::__construct();

    }


    public function send()
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
            } elseif (!isset($request->message)) {
                $status = 400;
                $message = "message is empty!";
            } elseif (!isset($request->destinationAddresses)) {
                $status = 400;
                $message = "Destination Addresses is empty!";
            } else {
                $data["applicationId"] = $request->applicationId;
                $data["password"] = $request->password;
                $data["message"] = $request->message;
                $data["destinationAddresses"] = $request->destinationAddresses;

                if (isset($request->version)) {
                    $data["version"] = $request->version;
                }
                if (isset($request->sourceAddress)) {
                    $data["sourceAddress"] = $request->sourceAddress;
                }
                if (isset($request->deliveryStatusRequest)) {
                    $data["deliveryStatusRequest"] = $request->deliveryStatusRequest;
                }
                if (isset($request->encoding)) {
                    $data["encoding"] = $request->encoding;
                }
                if (isset($request->chargingAmount)) {
                    $data["chargingAmount"] = $request->chargingAmount;
                }
                if (isset($request->binaryHeader)) {
                    $data["binaryHeader"] = $request->binaryHeader;
                }

                $result = $this->requestApi($data, $this->sendUrl);
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

    public function receive()
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


            if (!isset($request->version)) {
                $status = 400;
                $message = "version is empty!";
            } elseif (!isset($request->sourceAddress)) {
                $status = 400;
                $message = "Source Address is empty!";
            } elseif (!isset($request->message)) {
                $status = 400;
                $message = "message is empty!";
            } elseif (!isset($request->requestId)) {
                $status = 400;
                $message = "Request Id empty!";
            } elseif (!isset($request->encoding)) {
                $status = 400;
                $message = "Encoding is empty!";
            } else {
                $data["version"] = $request->version;
                $data["sourceAddress"] = $request->sourceAddress;
                $data["message"] = $request->message;
                $data["requestId"] = $request->requestId;
                $data["encoding"] = $request->encoding;

                if (isset($request->applicationId)) {
                    $data["applicationId"] = $request->applicationId;
                }


                $result = $this->requestApi($data, $this->receiveUrl);
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

    public function deliveryStatus()
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


            if (!isset($request->destinationAddress)) {
                $status = 400;
                $message = "Destination Address is empty!";
            } elseif (!isset($request->timeStamp)) {
                $status = 400;
                $message = "TimeStamp is empty!";
            } elseif (!isset($request->deliveryStatus)) {
                $status = 400;
                $message = "Delivery Status is empty!";
            } elseif (!isset($request->requestId)) {
                $status = 400;
                $message = "Request Id empty!";
            } else {
                $data["destinationAddress"] = $request->destinationAddress;
                $data["timeStamp"] = $request->timeStamp;
                $data["deliveryStatus"] = $request->deliveryStatus;
                $data["requestId"] = $request->requestId;

                $result = $this->requestApi($data, $this->receiveUrl);
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