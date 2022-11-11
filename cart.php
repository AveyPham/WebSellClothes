<?php 
require_once('layouts/header.php');
?>
<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
	<div class="row">
		<table class="table table-bordered">
			<tr>
				<th>STT</th>
				<th>Thumbnail</th>
				<th>Tiêu Đề</th>
				<th>Kích cỡ</th>
				<th>Màu sắc</th>
				<th>Giá</th>
				<th>Số Lượng</th>
				<th>Tổng Giá</th>
				<th></th>
			</tr>
<?php
if(!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}
$index = 0;
$total=0;
foreach($_SESSION['cart'] as $item) {
	$total+=$item['discount']*$item['num'];
	if($item['discount'] > 0) {	
		echo '<tr>
			<td>'.(++$index).'</td>
			<td><img src="'.$item['thumbnail'].'" style="height: 80px"/></td>
			<td>'.$item['title'].'</td>
			<td>'.$item['size_name'].'</td>
			<td>'.$item['color_name'].'</td>
			<td>'.number_format($item['discount']).' VND</td>
			<td style="display: flex"><button class="btn btn-light" style="border: solid #e0dede 1px; border-radius: 0px;" onclick="addMoreCart('.$item['pro_id'].', -1)">-</button>
				<input type="number" id="num_'.$item['pro_id'].'" value="'.$item['num'].'" class="form-control" style="width: 90px; border-radius: 0px" onchange="fixCartNum('.$item['pro_id'].')"/>
				<button class="btn btn-light" style="border: solid #e0dede 1px; border-radius: 0px;" onclick="addMoreCart('.$item['pro_id'].', 1)">+</button>
			</td>
			<td>'.number_format($item['discount'] * $item['num']).' VND</td>
			<td><button class="btn btn-danger" onclick="updateCart('.$item['pro_id'].', 0)">Xoá</button></td>
		</tr>';
	}
	
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
				<th id="total_money"><?=number_format($total)?> VND</th>
				<td></td>
			</tr>
		</table>

	</div>
	<div class="row" style="margin-top :10px;margin-bottom:100px;">
		<div style="width:100%">
		<?php
			if($index>0){
				echo '<a href="checkout.php"><button class="btn btn-success" style="border-radius: 0px; font-size: 26px;float:left;margin:0px">Đặt hàng</button></a>';
			}
		?>
			<a href="#remove_cart"><button class="btn btn-secondary" style="border-radius: 0px; font-size: 26px;float:right;" onclick="removeAllCart()">XOÁ GIỎ HÀNG</button></a>

		</div>
	</div>
</div>
<script type="text/javascript">
	function addMoreCart(id, delta) {
		num = parseInt($('#num_' + id).val())
		num += delta;
		$('#num_' + id).val(num)
		updateCart(id, num)
	}

	function fixCartNum(id) {
		$('#num_' + id).val(Math.abs($('#num_' + id).val()))

		updateCart(id, $('#num_' + id).val())
	}

	function updateCart(productId, num) {
		$.post('api/ajax_request.php', {
			'action': 'update_cart',
			'id': productId,
			'num': num
		}, function(data) {
			location.reload()
		})
	}
	
	function removeAllCart() {
		option=confirm('Bạn có chắc chắn muôn xoá giỏ hàng này không?');
		if(option){
			$.post('api/ajax_request.php', {
			'action': 'remove_all_cart'
			}, function(data) {
				location.reload()
			})
		}
		
	}
</script>
<?php
require_once('layouts/footer.php');
?>