<?php
if(!empty($_POST)) {
	$id = getPost('id');
	$fullname = getPost('fullname');
	$email = getPost('email');
	$phone_number = getPost('phone_number');
	$address = getPost('address');
	$password = getPost('password');
	if($password != '') {
		$password = getSecurityMD5($password);
	}
	
	$created_at = $updated_at = date("Y-m-d H:i:s");

	$role_id = getPost('role_id');

	if($id > 0) {
		//update
		$sql = "select * from User where email = '$email' and id <> $id";
		$userItem = executeResult($sql, true);

		if($userItem != null) {
			$msg = 'Email này đã tồn tại trong tài khoản khác, vui lòng kiểm tra lại!!!';
		} else {
			if($password != '') {
				$sql = "update User set fullname = '$fullname', email = '$email', phone_number = '$phone_number', address = '$address', password = '$password', updated_at = '$updated_at', role_id = $role_id where id = $id";
			} else {
				$sql = "update User set fullname = '$fullname', email = '$email', phone_number = '$phone_number', address = '$address', updated_at = '$updated_at', role_id = $role_id where id = $id";
			}
			execute($sql);
			header('Location: index.php');
			die();
		}
	} else {
		$sql = "select * from User where email = '$email'";
		$userItem = executeResult($sql, true);
		//insert
		if($userItem == null) {
			//insert
			$sql = "insert into User(fullname, email, phone_number, address, password, role_id, created_at, updated_at, deleted) values ('$fullname', '$email', '$phone_number', '$address', '$password', '$role_id', '$created_at', '$updated_at', 0)";
			execute($sql);
			header('Location: index.php');
			die();
		} else {
			//Tai khoan da ton tai -> failed
			$msg = 'Email đã được đăng ký, vui lòng kiểm tra lại!!!';
		}
	}
}