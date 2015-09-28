<!DOCTYPE html>
<?php
//ichart.yahoo.com/table.csv?s=BAS.DE&a=0&b=1&c=2015&d=08&e=27&f=2015&g=w&ignore=.csv
$date = date_create (date("Y-m-d"));
date_sub($date,date_interval_create_from_date_string("40 days"));
$date= date_format($date,"Y-m-d");
$date = explode ("-", $date);
$day = $date[2];
$month = $date[1]-1;
$year = $date[0];
$nday = date("d");
$nmonth = date("m")-1;
$nyear = date("Y");
    
$stockdata = file_get_contents('http://ichart.yahoo.com/table.csv?s=%5EGSPTSE&a='.$month.'&b='.$day.'&c='.$year.'&d=.'.$nmonth.'.&e='.$nday.'&f='.$nyear.'&g=d&ignore=.csv');
$stocks = explode ("\n", $stockdata);
//newlines get exploded into array
for ($i = 1; $i<50; $i++){
    $stocks[$i] = explode (",", $stocks[$i]);
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
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body style="height:100%;">
        <div class="clearfix" style="height:100%;">
            <aside class="sidebar">
                <nav class="sidebar-nav">
                    <div class="img-stack">
                        <img class="profile-back" src="img/image.jpg">
                        <img class="profile img-circle" src="img/user.png">
                    </div>


                    <ul class="metismenu" id="menu">
                        <li class="active">
                            <a href="index.php">
                                <span class="fa fa-home"></span>
                                <span class="sidebar-nav-item">Overview</span>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="sidebar-active">
                                <span class="fa fa-line-chart"></span>
                                <span class="sidebar-nav-item">Stocks</span>

                            </a>
                        </li>
                        <li class="logout">
                            <a href="#">
                                <span class="fa fa-sign-out"></span>
                                <span class="sidebar-nav-item">Logout</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>
            <section class="content">
                <div class="col-xs-12">
                    <canvas id="tsx" width="1280" height="800"></canvas>

                </div>
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="js/metisMenu.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
        <script src="js/chart.min.js"></script>


        <script>
            // line chart data
            var stockData = {
                    labels: [<?php 
                        for ($i = 1; $i < 50; $i++) {
                            if ($stocks[$i][0] != ""){
                                echo '"'.$stocks[$i][0].'",';}
                        } ?>
                        ],
                    datasets : [
                                {
                                    fillColor: "rgba(172,194,132,0.4)",
                                    strokeColor: "#ACC26D",
                                    pointColor: "#fff",
                                    pointStrokeColor: "#9DB86D",
                                    data: [<?php for ($i = 1; $i < 50; $i++) {
                                if ($stocks[$i][6] !=0) {
                                    echo number_format((float)$stocks[$i][6], 2, '.', '').",";
                                }
                        }?>]
                }
            ]
                        }
                        // get line chart canvas
                    var tsx = document.getElementById('tsx').getContext('2d');
                    // draw line chart
                    new Chart(tsx).Line(stockData);
        </script>
        <script>
            $(function () {
                $('#menu').metisMenu();
            });
            $.backstretch("");
        </script>

    </body>

    </html>