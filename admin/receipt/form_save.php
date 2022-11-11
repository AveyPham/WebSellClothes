<?php
if(!empty($_POST)) {
	$id = getPost('id');
	$supplier_id = getPost('supplier_id');
	$user_id = getPost('user_id');
	$product_id = getPost('pro_id');
	$price = getPost('price');
	$num = getPost('num');

	$total_money = $price * $num;
	$size_id = getPost('size_id');
	$color_id = getPost('color_id');
	$receipt_date = date("Y-m-d H:i:s");


	if($id > 0) {
		//update
			$sql = "update receipt set supplier_id = '$supplier_id', user_id = '$user_id',  receipt_date = '$receipt_date' , status = 0, total_money = '$total_money' where id = $id";		
			execute($sql);

			$sql = "select * from receipt where receipt_date = '$receipt_date'";
			$receiptItem = executeResult($sql, true);
			$receiptId = $receiptItem['id'];
			$receiptStatus = $receiptItem['status'];


			$sql = "update receipt_detail set product_id = '$product_id', size_id = '$size_id', color_id = '$color_id', price = '$price',  num = '$num' where receipt_id = $receiptId";
			execute($sql);

				$sql = "select * from product_detail where product_id = '$product_id' and size_id = '$size_id' and color_id = '$color_id'";
				$productItem = executeResult($sql, true);
				$productQuantity = $productItem['num'];
	
				$updateNum = $productQuantity + $num;
	
				$sql = "update product_detail set num = '$updateNum' where product_id = '$product_id' and size_id = '$size_id' and color_id = '$color_id'";
				execute($sql);
			

			header('Location: index.php');
			echo $receiptStatus;
			die();
		}
	 else {
		
			//insert
			$sql = "insert into receipt(receipt_date, supplier_id, user_id, total_money, status) values ('$receipt_date', '$supplier_id', '$user_id','$total_money',0)";
			execute($sql);

			$sql = "select * from receipt where receipt_date = '$receipt_date'";
			$receiptItem = executeResult($sql, true);

			$receiptId = $receiptItem['id'];


			$sql = "insert into receipt_detail(receipt_id,product_id, price, num, size_id, color_id) values ('$receiptId', '$product_id', '$price', '$num', '$size_id', '$color_id')";
			execute($sql);

				$sql = "select * from product_detail where product_id = '$product_id' and size_id = '$size_id' and color_id = '$color_id'";
				$productItem = executeResult($sql, true);
				$productQuantity = $productItem['num'];
	
				$updateNum = $productQuantity + $num;
	
				$sql = "update product_detail set num = '$updateNum' where product_id = '$product_id' and size_id = '$size_id' and color_id = '$color_id'";
				execute($sql);

			header('Location: index.php');
			die();
		
	
	}
}