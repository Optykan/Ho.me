<!DOCTYPE HTML>
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
    <html>

    <head>
        <script type="text/javascript">
            window.onload = function () {
                var chart = new CanvasJS.Chart("chartContainer", {
                    title: {
                        text: "BRK-A Composite Index",
                    },
                    exportEnabled: true,
                    axisY: {
                        includeZero: false,
                        prefix: "$",
                        title: "Prices",
                    },
                    axisX: {
                        interval: 1,
                        valueFormatString: "MMM-DD",
                    },
                    toolTip: {
                        content: "Date:{x}</br><strong>Prices:</strong></br>Open:{y[0]}, Close:{y[3]}</br>High:{y[1]},Low:{y[2]}",
                    },
                    data: [
                        {
                            type: "candlestick",
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
        <script type="text/javascript" src="js/canvasjs.min.js"></script>
    </head>

    <body>
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        <?='http://ichart.yahoo.com/table.csv?s=BRK-A&a='.$month.'&b='.$day.'&c='.$year.'&d=.'.$nmonth.'.&e='.$nday.'&f='.$nyear.'&g=d&ignore=.csv'?>
    </body>


    </html>