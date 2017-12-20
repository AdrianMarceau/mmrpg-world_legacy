<?
// Default the battles index to an empty array
$mmrpg_index['battles'] = array();

// Define the cache and index paths for battles
$battles_index_path = $MMRPG_CONFIG['ROOTDIR'].'data/battles/';
$battles_cache_path = $MMRPG_CONFIG['ROOTDIR'].'data/cache/'.'cache.battles.'.$MMRPG_CONFIG['CACHE_DATE'].'.php';

// If caching is turned OFF, or a cache has not been created
if (!$MMRPG_CONFIG['CACHE_INDEXES'] || !file_exists($battles_cache_path)){
  
  // Default the battles markup index to an empty array
  $battles_cache_markup = array();
  
  // Open the type data directory for scanning
  $data_battles  = opendir($battles_index_path);
  
  // Loop through all the files in the directory
  while (false !== ($filename = readdir($data_battles))) {
    
    // Ensure the file matches the naming format
    if (preg_match('#^battle\.[-_a-z0-9]+\.php$#i', $filename)){
      
      // Read the file into memory as a string
      $this_battle_markup = trim(file_get_contents($battles_index_path.$filename));
      // Remove the start and end PHP tags from the string
      if (preg_match('#^<\?\s?$#i', $this_battle_markup[0])){ $this_battle_markup[0] = ''; }
      // Evaluate the file into the local scope
      eval('?>'.$this_battle_markup.'<?');
      
      // If an type array was defined and is not empty
      if (isset($battle) && !empty($battle)){
        
        // Parse out the generic "battle" variable for a specific index
        $this_battle_markup = preg_replace('#\$battle = array\(#i', "\$mmrpg_index['battles']['{$battle['battle_token']}'] = array(", $this_battle_markup);
        // Copy this battle's data to the index
        $battles_cache_markup[] = $this_battle_markup;
        $mmrpg_index['battles'][$battle['battle_token']] = $battle;
        // Unset the temporary battle array
        unset($battle);
        
      }
      
    }
    
  }
  
  // Close the battle data directory
  closedir($data_battles);
  
  // Implode the markup into a single string
  $battles_cache_markup = implode('', $battles_cache_markup);
  $battles_cache_markup = preg_replace('#\s?\?><\?\s?#i', '', $battles_cache_markup);
  
  // If caching is enabled, create the index cache file
  if ($MMRPG_CONFIG['CACHE_INDEXES']){
    // Write the index to a cache file, if caching is enabled
    $battles_cache_file = fopen($battles_cache_path, 'w');
    fwrite($battles_cache_file, $battles_cache_markup);
    fclose($battles_cache_file);
  }
    
}
// Otherwise, simple include the cache file
else {
  
  // Include the cache file so it can be evaluated
  require_once($battles_cache_path);
  
}
?>