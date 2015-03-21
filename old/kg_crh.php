<?php
/*
	Plugin Name: Knowledge Graph
	Plugin URI: https://github.com/DavidEngland/Knowledge-Graph
	Description: Adds knowlege graph json-ld to WP.
	Author: <a href="http://about.me/DavidEngland">Dave England</a>
	Author URI: http://about.me/DavidEngland
	Version: 0.0.1
	License: GPL v2
	Usage: Visit the plugin's settings page to configure your options.
	Tags: knowledge-graph, head, wp_head, json-ld, ld-json, schema, microdata
*/

add_action('wp_head', 'kg_make_json');

function kg_make_json( ) {
    
$addr = array( 
             "@type" => "PostalAddress",
     "streetAddress" => "238 Cherokee Ridge Drive",
   "addressLocality" => "Union Grove",
     "addressRegion" => "AL",
        "postalCode" => "35175",
    "addressCountry" => "USA"
);

/**
      "geo": {
    "@type": "GeoCoordinates",
    "latitude": "40.75",
    "longitude": "73.98"
  }
*/
    $latlong = array (
       "latitude" => "34.425902",
	  "longitude" => "-86.559893"  
    );
   
    $GeoCoordinates = array($latlong);
   
    $geo = array("@type" => $GeoCoordinates);
  
$hours = array (
    "Su 13:00-17:00",
    "Mo-Sa 11:00-17:00"
          );

$links = array(
    "https://plus.google.com/u/0/b/103991536077218528599",
    "https://www.youtube.com/channel/UCvlA5fj-JiuZkYMSjpgnELw"
);

$lang = array ("English","Finnish");

$contact = array(
            "@type" => "ContactPoint",
        "telephone" => "+1-256-682-0383",
      "contactType" => "Sales and Marketing",
       "areaServed" => "US",
"availableLanguage" => $lang
);

$data2 = array(
     "@context" => "http://schema.org",
        "@type" => "LocalBusiness",
         'name' => 'Cherokee Ridge Country Club Lifestyle Information and Real Estate Sales Center',
         'logo' => "http://cherokeeridgehomes.com/wp-content/uploads/Golfing-Lion-at-Cherokee-Ridge.png",
  "description" => "Showcasing the relevant and responsive Cherokee Ridge lifestyle to the future property owners of this beautiful golf community.", 
      "address" => $addr,
 "openingHours" => $hours,
    "telephone" => "+1-256-457-0804",
 "contactPoint" => $contact,
          "url" => "http://CherokeeRidgeHomes.com",
       "sameAs" => $links    
);

//header('Content-type: application/ld+json');
    
    $str = '<script type="application/ld+json">'.PHP_EOL;

    $str .= json_encode( $data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ).PHP_EOL;
    
    echo $str . '</script>' . PHP_EOL;

}

?>