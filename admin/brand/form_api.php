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
			deleteBrand();
			break;
	}
}

function deleteBrand() {
	$id = getPost('id');
	$sql = "select count(*) as total from Product where brand_id = $id and deleted = 0";
	$data = executeResult($sql, true);
	// var_dump($data);
	$total = $data['total'];
	if($total > 0) {
		echo 'Danh mục đang chứa sản phẩm, không được xoá!!!';
		die();
	}

	$sql = "delete from brand where id = $id";
	execute($sql);
}