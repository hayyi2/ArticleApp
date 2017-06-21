<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['app_name'] 	= 'App_Article';
$config['app_version'] 	= '1.0';

$config['capability'] = array('nonaktif', 'admin');

$config['main_menu'] = array(
	array(
		'id' 	=> 'article',
		'label' => 'Data Article',
		'url'	=> 'article',
		'capability' => array('admin'),
	),
	array(
		'id' 	=> 'add-article',
		'label' => 'Add Article',
		'url'	=> 'article/input',
		'capability' => array('admin'),
	),
	array(
		'id' 	=> 'user',
		'label' => 'Data User',
		'url'	=> 'user/view',
		'capability' => array('admin'),
	),
);