<?

// Require the top files
require('../../config.php');
require('../../apptop.php');

// Include the required database files
require_once('include/config.php');
require_once('include/class.core.php');
require_once('include/class.database.php');
define('PLUTOCMS_CORE', 'CMS');
${PLUTOCMS_CORE} = new plutocms_core($PLUTOCMS_CONFIG['CORE']);
define('PLUTOCMS_DATABASE', 'DB');
${PLUTOCMS_DATABASE} = new plutocms_database($PLUTOCMS_CONFIG['DB']);

// Define the headers for this file
$html_title_text = 'Battle Engine Tests 002/005 | '.$html_title_text;
$html_content_title = $html_content_title.' | Battle Engine Tests 002/005';
$html_content_description = 'While developing the battle engine for the Mega Man RPG a few different loading techniques were tested. This one tested loading object indexes in their entirety.';

// Collect all the objects from the database and generate javascript insert markup
$index_markup = '';
$index_types = array('players', 'robots', 'abilities', 'types');
$index_lists = array('weaknesses', 'resistances', 'affinities', 'immunities');
foreach ($index_types AS $type){
    $this_index = $DB->get_array_list('SELECT * FROM index_'.$type.' ORDER BY id ASC');
    foreach ($this_index AS $info){
        $insert_string = array();
        foreach ($info AS $field => $value){
            if (in_array($field, $index_types) || in_array($field, $index_lists)){ $value = '['.$value.']'; }
            elseif (is_numeric($value)){ $value = $value; }
            else { $value = "'".str_replace("'", "\'", $value)."'"; }
            $insert_string[] = $field.':'.$value;
        }
        $insert_string = '{'.implode(',', $insert_string).'}';
        $index_markup .= '$'.$type.'.insert('.$insert_string.');'."\n";
    }
}

//

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">
        <div class="mmrpg">

            <div class="loader">

                <div id="types" style="">
                    <div>
                        <strong>Types</strong>
                        <span class="progress">
                            <span class="fraction">
                                <span class="current">0</span>
                                <span class="sign">/</span>
                                <span class="total">0</span>
                            </span>
                            <span class="percent">
                                <span class="current">0</span>
                                <span class="sign">%</span>
                            </span>
                        </span>
                    </div>
                    <div class="wrap"></div>
                </div>

                <div id="players" style="">
                    <div>
                        <strong>Players</strong>
                        <span class="progress">
                            <span class="fraction">
                                <span class="current">0</span>
                                <span class="sign">/</span>
                                <span class="total">0</span>
                            </span>
                            <span class="percent">
                                <span class="current">0</span>
                                <span class="sign">%</span>
                            </span>
                        </span>
                    </div>
                    <div class="wrap"></div>
                </div>

                <div id="robots" style="">
                    <div>
                        <strong>Robots</strong>
                        <span class="progress">
                            <span class="fraction">
                                <span class="current">0</span>
                                <span class="sign">/</span>
                                <span class="total">0</span>
                            </span>
                            <span class="percent">
                                <span class="current">0</span>
                                <span class="sign">%</span>
                            </span>
                        </span>
                    </div>
                    <div class="wrap"></div>
                </div>

                <div id="abilities" style="">
                    <div>
                        <strong>Abilities</strong>
                        <span class="progress">
                            <span class="fraction">
                                <span class="current">0</span>
                                <span class="sign">/</span>
                                <span class="total">0</span>
                            </span>
                            <span class="percent">
                                <span class="current">0</span>
                                <span class="sign">%</span>
                            </span>
                        </span>
                    </div>
                    <div class="wrap"></div>
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
    <? /* <link type="text/css" href="styles/reset.css" rel="stylesheet" /> */ ?>
    <style type="text/css">
    .mmrpg {
        padding: 20px;
        font-family: Arial;
    }

    .mmrpg > .window {
        display: block;
        margin: 0 auto 20px;
        width: 480px;
        height: 300px; /* 320px - 20px */
        border: 2px solid #292929;
        background-color: #393939;
        border-radius: 10px;
        overflow: hidden;
    }

    .mmrpg .canvas,
    .mmrpg .console,
    .mmrpg .actions {
        display: block;
        margin: 0 auto;
    }
    .mmrpg .canvas.hidden,
    .mmrpg .console.hidden,
    .mmrpg .actions.hidden {
        display: none;
    }
    .mmrpg .canvas {
        height: 200px;
    }
    .mmrpg .console,
    .mmrpg .actions {
        height: 100px;
    }

    .mmrpg .canvas .wrapper,
    .mmrpg .console .wrapper,
    .mmrpg .actions .wrapper {
        display: block;
        border: 2px solid #292929;
        background-color: #363636;
        width: 470px;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }
    .mmrpg .canvas .wrapper {
        margin: 3px 3px 0;
        height: 193px;
    }
    .mmrpg .console .wrapper,
    .mmrpg .actions .wrapper {
        margin: 0 3px 3px;
        height: 90px;
    }

    .mmrpg .canvas .sprite {
        display: block;
        position: absolute;
        overflow: hidden;
        z-index: 100;
        background-color: transparent;
        background-position: 0 0;
        background-repeat: no-repeat;
    }
    .mmrpg .canvas .sprite img {
        display: block;
        position: relative;
    }
    .mmrpg .canvas .sprite.x40 {
        width: 40px;
        height: 40px;
    }
    .mmrpg .canvas .sprite.x80 {
        width: 80px;
        height: 80px;
    }
    .mmrpg .canvas .sprite.bg,
    .mmrpg .canvas .sprite.fg {
        max-width: 100%;
        height: 193px;
        top: 0;
        left: 0;
    }

    .mmrpg .canvas .sprite.x80.taunt img {
        right: auto;
        left: -80px;
    }
    .mmrpg .canvas .sprite.x80.victory img {
        right: auto;
        left: -160px;
    }
    .mmrpg .canvas .sprite.x80.defeat img {
        right: auto;
        left: -240px;
    }
    .mmrpg .canvas .sprite.x80.shoot img {
        right: auto;
        left: -320px;
    }
    .mmrpg .canvas .sprite.x80.throw img {
        right: auto;
        left: -400px;
    }
    .mmrpg .canvas .sprite.x80.summon img {
        right: auto;
        left: -480px;
    }
    .mmrpg .canvas .sprite.x80.slide img {
        right: auto;
        left: -560px;
    }
    .mmrpg .canvas .sprite.x80.defend img {
        right: auto;
        left: -640px;
    }
    .mmrpg .canvas .sprite.x80.damage img {
        right: auto;
        left: -720px;
    }

    .mmrpg .console .frame {
        margin: 2px 2px 0;
        background-color: #333333;
        border-radius: 5px;
        padding: 3px;
        color: #FAFAFA;
        font-size: 12px;
        line-height: 14px;
    }

    .mmrpg .debug {
        display: block;
        margin: 0 auto 4px;
        padding: 4px;
        background-color: #282828;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
    }

    .mmrpg .progress {
        display: inline-block;
        margin-left: 20px;
        color: #BABABA;
    }
    .mmrpg .progress .fraction,
    .mmrpg .progress .percent {
        display: inline-block;
    }
    .mmrpg .progress .fraction {
        color: #CACACA;
    }
    .mmrpg .progress .percent {
        color: #DADADA;
        margin-left: 10px;
        font-weight: bold;
    }

    .mmrpg .loader {
        display: block;
        margin: 0 auto 20px;
    }

    #players,
    #robots,
    #abilities,
    #types {
        display: block;
        box-sizing: border-box;
        float: left;
        margin: 0 20px 20px 0;
        width: 32%;
        width: calc(33.33% - 20px);
        padding: 10px;
        background-color: #383838;
    }
    #types {
        width: 99.99%;
        clear: both;
    }
    #types .debug {
        float: left;
        width: 49%;
        margin: 0 4px 4px 0;
        width: calc(50% - 4px);
        box-sizing: border-box;
    }

    #players .wrap,
    #robots .wrap,
    #abilities .wrap,
    #types .wrap {
        display: block;
        margin: 0 auto;
        padding-top: 10px;
    }

    .mmrpg:after,
    .loader:after,
    #players:after,
    #robots:after,
    #abilities:after,
    #types:after {
        content: "";
        display: block;
        clear: both;
        float: none;
        height: 0;
    }

    </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();

// Start the ouput buffer to collect scripts
ob_start();
    ?>
    <script type="text/javascript" src="scripts/jquery.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
    <script type="text/javascript">

    // Define the indexes to be populated
    var $players = new mmrpgIndex();
    var $robots = new mmrpgIndex();
    var $abilities = new mmrpgIndex();
    var $types = new mmrpgIndex();

    // Insert player, robot, ability, and type objects into the index
    <?= $index_markup ?>

    var debugTimeout = {};
    var debugTotal = {};
    var debugCurrent = {};
    function showDebug(debugKey, $debugTarget, debugQueue, debugDelay){
        if (!debugQueue.length){ return false; }
        if (typeof debugTimeout[debugKey] !== 'undefined'){ clearTimeout(debugTimeout[debugKey]); }
        if (typeof debugTotal[debugKey] === 'undefined'){ debugTotal[debugKey] = debugQueue.length; }
        if (typeof debugCurrent[debugKey] === 'undefined'){ debugCurrent[debugKey] = 0; }
        if (typeof debugDelay === 'undefined'){ debugDelay = 500; }
        var thisDebug = debugQueue.shift();
        debugCurrent[debugKey]++;
        $debugTarget.find('.wrap').prepend(thisDebug);
        $progress = $debugTarget.find('.progress');
        if ($progress.length){
            updateProgress($progress,
                debugCurrent[debugKey],
                debugTotal[debugKey]
                );
            }
        if (debugQueue.length){
            debugTimeout[debugKey] = setTimeout(function(){
                showDebug(debugKey, $debugTarget, debugQueue, debugDelay);
                }, debugDelay);
            }
    }

    function updateProgress($progress, current, total){
        //console.log('updateProgress($progress, current, total)', $progress, current, total);
        if (typeof $progress === 'undefined'){ return false; }
        if (typeof current === 'undefined'){ return false; }
        if (typeof total === 'undefined'){ return false; }
        if (total === 0){ return false; }
        var percent = Math.round(((current / total) * 100) * 100) / 100;
        $progress.find('.fraction .current').html(current);
        $progress.find('.fraction .total').html(total);
        $progress.find('.percent .current').html(percent);
    }

    $(document).ready(function(){

        var $typeDiv = $('#types');
        var typeIndex = $types.all();
        var typeDebugQueue = [];
        typeIndex.map(function(type){
            typeDebugQueue.push('<div class="debug">'+
                    '<strong>'+type.name+'</strong> <span class="pipe">|</span> '+
                    '<span class="pre" style="color: #C0C0C0;">'+JSON.stringify(type)+'</span>'+
                '</div>');
            });
        console.log('typeIndex = ', typeIndex);
        showDebug('types', $typeDiv, typeDebugQueue, 100);

        var $playerDiv = $('#players');
        var playerIndex = $players.all();
        var playerDebugQueue = [];
        playerIndex.map(function(player){
            playerDebugQueue.push('<div class="debug">'+
                    '<div style="position: relative; bottom: 6px; left: 0; display: inline-block; vertical-align: middle; zoom: 1; width: 40px; height: 40px; background: transparent url(images/players/'+player.token+'/sprite_left_40x40.png) no-repeat 0 0;">&nbsp;</div>'+
                    '<div style="display: inline-block; line-height: 18px; vertical-align: middle; width: calc(100% - 50px);">'+
                        '<strong>Loaded the player '+player.name+'!</strong><br />'+
                        '<span class="pre" style="color: #C0C0C0;">'+JSON.stringify(player)+'</span>'+
                    '</div>'+
                '</div>');
            });
        console.log('playerIndex = ', playerIndex);
        showDebug('players', $playerDiv, playerDebugQueue, 200);

        var $robotDiv = $('#robots');
        var robotIndex = $robots.all();
        var robotDebugQueue = [];
        robotIndex.map(function(robot){
            robotDebugQueue.push('<div class="debug">'+
                    '<div style="position: relative; bottom: 6px; left: 0; display: inline-block; vertical-align: middle; zoom: 1; width: 40px; height: 40px; background: transparent url(images/robots/'+robot.token+'/sprite_left_40x40.png) no-repeat 0 0;">&nbsp;</div>'+
                    '<div style="display: inline-block; line-height: 18px; vertical-align: middle; width: calc(100% - 50px);">'+
                        '<strong>Loaded the robot '+robot.name+'!</strong><br />'+
                        '<span class="pre" style="color: #C0C0C0;">'+JSON.stringify(robot)+'</span>'+
                    '</div>'+
                '</div>');
            });
        console.log('robotIndex = ', robotIndex);
        showDebug('robots', $robotDiv, robotDebugQueue, 200);

        var $abilityDiv = $('#abilities');
        var abilityIndex = $abilities.all();
        var abilityDebugQueue = [];
        abilityIndex.map(function(ability){
            abilityDebugQueue.push('<div class="debug">'+
                    '<div style="position: relative; bottom: 6px; left: 0; display: inline-block; vertical-align: middle; zoom: 1; width: 40px; height: 40px; background: transparent url(images/abilities/'+ability.token+'/sprite_left_40x40.png) no-repeat 0 0;">&nbsp;</div>'+
                    '<div style="display: inline-block; line-height: 18px; vertical-align: middle; width: calc(100% - 50px);">'+
                        '<strong>Loaded the ability '+ability.name+'!</strong><br />'+
                        '<span class="pre" style="color: #C0C0C0;">'+JSON.stringify(ability)+'</span>'+
                    '</div>'+
                '</div>');
            });
        console.log('abilityIndex = ', abilityIndex);
        showDebug('abilities', $abilityDiv, abilityDebugQueue, 200);


    });



    </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();

// Require the page template
require('../../html.php');

?>