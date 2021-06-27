<?php
/**
 * Created by PhpStorm.
 * User: abhi
 * Date: 6/27/2021
 * Time: 9:32 PM
 */

class TestApi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');

        $response = array();
        $status = true;

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);


//        $applicationId = $request->applicationId;
//        $password = $request->password;
//        $subscriberId = $request->subscriberId;
//
//        $data["applicationId"] = $applicationId;
//        $data["password"] = $password;
//        $data["subscriberId"] = $subscriberId;



        $response['status'] = $status;
        $response['message'] = "Api Called";
//        $response['data'] = $data;
        $response['request'] = $request;

        echo json_encode($response);
    }

}
