<?php
defined('FACEDETECTOR_PATH') or die('Hacking attempt!');

global $page, $template, $conf, $user, $tokens, $pwg_loaded_plugins;


# DO SOME STUFF HERE... or not !


$template->assign(array(
  // this is useful when having big blocks of text which must be translated
  // prefer separated HTML files over big lang.php files
  'INTRO_CONTENT' => load_language('intro.html', FACEDETECTOR_PATH, array('return'=>true)),
  'FACEDETECTOR_PATH' => FACEDETECTOR_PATH,
  'FACEDETECTOR_ABS_PATH' => realpath(FACEDETECTOR_PATH).'/',
  ));

$template->set_filename('faceDetector_page', realpath(FACEDETECTOR_PATH . 'template/faceDetector_page.tpl'));
$template->assign_var_from_handle('CONTENT', 'faceDetector_page');
