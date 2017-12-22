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
      // Collect the battle token from the filename
      $this_battle_token = preg_replace('#^battle\.([-_a-z0-9]+)\.php$#i', '$1', $filename);
      // Read the file into memory as a string and crop slice out the imporant part
      $this_battle_markup = trim(file_get_contents($battles_index_path.$filename));
      $this_battle_markup = explode("\n", $this_battle_markup);
      $this_battle_markup = array_slice($this_battle_markup, 1, -1);
      // Replace the first line with the appropriate index key
      $this_battle_markup[1] = preg_replace('#\$battle = array\(#i', "\$mmrpg_index['battles']['{$this_battle_token}'] = array(", $this_battle_markup[1]);
      // Implode the markup into a single string
      $this_battle_markup = implode("\n", $this_battle_markup);
      // Copy this battle's data to the markup cache
      $battles_cache_markup[] = $this_battle_markup;
    }
    
  }
  
  // Close the battle data directory
  closedir($data_battles);
  
  // Implode the markup into a single string and enclose in PHP tags
  $battles_cache_markup = implode('', $battles_cache_markup);
  $battles_cache_markup = "<?\n".$battles_cache_markup."\n?>";
  
  // Write the index to a cache file, if caching is enabled
  $battles_cache_file = fopen($battles_cache_path, 'w');
  fwrite($battles_cache_file, $battles_cache_markup);
  fclose($battles_cache_file);
    
}

// Include the cache file so it can be evaluated
require_once($battles_cache_path);
//die('<pre>'.print_r($mmrpg_index['battles'], true).'</pre>'); //DEBUG
?>