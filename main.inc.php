<?php
/*
Plugin Name: faceDetector
Version: auto
Description: This is a plugin to detect faces within an image
Plugin URI: auto
Author: teknofile
Author URI: https://www.teknofile.space/
*/

/**
 * This is the main file of the plugin, called by Piwigo in "include/common.inc.php" line 137.
 * At this point of the code, Piwigo is not completely initialized, so nothing should be done directly
 * except define constants and event handlers (see http://piwigo.org/doc/doku.php?id=dev:plugins)
 */

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');


if (basename(dirname(__FILE__)) != 'faceDetector')
{
  add_event_handler('init', 'faceDetector_error');
  function faceDetector_error()
  {
    global $page;
    $page['errors'][] = 'faceDetector folder name is incorrect, uninstall the plugin and rename it to "faceDetector"';
  }
  return;
}


// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+
global $prefixeTable;

define('FACEDETECTOR_ID',      basename(dirname(__FILE__)));
define('FACEDETECTOR_PATH' ,   PHPWG_PLUGINS_PATH . FACEDETECTOR_ID . '/');
define('FACEDETECTOR_TABLE',   $prefixeTable . 'faceDetector');
define('FACEDETECTOR_ADMIN',   get_root_url() . 'admin.php?page=plugin-' . FACEDETECTOR_ID);
define('FACEDETECTOR_PUBLIC',  get_absolute_root_url() . make_index_url(array('section' => 'faceDetector')) . '/');
define('FACEDETECTOR_DIR',     PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'faceDetector/');



// +-----------------------------------------------------------------------+
// | Add event handlers                                                    |
// +-----------------------------------------------------------------------+
// init the plugin
add_event_handler('init', 'faceDetector_init');

/*
 * this is the common way to define event functions: create a new function for each event you want to handle
 */
if (defined('IN_ADMIN'))
{
  // file containing all admin handlers functions
  $admin_file = FACEDETECTOR_PATH . 'include/admin_events.inc.php';

  // admin plugins menu link
  add_event_handler('get_admin_plugin_menu_links', 'faceDetector_admin_plugin_menu_links',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  // new tab on photo page
  add_event_handler('tabsheet_before_select', 'faceDetector_tabsheet_before_select',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  // new prefiler in Batch Manager
  add_event_handler('get_batch_manager_prefilters', 'faceDetector_add_batch_manager_prefilters',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
  add_event_handler('perform_batch_manager_prefilters', 'faceDetector_perform_batch_manager_prefilters',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  // new action in Batch Manager
  add_event_handler('loc_end_element_set_global', 'faceDetector_loc_end_element_set_global',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
  add_event_handler('element_set_global_action', 'faceDetector_element_set_global_action',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
}
else
{
  // file containing all public handlers functions
  $public_file = FACEDETECTOR_PATH . 'include/public_events.inc.php';

  // add a public section
  add_event_handler('loc_end_section_init', 'faceDetector_loc_end_section_init',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
  add_event_handler('loc_end_index', 'faceDetector_loc_end_page',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);

  // add button on album and photos pages
  add_event_handler('loc_end_index', 'faceDetector_add_button',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
  add_event_handler('loc_end_picture', 'faceDetector_add_button',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);

  // prefilter on photo page
  add_event_handler('loc_end_picture', 'faceDetector_loc_end_picture',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
}

// file containing API function
$ws_file = FACEDETECTOR_PATH . 'include/ws_functions.inc.php';

// add API function
add_event_handler('ws_add_methods', 'faceDetector_ws_add_methods',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);


/*
 * event functions can also be wrapped in a class
 */

// file containing the class for menu handlers functions
$menu_file = FACEDETECTOR_PATH . 'include/menu_events.class.php';

// add item to existing menu (EVENT_HANDLER_PRIORITY_NEUTRAL+10 is for compatibility with Advanced Menu Manager plugin)
add_event_handler('blockmanager_apply', array('faceDetectorMenu', 'blockmanager_apply1'),
  EVENT_HANDLER_PRIORITY_NEUTRAL+10, $menu_file);

// add a new menu block (the declaration must be done every time, in order to be able to manage the menu block in "Menus" screen and Advanced Menu Manager)
add_event_handler('blockmanager_register_blocks', array('faceDetectorMenu', 'blockmanager_register_blocks'),
  EVENT_HANDLER_PRIORITY_NEUTRAL, $menu_file);
add_event_handler('blockmanager_apply', array('faceDetectorMenu', 'blockmanager_apply2'),
  EVENT_HANDLER_PRIORITY_NEUTRAL, $menu_file);

// NOTE: blockmanager_apply1() and blockmanager_apply2() can (must) be merged


/**
 * plugin initialization
 *   - check for upgrades
 *   - unserialize configuration
 *   - load language
 */
function faceDetector_init()
{
  global $conf;

  // load plugin language file
  load_language('plugin.lang', FACEDETECTOR_PATH);

  // prepare plugin configuration
  $conf['faceDetector'] = safe_unserialize($conf['faceDetector']);
}
