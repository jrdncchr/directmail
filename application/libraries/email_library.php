<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Email_Library {

    private $api_key;
    private $from;

    function __construct()
    {
        $this->api_key = SEND_GRID_API_KEY;
        $this->from = "Direct Mail <support@directmail.com>";
    }

    public function send_email($email)
    {
        if (isset($email['from'])) {
            $this->from = $email['from'];
        }

        $from = new SendGrid\Email(null, $this->from);
        $subject = $email['subject'];
        $to = new SendGrid\Email(null, $email['to']);
        $content = new SendGrid\Content("text/html", $email['content']);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $sg = new \SendGrid($this->api_key);
        $response = $sg->client->mail()->send()->post($mail);
        return $response->statusCode();
    }

    public function send_email_confirmation($data)
    {
        $email['subject'] = "Direct Mail - Email Confirmation";
        $email['content'] = "<p>Hi " . $data['name'] . ", </p>";
        $email['content'] .= "<p>Welcome to Direct Mail, you are now registered with your company <b>" . $data['company'] . "</b>. </p>";
        if (isset($data['password'])) {
            $email['content'] .= "<p>Your password is: " . $data['password'] . "</p>";
        }
        $email['content'] .= "<p>Please confirm your account by clicking the link below: </p>";
        $email['content'] .= "<a href='" . base_url() . "auth/confirm/" . $data['confirmation_key'] . "'>Confirm Account</a>";
        $email['to'] = $data['to'];
        $this->send_email($email);
    }

    public function send_new_company_email_confirmation($data)
    {
        $email['subject'] = "Direct Mail - New Company Email Confirmation";
        $email['content'] = "<p>Hi " . $data['name'] . ", </p>";
        $email['content'] .= "<p>Welcome to Direct Mail, you are now registered as an administrator with your company " . $data['company'] . ". </p>";
        $email['content'] .= "<pYour company key is:  " . $data['company_key'] . ". </p>";
        $email['content'] .= "<p>Your password is: " . $data['password'] . "</p>";
        $email['content'] .= "<p>Please confirm your account and company by clicking the link below: </p>";
        $email['content'] .= "<a href='" . base_url() . "auth/confirm_company/" . $data['confirmation_key'] . "'>Confirm Account & Company</a>";
        $email['to'] = $data['to'];
        $this->send_email($email);
    }

}
