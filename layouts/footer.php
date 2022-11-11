<footer style="background-color: #81d742 !important;">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<h4>GIỚI THIỆU</h4>
				<ul>
					<li>LIÊN HỆ CÔNG TY CỔ PHẦN ...</li>
					<li><i class="bi bi-mailbox2"></i> gokisoft.com@gmail.com</li>
					<li><i class="bi bi-telephone-fill"></i> 123456789</li>
					<li><i class="bi bi-map-fill"></i> Ha Noi, Viet Nam</li>
					<li>Chúng tôi luôn tiên phong trong lĩnh vực xậy dựng website cho các doanh nghiệp và của hàng. Chúng tôi luôn nỗ lực để tạo ra sản phẩm có chất lượng tốt nhất cho khách hàng.</li>
				</ul>
			</div>
			<div class="col-md-4">
				<h4>SẢN PHẨM MỚI NHẤT</h4>
				<ul>
					<li>LIÊN HỆ CÔNG TY CỔ PHẦN ...</li>
					<li>Email: CTCP.com@gmail.com</li>
					<li>Phone: 123456789</li>
					<li>Chúng tôi luôn tiên phong trong lĩnh vực xậy dựng website cho các doanh nghiệp và của hàng. Chúng tôi luôn nỗ lực để tạo ra sản phẩm có chất lượng tốt nhất cho khách hàng.</li>
				</ul>
			</div>
			<div class="col-md-4">
				<h4>TIN TỨC MỚI NHẤT</h4>
				<ul>
					<li>LIÊN HỆ CÔNG TY CỔ PHẦN ...</li>
					<li>Email: CTCP.com@gmail.com</li>
					<li>Phone: 123456789</li>
					<li>Chúng tôi luôn tiên phong trong lĩnh vực xậy dựng website cho các doanh nghiệp và của hàng. Chúng tôi luôn nỗ lực để tạo ra sản phẩm có chất lượng tốt nhất cho khách hàng.</li>
				</ul>
			</div>
		</div>
	</div>
	<div style="background-color: #3f9609; width: 100%; text-align: center; padding: 20px;">
		© 2018 ... Group . Được thiết kế bời .... All rights reserved.
	</div>
</footer>

<?php
if(!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = [];
}
$count = 0;

foreach($_SESSION['cart'] as $item) {
	$count += $item['num'];
}
?>
<script type="text/javascript">
	function addCart(productId, num,sizeId,colorId) {
		$.post('api/ajax_request.php', {
			'action': 'cart',
			'id': productId,
			'num': num,
			'sizeId': sizeId,
			'colorId': colorId
		}, function(data) {
			location.reload()
		})
	}
	
</script>
<!-- Cart start -->
<?php
if($user != null)
echo '<span class="cart_icon">
	<span class="cart_count">'.$count.'</span>
	<a href="cart.php"><img src="https://gokisoft.com/img/cart.png"></a>
</span>';
?>

<!-- Cart stop -->
</body>
</html>