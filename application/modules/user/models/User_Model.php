<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CRUD_Model {
	protected $table_name = "users";
	protected $primary_key = "user_id";

	public $editable_column = array(
		'username',
		'password',
		'name',
		'capability',
	);

	protected $view = array(
		'select'	=>array(
			'users.user_id', 
			'username', 
			'name',  
			"(case
				when capability = 1 then 'admin'
				else 'nonactive'
			end) as capability",
			'logincount',
			'lastlogin',
		),
	);

	public function __construct()
	{
		parent::__construct();
	}

	public function current_user_data($key){
		$allowed_data = array('user_id', 'username', 'name', 'capability');
		if (!$key || in_array($key, $allowed_data)) {
			$data = $this->session->userdata('current_user');
			if (isset($data['username']) && isset($data['token'])) {
				$data_user = parent::get_view(array(
					'where' => array(
						'username' 	=> $data['username'], 
						'token' 	=> $data['token'],
						'token != '	=> "",
					),
				));

				if($data_user){
					if (!$key) {
						return (array)$data_user;
					}else{
						return $data_user->$key;
					}
				}else{
					parent::update(array('username' => $data['username']), array('token' => ""));
				}
			}
		}
		return false;
	}

	public function login($username , $password, $remember = false)
	{
		$user_data = parent::get(array('where' => array('username' => $username, )));

		if ($user_data != null) {
			if ($user_data->password == $this->get_pwd($password)) {

				parent::update( $user_data->user_id, array( 
					'logincount' 	=> ($user_data->logincount) + 1,
					'lastlogin' 	=> date('Y-m-d H:i:s'),
					'token'			=> sha1(rand(1, 10000000000)),
				));

				$sess_array = (array)parent::get($user_data->user_id);
				$allowed_session = array('username', 'token');
				$sess_array = array_input_filter($sess_array, $allowed_session);

				if ($remember) {
					set_cookie('current_user', serialize($sess_array), time()+60*60*24*30 );
				}else{
					$this->session->sess_expire_on_close = TRUE;
				}
				
				$this->session->set_userdata('current_user', $sess_array);
				
				return array(
					'value' => true,
					'message' => "Success Login, Selamat datang ".$user_data->name."."
				);
			}else{
				return array(
					'value' => false,
					'message' => "Password Salah."
				);
			}
		}else{
			return array(
				'value' => false,
				'message' => "Username Tidak Ditemukan."
			);
		}
	}

	public function username_exists($username)
	{
		if (parent::get(array('where' => array('username' => $username))) != null) {
			return true;
		}
		return false;
	}

	public function logout(){
		parent::update($this->current_user_data('user_id'), array('token' => ""));
		$this->session->unset_userdata('current_user');
		delete_cookie('current_user');
	}

	public function create( $args )
	{
		$args['password'] = $this->get_pwd($args['password']);
		return parent::create($args);
	}

	public function update( $id, $args )
	{
		if (isset($args['password']))
			$args['password'] = $this->get_pwd($args['password']);
		return parent::update( $id, $args );
	}

	private function get_pwd($password){
		return md5('b'.$password);
	}

}