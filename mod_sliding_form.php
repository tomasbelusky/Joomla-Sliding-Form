<?php
  /**
   * @package Module Sliding Form for Joomla!
   * @version 1.0
   * @author Tomáš Beluský
   * @copyright (C) 2014 Tomáš Beluský
   * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
   */

  defined('_JEXEC') or die;

  require_once(dirname(__FILE__).'/helper.php');
  JHtml::stylesheet(Juri::base() . 'modules/mod_sliding_form/tmpl/css/style.css');

  if(version_compare(JVERSION,'3.0','ge')) {
    JHtml::_('jquery.framework');  
  }
  else {
    JHtml::script('http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
  }

  JHtml::script(Juri::base() . 'modules/mod_sliding_form/tmpl/js/script.js');

  if(isset($_POST['sendEmail'])) {
    modSlidingFormHelper::sendEmail($_POST, $params);
  }

  require(JModuleHelper::getLayoutPath('mod_sliding_form'));
?>
