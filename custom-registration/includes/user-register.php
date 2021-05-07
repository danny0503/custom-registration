<?php


function dm_register_user(){

    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];
    $sq = $_POST['sq'];
    $sa = $_POST['sa'];
    $captcha = $_POST['gresponse'];

    $user_id = username_exists( $user_name );
    $opt = get_option('dmc_options');

    $data = array(
            'secret' => $opt['dmc_field_secret'],
            'response' => $captcha
        );

    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    $data = json_decode($response);

    if($data->success != true)
    {
        echo json_encode(array("status"=>"error", "error"=>"Invalid Captcha Please try again", "res"=>$data->success));
    } else if ( ! $user_id && false == email_exists( $email ) ) {
        //$user_id = wp_create_user( $uname, $passwd, $email );
        echo json_encode(array("status"=>"success", "captcha"=>$captcha, "response"=>$response));
    } else {
        echo json_encode(array("status"=>"error", "error"=>"User already exists."));
    }

    wp_die();
}

add_action( 'wp_ajax_dm_register_user', 'dm_register_user' );
add_action( 'wp_ajax_nopriv_dm_register_user', 'dm_register_user' );

?>