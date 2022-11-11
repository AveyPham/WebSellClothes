<?php
	$title = 'Nhập Đơn Hàng';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	$id = $msg = $supplier_id = $user_id = $total_money = $product_id=$price=$num = '';
	require_once('form_save.php');

	$user = getUserToken();
	if($user != null) {
		$user_id=$user['id'];
	}

	$id = getGet('id');
	if($id != '' && $id > 0) {
		#$sql="select * from receipt where receipt_id = $id";
		$sql = "select * from receipt left join receipt_detail on receipt.id = receipt_detail.receipt_id where receipt.id = '$id'";
		$receiptItem = executeResult($sql, true);
		if($receiptItem != null) {
			$price=$receiptItem['price'];
			$num=$receiptItem['num'];
			$supplier_id = $receiptItem['supplier_id'];
			$pro_id = $receiptItem['product_id'];
			$total_money = $receiptItem['total_money'];	
			$size_id=$receiptItem['size_id'];
			$color_id = $receiptItem['color_id'];	
			$status = $receiptItem['status'];
		} else {
			$id = 0;
		}
	} else {
		$id = 0;
	}

	$sql = "select * from supplier";
	$supplierItems = executeResult($sql);

	$sql = "select * from user";
	$userItems = executeResult($sql);
	

	$sql = "select distinct color.id as colorId, size.id as sizeId, color.name as colorName, size.name as sizeName from product_detail join color on product_detail.color_id=color.id join size on size.id=product_detail.size_id";
	$specific = executeResult($sql);

	$sql = "select * from product";
	$proItems = executeResult($sql);

?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3 style="margin-top: 50px;">Nhập/Sửa Đơn Hàng</h3>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h5 style="color: red;"><?=$msg?></h5>
			</div>
			<div class="panel-body">
				<form method="post" onsubmit="return validateForm();">
					
					<div class="form-group">
					<input type="text" name="id" value="<?=$id?>" hidden="true">
					<input type="text" name="user_id" value="<?=$user_id?>" hidden="true">

					  <label for="pro">Sản phẩm:</label>
					  <select class="form-control" name="pro_id" id="pro_id" required="true">
					  	<option value="">-- Chọn --</option>
					  	<?php
					  		foreach($proItems as $pro) {
								
					  			if($pro['id'] == $pro_id) {
					  				echo '<option selected value="'.$pro['id'].'">'.$pro['title'].'</option>';
					  			} else {
					  				echo '<option value="'.$pro['id'].'">'.$pro['title'].'</option>';
					  			}
					  		}
					  	?>
					  </select>
					</div>


					<div class="form-group">
					  <label for="sup">Nhà cung cấp:</label>
					  <select class="form-control" name="supplier_id" id="supplier_id" required="true">
					  	<option value="">-- Chọn --</option>
					  	<?php
					  		foreach($supplierItems as $sup) {
								
					  			if($sup['id'] == $supplier_id) {
					  				echo '<option selected value="'.$sup['id'].'">'.$sup['name'].'</option>';
					  			} else {
					  				echo '<option value="'.$sup['id'].'">'.$sup['name'].'</option>';
					  			}
					  		}
					  	?>
					  </select>
					  <button><a href="../supplier/editor.php">Thêm nhà cung cấp</a></button>
					</div>

					<div class="form-group">
					  <label for="size">Kích cỡ:</label>
					  <select class="form-control" name="size_id" id="size_id" required="true">
						
					  	<option value="">-- Chọn --</option>
					  	<?php
							
					  		foreach($specific as $item) {
								
					  			if($item['sizeId'] == $size_id) {
					  				echo '<option selected value="'.$item['sizeId'].'">'.$item['sizeName'].'</option>';
					  			} else {
					  				echo '<option value="'.$item['sizeId'].'">'.$item['sizeName'].'</option>';
					  			}
					  		}
					  	?>
					  </select>
					</div>
					

					<div class="form-group">
					  <label for="size">Màu sắc:</label>
					  <select class="form-control" name="color_id" id="color_id" required="true">
						
					  	<option value="">-- Chọn --</option>
					  	<?php
							
					  		foreach($specific as $item) {
								
					  			if($item['colorId'] == $color_id) {
					  				echo '<option selected value="'.$item['colorId'].'">'.$item['colorName'].'</option>';
					  			} else {
					  				echo '<option value="'.$item['colorId'].'">'.$item['colorName'].'</option>';
					  			}
					  		}
					  	?>
					  </select>
					</div>
					

					<div class="form-group">
					  <label for="price">Giá nhập:</label>
					  <input required="true" type="number" class="form-control" id="price" name="price" value="<?=$price?>">
					</div>
					<div class="form-group">
					  <label for="num">Số lượng:</label>
					  <input required="true" type="number" class="form-control" id="num" name="num" value="<?=$num?>">
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