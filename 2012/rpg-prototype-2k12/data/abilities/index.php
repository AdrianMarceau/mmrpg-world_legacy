<?
// Default the abilities index to an empty array
$mmrpg_index['abilities'] = array();

// Define the cache and index paths for abilities
$abilities_index_path = $MMRPG_CONFIG['ROOTDIR'].'data/abilities/';
$abilities_cache_path = $MMRPG_CONFIG['ROOTDIR'].'data/cache/'.'cache.abilities.'.$MMRPG_CONFIG['CACHE_DATE'].'.php';

// If caching is turned OFF, or a cache has not been created
if (!$MMRPG_CONFIG['CACHE_INDEXES'] || !file_exists($abilities_cache_path)){
  
  // Default the abilities markup index to an empty array
  $abilities_cache_markup = array();
  
  // Open the type data directory for scanning
  $data_abilities  = opendir($abilities_index_path);
  
  // Loop through all the files in the directory
  while (false !== ($filename = readdir($data_abilities))) {
    
    // Ensure the file matches the naming format
    if (preg_match('#^ability\.[-_a-z0-9]+\.php$#i', $filename)){
      
      // Read the file into memory as a string
      $this_ability_markup = trim(file_get_contents($abilities_index_path.$filename));
      // Remove the start and end PHP tags from the string
      if (preg_match('#^<\?\s?$#i', $this_ability_markup[0])){ $this_ability_markup[0] = ''; }
      // Evaluate the file into the local scope
      eval('?>'.$this_ability_markup.'<?');
      
      // If an type array was defined and is not empty
      if (isset($ability) && !empty($ability)){
        
        // Parse out the generic "ability" variable for a specific index
        $this_ability_markup = preg_replace('#\$ability = array\(#i', "\$mmrpg_index['abilities']['{$ability['ability_token']}'] = array(", $this_ability_markup);
        // Copy this ability's data to the index
        $abilities_cache_markup[] = $this_ability_markup;
        $mmrpg_index['abilities'][$ability['ability_token']] = $ability;
        // Unset the temporary ability array
        unset($ability);
        
      }
      
    }
    
  }
  
  // Close the ability data directory
  closedir($data_abilities);
  
  // Implode the markup into a single string
  $abilities_cache_markup = implode('', $abilities_cache_markup);
  $abilities_cache_markup = preg_replace('#\s?\?><\?\s?#i', '', $abilities_cache_markup);
  
  // If caching is enabled, create the index cache file
  if ($MMRPG_CONFIG['CACHE_INDEXES']){
    // Write the index to a cache file, if caching is enabled
    $abilities_cache_file = fopen($abilities_cache_path, 'w');
    fwrite($abilities_cache_file, $abilities_cache_markup);
    fclose($abilities_cache_file);
  }
    
}
// Otherwise, simple include the cache file
else {
  
  // Include the cache file so it can be evaluated
  require_once($abilities_cache_path);
  
}
?>