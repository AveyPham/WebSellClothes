
<?php  

//index.php
$title = 'Thống kê';
	$baseUrl = '../';
	require_once('../layouts/header.php');

include("database_connection.php");

// $query = "select * FROM months";

// $statement = $connect->prepare($query);

// $statement->execute();

// $result = $statement->fetchAll();
$year = date("Y-m-d");
?>  
<!DOCTYPE html>  
<html>  
    <head>  
        <title>Create Dynamic Column Chart using PHP Ajax with Google Charts</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
    </head>  
    <body> 
        <br /><br />
        <div class="container">  
            <h3 text-align="center">Thống kê doanh thu theo năm</h3>  
            <br />  
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-9">
                            <h3 class="panel-title">Biểu đồ doanh thu theo năm</h3>
                        </div>
                        <div class="col-md-3">
                            <select name="year" class="form-control" id="year">
                                <option value="">Chọn năm</option>
                            <?php
                            for ($x = $year-5; $x <= $year; $x++)
                            {
                                // echo '<option value="'.$row["nr"].'">'.$row["nr"].'</option>';
                                echo '<option value="'.$x.'">'.$x.'</option>';
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="chart_area" style="width: 1000px; height: 620px;"></div>
                </div>
            </div>
        </div>  
    </body>  
</html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback();

function load_monthwise_data(year, title)
{
    var temp_title = title + ' '+year+'';
    $.ajax({
        url:"fetch.php",
        method:"POST",
        data:{year:year},
        dataType:"JSON",
        success:function(data)
        {console.log(data)
            drawMonthwiseChart(data, temp_title);
        }
    })
}

function drawMonthwiseChart(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Month');
    data.addColumn('number', 'Profit');
    $.each(jsonData, function(i, jsonData){
        var month = jsonData.nr;
        var profit = parseInt($.trim(jsonData.c));
        data.addRows([[month, profit]]);
    });
    var options = {
        title:chart_main_title,
        hAxis: {
            title: "Tháng"
        },
        vAxis: {
            title: 'Doanh thu (VND)'
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));
    chart.draw(data, options);
}

</script>

<script>
    
$(document).ready(function(){

    $('#year').change(function(){
        var year = $(this).val();
        if(year != '')
        {
            load_monthwise_data(year, 'Doanh thu của năm ');
        }
    });

});

</script>
