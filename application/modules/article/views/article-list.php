<?php get_message_flash() ?>
<div class="page-header">
	<h2>Data Article</h2>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="pull-right">
			<a href="<?php url('article/input') ?>" class="btn btn-primary btn-xs">
				<i class="fa fa-plus"></i> Tambah Data
			</a>
		</div>
		<h4>List Article</h4>
	</div>
	<table class="table table-striped table-hover data">
		<thead>
			<tr>
				<th width="1" class="text-nowrap">No</th>
				<th>Title</th>
				<th>Content</th>
				<th>Created at</th>
				<th width="1" >Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 1;
			foreach ($data as $item): ?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $item->title; ?></td>
				<td><?php echo $item->content; ?></td>
				<td><?php echo time_formating($item->created_at); ?></td>
				<td class="text-nowrap">
					<a href="<?php url('article/edit/'.$item->article_id) ?>" class="btn btn-info btn-xs">
						<i class="fa fa-edit"></i>  edit
					</a>
					<a href="<?php url('article/delete/'.$item->article_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah anda yakin akan hapus data?')">
						<i class="fa fa-trash"></i> delete
					</a>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
