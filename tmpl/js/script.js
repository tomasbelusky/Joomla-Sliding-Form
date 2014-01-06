/**
 * @package Module Sliding Form for Joomla!
 * @version 1.0
 * @author Tomáš Beluský
 * @copyright (C) 2014 Tomáš Beluský
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

var prefix = 'MOD_SLIDING_FORM_';
$j = jQuery.noConflict();

jQuery(document).ready(function() {
  $j(".showHideForm").click(function() { // toggle form
    $j("#slideBox").slideToggle("slow");
  });

  $j("#contactForm :input").each(function() { // manage all inputs in form
    if($j(this).attr('type') == 'submit') {
      return;
    }

    var name = $j(this).attr('name');
    var id = name + '-sliding';
    $j(this).attr('id', id);

    var hide = 'showError(true, $j("#' + id + '"))';
    $j(this).attr('onkeydown', hide);
    $j(this).attr('onfocus', hide);

    var label = Joomla.JText._(prefix + name.toUpperCase());
    $j(this).attr('placeholder', label);
  });
});

/**
 * Show error according to condition
 *  @param condition: tested condition
 *  @param field: field to mark/unmark
 *  @return condition's value
 */
function showError(condition, field) {
  if(condition) {
    $j(field).css({"border-color": "white"});
  }
  else {
    $j(field).css({"border-color": "red"});
  }

  return condition;
}

/**
 * Check if field's value is empty
 *  @param field: field to check
 *  @return if field's value is empty
 */
function checkField(field) {
  return showError(field.val().trim() !== '', field);
}

/**
 * Check if field's value has right pattern
 *  @param field: field to check
 *  @param testing: testing regular expression
 *  @return if field's value match pattern
 */
function checkFieldPattern(field, testing) {
  return showError(testing.test(field.val().trim()), field);
}

/**
 * Check form
 *  @param formId: form's id to check
 *  @return if form has correct values or not
 */
function checkForm(formId) {
  var value = 1;
  var patterns = {
    'sender' : '^[^@]+@[^@]+\.[a-z]{2,}$'
  };

  $j("#" + formId + " :input").each(function() { // check all input elements
    if($j(this).attr('type') == 'submit') {
      return;
    }

    var name = $j(this).attr('name')
    var actual = 1;

    if(typeof $j(this).attr('required') != "undefined") { // check for emptiness
      actual = checkField($j(this));
    }

    value &= actual;

    if(actual && name in patterns) { // check pattern of element
      value &= checkFieldPattern($j(this), new RegExp(patterns[name]));
    }
  });

  return value;
}

/**
 * Send email
 *  @param formId: form's id to send
 *  @return if form was send or not
 */
function sendMail(formId) {
  if(!checkForm(formId)) {
    return false;
  }

  return true;
}
