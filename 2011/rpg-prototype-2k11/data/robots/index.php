<?
// Default the robots index to an empty array
$mmrpg_index['robots'] = array();

// Define the cache and index paths for robots
$robots_index_path = $MMRPG_CONFIG['ROOTDIR'].'data/robots/';
$robots_cache_path = $MMRPG_CONFIG['ROOTDIR'].'data/cache/'.'cache.robots.'.date('Ymd').'.php';

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
      
      // Read the file into memory as a string
      $this_robot_markup = trim(file_get_contents($robots_index_path.$filename));
      // Remove the start and end PHP tags from the string
      if (preg_match('#^<\?\s?$#i', $this_robot_markup[0])){ $this_robot_markup[0] = ''; }
      // Evaluate the file into the local scope
      eval('?>'.$this_robot_markup.'<?');
      
      // If an type array was defined and is not empty
      if (isset($robot) && !empty($robot)){
        
        // Parse out the generic "robot" variable for a specific index
        $this_robot_markup = preg_replace('#\$robot = array\(#i', "\$mmrpg_index['robots']['{$robot['robot_token']}'] = array(", $this_robot_markup);
        // Copy this robot's data to the index
        $robots_cache_markup[] = $this_robot_markup;
        $mmrpg_index['robots'][$robot['robot_token']] = $robot;
        // Unset the temporary robot array
        unset($robot);
        
      }
      
    }
    
  }
  
  // Close the robot data directory
  closedir($data_robots);
  
  // Implode the markup into a single string
  $robots_cache_markup = implode('', $robots_cache_markup);
  $robots_cache_markup = preg_replace('#\s?\?><\?\s?#i', '', $robots_cache_markup);
  
  // If caching is enabled, create the index cache file
  if ($MMRPG_CONFIG['CACHE_INDEXES']){
    // Write the index to a cache file, if caching is enabled
    $robots_cache_file = fopen($robots_cache_path, 'w');
    fwrite($robots_cache_file, $robots_cache_markup);
    fclose($robots_cache_file);
  }
    
}
// Otherwise, simple include the cache file
else {
  
  // Include the cache file so it can be evaluated
  require_once($robots_cache_path);
  
}
?>