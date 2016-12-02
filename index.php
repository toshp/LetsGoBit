<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8"/>
<meta name="apple-mobile-web-app-capable" content="yes">
    
<link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>

<meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1.0">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
    
<title>LET'S GO BIT</title>

<link rel="stylesheet" type="text/css" href="../stylesheets/411-style.css">
    
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>

<script>

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

</script>
</head>
    
<body>
    
    <div class="sidebar">
        <div class="section entry-section">
            <h1>Where to?</h1>
            <p class="std-text subtle">Please enter you start and end locations.</p>

            <div class="form-area">
                <p class="input-label">Start</p>
                <input class="input-text start-loc" type="text" />

                <p class="input-label">End</p>
                <input class="input-text end-loc" type="text" />
            </div>

            <img class="load-icon hide" src="images/ellipsis.svg" />

            <a class="input-submit" onclick="findRoute();">Go!</a>

        </div> <!-- section -->
    </div> <!-- sidebar -->

    <div class="glass"></div>

    <iframe frameborder="0" class="map-frame" src=""></iframe>
   
   <script>

//https://www.google.com/maps/dir/Boston,+MA/Nashua,+NH/

function findRoute() {
    showLoad();

    var start = $(".start-loc").val();
    var end = $(".end-loc").val();

    start = encodeURI(start);
    end = encodeURI(end);

    var link = "https://www.google.com/maps/dir/" + start + "/" + end + "/";
    setIframe(link);

}

function showLoad() {
    $(".input-submit").addClass("hide-spot");
    $(".load-icon").removeClass("hide");
}

function showMap() {
    $(".glass").addClass("clear-glass");
    $(".load-icon").addClass("hide");
    $(".input-submit").removeClass("hide-spot");    
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