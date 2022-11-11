<?php
session_start();
require_once('../../utils/utility.php');
require_once('../../database/dbhelper.php');



$user = getUserToken();
if($user == null) {
	die();
}

if(!empty($_POST)) {
	$action = getPost('action');

	switch ($action) {
		case 'delete':
			delete();
			break;
	}
}

function delete() {
	$id = getPost('id');

	$sql = "select count(*) as total from receipt where supplier_id = $id";
	$data = executeResult($sql, true);
	// var_dump($data);
	$total = $data['total'];
	if($total > 0) {
		echo 'Nhà cung cấp đang có đơn hàng, không được xoá!!!';
		die();
	}

	$sql = "delete from supplier where id = $id";
	execute($sql);
}