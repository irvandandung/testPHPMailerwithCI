<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

//Set the hostname of the mail server
$config['smtp_host'] = 'gmckosmetik.com';

//Whether to use SMTP authentication
$config['smtp_auth'] = true; 

//Set the encryption system to use - ssl (deprecated) or tls
$config['smtp_secure'] = 'ssl'; 

//Username to use for SMTP authentication - use full email address for gmail or Outlook
$config['smtp_user'] = 'youremail';

//Password to use for SMTP authentication
$config['smtp_pass'] = 'yourpassword';

//Set the SMTP port number - likely to be 25, 465 or 587
$config['smtp_port'] = 465;

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$config['smtp_debug'] = 2; 

//Title or header this email
$config['smtp_header'] = 'Dandung';

//set isHtml = true
$config['smtp_isHtml'] = True;