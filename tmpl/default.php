<?php
  /**
   * @package Module Sliding Form for Joomla!
   * @version 1.0
   * @author Tomáš Beluský
   * @copyright (C) 2014 Tomáš Beluský
   * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
   */

  defined('_JEXEC') or die;

  JText::script('MOD_SLIDING_FORM_NAME');
  JText::script('MOD_SLIDING_FORM_SENDER');
  JText::script('MOD_SLIDING_FORM_SENDER_PATTERN');
  JText::script('MOD_SLIDING_FORM_SUBJECT');
  JText::script('MOD_SLIDING_FORM_MESSAGE');

  $button = '
    <input type="submit"
           class="showHideForm"
           name="sendEmail"
           value="' . $params->get('text') . '" />';
  $borderRadius = $params->get('border-radius');
  $borderRadiusPosition = $params->get('vertical') == "top" ? "bottom" : "top";
?>
<div id="slidingForm" style="<?php echo 'width:'.$params->get('width').'px;'.
                                         $params->get('vertical').':0;'.
                                         $params->get('horizontal').':3px;
                                         color:'.$params->get('font-color').';
                                         background-color:'.$params->get('background-color').';
                                         border-'.$borderRadiusPosition.'-left-radius: '.$borderRadius.'px '.$borderRadius.'px;
                                         border-'.$borderRadiusPosition.'-right-radius: '.$borderRadius.'px '.$borderRadius.'px;' ?>">
  <?php if($params->get('vertical') == 'bottom') echo $button; ?>
  <div id="slideBox">
    <form id="contactForm" action="" method="post">
      <table>
        <?php if($params->get('name_field') != 'no') { ?>
          <tr>
            <td>
              <input type="text"
                     name="name"
                     value=""
                     <?php echo $params->get('name_field') == 'require' ? 'required' : '' ?> />
            </td>
          </tr>
        <?php } ?>
        <tr>
          <td>
            <input type="text" name="sender" value="" required />
          </td>
        </tr>
        <?php if($params->get('subject_field') != 'no') { ?>
          <tr>
            <td>
              <input type="text"
                     name="subject"
                     value=""
                     <?php echo $params->get('subject_field') == 'require' ? 'required' : '' ?> />
            </td>
          </tr>
        <?php } ?>
        <tr>
          <td>
            <textarea name="message" required></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <input type="submit"
                   name="sendEmail"
                   value="<?php echo JText::_('MOD_SLIDING_FORM_SEND'); ?>"
                   formnovalidate
                   onclick="return sendMail('contactForm');" />
          </td>
        </tr>
      </table>
    </form>
  </div>
  <?php if($params->get('vertical') == 'top') echo $button; ?>
</div>
