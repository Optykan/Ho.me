<!DOCTYPE html>
<?php
$stockname = $_GET["stock"];
//ichart.yahoo.com/table.csv?s=BAS.DE&a=0&b=1&c=2015&d=08&e=27&f=2015&g=w&ignore=.csv
$date = date_create (date("Y-m-d"));
date_sub($date,date_interval_create_from_date_string("100 days"));
$date= date_format($date,"Y-m-d");
$date = explode ("-", $date);
$day = $date[2];
$month = $date[1]-1;
$year = $date[0];
$nday = date("d");
$nmonth = date("m")-1;
$nyear = date("Y");
    
$stockdata = file_get_contents('http://ichart.yahoo.com/table.csv?s=BRK-A&a='.$month.'&b='.$day.'&c='.$year.'&d=.'.$nmonth.'.&e='.$nday.'&f='.$nyear.'&g=d&ignore=.csv');
$stocks = explode ("\n", $stockdata);
//newlines get exploded into array
for ($i = 1; $i<50; $i++){
    $stocks[$i] = explode (",", $stocks[$i]);
    $stocks[$i][0] = explode ("-",  $stocks[$i][0]);
    if ($stocks[$i][6] != 0) {
    //echo number_format((float)$stocks[$i][6], 2, '.', '')."</br>";
    }
}
?>
    <html style="height:100%;">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>stocks</title>

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/metisMenu.min.css">
        <link rel="stylesheet" href="css/demo.css">
        <link rel="stylesheet" href="css/stocks.css">
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body style="height:100%;">
        <div class="clearfix" style="height:100%;">
            <?php $_GET['active']=2;
            include("menu.php");?>
                <section class="content">
                    <div class="col-xs-12">
                        <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                    </div>
                </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="js/metisMenu.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
        <script src="js/chart.min.js"></script>
        <script type="text/javascript" src="js/canvasjs.min.js"></script>
        <script type="text/javascript">
            window.onload = function () {
                var chart = new CanvasJS.Chart("chartContainer", {
                    title: {
                        text: "BRK-A Composite Index",
                    },
                    animationEnabled: true,
                    exportEnabled: false,
                    backgroundColor: null,
                    axisY: {
                        includeZero: false,
                        prefix: "$",
                    },
                    axisX: {
                        interval: 1,
                        valueFormatString: "MMM-DD",
                    },
                    toolTip: {
                        content: "Date:{x}</br><strong>Prices:</strong></br>Open:{y[0]}, Close:{y[3]}</br>High:{y[1]}, Low:{y[2]}",
                    },
                    data: [
                        {
                            type: "candlestick",
                            color: "#2ecc71",
                            dataPoints: [ // Y: [Open, High ,Low, Close]
                                <?php
                    for ($i=1; $i<50; $i++){
                        if ($stocks[$i][0][0] != 0){
                            $m = $stocks[$i][0][1]-1;
                                echo "{x:  new Date(".$stocks[$i][0][0],",".$m.",".$stocks[$i][0][2]."),  y:[".$stocks[$i][1].",".$stocks[$i][2].",".$stocks[$i][3].",".$stocks[$i][4]."]},"."\n";
                        }}?>
                            ]
                        }
                    ]
                });
                chart.render();
            }
        </script>


        <script>
            $(function () {
                $('#menu').metisMenu();
            });
            $.backstretch("");
        </script>

    </body>

    </html>