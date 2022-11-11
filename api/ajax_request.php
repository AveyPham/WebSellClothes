<?php
	session_start();
	require_once('../utils/utility.php');
	require_once('../database/dbhelper.php');

	$action = getPost('action');

	switch ($action) {
		case 'cart':
			addToCart();
			break;
		case 'update_cart':
			updateCart();
			break;
		case 'checkout':
			checkout();
			break;
		case 'remove_all_cart':
			removeAllCart();
			break;

		case 'getPrice':
			getPrice();
			break;
	}


	function removeAllCart() {
		unset($_SESSION['cart']);
	}

	function checkout() {
		if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
			return;
		}

		$fullname = getPost("fullname");
		$email = getPost("email");
		$phone_number = getPost("phone_number");
		$address = getPost("address");
		$note = getPost("note");

		
		$user = getUserToken();
		$userId = 0;
		if($user != null) {
			$userId = $user['id'];
		}

		$orderDate = date('Y-m-d H:i:s');

		
		$totalMoney = 0;
		foreach($_SESSION['cart'] as $item) {
			$totalMoney += $item['discount'] * $item['num'];
		}
		
		$sql = "insert into Orders(user_id, fullname, email, phone_number, address, note, order_date, status, total_money) values ($userId, '$fullname', '$email', '$phone_number', '$address', '$note', '$orderDate', 0, '$totalMoney')";
		execute($sql);

		$sql = "select * from Orders where order_date = '$orderDate'";
		$orderItem = executeResult($sql, true);

		$orderId = $orderItem['id'];

		foreach($_SESSION['cart'] as $item) {
			$product_id = $item['id'];
			$price = $item['discount'];
			$num = $item['num'];
			$size_id=$item['sizeId'];
			$color_id=$item['colorId'];
			$totalMoney = $price * $num;

			$sql = "insert into order_details(order_id, product_id,size_id,color_id, price, num, total_money) values ($orderId, $product_id,$size_id,$color_id, $price, $num, $totalMoney)";
			execute($sql);
		}

		unset($_SESSION['cart']);
	}

	function updateCart() {
		$id = getPost('id');
		$num = getPost('num');

		if(!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = [];
		}

		for($i=0;$i<count($_SESSION['cart']);$i++) {
			if($_SESSION['cart'][$i]['pro_id'] == $id) {
				$_SESSION['cart'][$i]['num'] = $num;
				if($num <= 0) {
					array_splice($_SESSION['cart'], $i, 1);
				}
				break;
			}
		}
	}

	function addToCart() {
		$id = getPost('id');
		$num = getPost('num');
		$size_id = getPost('sizeId');
		$color_id = getPost('colorId');
		
		$sql = "select product_detail.discount,product_detail.id as pro_id,size.id as sizeId, size.name as size_name, color.id as colorId, color.name as color_name FROM product_detail left join size on product_detail.size_id = size.id left join color on product_detail.color_id = color.id where Product_detail.product_id = $id and size.id = $size_id and color.id = $color_id";
		$product = executeResult($sql, true);	
			
		if($product !=null){
			if(!isset($_SESSION['cart'])) {
				$_SESSION['cart'] = [];
			}
			// var_dump($_SESSION['cart']);
			$isFind = false;
			for($i=0;$i<count($_SESSION['cart']);$i++) {
				if($_SESSION['cart'][$i]['id'] == $id && $_SESSION['cart'][$i]['sizeId']==$size_id && $_SESSION['cart'][$i]['colorId']==$color_id) {
					$_SESSION['cart'][$i]['num'] += $num;
					$_SESSION['cart'][$i]['sizeId'] = $size_id;
					$_SESSION['cart'][$i]['colorId'] = $color_id;
	
	
					$isFind = true;
					break;
				}
			}
	
			if(!$isFind) {
				$sql = "select product.*,product_detail.discount,product_detail.id as pro_id,size.id as sizeId, size.name as size_name, color.id as colorId, color.name as color_name from Product left join product_detail on product_detail.product_id = product.id left join size on product_detail.size_id = size.id left join color on product_detail.color_id = color.id where Product.id = $id and size.id = $size_id and color.id = $color_id";
				$product = executeResult($sql, true);		
				$product['num'] = $num;		
				$product['sizeId'] = $size_id;
				$product['colorId'] = $color_id;
				$_SESSION['cart'][] = $product;
			}		
		}
		
		else{
			echo 'Hết hàng';
		}


		
	}
	
	function getPrice(){
			$id = getPost('id');
			$size_id = getPost('sizeId');
			$color_id = getPost('colorId');
			$sql = "select product_detail.discount,product_detail.id as pro_id,size.id as sizeId, size.name as size_name, color.id as colorId, color.name as color_name FROM product_detail left join size on product_detail.size_id = size.id left join color on product_detail.color_id = color.id where Product_detail.product_id = $id and size.id = $size_id and color.id = $color_id";
			$product = executeResult($sql, true);	
				
			if($product !=null){
			echo number_format($product['discount']) ." ". "VNĐ";
			}
			
			else{
				echo 'Hết hàng';
			}
		
		
	}