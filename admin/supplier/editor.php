<?php
	$title = 'Thêm/Sửa Nhà Cung Cấp';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	$id = $msg = $name = $email = $phone_number = $address= '';
	require_once('form_save.php');

	$id = getGet('id');
	if($id != '' && $id > 0) {
		$sql = "select * from supplier where id = '$id'";
		$supplierItem = executeResult($sql, true);
		if($supplierItem != null) {
			$name = $supplierItem['name'];
			$email = $supplierItem['email'];
			$phone_number = $supplierItem['phone_number'];
			$address = $supplierItem['address'];		
		} else {
			$id = 0;
		}
	} else {
		$id = 0;
	}

?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3 style="margin-top: 50px;">Thêm/Sửa Nhà Cung Cấp</h3>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h5 style="color: red;"><?=$msg?></h5>
			</div>
			<div class="panel-body">
				<form method="post" onsubmit="return validateForm();">
					<div class="form-group">
					  <label for="usr">Tên Nhà Cung Cấp:</label>
					  <input required="true" type="text" class="form-control" id="usr" name="name" value="<?=$name?>">
					  <input type="text" name="id" value="<?=$id?>" hidden="true">
					</div>
					
					<div class="form-group">
					  <label for="email">Email:</label>
					  <input required="true" type="email" class="form-control" id="email" name="email" value="<?=$email?>">
					</div>
					<div class="form-group">
					  <label for="phone_number">SĐT:</label>
					  <input required="true" type="tel" class="form-control" id="phone_number" name="phone_number" value="<?=$phone_number?>">
					</div>
					<div class="form-group">
					  <label for="address">Địa Chỉ:</label>
					  <input required="true" type="text" class="form-control" id="address" name="address" value="<?=$address?>">
					</div>
					
					
					<button class="btn btn-success">Xác nhận</button>
				</form>
			</div>
		</div>
	</div>
</div>



<?php
	require_once('../layouts/footer.php');
?>