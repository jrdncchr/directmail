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