<html style="height:100%;">
<?php 

    function get_client_ip() {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
            
        if(strpos($ipaddress,',')){
            $ipaddress=explode(',', $ipaddress);
            $ipaddress=$ipaddress[0];
        }
        return $ipaddress;
    }
    
    function degtodir($deg){
        $compass = array("N","NNE","NE","ENE","E","ESE","SE","SSE","S","SSW","SW","WSW","W","WNW","NW","NNW");

        $compcount = round($deg / 22.5);
        $compdir = $compass[$compcount];
        return $compdir;

    }

    //$url = "http://api.openweathermap.org/data/2.5/forecast";
    $key = "01b0df735179e9b6382e2968b989eeba";
    
    //---------------GEO IP DATA---------------//
    if(get_client_ip()=="127.0.0.1")
        $locapiurl = "http://ipinfo.io/174.114.148.126/json";
    else
        $locapiurl = "http://ipinfo.io/".get_client_ip()."/json";
    $locjson = file_get_contents($locapiurl);
    $locdata = json_decode($locjson, true);
    
    $loc = explode(",", $locdata['loc']);
/*    $region = $locdata['region'];
    if(isset($region))
        $region = ', '.$region;*/

    //--------------TIME ZONE DATA--------------//
    $timezoneurl='https://maps.googleapis.com/maps/api/timezone/json?location='.$loc[0].','.$loc[1].'&timestamp='.time().'&sensor=false&key=AIzaSyCE5-bYxvo1NORW_eVGMuURepXRVsl2-C4';
    $timezonejson=file_get_contents($timezoneurl);
    $timedata=json_decode($timezonejson,true);
    
    $zone=$timedata['timeZoneId'];
    date_default_timezone_set($zone);

    //--------------5 DAY FORECAST--------------//
    /*$forecastapiurl = "http://api.openweathermap.org/data/2.5/forecast/daily?lat=".$loc[0]."&lon=".$loc[1]."&cnt=6&APPID=".$key;*/
    $forecastapiurl = "http://api.wunderground.com/api/aa95985154209660/forecast10day/q/".$loc[0].','.$loc[1].'.json';
    $forecastjson = file_get_contents($forecastapiurl);
    $forecastdata = json_decode($forecastjson, true);

    for($i=1;$i<6;$i++){
/*        ${'tmp'.$i}=round($forecastdata['list'][$i]['temp']['max']-273.15);
        ${'weatherimg'.$i}='img/'.$forecastdata['list'][$i]['weather'][0]['main'].'.jpg';
        ${'weather'.$i}=$forecastdata['list'][$i]['weather'][0]['main'];
        ${'date'.$i}=date("l, F j",$forecastdata['list'][$i]['dt']);*/
        ${'tmp'.$i}=$forecastdata['forecast']['simpleforecast']['forecastday'][$i]['high']['celsius'];
        ${'weatherimg'.$i}='img/'.$forecastdata['forecast']['simpleforecast']['forecastday'][$i]['icon'].'.jpg';
        ${'weather'.$i}=$forecastdata['forecast']['simpleforecast']['forecastday'][$i]['conditions'];
        ${'date'.$i}=date("l, F j",$forecastdata['forecast']['simpleforecast']['forecastday'][$i]['date']['epoch']);
        
    }

    //---------------CURRENT DATA---------------//
   /* $currentapiurl = "http://api.openweathermap.org/data/2.5/weather?lat=".$loc[0]."&lon=".$loc[1]."&APPID=".$key;*/
    $currentapiurl = "http://api.wunderground.com/api/aa95985154209660/conditions/q/".$loc[0].','.$loc[1].'.json';
    $currentjson = file_get_contents($currentapiurl);
    $currentdata = json_decode($currentjson, true);

/*    $nowtmp = round($currentdata['main']['temp']-273.15);
    $nowhum = $currentdata['main']['humidity'];
    $nowpres = $currentdata['main']['pressure'];
    $nowweather = $currentdata['weather'][0]['main'];
    $nowwind = $currentdata['wind']['speed'];
    $nowwinddeg = $currentdata['wind']['deg'];
    $nowsunrise = date("g:i A",$currentdata['sys']['sunrise']);
    $nowsunset = date("g:i A",$currentdata['sys']['sunset']);

    $city = $currentdata['name'];
    $country = $currentdata['sys']['country'];*/
    $region = $currentdata['current_observation']['display_location']['full'];
    $nowtmp = $currentdata['current_observation']['temp_c'];
    $nowhum = str_replace('%','',$currentdata['current_observation']['relative_humidity']);
    $nowpres = $currentdata['current_observation']['pressure_mb'];
    $nowweather = $currentdata['current_observation']['weather'];
    $nowwind = $currentdata['current_observation']['wind_kph'];
    $nowwinddeg = $currentdata['current_observation']['wind_degrees'];
    $nowfeel = $currentdata['current_observation']['feelslike_c'];
    $nowuv = $currentdata['current_observation']['UV'];
    $nowvisibility = $currentdata['current_observation']['visibility_km'];


/*    if(windchill($nowtmp,$nowwind)>$nowtmp)
        $nowfeel=round(humidex($nowtmp, $nowhum));
    else
        $nowfeel=round(windchill($nowtmp,$nowwind));
    $nowfeel=round(windchill($nowtmp,$nowwind));*/

    $nowimg = 'img/'.$currentdata['current_observation']['icon'].'.jpg';
    
    //-------------DICTIONARY REPLACE-----------//
/*    $search = array('Clear', 'Clouds', 'Rain', 'Snow', 'Thunderstorm');
	$replace = array('clear', 'cloudy', 'raining', 'snowing', 'thunderstorms');*/
    $search = array('chance','partly','mostly');
    $replace = array('','','');
    $nowimg = str_replace($search, $replace, $nowimg);
    
    for($i=1;$i<6;$i++){
        ${'weatherimg'.$i} = str_replace($search, $replace, ${'weatherimg'.$i});
    }
    

    ?>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>weather</title>

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
            <?php $_GET['active']=3;
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
        <script>
            $(function () {
                $('#menu').metisMenu();
            });
            $.backstretch("<?=$nowimg?>");
            console.log("<?=$forecastapiurl?>");
            console.log("<?=$currentapiurl?>");
        </script>

    </body>

</html>