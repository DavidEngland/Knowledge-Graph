<?php   
$addr = array( 
             "@type" => "PostalAddress",
     "streetAddress" => "107 Clinton Ave W",
   "addressLocality" => "Huntsville",
     "addressRegion" => "AL",
        "postalCode" => "35801",
    "addressCountry" => "USA"
);

$links = array(
    "https://www.facebook.com/RealEstateIntelligenceAgencyInc",
    "http://twitter.com/REIA007",
    "https://plus.google.com/115551206707821669279",
    "https://www.youtube.com/channel/UCJ_pqfxGw6hhSMuJxIPQHZg",
    "https://www.linkedin.com/company/real-estate-intelligence-agency"
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
        "@type" => "RealEstateAgent",
         'name' => 'Real Estate Intelligence Agency',
         'logo' => "http://www.realestate-huntsville.com/wp-content/uploads/2012/12/real-estate-intelligence-agency-logo.png",
  "description" => " A real estate brokerage specializing in back-to-basics residential and commercial real estate sales and marketing services.", 
      "address" => $addr,
    "telephone" => "+1-256-457-0804",
 "contactPoint" => $contact,
          "url" => "http://www.RealEstate-Huntsville.com",
       "sameAs" => $links    
);

header('Content-type: application/ld+json');

  $str = json_encode( $data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
  echo $str.PHP_EOL;



  ?>
