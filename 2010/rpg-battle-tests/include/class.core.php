<?php
/*
 * Project   : [PlutoCMS Version 2.2.0] <plutocms.plutolighthouse.net>
 * Name      : Core Class <class.core.php>
 * Author    : Adrian Marceau <Ageman20XX>
 * Created   : February 27th, 2010
 * Modified  : June 29th, 2011
 *
 * Description:
 * This is the Core Class for the PlutoCMS framework. This class
 * allows access to a huge library of CMS functions and tools,
 * including string, number, and array functions along with image
 * manipulation tools and tons more.
 */

// Define some STATUS MESSAGE constants for use within the class
define('PLUTOCMS_ERROR', 'error');
define('PLUTOCMS_SUCCESS', 'success');
define('PLUTOCMS_NOTICE', 'notice');
define('PLUTOCMS_WARNING', 'warning');
define('PLUTOCMS_LOADING', 'loading');
define('PLUTOCMS_ALERT', 'alert');
define('PLUTOCMS_DEFAULT', 'default');
define('PLUTOCMS_UNKNOWN', 'unknown');

// Define some IMAGE ALIGNMENT constants for use within the class
define('PLUTOCMS_ALIGN_TOP', 0);
define('PLUTOCMS_ALIGN_MIDDLE', 50);
define('PLUTOCMS_ALIGN_BOTTOM', 100);
define('PLUTOCMS_ALIGN_LEFT', 0);
define('PLUTOCMS_ALIGN_CENTER', 50);
define('PLUTOCMS_ALIGN_RIGHT', 100);

// Define some of the GEOGRAPHIC constants for use within the class
define('PLUTOCMS_NORTH', 'N');
define('PLUTOCMS_EAST', 'E');
define('PLUTOCMS_SOUTH', 'S');
define('PLUTOCMS_WEST', 'W');
define('PLUTOCMS_LATITUDE', 1);
define('PLUTOCMS_LONGITUDE', 2);

// Define the plutocms_core class
class plutocms_core {
	
  // Define the public variables
  public $NAME = 'PlutoCMS';
  public $VERSION = '2.2.0';
  public $CREATED =  1267250401;
  public $MODIFIED = 1294356006;
  public $LOCAL;
  public $TIMEZONE;
  public $DOMAIN;
  public $ROOTDIR;
  public $ROOTURL;
  public $ADMINDIR;
  public $ADMINURL;
  public $CONTENTDIR;
  public $CONTENTURL;
  public $INCLUDEDIR;
  public $INCLUDEURL;
  public $EXTENSIONDIR;
  public $EXTENSIONURL;
  public $MODULEDIR;
  public $MODULEURL;
  public $THEMEDIR;
  public $THEMEURL;
  public $LOGICDIR;
  public $LOGICURL;
  public $MESSAGES;
  public $FILETYPES;
  
  // Define the class constructor
  public function plutocms_core(){
    // Collect the initializer arguments
    $args = func_get_args();
    // If there is only one argument and it's an array
    if (!empty($args) && count($args) == 1 && is_array($args[0])){
      // Use the single config array for the core system variables
      $config = &$args[0];
      $this->LOCAL = isset($config['LOCAL']) ? $config['LOCAL'] : 'en_US.UTF8';
      $this->TIMEZONE = isset($config['TIMEZONE']) ? $config['TIMEZONE'] : 'Canada/Eastern';
      $this->DOMAIN = isset($config['DOMAIN']) ? $config['DOMAIN'] : 'localhost';
      $this->ROOTDIR = isset($config['ROOTDIR']) ? $config['ROOTDIR'] : '/localhost/public_html/';
      $this->ROOTURL = isset($config['ROOTURL']) ? $config['ROOTURL'] : 'http://localhost/';
      $this->ADMINDIR = isset($config['ADMINDIR']) ? $config['ADMINDIR'] : $this->ROOTDIR.'admin/';
      $this->ADMINURL = isset($config['ADMINURL']) ? $config['ADMINURL'] : $this->ROOTURL.'admin/';
      $this->CONTENTDIR = isset($config['CONTENTDIR']) ? $config['CONTENTDIR'] : $this->ROOTDIR.'content/';
      $this->CONTENTURL = isset($config['CONTENTURL']) ? $config['CONTENTURL'] : $this->ROOTURL.'content/';
      $this->INCLUDEDIR = isset($config['INCLUDEDIR']) ? $config['INCLUDEDIR'] : $this->ROOTDIR.'content/include/';
      $this->INCLUDEURL = isset($config['INCLUDEURL']) ? $config['INCLUDEURL'] : $this->ROOTURL.'content/include/';
      $this->EXTENSIONDIR = isset($config['EXTENSIONDIR']) ? $config['EXTENSIONDIR'] : $this->ROOTDIR.'content/extension/';
      $this->EXTENSIONURL = isset($config['EXTENSIONURL']) ? $config['EXTENSIONURL'] : $this->ROOTURL.'content/extension/';
      $this->MODULEDIR = isset($config['MODULEDIR']) ? $config['MODULEDIR'] : $this->ROOTDIR.'content/module/';
      $this->MODULEURL = isset($config['MODULEURL']) ? $config['MODULEURL'] : $this->ROOTURL.'content/module/';
      $this->THEMEDIR = isset($config['THEMEDIR']) ? $config['THEMEDIR'] : $this->ROOTDIR.'content/theme/';
      $this->THEMEURL = isset($config['THEMEURL']) ? $config['THEMEURL'] : $this->ROOTURL.'content/theme/';
      $this->LOGICDIR = isset($config['LOGICDIR']) ? $config['LOGICDIR'] : $this->ROOTDIR.'content/logic/';
      $this->LOGICURL = isset($config['LOGICURL']) ? $config['LOGICURL'] : $this->ROOTURL.'content/logic/';
    }
    // Otherwise, if no arguments were passed, assume defaults
    else {
      // Define the public core system default variable values one by one
      $this->LOCAL = 'en_US.UTF8';
      $this->TIMEZONE = 'Canada/Eastern';
      $this->DOMAIN = 'localhost';
      $this->ROOTDIR = '/localhost/public_html/';
      $this->ROOTURL = 'http://localhost/';
      $this->ADMINDIR = $this->ROOTDIR.'admin/';
      $this->ADMINURL = $this->ROOTURL.'admin/';
      $this->CONTENTDIR = $this->ROOTDIR.'content/';
      $this->CONTENTURL = $this->ROOTURL.'content/';
      $this->INCLUDEDIR = $this->ROOTDIR.'content/include/';
      $this->INCLUDEURL = $this->ROOTURL.'content/include/';
      $this->EXTENSIONDIR = $this->ROOTDIR.'content/extension/';
      $this->EXTENSIONURL = $this->ROOTURL.'content/extension/';
      $this->MODULEDIR = $this->ROOTDIR.'content/module/';
      $this->MODULEURL = $this->ROOTURL.'content/module/';
      $this->THEMEDIR = $this->ROOTDIR.'content/theme/';
      $this->THEMEURL = $this->ROOTURL.'content/theme/';
      $this->LOGICDIR = $this->ROOTDIR.'content/logic/';
      $this->LOGICURL = $this->ROOTURL.'content/logic/';
    }
    // Initialize the MESSAGES stack if there are any
    $this->MESSAGES = isset($_SESSION['PLUTOCMS']['MESSAGES']) ? $_SESSION['PLUTOCMS']['MESSAGES'] : array();
    // Initialize all the FILETYPES to be used in the script
    $this->filetypes(array(
      array('JPG', 'image/jpeg', 'jpg'),
      array('GIF', 'image/gif', 'gif'),
      array('PNG', 'image/png', 'png'),
      array('BMP', 'image/bmp', 'bmp'),
      array('TIFF', 'image/tiff', 'tiff'),
      array('ICO', 'image/x-icon', 'ico'),
      array('WBMP', 'image/vnd.wap.wbmp', 'wbmp'),
      array('JP2', 'image/jp2', 'jp2'),
      array('SWF', 'application/x-shockwave-flash', 'swf'),
      array('PSD', 'application/octet-stream', 'psd'),
      array('PDF', 'application/pdf', 'pdf'),
      array('DOC', 'application/msword', 'doc'),
      array('ZIP', 'application/zip', 'zip'),
      array('RAR', 'application/rar', 'rar'),
      array('AVI', 'video/x-msvideo', 'avi'),
      array('MOV', 'video/quicktime', 'mov'),
      array('MP4', 'video/mp4', 'mp4'),
      array('MPEG', 'video/mpeg', 'mpeg'),
      array('MPG', 'video/x-flv', 'mpg'),
      array('FLV', 'video/mpeg', 'flv'),
      array('MP3', 'audio/mp3', 'mp3'),
      array('WAV', 'audio/wav', 'wav'),
      array('OGG', 'application/ogg', 'ogg'),
      array('MID', 'audio/midi', 'mid'),
      array('MP2', 'audio/mpeg', 'mp2'),
      array('TXT', 'text/plain', 'txt'),
      array('TEXT', 'text/plain', 'text'),
      array('RTF', 'text/richtext', 'rtf'),
      array('HTML', 'text/html', 'html'),
      array('SHTML', 'text/html', 'shtml'),
      array('XML', 'text/xml', 'xml'),
      array('PHP', 'text/php', 'php'),
      array('CSS', 'text/css', 'css'),
      array('JS', 'text/javascript', 'js'),
      array('LOG', 'text/plain', 'log'),
      array('ASP', 'text/asp', 'asp'),
      array('XLS', 'application/vnd.ms-excel', 'xls'),
      array('UNKNOWN', 'unknown/not-supported', '')
      ));
  }
  
  /*
   * SHORTCUT FUNCTIONS /W DEFAULT PREFERENCES
   */
  
  // Define the shortcut function for encoding html entities
  public function htmlentity_encode($string, $encoding = ENT_QUOTES, $charset = 'UTF-8'){
    // Encode using UTF-8 and the ENT_QUOTES setting
    return htmlentities($string, $encoding, $charset);
  }
  // Define the shortcut function for decoding html entities
  public function htmlentity_decode($string, $encoding = ENT_QUOTES, $charset = 'UTF-8'){
    // Decode using UTF-8 and the ENT_QUOTES setting
    return html_entity_decode($string, $encoding, $charset);
  }
  // Define the shortcut function to padding numbers to 3 digits
  public function number_pad($number, $pad_length = 3, $pad_char = '0', $pad_direction = STR_PAD_LEFT){
    // Padd the number a default of three zeros to the left
    return str_pad($number, $pad_length, $pad_char, $pad_direction);
  }
  
  /*
   * STATUS MESSAGE FUNCTIONS
   */
  
  // Define some functions for creating/adding/collecting status messages to/from the stack
  public function message(){
    // Collect any arguments passed to the function
    $args = func_get_args();
    $args_count = is_array($args) ? count($args) : 0;
    // If there were no arguments provided, return the entire MESSAGE stack
    if (!$args_count){
      return $this->MESSAGES;
    }
    // Else if there was a single array provided, loop through collecting messages
    elseif ($args_count == 1 && is_array($args[0])){
      // Loop through each entry and add the item to the MESSAGE stack
      foreach ($args[0] AS $message){
        // Pull the details of the item
        $message['text'] = isset($message[0]) ? $message[0] : '';
        $message['type'] = isset($message[1]) ? $message[1] : PLUTOCMS_DEFAULT;
        // If the message text is empty, continue
        if (empty($message['text'])) { continue; }
        // Add this message to the end of the MESSAGE stack
        $this->MESSAGES[] = array('text' => $message['text'], 'type' => $message['type']);
        // Update the SESSION variable
        $_SESSION['PLUTOCMS']['MESSAGES'] = $this->MESSAGES;
      }
    }
    // Else if there are 1-3 arguments of string, string, and boolean types
    elseif ($args_count >= 1 && $args_count <= 3){
      // Pull the details of the item
      $message = array();
      $message['text'] = isset($args[0]) ? $args[0] : '';
      $message['type'] = isset($args[1]) ? $args[1] : PLUTOCMS_DEFAULT;
      // If the message text is empty, continue
      if (empty($message['text'])) { return false; }
      // Add this message to the end of the MESSAGE stack
      $this->MESSAGES[] = array('text' => $message['text'], 'type' => $message['type']);
      // Update the SESSION variable
      $_SESSION['PLUTOCMS']['MESSAGES'] = $this->MESSAGES;
    }
    // Otherwise, this is an invalid call and should return false
    else {
      $this->message("[[plutocms_core::message]] : An invalid set of arguments were passed.", PLUTOCMS_ERROR);
      return false;
    }
  }
  public function messages(){
    return $this->message();
  }
  // Define a function for pulling all status messages from the stack in a list format
  public function message_list($clear_stack = true, $list_id = 'messagestack', $item_class = 'message'){
    // Define the list container variable
    $message_list = '';
    // Define the opening tags for the message list
    $message_list .= "<ul id=\"{$list_id}\">\r\n";
    // Loop through each message and add it as a list item
    foreach ($this->MESSAGES AS $messageinfo){
      // Parse out quick-tags
      $messageinfo['text'] = $this->message_parse($messageinfo['text']);
      // Add a new list item for this message
      $message_list .= "<li class=\"{$item_class} status_{$messageinfo['type']}\">{$messageinfo['text']}</li>\r\n";
    }
    // Define the closing tags for the message list
    $message_list .= "</ul>\r\n";
    // If requested, clear the message stack
    if ($clear_stack){
      $_SESSION['PLUTOCMS']['MESSAGES'] = $this->MESSAGES = array();
    }
    // Return the completed list markup
    return $message_list;
  }
  // Define a function for pulling all status messages from the stack in JSON format
  public function message_json($clear_stack = true){
    // Define the container array variable
    $message_list = array();
    // Loop through each message and add it as an array element
    foreach ($this->MESSAGES AS $messageinfo){
      // Parse out quick-tags
      $messageinfo['text'] = $this->message_parse($messageinfo['text']);
      // Add a new array element for this message
      $message_list[] = array('type' => $messageinfo['type'], 'text' => $messageinfo['text']);
    }
    // Encode ythe entire message array as JSON
    $message_list = $this->json($message_list);
    // If requested, clear the message stack
    if ($clear_stack){
      $_SESSION['PLUTOCMS']['MESSAGES'] = $this->MESSAGES = array();
    }
    // Return the completed list array
    return $message_list;
  }
  // Define a function for parsing message quick text
  public function message_parse($message_text){
    // Parse out quick-tags
    $message_text = preg_replace('/\[\[(.*?)\]\]/i', '<strong>$1</strong>', $message_text);
    $message_text = preg_replace('/<<(.*?)>>/i', '<em>$1</em>', $message_text);
    $message_text = preg_replace('/\+\+(.*?)\+\+/i', '<span style="font-size:120%;">$1</span>', $message_text);
    $message_text = preg_replace('/--(.*?)--/i', '<span style="font-size:80%;">$1</span>', $message_text);
    // Return the result
    return $message_text;
  }
  // Define a function for attaching message stacks to the stackanchor (if one is defined)
  public function message_insert($message_stack, $content_body, $fallback = ''){
    // Ensure the $fallback variable is valid
    $fallback = !empty($fallback) && is_string($fallback) ? strtoupper($fallback) : 'PREPEND';
    if (!in_array($fallback, array('PREPEND', 'APPEND'))){ $fallback = 'PREPEND'; }
    // Define the pattern to match for the stack anchor and the final markup
    $stack_pattern = '#<span class="stackanchor">([^<>]*?)</span>#i';
    $stack_markup = '<span class="stackanchor"></span>';
    // Check if a stackanchor exists in the in the content_body
    if (preg_match($stack_pattern, $content_body)){
      // Replace all matches with the final markup, taking note of how MANY matches there were
      $replace_count = 0;
      $content_body = preg_replace($stack_pattern, $stack_markup, $content_body, -1, $replace_count);
      // Now replace all matches with nothing EXCEPT THE LAST
      $content_body = preg_replace($stack_pattern, '', $content_body, ($replace_count - 1));
      // Now replace the only exists match left with the stack anchor and messages
      $content_body = preg_replace($stack_pattern, $stack_markup."\r\n".$message_stack, $content_body);
    }
    // Otherwise, simply prepend/append the message stack to the content body
    elseif ($fallback == 'PREPEND'){
      $content_body = $message_stack."\r\n".$content_body;
    }
    elseif ($fallback == 'APPEND'){
      $content_body = $content_body."\r\n".$message_stack;
    }
    // And now return the new content_body
    return $content_body;
  }
  
  /*
   * STRING/NUMBER MANIPULATION FUNCTIONS
   */
  
  // Define the function for converting strings to web-safe URL tokens/IDs
  public function web_id($input_string, $crop_chars = false, $glue = '-'){
  	// Verified the input string is not empty
    if (!is_string($input_string) || empty($input_string)){
     $this->message('[[plutocms_core::web_id]] : A valid input string was not provided.', PLUTOCMS_ERROR);
     return false;
    }
    // If the $glue is empty, fill it with a hyphen
    $glue = is_string($glue) ? $glue : '';
    // Remove any/all line-breaks
    $web_id = str_replace(array("\r\n", "\r", "\n"), ' ', $input_string);
    // Encode any HTML entities
    $web_id = $this->htmlentity_encode($web_id);
    // Convert the rest of the string to lower-case
    $web_id = strtolower($web_id);
    // Replace any common entity codes with word equivalents
    $web_id = preg_replace('#(&){1}(\#){0,1}(amp|0038|038|38){1}(;){1}#i', 'and', $web_id);
    $web_id = preg_replace('#(&){1}(\#){0,1}(nbsp|0160|160|){1}(;){1}#i', ' ', $web_id);
    // Programmatically replace any accent characters with their plain ascii equivalents
    $web_id = preg_replace('#(&{1})([a-z]{1})(grave;{1})#i', '$2', $web_id);
    $web_id = preg_replace('#(&{1})([a-z]{1})(acute;{1})#i', '$2', $web_id);
    $web_id = preg_replace('#(&{1})([a-z]{1})(circ;{1})#i', '$2', $web_id);
    $web_id = preg_replace('#(&{1})([a-z]{1})(tilde;{1})#i', '$2', $web_id);
    $web_id = preg_replace('#(&{1})([a-z]{1})(uml;{1})#i', '$2', $web_id);
    $web_id = preg_replace('#(&{1})([a-z]{1})(cedil;{1})#i', '$2', $web_id);
    $web_id = preg_replace('#(&{2})([a-z]{1})(lig;{1})#i', '$2', $web_id);
    $web_id = preg_replace('#(&{1})([a-z]{1})(slash;{1})#i', '$2', $web_id);
    $web_id = preg_replace('#(&{1})([a-z]{1})(ring;{1})#i', '$2', $web_id);
    // Remove any remaining entity references entirely
    $web_id = preg_replace('/&#?[a-z0-9]+;/i', ' ', $web_id);
    // Replace any remaining single-characters that may be important
    $web_id = str_replace('&', 'and', $web_id);
    $web_id = str_replace('@', 'at', $web_id);
    // Remove all remaining non-ascii letter characters from the string
    $web_id = preg_replace('#([[:punct:][:blank:]]{1})#i', ' ', $web_id);
    // Purge any duplicate spaces, replacing them with single-spaces
    $web_id = preg_replace('/([\s]+)/i', $glue, $web_id);
    $web_id = trim($web_id, $glue);
    // Convert the back into their normal form
    $web_id = $this->htmlentity_decode($web_id);
    // If $crop_chars was provided, chop the web ID
    if (is_numeric($crop_chars) && $crop_chars > 0 && strlen($web_id) > $crop_chars){
      // Chop off the max chararcters plus one (used later)
      $temp_web_id = substr($web_id, 0, ($crop_chars + 1));
      // Check if this contains hyphens
      $hyphen_check = strrpos($temp_web_id, $glue);
      if ($hyphen_check !== false){
        // Check if the very last character is a hyphen
        if ($hyphen_check == (strlen($temp_web_id) - 1)){
          // Simply remove the last character and return
          // the full-length web_id
          $web_id = substr($temp_web_id, 0, $crop_chars);
        }
        // Otherwise, break the $temp_web_id into an array
        else{
          // Break the web_id into array with '-'
          $temp_web_id = explode($glue, $temp_web_id);
          // Pop the last element off at the end
          array_pop($temp_web_id);
          // Implode the array back together
          $temp_web_id = implode($glue, $temp_web_id);
          // And return the new web_id
          $web_id = $temp_web_id;
        }
      }
      // Otherwise, if no hypens were found
      else{
        // If this is too large and contains no hyphens,
        // we have no choice but to crop it to the exact
        // number specified - whole word or not
        $web_id = substr($temp_web_id, 0, $crop_chars);
      }
    }
    // Return the converted string
    return $web_id;
  }
  
  // Define the function for converting web-safe URL tokens/IDs to estimated labels
  public function web_label($string){
  	// First run the string through the web_id function to remove unwanted characters
    $string = $this->web_id($string);
    // Now replace all hyphens and/or underscores in the string with spaces
    $string = str_replace(array('_', '-', '+'), ' ', $string);
    // Now capitalize all the words in the string label
    $string = ucwords($string);
    // Return the labelized string
    return $string;
  }
  
  // Define the function for converting a string to an encrypted value
  function string_encrypt($string, $key){
    $result = '';
    $length = strlen($string);
    for ($i = 0; $i < $length; $i++){
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result .= $char;
    }
    return base64_encode($result);
  }
  
  // Define the function for decypting a string to it's original value
  function string_decrypt($string, $key){
    $result = '';
    $string = base64_decode($string);
    $length = strlen($string);
    for ($i = 0; $i < $length; $i++){
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result .= $char;
    }
    return $result;
  }

  // Define the function for exploding an encapsulated ID or Token List
  public function explode_list($list, $glue = ',', $containers = array('[', ']')){
    // First ensure the list is not empty, otherwise return false
    if (empty($list)){ return false; }
    // Now ensure the glue and containers are not empty
    if (empty($glue) || !is_string($glue)){ $this->message('[[plutocms_core::explode_list]] : A valid glue string was not provided.', PLUTOCMS_ERROR); return false; }
    if (!isset($containers[0]) || empty($containers[0]) || !is_string($containers[0])){ $this->message('[[plutocms_core::explode_list]] : A valid left-container string was not provided.', PLUTOCMS_ERROR); return false; }
    if (!isset($containers[1]) || empty($containers[1]) || !is_string($containers[1])){ $this->message('[[plutocms_core::explode_list]] : A valid right-container string was not provided.', PLUTOCMS_ERROR); return false; }
    // Now to encode the delimiters, glue and containers for preg-matching
    $preg = array();
    $preg['delim'] = $glue != '#' ? '#' : '/';
    $preg['glue'] = preg_quote($glue);
    $preg['lcont'] = preg_quote($containers[0]);
    $preg['rcont'] = preg_quote($containers[1]);
    // Now form the regular expression for pulling elements
    $regex = "{$preg['delim']}{$preg['lcont']}([^{$preg['lcont']}{$preg['rcont']}]+){$preg['rcont']}{$preg['glue']}?{$preg['delim']}i";
    // Now pull/match all elements in the string and return the results
    $matches = array();
    if (preg_match_all($regex, $list, $matches)){
      return $matches[1];
    }
    // Return false if no matches were found
    else {
      return false;
    }
  }
  
  // Define the function for imploding an encapsulated ID or Token List
  public function implode_list($array, $glue = ',', $leftcontainer = '[', $rightcontainer = ']'){
    // Loop through and remove any empty values in the array
    foreach($array as $key => $value) {
      if(empty($value)) {
        unset($array[$key]);
      }
    }
    $array = array_values($array);
    // Now walk through each array value and encapsulate it in the containers
    foreach($array as $key => $value) {
        $array[$key] = $leftcontainer.$value.$rightcontainer;
    }
    // Now implode the list into a string
    $list = implode($glue, $array);
    // And return the new string
    return $list;
  }
  
  // Define a function for easily replacing all line-breaks with a specific value
  public function newline_replace($string, $replace){
    // Either replace the line-breaks
    $new_string = str_replace(array("\r\n", "\r", "\n"), $replace, $string);
    // Return the new string
    return $new_string;
  }
  public function newline2break($string, $replace = '<br />'){
    return $this->newline_replace($string, $replace);
  }

  // Define a function for easily replacing all breaks-tags with a specific value
  public function break_replace($string, $replace){
    // Either replace the line-breaks
    $new_string = preg_replace('#<br\s*/?>#i', $replace, $string);
    // Return the new string
    return $new_string;
  }
  public function break2newline($string, $replace = "\r\n"){
    return $this->break_replace($string, $replace);
  }
  
  // Define a function for easily removing html tags from a string
  public function htmltags_filter($string, $allowtags = '<b><strong><i><em><u><del><ins>'){
    // Return the string with tags removed
    return strip_tags($string, $allowtags);
  }
  public function htmltags_remove($string){
    // Return the string with tags removed
    return $this->htmltags_filter($string, false);
  }
  
  // Define a function for closing HTML tags that haven't been closed
  public function htmltags_close($html){
    preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openedtags = $result[1];
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedtags = $result[1];
    $len_opened = count($openedtags);
    if (count($closedtags) == $len_opened) {
      return $html;
    }
    $openedtags = array_reverse($openedtags);
    for ($i=0; $i < $len_opened; $i++) {
      if (!in_array($openedtags[$i], $closedtags)) {
        $html .= '</'.$openedtags[$i].'>';
      } else {
        unset($closedtags[array_search($openedtags[$i], $closedtags)]);
      }
    }
    return $html;
  }
  
  // Define a function for adding the ordinal suffix to any integer
  public function number_suffix($value, $concatenate = true, $superscript = false){
    if (!is_numeric($value) || !is_int($value)){
      $this->message('[[plutocms_core::number_suffix]] : A valid integer value was not provided.', PLUTOCMS_ERROR);
      return false;
    }
    if (substr($value, -2, 2) == 11 || substr($value, -2, 2) == 12 || substr($value, -2, 2) == 13){ $suffix = "th"; }
    else if (substr($value, -1, 1) == 1){ $suffix = "st"; }
    else if (substr($value, -1, 1) == 2){ $suffix = "nd"; }
    else if (substr($value, -1, 1) == 3){ $suffix = "rd"; }
    else { $suffix = "th"; }
    if ($superscript){ $suffix = "<sup>".$suffix."</sup>"; }
    if ($concatenate){ return $value.$suffix; }
    else { return $suffix; }
  }
  
  /*
   * TEXT CREATION/MANIPULATION FUNCTIONS
   */
  
  // Define a function for generating an excerpt of a larger string with sensible cropping
  public function excerpt($string, $cutoff = 250, $endcap = '&hellip;', $allowtags = false){
    // Create the excerpt containers and remove any html tags
    $final_excerpt = '';
    $temp_excerpt = '';
    if (is_string($allowtags)){ $temp_excerpt = $this->htmltags_filter($string, $allowtags);  }
    elseif ($allowtags === true) { $temp_excerpt = $this->htmltags_filter($string); }
    elseif ($allowtags === false) { $temp_excerpt = $this->break_replace($string, ' '); $temp_excerpt = $this->htmltags_remove($temp_excerpt); }
    else { $temp_excerpt = $this->htmltags_remove($string); }
    // Replace any space characters with actual spaces
    $temp_excerpt = preg_replace('#(&){1}(\#){0,1}(nbsp|0160|160|){1}(;){1}#i', ' ', $temp_excerpt);
    // Replace any newline characters with spaces
    $temp_excerpt = $this->newline_replace($temp_excerpt, ' ');
    // If the new string is less than the cutoff, return it as-is
    if (strlen($temp_excerpt) <= $cutoff){
      $final_excerpt = $temp_excerpt;
    }
    // Otherwise, crop the string
    else{
      // Decrease the cutoff by the length of the endcap
      $cutoff = $cutoff - strlen($endcap);
      $minimum = ceil($cutoff*0.75);
      // Chop the string at the cutoff
      $temp_excerpt = substr($temp_excerpt, 0, $cutoff);
      // Check if there is a period at all in the string
      if (strpos($temp_excerpt, '.', $minimum)){
        // Find the position of the LAST period
        $period_position = strrpos($temp_excerpt, '.', $minimum);
        // Crop the text before the last occurance of a period
        $temp_excerpt = substr($temp_excerpt, 0, $period_position);
      }
      elseif (strpos($temp_excerpt, ' ', $minimum)){
        // Find the position of the LAST space
        $space_position = strrpos($temp_excerpt, ' ', $minimum);
        // Crop the text before the last occurance of a space
        $temp_excerpt = substr($temp_excerpt, 0, $space_position);
      }
      // Remove trailing spaces or tag fragments at the end of the string
      if (substr($temp_excerpt, -1, 1) == ' '
        || substr($temp_excerpt, -1, 1) == '<'
        || substr($temp_excerpt, -1, 1) == '.'
        || substr($temp_excerpt, -1, 1) == ','){
          $temp_excerpt = substr($temp_excerpt, 0, (strlen($temp_excerpt) - 2));
      }
      // Close any unclosed tags
      $temp_excerpt = $this->htmltags_close($temp_excerpt);
      // And finally add the endcap
      $temp_excerpt .= $endcap;
      // Add the $temp_excerpt to the $final_excerpt
      $final_excerpt = $temp_excerpt;
    }
    // Return the excerpt
    return $final_excerpt;
  }
  
  // Define the function for generating filler text (useful for layout planning and testing)
  public function filler($num_words = 200, $use_links = true, $use_styles = true){
    // Define the base text/words to use in as filler
    $filler_base = 'lorem ipsum dolor sit amet consectetur adipiscing elit donec klingon lacus arcu '.
    'porta mattis lacinia eget mattis at orci donec hendrerit beloved tortor orci non hendrerit hiro erat '.
    'in molestie dolor sit amet placerat fermentum diam eros rhoncus pichu eros at kratos iaculis dui dui '.
    'quis lorem appa phasellus sed quam mollis urna eevee vulputate condimentum id sodales urna proin '.
    'dictum dolor et cyndaquil leo pulvinar suscipit in adipiscing volutpat odio sagittis varius magna '.
    'porta id vivamus ornare fermentum turpis vitae egestas curabitur congue sark ultricies neque '.
    'donec congue ipsum nec congo risus ornare sed euismod sapien mollis aliquam erat volutpat rombaldi '.
    'phasellus mollis ornare vulputate nullam at neque metus et blandit turpis oddish aang dude munna '.
    'musharna shimama gonbe';
    // Explode the base into separate words
    $filler_words = explode(' ', strtolower($filler_base));
    // Count the number of words collected
    $filler_num_words = count($filler_words);
    // Start the container variable for the filler text
    $filler_text = '';
    // Loop through the number of words requested and pull/generate random words and punctuation
    for ($i = 1; $i <= $num_words; $i++)
    {
      $random_word = $filler_words[mt_rand(0, ($filler_num_words-1))];
      $new_sentance = ($i == 1 || ($i % mt_rand(1, 100) == 0)) ? true : false;
      $new_comma = ($i != 1 && ($i % mt_rand(1, 100) == 0)) ? true : false;
      $new_link = ($i != 1 && ($i % mt_rand(1, 100) == 0)) ? true : false;
      $new_bold = ($i != 1 && ($i % mt_rand(1, 100) == 0)) ? true : false;
      $new_italic = ($i != 1 && ($i % mt_rand(1, 100) == 0)) ? true : false;
      if ($new_sentance) { $filler_text .= ($i != 1 ? '. ' : '').ucfirst($random_word); }
      elseif ($new_comma) { $filler_text .= ', '.$random_word; }
      elseif ($use_links && $new_link) { $filler_text .= ' <a href="#">'.$random_word.'</a>'; }
      elseif ($use_styles && $new_bold) { $filler_text .= ' <strong>'.$random_word.'</strong>'; }
      elseif ($use_styles && $new_italic) { $filler_text .= ' <em>'.$random_word.'</em>'; }
      else { $filler_text .= ' '.$random_word; }
    }
    // Add a final period to the end of the
    $filler_text .= '.';
    // Return the finished filler text
    return $filler_text;
  }
  
  // Define a public function for sending email messages
  public function email($to_email, $from_email, $message_subject, $message_body, $reply_to_email = false, $email_type = 'text/html'){
    // Parse the email type
    $email_type = strtolower($email_type);
    if (!in_array($email_type, array('text/html', 'text/plain'))){
      $email_type = 'text/html';
    }
    // Parse the TO email
    if (preg_match('/([^<>]*)<(.*)>/i', $to_email, $to_matches)){
      $to_name = $to_matches[1];
      $to_email = $to_matches[2];
    }elseif(preg_match('/([-_a-z0-9\.]*)@([^<>]*)/i', $to_email, $to_matches)){
      $to_name = $to_matches[1];
      $to_email = $to_matches[0];
    }else{
      $this->message("[[plutocms_core::email]] : A valid recipient email was not provided.", PLUTOCMS_ERROR);
      return false;
    }
    // Parse the FROM email
    if (preg_match('/([^<>]*)<(.*)>/i', $from_email, $from_matches)){
      $from_name = $from_matches[1];
      $from_email = $from_matches[2];
    }elseif(preg_match('/([-_a-z0-9\.]*)@([^<>]*)/i', $from_email, $from_matches)){
      $from_name = $from_matches[1];
      $from_email = $from_matches[0];
    }else{
      $this->message("[[plutocms_core::email]] : A valid sender email was not provided.", PLUTOCMS_ERROR);
      return false;
    }
    // Parse the REPLY-TO email
    if (preg_match('/([^<>]*)<(.*)>/i', $reply_to_email, $reply_to_matches)){
      $reply_to_name = $reply_to_matches[1];
      $reply_to_email = $reply_to_matches[2];
    }elseif(preg_match('/([-_a-z0-9\.]*)@([^<>]*)/i', $reply_to_email, $reply_to_matches)){
      $reply_to_name = $reply_to_matches[1];
      $reply_to_email = $reply_to_matches[0];
    }else{
      $reply_to_name = false;
      $reply_to_email = false;
    }
    // Define/set the email headers
    ini_set('sendmail_from', $from_email);
    if ($reply_to_name && $reply_to_email) { $message_header = "Reply-To: {$reply_to_name} <{$reply_to_email}>\r\n"; }
    else { $message_header = "Reply-To: {$from_name} <{$from_email}>\r\n"; }
    $message_header .= "Return-Path: {$from_name} <{$from_email}>\r\n";
    $message_header .= "From: {$from_name} <{$from_email}>\r\n";
    $message_header .= "Content-Type: {$email_type};\r\n";
    // Attempt to send the email message
    if (mail($to_email, $message_subject, ($email_type == 'text/html' ? "<html>\r\n<body>\r\n" : '').$message_body.($email_type == 'text/html' ? "</body>\r\n</html>\r\n" : ''), $message_header)){ return true; }
    else { $this->message("[[plutocms_core::email]] : An unknown error occured.  Mail was not sent.", PLUTOCMS_UNKNOWN); return false; }
  }
  
  /*
   * COLOUR / GRAPHIC FUNCTIONS
   */

  // Define a function for converting a HEX value to an RGB array
  public function colour_hex2rgb($src_value){
    return $this->color_hex2rgb($src_value);
  }
  public function color_hex2rgb($src_value){
    if (!is_string($src_value)) { $this->message("[[plutocms_core::color_hex2rgb]] : Source value is not a string.", PLUTOCMS_ERROR); return false; }
    $src_value = str_replace('#','', trim($src_value));
    if (!preg_match("#^[0-9A-F]+$#i", $src_value)) { $this->message("[[plutocms_core::color_hex2rgb]] : Source value is not in HEX format as it contains illegal characters <<{$src_value}>>.", PLUTOCMS_ERROR); return false; }
    if (strlen($src_value) == 3) { $groups = 1; }
    elseif (strlen($src_value) == 6) { $groups = 2; }
    else { $this->message("[[plutocms_core::color_hex2rgb]] : Source value is not in HEX format as it contains an invalid number of digits <<{$src_value}>>.", PLUTOCMS_ERROR); return false; }
    $dst_value = array();
    $dst_value[0] = $dst_value['r'] = $dst_value['red'] = hexdec(substr($src_value, 0,1*$groups));
    $dst_value[1] = $dst_value['g'] = $dst_value['green'] = hexdec(substr($src_value, 1*$groups,1*$groups));
    $dst_value[2] = $dst_value['b'] = $dst_value['blue'] = hexdec(substr($src_value, 2*$groups,1*$groups));
    return $dst_value;
  }
  
  // Define a function for converting an RGB array to a HEX value
  public function colour_rgb2hex($src_value){
    return $this->color_rgb2hex($src_value);
  }
  public function color_rgb2hex($src_value){
    if (!is_array($src_value)) { $this->message("[[plutocms_core::color_rgb2hex]] : Source value is not an array.", PLUTOCMS_ERROR); return false; }
    if (count($src_value) % 3 != 0) { $this->message("[[plutocms_core::color_rgb2hex]] : Source value contains an invalid number of arguments <<".implode(',',$src_value).">>.", PLUTOCMS_ERROR); return false; }
    $src_value[0] = $src_value['r'] = $src_value['red'] = isset($src_value['red']) ? $src_value['red'] : (isset($src_value['r']) ? $src_value['r'] : (isset($src_value[0]) ? $src_value[0] : 0));
    $src_value[1] = $src_value['g'] = $src_value['green'] = isset($src_value['green']) ? $src_value['green'] : (isset($src_value['g']) ? $src_value['g'] : (isset($src_value[1]) ? $src_value[1] : 0));
    $src_value[2] = $src_value['b'] = $src_value['blue'] = isset($src_value['blue']) ? $src_value['blue'] : (isset($src_value['b']) ? $src_value['b'] : (isset($src_value[2]) ? $src_value[2] : 0));
    $dst_value = '#';
    $dst_value .= str_pad(dechex($src_value['red']), 2, '0', STR_PAD_LEFT);
    $dst_value .= str_pad(dechex($src_value['green']), 2, '0', STR_PAD_LEFT);
    $dst_value .= str_pad(dechex($src_value['blue']), 2, '0', STR_PAD_LEFT);
    $dst_value = strtoupper($dst_value);
    return $dst_value;
  }
  
  // Define a function for lightening the perceived brightness of a colour (HEX or RGB)
  public function colour_lighten($colour, $percent){
    return $this->color_lighten($colour, $percent);
  }
  public function color_lighten($color, $percent){
    // Verify the percent value and the variable type
    if (!is_numeric($percent)) { $this->message("[[plutocms_core::color_lighten]] : Percentage to lighten is not numeric.", PLUTOCMS_ERROR); return false; }
    if (!is_array($color) && !is_string($color)) { $this->message("[[plutocms_core::color_lighten]] : Source color value is not in a recognized format.", PLUTOCMS_ERROR); return false; }
    if ($percent == 0) { return $color; }
    // If this is a string, make sure it's a HEX value
    if (is_string($color)){
      $rgb = $this->color_hex2rgb($color);
      if (!isset($rgb['red']) || !isset($rgb['green']) || !isset($rgb['blue'])) { $this->message("[[plutocms_core::color_lighten]] : Source color value is not in a recognized format (incorrectly assumed HEX format).", PLUTOCMS_ERROR); return false; }
      $return_format = 'HEX';
    }
    // If this is an array, make sure it contains the necessary RGB values
    elseif (is_array($color)){
      if (count($color) % 3 != 0) { $this->message("[[plutocms_core::color_lighten]] : Source color value is not in a recognized format (incorrectly assumed RGB format).", PLUTOCMS_ERROR); return false; }
      $rgb = $color;
      $rgb[0] = $rgb['r'] = $rgb['red'] = isset($rgb['red']) ? $rgb['red'] : (isset($rgb['r']) ? $rgb['r'] : (isset($rgb[0]) ? $rgb[0] : 0));
      $rgb[1] = $rgb['g'] = $rgb['green'] = isset($rgb['green']) ? $rgb['green'] : (isset($rgb['g']) ? $rgb['g'] : (isset($rgb[1]) ? $rgb[1] : 0));
      $rgb[2] = $rgb['b'] = $rgb['blue'] = isset($rgb['blue']) ? $rgb['blue'] : (isset($rgb['b']) ? $rgb['b'] : (isset($rgb[2]) ? $rgb[2] : 0));
      if (!isset($rgb['red']) || !isset($rgb['green']) || !isset($rgb['blue'])) { $this->message("[[plutocms_core::color_lighten]] : Source color value is not in a recognized format (incorrectly assumed RGB format).", PLUTOCMS_ERROR); return false; }
      $return_format = 'RGB';
    }
    // Create the new RGB values by multiplying each by the percent
    $red = round($rgb['red'] * (1+($percent/100)));
    $blue = round($rgb['blue'] * (1+($percent/100)));
    $green = round($rgb['green'] * (1+($percent/100)));
    // Collect the overflow form any value over 255
    $overflow = 0;
    if ($red > 255) { $overflow += $red - 255; $red = 255; }
    elseif ($red < 0) { $overflow -= $red * -1; $red = 0; }
    if ($blue > 255) { $overflow += $blue - 255; $blue = 255; }
    elseif ($blue < 0) { $overflow -= $blue * -1; $blue = 0; }
    if ($green > 255) { $overflow += $green - 255; $green = 255; }
    elseif ($green < 0) { $overflow -= $green * -1; $green = 0; }
    // Distribute the overflow evenly to the other colours
    if ($overflow > 0){
      $overflow_each = round($overflow / 3);
      $red += $overflow_each;
      $blue += $overflow_each;
      $green += $overflow_each;
    }
    // And now re-cap them at 0-255 in case any went over
    if ($red > 255) { $red = 255; }
    elseif ($red < 0) { $red = 0; }
    if ($blue > 255) { $blue = 255; }
    elseif ($blue < 0) { $blue = 0; }
    if ($green > 255) { $green = 255; }
    elseif ($green < 0) { $green = 0; }
    // Return the value in the format it was submit
    if ($return_format == 'HEX'){
      $return_color = $this->color_rgb2hex(array($red, $green, $blue));
      return $return_color;
    }
    elseif ($return_format == 'RGB'){
      $return_color = array();
      $return_color[0] = $return_color['r'] = $return_color['red'] = $red;
      $return_color[1] = $return_color['g'] = $return_color['green'] = $green;
      $return_color[2] = $return_color['b'] = $return_color['blue'] = $blue;
      return $return_color;
    }
  }
  
  // Define a function for darkening the perceived brightness of a colour (HEX or RGB)
  public function colour_darken($colour, $percent){
    return $this->color_darken($colour, $percent);
  }
  public function color_darken($color, $percent){
    // Verify the percent value and the variable type
    if (!is_numeric($percent)) { $this->message("[[plutocms_core::color_darken]] : Percentage to lighten is not numeric.", PLUTOCMS_ERROR); return false; }
    if (!is_array($color) && !is_string($color)) { $this->message("[[plutocms_core::color_darken]] : Source color value is not in a recognized format.", PLUTOCMS_ERROR); return false; }
    if ($percent == 0) { return $color; }
      // If this is a string, make sure it's a HEX value
    if (is_string($color)){
      $rgb = $this->color_hex2rgb($color);
      if (!isset($rgb['red']) || !isset($rgb['green']) || !isset($rgb['blue'])) { $this->message("[[plutocms_core::color_darken]] : Source color value is not in a recognized format (incorrectly assumed HEX format).", PLUTOCMS_ERROR); return false; }
      $return_format = 'HEX';
    }
    // If this is an array, make sure it contains the necessary RGB values
    elseif (is_array($color)){
      if (count($color) % 3 != 0) { $this->message("[[plutocms_core::color_darken]] : Source color value is not in a recognized format (incorrectly assumed RGB format).", PLUTOCMS_ERROR); return false; }
      $rgb = $color;
      $rgb[0] = $rgb['r'] = $rgb['red'] = isset($rgb['red']) ? $rgb['red'] : (isset($rgb['r']) ? $rgb['r'] : (isset($rgb[0]) ? $rgb[0] : 0));
      $rgb[1] = $rgb['g'] = $rgb['green'] = isset($rgb['green']) ? $rgb['green'] : (isset($rgb['g']) ? $rgb['g'] : (isset($rgb[1]) ? $rgb[1] : 0));
      $rgb[2] = $rgb['b'] = $rgb['blue'] = isset($rgb['blue']) ? $rgb['blue'] : (isset($rgb['b']) ? $rgb['b'] : (isset($rgb[2]) ? $rgb[2] : 0));
      if (!isset($rgb['red']) || !isset($rgb['green']) || !isset($rgb['blue'])) { $this->message("[[plutocms_core::color_darken]] : Source color value is not in a recognized format (incorrectly assumed RGB format).", PLUTOCMS_ERROR); return false; }
      $return_format = 'RGB';
    }
    // Create the new RGB values by multiplying each by the percent
    $red = round($rgb['red'] * (1-($percent/100)));
    $blue = round($rgb['blue'] * (1-($percent/100)));
    $green = round($rgb['green'] * (1-($percent/100)));
    // Collect the overflow form any value over 255
    $overflow = 0;
    if ($red > 255) { $overflow += $red - 255; $red = 255; }
    elseif ($red < 0) { $overflow -= $red * -1; $red = 0; }
    if ($blue > 255) { $overflow += $blue - 255; $blue = 255; }
    elseif ($blue < 0) { $overflow -= $blue * -1; $blue = 0; }
    if ($green > 255) { $overflow += $green - 255; $green = 255; }
    elseif ($green < 0) { $overflow -= $green * -1; $green = 0; }
    // Distribute the overflow evenly to the other colours
    if ($overflow > 0){
      $overflow_each = round($overflow / 3);
      $red += $overflow_each;
      $blue += $overflow_each;
      $green += $overflow_each;
    }
    // And now re-cap them at 0-255 in case any went over
    if ($red > 255) { $red = 255; }
    elseif ($red < 0) { $red = 0; }
    if ($blue > 255) { $blue = 255; }
    elseif ($blue < 0) { $blue = 0; }
    if ($green > 255) { $green = 255; }
    elseif ($green < 0) { $green = 0; }
    // Return the value in the format it was submit
    if ($return_format == 'HEX'){
      $return_color = $this->color_rgb2hex(array($red, $green, $blue));
      return $return_color;
    }
    elseif ($return_format == 'RGB'){
      $return_color = array();
      $return_color[0] = $return_color['r'] = $return_color['red'] = $red;
      $return_color[1] = $return_color['g'] = $return_color['green'] = $green;
      $return_color[2] = $return_color['b'] = $return_color['blue'] = $blue;
      return $return_color;
    }
  }
  
  // Define a function for inverting a colour
  public function colour_invert($colour){
  	return $this->color_invert($colour);
  }
  public function color_invert($color){
    // Verify the color variable type
    if (!is_array($color) && !is_string($color)) { $this->message("[[plutocms_core::color_invert]] : Source color value is not in a recognized format.", PLUTOCMS_ERROR); return false; }
    // If this is a string, make sure it's a HEX value
    if (is_string($color)){
      $rgb = $this->color_hex2rgb($color);
      if (!isset($rgb['red']) || !isset($rgb['green']) || !isset($rgb['blue'])) { $this->message("[[plutocms_core::color_invert]] : Source color value is not in a recognized format (incorrectly assumed HEX format).", PLUTOCMS_ERROR); return false; }
      $return_format = 'HEX';
    }
    // If this is an array, make sure it contains the necessary RGB values
    elseif (is_array($color)){
      if (count($color) % 3 != 0) { return false; }
      $rgb = $color;
      $rgb[0] = $rgb['r'] = $rgb['red'] = isset($rgb['red']) ? $rgb['red'] : (isset($rgb['r']) ? $rgb['r'] : (isset($rgb[0]) ? $rgb[0] : 0));
      $rgb[1] = $rgb['g'] = $rgb['green'] = isset($rgb['green']) ? $rgb['green'] : (isset($rgb['g']) ? $rgb['g'] : (isset($rgb[1]) ? $rgb[1] : 0));
      $rgb[2] = $rgb['b'] = $rgb['blue'] = isset($rgb['blue']) ? $rgb['blue'] : (isset($rgb['b']) ? $rgb['b'] : (isset($rgb[2]) ? $rgb[2] : 0));
      if (!isset($rgb['red']) || !isset($rgb['green']) || !isset($rgb['blue'])) { $this->message("[[plutocms_core::color_invert]] : Source color value is not in a recognized format (incorrectly assumed RGB format).", PLUTOCMS_ERROR); return false; }
      $return_format = 'RGB';
    }
    // Create the new RGB values by subtracting the difference from 255
    $red = 255 - $rgb['red'];
    $blue = 255 - $rgb['blue'];
    $green = 255 - $rgb['green'];
    // Return the value in the format it was submit
    if ($return_format == 'HEX'){
      $return_color = $this->color_rgb2hex(array($red, $green, $blue));
      return $return_color;
    }
    elseif ($return_format == 'RGB'){
      $return_color = array();
      $return_color[0] = $return_color['r'] = $return_color['red'] = $red;
      $return_color[1] = $return_color['g'] = $return_color['green'] = $green;
      $return_color[2] = $return_color['b'] = $return_color['blue'] = $blue;
      return $return_color;
    }
  }
  
  // Define a function for creating a new image based on an existing source
  public function image_create($source_path, $export_path, $export_type = '', $export_width = '', $export_height = '', $options = array(), $filters = array()){
    // Attempt to increase the memory limit
    @ini_set("memory_limit", '500M');
    // Define allowable values for mandatory fields
    $allowed_types = array('JPG', 'PNG', 'GIF');
    // Ensure the $source_path exists
    if (empty($source_path)){ $this->message("[[plutocms_core::image_create]] : Source image path was not provided.", PLUTOCMS_ERROR); return false; }
    elseif (!file_exists($source_path)){ $this->message("[[plutocms_core::image_create]] : Source image path <<{$source_path}>> does not exist.", PLUTOCMS_ERROR); return false; }
    // Ensure the $export_path exists
    @preg_match('#^(.+?)([^/\\\]+)$#i', $export_path, $matches);
    if (empty($export_path)){ $this->message("[[plutocms_core::image_create]] : Export image path was not provided.", PLUTOCMS_ERROR); return false; }
    elseif (!empty($matches[1]) && !file_exists($matches[1])){ $this->message("[[plutocms_core::image_create]] : Export image path <<{$matches[1]}>> does not exist.", PLUTOCMS_ERROR); return false; }
    // Collect the file type for the source file
    $source_type = $this->filetype($source_path);
    if (!in_array($source_type['ID'], array('JPG','PNG','GIF'))){ $this->message("[[plutocms_core::image_create]] : Provided source file type <<{$source_type['ID']}>> was not a valid image format.", PLUTOCMS_ERROR); return false; }
    // Collect/reformat the file type for the export file
    if (!empty($export_type) && is_string($export_type)){ $export_type = isset($this->FILETYPES[$export_type]) ? $this->FILETYPES[$export_type] : ''; }
    elseif (!empty($export_type) && is_array($export_type)){ $id = isset($export_type['ID']) ? $export_type['ID'] : $export_type[0]; $export_type = isset($this->FILETYPES[$id]) ? $this->FILETYPES[$id] : '';  }
    if (!$export_type) { $export_type = $source_type; }
    // Collect the source image dimensions
    list($source_width, $source_height) = getimagesize($source_path);
    // Ensure the options are in array format, else define default
    if (!is_array($options)){ $options = array(); }
    // Ensure the filters are in array format, else define default
    if (!is_array($filters)){ $filters = array(); }
    // Define any option defaults if not set
    $options['crop'] = isset($options['crop']) ? $this->force_boolean($options['crop']) : true;
    $options['enlarge'] = isset($options['enlarge']) ? $this->force_boolean($options['enlarge']) : true;
    $options['background'] = isset($options['background']) && preg_match('/^#?([a-z0-9]{6})$/i', $options['background']) ? '#'.trim($options['background'], '#') : false;
    $options['halign'] = isset($options['halign']) && is_numeric($options['halign']) ? $options['halign'] : PLUTOCMS_ALIGN_CENTER;
    $options['valign'] = isset($options['valign']) && is_numeric($options['valign']) ? $options['valign'] : PLUTOCMS_ALIGN_MIDDLE;
    $options['maxwidth'] = isset($options['maxwidth']) && is_numeric($options['maxwidth']) && $options['maxwidth'] > 0 ? $options['maxwidth'] : false;
    $options['maxheight'] = isset($options['maxheight']) && is_numeric($options['maxheight']) && $options['maxheight'] > 0 ? $options['maxheight'] : false;
    // Collect and reformat any filters into associative arrays
    foreach ($filters AS $key => $filterinfo):
      $filter = array();
      $filter['type'] = isset($filterinfo['type']) ? $filterinfo['type'] : (isset($filterinfo[0]) ? $filterinfo[0] : false);
      $filter['arg1'] = isset($filterinfo['arg1']) ? $filterinfo['arg1'] : (isset($filterinfo[1]) ? $filterinfo[1] : false);
      $filter['arg2'] = isset($filterinfo['arg2']) ? $filterinfo['arg2'] : (isset($filterinfo[2]) ? $filterinfo[2] : false);
      $filter['arg3'] = isset($filterinfo['arg3']) ? $filterinfo['arg3'] : (isset($filterinfo[3]) ? $filterinfo[3] : false);
      $filter['arg4'] = isset($filterinfo['arg4']) ? $filterinfo['arg4'] : (isset($filterinfo[4]) ? $filterinfo[4] : false);
      if ($filter['type'] !== false) { $filters[$key] = $filter; }
    endforeach;
    // Collect or define export image dimensions, defining any missing values
    $export_width = !empty($export_width) && is_numeric($export_width) ? $export_width : '';
    $export_height = !empty($export_height) && is_numeric($export_height) ? $export_height : '';
    if (!$export_width && !$export_height){ $export_width = $source_width; $export_height = $source_height; }
    elseif ($export_width && !$export_height){ $export_height = $this->image_autoheight($source_width, $source_height, $export_width); }
    elseif (!$export_width && $export_height){ $export_width = $this->image_autowidth($source_width, $source_height, $export_height); }
    // If enlarge is set to FALSE, check to ensure this image will not be stretched
    if (!$options['enlarge']){
      if (is_numeric($export_width) && ($export_width > $source_width)){
        $export_width = $source_width;
        $export_height = $this->image_autoheight($source_width, $source_height, $export_width);
      }
      if (is_numeric($export_height) && ($export_height > $source_height)){
        $export_height = $source_height;
        $export_width = $this->image_autowidth($source_width, $source_height, $export_height);
      }
    }
    // If there is a maxwidth or maxheight defined, respect them
    if (!empty($options['maxwidth']) && $export_width > $options['maxwidth']){
      $export_width = $options['maxwidth'];
      $export_height = $this->image_autoheight($source_width, $source_height, $export_width);
    }
    if (!empty($options['maxheight']) && $export_height > $options['maxheight']){
      $export_height = $options['maxheight'];
      $export_width = $this->image_autowidth($source_width, $source_height, $export_height);
    }
    // Create backup variables for the source and export width and height
    $org_source_width = $source_width;
    $org_source_height = $source_height;
    $org_export_width = $export_width;
    $org_export_height = $export_height;
    // Define the source and export X and Y coordinance
    $source_x = $source_y = 0;
    $export_x = $export_y = 0;
    // Determine the aspect ratios for the source and export images
    $source_aspect = $source_width / $source_height;
    $export_aspect = $export_width / $export_height;
    // If enlargement is NOT enabled, prevent stretching of smaller images
    if (!$options['enlarge']){
      // If both the $export_width and $export_height are greater than the $source_width and $source_height
      if ($export_width > $source_width && $export_height > $source_height){
        $org_export_width= $export_width = $source_width;
        $org_export_height= $export_height = $source_height;
      }
      // If the $export_width is greater than the $source_width
      elseif ($export_width > $source_width){
        $org_export_width = $export_height = $this->image_autoheight($export_width, $export_height, $source_width);
        $org_export_height= $export_width = $source_width;
      }
      // If the $export_height is great than the $source_height
      elseif ($export_height > $source_height){
        $org_export_width = $export_width = $this->image_autowidth($export_width, $export_height, $source_height);
        $org_export_height= $export_height = $source_height;
      }
    }
    // If cropping was requested and the two images are different aspects, define the new resolution coordinants
    if ($options['crop'] && $source_aspect != $export_aspect){
      // If the $source_aspect is greater than $export_aspect (source is wider)
      if ($source_aspect > $export_aspect){
        // Leave the $source_height the same
        $source_height = $source_height;
        // Scale the $source_width proportionaly to the $export_width
        $source_width = ceil(($export_width * $org_source_height) / $export_height);
        // Leave the $source_y the same
        $source_y = $source_y;
        // Fix the halign if out of range
        if ($options['halign'] > 100 || $options['halign'] < -100){ $options['halign'] = $options['halign'] % 100; }
        if ($options['halign'] < 0){ $options['halign'] = 100 + $options['halign']; }
        // If the valign if at zero, keep it at the left (0%), otherwise, move it right proportionally
        if ($options['halign'] == 0){ $source_x = 0; }
        elseif ($options['halign'] > 0){ $source_x = ceil(($org_source_width / (100/$options['halign'])) - ($source_width / (100/$options['halign']))); }
      }
      // If the $source_aspect is less than the $export_aspect (source is taller)
      elseif ($source_aspect < $export_aspect){
        // Leave the $source_width the same
        $source_width = $source_width;
        // Scale the $source_height proportionaly to the $export_height
        $source_height = ceil(($org_source_width * $export_height) / $export_width);
        // Leave the $source_x the same
        $source_x = $source_x;
        // Fix the valign if out of range
        if ($options['valign'] > 100 || $options['valign'] < -100){ $options['valign'] = $options['valign'] % 100; }
        if ($options['valign'] < 0){ $options['valign'] = 100 + $options['valign']; }
        // If the valign if at zero, keep it at the top (0%), otherwise, move it down proportionally
        if ($options['valign'] == 0){ $source_y = 0; }
        elseif ($options['valign'] > 0){ $source_y = ceil(($org_source_height / (100/$options['valign'])) - ($source_height / (100/$options['valign']))); }
      }
    }
    // If cropping was NOT requested and the two images are different aspects, define the new resolution coordinants
    if (!$options['crop'] && $source_aspect != $export_aspect){
      // If the $source_aspect is greater than $export_aspect (source is wider)
      if ($source_aspect > $export_aspect){
        // Leave the $export_x the same
        $export_x = $export_x;
        // Leave the $source_width the same
        $source_width = $source_width;
        // Generate the approximate height of the fitted image
        $fit_width = $export_width;
        $fit_height = $this->image_autoheight($source_width, $source_height, $export_width);
        // Fix the valign if out of range
        if ($options['valign'] > 100 || $options['valign'] < -100){ $options['valign'] = $options['valign'] % 100; }
        if ($options['valign'] < 0){ $options['valign'] = 100 + $options['valign']; }
        // If the valign if at zero, keep it at the top (0%), otherwise, move it down proportionally
        if ($options['valign'] == 0){ $export_y = 0; }
        elseif ($options['valign'] > 0){ $export_y = round(($export_height / (100/$options['valign'])) - ($fit_height / (100/$options['valign']))); }
        // Update the $export_height to that of the $fit_height
        $export_height = $fit_height;
      }
      // If the $source_aspect is less than the $export_aspect (source is taller)
      elseif ($source_aspect < $export_aspect){
        // Leave the $export_y the same
        $export_y = $export_y;
        // Leave the $source_height the same
        $source_height = $source_height;
        // Generate the approximate width of the fitted image
        $fit_height = $export_height;
        $fit_width = $this->image_autowidth($source_width, $source_height, $export_height);
        // Fix the halign if out of range
        if ($options['halign'] > 100 || $options['halign'] < -100){ $options['halign'] = $options['halign'] % 100; }
        if ($options['halign'] < 0){ $options['halign'] = 100 + $options['halign']; }
        // If the valign if at zero, keep it at the left (0%), otherwise, move it right proportionally
        if ($options['halign'] == 0){ $export_x = 0; }
        elseif ($options['halign'] > 0){ $export_x = round(($export_width / (100/$options['halign'])) - ($fit_width / (100/$options['halign']))); }
        // Update the $export_width to that of the $fit_width
        $export_width = $fit_width;
      }
    }
    // Create the image link object based on source type
    if ($source_type['ID'] == 'JPG') { $source_link = @imagecreatefromjpeg($source_path); }
    elseif ($source_type['ID'] == 'PNG') { $source_link = @imagecreatefrompng($source_path); @imagealphablending($source_link, true); }
    elseif ($source_type['ID'] == 'GIF') { $source_link = @imagecreatefromgif($source_path); }
    // If there were any filters set, apply them to the image link
    if (!empty($filters)): foreach($filters AS $key => $filterinfo):
      if (defined('IMG_FILTER_COLORIZE') && $filterinfo['type'] == IMG_FILTER_COLORIZE):
        @imagefilter($source_link, $filterinfo['type'], $filterinfo['arg1'], $filterinfo['arg2'], $filterinfo['arg3']);
      elseif (defined('IMG_FILTER_PIXELATE') && $filterinfo['type'] == IMG_FILTER_PIXELATE):
        @imagefilter($source_link, $filterinfo['type'], $filterinfo['arg1'], $filterinfo['arg2']);
      elseif (defined('IMG_FILTER_SMOOTH') && $filterinfo['type'] == IMG_FILTER_SMOOTH):
        @imagefilter($source_link, $filterinfo['type'], $filterinfo['arg1']);
      elseif (defined('IMG_FILTER_CONTRAST') && $filterinfo['type'] == IMG_FILTER_CONTRAST):
        @imagefilter($source_link, $filterinfo['type'], $filterinfo['arg1']);
      elseif (defined('IMG_FILTER_BRIGHTNESS') && $filterinfo['type'] == IMG_FILTER_BRIGHTNESS):
        @imagefilter($source_link, $filterinfo['type'], $filterinfo['arg1']);
      else:
        @imagefilter($source_link, $filterinfo['type']);
      endif;
    endforeach; endif;
    // Create a true colour image container with the export with and height
    $export_object = imagecreatetruecolor($org_export_width, $org_export_height);
    // Fill a image with a background rectangle
    if ($options['background'] !== false){
      $background_rgb = $this->colour_hex2rgb($options['background']);
      $background_colour = imagecolorallocate($export_object, $background_rgb['red'], $background_rgb['green'], $background_rgb['blue']);
      imagefilledrectangle($export_object, 0, 0, $org_export_width, $org_export_height, $background_colour);
    }
    // If this is a PNG/GIF to PNG/GIF conversion, attempt to preserve transparency
    if ($options['background'] === false && ($export_type['ID'] == 'PNG' || $export_type['ID'] == 'GIF')):
      // Disable alpha blending on the export object
      @imagealphablending($export_object, false);
      // Enable alpha saving on the export object
      @imagesavealpha($export_object, true);
      // Now fill the export background will the transparent colour (assuming there is one)
      $trans_colour = imagecolorallocatealpha($export_object, 0, 0, 0, 127);
      @imagefill($export_object, 0, 0, $trans_colour);
      // If this is being exported as a GIF
      if (($source_type['ID'] == 'PNG' || $source_type['ID'] == 'GIF') && $export_type['ID'] == 'GIF'):
        // Collect the original transparent colour from the GIF or PNG
        $transparent_index = $source_type['ID'] == 'GIF' ? @imagecolortransparent($source_link) : @imagecolorsforindex($source_link, @imagecolorat($source_link, 0, 0));
        // Define the transparency colour for the export GIF
        if ($transparent_index >= 0) { $transparency_colour = @imagecolorsforindex($source_link, $transparent_index); }
        else { $transparency_colour = array('red' => 0, 'green' => 0, 'blue' => 0); }
        // Create the new transparency_index2 for the export and allocate it
        $transparent_index2 = @imagecolorallocate($export_object, $transparency_colour['red'], $transparency_colour['green'], $transparency_colour['blue']);
        // Copy the pallet from the source image to the export object
        @imagepalettecopy($source_link, $export_object);
        // Fill the background with the transparent index
        @imagefill($export_object, 0, 0, $transparent_index2);
        // Set the transparent colour on the destination image
        @imagecolortransparent($export_object, $transparent_index2);
        // Convert the export object to a pallet-based image
        @imagetruecolortopalette($export_object, true, 256);
      endif;
    endif;
    // Now, finally, copy the source image over into the export object
    @imagecopyresampled($export_object, $source_link, $export_x, $export_y, $source_x, $source_y, $export_width, $export_height, $source_width, $source_height);
    // Attempt to destroy the image objects from memory
    @imagedestroy($source_link);
    unset($source_link);
    // And now to export the image in the requested format
    if ($export_type['ID'] == 'JPG') { $success = imagejpeg($export_object, $export_path, 100); }
    elseif ($export_type['ID'] == 'PNG') { $success = imagepng($export_object, $export_path, 0); }
    elseif ($export_type['ID'] == 'GIF') { $success = imagegif($export_object, $export_path); }
    // Attempt to destroy the image objects from memory
    @imagedestroy($export_object);
    unset($export_object);
    // Attempt to destroy any other objects that might be taking extra memory
    unset($options, $filters);
    // Return the success flag on completion
    return $success;
  }
  
  // Define a function for generating an image index
  public function image_index($token, $config, $attributes = array(), $options = array()){
    // Define allowable values for mandatory fields
    $allowed_types = array('JPG', 'PNG', 'GIF');
    // Ensure the token is a valid string without spaces
    if (!is_string($token)){ $this->message("[[plutocms_core::image_index]] : Provided token is not a string.", PLUTOCMS_ERROR); return false; }
    elseif (strstr($token, ' ')){ $this->message("[[plutocms_core::image_index]] : Provided token contains illegal spaces.", PLUTOCMS_ERROR); return false; }
    // Ensure necessary fields are included in the CONFIG
    if (!isset($config['ROOTDIR']) || !is_string($config['ROOTDIR'])){ $this->message("[[plutocms_core::image_index]] : Configuration field <<ROOTDIR>> was not provided.", PLUTOCMS_ERROR); return false; }
    elseif (!isset($config['ROOTURL']) || !is_string($config['ROOTURL'])){ $this->message("[[plutocms_core::image_index]] : Configuration field <<ROOTURL>> was not provided.", PLUTOCMS_ERROR); return false; }
    elseif (!isset($config['INDEX']) || !is_array($config['INDEX'])){ $this->message("[[plutocms_core::image_index]] : Configuration field <<INDEX>> was not provided.", PLUTOCMS_ERROR); return false; }
    // Ensure the attributes are in array format, else define default array()
    if (!is_array($attributes)){ $this->message("[[plutocms_core::image_index]] : Provided attributes were not in array format.", PLUTOCMS_WARNING); $attributes = array(); }
    // Ensure the options are in array format, else define default
    if (!is_array($options)){ $this->message("[[plutocms_core::image_index]] : Provided options were not in array format.", PLUTOCMS_WARNING); $options = array(); }
    // Define any attribute defaults if not set
    $attributes['alt'] = isset($attributes['alt']) ? $attributes['alt'] : '';
    // Define any option defaults if not set
    $options['width'] = $this->filter_to_default((isset($options['width']) ? $options['width'] : true), array(true, false));
    $options['height'] = $this->filter_to_default((isset($options['height']) ? $options['height'] : true), array(true, false));
    // Define the image index container to populate
    $index = array();
    // Loop through all the config INDEX fields
    foreach ($config['INDEX'] AS $key => $imageinfo){
      // Compensate for missing fields by providing defaults
      $imageinfo['width'] = isset($imageinfo['width']) ? $imageinfo['width'] : 'auto';
      $imageinfo['height'] = isset($imageinfo['height']) ? $imageinfo['height'] : 'auto';
      $imageinfo['type'] = $this->filter_to_default((isset($imageinfo['type']) ? $imageinfo['type'] : ''), $allowed_types);
      $imageinfo['before'] = isset($imageinfo['before']) ? $imageinfo['before'] : '';
      $imageinfo['after'] = isset($imageinfo['after']) ? $imageinfo['after'] : '';
      $imageinfo['options'] = isset($imageinfo['options']) ? $imageinfo['options'] : false;
      $imageinfo['filters'] = isset($imageinfo['filters']) ? $imageinfo['filters'] : false;
      // Attempt to fix configuration logic errors
      if ($imageinfo['width'] == 'auto' && $imageinfo['height'] == 'auto') { $imageinfo['width'] = $imageinfo['height'] = 'full'; }
      if ($imageinfo['width'] == 'full' && is_numeric($imageinfo['height'])) { $imageinfo['width'] == 'auto'; }
      elseif ($imageinfo['height'] == 'full' && is_numeric($imageinfo['width'])) { $imageinfo['height'] == 'auto'; }
      // Define the container for this particular image index
      $this_index = array();
      // Define the image index fields
      $this_index['token'] = $key;
      $this_index['filters'] = $imageinfo['filters'];
      $this_index['width'] = $imageinfo['width'];
      $this_index['height'] = $imageinfo['height'];
      $this_index['xwidth'] = false;
      $this_index['xheight'] = false;
      $this_index['options'] = array();
      $this_index['size'] = '';
      $this_index['markup'] = '';
      $this_index['type'] = isset($this->FILETYPES[$imageinfo['type']]) ? $this->FILETYPES[$imageinfo['type']] : $this->FILETYPES['UNKNOWN'];
      $this_index['name'] = "{$imageinfo['before']}{$token}{$imageinfo['after']}.{$this_index['type']['EXTENSION']}";
      $this_index['dir'] = "{$config['ROOTDIR']}{$this_index['name']}";
      $this_index['url'] = "{$config['ROOTURL']}{$this_index['name']}";
      $this_index['exists'] = file_exists($this_index['dir']);
      // If the image exists, update the xwidth and xheight
      if ($this_index['exists']){ list($this_index['xwidth'], $this_index['xheight']) = getimagesize($this_index['dir']); }
      // Update the size text field
      if (is_numeric($imageinfo['width']) && is_numeric($imageinfo['height'])){ $this_index['size'] = "{$imageinfo['width']}px by {$imageinfo['height']}px"; }
      elseif ($imageinfo['width'] == 'full' && $imageinfo['height'] == 'full'){ $this_index['size'] = 'Fullsize'; }
      elseif ($this_index['xwidth'] && $this_index['xheight']){ $this_index['size'] = "{$this_index['xwidth']}px by {$this_index['xheight']}px"; }
      else { $this_index['size'] = 'Auto'; }
      // Collect and reformat any options into associative arrays
      if (is_array($imageinfo['options'])): foreach ($imageinfo['options'] AS $option => $value):
        if (is_string($option)) { $this_index['options'][$option] = $value; }
      endforeach; endif;
      if (is_array($options)): foreach ($options AS $option => $value):
        if (is_string($option)) { $options[$option] = $value; }
      endforeach; endif;
      // Create the image markup based on all collected information
      $this_index['markup'] .= "<img ";
      $this_index['markup'] .= "src=\"{$this_index['url']}\" ";
      if ($options['width'] && !isset($attributes['width'])) { $this_index['markup'] .= "width=\"".(is_numeric($this_index['width']) ? $this_index['width'] : '')."\" "; }
      if ($options['height'] && !isset($attributes['height'])) { $this_index['markup'] .= "height=\"".(is_numeric($this_index['height']) ? $this_index['height'] : '')."\" "; }
      foreach ($attributes AS $name => $value){ $this_index['markup'] .= "{$name}=\"{$value}\" "; }
      $this_index['markup'] .= "/>";
      // Add this index to the overall image index
      $index[$key] = $this_index;
    }
    // Return the completed image index
    return $index;
  }
  
  // Define a function for automatically exporting an image based on an imageindex
  public function image_export($source_path, $image_index, $source_filename = false, $delete_existing = true){
    // Define allowable values for mandatory fields
    $allowed_types = array('JPG', 'PNG', 'GIF');
    // Ensure the source_path is a valid string without spaces
    if (!is_string($source_path)){ $this->message("[[plutocms_core::image_export]] : Provided source path is not a string.", PLUTOCMS_ERROR); return false; }
    elseif (!file_exists($source_path) || is_dir($source_path)){ $this->message("[[plutocms_core::image_export]] : Provided source path does not point to a valid image resource.", PLUTOCMS_ERROR); return false; }
    // Attempt to determine the filename if it was not provided
    if (!is_string($source_filename) || empty($source_filename)){
      preg_match('/([^\/])+$/i', str_replace('\\', '/', $source_path), $matches);
      $source_filename = is_array($matches) ? $matches[0] : false;
    }
    // Collect the filetype for this image file
    $source_type = $this->filetype($source_path, $source_filename);
    // Ensure the source file is of the correct type
    if (!in_array($source_type['ID'], $allowed_types)){ $this->message("[[plutocms_core::image_export]] : Provided source image is not a valid file type - expected ".implode(' or ', $allowed_types)." but found {$source_type['ID']}.", PLUTOCMS_ERROR); return false; }
    // Attempt to collect the source width & height
    list($source_width, $source_height) = getimagesize($source_path);
    // Ensure the collected width and height are numeric
    if (!is_numeric($source_width) || !is_numeric($source_height)) { $this->message("[[plutocms_core::image_export]] : The source image&apos;s width and height could not be defined.", PLUTOCMS_ERROR); return false; }
    // Ensure the image_index is a valid array with at least one element
    if (!is_array($image_index) || empty($image_index)){ $this->message("[[plutocms_core::image_export]] : Provided image index is not a valid array.", PLUTOCMS_ERROR); return false; }
    // Create the success counter to count the number of successful exports
    $success = 0;
    // Now loop through each image in the index and attempt to export it
    foreach ($image_index AS $token => $imageinfo){
      // If the destination path exists, either delete or backup the existing file
      if (file_exists($imageinfo['dir']) && $delete_existing){ @unlink($imageinfo['dir']); }
      elseif (file_exists($imageinfo['dir']) && !$delete_existing){ @rename($imageinfo['dir'], $imageinfo['dir'].'.bak.'.time()); }
      // Decide what the final export sizes should be
      if ($imageinfo['width'] == 'full'){ $imageinfo['width'] = $source_width; }
      if ($imageinfo['height'] == 'full'){ $imageinfo['height'] = $source_height; }
      $export_width = is_numeric($imageinfo['width']) ? $imageinfo['width'] : $this->image_autowidth($source_width, $source_height, $imageinfo['height']);
      $export_height = is_numeric($imageinfo['height']) ? $imageinfo['height'] : $this->image_autoheight($source_width, $source_height, $imageinfo['width']);
      // Now attempt to export the image with the provided info
      $exported = $this->image_create($source_path, $imageinfo['dir'], $imageinfo['type'], $export_width, $export_height, $imageinfo['options'], $imageinfo['filters']);
      // If the export was successful, increment the success counter
      if ($exported){ $success++; }
    }
    // Return the success counter
    return $success;
  }
  
  // Define a function for automatically determining width given all other values
  public function image_autowidth($source_width, $source_height, $new_height){
    // Ensure all width/height values are numeric
    if (!is_numeric($source_width) || !is_numeric($source_height) || !is_numeric($new_height)){
      $this->message("[[plutocms_core::image_autowidth]] : One or more arguments were of invalid type ({$source_width}, {$source_height}, {$new_height}).", PLUTOCMS_ERROR);
      return false;
    }
    // Calculate the new width using the same aspect ratio
    $new_width = ceil(($source_width * $new_height) / $source_height);
    // Return the new width
    return $new_width;
  }
  
  // Define a function for automatically determining height given all other values
  public function image_autoheight($source_width, $source_height, $new_width){
    // Ensure all width/height values are numeric
    if (!is_numeric($source_width) || !is_numeric($source_height) || !is_numeric($new_width)){
      $this->message("[[plutocms_core::image_autoheight]] : One or more arguments were of invalid type ({$source_width}, {$source_height}, {$new_width}).", PLUTOCMS_ERROR);
      return false;
    }
    // Calculate the new height using the same aspect ratio
    $new_height = ceil(($source_height * $new_width) / $source_width);
    // Return the new height
    return $new_height;
  }
  
  
  /*
   * FILE ACCESS/MANIPULATION FEATURES
   */
  
  // Define a function for pulling or defining file types
  public function filetypes(){
    // Collect any arguments passed to the function
    $args = func_get_args();
    $args_count = is_array($args) ? count($args) : 0;
    // If there were no arguments provided, return the entire FILETYPES array
    if (!$args_count){
      return $this->FILETYPES;
    }
    // Else if there was a single array provided, loop through collecting types
    elseif ($args_count == 1 && is_array($args[0])){
      // Loop through each entry and add the type to the FILETYPES array
      foreach ($args[0] AS $type){
        // Pull the details of the item
        $type['ID'] = isset($type[0]) ? $type[0] : '';
        $type['MIME'] = isset($type[1]) ? $type[1] : '';
        $type['EXTENSION'] = isset($type[2]) ? $type[2] : '';
        // If the type ID is empty, continue
        if (empty($type['ID'])) { continue; }
        // Add this type to the FILETYPES array
        $this->FILETYPES[$type['ID']] = $type;
      }
    }
    // Else if there are 1-3 arguments of string, string, and string types
    elseif ($args_count >= 1 && $args_count <= 3){
      // Pull the details of the item
      $type = array();
      $type['ID'] = isset($type[0]) ? $type[0] : '';
      $type['MIME'] = isset($type[1]) ? $type[1] : '';
      $type['EXTENSION'] = isset($type[2]) ? $type[2] : '';
      // If the type ID is empty, break
      if (empty($type['ID'])){
        $this->message("[[plutocms_core::filetypes]] : A file type identifier was not provided.", PLUTOCMS_ERROR);
        return false;
      }
      // Add this type to the FILETYPES array
      $this->FILETYPES[$type['ID']] = $type;
    }
    // Otherwise, this is an invalid call and should return false
    else {
      $this->message("[[plutocms_core::filetypes]] : An invalid number of arguments was provided.", PLUTOCMS_NOTICE);
      return false;
    }
  }
  
  // Define a function for determining a given file's type
  public function filetype($file_path, $file_name = ''){
    // If the file path is empty, skip
    if (empty($file_path)){
      $this->message("[[plutocms_core::filetype]] : No file path was specified.", PLUTOCMS_ERROR);
      return false;
    }
    // Check to make sure the file exists
    elseif (!file_exists($file_path)){
      $this->message("[[plutocms_core::filetype]] : The file path <<{$file_path}>> does not exist.", PLUTOCMS_ERROR);
      return false;
    }
    // Check to make sure the file is NOT a directory
    elseif (is_dir($file_path)){
      $this->message("[[plutocms_core::filetype]] : The file path <<{$file_path}>> is not a file.", PLUTOCMS_ERROR);
      return false;
    }
    // Check if the filetype is an image
    if (list($width, $height, $type) = @getimagesize($file_path)){
      if ($type == IMAGETYPE_JPEG) { return $this->FILETYPES['JPG']; }
      elseif ($type == IMAGETYPE_GIF) { return $this->FILETYPES['GIF']; }
      elseif ($type == IMAGETYPE_PNG) { return $this->FILETYPES['PNG']; }
      elseif ($type == IMAGETYPE_BMP) { return $this->FILETYPES['BMP']; }
      elseif ($type == IMAGETYPE_WBMP) { return $this->FILETYPES['WBMP']; }
      elseif (defined('IMAGETYPE_ICO') && $type == IMAGETYPE_ICO) { return $this->FILETYPES['ICO']; }
      elseif ($type == IMAGETYPE_TIFF_II || $type == IMAGETYPE_TIFF_MM) { return $this->FILETYPES['TIFF']; }
      elseif ($type == IMAGETYPE_JPEG2000) { return $this->FILETYPES['JP2']; }
      elseif ($type == IMAGETYPE_SWF) { return $this->FILETYPES['SWF']; }
      elseif ($type == IMAGETYPE_PSD) { return $this->FILETYPES['PSD']; }
    }
    // Convert the filename to lowercase for extension analyzing
    preg_match('#/?([^/\\\]+)$#i', $file_path, $matches);
    $file_name = !empty($file_name) ? strtolower($file_name) : strtolower($matches[1]);
    // Check if document-type
    if (preg_match('#(.txt)$#i', $file_name)) { return $this->FILETYPES['TXT']; }
    elseif (preg_match('#(.rtf|.rt)$#i', $file_name)) { return $this->FILETYPES['RTF']; }
    elseif (preg_match('#(.doc)$#i', $file_name)) { return $this->FILETYPES['DOC']; }
    elseif (preg_match('#(.pdf)$#i', $file_name)) { return $this->FILETYPES['PDF']; }
    elseif (preg_match('#(.htm|.html|.htmlx)$#i', $file_name)) { return $this->FILETYPES['HTML']; }
    elseif (preg_match('#(.shtml|.shtm|.htmls)$#i', $file_name)) { return $this->FILETYPES['SHTML']; }
    elseif (preg_match('#(.css)$#i', $file_name)) { return $this->FILETYPES['CSS']; }
    elseif (preg_match('#(.js)$#i', $file_name)) { return $this->FILETYPES['JS']; }
    elseif (preg_match('#(.text)$#i', $file_name)) { return $this->FILETYPES['TEXT']; }
    elseif (preg_match('#(.xml)$#i', $file_name)) { return $this->FILETYPES['XML']; }
    elseif (preg_match('#(.log)$#i', $file_name)) { return $this->FILETYPES['LOG']; }
    elseif (preg_match('#(.php)$#i', $file_name)) { return $this->FILETYPES['PHP']; }
    elseif (preg_match('#(.asp)$#i', $file_name)) { return $this->FILETYPES['ASP']; }
    elseif (preg_match('#(.xls)$#i', $file_name)) { return $this->FILETYPES['XLS']; }
    // Check if uncaught image type
    elseif (preg_match('#(.jpg|.jpeg)$#i', $file_name)) { return $this->FILETYPES['JPG']; }
    elseif (preg_match('#(.gif)$#i', $file_name)) { return $this->FILETYPES['GIF']; }
    elseif (preg_match('#(.png)$#i', $file_name)) { return $this->FILETYPES['PNG']; }
    elseif (preg_match('#(.bmp)$#i', $file_name)) { return $this->FILETYPES['BMP']; }
    elseif (preg_match('#(.wbmp)$#i', $file_name)) { return $this->FILETYPES['WBMP']; }
    elseif (preg_match('#(.ico)$#i', $file_name)) { return $this->FILETYPES['ICO']; }
    elseif (preg_match('#(.tiff|.tif)$#i', $file_name)) { return $this->FILETYPES['TIFF']; }
    elseif (preg_match('#(.jp2|.jpg2|.jpeg2)$#i', $file_name)) { return $this->FILETYPES['JP2']; }
    elseif (preg_match('#(.swf)$#i', $file_name)) { return $this->FILETYPES['SWF']; }
    elseif (preg_match('#(.psd)$#i', $file_name)) { return $this->FILETYPES['PSD']; }
    // Check if audio-type
    elseif (preg_match('#(.mp3)$#i', $file_name)) { return $this->FILETYPES['MP3']; }
    elseif (preg_match('#(.wav)$#i', $file_name)) { return $this->FILETYPES['WAV']; }
    elseif (preg_match('#(.ogg)$#i', $file_name)) { return $this->FILETYPES['OGG']; }
    elseif (preg_match('#(.mid|.midi)$#i', $file_name)) { return $this->FILETYPES['MIDI']; }
    elseif (preg_match('#(.mp2)$#i', $file_name)) { return $this->FILETYPES['MP2']; }
    // Check if video type
    elseif (preg_match('#(.avi)$#i', $file_name)) { return $this->FILETYPES['AVI']; }
    elseif (preg_match('#(.mov)$#i', $file_name)) { return $this->FILETYPES['MOV']; }
    elseif (preg_match('#(.mpg)$#i', $file_name)) { return $this->FILETYPES['MPG']; }
    elseif (preg_match('#(.mpeg)$#i', $file_name)) { return $this->FILETYPES['MPEG']; }
    elseif (preg_match('#(.mp4)$#i', $file_name)) { return $this->FILETYPES['MP4']; }
    elseif (preg_match('#(.flv)$#i', $file_name)) { return $this->FILETYPES['FLV']; }
    // Check a few random others
    elseif (preg_match('#(.zip)$#i', $file_name)) { return $this->FILETYPES['ZIP']; }
    elseif (preg_match('#(.rar)$#i', $file_name)) { return $this->FILETYPES['RAR']; }
    // Otherwise, return 'unknown'
    else { return $this->FILETYPES['UNKNOWN']; }
  }
  
  /*
   * THEME HANDLER FUNCTIONS
   */
  
  // Define a function for parsing theme variables out of a given block of markup
  public function parse_theme($markup, $theme, $theme_key = 'default'){
    // Pull the PALLET, IMAGES, CMSVARS, and CMSFLAGS indexes from the $theme array
    $PALLET = isset($theme['PALLET']) ? $theme['PALLET'] : array();
    $IMAGES = isset($theme['IMAGES']) ? $theme['IMAGES'] : array();
    $CMSVARS = isset($theme['CMSVARS']) ? $theme['CMSVARS'] : array();
    $CMSFLAGS = isset($theme['CMSFLAGS']) ? $theme['CMSFLAGS'] : array();
    // Define commonly-used CMS vars if they are not defined
    if (!isset($CMSVARS['current_time'])){ $CMSVARS['current_time'] = time(); }
    if (!isset($CMSVARS['rootdir'])){ $CMSVARS['rootdir'] = $this->ROOTDIR; }
    if (!isset($CMSVARS['rooturl'])){ $CMSVARS['rooturl'] = $this->ROOTURL; }
    if (!isset($CMSVARS['admindir'])){ $CMSVARS['admindir'] = $this->ADMINDIR; }
    if (!isset($CMSVARS['adminurl'])){ $CMSVARS['adminurl'] = $this->ADMINURL; }
    if (!isset($CMSVARS['moduledir'])){ $CMSVARS['moduledir'] = $this->MODULEDIR; }
    if (!isset($CMSVARS['moduleurl'])){ $CMSVARS['moduleurl'] = $this->MODULEURL; }
    if (!isset($CMSVARS['extensiondir'])){ $CMSVARS['extensiondir'] = $this->EXTENSIONDIR; }
    if (!isset($CMSVARS['extensionurl'])){ $CMSVARS['extensionurl'] = $this->EXTENSIONURL; }
    if (!isset($CMSVARS['contentdir'])){ $CMSVARS['contenturl'] = $this->CONTENTDIR; }
    if (!isset($CMSVARS['contenturl'])){ $CMSVARS['themeurl'] = $this->CONTENTURL; }
    if (!isset($CMSVARS['themedir'])){ $CMSVARS['themedir'] = $this->THEMEDIR; }
    if (!isset($CMSVARS['themeurl'])){ $CMSVARS['themeurl'] = $this->THEMEURL; }
    if (!isset($CMSVARS['logicdir'])){ $CMSVARS['logicdir'] = $this->LOGICDIR; }
    if (!isset($CMSVARS['logicurl'])){ $CMSVARS['logicurl'] = $this->LOGICURL; }
    // Replace all the short-tags in the $markup with full PHP code
    $markup = preg_replace('#<pallets?:([-_a-z0-9]+)>#i', '<?= isset($PALLET[\'$1\']) ? $PALLET[\'$1\'] : \'auto\' ?>', $markup);
    $markup = preg_replace('#<images?:([-_a-z0-9]+)>#i', '<?= isset($IMAGES[\'$1\']) ? $IMAGES[\'$1\'] : \'auto\' ?>', $markup);
    $markup = preg_replace('#<cmsvars?:([-_a-z0-9]+)>#i', '<?= isset($CMSVARS[\'$1\']) ? $CMSVARS[\'$1\'] : \'<cmsvars:$1>\' ?>', $markup);
    // Now re-evaluate the markup, collecting the contents of the buffer
    ob_start();
    eval('?>'.$markup.'<?');
    $markup = ob_get_clean();
    // Now to run a second pass, replacing all logic short-tags with full PHP code
    $markup = preg_replace('#<cmsflags?:endif>#i', '<? endif; ?>', $markup);
    $markup = preg_replace('#<cmsflags?:else>#i', '<? else : ?>', $markup);
    $markup = preg_replace('#<cmsflags?:elseif:!([-_a-z0-9]+?)>#i', '<? elseif (!isset($CMSFLAGS[\'$1\']) || !$CMSFLAGS[\'$1\']): ?>', $markup);
    $markup = preg_replace('#<cmsflags?:elseif:([-_a-z0-9]+?)>#i', '<? elseif (isset($CMSFLAGS[\'$1\']) && $CMSFLAGS[\'$1\']): ?>', $markup);
    $markup = preg_replace('#<cmsflags?:!([-_a-z0-9]+?)>#i', '<? if (!isset($CMSFLAGS[\'$1\']) || !$CMSFLAGS[\'$1\']): ?>', $markup);
    $markup = preg_replace('#<cmsflags?:([-_a-z0-9]+?)>#i', '<? if (isset($CMSFLAGS[\'$1\']) && $CMSFLAGS[\'$1\']): ?>', $markup);
    // Now re-evaluate the markup with logical operators, collecting the contents of the buffer
    ob_start();
    eval('?>'.$markup.'<?');
    $markup = ob_get_clean();
    // Return the new markup
    return $markup;
  }
  
  /*
   * CONTENT TYPE FUNCTIONS
   */
  
  // Define a function for easily switching the content-type to that of an HTML document
  public function header_html($cache_time = 0, $attachment = false){
    // Update the page headers for text/html
    header("Content-type: text/html; charset=UTF-8");
    header("Expires: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Cache-control: public, max-age={$cache_time}, must-revalidate");
    header("Pragma: cache");
    // If the $attachment field is not false, set this as an attachment
    if (!empty($attachment) && is_string($attachment)){
      header("Content-Disposition: attachment; filename={$attachment}");
    }
    // Return true
    return true;
  }
  
  // Define a function for easily switching the content-type to that of a JS document
  public function header_js($cache_time = 0, $attachment = false){
    // Update the page headers for text/js
    header("Content-type: text/javascript; charset=UTF-8");
    header("Expires: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Cache-control: public, max-age={$cache_time}, must-revalidate");
    header("Pragma: cache");
    // If the $attachment field is not false, set this as an attachment
    if (!empty($attachment) && is_string($attachment)){
      header("Content-Disposition: attachment; filename={$attachment}");
    }
    // Return true
    return true;
  }

  // Define a function for easily switching the content-type to that of a CSS document
  public function header_css($cache_time = 0, $attachment = false){
    // Update the page headers for text/css
    header("Content-type: text/css; charset=UTF-8");
    header("Expires: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Cache-control: public, max-age={$cache_time}, must-revalidate");
    header("Pragma: cache");
    // If the $attachment field is not false, set this as an attachment
    if (!empty($attachment) && is_string($attachment)){
      header("Content-Disposition: attachment; filename={$attachment}");
    }
    // Return true
    return true;
  }
  
  // Define a function for easily switching the content-type to that of an XML document
  public function header_xml($cache_time = 0, $attachment = false){
    // Update the page headers for text/xml
    header("Content-type: text/xml; charset=UTF-8");
    header("Expires: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Cache-control: public, max-age={$cache_time}, must-revalidate");
    header("Pragma: cache");
    // If the $attachment field is not false, set this as an attachment
    if (!empty($attachment) && is_string($attachment)){
      header("Content-Disposition: attachment; filename={$attachment}");
    }
    // Return true
    return true;
  }

  // Define a function for easily switching the content-type to that of a TXT document
  public function header_txt($cache_time = 0, $attachment = false){
    // Update the page headers for text/html
    header("Content-type: text/plain; charset=UTF-8");
    header("Expires: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Cache-control: public, max-age={$cache_time}, must-revalidate");
    header("Pragma: cache");
    // If the $attachment field is not false, set this as an attachment
    if (!empty($attachment) && is_string($attachment)){
      header("Content-Disposition: attachment; filename={$attachment}");
    }
    // Return true
    return true;
  }
  
  // Define a function for easily switching the content-type to that of a CSV document
  public function header_csv($cache_time = 0, $attachment = false){
    // Update the page headers for text/html
    header("Content-type: text/csv; charset=UTF-8");
    header("Expires: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s", (time()+$cache_time)) . " GMT");
    header("Cache-control: public, max-age={$cache_time}, must-revalidate");
    header("Pragma: cache");
    // If the $attachment field is not false, set this as an attachment
    if (!empty($attachment) && is_string($attachment)){
      header("Content-Disposition: attachment; filename={$attachment}");
    }
    // Return true
    return true;
  }
  
  /*
   * MISC FUNCTIONS
   */
  
  // Define a function for printing out a variable's contents in a preformatted fashion
  public function printvar($value, $variable_name = 'myvariable', $container_style = '', $header_style = '', $content_style = ''){
    $variable_name = trim($variable_name, '$');
    $block = '';
    $block .= "<pre class=\"printvar\" style=\"{$container_style}\">";
    $block .= "<h1 class=\"label\" style=\"{$header_style}\">\${$variable_name}</h1>";
    $block .= "<div class=\"dump\" style=\"{$content_style}\">";
    $block .= trim(str_replace(' ', '&nbsp;', $this->htmlentity_encode(print_r($value, true))));
    $block .= "</div>";
    $block .= "</pre>";
    return $block;
  }
  
  // Define a function for filtering a value and returning allowable values
  public function filter_to_default($current_value, $allowed_values){
    // Ensure the $allowed_values is an array
    if (!is_array($allowed_values)){ $this->message("[[plutocms_core::filter_to_default]] : The allowed values was empty or of invalid type.", PLUTOCMS_ERROR); return false; }
    // If the $current_value is in the $allowed_values, let it pass
    if (in_array($current_value, $allowed_values)){ return $current_value; }
    // Otherwise, return the first key of $allowed_values
    else { return $allowed_values[0]; }
  }
  
  // Define a function for forcing a value to boolean
  public function force_boolean($value){
    // Convert the value to lowercase for easier comparrisons
    if (is_string($value)){ $value = strtolower($value); }
    // If the value is anything that could evaluate to true, return true
    if ($value === true || $value === 1 || $value === 'true' || $value === 'yes' || $value === '1'){
      return true;
    }
    // Else if the value is anything that could evaluate to false, return false
    elseif ($value === false || $value === 0 || $value === 'false' || $value === 'no' || $value === '0'){
      return false;
    }
    // Otherwise let PHP decide what the value evaluates to
    else {
      return ($value ? true : false);
    }
  }
  
  // Define a function for encoding variables into JSON format
  public function json($a = false){
    if (is_null($a)){ return 'null'; }
    if ($a === false){ return 'false'; }
    if ($a === true){ return 'true'; }
    if (is_scalar($a)){
      if (is_float($a)){
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }
      if (is_string($a)){
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else {
        return $a;
      }
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a)){
      if (key($a) !== $i){
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList){
      foreach ($a as $v) $result[] = $this->json($v);
      return '[' . join(',', $result) . ']';
    }
    else{
      foreach ($a as $k => $v) $result[] = $this->json($k).':'.$this->json($v);
      return '{' . join(',', $result) . '}';
    }
  }
  
  // Define a function for checking if an email address is valid format
  public function valid_email($email){
    $qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
    $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
    $atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
    $quoted_pair = '\\x5c[\\x00-\\x7f]';
    $domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
    $quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
    $domain_ref = $atom;
    $sub_domain = "($domain_ref|$domain_literal)";
    $word = "($atom|$quoted_string)";
    $domain = "$sub_domain(\\x2e$sub_domain)*";
    $local_part = "$word(\\x2e$word)*";
    $addr_spec = "$local_part\\x40$domain";
    return preg_match("!^$addr_spec$!", $email) ? true : false;
  }
  
  // Define a function for finding a person's age given their date of birth
  public function calculate_age($date_of_birth){
    // Explode the date into meaningful variables
    if (preg_match('#^([0-9]{2,4})/([0-9]{1,2})/([0-9]{1,2})$#i', $date_of_birth)){
      list($birth_year, $birth_month, $birth_day) = explode('/', $date_of_birth);
    } elseif (is_numeric($date_of_birth)) {
      list($birth_year, $birth_month, $birth_day) = explode('/', date('Y/m/d', $date_of_birth));
    } else {
      return false;
    }
    // Calculate the differences from the current date/time
    $year_diff = date('Y') - $birth_year;
    $month_diff = date('m') - $birth_month;
    $day_diff = date('n') - $birth_day;
    // If the birthday has not occured this year, decrement the $year_diff
    if ($month_diff < 0 || ($month_diff == 0 && $day_diff < 0)){
      $year_diff--;
    }
    // Return the final $year_diff
    return $year_diff;
  }
  
  // Define a function for converting latitude/longitude to decimal
  public function latlong_to_decimal($degrees, $minutes, $seconds, $direction, $decimals = 10){
    if (!is_numeric($degrees)){ $this->message("[[plutocms_core::latlong_to_decimal]] : The provided degree value was not numeric.", PLUTOCMS_ERROR); return false; }
    if (!is_numeric($minutes)){ $this->message("[[plutocms_core::latlong_to_decimal]] : The provided minute value was not numeric.", PLUTOCMS_ERROR); return false; }
    if (!is_numeric($seconds)){ $this->message("[[plutocms_core::latlong_to_decimal]] : The provided second value was not numeric.", PLUTOCMS_ERROR); return false; }
    if (!in_array($direction, array(PLUTOCMS_NORTH, PLUTOCMS_SOUTH, PLUTOCMS_EAST, PLUTOCMS_WEST))){ $this->message("[[plutocms_core::latlong_to_decimal]] : The provided direction value was not valid.", PLUTOCMS_ERROR); return false; }
    if (!is_numeric($decimals)){ $this->message("[[plutocms_core::latlong_to_decimal]] : The provided decimal value was not numeric.", PLUTOCMS_ERROR); return false; }
    $value = round((((($degrees * 60 * 60) + ($minutes * 60) + ($seconds)) / 60) / 60), $decimals);
    if ($direction == 'S' || $direction == 'W') { $value = $value * -1; }
    return $value;
  }
  public function latitude_to_decimal($degrees, $minutes, $seconds, $direction, $decimals = 10){
    return $this->latlong_to_decimal($degrees, $minutes, $seconds, $direction, $decimals);
  }
  public function longitude_to_decimal($degrees, $minutes, $seconds, $direction, $decimals = 10){
    return $this->latlong_to_decimal($degrees, $minutes, $seconds, $direction, $decimals);
  }
  
  // Define a function converting a latitude/longitude decimal to an associative array
  public function latlong_to_array($decimal, $latlong, $percision = 10){
    // If any essential values are missing, return false
    if (!is_numeric($decimal)) { $this->message("[[plutocms_core::latlong_to_decimal]] : The provided decimal value was not numeric.", PLUTOCMS_ERROR); return false; }
    if ($latlong != PLUTOCMS_LATITUDE && $latlong != PLUTOCMS_LONGITUDE) { $this->message("[[plutocms_core::latlong_to_decimal]] : The provided latitude/longitude value was not valid.", PLUTOCMS_ERROR); return false; }
    // Correct missing/invalid arguments
    if (!is_numeric($percision)) { $percision = 10; }
    // Convert decimal to total seconds
    $total_seconds = ($decimal < 0 ? $decimal * -1 : $decimal) * 60 * 60;
    // Pull the individual hours, minutes, and seconds
    $hours = floor($total_seconds / 60 / 60);
    $minutes = floor(($total_seconds - ($hours * 60 * 60)) / 60);
    $seconds = round(($total_seconds - ($hours * 60 * 60) - ($minutes * 60)), $percision);
    // Determine the direction
    $direction = false;
    if ($decimal > 0 && $latlong == PLUTOCMS_LATITUDE) { $direction = PLUTOCMS_NORTH; }
    elseif ($decimal < 0 && $latlong == PLUTOCMS_LATITUDE) { $direction = PLUTOCMS_SOUTH; }
    elseif ($decimal > 0 && $latlong == PLUTOCMS_LONGITUDE) { $direction = PLUTOCMS_EAST; }
    elseif ($decimal < 0 && $latlong == PLUTOCMS_LONGITUDE) { $direction = PLUTOCMS_WEST; }
    // Create the associative array
    $latlong_array = array();
    $latlong_array[0] = $latlong_array['hours'] = $hours;
    $latlong_array[1] = $latlong_array['minutes'] = $minutes;
    $latlong_array[2] = $latlong_array['seconds'] = $seconds;
    $latlong_array[3] = $latlong_array['direction'] = $direction;
    // Return the array
    return $latlong_array;
  }
  public function latitude_to_array($decimal, $percision = 10){
    return $this->latlong_to_array($decimal, PLUTOCMS_LATITUDE, $percision);
  }
  public function longitude_to_array($decimal, $percision = 10){
    return $this->latlong_to_array($decimal, PLUTOCMS_LONGITUDE, $percision);
  }
  
  // Define a function for converting a conditional string into an array
  public function conditions_to_array($condition_string){
    // Ensure this is a non-empty string else return false
    if (!is_string($condition_string) || empty($condition_string)){ return false; }
    // Create the variable to hold the condition array
    $conditions = array();
    // Explode the string into separated conditions
    $blocks = strstr($condition_string, '|') ? explode('|', $condition_string) : array($condition_string);
    // If blocks is empty, return false
    if (empty($blocks)){ return false; }
    // Now loop through each condition block
    foreach ($blocks AS $string){
      // Trim any extra whitespace off the string
      $string = trim($string);
      // If the item does not match the format, skip it
      $matches = array();
      if (!preg_match('/^([-_a-z0-9]+?)(>=|<=|!=|==|\*=|\^=|\$=|=|>|<)(.+?)$/i', $string, $matches)){ continue; }
      // If there were matches, pull them
      $varname = isset($matches[1]) && !empty($matches[1]) ? trim($matches[1]) : false;
      $varoperator = isset($matches[2]) && !empty($matches[2]) ? trim($matches[2]) : false;
      $varvalue = isset($matches[3]) && !empty($matches[3]) ? trim($matches[3]) : false;
      // If any part of the string was false, return
      if ($varname === false || $varoperator === false || $varvalue === false){ continue; }
      // If the operator is a fragment, fill out the default
      if ($varoperator == '='){ $varoperator = '=='; }
      // Now ad the new condition to the conditions array
      $conditions[] = array('name' => $varname, 'operator' => $varoperator, 'value' => $varvalue);
    }
    // Return the completed conditions array
    return $conditions;
  }
  
  // Define a function for converting a condition array back into a string
  public function conditions_to_string($condition_array){
    // Ensure the conditions array is not empty, else return false
    if (!is_array($condition_array) || empty($condition_array)){ return false; }
    // Create the temporary block array to stick condition blocks into
    $blocks = array();
    // Loop through all the conditions and add 'em to the blocks array
    foreach ($condition_array AS $rules){
      // Collect the rule variables
      $name = isset($rules['name']) ? $rules['name'] : false;
      $operator = isset($rules['operator']) ? $rules['operator'] : false;
      $value = isset($rules['value']) ? $rules['value'] : false;
      // If any variables are missing, continue
      if ($name === false || $operator === false || $value === false){ continue; }
      // If the operator is a single equals, fix it
      if ($operator == '='){ $operator = '=='; }
      // If the any of the values are incorrect format, continue
      if (!is_string($name) || !is_string($operator) || (!is_string($value) && !is_numeric($value))
        || !in_array($operator, array('==', '!=', '*=', '>=', '<=', '^=', '$=', '>', '<'))){ continue; }
      // Add these rules to the blocks array
      $blocks[] = "{$name}{$operator}{$value}";
    }
    // Implode the blocks and return the result
    $condition_string = implode('|', $blocks);
    return $condition_string;
  }
  
  // Define a function for comparing a conditional string to a value array
  public function conditions_compare($conditions, $variables, $case_sensitive = false){
    // If the conditions variable is not an array, return false
    if (!is_array($conditions)){ $this->message("[[plutocms_core::conditions_compare]] : The conditions variable must be an array.", PLUTOCMS_ERROR); return false; }
    // If the conditions array is an empty array, however, return true
    elseif (empty($conditions)){ return true; }
    // If the variables variable is not an array OR is empty, return false
    if (!is_array($variables)){ $this->message("[[plutocms_core::conditions_compare]] : The variables variable must be an array.", PLUTOCMS_ERROR); return false; }
    elseif (empty($variables)){ return false; }
    // Loop through each condition to compare
    foreach ($conditions AS $rules){
      // Collect the rule variables
      $name = isset($rules['name']) ? $rules['name'] : false;
      $operator = isset($rules['operator']) ? $rules['operator'] : false;
      $value = isset($rules['value']) ? $rules['value'] : false;
      // If any variables are missing, throw an error and return false
      if ($name === false || $operator === false || $value === false){ $this->message("[[plutocms_core::conditions_compare]] : One or more elements of the conditions array are corrupt and/or missing values.", PLUTOCMS_ERROR); return false; }
      // If the variable does not exist, return false
      if (!isset($variables[$name])){ $this->message("[[plutocms_core::conditions_compare]] : One or more elements in the conditions array do not exist in the variables array ({$name}).", PLUTOCMS_ERROR); return false; }
      // Collect the variable and compare/evaluate its value
      $thisvariable = $variables[$name];
      // If the variable is a boolean string, convert it
      if ($thisvariable === true){ $thisvariable = 'true'; }
      elseif ($thisvariable === false){ $thisvariable = 'false'; }
      // If the variable is an array, throw an error and return false
      if (!is_string($thisvariable) && !is_numeric($thisvariable)){ $this->message("[[plutocms_core::conditions_compare]] : One or more elements in the variables array are not in string format ({$name}).", PLUTOCMS_ERROR); return false; }
      // If we're NOT running a case-sensitive comparrison, convert both values to lower-case
      if (!$case_sensitive){ $value = strtolower($value); $thisvariable = strtolower($thisvariable); }
      // Use the operator as a switch to check the comparrison
      switch ($operator){
        case '>':
          if ($thisvariable > $value){ continue; }
          else { return false; }
          break;
        case '<':
          if ($thisvariable < $value){ continue; }
          else { return false; }
          break;
        case '>=':
          if ($thisvariable >= $value){ continue; }
          else { return false; }
          break;
        case '<=':
          if ($thisvariable <= $value){ continue; }
          else { return false; }
          break;
        case '!=':
          if ($thisvariable != $value){ continue; }
          else { return false; }
          break;
        case '*=':
          if (strstr($thisvariable, $value)){ continue; }
          else { return false; }
          break;
        case '^=':
          if (preg_match('/^('.$value.')/', $thisvariable)){ continue; }
          else { return false; }
          break;
        case '$=':
          if (preg_match('/('.$value.')$/', $thisvariable)){ continue; }
          else { return false; }
          break;
        case '==': default:
          if ($thisvariable == $value){ continue; }
          else { return false; }
          break;
      }
    }
    // Passing all checks means the conditions add-up, so return true
    return true;
  }
  
  // Create a function for parsing an array and converting it to a URL query string
  public function array_to_query($array = NULL, $convention = '%s'){
    if (count($array) == 0){ return ''; }
    else {
      if (function_exists( 'http_build_query' )){
        $query = http_build_query($array);
      }
      else {
        $query = '';
        foreach($array as $key => $value){
          if(is_array($value)){
            $new_convention = sprintf($convention, $key).'[%s]';
            $query .= variable_to_query($value, $new_convention);
          }
          else {
            $key = urlencode($key);
            $value = urlencode($value);
            $query .= sprintf($convention, $key)."=$value&";
          }
        }
      }
      return $query;
    }
  }
  
  // Define a function for converting full-country names into their "common" short forms
  public function country_common_name($country_name){
    // If the country name is empty or not a string, return false
    if (empty($country_name) || !is_string($country_name)){ return false; }
    // Otherwise, define the new country name variable
    $new_country_name = $country_name;
    // And decide if we can replace specific country name, otherwise automate the process
    switch (strtolower($new_country_name)){
      case 'united states of america':
        $new_country_name = 'USA';
        break;
      default:
        if (preg_match('#^(.*?)(of)\s?(the)?\s?(.*?)$#i', $new_country_name)){
          $new_country_name = trim(preg_replace('#^(.*?)(of)\s?(the)?\s?(.*?)$#i', '$4', $new_country_name));
        }
        break;
    }
    // Return the new country name
    return $new_country_name;
  }
  
  // Define a function for merging multidimensional arrays and maintaining key indexes and such
  public function array_multimerge($array1, $array2){
    if (is_array($array2) && count($array2)){
      foreach ($array2 as $k => $v){
        if (is_array($v) && count($v) && isset($array1[$k])){
          $array1[$k] = $this->array_multimerge($array1[$k], $v);
        }
        else {
          $array1[$k] = $v;
        }
      }
    }
    else {
      $array1 = $array2;
    }
    return $array1;
  }
  
  
}
?>