<?
// Default the types index to an empty array
$mmrpg_index['types'] = array();

// Define the cache and index paths for types
$types_index_path = $MMRPG_CONFIG['ROOTDIR'].'data/types/';
$types_cache_path = $MMRPG_CONFIG['ROOTDIR'].'data/cache/'.'cache.types.'.date('Ymd').'.php';

// If caching is turned OFF, or a cache has not been created
if (!$MMRPG_CONFIG['CACHE_INDEXES'] || !file_exists($types_cache_path)){
  
  // Default the types markup index to an empty array
  $types_cache_markup = array();
  
  // Open the type data directory for scanning
  $data_types  = opendir($types_index_path);
  
  // Loop through all the files in the directory
  while (false !== ($filename = readdir($data_types))) {
    
    // Ensure the file matches the naming format
    if (preg_match('#^type\.[-_a-z0-9]+\.php$#i', $filename)){
      
      // Read the file into memory as a string
      $this_type_markup = trim(file_get_contents($types_index_path.$filename));
      // Remove the start and end PHP tags from the string
      if (preg_match('#^<\?\s?$#i', $this_type_markup[0])){ $this_type_markup[0] = ''; }
      // Evaluate the file into the local scope
      eval('?>'.$this_type_markup.'<?');
      
      // If an type array was defined and is not empty
      if (isset($type) && !empty($type)){
        
        // Parse out the generic "type" variable for a specific index
        $this_type_markup = preg_replace('#\$type = array\(#i', "\$mmrpg_index['types']['{$type['type_token']}'] = array(", $this_type_markup);
        // Copy this type's data to the index
        $types_cache_markup[] = $this_type_markup;
        $mmrpg_index['types'][$type['type_token']] = $type;
        // Unset the temporary type array
        unset($type);
        
      }
      
    }
    
  }
  
  // Close the type data directory
  closedir($data_types);
  
  // Implode the markup into a single string
  $types_cache_markup = implode('', $types_cache_markup);
  $types_cache_markup = preg_replace('#\s?\?><\?\s?#i', '', $types_cache_markup);
  
  // If caching is enabled, create the index cache file
  if ($MMRPG_CONFIG['CACHE_INDEXES']){
    // Write the index to a cache file, if caching is enabled
    $types_cache_file = fopen($types_cache_path, 'w');
    fwrite($types_cache_file, $types_cache_markup);
    fclose($types_cache_file);
  }
    
}
// Otherwise, simple include the cache file
else {
  
  // Include the cache file so it can be evaluated
  require_once($types_cache_path);
  
}
?>