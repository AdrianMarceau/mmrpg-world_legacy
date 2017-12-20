<?
// Default the fields index to an empty array
$mmrpg_index['fields'] = array();

// Define the cache and index paths for fields
$fields_index_path = $MMRPG_CONFIG['ROOTDIR'].'data/fields/';
$fields_cache_path = $MMRPG_CONFIG['ROOTDIR'].'data/cache/'.'cache.fields.'.$MMRPG_CONFIG['CACHE_DATE'].'.php';

// If caching is turned OFF, or a cache has not been created
if (!$MMRPG_CONFIG['CACHE_INDEXES'] || !file_exists($fields_cache_path)){
  
  // Default the fields markup index to an empty array
  $fields_cache_markup = array();
  
  // Open the type data directory for scanning
  $data_fields  = opendir($fields_index_path);
  
  // Loop through all the files in the directory
  while (false !== ($filename = readdir($data_fields))) {
    
    // Ensure the file matches the naming format
    if (preg_match('#^field\.[-_a-z0-9]+\.php$#i', $filename)){
      
      // Read the file into memory as a string
      $this_field_markup = trim(file_get_contents($fields_index_path.$filename));
      // Remove the start and end PHP tags from the string
      if (preg_match('#^<\?\s?$#i', $this_field_markup[0])){ $this_field_markup[0] = ''; }
      // Evaluate the file into the local scope
      eval('?>'.$this_field_markup.'<?');
      
      // If an type array was defined and is not empty
      if (isset($field) && !empty($field)){
        
        // Parse out the generic "field" variable for a specific index
        $this_field_markup = preg_replace('#\$field = array\(#i', "\$mmrpg_index['fields']['{$field['field_token']}'] = array(", $this_field_markup);
        // Copy this field's data to the index
        $fields_cache_markup[] = $this_field_markup;
        $mmrpg_index['fields'][$field['field_token']] = $field;
        // Unset the temporary field array
        unset($field);
        
      }
      
    }
    
  }
  
  // Close the field data directory
  closedir($data_fields);
  
  // Implode the markup into a single string
  $fields_cache_markup = implode('', $fields_cache_markup);
  $fields_cache_markup = preg_replace('#\s?\?><\?\s?#i', '', $fields_cache_markup);
  
  // If caching is enabled, create the index cache file
  if ($MMRPG_CONFIG['CACHE_INDEXES']){
    // Write the index to a cache file, if caching is enabled
    $fields_cache_file = fopen($fields_cache_path, 'w');
    fwrite($fields_cache_file, $fields_cache_markup);
    fclose($fields_cache_file);
  }
    
}
// Otherwise, simple include the cache file
else {
  
  // Include the cache file so it can be evaluated
  require_once($fields_cache_path);
  
}
?>