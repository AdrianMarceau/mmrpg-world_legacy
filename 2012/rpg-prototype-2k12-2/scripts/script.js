
// Initialize the MMRPG global variables
var gameEngine = false;
var gameConnect = false;
var gameCanvas = false;
var gameConsole = false;
var gameActions = false;
var gameSettings = {};

// Define the MMRPG global settings variables
gameSettings.cacheTime = '00000000-00'; // the timestamp of when this game was last updated
gameSettings.wapFlag = false; // whether or not this game is running in mobile mode
gameSettings.eventTimeout = 1250; // default animation frame base internal
gameSettings.eventAutoPlay = true; // whether or not to automatically advance events

// Initialize document ready events
$(document).ready(function(){

  // Define the MMRPG global context variables
  gameWindow = $('#window');
  gameEngine = $('#engine');
  gameConnect = $('#connect');
  gameCanvas = $('#canvas');
  gameConsole = $('#console');
  gameActions = $('#actions');
  gameBattle = $('#battle');
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
        if (confirm(thisConfirm)){ 
        //if (true){ 
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
      // Collect the action and preload, if set
      var thisAction = $(this).attr('data-action');
      var thisPreload = $(this).attr('data-preload')  !== undefined ? $(this).attr('data-preload') : false;
      // Trigger the requested action and return the result
      return mmrpg_action_trigger(thisAction, thisPreload);
      });
    
    // Add a hover event to all the gameAction sprites
    $('.sprite[data-action]', gameCanvas)
      .live('mouseenter', function(){
        if ($('#actions_scan', gameActions).is(':visible')){
          $(this).css({cursor:'pointer'});
          var thisSize = $(this).hasClass('sprite_40x40') ? 40 : 80;
          $(this).addClass('sprite_'+thisSize+'x'+thisSize+'_focus');
          var thisOffset = parseInt($(this).css('z-index'));
          $('.event', gameCanvas).append('<div class="scan_overlay" style="z-index: '+(thisOffset-1)+';">&nbsp;</div>');
          } else {
          $(this).css({cursor:'default'});
          return false;  
          }
        })
      .live('mouseleave', function(){
        var thisSize = $(this).hasClass('sprite_40x40') ? 40 : 80;
        $(this).removeClass('sprite_'+thisSize+'x'+thisSize+'_focus');
        $('.scan_overlay', gameCanvas).remove();
        });
    // Add scan functionality to all on-screen robot sprites
    $('.sprite[data-action]', gameCanvas).live('click', function(){
      if ($('#actions_scan', gameActions).is(':visible')){
        $(this).css({cursor:'pointer'});
        // Collect the action and preload, if set
        var thisAction = $(this).attr('data-action');
        var thisPreload = $(this).attr('data-preload')  !== undefined ? $(this).attr('data-preload') : false;
        // Remove the focus class now clicked
        var thisSize = $(this).hasClass('sprite_40x40') ? 40 : 80;
        $(this).removeClass('sprite_'+thisSize+'x'+thisSize+'_focus');
        // Trigger the requested action and return the result
        return mmrpg_action_trigger(thisAction, thisPreload);      
        } else {
        $(this).css({cursor:'default'});
        return false;
        }
      });
    
    // Add a specialized click event for the gameActions continue button
    $('a[data-action=continue]', gameActions).live('click', function(e){
      mmrpg_events();
      });
    
    // Start animating the canvas randomly
    //mmrpg_canvas_animate();
    
    // Trigger the panel switch to the "next" action
    var nextAction = $('input[name=next_action]', gameEngine).val();
    if (nextAction.length){ mmrpg_action_panel(nextAction); }
    
  }
  
  /*
   * WINDOW RESIZE EVENTS
   */
  
  if (!gameSettings.wapFlag){
    
    // Remove the hard-coded heights for the main iframe
    $('iframe', gameWindow).removeAttr('width').removeAttr('height');
    
    // Trigger the windowResizeUpdate function automatically
    windowResizeUpdate('startup');
    window.onresize = function(){ return windowResizeUpdate('onresize'); }
    
  }
  
  
  /*
   * MOBILE EVENTS
   */
  
  // Check if we're running the game in mobile mode
  if (gameSettings.wapFlag){    
    
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
    $('*').live('touchstart', function () {
      this.onclick = this.onclick || function () { };
      });
    
    // Change the body's orientation flag classes
    orientationModeUpdate('startup');
    window.onorientationchange = function(){ return orientationModeUpdate('onorientationchange'); }
    window.onresize = function(){ return orientationModeUpdate('onresize'); }
    window.onscroll = function(){ return orientationModeUpdate('onscroll'); }
        
  }
  
  // Kill the animation queue if the window is unfocused
  $(window)
    .blur(function(){
    gameSettings.eventAutoPlay = false;
    clearTimeout(canvasAnimationTimeout);
    })
    .focus(function(){
    gameSettings.eventAutoPlay = true;
    mmrpg_canvas_animate(); 
    });
    /*
    .focusout(function(){
    gameSettings.eventAutoPlay = false;
    clearTimeout(canvasAnimationTimeout);
    alert('focusout');
    })
    .focusin(function(){
    gameSettings.eventAutoPlay = true;
    mmrpg_canvas_animate();  
    alert('focusin');    
    });
    */
  
});

// Define a function for updating the window sizes
function windowResizeUpdate(updateType){
  // Define the base values to resize from
  var canvasHeight = 267;
  var consoleHeight = 256;
  var consoleMessageHeight = 64;
  var actionsHeight = 225;
  
  // Check if this is the main window or if it's a child
  if (window === window.top){
    // Collect this window's width and height
    var windowWidth = $(window).width();
    var windowHeight = $(window).height();
    var gameWidth = gameWindow.width();
    var gameHeight = gameWindow.height();
    } else {
    // Collect the parent window's width and height
    var windowWidth = $(parent.window).width();
    var windowHeight = $(parent.window).height();
    var gameWidth = parent.gameWindow.width();
    var gameHeight = parent.gameWindow.height();        
    }
  
  // Check if the window is in landscape mode
  if (windowWidth >= (1024 + 12)){ $('body').addClass('windowFlag_landscapeMode'); } 
  else { $('body').removeClass('windowFlag_landscapeMode'); }  
  
  // Calculate the new game and console height values
  var newGameHeight = windowHeight - 25; //15;
  var newConsoleHeight = newGameHeight - (canvasHeight + actionsHeight);
  
  if ((newConsoleHeight - 3) < (consoleMessageHeight * 2)){
    var thisMinimum = consoleMessageHeight * 2;
    newGameHeight = newGameHeight + (thisMinimum - newConsoleHeight);
    newConsoleHeight = thisMinimum + 3;
    } else if ((newConsoleHeight - 3) %  consoleMessageHeight != 0){
    var thisRemainer = (newConsoleHeight - 3) %  consoleMessageHeight;
    newGameHeight = newGameHeight - thisRemainer;
    newConsoleHeight = newConsoleHeight - thisRemainer;
    }
  
  // If the console exists, resize it
  if (gameConsole.length && !gameConsole.hasClass('noresize')){ gameConsole.height(newConsoleHeight - 3); }
  gameWindow.height(newGameHeight);
  $('iframe', gameWindow).height(newGameHeight - 6);
  
  // Calculate the new console height
  
  /*
  alert('windowWidth:'+windowWidth+', windowHeight:'+windowHeight+',\n'+
        'gameWidth:'+gameWidth+', gameHeight:'+gameHeight+',\n'+
        'consoleHeight:'+consoleHeight+', newConsoleHeight:'+(gameHeight - (canvasHeight + actionsHeight))+'');
  */
  
  // Reset the window scroll to center elements properly
  window.scrollTo(0, 1);
  if (window !== window.top){ parent.window.scrollTo(0, 1); }
  
  // Return true on success
  return true;  
}




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
  // Determine if this user is running is non-fullscreen mode
  var notFullscreenMode = ('standalone' in window.navigator) && !window.navigator.standalone ? true : false;
  // Update the orientation variables on this window's body elements
  if (orientationMode == 'portrait'){ 
    $('body').removeClass('mobileFlag_landscapeMode').addClass('mobileFlag_portraitMode'); 
    if (notFullscreenMode){ $('body').removeClass('mobileFlag_landscapeMode_notFullscreen').addClass('mobileFlag_portraitMode_notFullscreen');  } 
    } else { 
    $('body').removeClass('mobileFlag_portraitMode').addClass('mobileFlag_landscapeMode'); 
    if (notFullscreenMode){ $('body').removeClass('mobileFlag_portraitMode_notFullscreen').addClass('mobileFlag_landscapeMode_notFullscreen');   }
    }
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

// Define a function for randomly animating canvas robots
var backgroundDirection = 'left';
var canvasAnimationTimeout = false;
function mmrpg_canvas_animate(){
  //alert('animation loop');
  // Loop through all field layers on the canvas
  $('.background[data-animate],.foreground[data-animate]', gameCanvas).each(function(){
    // Trigger an animation frame change for this field
    var thisField = $(this);
    mmrpg_canvas_field_frame(thisField, '');
    });  
  // Loop through all robots on the field
  $('.sprite[data-type=robot]', gameCanvas).each(function(){
    // Collect a reference to the current robot
    var thisRobot = $(this);
    // Generate a random number
    var thisRandom = Math.floor(Math.random() * 100);
    // Default the new frame to base
    var newFrame = 'base';
    // Collect the current battle status
    var battleStatus = $('.input[name=this_battle_status]', gameEngine).val();
    // Higher animation freqency if not active
    if (thisRobot.attr('data-position') != 'active'){
      if (battleStatus == 'complete' && thisRandom <= 80){ newFrame = 'victory'; }
      else if (thisRandom <= 10){ newFrame = 'taunt'; }
      else if (thisRandom <= 20){ newFrame = 'defend'; }
      } else {
      if (battleStatus == 'complete' && thisRandom <= 80){ newFrame = 'victory'; }
      else if (thisRandom <= 3){ newFrame = 'defend'; }
      else if (thisRandom <= 6){ newFrame = 'taunt'; }  
      }
    mmrpg_canvas_robot_frame(thisRobot, newFrame);
    }); 
  // Loop through all players on the field
  $('.sprite[data-type=player]', gameCanvas).each(function(){
    // Collect a reference to the current player
    var thisPlayer = $(this);
    // Generate a random number
    var thisRandom = Math.floor(Math.random() * 100);
    // Default the new frame to base
    var newFrame = 'base';
    // Collect the current battle status
    var battleStatus = $('.input[name=this_battle_status]', gameEngine).val();
    // Higher animation freqency if not active
    if (thisPlayer.attr('data-position') != 'active'){
      if (battleStatus == 'complete' && thisRandom <= 80){ newFrame = 'victory'; }
      else if (thisRandom <= 50){ newFrame = 'taunt'; }
      } else {
      if (battleStatus == 'complete' && thisRandom <= 80){ newFrame = 'victory'; }
      else if (thisRandom <= 50){ newFrame = 'taunt'; } 
      }
    mmrpg_canvas_player_frame(thisPlayer, newFrame);
    });   
  // Loop through all attachments on the field
  $('.sprite[data-type=attachment]', gameCanvas).each(function(){
    // Collect a reference to the current attachment
    var thisAttachment = $(this);
    var thisAttachmentFrame = thisAttachment.attr('data-frame');
    var thisAnimateFrame = thisAttachment.attr('data-animate').split(',');
    var thisAnimateFrameCount = thisAnimateFrame.length;
    // Default the new frame to base
    if (thisAnimateFrameCount > 1){
      var thisIndex = thisAnimateFrame.indexOf(thisAttachmentFrame);
      if ((thisIndex + 1) < thisAnimateFrameCount){
        var newFrame = thisAnimateFrame[thisIndex + 1]; 
        } else { 
        var newFrame = thisAnimateFrame[0]; 
        }      
    } else {
      var newFrame = thisAnimateFrame[0];
    }
    // Trigger the frame change
    mmrpg_canvas_attachment_frame(thisAttachment, newFrame);
    });  
  // Reset the timeout event for another animation round
  canvasAnimationTimeout = setTimeout(function(){
    mmrpg_canvas_animate(); // DEBUG PAUSE
    }, gameSettings.eventTimeout);
  // Return true for good measure
  return true;
}

// Define a function for updating a fields's frame with animation
function mmrpg_canvas_field_frame(thisField, newFrame){
  // Generate a new frame if one was not provided
  if (newFrame == ''){
    // Collect a reference to the current field data
    var thisFieldFrame = thisField.attr('data-frame');
    var thisAnimateFrame = thisField.attr('data-animate').split(',');
    var thisAnimateFrameCount = thisAnimateFrame.length;
    // Default the new frame to base
    if (thisAnimateFrameCount > 1){
      var thisIndex = thisAnimateFrame.indexOf(thisFieldFrame);
      if ((thisIndex + 1) < thisAnimateFrameCount){
        var newFrame = thisAnimateFrame[thisIndex + 1]; 
        } else { 
        var newFrame = thisAnimateFrame[0]; 
        }      
    } else {
      var newFrame = thisAnimateFrame[0];
    }    
  }
  // Collect this field's data fields (hehe)
  var thisFrame = thisField.attr('data-frame');
  // If the new frame is the same as the current, return
  if (thisFrame == newFrame || thisField.is(':animated')){ return false; }
  // Define the current class (based on data) and the new class
  var fieldLayer = thisField.hasClass('background') ? 'background' : 'foreground'; 
  var currentClass = fieldLayer+'_'+thisFrame;
  var newClass = fieldLayer+'_'+newFrame;
  // Update this field's class to change the layer frame
  var cloneField = thisField.clone().css('z-index', '10').appendTo(thisField.parent());
  thisField.css({opacity:0}).attr('data-frame', newFrame).removeClass(currentClass).addClass(newClass);
  thisField.animate({opacity:1}, {duration:Math.ceil(gameSettings.eventTimeout * 0.5),easing:'swing',queue:false});
  cloneField.animate({opacity:1}, {duration:Math.ceil(gameSettings.eventTimeout * 0.5),easing:'swing',queue:false,complete:function(){ $(this).remove(); }});  
  // Return true on success
  return true;
}

// Define a function for updating a robot's frame with animation
function mmrpg_canvas_robot_frame(thisRobot, newFrame){
  // Collect this robot's data fields
  var thisSize = thisRobot.attr('data-size');
  var thisPosition = thisRobot.attr('data-position');
  var thisDirection = thisRobot.attr('data-direction');
  var thisStatus = thisRobot.attr('data-status');
  var thisFrame = thisRobot.attr('data-frame');
  // If the new frame is the same as the current, return
  if (thisFrame == newFrame){ return false; }
  // If this robot is disabled, do not animate
  if (thisStatus == 'disabled'){ return false; }
  // Define the current class (based on data) and the new class
  var currentClass = 'sprite_'+thisSize+'x'+thisSize+'_'+thisFrame;
  var newClass = 'sprite_'+thisSize+'x'+thisSize+'_'+newFrame;
  // Update this robot's class to change the sprite frame
  var cloneRobot = thisRobot.clone().css('z-index', '-=1').appendTo(thisRobot.parent());
  thisRobot.css({opacity:0}).attr('data-frame', newFrame).removeClass(currentClass).addClass(newClass);
  thisRobot.animate({opacity:1}, {duration:400,easing:'swing',queue:false});
  cloneRobot.animate({opacity:0}, {duration:400,easing:'swing',queue:false,complete:function(){ $(this).remove(); }});  
  // Return true on success
  return true;
}

// Define a function for updating a player's frame with animation
function mmrpg_canvas_player_frame(thisPlayer, newFrame){
  // Collect this player's data fields
  var thisSize = thisPlayer.attr('data-size');
  var thisPosition = thisPlayer.attr('data-position');
  var thisDirection = thisPlayer.attr('data-direction');
  var thisStatus = thisPlayer.attr('data-status');
  var thisFrame = thisPlayer.attr('data-frame');
  // If the new frame is the same as the current, return
  if (thisFrame == newFrame){ return false; }
  // If this player is disabled, do not animate
  if (thisStatus == 'disabled'){ return false; }
  // Define the current class (based on data) and the new class
  var currentClass = 'sprite_'+thisSize+'x'+thisSize+'_'+thisFrame;
  var newClass = 'sprite_'+thisSize+'x'+thisSize+'_'+newFrame;
  // Update this player's class to change the sprite frame
  var clonePlayer = thisPlayer.clone().css('z-index', '-=1').appendTo(thisPlayer.parent());
  thisPlayer.css({opacity:0}).attr('data-frame', newFrame).removeClass(currentClass).addClass(newClass);
  thisPlayer.animate({opacity:1}, {duration:400,easing:'swing',queue:false});
  clonePlayer.animate({opacity:0}, {duration:400,easing:'swing',queue:false,complete:function(){ $(this).remove(); }});  
  // Return true on success
  return true;
}

// Define a function for updating an attachment's frame with animation
function mmrpg_canvas_attachment_frame(thisAttachment, newFrame){
  // Collect this robot's data fields
  var thisSize = thisAttachment.attr('data-size');
  var thisPosition = thisAttachment.attr('data-position');
  var thisDirection = thisAttachment.attr('data-direction');
  var thisFrame = thisAttachment.attr('data-frame');
  // If the new frame is the same as the current, return
  if (thisFrame == newFrame){ return false; }
  // Define the current class (based on data) and the new class
  var currentClass = 'sprite_'+thisSize+'x'+thisSize+'_'+thisFrame;
  var newClass = 'sprite_'+thisSize+'x'+thisSize+'_'+newFrame;
  // Update this attachment's class to change the sprite frame
  var cloneAttachment = thisAttachment.clone().css('z-index', '-=1').appendTo(thisAttachment.parent());
  thisAttachment.css({opacity:0}).attr('data-frame', newFrame).removeClass(currentClass).addClass(newClass);
  thisAttachment.animate({opacity:1}, {duration:400,easing:'swing',queue:false});
  cloneAttachment.animate({opacity:0}, {duration:400,easing:'swing',queue:false,complete:function(){ $(this).remove(); }});  
  // Return true on success
  return true;
}

// Define a function for triggering an action submit
function mmrpg_action_trigger(thisAction, thisPreload){
  //alert('thisAction : '+thisAction);
  // Return false if this is a continue click
  if (thisAction == 'continue'){ return false; }
  // Switch to the loading screen
  mmrpg_action_panel('loading');
  // Parse any actions with subtokens in their string
  if (thisAction.match(/^ability_([-a-z0-9_]+)$/i)){
    // Parse the ability token and clean the main action token
    var thisAbility = thisAction.replace(/^ability_([-a-z0-9_]+)$/i, '$1');
    mmrpg_engine_update({this_action_token:thisAbility});
    thisAction = 'ability';
    } else if (thisAction.match(/^switch_([-a-z0-9_]+)$/i)){
    // Parse the switch token and clean the main action token
    var thisSwitch = thisAction.replace(/^switch_([-a-z0-9_]+)$/i, '$1');
    mmrpg_engine_update({this_action_token:thisSwitch});
    thisAction = 'switch';
    } else if (thisAction.match(/^scan_([-a-z0-9_]+)$/i)){
    // Parse the scan token and clean the main action token
    var thisScan = thisAction.replace(/^scan_([-a-z0-9_]+)$/i, '$1');
    mmrpg_engine_update({this_action_token:thisScan});
    thisAction = 'scan';
    } else if (thisAction.match(/^settings_([-a-z0-9]+)_([-a-z0-9_]+)$/i)){
    // Parse the settings token and value, then clean the action token
    var thisSettingToken = thisAction.replace(/^settings_([-a-z0-9]+)_([-a-z0-9_]+)$/i, '$1');
    var thisSettingValue = thisAction.replace(/^settings_([-a-z0-9]+)_([-a-z0-9_]+)$/i, '$2');
    gameSettings[thisSettingToken] = thisSettingValue;
    var thisRequestType = 'session';
    var thisRequestData = 'battle_settings,'+thisSettingToken+','+thisSettingValue;
    $.post('scripts/script.php',{requestType: 'session',requestData: 'battle_settings,'+thisSettingToken+','+thisSettingValue});
    thisAction = 'settings';
    var nextAction = $('input[name=next_action]', gameEngine).val();
    if (nextAction.length){ mmrpg_action_panel(nextAction); } 
    return true;
    }
  // Check if image preloading was requested
  if (thisPreload.length){
    // Preload the requested image
    var thisPreloadImage = $(document.createElement('img'))
      .attr('src', thisPreload)
      .load(function(){
        // Update the engine and trigger a submit event
        mmrpg_engine_update({this_action:thisAction});
        gameEngine.submit();
        return true;
        });
    } else {
      // Update the engine and trigger a submit event
      mmrpg_engine_update({this_action:thisAction});
      gameEngine.submit(); 
      return true;
      }  
}

// Define a function for preloading assets
var asset_sprite_cache = [];
var asset_sprite_images = [
  'images/assets/battle-scene_robot-details.gif',
  'images/assets/battle-scene_robot-results.gif',
  'images/abilities/ability-results/sprite_left_80x80.png',
  'images/abilities/ability-results/sprite_right_80x80.png'
  ];
function mmrpg_preload_assets(){
  // Loop through each of the asset images
  for (key in asset_sprite_images){
    // Define the sprite path value
    var sprite_path = asset_sprite_images[key];
    // Cache this image in the appropriate array
    var cacheImage = document.createElement('img');
    cacheImage.src = sprite_path;
    asset_sprite_cache.push(cacheImage);
  }
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
var robotSpriteCache = {};
var robotSpriteTypes = ['mug', 'sprite'];
var robotSpriteExtension = 'png';
function mmrpg_preload_robot_sprites(thisRobotToken, thisRobotDirection, thisRobotSize){
  // If this sprite has not already been cached
  if (!robotSpriteCache[thisRobotToken]){
    //alert('creating sprite cache for '+thisRobotToken);
    // Define the container for this robot's cache
    robotSpriteCache[thisRobotToken] = [];
    // Define the sprite path and counter values
    var robotSpritePath = 'images/robots/'+thisRobotToken+'/';
    var numRobotTypes = robotSpriteTypes.length;
    // Loop through all the sizes and frames
    for (var i = 0; i < numRobotTypes; i++){
      // Collect the current frame, size, and filename
      var thisSpriteType = robotSpriteTypes[i];
      var thisSpriteToken = thisSpriteType+'_'+thisRobotDirection+'_'+thisRobotSize+'x'+thisRobotSize;
      var thisSpriteFilename = thisSpriteToken+'.'+robotSpriteExtension;
      // Cache this image in the apporiate array
      var thisCacheImage = document.createElement('img');
      thisCacheImage.src = robotSpritePath+thisSpriteFilename;
      robotSpriteCache[thisRobotToken].push(thisCacheImage);
      //alert(robotSpritePath+thisSpriteFilename);
    }
  }
  //alert('sprite cache '+sprite_cache[thisRobotToken].length);
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
var actionPanelCache = [];
function mmrpg_action_panel_update(thisPanel, thisMarkup){
  // Update the requested panel with the supplied markup
  var thisActionPanel = $('#actions_'+thisPanel, gameActions);
  thisActionPanel.empty().html(thisMarkup);
  // Search for any sprites in this panel's markup
  $('.sprite', thisActionPanel).each(function(){
    var thisBackground = $(this).css('background-image').replace(/^url\((.*?)\)$/i, '$1');
    var cacheImage = document.createElement('img');
    cacheImage.src = thisBackground;
    actionPanelCache.push(cacheImage)
    });
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
  clearTimeout(canvasAnimationTimeout);
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
    // Start animating the canvas randomly
    mmrpg_canvas_animate();
    } else if (mmrpgEvents.length >= 1){
      if (gameSettings.eventAutoPlay && thisEvent.event_flags.autoplay != false){
        var autoClickTimer = setTimeout(function(){
          mmrpg_events();
          }, parseInt(gameSettings.eventTimeout));
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
    $('.event:not(.sticky)', thisContext).css({zIndex:500});
    // Calculate the top offset based on previous event height
    var eventTop = $('.event:not(.sticky):first-child', thisContext).outerHeight();
    // Prepend the event to the current stack but bring it to the front
    var thisEvent = $('<div class="event clearback">'+thisMarkup+'</div>');
    thisEvent.css({opacity:0.0,zIndex:600});
    thisContext.prepend(thisEvent);
    // Wait for all the event's assets to finish loading
    thisEvent.waitForImages(function(){
      // Animate a fade out of the other events
      $('.event:not(.sticky):gt(0)', thisContext).animate({opacity:0},{
        duration: 800,
        easing: 'linear',
        queue: false
        });
      // Loop through all field layers on the canvas and trigger animations
      $('.background[data-animate],.foreground[data-animate]', gameCanvas).each(function(){
        // Trigger an animation frame change for this field
        var thisField = $(this);
        mmrpg_canvas_field_frame(thisField, '');
        });      
      // Animate a fade in, and the remove the old images
      $(this).animate({opacity:1.0}, {
        duration: 400, //300,
        easing: 'linear',
        complete: function(){
          //$('.event:is(.sticky)', thisContext).find('.ability_damage,.ability_recovery').animate({opacity:0},400,'swing',function(){ $(this).remove(); });
          //var statMods = $('.event:not(.sticky):gt(0)', thisContext).find('.ability_damage,.ability_recovery').clone();
          //$('.event:is(.sticky)', thisContext).append(statMods);
          $('.event:not(.sticky):gt(0)', thisContext).remove();
          $(this).css({zIndex:500});
          },
        queue: false
        });       
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
    $('.event:gt(9)', thisContext).animate({opacity:0.40}, 100, 'swing');
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

// Define a jQuery function for preloading images
(function($){
  var cache = [];
  // Arguments are image paths relative to the current page.
  $.preLoadImages = function(){
    var args_len = arguments.length;
    for (var i = args_len; i--;){
      var cacheImage = document.createElement('img');
      cacheImage.src = arguments[i];
      cache.push(cacheImage);
    }
  }
})(jQuery)

// Define a jQuery function for waiting for images
;(function($) {
    // Namespace all events.
    var eventNamespace = 'waitForImages';

    // CSS properties which contain references to images. 
    $.waitForImages = {
        hasImageProperties: [
        'backgroundImage',
        'listStyleImage',
        'borderImage',
        'borderCornerImage'
        ]
    };
    
    // Custom selector to find `img` elements that have a valid `src` attribute and have not already loaded.
    $.expr[':'].uncached = function(obj) {
        // Ensure we are dealing with an `img` element with a valid `src` attribute.
        if ( ! $(obj).is('img[src!=""]')) {
            return false;
        }

        // Firefox's `complete` property will always be`true` even if the image has not been downloaded.
        // Doing it this way works in Firefox.
        var img = document.createElement('img');
        img.src = obj.src;
        return ! img.complete;
    };

    $.fn.waitForImages = function(finishedCallback, eachCallback, waitForAll) {

        // Handle options object.
        if ($.isPlainObject(arguments[0])) {
            eachCallback = finishedCallback.each;
            waitForAll = finishedCallback.waitForAll;
            finishedCallback = finishedCallback.finished;
        }

        // Handle missing callbacks.
        finishedCallback = finishedCallback || $.noop;
        eachCallback = eachCallback || $.noop;

        // Convert waitForAll to Boolean
        waitForAll = !! waitForAll;

        // Ensure callbacks are functions.
        if (!$.isFunction(finishedCallback) || !$.isFunction(eachCallback)) {
            throw new TypeError('An invalid callback was supplied.');
        };

        return this.each(function() {
            // Build a list of all imgs, dependent on what images will be considered.
            var obj = $(this),
                allImgs = [];

            if (waitForAll) {
                // CSS properties which may contain an image.
                var hasImgProperties = $.waitForImages.hasImageProperties || [],
                    matchUrl = /url\((['"]?)(.*?)\1\)/g;
                
                // Get all elements, as any one of them could have a background image.
                obj.find('*').each(function() {
                    var element = $(this);

                    // If an `img` element, add it. But keep iterating in case it has a background image too.
                    if (element.is('img:uncached')) {
                        allImgs.push({
                            src: element.attr('src'),
                            element: element[0]
                        });
                    }

                    $.each(hasImgProperties, function(i, property) {
                        var propertyValue = element.css(property);
                        // If it doesn't contain this property, skip.
                        if ( ! propertyValue) {
                            return true;
                        }

                        // Get all url() of this element.
                        var match;
                        while (match = matchUrl.exec(propertyValue)) {
                            allImgs.push({
                                src: match[2],
                                element: element[0]
                            });
                        };
                    });
                });
            } else {
                // For images only, the task is simpler.
                obj
                 .find('img:uncached')
                 .each(function() {
                    allImgs.push({
                        src: this.src,
                        element: this
                    });
                });
            };

            var allImgsLength = allImgs.length,
                allImgsLoaded = 0;

            // If no images found, don't bother.
            if (allImgsLength == 0) {
                finishedCallback.call(obj[0]);
            };

            $.each(allImgs, function(i, img) {
                
                var image = new Image;
                
                // Handle the image loading and error with the same callback.
                $(image).bind('load.' + eventNamespace + ' error.' + eventNamespace, function(event) {
                    allImgsLoaded++;
                    
                    // If an error occurred with loading the image, set the third argument accordingly.
                    eachCallback.call(img.element, allImgsLoaded, allImgsLength, event.type == 'load');
                    
                    if (allImgsLoaded == allImgsLength) {
                        finishedCallback.call(obj[0]);
                        return false;
                    };
                    
                });

                image.src = img.src;
            });
        });
    };
})(jQuery);