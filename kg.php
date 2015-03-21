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

add_filter('plugin_action_links', 'myplugin_plugin_action_links', 10, 2);

function myplugin_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=options-general.php_knowledge_graph">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}

$country_names = json_decode(
    file_get_contents(MYPLUGIN_PLUGIN_DIR."/lib/names.json")
, true);

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

$options_panel->addText( 'kg_addressCountry_field_id', array(
  'name' => __( 'Country', 'apc' ),
  'std' => 'USA',
    'validate' => array(
        'alphanumeric' => array( 'param' => '', 'message' => __("Must be alpha numberic!", "apc"))
    )
) );

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
        'std'  => '+1-800-555-555',
        'desc' => __('Company main phone number', 'apc' )
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

/**
* Close 4th tab
*/
$options_panel->CloseTab();
/**
* Open admin page 5th tab
*/
$options_panel->OpenTab( 'options_5' );
$options_panel->Title(__( "Sitelinks Search Box", "apc" ));

$options_panel->addTextarea(
    'kg_search_field_id',
    array(
        'name' => 'Company Custom Search',
        'std'  => 'https://example.com/search?q={search_term_string}',
        'desc' => 'See <a href="https://developers.google.com/structured-data/slsb-overview" target="_blank">https://developers.google.com/structured-data/slsb-overview</a> for additional information.'
    )
);

/**
* Close 5th tab
*/
$options_panel->CloseTab();


//Search
$options_panel->OpenTab( 'options_6' );

$options_panel->addSelect(
    'kg_addressCountry_selected',
    $country_names,
    array( 'name' => __('Country', 'apc'),
          'std' => array('UNITED STATES'),
          'desc' => __('Choose your Country', 'apc')
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

$data = get_option('kg_options');

$options_panel->addParagraph(__($data['kg_company_name_field_id'],"apc"));
$options_panel->addParagraph(__($data['kg_addressCountry_selected'],"apc"));

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