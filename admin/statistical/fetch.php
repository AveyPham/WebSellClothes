<?php

//fetch.php

include('database_connection.php');

if(isset($_POST["year"]))
{
   $year = $_POST["year"];
 $query = "
 SELECT nr,c from months left join (
   SELECT nr as month, sum(orders.total_money) 
   as c FROM orders RIGHT JOIN months 
   ON EXTRACT(month FROM orders.order_date) = nr 
   WHERE (year(orders.order_date) = '$year') 
   GROUP BY EXTRACT(month FROM orders.order_date) 
   ORDER BY EXTRACT(month FROM orders.order_date) ASC) 
   as attt on months.nr = attt.month;
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();$output[] = array();
 foreach($result as $row)
 {
  $output[] = ($result);
 }
 echo json_encode($result);
}

?>
