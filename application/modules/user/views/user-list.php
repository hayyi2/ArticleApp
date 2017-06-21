<div class="page-header">
	<h2>Data Admin</h2>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>List User</h4>
	</div>
	<table class="table table-striped table-hover data">
		<thead>
			<tr>
				<th width="1" class="text-nowrap">No</th>
				<th>Name</th>
				<th>Username</th>
				<th>Login</th>
				<th>Last Login</th>
				<th width="1" >Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 1;
			foreach ($user_data as $item): ?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $item->name; ?></td>
				<td><?php echo $item->username; ?></td>
				<td><?php echo $item->logincount.' kali'; ?></td>
				<td><?php echo time_formating($item->lastlogin); ?></td>
				<td class="text-nowrap">
					<!-- <a href="<?php url('user/edit/'.$item->user_id) ?>" class="btn btn-info btn-xs">
						<i class="fa fa-edit"></i>  edit
					</a> -->
					<a href="<?php url('user/delete/'.$item->user_id) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah anda yakin akan hapus data?')">
						<i class="fa fa-trash"></i> delete
					</a>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>