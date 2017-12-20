
// Initialize the MMRPG global variables
var gameWAP = false;
var gameCache = '00000000-00';
var gameEngine = false;
var gameConnect = false;
var gameCanvas = false;
var gameConsole = false;
var gameActions = false;

// Initialize document ready events
$(document).ready(function(){

  // Update the MMRPG global variables
  gameWindow = $('#window');
  gameEngine = $('#engine');
  gameConnect = $('#connect');
  gameCanvas = $('#canvas');
  gameConsole = $('#console');
  gameActions = $('#actions');
  gamePrototype = $('#prototype');

  /*
   * INDEX EVENTS
   */

  // Ensure this is the battle document
  if (gameWindow.length){

    // Add click-events to the debug panel links
    $('a.battle', gamePrototype).live('click', function(e){
      var windowFrame = $('iframe', gameWindow);
      var thisLink = $(this).attr('href');
      if (windowFrame.attr('src') != 'about:blank'){
        e.preventDefault();
        var thisConfirm = 'Are you sure you want to switch battles?  Progress will be lost and all robots will be reset.';
        //if (confirm(thisConfirm)){
        if (true){
          windowFrame.attr('src', thisLink);
          return true;
          }
        } else {
        windowFrame.attr('src', thisLink);
        return false;
        }
      });

  }


  /*
   * BATTLE EVENTS
   */

  // Ensure this is the battle document
  if (gameEngine.length){

    // Add a click event to the gameActions panel buttons
    $('a[data-panel]', gameActions).live('click', function(e){
      var thisPanel = $(this).attr('data-panel');
      mmrpg_action_panel(thisPanel);
      });

    // Add a click event to the gameActions action buttons
    $('a[data-action]', gameActions).live('click', function(e){
      var thisAction = $(this).attr('data-action');
      if (thisAction == 'continue'){ return false; }
      mmrpg_action_panel('loading');
      if (thisAction.match(/^ability_([-a-z0-9_]+)$/i)){
        var thisAbility = thisAction.replace(/^ability_([-a-z0-9_]+)$/i, '$1');
        mmrpg_engine_update({this_action_token:thisAbility});
        thisAction = 'ability';
        } else if (thisAction.match(/^switch_([-a-z0-9_]+)$/i)){
        var thisSwitch = thisAction.replace(/^switch_([-a-z0-9_]+)$/i, '$1');
        //alert(thisSwitch);
        mmrpg_engine_update({this_action_token:thisSwitch});
        thisAction = 'switch';
        } else if (thisAction.match(/^scan_([-a-z0-9_]+)$/i)){
        var thisScan = thisAction.replace(/^scan_([-a-z0-9_]+)$/i, '$1');
        //alert(thisScan);
        mmrpg_engine_update({this_action_token:thisScan});
        thisAction = 'scan';
        }
      //alert(thisAction);
      mmrpg_engine_update({this_action:thisAction});
      gameEngine.submit();
      });

    // Add a specialized click event for the gameActions continue button
    $('a[data-action=continue]', gameActions).live('click', function(e){
      mmrpg_events();
      });

    // Trigger the panel switch to the "next" action
    var nextAction = $('input[name=next_action]', gameEngine).val();
    if (nextAction.length){ mmrpg_action_panel(nextAction); }

  }

  /*
   * MOBILE EVENTS
   */

  // Check if we're running the game in mobile mode
  if (gameWAP){

    // Remove the hard-coded heights for the main iframe
    $('iframe', gameWindow).removeAttr('width').removeAttr('height');

    // Let the user know about the full-screen option for mobile browsers
    if (('standalone' in window.navigator) && !window.navigator.standalone){
      //alert('Please use "Add to Home Screen" option for best view! :)');
      } else if (('standalone' in window.navigator) && window.navigator.standalone){
      //alert('launched from full-screen ready browser, and in full screen!');
      $('body').addClass('mobileFlag_fullScreen');
      } else {
      //alert('launched from a regular old browser...');
      }

    // Prevent window scrolling, or scrolling of any kind, for mobile views
    $(document).bind('touchmove', function(e){
      //alert('touchmove');
      e.preventDefault();
      });

    // Change the body's orientation flag classes
    orientationModeUpdate('startup');
    window.onorientationchange = function(){ return orientationModeUpdate('onorientationchange'); }
    window.onresize = function(){ return orientationModeUpdate('onresize'); }
    window.onscroll = function(){ return orientationModeUpdate('onscroll'); }

  }

});


// Define a function for updating the orientation Mode
function orientationModeUpdate(updateType){
  // Check if this is the main window or if it's a child
  if (window === window.top){
    // If this is the main window, collect it's orientation variable
    if (!isNaN(window.orientation)){ var orientationMode = (window.orientation == 0 || window.orientation == 180) ? 'portrait' : 'landscape'; }
    else { var orientationMode = ($(window).width() < 980) ? 'portrait' : 'landscape'; }
    } else {
    // Otherwise, check the parent window's orientation variable
    parent.window.testValue = true;
    if (!isNaN(parent.window.orientation)){ var orientationMode = (parent.window.orientation == 0 || parent.window.orientation == 180) ? 'portrait' : 'landscape'; }
    else { var orientationMode = ($(parent.window).width() < 980) ? 'portrait' : 'landscape'; }
    }
  // Update the orientation variables on this window's body elements
  if (orientationMode == 'portrait'){ $('body').removeClass('mobileFlag_landscapeMode').addClass('mobileFlag_portraitMode'); }
  else { $('body').removeClass('mobileFlag_portraitMode').addClass('mobileFlag_landscapeMode'); }
  // Reset the window scroll to center elements properly
  window.scrollTo(0, 1);
  if (window !== window.top){ parent.window.scrollTo(0, 1); }
  //$('body').css('border', '10px solid red').animate({borderWidth : '0'}, 1000, 'swing');
  // DEBUG
  //alert('<body class="'+$('body').attr('class')+'">\n'+updateType+'\n</body>');
  // Check if this is a child frame and this is not a startup call
  if (window !== window.top){
    // Alert the user of the orientation change (used to fix a bug with iframe not updating)
    parent.window.location.hash = '#'+orientationMode;
    //alert('Screen orientation changed...\nGame display updated!');
    }
  // Return the final orientation mode
  return orientationMode;
}

function localFunction(myMessage){
  alert(myMessage);
}

// Define a function for preloading field sprites
var field_sprite_cache = {};
var field_sprite_frames = ['base'];
var field_sprite_kinds = ['background', 'foreground'];
var field_sprite_type = 'png';
function mmrpg_preload_field_sprites(fieldToken){
  // If this sprite has not already been cached
  if (!field_sprite_cache[fieldToken]){
    //alert('creating sprite cache for '+fieldToken);
    // Define the container for this robot's cache
    field_sprite_cache[fieldToken] = [];
    // Define the sprite path and counter values
    var sprite_path = 'images/fields/'+fieldToken+'/';
    var num_frames = field_sprite_frames.length;
    var num_kinds = field_sprite_kinds.length;
    // Loop through all the sizes and frames
    for (var i = 0; i < num_frames; i++){
      for (var j = 0; j < num_kinds; j++){
        // Collect the current frame, size, and filename
        var this_frame = field_sprite_frames[i];
        var this_kind = field_sprite_kinds[j];
        var file_name = 'battle-field_'+this_kind+'_'+this_frame+'.'+field_sprite_type;
        // Cache this image in the apporiate array
        var cacheImage = document.createElement('img');
        cacheImage.src = sprite_path+file_name;
        field_sprite_cache[fieldToken].push(cacheImage);
        //alert(field_path+file_name);
      }
    }
  }
  //alert('sprite cache '+field_sprite_cache[fieldToken].length);
}

// Define a function for preloading robot sprites
var robot_sprite_cache = {};
var robot_sprite_frames = ['base', 'attack', 'defend', 'damage', 'disabled'];
var robot_sprite_sizes = [40, 80];
var robot_sprite_type = 'png';
function mmrpg_preload_robot_sprites(robotToken, robotDirection){
  // If this sprite has not already been cached
  if (!robot_sprite_cache[robotToken]){
    //alert('creating sprite cache for '+robotToken);
    // Define the container for this robot's cache
    robot_sprite_cache[robotToken] = [];
    // Define the sprite path and counter values
    //var sprite_path = 'images/robots/'+robotToken+'/';
    var sprite_path = 'images/robots/';
    var num_frames = robot_sprite_frames.length;
    var num_sizes = robot_sprite_sizes.length;
    // Loop through all the sizes and frames
    for (var i = 0; i < num_frames; i++){
      for (var j = 0; j < num_sizes; j++){
        // Collect the current frame, size, and filename
        var this_frame = robot_sprite_frames[i];
        var this_size = robot_sprite_sizes[j];
        //var file_name = 'robot-sprite_'+robotDirection+'_'+this_frame+'_'+this_size+'x'+this_size+'.'+robot_sprite_type;
        var file_name = 'robot_'+robotToken+'_'+this_size+'x'+this_size+'.'+robot_sprite_type;
        // Cache this image in the apporiate array
        var cacheImage = document.createElement('img');
        cacheImage.src = sprite_path+file_name;
        robot_sprite_cache[robotToken].push(cacheImage);
        //alert(sprite_path+file_name);
      }
    }
  }
  //alert('sprite cache '+sprite_cache[robotToken].length);
}

// Define a function for updating the engine form
function mmrpg_engine_update(newValues){
  if (gameEngine.length){
    for (var thisName in newValues){
      var thisValue = newValues[thisName];
      if ($('input[name='+thisName+']', gameEngine).length){
        $('input[name='+thisName+']', gameEngine).val(thisValue);
        } else {
        gameEngine.append('<input type="hidden" class="hidden" name="'+thisName+'" value="'+thisValue+'" />');
        }
      }
    }
}

// Define a function for switching to a different action panel
function mmrpg_action_panel(thisPanel){
  // Switch to the event actions panel
  $('.wrapper', gameActions).css({display:'none'});
  $('#actions_'+thisPanel, gameActions).css({display:''});
}

// Define a function for updating an action panel's markup
function mmrpg_action_panel_update(thisPanel, thisMarkup){
  // Update the requested panel with the supplied markup
  $('#actions_'+thisPanel, gameActions).empty().html(thisMarkup);
}

// Define a global variable for holding events
var mmrpgEvents = [];
// Define a function for queueing up an event
function mmrpg_event(flagsMarkup, dataMarkup, canvasMarkup, consoleMarkup){
  mmrpgEvents.push({
    'event_functions' : function(){
      if (dataMarkup.length){
        dataMarkup = $.parseJSON(dataMarkup);
        mmrpg_canvas_update(
          dataMarkup.this_battle,
          dataMarkup.this_field,
          dataMarkup.this_player,
          dataMarkup.this_robot,
          dataMarkup.target_player,
          dataMarkup.target_robot
          );
        }
      if (canvasMarkup.length){
        mmrpg_canvas_event(canvasMarkup, flagsMarkup);
        }
      if (consoleMarkup.length){
        mmrpg_console_event(consoleMarkup, flagsMarkup);
        }
      },
    'event_flags' : $.parseJSON(flagsMarkup)
      });
}
// Define a function for playing the events
function mmrpg_events(){
  var thisEvent = false;
  if (mmrpgEvents.length){
    // Switch to the events panel
    mmrpg_action_panel('event');
    // Collect the topmost event and execute it
    thisEvent = mmrpgEvents.shift();
    thisEvent.event_functions();
    }
  if (mmrpgEvents.length < 1){
    // Switch to the specified "next" action
    var nextAction = $('input[name=next_action]', gameEngine).val();
    if (nextAction.length){ mmrpg_action_panel(nextAction); }
    } else if (mmrpgEvents.length >= 1){
      if (thisEvent.event_flags.autoplay != false || mmrpgEvents.length == 1){
        var autoClickTimer = setTimeout(function(){
          mmrpg_events();
          }, 1500);
        $('a[data-action="continue"]').addClass('button_disabled');
        } else {
        $('a[data-action="continue"]').removeClass('button_disabled');
        }
      $('a[data-action="continue"]').click(function(){
        clearTimeout(autoClickTimer);
        });
    }
}

// Define a function for creating a new layer on the canvas
function mmrpg_canvas_event(thisMarkup){
  var thisContext = $('.wrapper', gameCanvas);
  if (thisContext.length){
    // Drop all the z-indexes to a single amount
    $('.event', thisContext).css({zIndex:500});
    // Calculate the top offset based on previous event height
    var eventTop = $('.event:first-child', thisContext).outerHeight();
    // Prepend the event to the current stack but bring it to the front
    var thisEvent = $('<div class="event">'+thisMarkup+'</div>');
    thisEvent.css({opacity:0.0,zIndex:600});
    thisContext.prepend(thisEvent);
    // Animate a fade in, and the remove the old images
    thisEvent.animate({opacity:1.0}, {
      duration: 400, //300,
      easing: 'linear',
      complete: function(){
        $('.event:gt(0)', thisContext).remove();
        $(this).css({zIndex:500});
        },
      queue: true
      });
    }
}


// Define a function for updating the graphics on the canvas
function mmrpg_canvas_update(thisBattle, thisPlayer, thisRobot, targetPlayer, targetRobot){
  // Preload all this robot's sprite image files if not already
  if (thisPlayer.player_side && thisRobot.robot_token){
    var thisRobotToken = thisRobot.robot_token;
    var thisRobotSide = thisPlayer.player_side == 'right' ? 'left' : 'right';
    mmrpg_preload_robot_sprites(thisRobotToken, thisRobotSide);
    }
  // Preload all the target robot's sprite image files if not already
  if (targetPlayer.player_side && targetRobot.robot_token){
    var targetRobotToken = targetRobot.robot_token;
    var targetRobotSide = targetPlayer.player_side == 'right' ? 'left' : 'right';
    mmrpg_preload_robot_sprites(targetRobotToken, targetRobotSide);
    }
  /*
  // Preload all of this battle's field image files
  if (thisBattle.battle_field){
    var thisFieldToken = thisBattle.battle_field.field_background;
    mmrpg_preload_field_sprites(thisFieldToken);
    }
  // Preload all of this player's robot sprite image files
  if (thisPlayer.player_robots){
    var thisRobotKey;
    var thisRobotSide = thisPlayer.player_side == 'right' ? 'left' : 'right';
    for (thisRobotKey in thisPlayer.player_robots){
      var thisRobotToken = thisPlayer.player_robots[thisRobotKey];
      mmrpg_preload_robot_sprites(thisRobotToken, thisRobotSide);
      }
    }
  // Preload all of the target player's robot sprite image files
  if (targetPlayer.player_robots){
    var targetRobotKey;
    var targetRobotSide = targetPlayer.player_side == 'right' ? 'left' : 'right';
    for (targetRobotKey in targetPlayer.player_robots){
      var targetRobotToken = thisPlayer.player_robots[thisRobotKey];
      mmrpg_preload_robot_sprites(targetRobotToken, targetRobotSide);
      }
    }
  */
}


// Define a function for appending a event to the console window
function mmrpg_console_event(thisMarkup){
  var thisContext = $('.wrapper', gameConsole);
  if (thisContext.length){
    // Append the event to the current stack
    //thisContext.prepend('<div class="event" style="top: -100px;">'+thisMarkup+'</div>');
    thisContext.prepend(thisMarkup);
    $('.event:first-child', thisContext).css({top:-100});
    $('.event:first-child', thisContext).animate({top:0}, 400, 'swing');
    $('.event:eq(1)', thisContext).animate({opacity:0.90}, 100, 'swing');
    $('.event:eq(2)', thisContext).animate({opacity:0.80}, 100, 'swing');
    $('.event:eq(3)', thisContext).animate({opacity:0.70}, 100, 'swing');
    $('.event:eq(4)', thisContext).animate({opacity:0.65}, 100, 'swing');
    $('.event:eq(5)', thisContext).animate({opacity:0.60}, 100, 'swing');
    $('.event:eq(6)', thisContext).animate({opacity:0.55}, 100, 'swing');
    $('.event:eq(7)', thisContext).animate({opacity:0.50}, 100, 'swing');
    $('.event:eq(8)', thisContext).animate({opacity:0.45}, 100, 'swing');
    $('.event:gt(8)', thisContext).animate({opacity:0.40}, 100, 'swing');
    // Remove any leftover boxes from previous events
    $('.event:gt(10)', thisContext).remove();
    }
}



/**
 * Function : dump()
 * Arguments: The data - array,hash(associative array),object
 *    The level - OPTIONAL
 * Returns  : The textual representation of the array.
 * This function was inspired by the print_r function of PHP.
 * This will accept some data as the argument and return a
 * text that will be a more readable version of the
 * array/hash/object that is given.
 * Docs: http://www.openjs.com/scripts/others/dump_function_php_print_r.php
 */
function dump(arr,level) {
  var dumped_text = "";
  if(!level) level = 0;

  //The padding given at the beginning of the line.
  var level_padding = "";
  for(var j=0;j<level+1;j++) level_padding += "    ";

  if(typeof(arr) == 'object') { //Array/Hashes/Objects
    for(var item in arr) {
      var value = arr[item];

      if(typeof(value) == 'object') { //If it is an array,
        dumped_text += level_padding + "'" + item + "' ...\n";
        dumped_text += dump(value,level+1);
      } else {
        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
      }
    }
  } else { //Stings/Chars/Numbers etc.
    dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
  }
  return dumped_text;
}
