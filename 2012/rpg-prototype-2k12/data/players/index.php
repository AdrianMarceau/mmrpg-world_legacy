<?
// Default the players index to an empty array
$mmrpg_index['players'] = array();

// Define the cache and index paths for players
$players_index_path = $MMRPG_CONFIG['ROOTDIR'].'data/players/';
$players_cache_path = $MMRPG_CONFIG['ROOTDIR'].'data/cache/'.'cache.players.'.$MMRPG_CONFIG['CACHE_DATE'].'.php';

// If caching is turned OFF, or a cache has not been created
if (!$MMRPG_CONFIG['CACHE_INDEXES'] || !file_exists($players_cache_path)){
  
  // Default the players markup index to an empty array
  $players_cache_markup = array();
  
  // Open the type data directory for scanning
  $data_players  = opendir($players_index_path);
  
  // Loop through all the files in the directory
  while (false !== ($filename = readdir($data_players))) {
    
    // Ensure the file matches the naming format
    if (preg_match('#^player\.[-_a-z0-9]+\.php$#i', $filename)){
      
      // Read the file into memory as a string
      $this_player_markup = trim(file_get_contents($players_index_path.$filename));
      // Remove the start and end PHP tags from the string
      if (preg_match('#^<\?\s?$#i', $this_player_markup[0])){ $this_player_markup[0] = ''; }
      // Evaluate the file into the local scope
      eval('?>'.$this_player_markup.'<?');
      
      // If an type array was defined and is not empty
      if (isset($player) && !empty($player)){
        
        // Parse out the generic "player" variable for a specific index
        $this_player_markup = preg_replace('#\$player = array\(#i', "\$mmrpg_index['players']['{$player['player_token']}'] = array(", $this_player_markup);
        // Copy this player's data to the index
        $players_cache_markup[] = $this_player_markup;
        $mmrpg_index['players'][$player['player_token']] = $player;
        // Unset the temporary player array
        unset($player);
        
      }
      
    }
    
  }
  
  // Close the player data directory
  closedir($data_players);
  
  // Implode the markup into a single string
  $players_cache_markup = implode('', $players_cache_markup);
  $players_cache_markup = preg_replace('#\s?\?><\?\s?#i', '', $players_cache_markup);
  
  // If caching is enabled, create the index cache file
  if ($MMRPG_CONFIG['CACHE_INDEXES']){
    // Write the index to a cache file, if caching is enabled
    $players_cache_file = fopen($players_cache_path, 'w');
    fwrite($players_cache_file, $players_cache_markup);
    fclose($players_cache_file);
  }
    
}
// Otherwise, simple include the cache file
else {
  
  // Include the cache file so it can be evaluated
  require_once($players_cache_path);
  
}
?>