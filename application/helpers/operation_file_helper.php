<?php 

function get_upload($file){
	echo base_url('uploads/'.$file);
}

function upload_file($post, $name){
	$CI =& get_instance();
	$CI->load->library('upload');

	$config['file_name'] 	 = $name;
	$config['upload_path']   = './uploads/';
	$config['allowed_types'] = 'jpg|jpeg|gif|png';

	$CI->upload->initialize($config);

	if ( $CI->upload->do_upload($post)){
		$file_data = $CI->upload->data();

		return $file_data['file_name'];
	}
	
	return false;
}

function upload_multi_file($post, $name){
	$CI =& get_instance();
	$CI->load->library('upload');

	$config['file_name'] 	 = $name;
	$config['upload_path']   = './uploads/';
	$config['allowed_types'] = 'jpg|jpeg|gif|png';

	$CI->upload->initialize($config);

	if ( $CI->upload->do_upload($post)){
		$file_data = $CI->upload->data();

		return $file_data['file_name'];
	}
	
	return false;
}

function rename_file($name, $new_name){
	$ext = explode(".", $name);
	$new_name .= (".".end($ext));
	rename('./uploads/'.$name, './uploads/'.$new_name);
	return $new_name;
}


function delete_file($name){
	if (file_exists('./uploads/'.$name)) {
		unlink('./uploads/'.$name);
	}
}
