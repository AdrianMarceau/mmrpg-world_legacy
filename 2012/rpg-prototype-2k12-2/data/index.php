<?php
// Include the TOP file
require_once('../top.php');

// Sort the robot index based on robot number
function mmrpg_index_sort_robots($robot_one, $robot_two){
  if ($robot_one['robot_number'] > $robot_two['robot_number']){ return 1; }
  elseif ($robot_one['robot_number'] < $robot_two['robot_number']){ return -1; }
  else { return 0; }
}
uasort($mmrpg_index['robots'], 'mmrpg_index_sort_robots');


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Mega Man RPG Prototype | Data Library | Last Updated <?= preg_replace('#([0-9]{4})([0-9]{2})([0-9]{2})-([0-9]{2})#', '$1/$2/$3', $MMRPG_CONFIG['CACHE_DATE']) ?></title>
<meta name="robots" content="noindex,nofollow" />
<meta name="format-detection" content="telephone=no" />
<base href="<?=$MMRPG_CONFIG['ROOTURL']?>" />
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<?if($flag_wap):?>
<link type="text/css" href="styles/style-mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<?endif;?>
<style type="text/css">
#canvas .sprite_robot {
  height: 42px;
  border: 1px solid transparent;
  border-radius: 0.5em;
  -moz-border-radius: 0.5em;
  -webkit-border-radius: 0.5em;
}
#canvas .sprite_robot_current,
#canvas .sprite_robot_current:hover,
#canvas .sprite_robot:hover {
  border-color: #212121;
  background-color: #313131;
}

#canvas .options {
  display: block;
  position: absolute;
  bottom: -2px;
  left: -2px;
  width: 46px;
  height: 17px;
  border: 1px solid rgb(36,36,36);
  border-width: 1px 0 0 1px;
  font-size: 6px;
  line-height: 12px;
  letter-spacing: 2px;
  text-align: right;
  text-transform: none;
  padding: 1px 16px 1px 6px;
  border-radius: 0 5em 0 0;
  -moz-border-radius: 0 5em 0 0;
  -webkit-border-radius: 0 5em 0 0;
  background-color: rgb(43,43,43);
  background-image: -webkit-gradient(
      linear,
      left bottom,
      left top,
      color-stop(0.15, rgb(43,43,43)),
      color-stop(0.75, rgb(41,41,41))
  );
  background-image: -moz-linear-gradient(
      center bottom,
      rgb(43,43,43) 15%,
      rgb(41,41,41) 75%
  );
  text-shadow: 1px 1px 4px #333333;
  cursor: pointer;
  _cursor: hand;
  box-shadow: 0 1px 2px #191919;
  -moz-box-shadow: 0 1px 2px #191919;
  -website-box-shadow: 0 1px 2px #191919;
  overflow: hidden;
  z-index: 30;
  text-decoration: none;
}
#canvas .options .back {
  display: block;
  float: right;
  font-size: 9px;
  font-weight: bold;
  color: #CACACA;
  cursor: pointer;
  _cursor: hand;
  text-decoration: none;
}
#canvas .options .back:hover {

}
#canvas .options .back,
#canvas .options .back label {
  cursor: pointer;
  _cursor: hand;
}

#canvas .event .titlebar {
  display: block;
  float: left;
  text-indent: 20px;
  height: 40px;
  line-height: 40px;
  border: 1px solid #212121;
  padding: 0;
  border-radius: 0.75em;
  -moz-border-radius: 0.75em;
  -webkit-border-radius: 0.75em;
  color: #FFFFFF;
  background-color: rgb(45,45,45);
  background-image: -webkit-gradient(
      linear,
      left bottom,
      left top,
      color-stop(0.15, rgb(45,45,45)),
      color-stop(0.75, rgb(51,51,51))
  );
  background-image: -moz-linear-gradient(
      center bottom,
      rgb(45,45,45) 15%,
      rgb(51,51,51) 75%
  );
  text-shadow: 1px 1px 4px #333333;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -o-user-select: none;
  user-select: none;
  box-shadow: 0 1px 2px #191919;
  -moz-box-shadow: 0 1px 2px #191919;
  -website-box-shadow: 0 1px 2px #191919;
  top: 5px;
  left: 5px;
  right: 5px;
  width: auto;
}
#canvas .event .titlebar .title {
  color: #FFFFFF;
  font-size: 13px;
  line-height: 40px;
  letter-spacing: 2px;
  text-transform: uppercase;
  text-decoration: none;
}

#console .event table td.right {
  line-height: 21px;
}

</style>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?<?=$MMRPG_CONFIG['CACHE_DATE']?>"></script>
<script type="text/javascript">
gameSettings.wapFlag = <?= $flag_wap ? 'true' : 'false' ?>;
gameSettings.cacheTime = '<?=$MMRPG_CONFIG['CACHE_DATE']?>';
$(document).ready(function(){

  // Create the click event for canvas sprites
  $('.sprite[data-token]', gameCanvas).click(function(){
    var dataSprite = $(this);
    $('.sprite_robot_current', gameCanvas).removeClass('sprite_robot_current');
    dataSprite.addClass('sprite_robot_current');
    var dataParent = $(this).closest('.wrapper')
    dataParent.css({display:'block'});
    var dataSelect = dataParent.attr('data-select');
    var dataToken = $(this).attr('data-token');
    var dataSelector = '#'+dataSelect+' .event:visible';
    $(dataSelector, gameConsole).animate({opacity:0},250,'swing',function(){
      $(this).css({display:'none'});
      var dataSelector = '#'+dataSelect+' .event[data-token='+dataToken+']';
      $(dataSelector, gameConsole).css({display:'block',opacity:0}).animate({opacity:1.0},250,'swing');

      });
    });

  // Create the click event for the back button
  $('a.back', gameCanvas).click(function(e){
    e.preventDefault();
    window.location = 'prototype.php';
    });

  // Fade in the battle screen slowly
  gameBattle.waitForImages(function(){
    var tempTimeout = setTimeout(function(){
      gameBattle.css({opacity:0}).removeClass('hidden').animate({opacity:1.0}, 800, 'swing');
      }, 1000);
    }, false, true);


});
</script>
</head>
<body id="mmrpg" class="battle">
<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k12-2'], true)?>
=================================
<?=print_r($mmrpg_index['robots'], true)?>
=================================
<?=print_r($_GET, true)?>
</pre>
*/?>
<div id="battle" class="hidden">

  <div id="canvas">
    <div class="wrapper" data-select="robots">
      <div class="event sticky">
        <div class="sprite background" style="background-image: url(images/menus/menu-banner_this-battle-select.png);">
          <div style="float: left; margin: 40px 5px 0 10px; width: 99%;">
            <?$key_counter = 0;?>
            <?foreach($mmrpg_index['robots'] AS $robot_key => $robot_info):?>
            <?if($robot_key == 'robot' || empty($_SESSION['RPG2k12-2']['GAME']['values']['robot_database'][$robot_info['robot_token']])){ continue; }?>
            <a data-token="<?=$robot_info['robot_token']?>" title="<?=$robot_info['robot_name']?>" style="background-image: url(images/robots/<?=$robot_info['robot_token']?>/sprite_right_40x40.png?<?=$MMRPG_CONFIG['CACHE_DATE']?>); position: static; float: left; margin: 10px 10px 0 0; background-color: " class="sprite sprite_robot sprite_robot_sprite sprite_40x40 sprite_40x40_mugshot robot_status_active robot_position_active <?= $key_counter == 0 ? 'sprite_robot_current' : '' ?>"><?=$robot_info['robot_name']?></a>
            <?$key_counter++;?>
            <?endforeach;?>
          </div>
        </div>
        <div class="sprite foreground titlebar" style="">
          <h1 class="title" style="">Robot Database</h1>
        </div>
        <div class="options">
          <a class="back"><label>&laquo; Back</label></a>
        </div>
      </div>
    </div>
  </div>

  <div id="console" class="noresize" style="height: auto;">
    <div id="robots" class="wrapper">
      <?$key_counter = 0;?>
      <?foreach($mmrpg_index['robots'] AS $robot_key => $robot_info):?>
      <?if($robot_key == 'robot' || empty($_SESSION['RPG2k12-2']['GAME']['values']['robot_database'][$robot_info['robot_token']])){ continue; }?>
      <div class="event event_triple" data-token="<?=$robot_info['robot_token']?>" style="<?= $key_counter != 0 ? 'display:none;' : '' ?>">
        <div class="this_sprite sprite_left" style="height: 40px;">
          <div title="<?=$robot_info['robot_name']?>" style="background-image: url(images/robots/<?=$robot_info['robot_token']?>/mug_right_40x40.png?<?=$MMRPG_CONFIG['CACHE_DATE']?>); " class="sprite sprite_robot sprite_robot_sprite sprite_40x40 sprite_40x40_mug robot_status_active robot_position_active"><?=$robot_info['robot_name']?></div>
          <div title="<?=$robot_info['robot_name']?>" style="background-image: url(images/robots/<?=$robot_info['robot_token']?>/sprite_right_40x40.png?<?=$MMRPG_CONFIG['CACHE_DATE']?>); " class="sprite sprite_robot sprite_robot_sprite sprite_40x40 sprite_40x40_base robot_status_active robot_position_active"><?=$robot_info['robot_name']?></div>
          <div title="<?=$robot_info['robot_name']?>" style="background-image: url(images/robots/<?=$robot_info['robot_token']?>/sprite_right_40x40.png?<?=$MMRPG_CONFIG['CACHE_DATE']?>); " class="sprite sprite_robot sprite_robot_sprite sprite_40x40 sprite_40x40_taunt robot_status_active robot_position_active"><?=$robot_info['robot_name']?></div>
          <div title="<?=$robot_info['robot_name']?>" style="background-image: url(images/robots/<?=$robot_info['robot_token']?>/sprite_right_40x40.png?<?=$MMRPG_CONFIG['CACHE_DATE']?>); " class="sprite sprite_robot sprite_robot_sprite sprite_40x40 sprite_40x40_victory robot_status_active robot_position_active"><?=$robot_info['robot_name']?></div>
        </div>
        <div class="header header_left" style="margin-right: 0;"><?=$robot_info['robot_name']?>&#39;s Data</div>
        <div class="body body_left" style="margin-right: 0; padding: 2px 3px;">
          <table class="full" style="margin-bottom: 5px;">
            <colgroup>
              <col width="26%" />
              <col width="1%" />
              <col width="65%" />
            </colgroup>
            <tbody>
              <tr>
                <td  class="right">
                  <label style="display: block; float: left;">Name :</label>
                  <span class="robot_name"><?=$robot_info['robot_name']?></span>
                </td>
                <td class="center">&nbsp;</td>
                <td  class="right">
                  <label style="display: block; float: left;">Number :</label>
                  <span class="robot_number"><?=$robot_info['robot_number']?></span>
                </td>
              </tr>
              <tr>
                <td  class="right">
                  <label style="display: block; float: left;">Energy :</label>
                  <span class="robot_stat"><?= $robot_info['robot_energy'] ?></span>
                </td>
                <td class="center">&nbsp;</td>
                <td class="right">
                  <label style="display: block; float: left;">Weaknesses :</label>
                  <?
                  if (!empty($robot_info['robot_weaknesses'])){
                    $temp_string = array();
                    foreach ($robot_info['robot_weaknesses'] AS $robot_weakness){
                      $temp_string[] = '<span class="robot_weakness">'.$mmrpg_index['types'][$robot_weakness]['type_name'].'</span>';
                    }
                    echo implode(' ', $temp_string);
                  } else {
                    echo '<span class="robot_weakness">None</span>';
                  }
                  ?>
                </td>

              </tr>
              <tr>
                <td  class="right">
                  <label style="display: block; float: left;">Attack :</label>
                  <span class="robot_stat"><?= $robot_info['robot_attack'] ?></span>
                </td>
                <td class="center">&nbsp;</td>
                <td class="right">
                  <label style="display: block; float: left;">Resistances :</label>
                  <?
                  if (!empty($robot_info['robot_resistances'])){
                    $temp_string = array();
                    foreach ($robot_info['robot_resistances'] AS $robot_resistance){
                      $temp_string[] = '<span class="robot_resistance">'.$mmrpg_index['types'][$robot_resistance]['type_name'].'</span>';
                    }
                    echo implode(' ', $temp_string);
                  } else {
                    echo '<span class="robot_resistance">None</span>';
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <td  class="right">
                  <label style="display: block; float: left;">Defense :</label>
                  <span class="robot_stat"><?= $robot_info['robot_defense'] ?></span>
                </td>
                <td class="center">&nbsp;</td>
                <td class="right">
                  <label style="display: block; float: left;">Affinities :</label>
                  <?
                  if (!empty($robot_info['robot_affinities'])){
                    $temp_string = array();
                    foreach ($robot_info['robot_affinities'] AS $robot_affinity){
                      $temp_string[] = '<span class="robot_affinity">'.$mmrpg_index['types'][$robot_affinity]['type_name'].'</span>';
                    }
                    echo implode(' ', $temp_string);
                  } else {
                    echo '<span class="robot_affinity">None</span>';
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <td class="right">
                  <label style="display: block; float: left;">Speed :</label>
                  <span class="robot_stat"><?= $robot_info['robot_speed'] ?></span>
                </td>
                <td class="center">&nbsp;</td>
                <td class="right">
                  <label style="display: block; float: left;">Immunities :</label>
                  <?
                  if (!empty($robot_info['robot_immunities'])){
                    $temp_string = array();
                    foreach ($robot_info['robot_immunities'] AS $robot_immunity){
                      $temp_string[] = '<span class="robot_immunity">'.$mmrpg_index['types'][$robot_immunity]['type_name'].'</span>';
                    }
                    echo implode(' ', $temp_string);
                  } else {
                    echo '<span class="robot_immunity">None</span>';
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
          <table class="full">
            <colgroup>
              <col width="100%" />
            </colgroup>
            <tbody>
              <tr>
                <td class="right">
                  <label style="display: block; float: left;">Abilities :</label>
                  <?
                  if (!empty($robot_info['robot_abilities'])){
                    $temp_string = array();

                    for ($i = 0; $i <= 7; $i++){
                      if (isset($robot_info['robot_abilities'][$i])){
                        $robot_ability = $robot_info['robot_abilities'][$i];
                        $temp_string[] = '<span class="ability_name">'.str_replace(' ', '&nbsp;', $mmrpg_index['abilities'][$robot_ability]['ability_name']).'</span>'.(($i + 1) % 4 == 0 ? '<br />' : '');
                      }
                    }
                    echo implode(' ', $temp_string);
                  } else {
                    echo '<span class="robot_ability">None</span>';
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <?$key_counter++;?>
      <?endforeach;?>
    </div>
  </div>

</div>
</body>
</html>