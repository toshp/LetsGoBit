<?php

ob_start();
session_start();
session_regenerate_id();

require('php/static_vars/vars.php');
require('php/user_mgmt/authenticate.php');

$user_id = false;
$email = false;
$phone = false;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone_number'];
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8"/>
<meta name="apple-mobile-web-app-capable" content="yes">
    
<link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>

<meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1.0">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
    
<title>LET'S GO BIT</title>

<link rel="stylesheet" type="text/css" href="stylesheets/411-style.css?v=1.8">
    
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>

<script>

var g_sw_corner = "";
var g_ne_corner = "";
var g_start;
var g_end;
var g_f_link;

function setIframe(link) {

    iframe = document.getElementsByTagName('iframe')[0];
    url = link;
    
    getData = function (data) {
        if (data && data.query && data.query.results && data.query.results.resources && data.query.results.resources.content && data.query.results.resources.status == 200) loadHTML(data.query.results.resources.content);
        else if (data && data.error && data.error.description) loadHTML(data.error.description);
        else loadHTML('Error: Cannot load ' + url);
    };
    
    loadURL = function (src) {
        url = src;
        var script = document.createElement('script');
        script.src = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20data.headers%20where%20url%3D%22' + encodeURIComponent(url) + '%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=getData';
        document.body.appendChild(script);
    };
    
    loadHTML = function (html) {
        iframe.src = 'about:blank';
        iframe.contentWindow.document.open();
        iframe.contentWindow.document.write(html.replace(/<head>/i, '<head><base href="' + url + '"><scr' + 'ipt>document.addEventListener("click", function(e) { if(e.target && e.target.nodeName == "A") { e.preventDefault(); parent.loadURL(e.target.href); } });</scr' + 'ipt>'));
        iframe.contentWindow.document.close();

        showMap();
    }

    loadURL(link);
}

function showSignUp() {
    $(".entry-section").css({"display":"none"});
    $(".signin-section").css({"display":"none"});
    $(".signup-section").css({"display":"block"});
}

function showMain() {
    $(".signup-section").css({"display":"none"});
    $(".signin-section").css({"display":"none"});
    $(".entry-section").css({"display":"block"});
}

function showSignIn() {
    $(".entry-section").css({"display":"none"});
    $(".signup-section").css({"display":"none"});
    $(".signin-section").css({"display":"block"});
}

<?php
if ($user_id != false) {
    echo '
    function sendRoute() {
        var route = $(".link-preview").attr("href");

        $.ajax( {
            url:"php/user_mgmt/send_route.php",
            data: "route=" + route,
            method: "POST",
            success:function(msg) {
                alert("Sent to phone!");
                $(".send-button").css({"display":"none"});
            }
        }); 
    }';
} else {
    echo '
    function sendRoute() {
        showSignUp();
    }';
}
    
?>

</script>
</head>
    
<body>
    
    <div class="sidebar">
        
        <div class="section entry-section">
            <h1 id="title">Where to?</h1>
            <p class="std-text subtle" id="subtext">Please enter your start and end locations.</p>

            <a class="link-preview" href="#" target="_blank"></a>    
            
            <div class="form-area">
                <p class="input-label">Start</p>
                <div class="input-cover"></div>
                <input class="input-text start-loc" type="text" />

                <div class="poi-box">
                    <div class="via-box">
                        <p class="input-label">Via</p>
                        <p class="via-name">Freedom Trail</p>
                    </div>

                    <div class="poi-box-button" onclick="showPOI()">
                        <p>Add a Point of Interest</p>
                    </div>
                </div>

                <p class="input-label">End</p>
                <div class="input-cover"></div>
                <input class="input-text end-loc" type="text" />
            </div>

            <img class="load-icon hide" src="images/ellipsis.svg" />

            <a class="input-submit go-button" onclick="findRoute();">Go!</a>
            <a class="input-submit fin-button" onclick="finalizeRoute();">Finalize</a>
            <a class="input-submit send-button" onclick="sendRoute();">Text Me Route</a>
            <a class="input-submit redo-button hide-spot" onclick="location.reload();">Edit Start/End</a>

        </div> <!-- section -->

        <div class="section signup-section">
            <h1>Sign Up</h1>
            <p class="std-text subtle">Sign up to send directions to your phone.</p>

            
            <div class="form-area">
                <form action="php/user_mgmt/signup.php" method="post">
                    <p class="input-label">Email</p>
                    <input class="input-text" name="email" type="email" />

                    <p class="input-label">Phone Number</p>
                    <input class="input-text" name="phone" type="text" />

                    <p class="input-label">Password</p>
                    <input class="input-text" name="password" type="password" />

                    <input class="input-submit" type="submit" value="Sign Up" />
                </form>
            </div>
        </div> <!-- section -->

        <div class="section signin-section">
            <h1>Sign In</h1>
            <p class="std-text subtle">Sign in to send directions to your phone.</p>

            
            <div class="form-area">
                <form action="php/user_mgmt/signin.php" method="post">
                    <p class="input-label">Email</p>
                    <input class="input-text" name="email" type="email" />

                    <p class="input-label">Password</p>
                    <input class="input-text" name="password" type="password" />

                    <input class="input-submit" type="submit" value="Sign In" />
                </form>
            </div>
        </div> <!-- section -->

        <p class="logo"><span style="cursor:pointer" onclick="showMain();">LetsGoBit<span style="color:#aaa">.ch</span> </span>

        <?php

        if ($user_id == false) {
            echo '
                <span class="account-opts">
                    <a class="account-button" onclick="showSignUp();">Sign Up</a>
                    <a class="account-button" onclick="showSignIn();">Sign In</a>
                </span>';
        } else {
            echo '
                <span class="account-opts">
                    <a class="account-button" style="text-decoration:none;">'.$email.'</a>
                    <a class="account-button" href="php/user_mgmt/signout.php">Sign Out</a>
                </span>';
        }

        ?>
        </p>
    </div> <!-- sidebar -->

    <div class="glass"></div>

    <iframe frameborder="0" class="map-frame" src=""></iframe>

    <div class="poi-holder">
        <div class="poi-container">
            <div class="poi-header">
                <h2>Points of Interest</h2>
                <span class="poi-type">
                    <a class="poi-opt poi-all selected-poi" onclick="loadPOIType('all')">All POIs</a>
                    <a class="poi-opt poi-att" onclick="loadPOIType('att')">Attractions</a>
                    <a class="poi-opt poi-res" onclick="loadPOIType('res')">Restaurants &amp; Cafés</a>
                    <a class="poi-opt poi-sho" onclick="loadPOIType('sho')">Shopping</a>
                </span>
            </div>

            <div class="poi-listing">
                
            </div> <!-- poi-listing -->

        </div>
    </div> <!-- poi-holder -->
   
   <script>

//https://www.google.com/maps/dir/Boston,+MA/Nashua,+NH/

function findRoute() {
    showLoad();

    var start = $(".start-loc").val();
    var end = $(".end-loc").val();

    start = encodeURI(start);
    end = encodeURI(end);

    var link = "https://www.google.com/maps/dir/" + start + "/" + end + "/";
    g_start = start;
    g_end = end;

    setIframe(link);

}

function showLoad() {
    $(".input-submit").addClass("hide-spot");
    $(".load-icon").removeClass("hide");
}

function showMap() {
    $(".glass").addClass("clear-glass");
    $(".load-icon").addClass("hide");
    $(".poi-box").css({"display":"block"});
    $(".redo-button").removeClass("hide-spot");

    $(".poi-holder").css({"opacity":"0", "display":"none"});  
    $(".map-frame").removeClass("blur");

    $("#subtext").html("Please select your via point.");
    $(".input-cover").css({"display":"block"});
    $(".go-button").css({"display":"none"});

    var realURL = $('.map-frame').contents().find('meta[itemprop=image]').attr("content");
    var m = realURL.indexOf("markers=");
    if (g_ne_corner == "" && m > -1) {
        realURL = realURL.substring(m + 8);
        m = realURL.indexOf("&");
        if (m > -1) {
            realURL = realURL.substring(0, m);
        } 

        var temp = realURL.indexOf("%2C");
        var lat1 = realURL.substring(0, temp);
        realURL = realURL.substring(temp + 3);

        temp = realURL.indexOf("%7C");
        var long1 = realURL.substring(0, temp);
        realURL = realURL.substring(temp + 3);

        temp = realURL.indexOf("%2C");
        var lat2 = realURL.substring(0, temp);
        var long2 = realURL.substring(temp + 3);

        // Larger latitude must be ne_corner

        if (lat1 > lat2) {
            if (long1 < long2) {
                $.ajax( {
                    url:'php/loc_mgmt/poi_load.php',
                    data: "ne_corner=" + long1 + "%2C" + lat1 + "&sw_corner=" + long2 + "%2C" + lat2 + "&type=all",
                    method: 'GET',
                    success:function(msg) {
                        $(".poi-listing").html(msg);
                        g_sw_corner = long2 + "%2C" + lat2;
                        g_ne_corner = long1 + "%2C" + lat1;
                    }
                }); 
            } else {
                $.ajax( {
                    url:'php/loc_mgmt/poi_load.php',
                    data: "ne_corner=" + long2 + "%2C" + lat1 + "&sw_corner=" + long1 + "%2C" + lat2 + "&type=all",
                    method: 'GET',
                    success:function(msg) {
                        $(".poi-listing").html(msg);
                        g_sw_corner = long1 + "%2C" + lat2;
                        g_ne_corner = long2 + "%2C" + lat1;
                    }
                }); 
            }
        } else {
            if (long1 > long2) {
                $.ajax( {
                    url:'php/loc_mgmt/poi_load.php',
                    data: "ne_corner=" + long2 + "%2C" + lat2 + "&sw_corner=" + long1 + "%2C" + lat1 + "&type=all",
                    method: 'GET',
                    success:function(msg) {
                        $(".poi-listing").html(msg);
                        g_ne_corner = long2 + "%2C" + lat2;
                        g_sw_corner = long1 + "%2C" + lat1;
                    }
                }); 
            } else {
                $.ajax( {
                    url:'php/loc_mgmt/poi_load.php',
                    data: "ne_corner=" + long1 + "%2C" + lat2 + "&sw_corner=" + long2 + "%2C" + lat1 + "&type=all",
                    method: 'GET',
                    success:function(msg) {
                        $(".poi-listing").html(msg);
                        g_ne_corner = long1 + "%2C" + lat2;
                        g_sw_corner = long2 + "%2C" + lat1;
                    }
                }); 
            }
        }
    }
}

function showPOI() {
    $(".map-frame").addClass("blur");
    $(".poi-holder").css({"display":"block"}).animate({
        "opacity":"1"
    }, 200);
}

function loadPOIType(type) {
    $(".poi-opt").removeClass("selected-poi");

    if (type == "att") {
        $(".poi-att").addClass("selected-poi");
    } else if (type == "sho") {
        $(".poi-sho").addClass("selected-poi");
    } else if (type == "res") {
        $(".poi-res").addClass("selected-poi");
    } else {
        $(".poi-all").addClass("selected-poi");
        type = "all";
    }

    $.ajax( {
        url:'php/loc_mgmt/poi_load.php',
        data: "ne_corner=" + g_ne_corner + "&sw_corner=" + g_sw_corner + "&type=" + type,
        method: 'GET',
        success:function(msg) {
            $(".poi-listing").html(msg);
        }
    }); 
}

function addToRoute(loc, name) {
    var link = "https://www.google.com/maps/dir/" + g_start + "/" + loc + "/" + g_end + "/";

    $(".via-name").html(name);
    $(".via-box").css({"display":"block"});
    $(".fin-button").removeClass("hide-spot");
    $(".fin-button").css({"display":"inline-block"});
    $(".poi-box-button p").html("Change Via Point");
    setIframe(link);

    g_f_link = link;
}

function finalizeRoute() {
    $("#title").html("Your trip.");
    $("#subtext").html("Here is the link for directions.");
    $(".poi-box-button").css({"display":"none"});
    $(".via-box").css({"padding-bottom":"5px"});

    $(".redo-button").html("Plan New Trip");
    $(".fin-button").css({"display":"none"});
    $(".send-button").removeClass("hide-spot").css({"display":"inline-block"});

    $(".link-preview").css({"display":"block"}).html("http://google.com/maps/...").attr("href", g_f_link);
}

   </script>

    <!-- Begin Inspectlet Embed Code -->
<script type="text/javascript" id="inspectletjs">
window.__insp = window.__insp || [];
__insp.push(['wid', 746306330]);
(function() {
function ldinsp(){if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
setTimeout(ldinsp, 500); document.readyState != "complete" ? (window.attachEvent ? window.attachEvent('onload', ldinsp) : window.addEventListener('load', ldinsp, false)) : ldinsp();
})();
</script>
<!-- End Inspectlet Embed Code -->
</body>
</html>