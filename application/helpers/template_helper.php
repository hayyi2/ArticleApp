<?php 

function asset( $asset_url )
{
	echo base_url('assets/' . $asset_url );
}

function url( $asset_url = "" )
{
	echo base_url( $asset_url );
}

function link_get()
{
	$data = "?";
	$CI =& get_instance();
	$no = 1;
	foreach ($CI->input->get() as $key => $value) {
		if ($value != "") {
			$data .= (($no++ != 1) ? "&" : "").$key."=".$value;
		}
	}
	return ($data == "?" ? "" : $data);
}

function nama_bulan($index){
	$nama_bulan = array(
		'01' => "Januari",
		'02' => "Februari",
		'03' => "Maret",
		'04' => "April",
		'05' => "Mei",
		'06' => "Juni",
		'07' => "Juli",
		'08' => "Agustus",
		'09' => "September",
		'10' => "Oktober",
		'11' => "November",
		'12' => "Desember",
	);

	return $nama_bulan[$index];
}

// Penanganan format waktu
function time_formating($date)
{
	$new_date = date('d ', strtotime($date));
	$new_date .= nama_bulan(date('m', strtotime($date)));
	$new_date .= date(' Y', strtotime($date)).'<small> ('.date('H:i', strtotime($date)).')</small>';
	return $new_date;
}

function date_formating($date)
{
	$tanggal 	= date('d', strtotime($date));
	$bulan 		= nama_bulan(date('m', strtotime($date)));
	$tahun 		= date('Y', strtotime($date));
	return $tanggal.' '.$bulan.' '.$tahun;
}

// Penanganan format money
function money_formating($data)
{
	return "Rp ". number_format($data,0,',','.').",- ";
}

function token(){
	$CI =& get_instance();
	$token = $CI->session->userdata('token');

	if (isset($token)) {
		echo '<input type="hidden" name="token" value="'.$token.'">';
	}else{
		$token = sha1(rand(0, 1000000));
		
		$CI->session->set_userdata('token', $token);

		echo '<input type="hidden" name="token" value="'.$token.'">';
	}
}
function form_valid( $post , $post_valid ){
	$CI =& get_instance();

	$valid 	= true;
	$errors = array();

	$token = $CI->session->userdata('token');
	$CI->session->unset_userdata('token');

	if (!isset($post['token']) || $post['token'] != $token) {
		return array(
			'value' 	=> false,
			'errors' 	=> array('token' => 'Failed Form.', ),
		);
	}
	foreach ($post_valid as $key => $value) {
		if ($value[1] == 'need' && (!isset($post[$key]) || $post[$key] == "")) {
			$valid 			= false;
			$errors[$key] 	= $value[0].' Tidak Boleh Kosong.';
		}elseif(isset($value[2]['min']) && !(strlen($post[$key]) >= $value[2]['min'])){
			$valid 			= false;
			$errors[$key] 	= $value[0].' Minimal '.$value[2]['min'].' Karakter.';
		}elseif(isset($value[2]['max']) && !(strlen($post[$key]) <= $value[2]['max'])){
			$valid 			= false;
			$errors[$key] 	= $value[0].' Maksimal '.$value[2]['max'].' Karakter.';
		}
	}

	return array(
		'value' 	=> $valid,
		'errors' 	=> $errors
	);
}

function words_cut($words, $no){
	$array_words = explode(" ", strip_tags($words));

	if (count($array_words) <= $no) {
		return strip_tags($words);
	}

	for ($i=0; $i <= $no; $i++) {
		$new_words[] = $array_words[$i]; 
	}
	return strip_tags(implode(" ", $new_words)). " [...]";
}

function gets_category(){
    $CI =& get_instance();
    $CI->load->model('category/Category_Model');
    return $CI->Category_Model->gets_view();
}