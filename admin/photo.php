<?php
defined('FACEDETECTOR_PATH') or die('Hacking attempt!');

// +-----------------------------------------------------------------------+
// | Photo[faceDetector] tab                                                   |
// +-----------------------------------------------------------------------+

$page['active_menu'] = get_active_menu('photo'); // force oppening "Photos" menu block

/* Basic checks */
check_status(ACCESS_ADMINISTRATOR);

check_input_parameter('image_id', $_GET, false, PATTERN_ID);

$admin_photo_base_url = get_root_url()  .'admin.php?page=photo-'.$_GET['image_id'];
$self_url = FACEDETECTOR_ADMIN . '-photo&amp;image_id=' . $_GET['image_id'];


/* Tabs */
// when adding a tab to an existing tabsheet you MUST reproduce the core tabsheet code
// this way it will not break compatibility with other plugins and with core functions
include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');
$tabsheet = new tabsheet();
$tabsheet->set_id('photo'); // <= don't forget tabsheet id
$tabsheet->select('faceDetector');
$tabsheet->assign();


/* Initialisation */
$query = 'SELECT * FROM ' . IMAGES_TABLE . ' WHERE id = ' . $_GET['image_id'] . ';';
$picture = pwg_db_fetch_assoc(pwg_query($query));


$foobar = "";

# DO SOME STUFF HERE... or not !
if(isset($_POST['detect_faces']))
{
  $foobar = shell_exec('face_detection ' . $picture['path']);
}

/* Template */
$template->assign(array(
  'DEBUG_MSG' => $foobar,
  'F_ACTION' => $self_url,
  'faceDetector' => $conf['faceDetector'],
  'TITLE' => render_element_name($picture),
  'SRC_IMG' => DerivativeImage::url(IMG_LARGE, $picture),
));

$template->set_filename('faceDetector_content', realpath(FACEDETECTOR_PATH . 'admin/template/photo.tpl'));
