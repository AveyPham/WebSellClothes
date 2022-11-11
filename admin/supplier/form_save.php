<?php
if(!empty($_POST)) {
	$id = getPost('id');
	$name = getPost('name');
	$email = getPost('email');
	$phone_number = getPost('phone_number');
	$address = getPost('address');
	
	

	if($id > 0) {
		//update
		
			$sql = "update Supplier set name = '$name', email = '$email', phone_number = '$phone_number', address = '$address' where id = $id";
		
			
			execute($sql);
			header('Location:../receipt/editor.php');
			die();
		
	} else {
		 
			//insert
			$sql = "insert into Supplier(name, email, phone_number, address) values ('$name', '$email', '$phone_number', '$address')";
			execute($sql);
			header('Location:../receipt/editor.php');
			die();
		
	}
}