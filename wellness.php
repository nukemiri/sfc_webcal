<?php 
    // ini_set('display_errors', "On");

    require_once './Requests/src/Autoload.php';
    WpOrg\Requests\Autoload::register();

    if(isset($_GET['studentid'])&&isset($_GET['password'])){ 
        $studentid = $_GET['studentid'];
        $password = $_GET['password']; } 
    
        $url = "https://wellness.sfc.keio.ac.jp/v3/index.php";
        $cal_url = "https://wellness.sfc.keio.ac.jp/v3/index.php?page=ics&mode=student&semester=20220";

        $login_data = array(
            'login'=> $studentid,
            'password'=> $password,
            'submit'=>"login",
            "page"=>"top",
            "mode"=>"login",
            "semester"=>"20220",);
        $session = new \WpOrg\Requests\Session();
        $session->post($url,array(),$login_data);
        $response = $session->get($cal_url);
        // echo($response->status_code. "<br/><br/>");
        header("Content-type: text/calendar; charset=utf-8");
        print($response->body);


    
 ?>