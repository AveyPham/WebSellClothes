<?php 
    require_once('layouts/header.php');
    $sql = "select product.*, category.name as category_name from product left join category on product.category_id = category.id order by product.updated_at desc limit 0,8";
    $lastestItems = executeResult($sql);

    $key=getGet('search');
    // $row=mysqli_fetch_assoc($result);
    // echo $row;
    //   $id=$result['id'];
    //   $category_name=$result['category_name'];
    //   $thumbnail=$result['thumbnail'];
    //   $title=$result['title'];
    //   $price=$result['price'];
    //   $discount=$result['discount'];
    
?>
<!-- banner -->
<div id="demo" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://t004.gokisoft.com/uploads/2021/07/1-s-1634-banner-web.jpg" alt="Los Angeles">
    </div>
    <div class="carousel-item">
      <img src="https://t004.gokisoft.com/uploads/2021/07/2-s-1634-banner-web.jpg" alt="Chicago">
    </div>
    <div class="carousel-item">
      <img src="https://t004.gokisoft.com/uploads/2021/07/3-s-1634-banner-web.jpg" alt="New York">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>

</div>
<!-- banner stop -->
<div class="container">
	<h1 style="text-align: center; margin-top: 20px; margin-bottom: 20px;">SẢN PHẨM</h1>
	<div class="row">
    <?php
    if($key!=''){
      foreach($result as $item) {
        echo '<div class="col-md-3 col-6 product-item">
            <a href="detail.php?id='.$item['id'].'"><img src="'.$item['thumbnail'].'" style="width: 100%; height: 220px;"></a>
            <p style="font-weight: bold;">'.$item['category_name'].'</p>
            <a href="detail.php?id='.$item['id'].'"><p style="font-weight: bold;">'.$item['title'].'</p></a>
            <p style="color: red; font-weight: bold;">'.number_format($item['price']).' VND</p>
          </div>';
      }
    }else{
      foreach($lastestItems as $item) {
        echo '<div class="col-md-3 col-6 product-item">
            <a href="detail.php?id='.$item['id'].'"><img src="'.$item['thumbnail'].'" style="width: 100%; height: 220px;"></a>
            <p style="font-weight: bold;">'.$item['category_name'].'</p>
            <a href="detail.php?id='.$item['id'].'"><p style="font-weight: bold;">'.$item['title'].'</p></a>
            <p style="color: red; font-weight: bold;">'.number_format($item['price']).' VND</p>
          </div>';
      }
    }
    #<p><button class="btn btn-success" onclick="addCart('.$item['id'].', 1)" style="width: 100%; border-radius: 0px;"><i class="bi bi-cart-plus-fill"></i> Thêm giỏ hàng</button></p>

      
    ?>
    

    

	</div>
  <!-- <div class="col-md-3 col-6 product-item">
            <a href="detail.php?id='.$item['id'].'"><img src="'.$item['thumbnail'].'" style="width: 100%; height: 220px;"></a>
            <p style="font-weight: bold;"></p>
            <a href="detail.php?id='.$item['id'].'"><p style="font-weight: bold;">'.$item['title'].'</p></a>
            <p style="color: red; font-weight: bold;">'.number_format($item['discount']).' VND</p>
            <p><button class="btn btn-success" onclick="addCart('.$item['id'].', 1)" style="width: 100%; border-radius: 0px;"><i class="bi bi-cart-plus-fill"></i> Thêm giỏ hàng</button></p>
  </div> -->
</div>



<!-- danh muc san pham -->
<?php
$count = 0;
foreach($menuItems as $item) {
	$sql = "select product.id as pId, product.*, category.name as category_name from product left join category on product.category_id = category.id  where product.category_id = ".$item['id']." order by product.updated_at desc limit 0,4";
	$items = executeResult($sql);
	if($items == null || count($items) < 4) continue;
?>
<div style="background-color: <?=($count++%2 == 0)?'#f7f9fa':''?>;">
<div class="container">
<h1 style="text-align: center; margin-top: 20px; margin-bottom: 20px;"><?=$item['name']?></h1>
<div class="row">
<?php
	foreach($items as $pItem) {
      echo '<div class="col-md-3 col-6 product-item">
      <a href="detail.php?id='.$pItem['pId'].'"><img src="'.$pItem['thumbnail'].'" style="width: 100%; height: 220px;"></a>
      <p style="font-weight: bold;">'.$pItem['category_name'].'</p>
      <a href="detail.php?id='.$pItem['pId'].'"><p style="font-weight: bold;">'.$pItem['title'].'</p></a>
      <p style="color: red; font-weight: bold;">'.number_format($pItem['price']).' VND</p>
    </div>';
	}
  #<p><button class="btn btn-success" onclick="addCart('.$item['id'].', 1)" style="width: 100%; border-radius: 0px;"><i class="bi bi-cart-plus-fill"></i> Thêm giỏ hàng</button></p>

?>

</div>
</div>
</div>
<?php
}
?>
<?php
require_once('layouts/footer.php');
?>