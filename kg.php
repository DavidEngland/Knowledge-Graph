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
if (!defined('MYPLUGIN_THEME_DIR'))
    define('MYPLUGIN_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('MYPLUGIN_PLUGIN_NAME'))
    define('MYPLUGIN_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('MYPLUGIN_PLUGIN_DIR'))
    define('MYPLUGIN_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . MYPLUGIN_PLUGIN_NAME);

if (!defined('MYPLUGIN_PLUGIN_URL'))
    define('MYPLUGIN_PLUGIN_URL', WP_PLUGIN_URL . '/' . MYPLUGIN_PLUGIN_NAME);

if (!defined('MYPLUGIN_VERSION_KEY'))
    define('MYPLUGIN_VERSION_KEY', 'myplugin_version');

if (!defined('MYPLUGIN_VERSION_NUM'))
    define('MYPLUGIN_VERSION_NUM', '0.0.1');

add_option(MYPLUGIN_VERSION_KEY, MYPLUGIN_VERSION_NUM);

    //Add settings link on plugin page
add_filter('plugin_action_links', 'myplugin_plugin_action_links', 10, 2);

function myplugin_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=options-general.php_knowledge_graph">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}

$contact_types = array("sales", "customer support", "reservations", "credit card support", "emergency", "customer service", "technical support", "billing support", "bill payment", "baggage tracking", "roadside assistance", "package tracking");

foreach ( $contact_types as $contact_type ) {
    $contact_slug[] = str_replace( ' ', '-', $contact_type);
    $type_contact[$contact_type] = ucwords($contact_type);
}


//Read in Country names indexed by two letter codes (ISO-3166), from http://country.io
$country_names = json_decode( file_get_contents( MYPLUGIN_PLUGIN_DIR."/lib/names.json" ), true);

//Read in Country two letter to three letter mappings
$country_2to3 = json_decode( file_get_contents( MYPLUGIN_PLUGIN_DIR."/lib/iso3.json" ), true);

//Same for days of the week
$days = json_decode( file_get_contents( MYPLUGIN_PLUGIN_DIR."/lib/days.json" ), true);

//include the main class file
require_once( "admin-page-class/admin-page-class.php" );


/**
* admin page configuration
*/
$config = array(
  'menu'           => 'settings', //sub page to settings page
  'page_title'     => __( 'Knowledge Graph', 'apc' ), //The name of this page 
  'capability'     => 'edit_themes', // The capability needed to view the page 
  'option_group'   => 'kg_options', //the name of the option to create in the database
  'id'             => 'admin_page', // meta box id, unique per page
  'fields'         => array( ), // list of fields (can be added by field arrays)
  'local_images'   => false, // Use local or hosted images (meta box images for add/remove)
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
  'options_4a'=> __( 'Hours', 'apc' ),
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


$options_panel->addText( 'kg_company_name_field_id', array(
  'name' => __( 'Company Name', 'apc' ),
  'std' => get_bloginfo( 'name' ),
  'desc' => __( 'Legal Company name', 'apc' ) 
) 
					   );

//email with validation
$options_panel->addText('kg_email_field_id',
						array(
						  'name'     => __(' Main Email ','apc'),
						  'std'      => get_bloginfo( 'admin-email' ),
						  'desc'     => __("Enter a valid e-mail address.","apc"),
						  'validate' => array(
							'email' => array('param' => '','message' => __("Must be a valid email address!","apc"))
						  )
						)
					   );

$options_panel->addText( 'kg_streetAddress_field_id', array(
  'name' => __( 'Street', 'apc' ),
  'std' => '103 Elm',
        'validate' => array(
        'street' => array( 'param' => '', 'message' => __("Enter a valid Street please!", "apc"))
    )
) );

$options_panel->addText( 'kg_addressLocality_field_id', array(
  'name' => __( 'City', 'apc' ),
  'std' => 'City',
    'validate' => array(
        'alphanumeric' => array( 'param' => '', 'message' => __("Must be alpha numberic!", "apc"))
    )
) );

$options_panel->addText( 'kg_addressRegion_field_id', array(
  'name' => __( 'State', 'apc' ),
  'std' => 'AL',
    'validate' => array(
        'alphanumeric' => array( 'param' => '', 'message' => __("Must be alpha numberic!", "apc"))
    )
) );

$options_panel->addText( 'kg_postalCode_field_id', array(
  'name' => __( 'Postal Zip Code', 'apc' ),
  'std' => '12345',
    'validate' => array(
        'alphanumeric' => array( 'param' => '', 'message' => __("Must be alpha numberic!", "apc"))
    )
) );

$options_panel->addSelect(
    'kg_addressCountry_selected',
    $country_names,
    array( 'name' => __('Country', 'apc'),
          'std' => array('UNITED STATES'),
          'desc' => __('Choose your Country', 'apc')
         )
);

$options_panel->addTextarea( 'kg_company_desc_field_id', array(
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
$options_panel->addImage( 'kg_logo_field_id', array(
  'name' => __( 'Company Logo ', 'apc' ),
  'preview_height' => '150px',
  'preview_width' => '150px',
  'desc' => __( 'Company logo image', 'apc' ) 
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

  $options_panel->addText(
      'kg_url_field_id',
       array(
           'name'     => __(' Website ','apc'),
           'std'      => get_bloginfo( 'wpurl' ),
           'desc'     => __("URL of Company's main website","apc"),
           'validate' => array(
                         'url' => array('param' => '','message' => __("must be a valid URL","apc"))
                        )
        )
);

$repeater_fields[] = $options_panel->addText(
    're_links_field_id',
    array(
      'name'  => __('Enter a URL ','apc'),
        'std' => 'http://',
    'validate' => array('url' => array('param' => '','message' => __("must be a valid URL","apc")))
    ),true);

 $options_panel->addRepeaterBlock(
     're_',
     array(
         'name'   => __('Other Company profile links','apc'),
         'fields' => $repeater_fields,
         'desc'   => __('For Example:  http://www.facebook.com/CompanyName','apc')
 ));

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

$options_panel->addText( 
    'kg_main_phone',
    array (
        'name' => __('Main Telephone Number', 'apc'),
        'std'  => '+1(800) 555-5555',
        'desc' => __('Company main phone number', 'apc' ),
        'validate' => array(
            'phone' => array( 'param' => '', 'message' => __("Telephone Number does not validate!", "apc"))
    )
    )
);

$options_panel->addCheckbox(
    'kg_main_phone_show',
    array(
        'name' => __('Show main phone?', 'apc' ),
        'std' => true,
        'desc' => __('Inculde main phone or not', 'apc' )
    )
);

    $phone_options[] = $options_panel->addText(
     'phoneNumber',
        array(
            'name' => __( 'Phone Number', 'apc'),
            'validate' => array(
                  'phone' => array( 'param' => '', 'message' => __("Telephone Number does not validate!", "apc"))
            )
        ),true
    );
    
    $phone_options[] = $options_panel->addSelect(
        'phoneType',
         $type_contact,
        array(
            'name' => __( "Choose Type", "apc" )
        ),
        true
    );
                                
    $phone_options[] = $options_panel->addCheckbox(                      
       'tollFree',
        array(
            'name' => __( 'Toll Free?', 'apc' ),
            'std' => true
        ),true
    );
    
   $phone_options[] = $options_panel->addCheckbox(                      
      'hearing',
        array(
            'name' => __( 'Hearing Impaired?', 'apc' ),
            'std' => false
        ),true
    ); 

    $phone_options[] = $options_panel->addText(
        'lang',
        array(
            'name' => __( "Languages, comma seperated", 'apc'),
            'std' => "English, Spanish, German, French"
        ),
        true
    );
    
    $options_panel->addRepeaterBlock('ContactPoints',array('inline'=>true,'name'=>__("Contact Point",'apc'),'fields'=>$phone_options),true);       

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

$Conditinal_fields[] = $options_panel->addTime('mondayOpen',array('name'=>__("Hours open Monday","apc"),'std'=>'08:00'),true);
$Conditinal_fields[] = $options_panel->addTime('mondayClose',array('name'=>__("Hours close Monday","apc"),'std'=>'17:00'),true);


$Conditinal_fields[] = $options_panel->addTime('tuesdayOpen',array('name'=>__("Hours open Tuesday","apc"),'std'=>'08:00'),true);
$Conditinal_fields[] = $options_panel->addTime('tuesdayClose',array('name'=>__("Hours close Tuesday","apc"),'std'=>'17:00'),true);


$Conditinal_fields[] = $options_panel->addTime('wednesdayOpen',array('name'=>__("Hours open Wednesday","apc"),'std'=>'08:00'),true);
$Conditinal_fields[] = $options_panel->addTime('wednesdayClose',array('name'=>__("Hours close Wednesday","apc"),'std'=>'17:00'),true);


$Conditinal_fields[] = $options_panel->addTime('thursdayOpen',array('name'=>__("Hours open Thursday","apc"),'std'=>'08:00'),true);
$Conditinal_fields[] = $options_panel->addTime('thursdayClose',array('name'=>__("Hours close Thursday","apc"),'std'=>'17:00'),true);


$Conditinal_fields[] = $options_panel->addTime('fridayOpen',array('name'=>__("Hours open Friday","apc"),'std'=>'08:00'),true);
$Conditinal_fields[] = $options_panel->addTime('fridayClose',array('name'=>__("Hours close Friday","apc"),'std'=>'17:00'),true);


$Conditinal_fields[] = $options_panel->addTime('saturdayOpen',array('name'=>__("Hours open Saturday","apc"),'std'=>'09:00'),true);
$Conditinal_fields[] = $options_panel->addTime('saturdayClose',array('name'=>__("Hours close Saturday","apc"),'std'=>'17:00'),true);


$Conditinal_fields[] = $options_panel->addTime('sundayOpen',array('name'=>__("Hours open Sunday","apc")),true);
$Conditinal_fields[] = $options_panel->addTime('sundayClose',array('name'=>__("Hours close Sunday","apc")),true);

  /**
   * Then just add the fields to the repeater block
   */
  //conditinal block 
  $options_panel->addCondition('conditinal_fields',
      array(
        'name'   => __('Enable Times open? ','apc'),
        'desc'   => __('<small>Turn ON if you want to enable the <strong>Hours open for each day of the week</strong>.</small>','apc'),
        'fields' => $Conditinal_fields,
        'std'    => false
      ));

/**
* Close tab
*/
$options_panel->CloseTab();


/**
* Open admin page 5th tab
*/
$options_panel->OpenTab( 'options_5' );
$options_panel->Title(__( "Sitelinks Search Box", "apc" ));
// $options_panel->addCode('code_field_id',array('name'=> __('Code Editor ','apc'),'syntax' => 'php', 'desc' => __('code editor field description','apc')));
$options_panel->addCode(
    'search_field',
    array(
        'name' => 'Company Custom Search',
        'syntax' => 'php',
        'std'  => 'https://example.com/?s={search_term_string}',
        'desc' => 'See <a href="https://developers.google.com/structured-data/slsb-overview" target="_blank">https://developers.google.com/structured-data/slsb-overview</a> for additional information.'
    )
);

/**
* Close 5th tab
*/
$options_panel->CloseTab();

//Search
$options_panel->OpenTab( 'options_6' );

$data = get_option('kg_options');

$addr = array( 
             "@type" => "PostalAddress",
     "streetAddress" => $data['kg_streetAddress_field_id'],
   "addressLocality" => $data['kg_addressLocality_field_id'],
     "addressRegion" => $data['kg_addressRegion_field_id'],
        "postalCode" => $data['kg_postalCode_field_id'],
    "addressCountry" => $country_2to3[$data['kg_addressCountry_selected']]
);

$hours = array();
foreach ( array("Mo","Tu","We","Th","Fr","Sa","Su") as $day ) {
    $day_long = $days[$day];
    $id_1 = strtolower($day_long) . 'Open';
    $id_2 = strtolower($day_long) . 'Close';
    $opening_time = $data['conditinal_fields'][$id_1];
    $closing_time = $data['conditinal_fields'][$id_2];   
    if ( is_null($opening_time) && is_null($closing_time) )
       $get_hours = NULL;
    else
       $get_hours = "$day $opening_time-$closing_time";
    
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
         'name' => $data['kg_company_name_field_id'],
         'logo' => $data['kg_logo_field_id']['src'],
  "description" => $data['kg_company_desc_field_id'], 
      "address" => $addr,
 "openingHours" => $hours,
          "url" => $data['kg_url_field_id']   
);

//header('Content-type: application/ld+json');
    
    $str = '<script type="application/ld+json">'.PHP_EOL;

    //$str .= json_encode( $data2, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ).PHP_EOL;
    $str .= json_encode( $data2 );
    
    $str .= '</script>' . PHP_EOL;
$options_panel->addParagraph('<pre>'.$str.'</pre>');
$options_panel->addCode(
    'kg_the_script',
    array(
        'std' => $str,
        'syntax'=>'javascript'
    )
);

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

//Now Just for the fun I'll add Help tabs
$options_panel->HelpTab( array(
  'id' => 'tab_id',
  'title' => __( 'My help tab title', 'apc' ),
  'content' => '<p>' . __( 'This is my Help Tab content', 'apc' ) . '</p>' 
) );
$options_panel->HelpTab( array(
  'id' => 'tab_id2',
  'title' => __( 'My 2nd help tab title', 'apc' ),
  'callback' => 'help_tab_callback_demo' 
) );

//help tab callback function
function help_tab_callback_demo( ) {
  echo '<p>' . __( 'This is my 2nd Help Tab content from a callback function', 'apc' ) . '</p>';
}

?>