<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Define the headers for this HTML page
$html->addTitle('RPG Display Tests')->addTitle('Battle Layout Template');
$html->setContentDescription(
    'Several different layouts for a browser-based Mega Man RPG were experimented with during development. '.
    'This is the first of the early battle system layouts. '
    );

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">

        <div id="page">

            <h2>MegaMan Powered Up RPG</h2>
            <h3>Play-by-Post Text-Adventure Role-Playing Game</h3>
            <h1>Battle Layout Template</h1>

            <table id="battle_area">
            <tr>
            <td width="40%">

            <h5>Battle Overview</h5>
            <div id="overview">
            overview
            </div>

            </td>
            <td width="60%" rowspan="2">

            <h5>Play-by-Play Timeline</h5>
            <div id="timeline">
            timeline<br />
            <?
            // Test the overflow
            for ($i = 100; $i >= 1; $i--)
            {
            ?>
            <table class="post">
            <tr>
            <td class="turn" width="10"><a name="turn_<?=$i?>" href="javascript:;">#<?=$i?></a></td>
            </td>
            <td class="team" width="50">
                <span class="robot">
                    <img src="images/character_profiles/bombman_60x60.png" alt="Bomb Man" width="60" height="60" />
                    <label>143/546 LE</label>
                </span>
                <span class="robot">
                    <img src="images/character_profiles/fireman_60x60.png" alt="Fire Man" width="60" height="60" />
                    <label>300/341 LE</label>
                </span>
            </td>
            <td class="actions">
            <em>&quot;We&#39;re gonna mess you up!&quot;</em>
            <strong>BombMan and FireMan used <u>Double Team</u>!</strong>
            <span>BombMan throwns a barrage of bombs at the targets!</span>
            <span>FireMan conjurs up a storm of Fire!</span>
            <strong>Knight Roll is hit by the attack!</strong>
            <span>67 <img src="images/type_icons/bomb_icon_25x25.png" alt="BOMB" title="BOMB"/> damage!</span>
            <span>76 <img src="images/type_icons/heat_icon_25x25.png" alt="HEAT" title="HEAT"/> damage!</span>
            <strong>Elec Man is hit by the attack!</strong>
            <span>120 <img src="images/type_icons/bomb_icon_25x25.png" alt="BOMB" title="BOMB"/> damage!</span>
            <span>457 <img src="images/type_icons/heat_icon_25x25.png" alt="HEAT" title="HEAT"/> damage!</span>
            <strong>Knight Roll is hit by the attack!</strong>
            <span>67 <img src="images/type_icons/bomb_icon_25x25.png" alt="BOMB" title="BOMB"/> damage!</span>
            <span>76 <img src="images/type_icons/heat_icon_25x25.png" alt="HEAT" title="HEAT"/> damage!</span>
            </td>
            <td class="team" width="40">
                <span class="robot">
                    <img src="images/character_profiles/knight_roll_60x60.png" alt="Knight Roll" width="60" height="60" />
                    <label>148/483 LE</label>
                </span>
                <span class="robot">
                    <img src="images/character_profiles/elecman_60x60.png" alt="Elec Man" width="60" height="60" />
                    <label>24/841 LE</label>
                </span>
                <span class="robot">
                    <img src="images/character_profiles/knight_roll_60x60.png" alt="Knight Roll" width="60" height="60" />
                    <label>155/478 LE</label>
                </span>
            </td>
            </tr>
            </table>
            <?
            }
            ?>
            </div>

            </td>
            </tr>
            <tr>
            <td width="40%">

            <h5>Action Panel</h5>
            <div id="action">
            action
            </div>

            </td>
            </tr>
            </table>

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
            .wrapper {
                margin: 0;
                padding: 20px;
                background: transparent url(mmpu_background.gif) repeat top left;
                height: 100%;
                text-align: center;
                -moz-border-radius: 6px;
                -webkit-border-radius: 6px;
                border-radius: 6px;
            }
            #page {
                display: block;
                margin: 0 auto;
                height: 100%;
                min-height: 100%;
                width: 790px;
                min-width: 790px;
                border-width: 4px;
                border-style: solid;
                border-color: #DEDEDE;
                background-color: #FFF;
                text-align: center;
                padding: 10px;
                color: #222;
            }
            #page h1 {
                margin: 6px auto;
                text-align: left;
                border-bottom: 4px double #222;
                color: #222;
                padding-bottom: 8px;
            }
            #page h2 {
                margin: 3px auto;
                text-align: right;
                color: #222;
            }
            #page h3 {
                margin: 0 auto;
                text-align: right;
                font-style: italic;
                font-size: 12px;
                color: #222;
            }
            #page h5 {
                margin: 0 auto;
                padding: 0;
                font-size: 15px;
                font-weight: bold;
                color: #464646;
                text-align: center;
            }

            #battle_area {
                border-collapse: collapse;
                border-style: none;
                width: 98%;
                margin: 20px auto;
                background-color: #DEDEDE;
            }
            #battle_area td {
                text-align: center;
                vertical-align: top;
                padding: 0;
            }

            #overview, #timeline, #action {
                margin: 0 auto;
                background-color: #FFF;
                border: 2px solid #DEDEDE;
                text-align: center;
                width: 98%;
            }

            #overview {
                min-height: 300px;
                height: 300px;
            }

            #timeline {
                min-height: 535px;
                height: 535px;
                max-height: 535px;
                overflow: auto;
            }

            #action {
                min-height: 200px;
                height: 200px
            }

            #page table.post {
                margin: 0 auto 4px;
                width: 98%;
                min-width: 98%;
                max-width: 98%;
                border: 1px solid #EFEFEF;
                font-size: 12px;
                color: #222;
            }
            #page table.post td.turn a {
                color: #CACACA;
                font-size: 10px;
                text-decoration: none;
            }
            #page table.post td.turn a:hover {
                color: #DEDEDE;
                text-decoration: underline;
            }

            #page table.post td.actions {

            }
            #page table.post td.actions em {
                display: block;
                margin: 0 auto 2px;
                color: #747474;
                font-style: italic;
                text-align: center;
                font-size: 14px;
            }
            #page table.post td.actions strong {
                display: block;
                margin: 0 8px 2px;
                color: #444;
                text-align: left;
                font-size: 11px;
            }
            #page table.post td.actions span {
                display: block;
                margin: 0 8px 2px;
                color: #555;
                text-align: left;
                font-size: 10px;
            }
            #page table.post td.actions span img {
                width: 15px;
                height: 15px;
                margin: 0 2px;
            }

            #page table.post td.team span.robot label {
                display: block;
                margin: 0 8px 2px;
                color: #222;
                text-align: left;
                font-size: 10px;
            }

        </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
$html->addStyleMarkup($html_styles_markup);

// Print out the final HTML page markup
$html->printHtmlPage();

?>
