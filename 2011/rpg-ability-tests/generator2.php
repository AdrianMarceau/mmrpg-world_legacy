<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Define the headers for this HTML page
$html->addTitle('RPG Ability Tests')->addTitle('Special Weapon Generator v2');
$html->setContentDescription(
    'At one point robot masters would learn new abilities based on who they defeated in battle. '.
    'This is a list of abilities generated in this way, but with some renamed special weapons. '
    );

$abilities = array();

// MegaMan 1
$abilities[] = array('Cut Man', 'Rolling', 'Cutter', 'cutter', 2);
$abilities[] = array('Bomb Man', 'Hyper', 'Bomb', 'explode', 2);
$abilities[] = array('Elec Man', 'Thunder', 'Beam', 'electric', 1);
$abilities[] = array('Guts Man', 'Super', 'Punch', 'impact', 2, 2);  // Super Arm
$abilities[] = array('Fire Man', 'Fire', 'Storm', 'flame', 1);
$abilities[] = array('Ice Man', 'Ice', 'Slasher', 'freeze', 1);
$abilities[] = array('Oil Man', 'Oil', 'Slider', 'earth', 1);
$abilities[] = array('Time Man', 'Time', 'Arrow', 'time', 1);

// MegaMan 2
$abilities[] = array('Air Man', 'Air', 'Shooter', 'wind', 1);
$abilities[] = array('Bubble Man', 'Bubble', 'Lead', 'water', 1);
$abilities[] = array('Metal Man', 'Metal', 'Blade', 'cutter', 1);
$abilities[] = array('Heat Man', 'Atomic', 'Flare', 'flame', 2, 2);  // Atomic Fire
$abilities[] = array('Flash Man', 'Flash', 'Stopper', 'time', 2, 1);  // Time Stopper
$abilities[] = array('Crash Man', 'Crash', 'Bomber', 'explode', 2);
$abilities[] = array('Wood Man', 'Leaf', 'Shield', 'nature', 1);
$abilities[] = array('Quick Man', 'Quick', 'Boomerang', 'swift', 1);

// MegaMan 3
$abilities[] = array('Gemini Man', 'Gemini', 'Laser', 'laser', 1);
$abilities[] = array('Hard Man', 'Hard', 'Knuckle', 'impact', 1);
$abilities[] = array('Magnet Man', 'Magnet', 'Missile', 'missile', 1);
$abilities[] = array('Needle Man', 'Needle', 'Cannon', 'cutter', 1);
$abilities[] = array('Shadow Man', 'Shadow', 'Blade', 'shadow', 1);
$abilities[] = array('Snake Man', 'Search', 'Snake', 'nature', 2);
$abilities[] = array('Spark Man', 'Spark', 'Shock', 'electric', 1);
$abilities[] = array('Top Man', 'Top', 'Spin', 'swift', 1);

// MegaMan 4
$abilities[] = array('Bright Man', 'Bright', 'Stunner', 'time', 1, 2);  // Flash Stopper
$abilities[] = array('Dive Man', 'Dive', 'Torpedo', 'missile', 1, 2); // Dive Missile
$abilities[] = array('Drill Man', 'Drill', 'Blitz', 'earth', 1, 2);  // Drill Bomb
$abilities[] = array('Dust Man', 'Dust', 'Crusher', 'wind', 1);
$abilities[] = array('Pharaoh Man', 'Pharaoh', 'Curse', 'flame', 1, 2);  // Pharaoh Shot
$abilities[] = array('Ring Man', 'Ring', 'Throw', 'space', 1);  // Ring Boomerang
$abilities[] = array('Skull Man', 'Skull', 'Barrier', 'shadow', 1);
$abilities[] = array('Toad Man', 'Rain', 'Flush', 'water', 1);

// MegaMan 5
$abilities[] = array('Gravity Man', 'Gravity', 'Hold', 'electric', 1);
$abilities[] = array('Wave Man', 'Water', 'Wave', 'water', 1);
$abilities[] = array('Stone Man', 'Power', 'Stone', 'earth', 2);
$abilities[] = array('Gyro Man', 'Gyro', 'Attack', 'wind', 1);
$abilities[] = array('Star Man', 'Star', 'Crash', 'space', 1);
$abilities[] = array('Charge Man', 'Charge', 'Kick', 'swift', 1);
$abilities[] = array('Napalm Man', 'Napalm', 'Firework', 'explode', 1, 2);
$abilities[] = array('Crystal Man', 'Crystal', 'Eye', 'crystal', 1);

// MegaMan 6
$abilities[] = array('Blizzard Man', 'Blizzard', 'Attack', 'freeze', 1);
$abilities[] = array('Centaur Man', 'Centaur', 'Flash', 'time', 1);
$abilities[] = array('Flame Man', 'Flame', 'Blast', 'flame', 1);
$abilities[] = array('Knight Man', 'Knight', 'Crush', 'impact', 1);
$abilities[] = array('Plant Man', 'Plant', 'Guard', 'nature', 1, 2);
$abilities[] = array('Tomahawk Man', 'Silver', 'Tomahawk', 'earth', 2);
$abilities[] = array('Wind Man', 'Wind', 'Storm', 'wind', 1);
$abilities[] = array('Yamato Man', 'Yamato', 'Spear', 'cutter', 1);

// MegaMan 7
$abilities[] = array('Freeze Man', 'Freeze', 'Cracker', 'freeze', 1);  // DWN. 049 Freeze Man
$abilities[] = array('Junk Man', 'Junk', 'Fortress', 'earth', 1, 2);  // DWN. 050 Junk Man
$abilities[] = array('Burst Man', 'Danger', 'Wrap', 'explode', 1);  // DWN. 051 Burst Man
$abilities[] = array('Cloud Man', 'Storm', 'Cloud', 'electric', 2, 3);  // DWN. 052 Cloud Man
$abilities[] = array('Spring Man', 'Wild', 'Coil', 'impact', 1);  // DWN. 053 Spring Man
$abilities[] = array('Slash Man', 'Slash', 'Claw', 'nature', 1);  // DWN. 054 Slash Man
$abilities[] = array('Shade Man', 'Noise', 'Crush', 'shadow', 1);  // DWN. 055 Shade Man
$abilities[] = array('Turbo Man', 'Scorch', 'Wheel', 'swift', 1);  // DWN. 056 Turbo Man

// MegaMan 8
$abilities[] = array('Tengu Man', 'Tornado', 'Hold', 'wind', 1);  // DWN. 057 Tengu Man
$abilities[] = array('Astro Man', 'Astro', 'Crush', 'space', 1);  // DWN. 058 Astro Man
$abilities[] = array('Sword Man', 'Flame', 'Sword', 'flame', 1);  // DWN. 059 Sword Man
$abilities[] = array('Clown Man', 'Electric', 'Carnival', 'electric', 2, 3);  // DWN. 060 Clown Man
$abilities[] = array('Search Man', 'Homing', 'Sniper', 'missile', 1);  // DWN. 061 Search Man
$abilities[] = array('Frost Man', 'Frost', 'Wave', 'freeze', 1, 1);  // DWN. 062 Frost Man
$abilities[] = array('Grenade Man', 'Flash', 'Grenade', 'explode', 1, 2);  // DWN. 063 Grenade Man
$abilities[] = array('Aqua Man', 'Aqua', 'Balloon', 'water', 1, 1);  // DWN. 064 Aqua Man

// MegaMan 8.5
$abilities[] = array('Dynamo Man', 'Lightning', 'Bolt', 'electric', 1);  // KGN. Dynamo Man
$abilities[] = array('Cold Man', 'Frozen', 'Wall', 'freeze', 1, 1);  // KGN. Cold Man
$abilities[] = array('Ground Man', 'Spread', 'Drill', 'earth', 1);  // KGN. Ground Man
$abilities[] = array('Pirate Man', 'Remote', 'Mine', 'explode', 1);  // KGN. Pirate Man
$abilities[] = array('Burner Man', 'Wave', 'Burner', 'flame', 1);  // KGN. Burner Man
$abilities[] = array('Magic Man', 'Magic', 'Card', 'shadow', 1);  // KGN. Magic Man

// MegaMan 9
$abilities[] = array('Concrete Man', 'Concrete', 'Block', 'impact', 1, 2);  // DLN. 065 Concrete Man
$abilities[] = array('Tornado Man', 'Tornado', 'Blow', 'wind', 1);  // DLN. 066 Tornado Man
$abilities[] = array('Splash Woman', 'Laser', 'Trident', 'water', 1);  // DLN. 067 Splash Woman
$abilities[] = array('Plug Man', 'Plug', 'Ball', 'electric', 1);  // DLN. 068 Plug Man
$abilities[] = array('Jewel Man', 'Jewel', 'Satellite', 'crystal', 1);  // DLN. 069 Jewel Man
$abilities[] = array('Hornet Man', 'Hornet', 'Chaser', 'nature', 1);  // DLN. 070 Hornet Man
$abilities[] = array('Magma Man', 'Magma', 'Bazooka', 'flame', 1);  // DLN. 071 Magma Man
$abilities[] = array('Galaxy Man', 'Galaxy', 'Void', 'space', 1, 3);  // DLN. 072 Galaxy Man

// MegaMan 10
$abilities[] = array('Blade Man', 'Triple', 'Blade', 'cutter', 1);  // DWN. 073 Blade Man
$abilities[] = array('Pump Man', 'Water', 'Surge', 'water', 1, 2);  // DWN. 074 Pump Man
$abilities[] = array('Commando Man', 'Commando', 'Rush', 'explode', 1, 2);  // DWN. 075 Commando Man
$abilities[] = array('Chill Man', 'Chill', 'Spike', 'freeze', 1);  // DWN. 076 Chill Man
$abilities[] = array('Sheep Man', 'Static', 'Wool', 'electric', 1, 1);  // DWN. 077 Sheep Man
$abilities[] = array('Strike Man', 'Rebound', 'Striker', 'impact', 1);  // DWN. 078 Strike Man
$abilities[] = array('Nitro Man', 'Wheel', 'Cutter', 'swift', 1);  // DWN. 079 Nitro Man
$abilities[] = array('Solar Man', 'Solar', 'Blaze', 'flame', 1);  // DWN. 080 Solar Man

// Count the number of duplicated words
$ability_word_counter = array();
foreach ($abilities AS $ability){
    if (!isset($ability_word_counter[$ability[1]])){ $ability_word_counter[$ability[1]] = 0; }
    $ability_word_counter[$ability[1]]++;
    if (!isset($ability_word_counter[$ability[2]])){ $ability_word_counter[$ability[2]] = 0; }
    $ability_word_counter[$ability[2]]++;
}

// Find duplicated ability words for display
$duplicate_ability_words = array();
foreach ($ability_word_counter AS $word => $count){
    if ($count > 1){ $duplicate_ability_words[$word] = $count; }
}

// Sort duplicates by worst offenders
arsort($duplicate_ability_words);

// Group abilities based on number of dupes
$duplicate_ability_word_groups = array();
foreach ($duplicate_ability_words AS $word => $count){
    if (!isset($duplicate_ability_word_groups[$count])){ $duplicate_ability_word_groups[$count] = array(); }
    $duplicate_ability_word_groups[$count][] = $word;
}

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">

        <?
        // Pregenerate the table, then display results up top
        ob_start();

            ?>
            <table class="abilities">
                <colgroup>
                    <col width="75" />
                    <col width="" />
                    <col width="100" />
                    <col width="100" />
                    <col width="200" />
                </colgroup>
                <thead>
                    <tr>
                        <th class="id">ID No.</th>
                        <th class="name">Ability Name</th>
                        <th class="type t1">Type 1</th>
                        <th class="type t2">Type 2</th>
                        <th class="method">Learn Method</th>
                    </tr>
                </thead>
                <?

                $ability_index = array();
                $ability_type_index = array();
                $ability_name_counter = array();

                $counter = 0;
                foreach ($abilities AS $key1 => $ability1){

                    echo "<tbody>\r\n";

                        $robot_name = $ability1[0];

                        //echo "<strong style=\"display: block; margin: 0 auto 5px;\">{$robot_name}</strong>\r\n";
                        echo "<tr><td class=\"head\" colspan=\"5\"><strong>{$robot_name}</strong></td></tr>\r\n";

                        $counter++;
                        $counter_padded = str_pad($counter, 4, '0', STR_PAD_LEFT);
                        $ability_name = $ability1[1].' '.$ability1[2];
                        $ability_type = ucfirst($ability1[3]);
                        $ability_base = $ability1[4];

                        $ability_index[] = $ability_name;

                        if (!isset($ability_type_index[$ability_type])){ $ability_type_index[$ability_type] = 0; }
                        $ability_type_index[$ability_type]++;

                        if (!isset($ability_name_counter[$ability_name])){ $ability_name_counter[$ability_name] = 0; }
                        $ability_name_counter[$ability_name]++;

                        $ability1_word1_updated = !empty($ability1[5]) && ($ability1[5] === 1 || $ability1[5] === 3) ? true : false;
                        $ability1_word2_updated = !empty($ability1[5]) && ($ability1[5] === 2 || $ability1[5] === 3) ? true : false;

                        $updated = $ability1_word1_updated || $ability1_word2_updated ? true : false;
                        $tr_class = '';
                        $tr_class .=  $updated ? 'updated ' : '';

                        //echo "#{$counter_padded}&nbsp;&nbsp;<span>{$ability_name}</span>&nbsp;&nbsp;<em>[{$ability_type}]</em>&nbsp;&nbsp;<span style=\"color: #898989; font-size: 80%;\">(Start)</span><br />\r\n";
                        echo "<tr class=\"{$tr_class}\">";
                            echo "<td class=\"id\">{$counter_padded}</td>";
                            echo "<td class=\"name\">{$ability_name}</td>";
                            echo "<td class=\"type t1\">{$ability_type}</td>";
                            echo "<td class=\"type t2\">-</td>";
                            echo "<td class=\"method\">Start</td>";
                        echo "</tr>\r\n";

                        foreach ($abilities AS $key2 => $ability2){

                            if ($ability1[0] == $ability2[0]){ continue; }

                            if ($ability_base == 1){ $ability_name = $ability1[1].' '.$ability2[2];  }
                            else { $ability_name = $ability2[1].' '.$ability1[2]; }

                            if (!in_array($ability_name, $ability_index)){
                                $counter++;
                                $counter_padded = str_pad($counter, 4, '0', STR_PAD_LEFT);
                                $ability_index[] = $ability_name;
                            }
                            else {
                                $temp_counter = array_search($ability_name, $ability_index) + 1;
                                $counter_padded = str_pad($temp_counter, 4, '0', STR_PAD_LEFT);
                            }

                            //$ability_type = $ability1[3].' / '.$ability2[3];
                            $ability_type = ucfirst($ability1[3]);
                            $ability_type2 = $ability2[3] != $ability1[3] ? ucfirst($ability2[3]) : '-';

                            if (!isset($ability_type_index[$ability_type])){ $ability_type_index[$ability_type] = 0; }
                            $ability_type_index[$ability_type]++;

                            if ($ability_type2 !== '-'){
                                if (!isset($ability_type_index[$ability_type2])){ $ability_type_index[$ability_type2] = 0; }
                                $ability_type_index[$ability_type2]++;
                            }

                            if (!isset($ability_name_counter[$ability_name])){ $ability_name_counter[$ability_name] = 0; }
                            $ability_name_counter[$ability_name]++;

                            $ability2_word1_updated = !empty($ability2[5]) && ($ability2[5] === 1 || $ability2[5] === 3) ? true : false;
                            $ability2_word2_updated = !empty($ability2[5]) && ($ability2[5] === 2 || $ability2[5] === 3) ? true : false;

                            if ($ability_base == 1){ $updated = $ability1_word1_updated || $ability2_word2_updated ? true : false; }
                            else { $updated = $ability2_word1_updated || $ability1_word2_updated ? true : false; }
                            $tr_class = '';
                            $tr_class .= $updated ? 'updated ' : '';

                            //echo "#{$counter_padded}&nbsp;&nbsp;<span>{$ability_name}</span>&nbsp;&nbsp;<em>[{$ability_type}]</em>&nbsp;&nbsp;<span style=\"color: #898989; font-size: 80%;\">(Defeat {$ability2[0]})</span><br />\r\n";
                            echo "<tr class=\"{$tr_class}\">";
                                echo "<td class=\"id\">{$counter_padded}</td>";
                                echo "<td class=\"name\">{$ability_name}</td>";
                                echo "<td class=\"type t1\">{$ability_type}</td>";
                                echo "<td class=\"type t2\">{$ability_type2}</td>";
                                echo "<td class=\"method\">Defeat {$ability2[0]}</td>";
                            echo "</tr>\r\n";

                        }

                    echo "</tbody>\r\n";

                }

                // Sort the ability type info by highest
                arsort($ability_type_index);

                // Find duplicated ability names for display
                $duplicate_ability_names = array();
                foreach ($ability_name_counter AS $name => $count){
                    if ($count > 1){ $duplicate_ability_names[$name] = $count; }
                }
                // Sort duplicates by worst offenders
                arsort($duplicate_ability_names);
                // Group abilities based on number of dupes
                $duplicate_ability_name_groups = array();
                foreach ($duplicate_ability_names AS $name => $count){
                    if (!isset($duplicate_ability_name_groups[$count])){ $duplicate_ability_name_groups[$count] = array(); }
                    $duplicate_ability_name_groups[$count][] = $name;
                }

                ?>
            </table>
            <?

        // Collect ability table markup to display later
        $ability_table_markup = ob_get_clean();

        ?>

        <?= $ability_table_markup ?>

        <div class="stats debug" style="margin-top: 10px;">
            <div><strong>Generated Ability Stats</strong></div>
            <div class="pre"><strong>Total Abilities</strong>: <?= count($ability_index) ?></div>
            <? foreach ($ability_type_index AS $type => $count){  ?>
                <div class="pre"><strong>Total Abilities w/ <?= $type ?> Type</strong>: <?= $count ?></div>
            <? } ?>
        </div>

        <div class="stats debug" style="margin-top: 10px;">
            <div><strong>Most Overused Words</strong></div>
            <? $key = 0; foreach ($duplicate_ability_word_groups AS $count => $words){ ?>
                <div class="pre" style="word-break: normal;">
                    <strong>Used in <?= $count ?> Base Ability Names</strong>:
                    <?= count($words) > 20 ? (implode(', ', array_slice($words, 0, 20)).', '.(count($words) - 20).' more...') : implode(', ', $words) ?>
                </div>
            <? $key++; if ($key >= 20){ break; } } ?>
        </div>

        <div class="stats debug" style="margin-top: 10px;">
            <div><strong>Most Repeated Abilities</strong></div>
            <? $key = 0; foreach ($duplicate_ability_name_groups AS $count => $names){ ?>
                <div class="pre" style="word-break: normal;">
                    <strong>Learned by <?= $count ?> Robots</strong>:
                    <?= count($names) > 20 ? (implode(', ', array_slice($names, 0, 20)).', '.(count($names) - 20).' more...') : implode(', ', $names) ?>
                </div>
            <? $key++; if ($key >= 20){ break; } } ?>
        </div>

    </div>
    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();
$html->addContentMarkup($html_content_markup);

// Start the ouput buffer to collect styles
ob_start();
    ?>

    <style type="text/css">
        table.abilities {
            margin: 0 auto 20px;
            width: 100%;
            box-sizing: border-box;
            border-collapse: collapse;
            border-spacing: 0;
            table-layout: fixed;
            font-size: 12px;
            line-height: 1.2;
        }
        table.abilities th,
        table.abilities td {
            padding: 6px;
            text-align: left;
            vertical-align: middle;
        }
        table.abilities th {
            background-color: #333333;
        }
        table.abilities tr:nth-child(odd) td {
            background-color: #626262;
        }
        table.abilities tr:nth-child(even) td {
            background-color: #525252;
        }
        table.abilities tr:nth-child(odd) td.head,
        table.abilities tr:nth-child(even) td.head {
            background-color: #444444;
            padding: 9px 6px;
            font-size: 13px;
        }

        table.abilities tr th.name,
        table.abilities tr td.name {
            font-weight: bold;
        }
        table.abilities tr th.type,
        table.abilities tr td.type {
            text-align: center;
        }
        table.abilities tr th.method,
        table.abilities tr td.method {

        }

        table.abilities tr.updated th,
        table.abilities tr.updated td {
            color: #fff3d6;
        }
        table.abilities tr.updated td.name:after {
            content: "(Updated)";
            display: inline-block;
            font-size: 11px;
            padding: 0 0 0 6px;
            position: relative;
            font-weight: normal;
            bottom: 2px;
            opacity: 0.75;
        }

        .stats {
            display: block;
            margin: 0 auto 4px;
            padding: 12px;
            background-color: #282828;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            font-size: 13px;
            line-height: 1.2;
        }
        .stats .pre {
            display: block;
            margin: 6px auto 0;
            padding: 0px;
            font-size: 12px;
            color: #969696;
        }

    </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
$html->addStyleMarkup($html_styles_markup);

// Print out the final HTML page markup
$html->printHtmlPage();

?>