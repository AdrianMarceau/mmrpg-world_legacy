<?php
/*
 * Filename : index.php
 * Title	: MegaManPoweredUp.NET Placeholder Page
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : Jun 6, 2009
 *
 * Description:
 * This is really nothing more than a placeholder until I actually make a Powered Up site.  :P
 */

// Define the CURRENTDOMAIN, ISLIVE and various ROOTS
$currentdomain = $_SERVER['HTTP_HOST'];
if (stristr($currentdomain, "localhost")) { define('CURRENTDOMAIN', 'localhost'); define('ISLIVE', false); }
elseif (stristr($currentdomain, "kratos")) { define('CURRENTDOMAIN', 'kratos'); define('ISLIVE', false); }
else { define('CURRENTDOMAIN', 'remote'); define('ISLIVE', true); }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
<title>Battle Layout Template #2 | MegaMan Powered Up RPG | Play-by-Post Text-Adventure Role-Playing Game</title>
<meta name="robots" content="noindex,nofollow" />
<style type="text/css">
body, html {
margin: 0;
padding: 0;
background: transparent url(mmpu_background.gif) repeat top left;
height: 100%;
text-align: center;
}
#page {
	display: block;
  margin: 0 auto;
  height: 100%;
  min-height: 100%;
  width: 790px;
  min-width: 790px;
  border-width: 0 4px;
  border-style: solid;
  border-color: #DEDEDE;
  background-color: #FFF;
  text-align: center;
  padding: 10px;
}
h1 {
	margin: 6px auto;
  text-align: left;
  border-bottom: 4px double #222;
  color: #222;
  padding-bottom: 8px;
}
h2 {
	margin: 3px auto;
  text-align: right;
}
h3 {
	margin: 0 auto;
  text-align: right;
  font-style: italic;
  font-size: 12px;
}

#battle_state_window {
	width: 95%;
  margin: 10px auto 20px;
  border: 2px solid #464646;
  background-color: #646464;
  border-collapse: collapse;
}
#battle_state_window td {
	padding: 0;
  vertical-align: middle;
}
#battle_state_window td.left_team, #battle_state_window td.right_team {
  padding: 5px;
}
#battle_state_window div.robot_stat_block {
	margin: 2px auto;
  padding: 0;
  width: 300px;
  border: 2px solid #242424;
  background-color: #363636;
  color: #FFF;
}
#battle_state_window td.left_team div.robot_stat_block {
  border-right: 5px solid #464646;
}
#battle_state_window td.right_team div.robot_stat_block {
  border-left: 5px solid #464646;
}

#battle_state_window div.robot_stat_block span.robot_image {
  display: inline-block;
  width: 100px;
  vertical-align: middle;
}


#battle_state_window div.robot_stat_block span.robot_stats {
  display: inline-block;
  width: 150px;
  vertical-align: middle;
  text-align: left;
}
#battle_state_window div.robot_stat_block span.robot_stats span.name_level {
  font-weight: bold;
}
#battle_state_window div.robot_stat_block span.robot_stats span.name_level sup {
	font-weight: normal;
}

#battle_state_window div.robot_stat_block span.robot_stats span.life_energy {
	display: inline-block;
  vertical-align: top;
  margin: 1px auto;
  height: 15px;
  border: 1px solid #156829;
  background-color: #197b30;
}
#battle_state_window div.robot_stat_block span.robot_stats label.life_energy {
  display: inline-block;
  vertical-align: top;
  text-align: center;
  margin: 1px auto;
  width: 20px;
  height: 15px;
  border: 1px solid #156829;
  font-size: 11px;
  font-weight: bold;
}

#battle_state_window div.robot_stat_block span.robot_stats span.weapon_energy {
  display: inline-block;
  vertical-align: top;
  margin: 1px auto;
  height: 15px;
  border: 1px solid #004281;
  background-color: #0054a6;
}
#battle_state_window div.robot_stat_block span.robot_stats label.weapon_energy {
  display: inline-block;
  vertical-align: top;
  text-align: center;
  margin: 1px auto;
  width: 20px;
  height: 15px;
  border: 1px solid #004281;
  font-size: 11px;
  font-weight: bold;
}

</style>
</head>
<body>
<div id="page">
<h2>MegaMan Powered Up RPG</h2>
<h3>Play-by-Post Text-Adventure Role-Playing Game</h3>
<h1>Battle Layout Template #2</h1>

<table id="battle_state_window">
<tr>
<td width="300" class="left_team">
  <div class="robot_stat_block" style="background: #363636 url(images/type_icons/cold_icon_80x80.png) no-repeat -40px -40px;">
    <span class="robot_image"><img src="images/character_profiles/iceman_100x100.png" width="100" height="100" alt="IceMan" /></span>
    <span class="robot_stats">
      <span class="name_level">IceMan <sup>Lv 174</sup></span><br />
      <label class="life_energy">LE</label><span class="life_energy" title="128/128" style="width: 100px;">&nbsp;</span><br />
      <label class="weapon_energy">WE</label><span class="weapon_energy" title="10/10" style="width: 100px;">&nbsp;</span><br />
    </span>
  </div>
  <div class="robot_stat_block" style="background: #363636 url(images/type_icons/heat_icon_80x80.png) no-repeat -40px -40px;">
    <span class="robot_image"><img src="images/character_profiles/fireman_100x100.png" width="100" height="100" alt="FireMan" /></span>
    <span class="robot_stats">
      <span class="name_level">FireMan <sup>Lv 35</sup></span><br />
      <label class="life_energy">LE</label><span class="life_energy" title="12/35" style="width: 58px;">&nbsp;</span><br />
      <label class="weapon_energy">WE</label><span class="weapon_energy" title="8/10" style="width: 80px;">&nbsp;</span><br />
    </span>
  </div>
  <div class="robot_stat_block" style="background: #363636 url(images/type_icons/erth_icon_80x80.png) no-repeat -40px -40px;">
    <span class="robot_image"><img src="images/character_profiles/oilman_100x100.png" width="100" height="100" alt="OilMan" /></span>
    <span class="robot_stats">
      <span class="name_level">OilMan <sup>Lv 71</sup></span><br />
      <label class="life_energy">LE</label><span class="life_energy" title="12/35" style="width: 85px;">&nbsp;</span><br />
      <label class="weapon_energy">WE</label><span class="weapon_energy" title="2/10" style="width: 20px;">&nbsp;</span><br />
    </span>
  </div>
</td>
<td class="vs" style="font-size: 20px; color: #FFF; font-family: Comis Sans MS, Arial;">
Ageman<br />vs.<br />Ender<br /><br /><span style="font-size: 12px;">Turn #12</span>
</td>
<td width="300" class="right_team">
  <div class="robot_stat_block" style="background: #363636 url(images/type_icons/metl_icon_80x80.png) no-repeat 260px -40px;">
    <span class="robot_stats">
      <span class="name_level">CutMan <sup>Lv 280</sup></span><br />
      <label class="life_energy">LE</label><span class="life_energy" title="488/588" style="width: 98px;">&nbsp;</span><br />
      <label class="weapon_energy">WE</label><span class="weapon_energy" title="5/10" style="width: 50px;">&nbsp;</span><br />
    </span>
    <span class="robot_image"><img src="images/character_profiles/cutman_100x100.png" width="100" height="100" alt="CutMan" /></span>
  </div>
  <div class="robot_stat_block" style="background: #363636 url(images/type_icons/powr_icon_80x80.png) no-repeat 260px -40px;">
    <span class="robot_stats">
      <span class="name_level">GutsMan <sup>Lv 187</sup></span><br />
      <label class="life_energy">LE</label><span class="life_energy" title="750/1000" style="width: 75px;">&nbsp;</span><br />
      <label class="weapon_energy">WE</label><span class="weapon_energy" title="10/10" style="width: 100px;">&nbsp;</span><br />
    </span>
    <span class="robot_image"><img src="images/character_profiles/gutsman_100x100.png" width="100" height="100" alt="GutsMan" /></span>
  </div>
  <div class="robot_stat_block" style="background: #363636 url(images/type_icons/elec_icon_80x80.png) no-repeat 260px -40px;">
    <span class="robot_stats">
      <span class="name_level">ElecMan <sup>Lv 18</sup></span><br />
      <label class="life_energy">LE</label><span class="life_energy" title="1/100" style="width: 1px;">&nbsp;</span><br />
      <label class="weapon_energy">WE</label><span class="weapon_energy" title="1/10" style="width: 10px;">&nbsp;</span><br />
    </span>
    <span class="robot_image"><img src="images/character_profiles/elecman_100x100.png" width="100" height="100" alt="ElecMan" /></span>
  </div>
</td>
</tr>
</table>

</div>
</body>
</html>
