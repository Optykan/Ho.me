<!DOCTYPE html>
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
    

/*    function windchill($Ta,$ws){
        $Ta = $Ta*(9/5)+32;
        $ws = $ws/1.609344;
        $wc=35.74+0.6215*$Ta-35.75*$ws**0.16+0.4275*$Ta*$ws**0.16;
        $wc=($wc-32)*(5/9);
        return $wc;
    }*/

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
    

?>
    <html style="height:100%;">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>home</title>

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
                            <a href="#" class="sidebar-active">
                                <span class="fa fa-home"></span>
                                <span class="sidebar-nav-item">Overview</span>

                            </a>
                        </li>
                        <li>
                            <a href="stocks.php">
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

                    <div class='current'>
                        <center>
                            <p class="welcome po">welcome home</p>
                            <p class='now'>it's
                                <span class='temp'><?=round($nowtmp)?></span>&deg;<span class='unit'>C</span> now, <span class='lowercase'><?=$nowweather?></span></br>
                            </p>
                            <p class='feels'>feels like <span class='temp'><?=round($nowfeel)?></span>&deg;<span class='unit'>C</span></p>
                        </center>
                    </div>
                </div>
            </section>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="js/metisMenu.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
        <script>
            $(function () {
                $('#menu').metisMenu();
            });
            $.backstretch("img/wallpaper-dim.png");
        </script>

    </body>

    </html>