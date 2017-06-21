<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set("Asia/Jakarta");
	}

	public function index()
	{
		$this->login();
	}
	
	/*
	| Login
	*/

	public function login()
	{
		protected_page();

		$param = array(
			'title' 		=> 'Login',
		);
		
		if ($go = $this->input->get('go')) {
			$param['go'] = $go;
		}

		if ($post = $this->input->post()) {
			$form_valid = form_valid( $post , array()); 
			
			if( !$form_valid['value'] ){
				$param['post'] 	 = (object)$post;
				set_message_flash('Failed Login.');
			} else {
				$remember = false; 
				if (isset($post['remember']) && $post['remember']) {
					$remember = $post['remember']; 
				}

				$login = $this->User_Model->login($post['username'], $post['password'], $remember);
				if ($login['value']) {
					set_message_flash($login['message'], 'success');
					if (isset($post['go'])) {
						redirect($post['go']);
					}
					redirect('');
				}else{
					$param['post'] 	 = (object)$post;
					set_message_flash($login['message']);
				}
			}
		}
		
		$this->load->view('header', $param );
		$this->load->view('login', $param );
		$this->load->view('footer', $param );
	}
	
	public function logout()
	{
		if (is_null(current_user_data())) {
			set_message_flash('Anda harus login dahulu.');
			redirect('login');
		}

		$this->User_Model->logout();
		set_message_flash('Success Log Out', 'success');
		redirect('user/login');
	}

	/*
	| CRUD User
	*/

	public function view()
	{
		protected_page('admin');
		
		$param = array(
			'title'         => 'Data Admin', 
			'active_menu'   => 'user',
			'user_data'     => $this->User_Model->gets(),
		);

		$this->load->view('header', $param );
		$this->load->view('user-list', $param );
		$this->load->view('footer', $param );
	}

	// public function input()
	// {
	// 	protected_page('admin');

	// 	$param = array(
	// 		'title'         => "Input Admin",
	// 		'active_menu'   => "admin",
	// 		'mode'          => "add",
	// 	);

	// 	if ($post = $this->input->post()) {

	// 		$form_valid = form_valid( $post , array(
	// 			'name'      => array('Name',    'need', array('max' => 100 )),
	// 			'username'  => array('Username','need', array('max' => 100 )),
	// 			'password'  => array('Password', 'need'),
	// 		)); 

	// 		if( !isset($form_valid['errors']['username']) && $this->User_Model->username_exists($post['username'])) {
	// 			$form_valid['value']                = false;
	// 			$form_valid['errors']['username']   = "Username sudah ada yang menggunakan.";
	// 		}

	// 		if( !$form_valid['value'] ){
	// 			$param['post']   = (object)$post;
	// 			foreach ($form_valid['errors'] as $value) {
	// 				$error = $value; break;
	// 			}
	// 			set_message_flash($value);
	// 		} else {
	// 			$allowed_add    = $this->User_Model->editable_column;
	// 			$data           = array_input_filter($post, $allowed_add);
	// 			$data['capability'] = 2;
	// 			$insert_id      = $this->User_Model->create( $data );

	// 			set_message_flash('Success Input Admin.', 'success');
	// 			redirect('user/admin');
	// 		}
	// 	}

	// 	$this->load->view('admin-header', $param );
	// 	$this->load->view('admin-input', $param );
	// 	$this->load->view('admin-footer', $param );
	// }

	// public function edit($id = false)
	// {
	// 	protected_page('admin');

	// 	if( !$this->User_Model->get($id) ){
	// 		set_message_flash('Admin Tidak Ditemukan.');
	// 		redirect('user/admin');
	// 	}

	// 	$data_post = $this->User_Model->get($id);

	// 	$param = array(
	// 		'title'         => "Edit Admin",
	// 		'active_menu'   => "admin",
	// 		'mode'          => "edit",
	// 		'post'          => $data_post,
	// 	);


	// 	if ($post = $this->input->post()) {

	// 		$form_valid = form_valid( $post , array(
	// 			'name'      => array('Name',    'need', array('max' => 100 )),
	// 			'username'  => array('Username','need', array('max' => 100 )),
	// 		)); 

	// 		if( !isset($form_valid['errors']['username']) && 
	// 			$this->User_Model->username_exists($post['username']) &&
	// 			$post['username'] != $data_post->username) {
	// 			$form_valid['value']                = false;
	// 			$form_valid['errors']['username']   = "Username sudah ada yang menggunakan.";
	// 		}

	// 		if ($post['password'] == "") {
	// 			unset($post['password']);
	// 		}

	// 		if( !$form_valid['value'] ){
	// 			foreach ($form_valid['errors'] as $value) {
	// 				$error = $value; break;
	// 			}
	// 			set_message_flash($value);

	// 			$param['post'] = array_merge((array)$data_post, $post);
	// 		} else {
	// 			$allowed_add    = $this->User_Model->editable_column;
	// 			$data           = array_input_filter($post, $allowed_add);
	// 			$insert_id      = $this->User_Model->update( $id, $data );

	// 			set_message_flash('Success Edit Admin.', 'success');
	// 			redirect('user/admin');
	// 		}

	// 	}

	// 	$this->load->view('admin-header', $param );
	// 	$this->load->view('admin-input', $param );
	// 	$this->load->view('admin-footer', $param );
	// }

	// public function delete($id = false)
	// {
	// 	protected_page('admin');

	// 	if( !$this->User_Model->get($id) ){
	// 		set_message_flash('Admin Tidak Ditemukan.');
	// 		redirect('user/admin');
	// 	}

	// 	$this->User_Model->delete($id);

	// 	set_message_flash('Success Delete Admin.', 'success');
	// 	redirect('user/admin');
	// }
}