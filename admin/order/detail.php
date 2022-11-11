<?php
	$title = 'Thông Tin Chi Tiết Đơn Hàng';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	$orderId = getGet('id');

	#left join color on product_detail.color_id = color.id left join size on product_detail.size_id = size.id
	#, size.name as size_name, color.name as color_name
	$sql = "select Order_Details.*, Product.title, Product.thumbnail,size.name as size_name, color.name as color_name from Order_Details left join Product on Product.id = Order_Details.product_id left join color on order_details.color_id = color.id left join size on order_details.size_id = size.id where Order_Details.order_id = $orderId";
	$data = executeResult($sql);

	$sql = "select * from Orders where id = $orderId";
	$orderItem = executeResult($sql, true);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
		<h3 style="margin-top: 50px;">Chi Tiết Đơn Hàng</h3>
	</div>
	<div class="col-md-8 table-responsive">
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Thumbnail</th>
					<th>Tên Sản Phẩm</th>
					<th>Màu Sắc</th>
					<th>Kích Cỡ</th>
					<th>Giá</th>
					<th>Số Lượng</th>
					<th>Tổng Giá</th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		echo '<tr>
				  	<th>'.(++$index).'</th>
					<td><img src="'.fixUrl($item['thumbnail']).'" style="height: 120px"/></td>
					<td>'.$item['title'].'</td>
					<td>'.$item['color_name'].'</td>
					<td>'.$item['size_name'].'</td>
					<td>'.number_format($item['price']).' VNĐ</td>
					<td>'.number_format($item['num']).'</td>
					<td>'.number_format($item['price']*$item['num']).' VNĐ</td>
				</tr>';
	}
?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<th>Tổng Tiền</th>
					<th><?=number_format($orderItem['total_money'])?></th>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-4">
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<tr>
				<th>Họ & Tên: </th>
				<td><?=$orderItem['fullname']?></td>
			</tr>
			<tr>
				<th>Email: </th>
				<td><?=$orderItem['email']?></td>
			</tr>
			<tr>
				<th>Địa Chỉ: </th>
				<td><?=$orderItem['address']?></td>
			</tr>
			<tr>
				<th>Phone: </th>
				<td><?=$orderItem['phone_number']?></td>
			</tr>
		</table>
	</div>
</div>
<?php
	require_once('../layouts/footer.php');
?>