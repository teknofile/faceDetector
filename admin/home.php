<?php
defined('FACEDETECTOR_PATH') or die('Hacking attempt!');

// +-----------------------------------------------------------------------+
// | Home tab                                                              |
// +-----------------------------------------------------------------------+

// send variables to template
$template->assign(array(
  'faceDetector' => $conf['faceDetector'],
  'INTRO_CONTENT' => load_language('intro.html', FACEDETECTOR_PATH, array('return'=>true)),
  ));

// define template file
$template->set_filename('FACEDETECTOR_PATH_content', realpath(FACEDETECTOR_PATH . 'admin/template/home.tpl'));
