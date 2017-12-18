<?
// Include the TOP file
require_once('top.php');

// Change the header type for this file
header('Content-Type: text/cache-manifest');
//echo "<pre>\r\n";

// Display the cache manifest header
echo "CACHE MANIFEST\r\n";

// Display the cache section header
echo "CACHE:\r\n";

// Define the cache for the index file
echo "{$MMRPG_CONFIG['ROOTURL']}index.php\r\n";

// Define script and style cache files
echo "{$MMRPG_CONFIG['ROOTURL']}styles/reset.css\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}styles/style.css\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}styles/mobile.css\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}scripts/jquery.js\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}scripts/script.js\r\n";

// Define any GUI images for caching
echo "{$MMRPG_CONFIG['ROOTURL']}images/ajax-loader.gif\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}images/ajax-loader_mobile.gif\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}images/assets/iphone-icon_57x57.png\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}images/assets/iphone-startup_320x460.png\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}images/tiles/vertical-gradient_energy-bar.gif\r\n";

// Define the field sprite variables
$field_sprite_types = array('background', 'foreground');
$robot_sprite_frames = array('base');
// Loop through the entire robot index
if (!empty($mmrpg_index['battles'])){
  foreach ($mmrpg_index['battles'] AS $battle_token => $this_battle){
    foreach ($field_sprite_types AS $this_type){
      foreach ($robot_sprite_frames AS $this_frame){
        echo "{$MMRPG_CONFIG['ROOTURL']}images/fields/{$this_battle['battle_field']['field_'.$this_type]}/battle-field_{$this_type}_{$this_frame}.png\r\n";
      }
    }
  }
}

// Define the robot sprite variables
$robot_sprite_directions = array('left', 'right');
$robot_sprite_frames = array('base', 'attack', 'damage', 'defend');
$robot_sprite_sizes = array(40, 80);
// Loop through the entire robot index
if (!empty($mmrpg_index['robots'])){
  foreach ($mmrpg_index['robots'] AS $robot_token => $this_robot){
    foreach ($robot_sprite_directions AS $this_direction){
      foreach ($robot_sprite_frames AS $this_frame){
        foreach ($robot_sprite_sizes AS $this_size){
          echo "{$MMRPG_CONFIG['ROOTURL']}images/robots/{$this_robot['robot_token']}/robot-sprite_{$this_direction}_{$this_frame}_{$this_size}x{$this_size}.gif\r\n";
        }
      }
    }
  }
}

// Display the network section header
echo "NETWORK:\r\n";

// List any network paths that need to stay open
echo "{$MMRPG_CONFIG['ROOTURL']}battle.php\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}data.php\r\n";
echo "{$MMRPG_CONFIG['ROOTURL']}manifest.php\r\n";

?>