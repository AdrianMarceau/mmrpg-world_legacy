<?
// Include the TOP file
require_once('top.php');

// Change the header type for this file
header('Content-Type: text/cache-manifest');
//echo "<pre>\r\n";

// Display the cache manifest header
echo "CACHE MANIFEST\r\n";

// Print a version comment
echo "# Manifest Updated {$MMRPG_CONFIG['CACHE_DATE']}\r\n";

// Display the cache section header
echo "CACHE:\r\n";

// Define the asset base
$asset_base_dir = $MMRPG_CONFIG['ROOTDIR'];
$asset_base_url = $MMRPG_CONFIG['ROOTURL'];

// Define script and style cache files
//echo "{$asset_base_url}styles/reset.css\r\n";
echo "{$asset_base_url}styles/style.css?{$MMRPG_CONFIG['CACHE_DATE']}\r\n";
echo "{$asset_base_url}styles/mobile.css?{$MMRPG_CONFIG['CACHE_DATE']}\r\n";
echo "{$asset_base_url}scripts/jquery.js\r\n";
echo "{$asset_base_url}scripts/script.js?{$MMRPG_CONFIG['CACHE_DATE']}\r\n";

// Define any GUI images for caching
echo "{$asset_base_url}images/ajax-loader.gif\r\n";
echo "{$asset_base_url}images/ajax-loader_mobile.gif\r\n";
echo "{$asset_base_url}images/assets/iphone-icon_57x57.png\r\n";
echo "{$asset_base_url}images/assets/iphone-startup_320x460.png\r\n";
echo "{$asset_base_url}images/tiles/vertical-gradient_energy-bar.gif\r\n";

// Define the field sprite variables
$field_sprite_types = array('background', 'foreground');
$robot_sprite_frames = array('base');
// Loop through the entire robot index
if (!empty($mmrpg_index['battles'])){
  foreach ($mmrpg_index['battles'] AS $battle_token => $this_battle){
    foreach ($field_sprite_types AS $this_type){
      foreach ($robot_sprite_frames AS $this_frame){
        $this_filename = "images/fields/{$this_battle['battle_field']['field_'.$this_type]}/battle-field_{$this_type}_{$this_frame}.png\r\n";
        echo $asset_base_url.$this_filename;
      }
    }
  }
}

/*
// Define the robot sprite variables
$robot_sprite_directions = array('left', 'right');
$robot_sprite_frames = array('base', 'attack', 'damage', 'defend', 'disabled');
$robot_sprite_sizes = array(40, 80);
// Loop through the entire robot index
if (!empty($mmrpg_index['robots'])){
  foreach ($mmrpg_index['robots'] AS $robot_token => $this_robot){
    if ($robot_token == 'robot'){ continue; }
    foreach ($robot_sprite_directions AS $this_direction){
      foreach ($robot_sprite_frames AS $this_frame){
        foreach ($robot_sprite_sizes AS $this_size){
          $this_filename = "images/robots/{$this_robot['robot_token']}/robot-sprite_{$this_direction}_{$this_frame}_{$this_size}x{$this_size}.gif\r\n";
          echo $asset_base_url.$this_filename;
        }
      }
    }
  }
}
 */

// Define the robot sprite variables
$robot_sprite_sizes = array(40, 80);
// Loop through the entire robot index
if (!empty($mmrpg_index['robots'])){
  foreach ($mmrpg_index['robots'] AS $robot_token => $this_robot){
    if ($robot_token == 'robot'){ continue; }
    foreach ($robot_sprite_sizes AS $this_size){
      $this_filename = "images/robots/robot_{$this_robot['robot_token']}_{$this_size}x{$this_size}.png\r\n";
      echo $asset_base_url.$this_filename;
    }
  }
}

// Display the network section header
echo "NETWORK:\r\n";

// List any network paths that need to stay open
echo "{$asset_base_url}index.php\r\n";
echo "{$asset_base_url}prototype.php\r\n";
echo "{$asset_base_url}battle.php\r\n";
echo "{$asset_base_url}data.php\r\n";
//echo "{$asset_base_url}manifest.php\r\n";

?>