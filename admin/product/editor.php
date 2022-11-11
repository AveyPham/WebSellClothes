<?php
	$title = 'Thêm/Sửa Sản Phẩm';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	$id = $thumbnail = $title = $price = $discount = $category_id = $description = $brand_id=$num=$size_id=$color_id='';
	require_once('form_save.php');

	$id = getGet('id');
	if($id != '' && $id > 0) {
		$sql = "select product.*, product_detail.discount, product_detail.num, size.id as sizeId, size.name as sizeName, color.id as colorId, color.name as colorName from Product join product_detail on product.id = product_detail.product_id join size on size.id = product_detail.size_id join color on color.id = product_detail.color_id where product_detail.id = '$id' and product.deleted = 0";
		$productItem = executeResult($sql, true);
		if($productItem != null) {
			$thumbnail = $productItem['thumbnail'];
			$title = $productItem['title'];
			$price = $productItem['price'];
			$discount = $productItem['discount'];
			$category_id = $productItem['category_id'];
			$description = $productItem['description'];
			$brand_id = $productItem['brand_id'];
			$num= $productItem['num'];
			$size_id = $productItem['sizeId'];
			$color_id=$productItem['colorId'];
			$size_name = $productItem['sizeName'];
			$color_name=$productItem['colorName'];

		} else {
			$id = 0;
		}
	} else {
		$id = 0;
	}

	$sql = "select * from Category";
	$categoryItems = executeResult($sql);

	$sql = "select * from brand";
	$brandItems = executeResult($sql);

	$sql = "select * from product";
	$proItems = executeResult($sql);

	$sql = "select * from color";
	$colorItems = executeResult($sql);

	$sql = "select * from size";
	$sizeItems = executeResult($sql);
	
?>
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3 style="margin-top: 50px;">Thêm/Sửa Sản Phẩm</h3>
		<div class="panel panel-primary">
			<div class="panel-body">
				<form method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-9 col-12">
						<div class="form-group">
						  <label for="usr">Tên Sản Phẩm:</label>
						  <input required="true" type="text" class="form-control" id="usr" name="title" value="<?=$title?>">
						  <input type="text" name="id" value="<?=$id?>" hidden="true">
						</div>
						<div class="form-group">
						  <label for="pwd">Nội Dung:</label>
						  <textarea class="form-control" rows="5" name="description" id="description"><?=$description?></textarea>
						</div>

						<button class="btn btn-success">Lưu Sản Phẩm</button>
					</div>
					<div class="col-md-3 col-12" style="border: solid grey 1px; padding-top: 10px; padding-bottom: 10px;">
						<div class="form-group">
						  <label for="thumbnail">Thumbnail:</label>
						  <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
						  <img id="thumbnail_img" src="<?=fixUrl($thumbnail)?>" style="max-height: 160px; margin-top: 5px; margin-bottom: 15px;">
						</div>

						<div class="form-group">
						  <label for="category">Danh Mục Sản Phẩm:</label>
						  <select class="form-control" name="category_id" id="category_id" required="true">
						  	<option value="">-- Chọn --</option>
						  	<?php
						  		foreach($categoryItems as $item) {
						  			if($item['id'] == $category_id) {
						  				echo '<option selected value="'.$item['id'].'">'.$item['name'].'</option>';
						  			} else {
						  				echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
						  			}
						  		}
						  	?>
						  </select>
						</div>

						<div class="form-group">
						  <label for="brand">Nhãn hiệu:</label>
						  <select class="form-control" name="brand_id" id="brand_id" required="true">
						  	<option value="">-- Chọn --</option>
						  	<?php
						  		foreach($brandItems as $item) {
						  			if($item['id'] == $brand_id) {
						  				echo '<option selected value="'.$item['id'].'">'.$item['name'].'</option>';
						  			} else {
						  				echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
						  			}
						  		}
						  	?>
						  </select>
						</div>

						<div class="form-group">
						  <label for="num">Số lượng:</label>
						  <input required="true" type="number" class="form-control" id="num" name="num" value="<?=$num?>">
						</div>

						<div class="form-group">
						  <label for="color">Màu sắc:</label>
						  <select class="form-control" name="color_id" id="color_id" required="true">
							<option value="">-- Chọn --</option>
								<?php
									foreach($colorItems as $item) {
										if($item['id'] == $color_id) {
											echo '<option selected value="'.$item['id'].'">'.$item['name'].'</option>';
										} else {
											echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
										}
									}
								?>
						  </select>
						</div>

						<div class="form-group">
						  <label for="size">Kích cỡ:</label>
						  <select class="form-control" name="size_id" id="size_id" required="true">
						  
						  	
							<option value="">-- Chọn --</option>
								<?php
									foreach($sizeItems as $item) {
										if($item['id'] == $size_id) {
											
											echo '<option selected value="'.$item['id'].'">'.$item['name'].'</option>';
										} else {
											echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
										}
									}
								?>
						  									  			  		
						  	
						  </select>
						</div>

						<div class="form-group">
						  <label for="price">Giá:</label>
						  <input required="true" type="number" class="form-control" id="price" name="price" value="<?=$price?>">
						</div>
						<div class="form-group">
						  <label for="discount">Giảm Giá:</label>
						  <input required="true" type="text" class="form-control" id="discount" name="discount" value="<?=$discount?>">
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function updateThumbnail() {
		$('#thumbnail_img').attr('src', $('#thumbnail').val())
	}
</script>
<script>
  $('#description').summernote({
    placeholder: 'Nhập nội dung dữ liệu',
    tabsize: 2,
    height: 300,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen', 'codeview', 'help']]
    ]
  });
</script>

<?php
	require_once('../layouts/footer.php');
?>