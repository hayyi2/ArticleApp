<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set("Asia/Jakarta");
		protected_page('admin');

		$this->load->model('Article_Model');
	}

	public function index()
	{
		$data_article = $this->Article_Model->gets();

		$per_page = 10;
		$page = ($this->input->get('page'))? $this->input->get('page') : 1;
		if ($per_page*$page > count($data_article)) {
			$last =  count($data_article);
		}else{
			$last =  $per_page*$page;
		}

		for ($i=($page-1)*$per_page; $i < $last; $i++) { 
			$data[] = $data_article[$i];
		}

		$param = array(
			'title'			=> 'Data Article',
			'active_menu'	=> 'article',
			'data'			=> $data,
			'jumlah'		=> count($data_article),
		);

		$this->load->view('header', $param );
		$this->load->view('article-list', $param );
		$this->load->view('footer', $param );
	}

	public function input()
	{
		$param = array(
			'title'			=> "Input Article",
			'active_menu'	=> "add-article",
			'mode'			=> "add",
		);

		if ($post = $this->input->post()) {

			$form_valid = form_valid( $post , array(
				'title'			=> array('Title Article', 'need'),
				'content'		=> array('Content Article', 'need'),
			)); 

			if( !$form_valid['value'] ){
				$param['post']   = (object)$post;
				foreach ($form_valid['errors'] as $value) {
					$error = $value; break;
				}
				set_message_flash($value);
			} else {
				$allowed_add    	= $this->Article_Model->editable_column;
				$article_data      	= array_input_filter($post, $allowed_add);
				$insert_id      = $this->Article_Model->create( $article_data );

				set_message_flash('Success Input Article.', 'success');
				redirect('article/edit/'.$insert_id);
			}
		}

		$this->load->view('header', $param );
		$this->load->view('article-input', $param );
		$this->load->view('footer', $param );
	}

	public function edit($id = false)
	{
		$data_post = $this->Article_Model->get_view($id);

		if( !$data_post ){
			set_message_flash('Article Tidak Ditemukan.');
			redirect('article');
		}

		$param = array(
			'title'         => "Edit Article",
			'active_menu'   => "article",
			'mode'          => "edit",
			'data'          => $data_post,
		);


		if ($post = $this->input->post()) {

			$form_valid = form_valid( $post , array(
				'title'			=> array('Title Article', 'need'),
				'content'		=> array('Content Article', 'need'),
			)); 

			if( !$form_valid['value'] ){
				foreach ($form_valid['errors'] as $value) {
					$error = $value; break;
				}
				set_message_flash($value);

				$param['data'] = array_merge((array)$data_post, $post);
			} else {

				$allowed_add    = $this->Article_Model->editable_column;
				$article_data   = array_input_filter($post, $allowed_add);
				$insert_id      = $this->Article_Model->update( $data_post->article_id, $article_data );

				set_message_flash('Success Edit Article.', 'success');
				redirect('article/edit/'.$insert_id);
			}

		}

		$this->load->view('header', $param );
		$this->load->view('article-input', $param );
		$this->load->view('footer', $param );
	}

	public function delete($id = false)
	{
		$article_data = $this->Article_Model->get($id);

		if( !$article_data ){
			set_message_flash('Article Tidak Ditemukan.');
			redirect('article');
		}

		$this->Article_Model->delete($id);

		set_message_flash('Success Delete Article.', 'success');
		redirect('article');
	}

}