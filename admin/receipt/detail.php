<?php
	$title = 'Thông Tin Chi Tiết Đơn Nhập';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	$receiptId = getGet('id');

	$sql = "select receipt_detail.*, Product.title, Product.thumbnail, size.name as size_name, color.name as color_name from receipt_detail left join Product on Product.id = receipt_Detail.product_id left join size on size.id = receipt_Detail.size_id left join color on color.id = receipt_Detail.color_id where receipt_detail.receipt_id = $receiptId";
	$data = executeResult($sql);

	$sql = "select receipt.*, supplier.name as sup_name, user.fullname as user_name from receipt join supplier on supplier.id = receipt.supplier_id join user on user.id = receipt.user_id where receipt.id = $receiptId";
	$receiptItem = executeResult($sql, true);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
		<h3 style="margin-top: 50px;">Chi Tiết Đơn Nhập</h3>
	</div>
	<div class="col-md-8">
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Thumbnail</th>
					<th>Tên Sản Phẩm</th>
					<th>Kích cỡ</th>
					<th>Màu sắc</th>
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
					<td>'.$item['size_name'].'</td>
					<td>'.$item['color_name'].'</td>
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
					<td></td>
					<td></td>
					<th>Tổng Tiền</th>
					<th><?=number_format($receiptItem['total_money'])?></th>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-4">
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<tr>
				<th>Nhà cung cấp: </th>
				<td><?=$receiptItem['sup_name']?></td>
			</tr>
			<tr>
				<th>Người nhập: </th>
				<td><?=$receiptItem['user_name']?></td>
			</tr>
			
		</table>
	</div>
</div>
<?php
	require_once('../layouts/footer.php');
?>