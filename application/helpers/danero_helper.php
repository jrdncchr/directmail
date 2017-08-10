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

function get_start_and_end_date_current_month() 
{
    $month_start_ts = strtotime('first day of this month', time());
    $month_end_ts = strtotime('last day of this month', time());
    return [
        'start' => date('Y-m-d', $month_start_ts),
        'end' => date('Y-m-d', $month_end_ts)
    ];
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

function setTemporaryFile($name, $content)
{
    $file = DIRECTORY_SEPARATOR .
            trim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) .
            DIRECTORY_SEPARATOR .
            ltrim($name, DIRECTORY_SEPARATOR);

    $x = file_put_contents($file, $content);

    // register_shutdown_function(function() use($file) {
    //     unlink($file);
    // });

    // return $file;
}

function getTemporaryFileContent($name)
{
    $file = DIRECTORY_SEPARATOR .
            trim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) .
            DIRECTORY_SEPARATOR .
            ltrim($name, DIRECTORY_SEPARATOR);
    return file_get_contents($file);
}