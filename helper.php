<?php
  /**
   * @package Module Sliding Form for Joomla!
   * @version 1.0
   * @author Tomáš Beluský
   * @copyright	(C) 2014 Tomáš Beluský
   * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
   */

  defined('_JEXEC') or die;

  /**
   * Helper for sliding form
   */
  class modSlidingFormHelper {
    /**
     * Array with required field's pattern
     */
    private static $PATTERNS = array(
      'email' => '^[^@]+@[^@]+\.[a-z]{2,}$'
    );

    /**
     * Clean text
     *  @param text: text to clean
     *  @return cleaned text
     */
    public static function cleanText($text) {
      return strip_tags(htmlspecialchars($text));
    }

    /**
     * Check if key is set
     *  @param key: key to be checked
     *  @param array: array
     *  @return if key is set and match pattern
     */
    public static function isKeySet($key, $array) {
      return array_key_exists($key, $array) &&
             !empty($array[$key]) &&
             (!array_key_exists($key, modSlidingFormHelper::$PATTERNS) ||
              preg_match(modSlidingFormHelper::$PATTERNS[$key], $array[$key]));
    }

    /**
     * Send email
     *  @param args: form arguments
     *  @param params: module parameters
     */
    public static function sendEmail($args, $params) {
      foreach($args as $i => $arg) { // clean args
        $args[$i] = modSlidingFormHelper::cleanText($arg);
      }

      $fields = array( // field with default value
        'name' => $args['sender'],
        'sender' => $args['sender'],
        'subject' => $params->get('default_subject'),
        'message' => $args['message'],
      );

      foreach($fields as $field => $default) { // check fields
        if(modSlidingFormHelper::isKeySet($field, $args)) { // field is set
          $fields[$field] = $args[$field];
        }
        else if($params->get("${field}_field") == "require") { // field is required
          return;
        }
      }

      extract($fields);
      $mailer = JFactory::getMailer();
      $mailer->addRecipient($params->get('email'));
      $mailer->setSender(array($args['sender'], $name));
      $mailer->setSubject($subject);
      $mailer->setBody("${args['message']}\n\n--\n" . JText::_('MOD_SLIDING_FORM_MESSAGE_SIGNATURE') . " http://" . $_SERVER['HTTP_HOST']);

      if($mailer->Send() === true) { // redirect on success
        header("Location: " . JURI::current());
      }
    }
  }
?>
