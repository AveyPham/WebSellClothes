<?php
	$title = 'Quản Lý Đơn Nhập';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	//pending, approved, cancel
	$sql = "select receipt.*, supplier.name as supplier_name,user.fullname as user_name from receipt left join supplier on receipt.supplier_id = supplier.id left join user on receipt.user_id = user.id order by status asc, receipt_date desc";
	$data = executeResult($sql);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3 style="margin-top: 50px;">Quản Lý Nhập</h3>

		<a href="editor.php"><button class="btn btn-success">Nhập đơn hàng</button></a>

		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Tên Nhà Cung Cấp</th>
					<th>Người nhập đơn</th>					
					<th>Tổng Tiền</th>
					<th>Ngày Nhập</th>
					<th style="width: 50px"></th>
					<th style="width: 120px"></th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		echo '<tr>
					<th>'.(++$index).'</th>
					<td><a href="detail.php?id='.$item['id'].'">'.$item['supplier_name'].'</a></td>
					<td><a href="detail.php?id='.$item['id'].'">'.$item['user_name'].'</a></td>					
					<td>'.number_format($item['total_money']).' VNĐ</td>
					<td>'.$item['receipt_date'].'</td>
					<td style="width: 50px">';
					if($item['status'] == 0 ){
						echo '<a href="editor.php?id='.$item['id'].'"><button class="btn btn-warning">Sửa</button></a>';
					}	
					echo '</td>
					
					<td style="width: 50px">';
					if($item['status'] == 0) {
						echo '<button onclick="changeStatus('.$item['id'].', 1)" class="btn btn-sm btn-success" style="margin-bottom: 10px;">Duyệt đơn</button>
						<button onclick="changeStatus('.$item['id'].', 2)" class="btn btn-sm btn-danger">Huỷ đơn</button>';
					} else if($item['status'] == 1) {
						echo '<label class="badge badge-success">Đã duyệt</label>';
					} else {
						echo '<label class="badge badge-danger">Đã huỷ</label>';
					}
					echo '</td>
			</tr>';
					

					
		
	}
?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function changeStatus(id, status) {
		$.post('form_api.php', {
			'id': id,
			'status': status,
			'action': 'update_status'
		}, function(data) {
			location.reload()
		})
	}
</script>

<?php
	require_once('../layouts/footer.php');
?>