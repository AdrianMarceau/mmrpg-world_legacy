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
$html->addTitle('Battle Engine Canvas Test #2');
$html->setContentDescription(
    'While developing the battle system for the Mega Man RPG a number of different field layouts were experimented with. '.
    'This was one of the layouts tested. '
    );

// Collect all the objects from the database and generate javascript insert markup
$index_markup = '';
$index_types = array('players', 'robots', 'abilities', 'types');
$index_lists = array('weaknesses', 'resistances', 'affinities', 'immunities');
$mmrpg_object_index = array();
foreach ($index_types AS $type){
    $this_index = $DB->get_array_list('SELECT * FROM index_'.$type.' ORDER BY id ASC', 'token');
    $mmrpg_object_index[$type] = $this_index;
    if ($type === 'abilities'){
        $mmrpg_object_index[$type.'_byid'] = array();
        foreach ($this_index AS $info){ $mmrpg_object_index[$type.'_byid'][$info['id']] = $info; }
    }
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

// Define a few scenarios to loop through
$battle_scenes = array();

$battle_scenes[] = array(
    'field' => 'elec-field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'mega-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'elec-man'
        )
    );
$battle_scenes[] = array(
    'field' => 'elec-field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'oil-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'elec-man'
        )
    );

$battle_scenes[] = array(
    'field' => 'guts-field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'cut-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'guts-man'
        )
    );
$battle_scenes[] = array(
    'field' => 'guts-field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'time-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'guts-man'
        )
    );

$battle_scenes[] = array(
    'field' => 'ice-field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'fire-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'ice-man'
        )
    );
$battle_scenes[] = array(
    'field' => 'ice-field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'bomb-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'ice-man'
        )
    );

$battle_scenes[] = array(
    'field' => 'field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'proto-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'crash-man'
        )
    );
$battle_scenes[] = array(
    'field' => 'field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'air-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'crash-man'
        )
    );

$battle_scenes[] = array(
    'field' => 'field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'wood-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'heat-man'
        )
    );
$battle_scenes[] = array(
    'field' => 'field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'bubble-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'heat-man'
        )
    );

$battle_scenes[] = array(
    'field' => 'field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'metal-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'quick-man'
        )
    );
$battle_scenes[] = array(
    'field' => 'field',
    'this_team' => array(
        'player' => 'dr-light',
        'robot' => 'flash-man'
        ),
    'target_team' => array(
        'player' => 'dr-wily',
        'robot' => 'quick-man'
        )
    );


// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">
        <div class="mmrpg">

            <?
            //echo('<pre>$mmrpg_object_index = '.print_r($mmrpg_object_index, true).'</pre>');
            foreach ($battle_scenes AS $key => $scene){

                $this_team_robot = $mmrpg_object_index['robots'][$scene['this_team']['robot']];
                $this_team_robot_abilities = strstr($this_team_robot['abilities'], ',') ? explode(',', $this_team_robot['abilities']) : array($this_team_robot['abilities']);
                $this_team_robot_abilitykey = $this_team_robot['token'] == 'mega-man' ? 0 : 1; //mt_rand(0, (count($this_team_robot_abilities) - 1));
                $this_team_robot_ability = $mmrpg_object_index['abilities_byid'][$this_team_robot_abilities[$this_team_robot_abilitykey]];

                $target_team_robot = $mmrpg_object_index['robots'][$scene['target_team']['robot']];
                $target_team_robot_abilities = strstr($target_team_robot['abilities'], ',') ? explode(',', $target_team_robot['abilities']) : array($target_team_robot['abilities']);
                $target_team_robot_abilitykey = 0; //mt_rand(0, (count($target_team_robot_abilities) - 1));
                $target_team_robot_ability = $mmrpg_object_index['abilities_byid'][$target_team_robot_abilities[$target_team_robot_abilitykey]];

                ?>
                <div class="window">
                    <div class="canvas">
                        <div class="wrapper">

                            <div class="sprite bg"><img src="images/fields/<?= $scene['field'] ?>/battle-field_background_base.png" /></div>
                            <div class="sprite fg"><img src="images/fields/<?= $scene['field'] ?>/battle-field_foreground_base.png" /></div>

                            <div class="sprite x40" style="bottom: 50px; left: 10px;"><img src="images/players/<?= $scene['this_team']['player'] ?>/sprite_right_40x40.png" /></div>
                            <div class="sprite x40" style="bottom: 50px; right: 10px;"><img src="images/players/<?= $scene['target_team']['player'] ?>/sprite_left_40x40.png" /></div>

                            <div class="sprite x80 shoot" style="bottom: 30px; left: 50px;"><img src="images/robots/<?= $scene['this_team']['robot'] ?>/sprite_right_80x80.png" /></div>
                            <div class="sprite x80 <?= $key % 2 === 0 ? 'taunt' : 'defend' ?>" style="bottom: 30px; right: 50px;"><img src="images/robots/<?= $scene['target_team']['robot'] ?>/sprite_left_80x80.png" /></div>

                            <div class="sprite x80 base" style="bottom: 30px; left: 125px;"><img src="images/abilities/<?= $this_team_robot_ability['token'] ?>/sprite_right_80x80.png" /></div>

                        </div>
                    </div>
                    <div class="console">
                        <div class="wrapper">

                            <? if (!preg_match('/-(boost|mode)$/', $this_team_robot_ability['token'])){ ?>
                                <div class="frame"><strong><?= $this_team_robot['name'] ?></strong> targets <strong><?= $target_team_robot['name'] ?></strong>!</div>
                            <? } else { ?>
                                <div class="frame"><strong><?= $this_team_robot['name'] ?></strong> targets itself</strong>!</div>
                            <? } ?>

                            <div class="frame"><strong><?= $this_team_robot['name'] ?></strong> uses the <strong><?= $this_team_robot_ability['name'] ?></strong> ability!</div>

                            <? if (!preg_match('/-(boost|mode)$/', $this_team_robot_ability['token'])){ ?>
                                <div class="frame"><?= $key % 2 === 0 ? 'It\'s not very effective... ' : 'It\'s super effective! ' ?><strong><?= $target_team_robot['name'] ?></strong> takes <strong><?= $key % 2 === 0 ? 15 : 60 ?></strong> damage!</div>
                            <? } else { ?>
                                <div class="frame"><strong><?= $target_team_robot['name'] ?></strong> recovered by <strong>30</strong>!</div>
                            <? } ?>

                            <? if ($key % 2 === 0){ ?>
                                <div class="frame">&quot;<em>Is that all you've got, <strong><?= $this_team_robot['name'] ?></strong>?</em>&quot;</div>
                            <? } else { ?>
                                <div class="frame">&quot;<em>Wow, <strong><?= $this_team_robot['name'] ?></strong>! You're strong!</em>&quot;</div>
                            <? } ?>

                        </div>
                    </div>
                    <div class="actions">
                        <div class="wrapper">
                        </div>
                    </div>
                </div>
                <?
            }
            ?>

            <? /*
            <div class="window">
                <div class="canvas">
                    <div class="wrapper">
                        <div class="sprite bg"><img src="images/fields/elec-field/battle-field_background_base.png" /></div>
                        <div class="sprite fg"><img src="images/fields/elec-field/battle-field_foreground_base.png" /></div>
                        <div class="sprite x80 shoot" style="bottom: 30px; left: 50px;"><img src="images/robots/mega-man/sprite_right_80x80.png" /></div>
                        <div class="sprite x80 defend" style="bottom: 30px; right: 50px;"><img src="images/robots/elec-man/sprite_left_80x80.png" /></div>
                    </div>
                </div>
                <div class="console">
                    <div class="wrapper">
                        <div class="frame">&quot;<em>Is that all you've got, <strong>Mega Man</strong>?</em>&quot;</div>
                        <div class="frame"><strong>Elec Man</strong> takes <strong>30</strong> damage!</div>
                        <div class="frame"><strong>Mega Man</strong> uses the <strong>Mega Buster</strong>!</div>
                        <div class="frame"><strong>Mega Man</strong> targets <strong>Elec Man Man</strong>!</div>
                    </div>
                </div>
                <div class="actions">
                    <div class="wrapper">
                    </div>
                </div>
            </div>
            */ ?>

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
    .mmrpg {
        padding: 20px;
        font-family: Arial;
    }

    .mmrpg > .window {
        display: block;
        margin: 0 auto 20px;
        max-width: 480px;
        height: 300px; /* 320px - 20px */
        border: 2px solid #292929;
        background-color: #393939;
        border-radius: 10px;
        overflow: hidden;

        float: left;
        box-sizing: border-box;
        width: 48%;
        width: calc(50% - 20px);
        margin: 0 20px 20px 0;
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
    .mmrpg .console {
        text-align: center;
    }
    .mmrpg .actions {
        display: none;
    }

    .mmrpg .canvas .wrapper,
    .mmrpg .console .wrapper,
    .mmrpg .actions .wrapper {
        display: block;
        border: 2px solid #292929;
        background-color: #363636;
        width: auto;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        box-sizing: border-box;
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

    .loader {
        display: block;
        margin: 0 auto 20px;
        padding-top: 20px;
        border-top: 1px solid #282828;
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

    // Insert player, robot, ability, and type objects into the index
    <?= $index_markup ?>

    var debugTimeout = {};
    function showDebug(debugKey, $debugTarget, debugQueue){
        if (typeof debugTimeout[debugKey] !== 'undefined'){
            clearTimeout(debugTimeout[debugKey]);
            }
        if (!debugQueue.length){ return false; }
        var thisDebug = debugQueue.shift();
        $debugTarget.find('.wrap').prepend(thisDebug);
        if (debugQueue.length){
            debugTimeout[debugKey] = setTimeout(function(){
                showDebug(debugKey, $debugTarget, debugQueue);
                }, 400);
            }
    }

    $(document).ready(function(){

        // Dont do anything for this test

    });



    </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();
$html->addScriptMarkup($html_scripts_markup);

// Print out the final HTML page markup
$html->printHtmlPage();

?>