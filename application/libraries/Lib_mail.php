<?php

class Lib_mail
{
    protected $Con_file;
    public function __construct()
    {
        log_message('Debug', 'PHPMailer class is loaded.');
        $this->con_file =& get_instance();
        $this->con_file->load->config('authmail');
    }
    
    public function path($file = ''){
        $p = require_once(APPPATH.'third_party/PHPMailer/src/'.$file);
        return $p;
    }

    public function con_item($item = '')
    {
        $itemconfig = $this->con_file->config->item($item);
        return $itemconfig;
    }


    public function load($email_to, $subject, $content)
    {
        $this->path('PHPMailer.php');
        $this->path('Exception.php');
        $this->path('SMTP.php');
        $objMail = new PHPMailer\PHPMailer\PHPMailer(true);
        $objMail->isSMTP();
		$objMail->SMTPDebug = 2;
        $objMail->Host     = $this->con_item('smtp_host');
        $objMail->SMTPAuth = $this->con_item('smtp_auth');
        $objMail->Username = $this->con_item('smtp_user');
        $objMail->Password = $this->con_item('smtp_pass');
        $objMail->SMTPSecure = $this->con_item('smtp_secure');
        $objMail->Port     =  $this->con_item('smtp_port');
        $objMail->setFrom($this->con_item('smtp_user'), $this->con_item('smtp_header'));
        $objMail->isHTML($this->con_item('smtp_isHtml'));
        $objMail->addAddress($email_to);
        $objMail->Subject = $subject;
        $objMailContent = $content;
        $objMail->Body = $objMailContent;
        $objMail->send();
        return $objMail;
    }
}
