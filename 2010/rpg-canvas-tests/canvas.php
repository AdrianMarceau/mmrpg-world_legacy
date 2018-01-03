<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Define the headers for this HTML page
$html->addTitle('RPG Canvas Tests')->addTitle('Sprite Animations');
$html->setContentDescription(
    'While developing the battle system for the Mega Man RPG a few different sprite animation techniques were tested. '.
    'This one used infinitely looping timeouts. '
    );

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">
        <div id="mmrpg"></div>
    </div>
    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();
$html->addContentMarkup($html_content_markup);

// Start the ouput buffer to collect styles
ob_start();
    ?>
    <link type="text/css" href="styles/canvas.css" rel="stylesheet" />
    <style type="text/css">
    html { background-color: #EFEFEF; }
    .canvas {
        background: #191919 url(images/fields/guts-field/battle-field_background_base.png) scroll no-repeat center bottom;
        border: 2px solid #272727;
        position: relative;
    }
    .canvas:before {
        content: "";
        background: transparent url(images/fields/guts-field/battle-field_foreground_base.png) scroll no-repeat center bottom;
        display: block;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
$html->addStyleMarkup($html_styles_markup);

// Start the ouput buffer to collect scripts
ob_start();
    ?>
    <script type="text/javascript" src="scripts/jquery.js"></script>
    <script type="text/javascript" src="scripts/game.js"></script>
    <script type="text/javascript" src="scripts/canvas.js"></script>
    <script type="text/javascript" src="scripts/sprite.js"></script>
    <script type="text/javascript">

    // Define the global variables
    var thisGame;
    var thisCanvas;
    // Wait until the document is ready before drawing
    $(document).ready(function(){

        // Generate the new game object variable
        thisGame = new mmrpgGame();

        // Generate the new canvas object variable
        thisCanvas = new mmrpgCanvas({id:'main'});

        // Draw the canvas on the game screen
        thisGame.drawCanvas('main');

        // Create some new sprites and add them to the canvas
        var sprite1 = new mmrpgSprite({id:'mega-man',path:'robots',image:'mega-man',side:'left',offset:{x:60,y:80,z:1}});
        var sprite2 = new mmrpgSprite({id:'proto-man',path:'robots',image:'proto-man',side:'left',offset:{x:75,y:70,z:2}});
        thisCanvas.drawSprite(sprite1.id);
        thisCanvas.drawSprite(sprite2.id);

        var sprite3 = new mmrpgSprite({id:'air-man',path:'robots',image:'air-man',side:'right',offset:{x:60,y:80,z:1}});
        var sprite4 = new mmrpgSprite({id:'bubble-man',path:'robots',image:'bubble-man',side:'right',offset:{x:75,y:70,z:2}});
        thisCanvas.drawSprite(sprite3.id);
        thisCanvas.drawSprite(sprite4.id);

        setTimeout(function(){ test123(sprite1); }, 400);
        setTimeout(function(){ test123(sprite2); }, 800);
        setTimeout(function(){ test123(sprite3); }, 1200);
        setTimeout(function(){ test123(sprite4); }, 1600);

        /*
        // Create the new sprite object variable
        var thisSprite = new mmrpgSprite({id: 'S1', path: 'robots', image: 'air-man', frame: '02'});
        // Draw the created sprite on the canvas object
        thisCanvas.drawSprite('S1');
        */



    });

    function test123(sprite){
        setTimeout(function(){
            sprite.frame = '01';
            sprite.offset.x += 5;
            thisCanvas.redrawSprite(sprite.id);
            setTimeout(function(){
                sprite.frame = '00';
                sprite.offset.x -= 5;
                thisCanvas.redrawSprite(sprite.id);
                setTimeout(function(){
                    test123(sprite);
                    }, getRandomInt(1000, 2000));
                }, getRandomInt(1000, 2000));
            }, getRandomInt(1000, 2000));
    }

    /**
     * Returns a random integer between min (inclusive) and max (inclusive)
     * Using Math.round() will give you a non-uniform distribution!
     */
    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();
$html->addScriptMarkup($html_scripts_markup);

// Print out the final HTML page markup
$html->printHtmlPage();

?>