<?php
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
echo $day.'-'.$month.'-'.$year."</br>";
echo $nday.'-'.$nmonth.'-'.$nyear."</br>";
    
$stockdata = file_get_contents('http://ichart.yahoo.com/table.csv?s=%5EGSPTSE&a='.$month.'&b='.$day.'&c='.$year.'&d=.'.$nmonth.'.&e='.$nday.'&f='.$nyear.'&g=d&ignore=.csv');
$stocks = explode ("\n", $stockdata);
//newlines get exploded into array
for ($i = 1; $i<50; $i++){
    $stocks[$i] = explode (",", $stocks[$i]);
    if ($stocks[$i][6] != 0) {
    echo number_format((float)$stocks[$i][6], 2, '.', '')."</br>";
    }
}
?>