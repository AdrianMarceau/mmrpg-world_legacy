
// Initialize the MMRPG global variables
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
  gameDebug = $('#debug');
  
  /*
   * INDEX EVENTS
   */
  
  // Ensure this is the battle document
  if (gameWindow.length){
    
    // Add click-events to the debug panel links
    $('a.battle', gameDebug).live('click', function(e){
      var windowFrame = $('iframe', gameWindow);
      var thisLink = $(this).attr('href');
      if (windowFrame.attr('src') != 'about:blank'){
        e.preventDefault();
        var thisConfirm = 'Are you sure you want to switch battles?  Progress will be lost and all robots will be reset.';
        if (confirm(thisConfirm)){ 
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
  
  

  
});

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
var robot_sprite_frames = ['base', 'attack', 'defend', 'damage'];
var robot_sprite_sizes = [40, 80];
var robot_sprite_type = 'gif';
function mmrpg_preload_robot_sprites(robotToken, robotDirection){
  // If this sprite has not already been cached
  if (!robot_sprite_cache[robotToken]){
    //alert('creating sprite cache for '+robotToken);
    // Define the container for this robot's cache
    robot_sprite_cache[robotToken] = [];
    // Define the sprite path and counter values
    var sprite_path = 'images/robots/'+robotToken+'/';
    var num_frames = robot_sprite_frames.length;
    var num_sizes = robot_sprite_sizes.length;
    // Loop through all the sizes and frames
    for (var i = 0; i < num_frames; i++){
      for (var j = 0; j < num_sizes; j++){
        // Collect the current frame, size, and filename
        var this_frame = robot_sprite_frames[i];
        var this_size = robot_sprite_sizes[j];
        var file_name = 'robot-sprite_'+robotDirection+'_'+this_frame+'_'+this_size+'x'+this_size+'.'+robot_sprite_type;
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
function mmrpg_event(dataMarkup, canvasMarkup, consoleMarkup){
  mmrpgEvents.push(function(){
    if (dataMarkup.length){
      dataMarkup = $.parseJSON(dataMarkup); 
      mmrpg_canvas_update(
        dataMarkup.this_battle, 
        dataMarkup.this_player, 
        dataMarkup.this_robot, 
        dataMarkup.target_player, 
        dataMarkup.target_robot
        );
      }
    if (canvasMarkup.length){ 
      mmrpg_canvas_event(canvasMarkup); 
      }
    if (consoleMarkup.length){ 
      mmrpg_console_event(consoleMarkup); 
      }
    });
}
// Define a function for playing the events
function mmrpg_events(){
  if (mmrpgEvents.length){
    // Switch to the events panel
    mmrpg_action_panel('event');     
    // Collect the topmost event and execute it
    var thisFunction = mmrpgEvents.shift();
    thisFunction();
    }
  if (mmrpgEvents.length < 1){
    // Switch to the specified "next" action
    var nextAction = $('input[name=next_action]', gameEngine).val();
    if (nextAction.length){ mmrpg_action_panel(nextAction); } 
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
      duration: 300,
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
    thisContext.prepend('<div class="event" style="top: -100px;">'+thisMarkup+'</div>');
    $('.event:first-child', thisContext).animate({top:0}, 400, 'swing');
    $('.event:eq(1)', thisContext).animate({opacity:0.75}, 100, 'swing');
    $('.event:eq(2)', thisContext).animate({opacity:0.50}, 100, 'swing');
    $('.event:gt(2)', thisContext).animate({opacity:0.25}, 100, 'swing');
    // Remove any leftover boxes from previous events
    $('.event:gt(10)', thisContext).remove();
    }
}
