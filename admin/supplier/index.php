<?php
	$title = 'Quản Lý Nhà Cung Cấp';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	$sql = "select * from supplier";
	$data = executeResult($sql);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3 style="margin-top: 50px;">Quản Lý Nhà Cung Cấp</h3>

		<!-- <a href="editor.php"><button class="btn btn-success">Thêm Nhà Cung Cấp</button></a> -->

		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Tên Nhà Cung Cấp</th>
					<th>Email</th>
					<th>SĐT</th>
					<th>Địa Chỉ</th>					
					<th style="width: 50px"></th>
					<th style="width: 50px"></th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		echo '<tr>
					<th>'.(++$index).'</th>
					<td>'.$item['name'].'</td>
					<td>'.$item['email'].'</td>
					<td>'.$item['phone_number'].'</td>
					<td>'.$item['address'].'</td>					
					<td style="width: 50px">
					<a href="editor.php?id='.$item['id'].'"><button class="btn btn-warning">Sửa</button></a>
				</td>
				<td style="width: 50px">
					<button onclick="deleteSupplier('.$item['id'].')" class="btn btn-danger">Xoá</button>
				</td>
				</tr>';
	}
?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function deleteSupplier(id) {
		option = confirm('Bạn có chắc chắn muốn xoá nhà cung cấp này không?');
		if(!option) return;

		$.post('form_api.php', {
			'id': id,
			'action': 'delete'
		}, function(data) {
			location.reload()
		})
	}
</script>

<?php
	require_once('../layouts/footer.php');
?>