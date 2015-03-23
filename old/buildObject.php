<?php

    
$addr = array( 
             "@type" => "PostalAddress",
     "streetAddress" => $data['kg_streetAddress_field_id'],
   "addressLocality" => $data['kg_addressLocality_field_id'],
     "addressRegion" => $data['kg_addressRegion_field_id'],
        "postalCode" => $data['kg_postalCode_field_id'],
    "addressCountry" => $country_2to3[$data['kg_addressCountry_selected']];
);

function make_time ($day) {
    $day_long = $days[$day];
    $id_1 = strtolower($day_long) . 'Open';
    $id_2 = strtolower($day_long) . 'Close';
    $opening_time = $data['conditinal_fields'][$id_1];
    $closing_time = $data['conditinal_fields'][$id_2];
    if ( is_null($opening_time) && is_null($closing_time) )
       return;
    else
        return "$day $opening_time-$closing_time";
}

$hours = array();
foreach ( array("Mo","Tu","We","Th","Fr","Sa","Su") as $day ) {
    $get_hours = make_time($day);
    if ( !is_null($get_hours) )
      $hours[] = $get_hours;
}

$links = array();

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