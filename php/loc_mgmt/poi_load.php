<?php

require('../static_vars/vars.php');
require('../string_mgmt/str_process.php');

// Sanitize
$ne_corner = incomingSanitize($con, $_GET['ne_corner']);
$sw_corner = incomingSanitize($con, $_GET['sw_corner']);

$type = incomingSanitize($con, $_GET['type']);

$rt_url = "";

if (strcmp($type, "att") == 0) {
	$rt_url = "https://roadtrippers.com/api/v2/pois/discover?segments%5B%5D=amusement-parks&segments%5B%5D=museums&segments%5B%5D=offbeat-attractions&segments%5B%5D=top-attractions&segments%5B%5D=cultural-theme-tours&segments%5B%5D=sightseeing-tours&segments%5B%5D=zoos-aquariums&segments%5B%5D=architectural-sites&segments%5B%5D=college-icons&segments%5B%5D=filming-location&segments%5B%5D=historic-site&segments%5B%5D=literary-place&segments%5B%5D=military-site&segments%5B%5D=monuments-memorials&segments%5B%5D=photo-op&segments%5B%5D=amazing-engineering&segments%5B%5D=public-art&segments%5B%5D=science-technology&sw_corner=".$sw_corner."&ne_corner=".$ne_corner."&offset=0&page_size=40&radius=50";
} else if (strcmp($type, "res") == 0) {
	$rt_url = "https://roadtrippers.com/api/v2/pois/discover?segments%5B%5D=bars-drinks&segments%5B%5D=american-food&segments%5B%5D=fast-food&segments%5B%5D=coffee-tea&segments%5B%5D=delis-bakeries&segments%5B%5D=diners-breakfast-spots&segments%5B%5D=sweet-tooth&segments%5B%5D=restaurants&segments%5B%5D=asian-food&segments%5B%5D=latin-american-food&segments%5B%5D=european-food&segments%5B%5D=african-food&segments%5B%5D=middle-eastern-food&segments%5B%5D=australian-food&segments%5B%5D=vegetarian-health-food&segments%5B%5D=wineries-breweries-distilleries&sw_corner=".$sw_corner."&ne_corner=".$ne_corner."&offset=0&page_size=40&radius=50";
} else if (strcmp($type, "sho") == 0) {
	$rt_url = "https://roadtrippers.com/api/v2/pois/discover?segments%5B%5D=antiques&segments%5B%5D=books-music&segments%5B%5D=crafts-handmade&segments%5B%5D=general-goods&segments%5B%5D=specialty-shops&segments%5B%5D=clothing&segments%5B%5D=outfitters&segments%5B%5D=gifts-souvenirs&segments%5B%5D=malls-shopping-areas&sw_corner=".$sw_corner."&ne_corner=".$ne_corner."&offset=0&page_size=40&radius=50";
} else {
	$rt_url = "https://roadtrippers.com/api/v2/pois/discover?segments%5B%5D=amusement-parks&segments%5B%5D=museums&segments%5B%5D=offbeat-attractions&segments%5B%5D=top-attractions&segments%5B%5D=cultural-theme-tours&segments%5B%5D=sightseeing-tours&segments%5B%5D=zoos-aquariums&segments%5B%5D=architectural-sites&segments%5B%5D=college-icons&segments%5B%5D=filming-location&segments%5B%5D=historic-site&segments%5B%5D=literary-place&segments%5B%5D=military-site&segments%5B%5D=monuments-memorials&segments%5B%5D=photo-op&segments%5B%5D=amazing-engineering&segments%5B%5D=public-art&segments%5B%5D=science-technology&segments%5B%5D=bars-drinks&segments%5B%5D=american-food&segments%5B%5D=fast-food&segments%5B%5D=coffee-tea&segments%5B%5D=delis-bakeries&segments%5B%5D=diners-breakfast-spots&segments%5B%5D=sweet-tooth&segments%5B%5D=restaurants&segments%5B%5D=asian-food&segments%5B%5D=latin-american-food&segments%5B%5D=european-food&segments%5B%5D=african-food&segments%5B%5D=middle-eastern-food&segments%5B%5D=australian-food&segments%5B%5D=vegetarian-health-food&segments%5B%5D=wineries-breweries-distilleries&segments%5B%5D=antiques&segments%5B%5D=books-music&segments%5B%5D=crafts-handmade&segments%5B%5D=general-goods&segments%5B%5D=specialty-shops&segments%5B%5D=clothing&segments%5B%5D=outfitters&segments%5B%5D=gifts-souvenirs&segments%5B%5D=malls-shopping-areas&sw_corner=".$sw_corner."&ne_corner=".$ne_corner."&offset=0&page_size=40&radius=50";
}

// Set headers to fool the API
$context = stream_context_create(array(
    'http' => array(
        'method' => "GET",
        'header' =>
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n" .
            "Accept-Language: en-US,en;q=0.8\r\n".
            "Keep-Alive: timeout=3, max=10\r\n",
            "Connection: keep-alive",
        'user_agent' => "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.66 Safari/535.11",
        "ignore_errors" => true,
        "timeout" => 3
    )
));

$json = file_get_contents($rt_url, false, $context);

$array = json_decode($json, true);

$html = "";

$array = $array["pois"];

for ($i = 0; $i < count($array); $i++) { 
	$res = $array[$i];
	$name = $res["name"];
	$rating = substr($res["rating"], 0, 4);
	$pic = $res["v_145x145_url"];
	$loc = $res["loc"];
	$loc = $loc[1].",".$loc[0];

	$html .= '<div class="poi-item">
                    <img src="'.$pic.'" class="poi-img" />
                    <div class="poi-item-text">
                        <a class="poi-add" onclick="addToRoute(\''.$loc.'\', \''.mysqli_real_escape_string($con, $name).'\')">Add to Route</a>

                        <p class="poi-name">'.$name.'</p>
                        <p class="poi-rating">Rated '.$rating.'/5</p>
                    </div>
                </div>';
}

echo $html;
?>