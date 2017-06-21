<?php get_message_flash() ?>
<form class="panel panel-default" method="post"  action="<?php echo $mode == 'add' ? url('article/input') : url('article/edit/' . $data->article_id) ?>" >
	<?php token() ?>
	<div class="panel-heading">
		<?php if ($mode == "edit"): ?>
		<div class="pull-right">
			<a href="<?php url('article/input') ?>" class="btn btn-primary btn-xs">
				<i class="fa fa-plus"></i> Tambah Data
			</a>
		</div>
		<?php endif ?>
		<h4><?php echo $mode == 'add' ? 'Tambahkan' : 'Edit'  ?> Article</h4>
	</div>
	<div class="panel-body">
		<div class="form-horizontal form-input" role="form">
			<div class="form-group">
				<label class="col-xs-3 control-label">Title Article</label>
				<div class="col-xs-9">
					<input value="<?php if(isset($data->title)) echo $data->title; ?>" type="text" class="form-control" name="title" placeholder="title" required="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">Content Article</label>
				<div class="col-xs-9">
					<textarea class="form-control tinymce-lg" name="content" placeholder="Keterangan"><?php if(isset($data->content)) echo $data->content; ?></textarea>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-footer text-right">
		<a href="<?php url('article') ?>" class="btn btn-default" >Back to List</a>
		<button class="btn btn-primary" type="submit"><?php echo $mode == 'add' ? 'Tambahkan' : 'Edit'  ?> Data</button>
	</div>
</form>