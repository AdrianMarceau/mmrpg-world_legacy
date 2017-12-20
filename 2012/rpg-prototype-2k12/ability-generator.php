<?
/*
 *  Project  : Untitled Project
 *  Location : http://www.domain.com/
 *  File     : Name <ability-generator.php>
 *  Created  :
 *  Modified :
 */

$abilities = array();
// MegaMan 1
$abilities[] = array('CutMan', 'Rolling', 'Cutter', 'metal', 2);
$abilities[] = array('BombMan', 'Hyper', 'Bomb', 'bomb', 2);
$abilities[] = array('ElecMan', 'Thunder', 'Beam', 'elec', 1);
$abilities[] = array('GutsMan', 'Super', 'Punch', 'power', 2);  // Super Arm
$abilities[] = array('FireMan', 'Fire', 'Storm', 'heat', 1);
$abilities[] = array('IceMan', 'Ice', 'Slasher', 'cold', 1);
$abilities[] = array('OilMan', 'Oil', 'Slider', 'earth', 1);
$abilities[] = array('TimeMan', 'Time', 'Arrow', 'time', 1);
// MegaMan 2
$abilities[] = array('AirMan', 'Air', 'Shooter', 'wind', 1);
$abilities[] = array('BubbleMan', 'Bubble', 'Lead', 'aqua', 1);
$abilities[] = array('MetalMan', 'Metal', 'Blade', 'metal', 1);
$abilities[] = array('HeatMan', 'Atomic', 'Flare', 'heat', 2);  // Atomic Fire
$abilities[] = array('FlashMan', 'Flash', 'Stopper', 'time', 2);  // Time Stopper
$abilities[] = array('CrashMan', 'Crash', 'Bomb', 'bomb', 2);
$abilities[] = array('WoodMan', 'Leaf', 'Shield', 'nature', 1);
$abilities[] = array('QuickMan', 'Quick', 'Boomerang', 'metal', 1);
// MegaMan 3
$abilities[] = array('GeminiMan', 'Gemini', 'Laser', 'heat', 1);
$abilities[] = array('HardMan', 'Hard', 'Knuckle', 'power', 1);
$abilities[] = array('MagnetMan', 'Magnet', 'Missle', 'elec', 1);
$abilities[] = array('NeedleMan', 'Needle', 'Cannon', 'metal', 1);
$abilities[] = array('ShadowMan', 'Shadow', 'Blade', 'dark', 1);
$abilities[] = array('SnakeMan', 'Search', 'Snake', 'nature', 2);
$abilities[] = array('SparkMan', 'Spark', 'Shock', 'elec', 1);
$abilities[] = array('TopMan', 'Top', 'Spin', 'metal', 1);
// MegaMan 4
$abilities[] = array('BrightMan', 'Bright', 'Stunner', 'time', 1);  // Flash Stopper
$abilities[] = array('DiveMan', 'Dive', 'Missle', 'aqua', 1);
$abilities[] = array('DrillMan', 'Drill', 'Rush', 'bomb', 1);  // Drill Bomb
$abilities[] = array('DustMan', 'Dust', 'Crusher', 'earth', 1);
$abilities[] = array('PharaohMan', 'Pharaoh', 'Curse', 'heat', 1);  // Pharaoh Shot
$abilities[] = array('RingMan', 'Ring', 'Blitz', 'metal', 1);  // Ring Boomerang
$abilities[] = array('SkullMan', 'Skull', 'Barrier', 'dark', 1);
$abilities[] = array('ToadMan', 'Rain', 'Flush', 'aqua', 1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>MegaMan RPG Ability Generator</title>
<base href="http://www.domain.com/" />
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<meta name="robots" content="index,follow" />
<link type="text/css" href="styles.css" rel="stylesheet" />
<style type="text/css">
</style>
<script type="text/css" src="scripts.js"></script>
<script type="text/css">
</script>
</head>
<body>

<?

$ability_index = array();

$counter = 0;
foreach ($abilities AS $key1 => $ability1){
  
  $counter++;
  $counter_padded = str_pad($counter, 3, '0', STR_PAD_LEFT);
  
  $robot_name = $ability1[0];
  $ability_name = $ability1[1].' '.$ability1[2];
  $ability_type = $ability1[3];
  $ability_base = $ability1[4];
  
  echo "<div style=\"margin: 0 auto 20px 0;\">\r\n";
  echo "<strong style=\"display: block; margin: 0 auto 5px;\">{$robot_name}</strong>\r\n";
  echo "#{$counter_padded}&nbsp;&nbsp;<span>{$ability_name}</span>&nbsp;&nbsp;<em>[{$ability_type}]</em>&nbsp;&nbsp;<span style=\"color: #696969; font-size: 80%;\">(Start)</span><br />\r\n";
  
  $ability_index[] = $ability_name;
  
  foreach ($abilities AS $key2 => $ability2){
    
    if ($ability1[0] == $ability2[0]){ continue; }
    
    if ($ability_base == 1){ $ability_name = $ability1[1].' '.$ability2[2];  }
    else { $ability_name = $ability2[1].' '.$ability1[2]; }
    
    if (!in_array($ability_name, $ability_index)){
      $counter++;
      $counter_padded = str_pad($counter, 3, '0', STR_PAD_LEFT);
      $ability_index[] = $ability_name;
    }
    else {
      $temp_counter = array_search($ability_name, $ability_index) + 1;
      $counter_padded = str_pad($temp_counter, 3, '0', STR_PAD_LEFT);
    }
    
    $ability_type = $ability1[3].' / '.$ability2[3];
    
    echo "#{$counter_padded}&nbsp;&nbsp;<span>{$ability_name}</span>&nbsp;&nbsp;<em>[{$ability_type}]</em>&nbsp;&nbsp;<span style=\"color: #696969; font-size: 80%;\">(Defeat {$ability2[0]})</span><br />\r\n";
    
    
    
  }
  echo "</div>\r\n";
}
?>

<!--
<?= print_r($ability_index, true) ?>
-->

</body>
</html>