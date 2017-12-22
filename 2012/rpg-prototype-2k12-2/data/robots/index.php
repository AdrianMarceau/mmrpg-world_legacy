<?
// Default the robots index to an empty array
$mmrpg_index['robots'] = array();

// Define the cache and index paths for robots
$robots_index_path = $MMRPG_CONFIG['ROOTDIR'].'data/robots/';
$robots_cache_path = $MMRPG_CONFIG['ROOTDIR'].'data/cache/'.'cache.robots.'.$MMRPG_CONFIG['CACHE_DATE'].'.php';

// If caching is turned OFF, or a cache has not been created
if (!$MMRPG_CONFIG['CACHE_INDEXES'] || !file_exists($robots_cache_path)){
  
  // Default the robots markup index to an empty array
  $robots_cache_markup = array();
  
  // Open the type data directory for scanning
  $data_robots  = opendir($robots_index_path);
  
  // Loop through all the files in the directory
  while (false !== ($filename = readdir($data_robots))) {
    
    // Ensure the file matches the naming format
    if (preg_match('#^robot\.[-_a-z0-9]+\.php$#i', $filename)){
      // Collect the robot token from the filename
      $this_robot_token = preg_replace('#^robot\.([-_a-z0-9]+)\.php$#i', '$1', $filename);
      // Read the file into memory as a string and crop slice out the imporant part
      $this_robot_markup = trim(file_get_contents($robots_index_path.$filename));
      $this_robot_markup = explode("\n", $this_robot_markup);
      $this_robot_markup = array_slice($this_robot_markup, 1, -1);
      // Replace the first line with the appropriate index key
      $this_robot_markup[1] = preg_replace('#\$robot = array\(#i', "\$mmrpg_index['robots']['{$this_robot_token}'] = array(", $this_robot_markup[1]);
      // Implode the markup into a single string
      $this_robot_markup = implode("\n", $this_robot_markup);
      // Copy this robot's data to the markup cache
      $robots_cache_markup[] = $this_robot_markup;
    }
    
  }
  
  // Close the robot data directory
  closedir($data_robots);
  
  // Implode the markup into a single string and enclose in PHP tags
  $robots_cache_markup = implode('', $robots_cache_markup);
  $robots_cache_markup = "<?\n".$robots_cache_markup."\n?>";
  
  // Write the index to a cache file, if caching is enabled
  $robots_cache_file = fopen($robots_cache_path, 'w');
  fwrite($robots_cache_file, $robots_cache_markup);
  fclose($robots_cache_file);
    
}

// Include the cache file so it can be evaluated
require_once($robots_cache_path);
//die('<pre>'.print_r($mmrpg_index['robots'], true).'</pre>'); //DEBUG
?>