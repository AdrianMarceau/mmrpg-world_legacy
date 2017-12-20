<?php

// Require the top files
require('../../config.php');
require('../../apptop.php');

// Define the headers for this file
$html_title_text = 'RPG Sprite Animation Tests | '.$html_title_text;
$html_content_title = $html_content_title.' | RPG Sprite Animation Tests';
$html_content_description = 'Several different sprite and field animation techniques were experimented with during development of the Mega Man RPG.  This is one of those tests. ';

// Include the application top
require_once('_top.php');

// Now convert the headers to that of an HTML document
$CMS->header_html();

// Collect the players from the URL, if set
$this_player = !empty($_REQUEST['thisPlayer']) ? $_REQUEST['thisPlayer'] : '';
if (!empty($this_player)){ list($this_player_id, $this_player_robots) = explode(':', $this_player); }
else { $this_player_id = 2; $this_player_robots = '';  }
$target_player = !empty($_REQUEST['targetPlayer']) ? $_REQUEST['targetPlayer'] : '';
if (!empty($target_player)){ list($target_player_id, $target_player_robots) = explode(':', $target_player); }
else { $target_player_id = 3; $target_player_robots = '';  }

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">
        <div id="index">

            <div id="mmrpg" class="battle">

                <div id="canvas">
                    <?
                    $background_layers = array();
                    function background_layer($sprite = false, $position = false, $animate = false){
                        global $background_layers;
                        $background_layers[] = array('sprite' => $sprite, 'position' => $position, 'animate' => $animate);
                    }

                    // Display the layered elements of the current field
                    echo '<div class="background" data-animate="scroll" data-direction="up" data-timeout="100000" data-ybase="" data-yrange="50" data-loop="false" style="z-index: 10;"><div class="wrapper"><img src="images/fields/guts-field/battle-field_background_base.png?1" style="margin-left: -258px;" /></div></div>'."\n";
                    echo '<div class="background" data-animate="scroll" data-direction="right" data-timeout="5000" data-xbase="-60" data-xrange="20" data-ybase="20" data-yrange="5" style="z-index: 20;"><div class="wrapper"><img src="images/fields/guts-field/battle-field_middleground_base.png?1" style="margin-left: -60px; margin-top: 20px;" /></div></div>'."\n";
                    echo '<div class="background" data-animate="scroll" data-direction="right" data-timeout="4000" data-xbase="-160" data-xrange="70" data-ybase="50" data-yrange="10" style="z-index: 1000;"><div class="wrapper"><img src="images/fields/guts-field/battle-field_middleground_base.png?1" style="margin-left: -160px; margin-top: 150px;" /></div></div>'."\n";
                    echo '<div class="background" style="z-index: 30;"><div class="wrapper"><img src="images/fields/guts-field/battle-field_foreground_base.png?1" style="margin-left: -258px;" /></div></div>'."\n";
                    // Display the scanline layer if enabled
                    echo '<div class="background" style="z-index: 10000;"><div class="wrapper"><img src="images/gui/canvas-scanlines.png?1234" style="" /></div></div>'."\n";
                    ?>
                    <div class="sprites"><div class="wrapper"></div></div>
                </div>
                <div id="console">
                    <div class="wrapper">

                    </div>
                </div>
                <div id="actions">
                    <div class="wrapper">
                        <div class="menu menu_battle active" data-menu="battle">
                            <a href="#actions" class="button button_ability" data-menu="ability"><label>Ability</label></a>
                            <a href="#actions" class="button button_scan" data-menu="scan"><label>Scan</label></a>
                            <a href="#actions" class="button button_option" data-menu="option"><label>Option</label></a>
                            <a href="#actions" class="button button_move" data-menu="move"><label>Move</label></a>
                        </div>
                        <div class="menu menu_ability" data-menu="ability">
                            <a class="button button_ability" data-action="ability"><label>Ability</label></a>
                            <a class="button button_cancel" data-menu="battle"><label>Cancel</label></a>
                        </div>
                        <div class="menu menu_scan" data-menu="scan">
                            <a class="button button_scan" data-action="scan"><label>Scan</label></a>
                            <a class="button button_cancel" data-menu="battle"><label>Cancel</label></a>
                        </div>
                        <div class="menu menu_option" data-menu="option">
                            <a class="button button_option" data-action="option"><label>Option</label></a>
                            <a class="button button_cancel" data-menu="battle"><label>Cancel</label></a>
                        </div>
                        <div class="menu menu_move" data-menu="move">
                            <a class="button button_move" data-action="move"><label>Move</label></a>
                            <a class="button button_cancel" data-menu="battle"><label>Cancel</label></a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();


// Start the ouput buffer to collect styles
ob_start();
    ?>
        <? /* <link rel="icon" type="image/x-icon" href="images/favicon.ico" /> */ ?>
        <? /* <link type="text/css" href="styles/reset.css" rel="stylesheet" /> */ ?>
        <link type="text/css" href="styles/index.css" rel="stylesheet" />
        <style type="text/css">

        </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();

// Start the ouput buffer to collect scripts
ob_start();
    ?>
        <script type="text/javascript" src="scripts/jquery.js"></script>
        <script type="text/javascript" src="scripts/classes.js"></script>
        <script type="text/javascript" src="scripts/players.js"></script>
        <script type="text/javascript" src="scripts/robots.js"></script>
        <script type="text/javascript" src="scripts/abilities.js"></script>
        <script type="text/javascript" src="scripts/types.js"></script>
        <script type="text/javascript" src="scripts/index.js"></script>
        <script type="text/javascript">

            // Define this and the target player ids
            var thisPlayerID = <?=$this_player_id?>;
            var thisPlayerRobots = [<?=$this_player_robots?>];
            var targetPlayerID = <?=$target_player_id?>;
            var targetPlayerRobots = [<?=$target_player_robots?>];

            // Define the current game object
            var $mmrpg = new mmrpgEngine({});  //{};
            // Add this and the target player to the game object
            $mmrpg.addPlayers([thisPlayerID, targetPlayerID]);

            // Wait for the document to finish loading
            var documentActive = true;
            $(document).ready(function(){

                // Create focus and blur events on the window to pause action when idle
                $(window).blur(function(){ documentActive = false; stopSpriteAnimations(); });
                $(window).focus(function(){ documentActive = true; startSpriteAnimations(); });

                // Loop through all the players and start displaying stuff
                for (pid in $mmrpg.players){
                    var thisPlayer = $mmrpg.players[pid];

                    // Define the starting z-index to count down from
                    var thisLayer = 10;

                    // Create a sprite for this player on the canvas and trigger animation
                    //alert('Creating player sprite ('+thisPlayer.name+', '+thisLayer+')!');
                    createPlayerSprite(thisPlayer, thisLayer);

                    // Loop through all the robots and start displaying stuff
                    for (rid in thisPlayer.robots){
                        var thisRobot = thisPlayer.robots[rid];

                        // Decrement the layer depth for perspective
                        thisLayer -= 1;

                        // Create a sprite for this robot on the canvas and trigger animation
                        //alert('Creating the robot sprite ('+thisRobot.name+', '+thisLayer+')!');
                        createRobotSprite(thisRobot, thisLayer);

                        }

                    }

                // Start animating the middle background layer
                startBackgroundAnimations();


                // Prevent default action of clicking buttons
                $('#actions .button').click(function(e){
                    e.preventDefault();
                    //alert($('label', this).html());

                    // Start an ability animation
                    startAbilityAnimation();


                    });

                // DEBUG SPRITE CLICK
                $('#canvas .sprites .sprite').click(function(){

                    // Collect sprite object references
                    var thisPlayerID = $(this).attr('data-player') || 0;
                    var thisPlayer = thisPlayerID != 0 ? $mmrpg.players[thisPlayerID] : false;
                    var thisRobotID = $(this).attr('data-robot') || 0;
                    var thisRobot = thisPlayer != false && thisRobotID != 0 ? thisPlayer.robots[thisRobotID] : false;
                    var thisAbilityID = $(this).attr('data-ability') || 0;
                    var thisAbility = thisRobot != false && thisAbilityID != 0 ? thisRobot.abilities[thisAbilityID] : false;
                    var thisClass = 'unknown';
                    if (thisAbility != false){ thisClass = 'ability'; }
                    else if (thisRobot != false){ thisClass = 'robot' }
                    else if (thisPlayer != false){ thisClass = 'player' }

                    // DEBUG
                    /*
                    if (thisAbility != false){ alert(thisAbility.name); }
                    else if (thisRobot != false){ alert(thisRobot.name); }
                    else if (thisPlayer != false){ alert(thisPlayer.name); }
                    */

                    if (thisClass == 'robot'){

                        var thisTarget = thisRobot.getTarget();
                        if (thisTarget != false){
                            alert(thisRobot.name+' is targetting '+thisTarget.name+'!');
                            console.log(thisTarget);
                            }

                        }


                    });

            });




            // Define a function for creating a canvas sprite
            function createSprite(spriteClass, spriteData, spriteLayer){
                if (spriteClass == undefined){ alert('class not provided'); return false; }
                if (spriteData == undefined){ alert('data not provided'); return false; }
                if (spriteLayer == undefined){ spriteLayer = 100; }
                // If this is a player sprite we're dealing with
                if (spriteClass == 'players'){
                    var thisPlayer = spriteData;
                    // Create a sprite for this player on the canvas and trigger animation
                    var spriteID = 'sprite_players_'+thisPlayer.id;
                    var spriteTimeout = 1000;
                    var thisSprite = $('<div id="'+spriteID+'"></div>');
                    var thisSize = 50;
                    thisSprite.addClass('sprite').css({opacity:0,width:thisSize,height:thisSize,bottom:100,zIndex:(spriteLayer * 2)}).css(thisPlayer.side, '5px');
                    thisSprite.attr('data-class', 'players').attr('data-player', thisPlayer.id).attr('data-id', thisPlayer.id).attr('data-timeout', spriteTimeout);
                    thisSprite.append('<img src="images/players/'+thisPlayer.token+'/sprite_'+thisPlayer.direction+'_80x80.png" alt="'+thisPlayer.name+'" height="'+thisSize+'" />');
                    thisSprite.appendTo('#canvas .sprites .wrapper').animate({opacity:1},spriteTimeout,'swing',function(){
                            //alert('Attempting to animate '+spriteID);
                            animateSprite(spriteID);
                            });
                    }
                // Otherwise, if this is a robot sprite we're dealing with
                else if (spriteClass == 'robots'){
                    var thisRobot = spriteData;
                    var thisPlayer = $mmrpg.players[thisRobot.player];
                    //alert('thisRobot.player = '+thisRobot.player+' | '+'thisPlayer.counters.robots = '+thisPlayer.counters.robots);
                    // Create a sprite for this robot on the canvas and trigger animation
                    var thisScale = 1 - (thisRobot.position * 0.04);
                    var thisSize = 85 - Math.ceil((thisRobot.position + 1) * 5);
                    if (thisSize % 2 != 0){ thisSize += 1; }
                    var thisBottom = 35 + (thisRobot.position * 10) + (7 - thisRobot.position);  //(thisRobot.key * Math.floor(((thisRobot.key + 1)/8) * 20));
                    var thisLeft = 20 + (thisRobot.position * Math.ceil(320/8)); //20 + (thisRobot.position * Math.ceil(320/thisPlayer.countRobots())); //20 + (thisRobot.key * 40);
                    thisLeft = thisLeft - Math.ceil(((thisRobot.position + 1) / 8) * 90); //thisLeft - Math.ceil(((thisRobot.position + 1) / thisPlayer.countRobots()) * 90); //Math.ceil(10 + ( * (((thisPlayer.robots.length - thisRobot.key) / thisPlayer.robots.length) * 45)));
                    if (thisLeft < 0){ thisLeft = 0; }
                    var spriteID = 'sprite_robots_'+thisRobot.id;
                    var spritePosition = thisRobot.position + 1;
                    var spriteTimeout = Math.ceil(2100 - (1100 * (thisRobot.speed / 100)));
                    //alert('createSprite('+spriteClass+', '+spriteData.name+', '+spriteLayer+') ('+spriteID+', '+spriteTimeout+')');
                    var thisSprite = $('<div id="'+spriteID+'"></div>');
                    thisSprite.addClass('sprite').css({opacity:0,width:thisSize,height:thisSize,bottom:thisBottom+'px',zIndex:(spriteLayer * 10)}).css(thisRobot.side, thisLeft);
                    thisSprite.attr('data-class', 'robots').attr('data-player', thisPlayer.id).attr('data-robot', thisRobot.id).attr('data-id', thisRobot.id).attr('data-timeout', spriteTimeout).attr('data-position', spritePosition).attr('data-scale', thisScale);
                    thisSprite.append('<img src="images/robots/'+thisRobot.token+'/sprite_'+thisRobot.direction+'_80x80.png" alt="'+thisRobot.name+'" height="'+thisSize+'" />');
                    thisSprite.appendTo('#canvas .sprites .wrapper').animate({opacity:1},spriteTimeout,'swing',function(){
                            //alert('Attempting to animate '+spriteID);
                            animateSprite(spriteID);
                            });
                }
                // Return true on success
                //return true;
            }
            function createPlayerSprite(spriteData, spriteLayer){ createSprite('players', spriteData, spriteLayer);  }
            function createRobotSprite(spriteData, spriteLayer){ createSprite('robots', spriteData, spriteLayer);  }
            function createAbilitySprite(spriteData, spriteLayer){ createSprite('abilities', spriteData, spriteLayer);  }

            // Define a function for starting the animation of a background layer
            function animateBackground(thisBackground, thisDirection){
                if (!documentActive){ return false; }
                var thisTimeout = parseInt(thisBackground.attr('data-timeout')) || 1000;
                var thisLoop = thisBackground.attr('data-loop') == 'false' ? false : true;
                var xRange = thisBackground.attr('data-xrange') || 0;
                var yRange = thisBackground.attr('data-yrange') || 0;
                var newCSS = {};
                if (thisDirection == undefined){ thisDirection = thisBackground.attr('data-direction'); }
                if (thisDirection == 'left' || thisDirection == 'down'){
                    newCSS.marginLeft = '-='+xRange+'px'; newCSS.marginTop = '+='+yRange+'px';
                    var newDirection = thisDirection == 'left' ? 'right' : 'up';
                    } else if (thisDirection == 'right' || thisDirection == 'up'){
                    newCSS.marginLeft = '+='+xRange+'px'; newCSS.marginTop = '-='+yRange+'px';
                    var newDirection = thisDirection == 'right' ? 'left' : 'down';
                    }
                $('img', thisBackground).animate(newCSS,thisTimeout,'linear',function(){
                    if (thisLoop){
                        animateBackground(thisBackground, newDirection);
                        }
                    });
            }
            // Define a function for starting the animations of background layers
            function startBackgroundAnimations(){
                $('#canvas .background[data-animate]').each(function(index, element){
                    var thisBackground = $(this);
                    animateBackground(thisBackground);
                    });
            }

            // Define a function for stopping the animation of  background layers
            function stopBackgroundAnimations(){
                $('#canvas .background[data-animate] img').stop(true, false);
            }

            // Define the sprite animation global variables and defaults
            var animatedSprites = {players:[],robots:[],abilities:[]};
            var animationFramesIndex = {players:[],robots:[],abilities:[]};
            var animationFramesIdle = {players:[],robots:[],abilities:[]};
            animationFramesIndex.players = ['base','taunt','victory','defeat','command','damage'];
            animationFramesIdle.players = ['base','base','base','taunt','command'];
            animationFramesIndex.robots = ['base','taunt','victory','defeat','shoot','throw','summon','slide','defend','damage'];
            animationFramesIdle.robots = ['base','base','base','taunt','defend'];
            animationFramesIndex.abilities = ['base'];
            animationFramesIdle.abilities = ['base'];
            // Define the function for animating battle sprites
            function animateSprite(thisID, newFrame){
                clearTimeout(animatedSprites[thisID]);
                if (!documentActive){ return false; }
                var thisSprite = $('#'+thisID);
                if (!thisSprite.length){ alert(thisID+' was not found!'); }
                var playerID = thisSprite.attr('data-player') || 0;
                var robotID = thisSprite.attr('data-robot') || 0;
                var abilityID = thisSprite.attr('data-ability') || 0;
                var spriteID = thisSprite.attr('data-id');
                var spriteClass = thisSprite.attr('data-class');
                var spriteFrame = thisSprite.attr('data-frame');
                var spriteTimeout = parseInt(thisSprite.attr('data-timeout'));
                var spriteSize = thisSprite.height();
                if (newFrame == undefined){
                    var frameOptions = animationFramesIdle[spriteClass];
                    newFrame = frameOptions[Math.floor((Math.random()*frameOptions.length))];
                    }
                thisSprite.attr('data-frame', newFrame);
                var newFrameIndex = animationFramesIndex[spriteClass].indexOf(newFrame);
                var newFrameLeft = newFrameIndex > 0 ? '-'+(newFrameIndex * spriteSize)+'px' : '0';
                $('img', thisSprite).css({left:newFrameLeft});
                //console.log('animatedSprites[spriteClass][spriteID] : animatedSprites['+spriteClass+']['+spriteID+']');
                clearTimeout(animatedSprites[spriteClass][spriteID]);
                animatedSprites[spriteClass][spriteID] = setTimeout(function(){
                    animateSprite(thisID);
                    }, spriteTimeout);
            }

            // Define a function for triggering all sprite animations
            function startSpriteAnimations(){
                for (kind in animatedSprites){
                    var thisQueue = animatedSprites[kind];
                    for (id in thisQueue){
                        animateSprite('sprite_'+kind+'_'+id);
                        //clearTimeout(thisQueue[id]);
                        //delete thisQueue[id];
                        }
                    }
                startBackgroundAnimations();
            }

            // Define a function for stopping all sprite animations
            function stopSpriteAnimations(){
                for (kind in animatedSprites){
                    var thisQueue = animatedSprites[kind];
                    for (id in thisQueue){
                        clearTimeout(thisQueue[id]);
                        //delete thisQueue[id];
                        }
                    }
                stopBackgroundAnimations();
            }


            // Define a function for finding a specific sprite on the canvas
            function findSprites(thisFilter){
                var thisSelector = '.sprite';
                if (thisFilter.spriteClass){ thisSelector += '[data-class='+thisFilter.spriteClass+']'; }
                if (thisFilter.playerID){ thisSelector += '[data-player='+thisFilter.playerID+']'; }
                if (thisFilter.robotID){ thisSelector += '[data-robot='+thisFilter.robotID+']'; }
                if (thisFilter.abilityID){ thisSelector += '[data-ability='+thisFilter.abilityID+']'; }
                if (thisFilter.spriteID){ thisSelector += '[data-id='+thisFilter.spriteID+']'; }
                if (thisFilter.spritePosition){ thisSelector += '[data-position='+thisFilter.spritePosition+']'; }
                var thisCanvasLayer = $('#canvas .sprites');
                var thisSprite = $(thisSelector, thisCanvasLayer);
                //alert(thisSelector);
                return thisSprite;
            }

            // Define a function for shifting a sprite's position on the canvas
            function shiftSprite(){

            }



            // Define a function for displaying an ability animation
            function startAbilityAnimation(){

                var thisRobotSprite = findSprites({spriteClass:'robots',playerID:2});
                thisRobotSprite = thisRobotSprite.eq(Math.floor(Math.random()*(thisRobotSprite.length - 1)));

                //var targetRobotSprite = findSprites({spriteClass:'robots',playerID:3});
                //targetRobotSprite = targetRobotSprite.eq(Math.floor(Math.random()*(targetRobotSprite.length - 1)));
                var targetRobotSprite = findSprites({spriteClass:'robots',playerID:3,spritePosition:thisRobotSprite.data('position')});

                //alert(thisRobotSprite);
                //alert(thisRobotSprite.length);
                //alert(thisRobotSprite.attr('data-frame'));


                var thisPosition = parseInt(thisRobotSprite.data('position'));
                var thisScale = parseFloat(thisRobotSprite.data('scale'));
                var thisShift = Math.floor((thisScale * 250) - (thisPosition * 10));
                var thisOffset = (parseInt(thisRobotSprite.css('left')) + thisShift) + 'px';
                //alert('thisPosition:'+thisPosition+',thisScale:'+thisScale+',thisShift:'+thisShift+',thisOffset:'+thisOffset);
                var thisBackupOffset = thisRobotSprite.css('left');
                var thisRevertTimeout = setTimeout(function(){
                    thisRobotSprite.css({left:thisBackupOffset});
                    }, 1000);
                thisRobotSprite.css({left:thisOffset});
                animateSprite('sprite_robots_'+thisRobotSprite.data('id'), 'shoot');

                var targetPosition = parseInt(targetRobotSprite.data('position'));
                var targetScale = parseFloat(targetRobotSprite.data('scale'));
                var targetShift = Math.floor((targetScale * 250) - (targetPosition * 10));
                var targetOffset = (parseInt(targetRobotSprite.css('right')) + targetShift) + 'px';
                //alert('targetPosition:'+targetPosition+',targetScale:'+targetScale+',targetShift:'+targetShift+',targetOffset:'+targetOffset);
                var targetBackupOffset = targetRobotSprite.css('right');
                var targetRevertTimeout = setTimeout(function(){
                    targetRobotSprite.css({right:targetBackupOffset});
                    }, 1000);
                targetRobotSprite.css({right:targetOffset});
                animateSprite('sprite_robots_'+targetRobotSprite.data('id'), 'defend');


            }

        </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();

// Require the page template
require('../../html.php');

?>