

<?php
	$title = 'Quản Lý Đơn Hàng';
	$baseUrl = '../';
	require_once('../layouts1/header.php');

	$user=getUserToken();
	if($user!=null){
		$user_id=$user['id'];
	}
	//pending, approved, cancel
	$sql = "select * from Orders where user_id = '$user_id' order by status asc, order_date desc";
	$data = executeResult($sql);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3 style="margin-top: 50px;">Quản Lý Đơn Hàng</h3>

		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Họ & Tên</th>
					<th>SĐT</th>
					<th>Email</th>
					<th>Địa Chỉ</th>
					<th>Nội Dung</th>
					<th>Tổng Tiền</th>
					<th>Ngày Tạo</th>
					<th style="width: 120px"></th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		echo '<tr>
					<th>'.(++$index).'</th>
					<td><a href="detail.php?id='.$item['id'].'">'.$item['fullname'].'</a></td>
					<td><a href="detail.php?id='.$item['id'].'">'.$item['phone_number'].'</a></td>
					<td><a href="detail.php?id='.$item['id'].'">'.$item['email'].'</a></td>
					<td>'.$item['address'].'</td>
					<td>'.$item['note'].'</td>
					<td>'.number_format($item['total_money']).' VNĐ</td>
					<td>'.$item['order_date'].'</td>
					<td style="width: 50px">';
		if($item['status'] == 0) {
			echo '
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
	require_once('../layouts1/footer.php');
?>