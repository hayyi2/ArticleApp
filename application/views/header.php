<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?php echo (isset($title) ? $title . ' - ' : '') . $this->config->item('app_name'); ?></title>
	
	<!-- Bootstrap Core CSS -->
	<link href="<?php asset('css/bootstrap.css') ?>" rel="stylesheet">
	
	<!-- Font Awesome -->
	<link href="<?php asset('css/font-awesome.min.css') ?>" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="<?php asset('css/style.css') ?>" rel="stylesheet">

	<!-- jQuery -->
	<script src="<?php asset('js/jquery.min.js') ?>"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="<?php asset('js/bootstrap.min.js') ?>"></script>

	<!-- text editor tinymce -->
	<script type="text/javascript" src="<?php asset('plugins/tinymce/tinymce.min.js'); ?>"></script>

	<!-- script -->
	<script src="<?php asset('js/script.js') ?>"></script>

</head>
<body>
<header>
	<nav class="navbar navbar-default">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" title="<?php echo($this->config->item('app_name')) ?>" href="<?php url() ?>"><?php echo($this->config->item('app_name')) ?></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
				<?php 
				$menu = $this->config->item('main_menu');
				foreach ($menu as $item_menu): ?>
					<?php if (in_array(current_user_data('capability'), $item_menu['capability'])): ?>
						<li<?php if (isset($active_menu) && $active_menu == $item_menu['id']) echo ' class="active"';?>><a href="<?php url($item_menu['url']) ?>"><?php echo($item_menu['label']) ?></a></li>
					<?php endif ?>
				<?php endforeach ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php if (current_user_data('user_id') == ""): ?>
						<li<?php if (isset($active_menu) && $active_menu == "login") echo ' class="active"';?>><a href="<?php url('user/login') ?>">Login</a></li>
					<?php else: ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								<span class="avatar" ><?php echo substr(current_user_data('name'), 0, 1) ?></span>
								<span><?php echo current_user_data('name') ?></span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<!-- <li><a href="<?php url('user/profile') ?>">Edit Profile</a></li>
								<li class="divider"></li> -->
								<li><a href="<?php url('user/logout') ?>">Logout</a></li>
							</ul>
						</li>
					<?php endif ?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
</header>
<div class="body">
	<div class="container">