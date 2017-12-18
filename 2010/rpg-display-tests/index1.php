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
<title>Battle Layout Template | MegaMan Powered Up RPG | Play-by-Post Text-Adventure Role-Playing Game</title>
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
h5 {
	margin: 0 auto;
  padding: 0;
  font-size: 15px;
  font-weight: bold;
  color: #464646;
  text-align: center;
}

#battle_area {
	border-collapse: collapse;
  border-style: none;
  width: 98%;
  margin: 20px auto;
  background-color: #DEDEDE;
}
#battle_area td {
  text-align: center;
  vertical-align: top;
  padding: 0;
}

#overview, #timeline, #action {
	margin: 0 auto;
  background-color: #FFF;
  border: 2px solid #DEDEDE;
  text-align: center;
  width: 98%;
}

#overview {
	min-height: 300px;
  height: 300px;
}

#timeline {
	min-height: 535px;
  height: 535px;
  max-height: 535px;
  overflow: auto;
}

#action {
	min-height: 200px;
  height: 200px
}

table.post {
  margin: 0 auto 4px;
  width: 98%;
  min-width: 98%;
  max-width: 98%;
  border: 1px solid #EFEFEF;
  font-size: 12px;
  color: #222;
}
table.post td.turn a {
	color: #CACACA;
  font-size: 10px;
  text-decoration: none;
}
table.post td.turn a:hover {
  color: #DEDEDE;
  text-decoration: underline;
}

table.post td.actions {

}
table.post td.actions em {
	display: block;
  margin: 0 auto 2px;
  color: #747474;
  font-style: italic;
  text-align: center;
  font-size: 14px;
}
table.post td.actions strong {
  display: block;
  margin: 0 8px 2px;
  color: #444;
  text-align: left;
  font-size: 11px;
}
table.post td.actions span {
  display: block;
  margin: 0 8px 2px;
  color: #555;
  text-align: left;
  font-size: 10px;
}
table.post td.actions span img {
	width: 15px;
  height: 15px;
  margin: 0 2px;
}

table.post td.team span.robot label {
  display: block;
  margin: 0 8px 2px;
  color: #222;
  text-align: left;
  font-size: 10px;
}

</style>
</head>
<body>
<div id="page">
<h2>MegaMan Powered Up RPG</h2>
<h3>Play-by-Post Text-Adventure Role-Playing Game</h3>
<h1>Battle Layout Template</h1>

<table id="battle_area">
<tr>
<td width="40%">

<h5>Battle Overview</h5>
<div id="overview">
overview
</div>

</td>
<td width="60%" rowspan="2">

<h5>Play-by-Play Timeline</h5>
<div id="timeline">
timeline<br />
<?
// Test the overflow
for ($i = 100; $i >= 1; $i--)
{
?>
<table class="post">
<tr>
<td class="turn" width="10"><a name="turn_<?=$i?>" href="javascript:;">#<?=$i?></a></td>
</td>
<td class="team" width="50">
  <span class="robot">
    <img src="images/character_profiles/bombman_60x60.png" alt="Bomb Man" width="60" height="60" />
    <label>143/546 LE</label>
  </span>
  <span class="robot">
    <img src="images/character_profiles/fireman_60x60.png" alt="Fire Man" width="60" height="60" />
    <label>300/341 LE</label>
  </span>
</td>
<td class="actions">
<em>&quot;We&#39;re gonna mess you up!&quot;</em>
<strong>BombMan and FireMan used <u>Double Team</u>!</strong>
<span>BombMan throwns a barrage of bombs at the targets!</span>
<span>FireMan conjurs up a storm of Fire!</span>
<strong>Knight Roll is hit by the attack!</strong>
<span>67 <img src="images/type_icons/bomb_icon_25x25.png" alt="BOMB" title="BOMB"/> damage!</span>
<span>76 <img src="images/type_icons/heat_icon_25x25.png" alt="HEAT" title="HEAT"/> damage!</span>
<strong>Elec Man is hit by the attack!</strong>
<span>120 <img src="images/type_icons/bomb_icon_25x25.png" alt="BOMB" title="BOMB"/> damage!</span>
<span>457 <img src="images/type_icons/heat_icon_25x25.png" alt="HEAT" title="HEAT"/> damage!</span>
<strong>Knight Roll is hit by the attack!</strong>
<span>67 <img src="images/type_icons/bomb_icon_25x25.png" alt="BOMB" title="BOMB"/> damage!</span>
<span>76 <img src="images/type_icons/heat_icon_25x25.png" alt="HEAT" title="HEAT"/> damage!</span>
</td>
<td class="team" width="40">
  <span class="robot">
    <img src="images/character_profiles/knight_roll_60x60.png" alt="Knight Roll" width="60" height="60" />
    <label>148/483 LE</label>
  </span>
  <span class="robot">
    <img src="images/character_profiles/elecman_60x60.png" alt="Elec Man" width="60" height="60" />
    <label>24/841 LE</label>
  </span>
  <span class="robot">
    <img src="images/character_profiles/knight_roll_60x60.png" alt="Knight Roll" width="60" height="60" />
    <label>155/478 LE</label>
  </span>
</td>
</tr>
</table>
<?
}
?>
</div>

</td>
</tr>
<tr>
<td width="40%">

<h5>Action Panel</h5>
<div id="action">
action
</div>

</td>
</tr>
</table>

</div>
</body>
</html>
