<?php
/**
 * Created by PhpStorm.
 * User: abhi
 * Date: 6/28/2021
 * Time: 12:06 AM
 */

class Subscription extends CI_Controller
{


    private $sendUrl = 'https://api.ideamart.io/subscription/send';
//    private $sendUrl = 'http://localhost/ideamart_api/test/TestApi';

//    private $subscriptionNotificationUrl = ''; // enter request api
    private $subscriptionNotificationUrl = 'http://localhost/ideamart_api/test/TestApi';

    private $getSubscriptionStatusUrl = 'https://api.ideamart.io/subscription/getStatus';
//    private $getSubscriptionStatusUrl = 'http://localhost/ideamart_api/test/TestApi';

    private $queryBaseUrl = 'https://api.ideamart.io/subscription/query-base';
//    private $queryBaseUrl = 'http://localhost/ideamart_api/test/TestApi';


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
            } elseif (!isset($request->action)) {
                $status = 400;
                $message = "Action is empty!";
            } elseif (!isset($request->subscriberId)) {
                $status = 400;
                $message = "Subscriber Id empty!";
            } else {
                $data["applicationId"] = $request->applicationId;
                $data["password"] = $request->password;
                $data["action"] = $request->action;
                $data["subscriberId"] = $request->subscriberId;

                if (isset($request->version)) {
                    $data["version"] = $request->version;
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


    public function subscriptionNotification()
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
            } elseif (!isset($request->frequency)) {
                $status = 400;
                $message = "Frequency is empty!";
            } elseif (!isset($request->status)) {
                $status = 400;
                $message = "Status is empty!";
            } elseif (!isset($request->subscriberId)) {
                $status = 400;
                $message = "Subscriber Id empty!";
            } elseif (!isset($request->version)) {
                $status = 400;
                $message = "Version empty!";
            } elseif (!isset($request->timeStamp)) {
                $status = 400;
                $message = "TimeStamp empty!";
            } else {
                $data["applicationId"] = $request->applicationId;
                $data["frequency"] = $request->frequency;
                $data["status"] = $request->status;
                $data["subscriberId"] = $request->subscriberId;
                $data["version"] = $request->version;
                $data["timeStamp"] = $request->timeStamp;


                $result = $this->requestApi($data, $this->subscriptionNotificationUrl);
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

    public function getSubscriptionStatus()
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
                $message = "password is empty!";
            } elseif (!isset($request->subscriberId)) {
                $status = 400;
                $message = "Subscriber Id empty!";
            } else {
                $data["applicationId"] = $request->applicationId;
                $data["password"] = $request->password;
                $data["subscriberId"] = $request->subscriberId;



                $result = $this->requestApi($data, $this->getSubscriptionStatusUrl);
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


    public function queryBase()
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
                $message = "password is empty!";
            }else {
                $data["applicationId"] = $request->applicationId;
                $data["password"] = $request->password;



                $result = $this->requestApi($data, $this->queryBaseUrl);
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