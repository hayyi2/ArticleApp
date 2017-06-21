<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_Model extends CRUD_Model {
	protected $table_name = "articles";
	protected $primary_key = "article_id";

	public $editable_column = array(
		'title',
		'content',
	);

	protected $view = array();

}