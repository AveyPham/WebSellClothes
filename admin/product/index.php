<?php
	$title = 'Quản Lý Sản Phẩm';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	$sql = "select Product.*,product_detail.*, Category.name as category_name,color.name as color_name,size.name as size_name from Product left join Category on Product.category_id = Category.id left join product_detail on Product.id = product_detail.product_id  left join size on product_detail.size_id = size.id left join color on product_detail.color_id = color.id where Product.deleted = 0";
	$data = executeResult($sql);
?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3 style="margin-top: 50px;">Quản Lý Sản Phẩm</h3>

		<a href="editor.php"><button class="btn btn-success">Thêm Sản Phẩm</button></a>

		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Thumbnail</th>
					<th>Tên Sản Phẩm</th>
					<th>Số lượng</th>
					<th>Kích cỡ</th>
					<th>Màu sắc</th>
					<th>Giá</th>
					<th>Danh Mục</th>
					<th style="width: 50px"></th>
					<th style="width: 50px"></th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		// if($item['color']=='black'){
		// 	$color='Đen';
		// }
		// else if($item['color']=='white'){
		// 	$color='Trắng';
		// }
		echo '<tr>
					<th>'.(++$index).'</th>
					<td><img src="'.fixUrl($item['thumbnail']).'" style="height: 100px"/></td>
					<td>'.$item['title'].'</td>
					<td>'.$item['num'].'</td>
					<td>'.$item['size_name'].'</td>
					<td>'.$item['color_name'].'</td>
					<td>'.number_format($item['discount']).' VNĐ</td>
					<td>'.$item['category_name'].'</td>
					<td style="width: 50px">
						<a href="editor.php?id='.$item['id'].'"><button class="btn btn-warning">Sửa</button></a>
					</td>
					<td style="width: 50px">
						<button onclick="deleteProduct('.$item['id'].')" class="btn btn-danger">Xoá</button>
					</td>
				</tr>';
	}
?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function deleteProduct(id) {
		option = confirm('Bạn có chắc chắn muốn xoá sản phẩm này không?')
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