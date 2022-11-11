<?php 
require_once('layouts/header.php');

// $user_id = getGet('id');
// $sql = "select user.*, token.user_id as user_id from user left join token on token.user_id = user.id where user.id = $productId";
// $product = executeResult($sql, true);
$user = $_SESSION['user']


?>
<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
	<form method="post" onsubmit="return completeCheckout();">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			  <input required="true" value="<?=$user['fullname']?>" type="text" class="form-control" id="usr" name="fullname" placeholder="Nhập họ tên">
			</div>
			<div class="form-group">
			  <input required="true" value="<?=$user['email']?>" type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
			</div>
			<div class="form-group">
			  <input required="true" value="<?=$user['phone_number']?>" type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập sđt">
			</div>
			<div class="form-group">
			  <input required="true" value="<?=$user['address']?>" type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ">
			</div>
			<div class="form-group">
			  <label for="pwd">Nội dung:</label>
			  <textarea class="form-control" rows="3"></textarea>
			</div>
		</div>
		<div class="col-md-6">
			<table class="table table-bordered">
			<tr>
				<th>STT</th>
				<th>Tiêu Đề</th>
				<th>Màu sắc</th>
				<th>Kích cỡ</th>
				<th>Giá</th>
				<th>Số Lượng</th>
				<th>Tổng Giá</th>
			</tr>
<?php
if(!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}
$total=0;
$index = 0;
foreach($_SESSION['cart'] as $item) {
	$total += $item['discount']*$item['num'];
	echo '<tr>
			<td>'.(++$index).'</td>
			<td>'.$item['title'].'</td>
			<td>'.$item['color_name'].'</td>
			<td>'.$item['size_name'].'</td>
			<td>'.number_format($item['discount']).' VND</td>
			<td>
				'.$item['num'].'
			</td>
			<td>'.number_format($item['discount'] * $item['num']).' VND</td>
		</tr>';
}
?>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th>Tổng tiền</th>
				<th id="total_money"><?=number_format($total)?> VND</th>
			</tr>
		</table>
		<a href="checkout.php"><button class="btn btn-success" style="border-radius: 0px; font-size: 26px; width: 100%;">THANH TOÁN</button></a>
		</div>
	</div>
</form>
</div>

<script type="text/javascript">
	function completeCheckout() {
		$.post('api/ajax_request.php', {
			'action': 'checkout',
			'fullname': $('[name=fullname]').val(),
			'email': $('[name=email]').val(),
			'phone_number': $('[name=phone]').val(),
			'address': $('[name=address]').val(),
			'note': $('[name=note]').val()
			
		}, function() {
			window.open('complete.php', '_self');
		})

		return false;
	}
</script>
<?php
require_once('layouts/footer.php');
?>