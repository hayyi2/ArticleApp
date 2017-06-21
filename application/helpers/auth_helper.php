<?php 

function current_user_data($key = false)
{
	$CI =& get_instance();
	return $CI->User_Model->current_user_data($key);
}

function protected_page($access = 'no_user'){
	$capability = current_user_data('capability');
	$login_url 	= 'user/login';
	$no_go 		= array('user/logout');

	switch ($access) {
		case 'no_user': 
			if ($capability) {
				set_message_flash('Anda telah login.');
				redirect('');
			}
		break;
		case 'login': 
			if (!$capability) {
				set_message_flash('Anda Harus Login Dagulu.');
				
				$uri_string = uri_string();
				if( !in_array( $uri_string, $no_go))
					$login_url .= ('?go='.$uri_string);

				redirect($login_url);
			}
		break;
		case 'admin': 
			if ($capability != 'admin') {
				show_404();
			}
		break;
		default: 
			if ($capability && $capability != $access) {
				set_message_flash('Anda tidak boleh mengakses halaman tersebut.');
				redirect('');
			}else if(!$capability){
				set_message_flash('Anda harus login dahulu.');

				$uri_string = uri_string();
				if( !in_array( $uri_string, $no_go))
					$login_url .= ('?go='.$uri_string);

				redirect($login_url);
			}
		break;
	}
	
}