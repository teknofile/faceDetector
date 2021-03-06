<?php
defined('FACEDETECTOR_PATH') or die('Hacking attempt!');

// +-----------------------------------------------------------------------+
// | Configuration tab                                                     |
// +-----------------------------------------------------------------------+

// save config
if (isset($_POST['save_config']))
{
  $conf['faceDetector'] = array(
    'option1' => intval($_POST['option1']),
    'option2' => isset($_POST['option2']),
    'option3' => $_POST['option3'],
    );

  conf_update_param('faceDetector', $conf['faceDetector']);
  $page['infos'][] = l10n('Information data registered in database');
}

$select_options = array(
  'one' => l10n('One'),
  'two' => l10n('Two'),
  'three' => l10n('Three'),
  );

// send config to template
$template->assign(array(
  'faceDetector' => $conf['faceDetector'],
  'select_options' => $select_options
  ));

// define template file
$template->set_filename('faceDetector_content', realpath(FACEDETECTOR_PATH . 'admin/template/config.tpl'));
