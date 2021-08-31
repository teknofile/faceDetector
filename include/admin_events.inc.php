<?php
defined('FACEDETECTOR_PATH') or die('Hacking attempt!');

/**
 * admin plugins menu link
 */
function faceDetector_admin_plugin_menu_links($menu)
{
  $menu[] = array(
    'NAME' => l10n('faceDetector'),
    'URL' => FACE_DETECTOR_ADMIN,
    );

  return $menu;
}

/**
 * add a tab on photo properties page
 */
function faceDetector_tabsheet_before_select($sheets, $id)
{
  if ($id == 'photo')
  {
    $sheets['faceDetector'] = array(
      'caption' => l10n('faceDetector'),
      'url' => FACEDETECTOR_ADMIN.'-photo&amp;image_id='.$_GET['image_id'],
      );
  }

  return $sheets;
}

/**
 * add a prefilter to the Batch Downloader
 */
function faceDetector_add_batch_manager_prefilters($prefilters)
{
  $prefilters[] = array(
    'ID' => 'faceDetector',
    'NAME' => l10n('faceDetector'),
    );

  return $prefilters;
}

/**
 * perform added prefilter
 */
function faceDetector_perform_batch_manager_prefilters($filter_sets, $prefilter)
{
  if ($prefilter == 'faceDetector')
  {
    $query = '
SELECT id
  FROM '.IMAGES_TABLE.'
  ORDER BY RAND()
  LIMIT 20
;';
    $filter_sets[] = query2array($query, null, 'id');
  }

  return $filter_sets;
}

/**
 * add an action to the Batch Manager
 */
function faceDetector_loc_end_element_set_global()
{
  global $template;

  /*
    CONTENT is optional
    for big contents it is advised to use a template file

    $template->set_filename('faceDetector_batchmanager_action', realpath(FACEDETECTOR_PATH.'template/batchmanager_action.tpl'));
    $content = $template->parse('faceDetector_batchmanager_action', true);
   */
  $template->append('element_set_global_plugins_actions', array(
    'ID' => 'faceDetector',
    'NAME' => l10n('faceDetector'),
    'CONTENT' => '<label><input type="checkbox" name="check_faceDetector"> '.l10n('Check me!').'</label>',
    ));
}

/**
 * perform added action
 */
function faceDetector_element_set_global_action($action, $collection)
{
  global $page;

  if ($action == 'faceDetector')
  {
    if (empty($_POST['check_faceDetector']))
    {
      $page['warnings'][] = l10n('Nothing appened, but you didn\'t check the box!');
    }
    else
    {
      $page['infos'][] = l10n('Nothing appened, but you checked the box!');
    }
  }
}
