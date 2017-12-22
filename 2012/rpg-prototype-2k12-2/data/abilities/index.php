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
      // Collect the ability token from the filename
      $this_ability_token = preg_replace('#^ability\.([-_a-z0-9]+)\.php$#i', '$1', $filename);
      // Read the file into memory as a string and crop slice out the imporant part
      $this_ability_markup = trim(file_get_contents($abilities_index_path.$filename));
      $this_ability_markup = explode("\n", $this_ability_markup);
      $this_ability_markup = array_slice($this_ability_markup, 1, -1);
      // Replace the first line with the appropriate index key
      $this_ability_markup[1] = preg_replace('#\$ability = array\(#i', "\$mmrpg_index['abilities']['{$this_ability_token}'] = array(", $this_ability_markup[1]);
      // Implode the markup into a single string
      $this_ability_markup = implode("\n", $this_ability_markup);
      // Copy this ability's data to the markup cache
      $abilities_cache_markup[] = $this_ability_markup;
    }
    
  }
  
  // Close the ability data directory
  closedir($data_abilities);
  
  // Implode the markup into a single string and enclose in PHP tags
  $abilities_cache_markup = implode('', $abilities_cache_markup);
  $abilities_cache_markup = "<?\n".$abilities_cache_markup."\n?>";
  
  // Write the index to a cache file, if caching is enabled
  $abilities_cache_file = fopen($abilities_cache_path, 'w');
  fwrite($abilities_cache_file, $abilities_cache_markup);
  fclose($abilities_cache_file);
    
}

// Include the cache file so it can be evaluated
require_once($abilities_cache_path);
//die('<pre>'.print_r($mmrpg_index['abilities'], true).'</pre>'); //DEBUG
?>