<?php
// Include the TOP file
require_once('top.php');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>MegaMan RPG Test 2k11 : Prototype</title>
<meta name="robots" content="noindex,nofollow" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?<?=$MMRPG_CONFIG['CACHE_DATE']?>"></script>
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<link rel="stylesheet" href="styles/mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" media="only screen and (max-device-width: 768px)" type="text/css" />
<?if($flag_wap):?><link type="text/css" href="styles/mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" /><?endif;?>
<script type="text/javascript">
// Define the game WAP and cache flags/values
gameWAP = <?= $flag_wap ? 'true' : 'false' ?>;
gameCache = '<?=$MMRPG_CONFIG['CACHE_DATE']?>';
// Create the prototype battle options object
var battleOptions = {};
battleOptions.wap = gameWAP ? 'true' : 'false';
// When the document is ready, assign events
$(document).ready(function(){
  
  // Define the prototype context
  var thisContext = $('#prototype');
  if (thisContext.length){
    
    // Create click events for the battle redirect links
    $('a[data-redirect]', thisContext).click(function(e){
      e.preventDefault();
      var thisRedirect = $(this).attr('data-redirect');
      if (thisRedirect.length){
        window.location.href = thisRedirect;
        return true;
        } else {
        return false;
        }
      });
      
    // Automatically show the first menu screen
    prototype_menu_switch(1);
    // Create the click events for the prototype menu
    $('.option[data-token]', thisContext).click(function(e){
      // Prevent the default click action
      e.preventDefault();
      // If this option is disabled, ignore its input
      if ($(this).hasClass('option_disabled')){ return false; }
      // Collect the parent menu and option fields
      var thisParent = $(this).parent();
      var thisStep = parseInt(thisParent.attr('data-step'));
      var thisSelect = thisParent.attr('data-select');
      var thisToken = $(this).attr('data-token');
      var nextStep = $('.menu[data-step='+(thisStep + 1)+']', thisContext);
      // Update the battleOptions object with the current selection
      battleOptions[thisSelect] = thisToken;
      // Execute option-specific commands for special cases
      switch (thisSelect){
        case 'this_player_token': {
          // Prevent the player from fighting themselves
          var tempMenu = $('.menu[data-step=3]', thisContext);
          $('.option[data-token='+thisToken+']', tempMenu).addClass('option_disabled');
          break;
          }
        default: {
          break;
          }
        }
      // Check if there is another menu step to complete
      if (nextStep.length){
        // Automatically switch to the next step in sequence
        prototype_menu_switch(thisStep + 1);
        } else {
        // Collect all the variables and redirect to the battle page
        var thisRedirect = 'battle.php?1=1';
        for (var key in battleOptions){ thisRedirect += '&'+key+'='+battleOptions[key]; }
        //window.location.href = thisRedirect;
        prototype_menu_switch(thisRedirect);
        }
      // Return true on success
      return true;
      });
    
    }
  
});

// Create a function for switching to a specific menu step
function prototype_menu_switch(stepNumber){
  // Define the prototype context
  var thisContext = $('#prototype');
  if (thisContext.length){
    // Slowly fade all other menus
    $('.menu[data-step]', thisContext).animate({opacity:0,marginTop:'-100px'}, 600, 'swing', function(){
      // Once the menu is faded, remove it from display
      $(this).addClass('menu_hide').css({opacity:0,marginTop:''});
      // Check if the stepNumber is numeric or not
      if (typeof(stepNumber) == 'number'){
        // Collect the main banner title
        var thisBanner = $('.banner', thisContext);
        var thisBannerTitle = thisBanner.attr('title');
        // Collect a reference to the current menus
        var thisMenu = $('.menu[data-step='+stepNumber+']', thisContext);
        var thisMenuTitle = thisMenu.attr('data-title');
        // Update the banner text with this menu subtitle
        $('.title', thisBanner).html(thisBannerTitle+' : '+thisMenuTitle);
        // Unhide the current menu
        thisMenu.removeClass('menu_hide').animate({opacity:1.0}, 400, 'swing');
        } else {
        // Redirect to the string location passed as the stepNumber
        window.location.href = stepNumber;
        }
      });
    }
}
</script>
</head>
<body class="prototype">

<div id="prototype">
  
  <div class="banner" title="MegaMan RPG Prototype">
    <div class="sprite background" style="background-image: url(images/menus/menu-banner_this-battle-select.png);">prototype-4</div>
    <div class="sprite foreground" style="background-image: url(images/menus/menu-banner_this-battle-select_prototype-4.png);">prototype-4</div>
    <div class="title">MegaMan RPG Prototype</div>
  </div>
  
  <div class="menu menu_hide select_this_battle" data-step="1" data-title="Battle Select" data-select="this_battle_token">
    <span class="header block_1">Battle Select</span>
    <a class="option block_1" data-token="prototype-4">Prototype Battle</a>
  </div>
  
  <div class="menu menu_hide select_this_player" data-step="2" data-title="Player Select" data-select="this_player_token">
    <span class="header block_1">Player Select</span>
    <a class="option block_1" data-token="dr-light">Dr. Light</a>
    <a class="option block_2" data-token="dr-wily">Dr. Wily</a>
  </div>
  
  <div class="menu menu_hide select_target_player" data-step="3" data-title="Target Select" data-select="target_player_token">
    <span class="header block_1">Target Select</span>
    <a class="option block_1" data-token="dr-light">Dr. Light</a>
    <a class="option block_2" data-token="dr-wily">Dr. Wily</a>
  </div>
  
  <div class="menu menu_hide select_this_field" data-step="4" data-title="Field Select" data-select="this_field_token">
    <span class="header block_1">Field Select</span>
    <a class="option block_1" data-token="field">Base Field</a>
    <a class="option block_2" data-token="ice-field">Ice Field</a>
    <a class="option block_3" data-token="guts-field">Guts Field</a>
  </div>
  
  <?/*
  
  <div class="menu">
    
    <a class="battle block_1" data-redirect="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-4&this_field_token=field&this_player_token=dr-light&target_player_token=dr-wily">Light vs Wily<br />Base Field</a>
    <a class="battle block_2" data-redirect="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-4&this_field_token=field&this_player_token=dr-wily&target_player_token=dr-light">Wily vs Light<br />Base Field</a>
    
    <a class="battle block_3" data-redirect="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-4&this_field_token=ice-field&this_player_token=dr-light&target_player_token=dr-wily">Light vs Wily<br />Ice Field</a>
    <a class="battle block_4" data-redirect="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-4&this_field_token=ice-fieldthis_player_token=dr-wily&target_player_token=dr-light">Wily vs Light<br />Ice Field</a>
    
    <a class="battle block_5" data-redirect="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-4&this_field_token=guts-field&this_player_token=dr-light&target_player_token=dr-wily">Light vs Wily<br />Guts Field</a>
    <a class="battle block_6" data-redirect="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-4&this_field_token=guts-field&this_player_token=dr-wily&target_player_token=dr-light">Wily vs Light<br />Guts Field</a>

  </div>
  
  */?>
  
</div>

</body>
</html>