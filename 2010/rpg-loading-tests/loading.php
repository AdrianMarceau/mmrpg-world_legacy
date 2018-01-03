<?

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Include the required database files
//require_once('include/config.php');
require_once('include/config.legacy.php');
require_once('include/class.core.php');
require_once('include/class.database.php');
define('PLUTOCMS_CORE', 'CMS');
${PLUTOCMS_CORE} = new plutocms_core($PLUTOCMS_CONFIG['CORE']);
define('PLUTOCMS_DATABASE', 'DB');
${PLUTOCMS_DATABASE} = new plutocms_database($PLUTOCMS_CONFIG['DB']);

// Define the headers for this HTML page
$html->addTitle('RPG Loading Tests')->addTitle('Load Robot Abilities');
$html->setContentDescription(
    'While developing the battle engine for the Mega Man RPG a few different loading techniques were tested. '.
    'This one tested loading robots and the abilities they learned. '
    );

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">
        <div id="mmrpg">

            <? /*
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
            */ ?>


            <div id="debug" style="margin-bottom: 50px; padding: 10px; line-height: 2em; background-color: #383838; margin-top: 10px;">
                <strong class="title">Robot Index Debug</strong>
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
                <div class="wrap"></div>
            </div>

        </div>
    </div>
    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();
$html->addContentMarkup($html_content_markup);

// Start the ouput buffer to collect styles
ob_start();
    ?>
    <? /* <link type="text/css" href="styles/reset.css" rel="stylesheet" /> */ ?>
    <style type="text/css">
        .debug {
            display: block;
            margin: 0 auto 4px;
            padding: 4px;
            background-color: #282828;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
        }

        .progress {
            display: inline-block;
            margin-left: 20px;
            color: #BABABA;
        }
        .progress .fraction,
        .progress .percent {
            display: inline-block;
        }
        .progress .fraction {
            color: #CACACA;
        }
        .progress .percent {
            color: #DADADA;
            margin-left: 10px;
            font-weight: bold;
        }

        #debug .wrap {
            display: block;
            margin: 0 auto;
            padding-top: 10px;
        }

        .mmrpg:after,
        .loader:after,
        #debug:after {
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
$html->addStyleMarkup($html_styles_markup);

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
    var $debug;
    var $debugProgress;
    var debugQueue = [];

    // Wait for document ready before delegating events
    $(document).ready(function(){

        $debug = $('#debug');
        $debugProgress = $debug.find('.progress');

        <?
        // Collect all the players from the database and insert them into the index
        $index_types = array('players', 'robots', 'types', 'abilities');
        $index_lists = array('weaknesses', 'resistances', 'affinities', 'immunities');
        foreach ($index_types AS $type){
            $this_index = $DB->get_array_list('SELECT * FROM index_'.$type.' ORDER BY id ASC');
            echo '// Insert objects into the '.$type.' index one by one'."\n";
            foreach ($this_index AS $info){
                $insert_string = array();
                foreach ($info AS $field => $value){
                    if (in_array($field, $index_types) || in_array($field, $index_lists)){ $value = '['.$value.']'; }
                    elseif (is_numeric($value)){ $value = $value; }
                    else { $value = "'".str_replace("'", "\'", $value)."'"; }
                    $insert_string[] = $field.':'.$value;
                }
                $insert_string = '{'.implode(',', $insert_string).'}';
                echo '$'.$type.'.insert('.$insert_string.');'."\n";
            }
            echo "\n";
        }
        ?>

        var testSelect = $robots.select(2);
        var testSearch = $robots.search({name:'Man'});
        testSearch.map(function(robot){

            var debug = '';

            //debug += 'Found the robot '+robot.name+'!\n';
            debugQueue.push('<div class="debug">'+
                    '<div style="position: relative; bottom: 6px; left: -6px; display: inline-block; vertical-align: middle; zoom: 1; width: 40px; height: 40px; background: transparent url(images/robots/'+robot.token+'/sprite_left_40x40.png) no-repeat 0 0;">&nbsp;</div>'+
                    '<div style="display: inline-block; line-height: 18px; vertical-align: middle;">Found the robot '+robot.name+'!</div>'+
                '</div>');


            for (akey in robot.abilities){
                var ability = $abilities.select(robot.abilities[akey]);

                /*
                //debug += robot.name+' has the '+ability.name+' ability!\n '+ability.name;
                debugQueue.push('<div class="debug sub">'+
                        '<div style="display: inline-block; vertical-align: middle; width: 20px; height: 40px;">&nbsp;</div>'+
                        '<div style="position: relative; bottom: 6px; left: -6px; display: inline-block; vertical-align: middle; zoom: 1; width: 40px; height: 40px; background: transparent url(images/abilities/'+ability.token+'/sprite_left_40x40.png) no-repeat 0 0;">&nbsp;</div>'+
                        '<div style="display: inline-block; line-height: 18px; vertical-align: middle;">'+robot.name+' has the '+ability.name+' ability!</div>'+
                    '</div>');
                    */

                var abilityText = '';
                abilityText += '<div style="display: inline-block; line-height: 18px; vertical-align: middle;">';
                    abilityText += robot.name+' has the '+ability.name+' ability!<br />';
                    abilityText += ability.name;
                    if (ability.types.length){
                        if (ability.types.length == 1){
                            abilityText += ' is ';
                            var type = $types.select(ability.types[0]);
                            abilityText += type.name+' type';
                            } else if (ability.types.length > 1){
                            abilityText += ' is ';
                            for (tkey in ability.types){
                                var type = $types.select(ability.types[tkey]);
                                if (tkey == 0){ abilityText += type.name; }
                                else if (tkey == 1 && ability.types.length == 2){ abilityText += ' and '+type.name;  }
                                else if (tkey > 1 && ability.types.length > 2){ abilityText += ', and '+type.name; }
                                else { abilityText += ', '+type.name; }
                                }
                            abilityText += ' types';
                            } else {
                                // nothing
                            }
                        }
                    if (ability.damage > 0 && ability.recovery > 0){ abilityText += (ability.types.length ? ', ' : '')+' does '+ability.damage+' damage'+(ability.types.length ? ',' : '')+' and '+ability.recovery+' recovery'; }
                    else if (ability.damage > 0){ abilityText += (ability.types.length ? ' and' : '')+' does '+ability.damage+' damage'; }
                    else if (ability.recovery > 0){ abilityText += (ability.types.length ? ' and' : '')+' does '+ability.recovery+' recovery'; }
                    abilityText += '!';
                abilityText += '</div>';

                debugQueue.push('<div class="debug sub">'+
                        '<div style="display: inline-block; vertical-align: middle; width: 20px; height: 40px;">&nbsp;</div>'+
                        '<div style="position: relative; bottom: 6px; left: -6px; display: inline-block; vertical-align: middle; zoom: 1; width: 40px; height: 40px; background: transparent url(images/abilities/'+ability.token+'/sprite_left_40x40.png) no-repeat 0 0;">&nbsp;</div>'+
                        '<div style="display: inline-block; line-height: 18px; vertical-align: middle;">'+abilityText+'</div>'+
                    '</div>');

                }
            //console.log(debug);
            //debugQueue.push('<div class="debug">'+debug.replace(/\n/g, '</div>\n<div class="debug">')+'</div>');
            });

        //console.log(testSelect);
        //console.log(testSearch);
        updateProgress($debugProgress, 0, debugQueue.length);
        showDebug();


    });

    var debugTimeout = false;
    var debugTotal = false;
    var debugCurrent = false;
    function showDebug(){
        if (debugTimeout !== false){ clearTimeout(debugTimeout); }
        if (debugTotal === false){ debugTotal = debugQueue.length; }
        if (debugCurrent === false){ debugCurrent = 0; }
        if (!debugQueue.length){ return false; }
        var thisDebug = debugQueue.shift();
        debugCurrent++;
        $debug.find('.wrap').append(thisDebug);
        updateProgress($debugProgress)
        if (debugQueue.length){
            debugTimeout = setTimeout(function(){
                showDebug();
                }, 100);
            }
    }

    function updateProgress($progress, current, total){
        //console.log('updateProgress($progress, current, total)', $progress, current, total);
        if (typeof current === 'undefined'){ current = debugCurrent; }
        if (typeof total === 'undefined'){ total = debugTotal; }
        if (total === 0){ return false; }
        var percent = Math.round(((current / total) * 100) * 100) / 100;
        $progress.find('.fraction .current').html(current);
        $progress.find('.fraction .total').html(total);
        $progress.find('.percent .current').html(percent);

    }

    </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();
$html->addScriptMarkup($html_scripts_markup);

// Print out the final HTML page markup
$html->printHtmlPage();

?>