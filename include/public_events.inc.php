<?php
defined('FACEDETECTOR_PATH') or die('Hacking attempt!');

/**
 * detect current section
 */
function faceDetector_loc_end_section_init()
{
  global $tokens, $page, $conf;

  if ($tokens[0] == 'faceDetector')
  {
    $page['section'] = 'faceDetector';

    // section_title is for breadcrumb, title is for page <title>
    $page['section_title'] = '<a href="'.get_absolute_root_url().'">'.l10n('Home').'</a>'.$conf['level_separator'].'<a href="'.FACEDETECTOR_PUBLIC.'">'.l10n('faceDetector').'</a>';
    $page['title'] = l10n('faceDetector');

    $page['body_id'] = 'thefaceDetectorPage';
    $page['is_external'] = true; // inform Piwigo that you are on a new page
  }
}

/**
 * include public page
 */
function faceDetector_loc_end_page()
{
  global $page, $template;

  if (isset($page['section']) and $page['section']=='faceDetector')
  {
    include(FACEDETECTOR_PATH . 'include/faceDetector_page.inc.php');
  }
}

/*
 * button on album and photos pages
 */
function faceDetector_add_button()
{
  global $template;

  $template->assign('FACEDETECTOR_PATH', FACEDETECTOR_PATH);
  $template->set_filename('faceDetector_button', realpath(FACEDETECTOR_PATH.'template/my_button.tpl'));
  $button = $template->parse('faceDetector_button', true);

  if (script_basename()=='index')
  {
    $template->add_index_button($button, BUTTONS_RANK_NEUTRAL);
  }
  else
  {
    $template->add_picture_button($button, BUTTONS_RANK_NEUTRAL);
  }
}

/**
 * add a prefilter on photo page
 */
function faceDetector_loc_end_picture()
{
  global $template;

  $template->set_prefilter('picture', 'faceDetector_picture_prefilter');
}

function faceDetector_picture_prefilter($content)
{
  $search = '{if $display_info.author and isset($INFO_AUTHOR)}';
  $replace = '
<div id="faceDetector" class="imageInfo">
  <dt>{\'faceDetector\'|@translate}</dt>
  <dd style="color:orange;">{\'Piwigo rocks\'|@translate}</dd>
</div>
';

  return str_replace($search, $replace.$search, $content);
}
