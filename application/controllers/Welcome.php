<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function  __construct(){
		parent::__construct();
		$this->load->library("lib_mail");
		$this->load->model('master_model');
	} 
	
	public function index()
	{
		$this->load->view('form');
	}

	public function sendMail($email_from, $subject, $content)
	{
		$mail = $this->lib_mail->load($email_from, $subject, $content);
		// Send email
		// $mail->send();
        if(!$mail->send()){
            $response = echo 'Message could not be sent.<br>
                  Mailer Error: ' . $mail->ErrorInfo;
        }else{
            $response = echo 'Message has been sent';
		}
		return $response;
	}

	public function cek_data($table, $email, $phone)
	{
		$where = array('email' => $email);
		$or_where = array('phone' => $phone);
		$cek = $this->master_model->getwhere($table, $where, $or_where)->num_rows();
		if ($cek > 0){
			$nodouble = false;
		}else{
			$nodouble = true;
		}
		return $nodouble;
	}

	public function create_uniqecode($table, $field){
		$data = $this->master_model->select_maxe($table, $field);
		foreach($data->result_array() as $row){
			$data = $row[$field];
			if ($data == null){
				$data = 'C01';
			}else{
				$number = (int) substr($data, 1, 2);
				$number++;
				$char = "C";
				$data = $char . sprintf("%02s",$number);
			}
		}		
		return $data;
	}

	public function submit()
	{
		$subject = 'Send Codeunik for user';
		$table = 'user';
		$field = 'coupon';
		$nama = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');

		//cek data
		$cek = $this->cek_data($table, $email, $phone);
		// print_r($cek);
		// exit;
		if($cek == true){

			//insert codeunik
			$codeunik = $this->create_uniqecode($table, $field);
			$data = array(
				'nama' => $nama,
				'email' => $email,
				'phone' => $phone,
				'coupon' => $codeunik
			);
			$content = '<h1>'.$codeunik.'</h1>
			<p>This is a your code unik.</p>';
			$this->master_model->insert_data($table, $data);
			$this->sendMail($email, $subject, $content);
		}else{
			echo 'data sudah ada';
		}
	}
}
