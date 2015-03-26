<?php
/*
Plugin Name: Knowledge Graph
Plugin URI: https://github.com/DavidEngland/Knowledge-Graph
Description: Adds knowlege graph json-ld to WP.
Author: <a href="http://about.me/DavidEngland">Dave England</a>
Author URI: http://about.me/DavidEngland
Version: 0.0.1
License: GPL v2
Usage: Visit the plugin\'s settings page to configure your options.
Tags: knowledge, graph, head, wp_head, jsonld, ldjson, schema, microdata
*/

//Define some standard constants.
if ( !defined( 'MYPLUGIN_THEME_DIR' ) )
    define( 'MYPLUGIN_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template() );

if ( !defined( 'MYPLUGIN_PLUGIN_NAME' ) )
    define( 'MYPLUGIN_PLUGIN_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );

if ( !defined( 'MYPLUGIN_PLUGIN_DIR' ) )
    define( 'MYPLUGIN_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . MYPLUGIN_PLUGIN_NAME );

if ( !defined( 'MYPLUGIN_PLUGIN_URL' ) )
    define( 'MYPLUGIN_PLUGIN_URL', WP_PLUGIN_URL . '/' . MYPLUGIN_PLUGIN_NAME );

if ( !defined( 'MYPLUGIN_VERSION_KEY' ) )
    define( 'MYPLUGIN_VERSION_KEY', 'myplugin_version' );

if ( !defined( 'MYPLUGIN_VERSION_NUM' ) )
    define( 'MYPLUGIN_VERSION_NUM', '0.0.1' );

add_option( MYPLUGIN_VERSION_KEY, MYPLUGIN_VERSION_NUM );

//Add settings link on plugin page
add_filter( 'plugin_action_links', 'myplugin_plugin_action_links', 10, 2 );

function myplugin_plugin_action_links( $links, $file ) {
    static $this_plugin;
    
    if ( !$this_plugin ) {
        $this_plugin = plugin_basename( __FILE__ );
    } //!$this_plugin
    
    if ( $file == $this_plugin ) {
        $settings_link = '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/options-general.php?page=options-general.php_knowledge_graph">Settings</a>';
        array_unshift( $links, $settings_link );
    } //$file == $this_plugin
    
    return $links;
}

$contact_types = array(
     "sales",
    "customer support",
    "reservations",
    "credit card support",
    "emergency",
    "customer service",
    "technical support",
    "billing support",
    "bill payment",
    "baggage tracking",
    "roadside assistance",
    "package tracking" 
);

foreach ( $contact_types as $contact_type ) {
    $contact_slug[]                = str_replace( ' ', '-', $contact_type );
    $type_contact[ $contact_type ] = ucwords( $contact_type );
} //$contact_types as $contact_type


//Read in Country names indexed by two letter codes (ISO-3166), from http://country.io
$country_names = json_decode( file_get_contents( MYPLUGIN_PLUGIN_DIR . "/lib/names.json" ), true );

//Read in Country two letter to three letter mappings
$country_2to3 = json_decode( file_get_contents( MYPLUGIN_PLUGIN_DIR . "/lib/iso3.json" ), true );

//Same for days of the week
$days = json_decode( file_get_contents( MYPLUGIN_PLUGIN_DIR . "/lib/days.json" ), true );

//JSON Pretty Print, because some old version of PHP don't have.
require_once( MYPLUGIN_PLUGIN_DIR . "/lib/json_format.php" );

//include the main class file
require_once( MYPLUGIN_PLUGIN_DIR . "/admin-page-class/admin-page-class.php" );

function my_array_merge( $arry, $key, $value ) {
    if ( !empty( $value ) ) {
        return array_merge( $arry, array(
             $key => $value 
        ) );
    } //!empty( $value )
    return $arry;
}

/**
 * admin page configuration
 */
$config = array(
     'menu' => 'settings', //sub page to settings page
    'page_title' => __( 'Knowledge Graph', 'apc' ), //The name of this page 
    'capability' => 'edit_themes', // The capability needed to view the page 
    'option_group' => 'kg_options', //the name of the option to create in the database
    'id' => 'admin_page', // meta box id, unique per page
    'fields' => array( ), // list of fields (can be added by field arrays)
    'local_images' => false, // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);

/**
 * instantiate your admin page
 */
$options_panel = new BF_Admin_Page_Class( $config );
$options_panel->OpenTabs_container( '' );

/**
 * define your admin page tabs listing
 */
$options_panel->TabsListing( array(
     'links' => array(
         'options_1' => __( 'Basic Information', 'apc' ),
        'options_2' => __( 'Branding', 'apc' ),
        'options_3' => __( 'Links', 'apc' ),
        'options_4' => __( 'Contact', 'apc' ),
        'options_4a' => __( 'Hours', 'apc' ),
        'options_5' => __( 'Search', 'apc' ),
        'options_6' => __( 'Install', 'apc' ),
        'options_7' => __( 'Import Export', 'apc' ) 
    ) 
) );

/**
 * Open admin page first tab
 */
$options_panel->OpenTab( 'options_1' );

/**
 * Add fields to admin page first tab
 * 
 */

//title
$options_panel->Title( __( "Basic Information", "apc" ) );

//An optionl descrption paragraph
$options_panel->addParagraph( __( "Company Name and address.", "apc" ) );

$options_panel->addSelect( '@context', array(
     "http://schema.org" => "MicroData" 
), array(
     'desc' => __( "Only one type supported currently", "apc" ) 
) );

$options_panel->addSelect( '@type', array(
     "Organization" => "Organization",
    "LocalBusiness" => "Local Business",
    "Airline" => "Airline",
    "EducationalOrganization" => "Educational Organization",
    "GovernmentOrganization" => "Government Organization",
    "NGO" => "Non-government Organization",
    "PerformingGroup" => "Performing Group",
    "AnimalShelter" => "Animal Shelter",
    "AutomotiveBusiness" => "Automotive Business",
    "ChildCare" => "Child Care",
    "DryCleaningOrLaundry" => "Dry Cleaning or Laundry",
    "EmergencyService" => "Emergency Service",
    "EmploymentAgency" => "Employment Agency",
    "EntertainmentBusiness" => "Entertainment Business",
    "FinancialService" => "Financial Service",
    "FoodEstablishment" => "Food Establishment",
    "GovernmentOffice" => "Government Office",
    "HealthAndBeautyBusiness" => "Health and Beauty Business",
    "HomeAndConstructionBusiness" => "Home and Construction Business",
    "InternetCafe" => "Internet Cafe",
    "Library" => "Library",
    "LodgingBusiness" => "Lodging Business",
    "MedicalOrganization" => "Medical Organization",
    "ProfessionalService" => "Professional Service",
    "RadioStation" => "Radio Station",
    "RealEstateAgent" => "Real Estate Agent",
    "RecyclingCenter" => "Recycling Center",
    "SelfStorage" => "Self Storage",
    "ShoppingCenter" => "Shopping Center",
    "SportsActivityLocation" => "Sports Activity Location",
    "Store" => "Store",
    "TelevisionStation" => "Television Station",
    "TouristInformationCenter" => "Tourist Information Center",
    "TravelAgency" => "Travel Agency" 
), array(
     'desc' => __( "Choose the best category @type", "apc" ),
    'std' => __( "Organization", "apc" ) 
) );

$options_panel->addText( 'name', array(
     'name' => __( 'Company Name', 'apc' ),
    'std' => get_bloginfo( 'name' ),
    'desc' => __( 'Legal Company name', 'apc' ) 
) );

//email with validation
$options_panel->addText( 'email', array(
     'name' => __( ' Main Email ', 'apc' ),
    'std' => get_bloginfo( 'admin-email' ),
    'desc' => __( "Enter a valid e-mail address.", "apc" ),
    'validate' => array(
         'email' => array(
             'param' => '',
            'message' => __( "Must be a valid email address!", "apc" ) 
        ) 
    ) 
) );

$options_panel->addText( 'streetAddress', array(
     'name' => __( 'Street', 'apc' ),
    'std' => '103 Elm',
    'validate' => array(
         'street' => array(
             'param' => '',
            'message' => __( "Enter a valid Street please!", "apc" ) 
        ) 
    ) 
) );

$options_panel->addText( 'addressLocality', array(
     'name' => __( 'City', 'apc' ),
    'std' => 'City',
    'validate' => array(
         'alphanumeric' => array(
             'param' => '',
            'message' => __( "Must be alpha numberic!", "apc" ) 
        ) 
    ) 
) );

$options_panel->addText( 'addressRegion', array(
     'name' => __( 'State', 'apc' ),
    'std' => 'AL',
    'validate' => array(
         'alphanumeric' => array(
             'param' => '',
            'message' => __( "Must be alpha numberic!", "apc" ) 
        ) 
    ) 
) );

$options_panel->addText( 'postalCode', array(
     'name' => __( 'Postal Zip Code', 'apc' ),
    'std' => '35633',
    'validate' => array(
         'alphanumeric' => array(
             'param' => '',
            'message' => __( "Must be alpha numberic!", "apc" ) 
        ) 
    ) 
) );

$options_panel->addSelect( 'addressCountry', $country_names, array(
     'name' => __( 'Country', 'apc' ),
    'std' => array(
         'UNITED STATES' 
    ),
    'desc' => __( 'Choose your Country', 'apc' ) 
) );

$options_panel->addTextarea( 'description', array(
     'name' => __( 'Description', 'apc' ),
    'std' => get_bloginfo( 'description' ),
    'desc' => __( 'Brief description of what company is.', 'apc' ) 
) );

/**
 * Close first tab
 */
$options_panel->CloseTab();


/**
 * Open admin page Second tab
 */
$options_panel->OpenTab( 'options_2' );

//title
$options_panel->Title( __( 'Logo', 'apc' ) );
//Typography field

//Image field
$options_panel->addImage( 'logo', array(
     'name' => __( 'Company Logo ', 'apc' ),
    'preview_height' => '150px',
    'preview_width' => '150px',
    'desc' => __( 'Company logo image<br/><small>Image preview may appear distorted, but, the image itself should NOT be.</small>', 'apc' ) 
) );

/**
 * Close second tab
 */
$options_panel->CloseTab();



/**
 * Open admin page 3rd tab
 */
$options_panel->OpenTab( 'options_3' );
/**
 * Add fields to your admin page 3rd tab
 * 
 */
//title
$options_panel->Title( __( "URL and Social sites", "apc" ) );

$options_panel->addText( 'url', array(
     'name' => __( ' Website ', 'apc' ),
    'std' => get_bloginfo( 'wpurl' ),
    'desc' => __( "URL of Company's main website", "apc" ),
    'validate' => array(
         'url' => array(
             'param' => '',
            'message' => __( "must be a valid URL", "apc" ) 
        ) 
    ) 
) );

$repeater_fields[] = $options_panel->addText( 'li', array(
     'name' => __( 'Enter a URL ', 'apc' ),
    'std' => 'http://',
    'validate' => array(
         'url' => array(
             'param' => '',
            'message' => __( "must be a valid URL", "apc" ) 
        ) 
    ) 
), true );

$options_panel->addRepeaterBlock( 'sameAs', array(
     'name' => __( 'Other Company profile links', 'apc' ),
    'fields' => $repeater_fields,
    'desc' => __( 'For Example:  http://www.facebook.com/CompanyName', 'apc' ) 
) );

/**
 * Close 3rd tab
 */
$options_panel->CloseTab();


/**
 * Open admin page 4th tab
 */
$options_panel->OpenTab( 'options_4' );

//title
$options_panel->Title( __( "Contact", "apc" ) );

$options_panel->addText( 'telephone', array(
     'name' => __( 'Main Telephone Number', 'apc' ),
    'std' => '+1(800) 555-5555',
    'desc' => __( 'Company main phone number', 'apc' ),
    'validate' => array(
         'phone' => array(
             'param' => '',
            'message' => __( "Telephone Number does not validate!", "apc" ) 
        ) 
    ) 
) );

$options_panel->addCheckbox( 'telephone_show', array(
     'name' => __( 'Show main phone?', 'apc' ),
    'std' => true,
    'desc' => __( 'Inculde main phone or not', 'apc' ) 
) );

$phone_options[] = $options_panel->addText( 'telephone', array(
     'name' => __( 'Phone Number', 'apc' ),
    'validate' => array(
         'phone' => array(
             'param' => '',
            'message' => __( "Telephone Number does not validate!", "apc" ) 
        ) 
    ) 
), true );

$phone_options[] = $options_panel->addSelect( 'contactType', $type_contact, array(
     'name' => __( "Choose Type", "apc" ) 
), true );

$phone_options[] = $options_panel->addCheckbox( 'TollFree', array(
     'name' => __( 'Toll Free?', 'apc' ),
    'std' => true 
), true );

$phone_options[] = $options_panel->addCheckbox( 'HearingImpairedSupported', array(
     'name' => __( 'Hearing Impaired?', 'apc' ),
    'std' => false 
), true );

$phone_options[] = $options_panel->addText( 'areaServed', array(
     'name' => __( "Area Served", 'apc' ),
    'std' => "US, CA, MX" 
), true );

$phone_options[] = $options_panel->addText( 'availableLanguage', array(
     'name' => __( "Languages, comma seperated", 'apc' ),
    'std' => "English, Spanish, German, French" 
), true );

$options_panel->addRepeaterBlock( 'ContactPoints', array(
     'inline' => true,
    'name' => __( "Contact Point", 'apc' ),
    'fields' => $phone_options 
), true );

/**
 * Close 4th tab
 */
$options_panel->CloseTab();

/**
 * Open admin page
 */
$options_panel->OpenTab( 'options_4a' );

//title
$options_panel->Title( __( 'Opening Hours', 'apc' ) );

$Conditinal_fields[] = $options_panel->addTime( 'mondayOpen', array(
     'name' => __( "Time open Monday", "apc" ),
    'std' => '08:00' 
), true );
$Conditinal_fields[] = $options_panel->addTime( 'mondayClose', array(
     'name' => __( "Time close Monday", "apc" ),
    'std' => '17:00' 
), true );


$Conditinal_fields[] = $options_panel->addTime( 'tuesdayOpen', array(
     'name' => __( "Time open Tuesday", "apc" ),
    'std' => '08:00' 
), true );
$Conditinal_fields[] = $options_panel->addTime( 'tuesdayClose', array(
     'name' => __( "Time close Tuesday", "apc" ),
    'std' => '17:00' 
), true );


$Conditinal_fields[] = $options_panel->addTime( 'wednesdayOpen', array(
     'name' => __( "Time open Wednesday", "apc" ),
    'std' => '08:00' 
), true );
$Conditinal_fields[] = $options_panel->addTime( 'wednesdayClose', array(
     'name' => __( "Time close Wednesday", "apc" ),
    'std' => '17:00' 
), true );


$Conditinal_fields[] = $options_panel->addTime( 'thursdayOpen', array(
     'name' => __( "Time open Thursday", "apc" ),
    'std' => '08:00' 
), true );
$Conditinal_fields[] = $options_panel->addTime( 'thursdayClose', array(
     'name' => __( "Time close Thursday", "apc" ),
    'std' => '17:00' 
), true );


$Conditinal_fields[] = $options_panel->addTime( 'fridayOpen', array(
     'name' => __( "Time open Friday", "apc" ),
    'std' => '08:00' 
), true );
$Conditinal_fields[] = $options_panel->addTime( 'fridayClose', array(
     'name' => __( "Time close Friday", "apc" ),
    'std' => '17:00' 
), true );


$Conditinal_fields[] = $options_panel->addTime( 'saturdayOpen', array(
     'name' => __( "Time open Saturday", "apc" ),
    'std' => '09:00' 
), true );
$Conditinal_fields[] = $options_panel->addTime( 'saturdayClose', array(
     'name' => __( "Time close Saturday", "apc" ),
    'std' => '17:00' 
), true );


$Conditinal_fields[] = $options_panel->addTime( 'sundayOpen', array(
     'name' => __( "Time open Sunday", "apc" ) 
), true );
$Conditinal_fields[] = $options_panel->addTime( 'sundayClose', array(
     'name' => __( "Time close Sunday", "apc" ) 
), true );

/**
 * Then just add the fields to the repeater block
 */
//conditinal block 
$options_panel->addCondition( 'openingHours', array(
     'name' => __( 'Enable Times open? ', 'apc' ),
    'desc' => __( '<small>Turn ON if you want to enable the <strong>Time open for each day of the week</strong>.</small>', 'apc' ),
    'fields' => $Conditinal_fields,
    'std' => false 
) );

/**
 * Close tab
 */
$options_panel->CloseTab();


/**
 * Open admin page 5th tab
 */
$options_panel->OpenTab( 'options_5' );
$options_panel->Title( __( "Sitelinks Search Box", "apc" ) );

$options_panel->addCheckBoxList(
    'junk',
    array('op1'=>"Op1",'op2'=>"Op2")
);

// $options_panel->addCode('code',array('name'=> __('Code Editor ','apc'),'syntax' => 'php', 'desc' => __('code editor field description','apc')));
$options_panel->addCode( 'target', array(
     'name' => 'Company Custom Search',
    'syntax' => 'php',
    'std' => 'https://example.com/?s={search_term_string}',
    'desc' => 'See <a href="https://developers.google.com/structured-data/slsb-overview" target="_blank">https://developers.google.com/structured-data/slsb-overview</a> for additional information.' 
) );

/**
 * Close 5th tab
 */
$options_panel->CloseTab();

//Search
$options_panel->OpenTab( 'options_6' );

$data = get_option( 'kg_options' );

//assemble the physical postal address
$addr  = array(
     "@type" => "PostalAddress",
    "streetAddress" => $data[ 'streetAddress' ],
    "addressLocality" => $data[ 'addressLocality' ],
    "addressRegion" => $data[ 'addressRegion' ],
    "postalCode" => $data[ 'postalCode' ],
    "addressCountry" => $country_2to3[ $data[ 'addressCountry' ] ] 
);
/**

Start forming the main data structure.  Other
optional parts will be formed and merged later.

*/
$data2 = array(
     "@context" => $data[ '@context' ],
    "@type" => $data[ '@type' ],
    'name' => $data[ 'name' ],
    "address" => $addr 
);

$data2 = my_array_merge( $data2, "email", $data[ 'email' ] );
$data2 = my_array_merge( $data2, "logo", $data[ 'logo' ][ 'src' ] );
$data2 = my_array_merge( $data2, "description", $data[ 'description' ] );

//add main phone?
if ( $data[ 'telephone_show' ] ) {
    $data2 = my_array_merge( $data2, "telephone", $data[ 'telephone' ] );
} //$data[ 'telephone_show' ]
// Opening Hours, hours of operation 
if ( isset( $data[ 'openingHours' ][ 'enabled' ] ) ) {
    $hours = array( );
    foreach ( array(
         "Mo",
        "Tu",
        "We",
        "Th",
        "Fr",
        "Sa",
        "Su" 
    ) as $day ) {
        $day_long     = $days[ $day ];
        $id_1         = strtolower( $day_long ) . 'Open';
        $id_2         = strtolower( $day_long ) . 'Close';
        $opening_time = $data[ 'openingHours' ][ $id_1 ];
        $closing_time = $data[ 'openingHours' ][ $id_2 ];
        if ( empty( $opening_time ) && empty( $closing_time ) ) {
            $get_hours = NULL;
        } //empty( $opening_time ) && empty( $closing_time )
        else {
            $get_hours = "$day $opening_time-$closing_time";
        }
        if ( !is_null( $get_hours ) ) {
            $hours[] = $get_hours;
        } //!is_null( $get_hours )
    } //foreach short day abbrev 
    
    $data2 = my_array_merge( $data2, "openingHours", $hours );
} //if opening hours is set


// There had better be a "url" => $data['url'], or else, what's the point!
$data2 = my_array_merge( $data2, "url", $data[ 'url' ] );

// sameAs links pointing to other organizational profiles
$alinks = $data[ "sameAs" ];
if ( !empty( $alinks ) ) {
    $links = array( );
    foreach ( $alinks as $alink ) {
        $links[] = $alink[ "li" ];
    } //$alinks as $alink
    $data2 = my_array_merge( $data2, "sameAs", $links );
} //if ( !empty ( $alinks ) )

//Points of Contact, e.g.,
$contact_points = $data[ 'ContactPoints' ];
$contact_point  = array( );
for ( $i = 0; $i < count( $contact_points ); $i++ ) {
    $contact = array(
         "@type" => "ContactPoint" 
    );
    $contact = array_merge( $contact, array(
         "contactType" => $contact_points[ $i ][ "contactType" ] 
    ) );
    $contact = my_array_merge( $contact, "telephone", $contact_points[ $i ][ "telephone" ] );
    $options = array( );
    if ( isset( $contact_points[ $i ][ "TollFree" ] ) ) {
        $options[] = "TollFree";
    } //isset( $contact_points[ $i ][ "TollFree" ] )
    if ( isset( $contact_points[ $i ][ "HearingImpairedSupported" ] ) ) {
        $options[] = "HearingImpairedSupported";
    } //isset( $contact_points[ $i ][ "HearingImpairedSupported" ] )
    $contact       = my_array_merge( $contact, "contactOption", $options );
    $contact       = my_array_merge( $contact, "areaServed", str_getcsv( $contact_points[ $i ][ "areaServed" ] ) );
    $contact       = my_array_merge( $contact, "availableLanguage", str_getcsv( $contact_points[ $i ][ "availableLanguage" ] ) );
    $contact_point = array_merge( $contact_point, array(
         $contact 
    ) );
} //$i = 0; $i < count( $contact_points ); $i++

$data2 = my_array_merge( $data2, "contactPoint", $contact_point );

$json_view_data[] = $options_panel->addParagraph( '<pre><code>' . json_format( json_encode( $data ) ) . '</code></pre>', true );
$options_panel->addCondition( 'json_data', array(
     'name' => __( 'Show current data in JSON format?', 'apc' ),
    'desc' => __( '<small>Current entered data in JSON format</small>', 'apc' ),
    'fields' => $json_view_data,
    'std' => false 
) );

$json_view_data2[] = $options_panel->addParagraph( '<pre>' . json_format( json_encode( $data2 ) ) . '</pre>', true );
$options_panel->addCondition( 'json_data2', array(
     'name' => __( 'Show generated data in JSON format?', 'apc' ),
    'desc' => __( '<small>Select, copy, paste below and edit as needed.<br/>The opening and closing script tags will be added.</small>', 'apc' ),
    'fields' => $json_view_data2,
    'std' => false 
) );

$options_panel->addCode( 'the_script', array(
     'name' => __( 'This is what will be included in the HEAD section of this site!', 'apc' ),
    'std' => json_format( json_encode( $data2 ) ),
    'syntax' => 'javascript',
    'desc' => 'Test the above at <a href="https://developers.google.com/structured-data/testing-tool/" target="_blank">https://developers.google.com/structured-data/testing-tool/</a>' 
) );

//checkbox field
$options_panel->addCheckbox( 'write_file', array(
     'name' => __( 'Use the above code? ', 'apc' ),
    'std' => false,
    'desc' => __( 'Check to use the above on this website!', 'apc' ) 
) );

if ( $data[ "write_file" ] ) {
    /**
     * Write the edited script ('the_script') to a file, that will then be read 
     * back end and included in the <head/>.
     *
     */
    $jsonFile = MYPLUGIN_PLUGIN_DIR . "/knowledge-graph.json";
    $fh       = fopen( $jsonFile, 'w' );
    //header('Content-type: application/ld+json');
    
    $str = '<script type="application/ld+json">' . PHP_EOL;
    
    //$str .= json_encode( $data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ).PHP_EOL;
    $str .= $data[ 'the_script' ];
    $str .= '</script>' . PHP_EOL;
    fwrite( $fh, $str );
    
    function kg_header( ) {
        $jsonFile = MYPLUGIN_PLUGIN_DIR . "/knowledge-graph.json";
        $fh       = fopen( "knowledge-graph.json", 'r' );
        $json     = fread( $fh, filesize( $jsonFile ) );
        echo $json . PHP_EOL;
    }
    
    add_action( 'wp_head', 'kg_header' );
} //$data[ "write_file" ]
/**
 * Close 6th tab
 */
$options_panel->CloseTab();

/**
 * Open admin page 7th tab
 */
$options_panel->OpenTab( 'options_7' );

//title
$options_panel->Title( __( "Import Export", "apc" ) );

/**
 * add import export functionallty
 */
$options_panel->addImportExport();

/**
 * Close 7th tab
 */
$options_panel->CloseTab();

?>