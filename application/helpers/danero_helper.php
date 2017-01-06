<?php

function generate_random_str($length = 10, $uppercase = false) {
    if($uppercase) {
        return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    } else {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}

function create_alert_message($result)
{
    if ($result['success']) {
        $alert_class = "alert-success";
        $icon = "<i class='fa fa-check-circle'></i>";
    } else {
        $alert_class = 'alert-danger';
        $icon = "<i class='fa fa-exclamation-circle'></i>";
    }
    $message = $result['message'];
    return "
    <div class='alert $alert_class'>
        $icon $message
    </div>
    ";
}

function json_response($code = 200, $message = null)
{
    // clear the old headers
    header_remove();
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        500 => '500 Internal Server Error'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    return json_encode(array(
    'status' => $code < 300, // success or not?
    'message' => $message
    ));
}
