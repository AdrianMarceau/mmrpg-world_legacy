<?php

// Require the top files
require('../../config.php');
require('../../apptop.php');

// Define the headers for this file
$html_title_text = 'Battle Engine Tests 003/005 | '.$html_title_text;
$html_content_title = $html_content_title.' | Battle Engine Tests 003/005';
$html_content_description = 'While developing the battle engine for the Mega Man RPG many different mechanics were tested. This one allowed multiple robot actions per turn ordered by speed.';

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">
        <div id="mmrpg">

            <strong>Players</strong>
            <div id="players" style="margin-bottom: 50px; padding: 10px; background-color: #383838; margin-top: 10px;">

            </div>

            <strong>Robots</strong>
            <div id="robots" style="margin-bottom: 50px; padding: 10px; background-color: #383838; margin-top: 10px;">

            </div>

            <strong>Menu</strong>
            <div id="menu" style="margin-bottom: 50px; padding: 10px; line-height: 2em; background-color: #383838; margin-top: 10px;">

            </div>

            <strong>Actions</strong>
            <div id="actions" style="margin-bottom: 50px; padding: 10px; line-height: 2em; background-color: #383838; margin-top: 10px;">

            </div>

        </div>
    </div>
    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();

// Start the ouput buffer to collect styles
ob_start();
    ?>
    <? /* <link type="text/css" href="styles/reset.css" rel="stylesheet" /> */ ?>
    <style type="text/css">
        .player, .robot { display: block; padding: 6px 12px; margin: 0 auto 2px; position: relative;  }
        .player.disabled, .robot.disabled { opacity: 0.5;  }
        .dr-light { background-color: #5985bb; }
        .dr-wily { background-color: #bb5a5a; }
        .robot { background-color: rgba(0, 0, 0, 0.1); }
        input[type="button"] { display: inline-block; margin: 0 10px 10px 0; box-sizing: border-box; border: 1px solid #CACACA; background-color: #D0D0D0; padding: 6px 12px; font-family: Arial, sans-serif; cursor: pointer; }
        input[type="button"]:hover { background-color: #DEDEDE; }
    </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();

// Start the ouput buffer to collect scripts
ob_start();
    ?>
    <script type="text/javascript" src="scripts/jquery.js"></script>
    <script type="text/javascript" src="scripts/jquery.impromptu.js"></script>
    <script type="text/javascript" src="scripts/players.js"></script>
    <script type="text/javascript" src="scripts/robots.js"></script>
    <script type="text/javascript" src="scripts/abilities.js"></script>
    <script type="text/javascript">

    /*
     * PREPARE BATTLE
     */

    // Pull specific players out of the index
    //mmrpgPlayers.push();

    /*
     * BATTLE CODE
     */

    // Define the global turn order array
    var turnOrder = [];
    // Define the global robot actions array
    var robotActions = [];

    // Define document ready events
    $(document).ready(function(){

        // DEBUG

        // Print all players to the page
        for (i in mmrpgPlayers){
            var thisPlayer = mmrpgPlayers[i];
            $('#players').append('<div class="player '+thisPlayer.token+'">#'+thisPlayer.id+' : '+thisPlayer.name+'</div>');
            $('#robots').append('<div class="player '+thisPlayer.token+'"></div>');
            }

        // Print all robots to the page
        for (i in mmrpgRobots){
            var thisRobot = mmrpgRobots[i];
            var player = mmrpgPlayers[thisRobot.player];
            var $player = $('#robots').find('.'+player.token);
            var text = '';
            text += '<div style="position: relative; bottom: 6px; left: -6px; display: inline-block; vertical-align: middle; zoom: 1; width: 40px; height: 40px; background: transparent url(images/robots/'+thisRobot.token+'/sprite_left_40x40.png) no-repeat 0 0;">&nbsp;</div> ';
            text += '<div style="display: inline-block; line-height: 18px; vertical-align: middle;">';
                text += '#'+thisRobot.id+' : '+thisRobot.name;
                text += ' (<span class="energy">'+thisRobot.energy+'</span> EN)';
                text += ' (AT '+thisRobot.attack+' | DF '+thisRobot.defense+' | SP '+thisRobot.speed+')';
                text += ' ('+mmrpgAbilities[thisRobot.ability].name+')';
            text += '</div>';
            $player.append('<div class="robot '+thisRobot.token+'">'+text+'</div>');
            //$player.append('<pre>'+JSON.stringify(thisRobot)+'</pre>');
            }

        // Define click events for any menu buttons
        var thisMenu = $('#menu');
        $('*[data-action]', thisMenu).live('click', function(e){
            // Prevent any default click actions
            e.preventDefault();
            // Generate the action object based on button data
            var thisAction = {
                player: parseInt($(this).attr('data-player')),
                robot: parseInt($(this).attr('data-robot')),
                action: $(this).attr('data-action'),
                ability: $(this).attr('data-ability')
                };
            // Append this request to the actions array
            robotActions.push(thisAction);
            // Fade the menu from view
            $('#menu').animate({opacity:0},200,'swing',function(){
                // Evoke the action collector again
                mmrpgUpdateActions();
                });
            });

        // Trigger calculation of the turn order
        mmrpgUpdateTurns();

        // Trigger the action collector functions
        mmrpgUpdateActions();

    });

    // Define a function for recalculating turn order
    function mmrpgUpdateTurns(){

        // Clear the turn order to start fresh
        turnOrder = [];

        // Add each active robot's ID to the turn order array
        for (i in mmrpgRobots){
            var thisRobot = mmrpgRobots[i];
            turnOrder.push(thisRobot.id);
            }

        // Now sort the turnOrder array based on speed
        turnOrder.sort(function(a, b){
            var thisRobot = mmrpgRobots[a];
            var thatRobot = mmrpgRobots[b];
            var thisPlayer = mmrpgPlayers[thisRobot.player];
            var thatPlayer = mmrpgPlayers[thatRobot.player];
            if (thisRobot.speed > thatRobot.speed){ return -1; }
            else if (thisRobot.speed < thatRobot.speed){ return 1; }
            else if (thisPlayer.speed < thatPlayer.speed){ return -1; }
            else if (thisPlayer.speed < thatPlayer.speed){ return 1; }
            else { return 0; }
            });

        // Return true on success
        return true;

    }


    // Define a function to render messages to the screen
    var mmrpgMessages = [];
    function mmrpgRenderMessages(callback){
        if (mmrpgMessages.length){
            var thisMessage = $('<div class="message">'+mmrpgMessages.shift()+'</div>').css({opacity:0}).prependTo('#actions');
            thisMessage.animate({opacity:1},{duration:250,easing:'swing',queue:true,complete:function(){
                mmrpgRenderMessages(callback);
                }});
            } else {
            return callback();
            }
    }

    // Define a function to display collected robot actions
    function mmrpgRenderActions(){

        //console.debug(robotActions);
        //alert('robotActions.length : '+robotActions.length);

        // Loop through all the robot actions and generate any feedback
        var actionKeyLimit = robotActions.length;
        for (actionKey = 0; actionKey < actionKeyLimit; actionKey++){

            // Pop the next action off the array and collect details
            var thisAction = robotActions.shift();
            var thisRobot = mmrpgRobots[thisAction.robot];
            var thisPlayer = mmrpgPlayers[thisRobot.player];
            var thisAbility = mmrpgAbilities[thisAction.ability]; //thisAction.ability != undefined ? thisAction.ability : mmrpgAbilities[thisRobot.ability];
            // Inflict damage on itself (temporary)
            thisRobot.energy = thisRobot.energy <= thisAbility.damage ? 0 : thisRobot.energy - thisAbility.damage;
            // Update the parent robot object
            var $robot = $('#robots').find('.'+thisRobot.token);
            if ($robot.length){
                $robot.find('.energy').html(thisRobot.energy);
                if (thisRobot.energy <= 0){ $robot.addClass('disabled'); }
                }

            // Generate the markup for the ability action message
            mmrpgMessages.push('<div class="'+thisPlayer.token+'" style="border-style: solid; border-color: #EFEFEF; border-width: 2px 4px;"><div style="display: inline-block; zoom: 1; width: 40px; height: 40px; background: transparent url(images/robots/'+thisRobot.token+'/sprite_left_40x40.png) no-repeat 0 0; position: relative; bottom: 6px; left: -2px;">&nbsp;</div> '+thisPlayer.name+'&#39;s '+thisRobot.name+' (EN:'+thisRobot.energy+') uses '+thisAbility.name+' on itself!</div>');
            // Check if this robot has been destroyed by the attack
            if (thisRobot.energy == 0){
                // Generate the markup for the robot disabled message
                mmrpgMessages.push('<div class="'+thisPlayer.token+'" style="border-style: solid; border-color: #EFEFEF; border-width: 2px 4px;"><div style="display: inline-block; zoom: 1; width: 40px; height: 40px; background: transparent url(images/robots/'+thisRobot.token+'/sprite_left_40x40.png) no-repeat -120px 0; position: relative; bottom: 6px; left: -2px;">&nbsp;</div> '+thisPlayer.name+'&#39;s '+thisRobot.name+' was disabled!</div>');
                // Remove this robot from the turn order array
                var newTurnOrder = [];
                for (i in turnOrder){
                    if (turnOrder[i] != thisRobot.id){
                        newTurnOrder.push(turnOrder[i]);
                        }
                    }
                turnOrder = newTurnOrder;
                }

            // If the battle is complete, stop execution
            if (mmrpgBattleComplete()){ break; }

            }

        // Trigger the message display function
        //alert(mmrpgMessages.join('\n'));
        mmrpgRenderMessages(function(){ return mmrpgUpdateActions(); });

        // Return true on success
        return true;

    }

    // Define a function for checking if the battle is over
    var mmrpgBattleCompleteFlag = false;
    function mmrpgBattleComplete(){
        // If the flag was already set, just return that
        if (mmrpgBattleCompleteFlag){ return true; }
        // Loop through robots and count the number of player still in the game
        var activePlayers = [];
        for (i in mmrpgRobots){
            var thisRobot = mmrpgRobots[i];
            var thisPlayer = mmrpgPlayers[thisRobot.player];
            if (thisRobot.energy > 0 && activePlayers.indexOf(thisPlayer.id) == -1){
                activePlayers.push(thisPlayer.id);
                }
            }
        // If there's only one player left, they win!
        if (activePlayers.length == 1){
            var thisPlayer = mmrpgPlayers[activePlayers[0]];
            var $player = $('#players').find('.'+thisPlayer.token);
            $('#players').find('.player').not($player).addClass('disabled');
            mmrpgMessages.push('<div class="'+thisPlayer.token+'" style="border-style: solid; border-color: #EFEFEF; border-width: 2px 4px;">'+thisPlayer.name+' wins!!!</div>');
            mmrpgBattleCompleteFlag = true;
            return true;
            }
        // If there are no players left, everyone looses
        if (activePlayers.length == 0 || turnOrder.length == 0){
            $('#players').find('.player').addClass('disabled');
            mmrpgMessages.push('<div class="'+thisPlayer.token+'" style="border-style: solid; border-color: #EFEFEF; border-width: 2px 4px;">Everyone was defeated?!</div>');
            mmrpgBattleCompleteFlag = true;
            return true;
            }
        // Otherwise return false, the battle is not complete
        return false;
    }

    // Define a function to collect and queue robot actions
    function mmrpgUpdateActions(){

        // If the battle is complete, stop execution
        if (mmrpgBattleComplete()){ return false; }

        // Check if there are still more actions to collect, else continue
        if (robotActions.length < turnOrder.length){

            // Collect the robot and player data for this next action
            var thisRobot = mmrpgRobots[turnOrder[robotActions.length]];
            var thisPlayer = mmrpgPlayers[thisRobot.player];

            // Decide whether to collect or generate input based the cpu flag
            if (thisPlayer.cpu){

                // Automatically generate this robot's action
                robotActions.push({
                    player: thisPlayer.id,
                    robot: thisRobot.id,
                    action: 'ability',
                    ability: thisRobot.ability
                    });

                // Evoke the action collector again
                return mmrpgUpdateActions();

                } else {

                // Display a the menu to the user
                var thisPanel = $('<div class="panel"></div>');
                thisPanel.append('<div class="message" style="padding-bottom: 10px;">'+
                        '<div style="display: inline-block; vertical-align: middle; zoom: 1; width: 40px; height: 40px; background: transparent url(images/robots/'+thisRobot.token+'/sprite_left_40x40.png) no-repeat 0 0;">&nbsp;</div> '+
                        '<div style="display: inline-block; line-height: 18px; vertical-align: middle;">'+
                            'Select ability for '+thisPlayer.name+'&#39;s '+thisRobot.name+': <br />'+
                            '<span style="opacity: 0.6;">(will be used on self until target programming is done)</span>'+
                        '</div> '+
                    '</div>');
                var thisAbilities = [thisRobot.ability, 100, 101];
                for (var i in thisAbilities){
                    var thisAbility = mmrpgAbilities[thisAbilities[i]];
                    thisPanel.append('<input type="button" class="action" value="'+thisAbility.name+' ('+thisAbility.damage+')" data-player="'+thisPlayer.id+'" data-robot="'+thisRobot.id+'" data-action="ability" data-ability="'+thisAbility.id+'" />');
                    }
                $('#menu').empty().append(thisPanel).animate({opacity:1},300,'swing');

                // Return false on input waiting
                return false;

             }

            } else {

            // Hide the menu from view
            $('#menu').empty().css({opacity:0});

            // Initiate the display function
            return mmrpgRenderActions();

            }

        alert('how did we get here?');

    }

    </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();

// Require the page template
require('../../html.php');

?>