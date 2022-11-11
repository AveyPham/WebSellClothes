<?php
if(!empty($_POST)) {
	$id = getPost('id');
	$title = getPost('title');
	$price = getPost('price');
	$discount = getPost('discount');
	
	$thumbnail = moveFile('thumbnail');
	$brand_id = getPost('brand_id');

	$description = getPost('description');
	$category_id = getPost('category_id');
	$num= getPost('num');
	$size_id= getPost('size_id');
	$color_id= getPost('color_id');
	echo $id;
	$created_at = $updated_at = date('Y-m-d H:s:i');

	if($id > 0) {
		//update
		if($thumbnail != '') {
			
			$sql = "update Product_detail set discount = $discount,  num='$num', size_id='$size_id', color_id='$color_id' where id = $id";
			execute($sql);

			$sql = "select * from product_detail where id = $id";
			$productItem = executeResult($sql, true);
			$productId = $productItem['product_id'];

			$sql = "update Product set thumbnail = '$thumbnail', title = '$title', price = $price,  description = '$description', updated_at = '$updated_at', category_id = '$category_id', brand_id='$brand_id' where id = $productId";
			execute($sql);

			

		} else {
			$sql = "update Product_detail set discount = $discount,  num='$num', size_id='$size_id', color_id='$color_id' where id = $id";
			execute($sql);

			$sql = "select * from product_detail where id = $id";
			$productItem = executeResult($sql, true);
			$productId = $productItem['product_id'];

			$sql = "update Product set title = '$title', price = $price,  description = '$description', updated_at = '$updated_at', category_id = '$category_id', brand_id='$brand_id' where id = $productId";
			execute($sql);

		}
		
		header('Location: index.php');
		die();
	} else {
		//insert
		$sql = "select * from product where title = '$title'";
		$productItem = executeResult($sql, true);
		$productName = $productItem['title'];

		if($productName == $title){
			header('Location: index.php');
		}
		else{
			$sql = "insert into Product(thumbnail, title, price, description, updated_at, created_at, deleted, category_id, brand_id) values ('$thumbnail', '$title', '$price', '$description', '$updated_at', '$created_at', 0, $category_id,$brand_id)";
			execute($sql);

			$sql = "select * from product where created_at = '$created_at'";
			$productItem = executeResult($sql, true);
			$productId = $productItem['id'];

			$sql = "insert into Product_detail(product_id, discount, num, size_id, color_id) values ('$productId', '$discount', '$num', '$size_id', '$color_id')";
			execute($sql);

			header('Location: index.php');
			die();
		}
		
		
		

		
		
	}
}