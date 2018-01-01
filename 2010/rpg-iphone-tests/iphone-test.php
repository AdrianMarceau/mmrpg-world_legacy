<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Define the headers for this HTML page
$html->addTitle('RPG iPhone Game Test');
$html->setContentDescription(
    'Early concepts for the  Mega Man RPG had the the target device of an iPhone or other comparable smartphone. '.
    'This is an unfinished mockup of a potential battle system layout. '
    );

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">

        <div id="canvas">

            <div id="navbar">
                &nbsp;
            </div>

            <div class="action">
                <table class="attack_container_left">
                <tr>
                <td class="robot"><img src="megaman_attack_shoot.gif" /></td>
                <td class="name"><strong>MegaMan</strong> unleashed a stream of <strong>Buster Shot</strong>s on the opponent! Hit 3 times!</td>
                <td class="number">135</td>
                </tr>
                </table>
            </div>

            <div class="action">
                <table class="attack_container_right">
                <tr>
                <td class="number">189</td>
                <td class="name"><strong>ProtoMan</strong> released a powerful <strong>Proto Blast</strong> at the opponent! It&apos;s a critical hit!</td>
                <td class="robot"><img src="protoman_attack_shoot.gif" /></td>
                </tr>
                </table>
            </div>

            <div class="action">
                <table class="attack_container_left">
                <tr>
                <td class="robot"><img src="megaman_attack_shoot.gif" /></td>
                <td class="name"><strong>MegaMan</strong> unleashed a stream of <strong>Buster Shot</strong>s on the opponent! Hit 3 times!</td>
                <td class="number">135</td>
                </tr>
                </table>
            </div>

            <div class="action">
                <table class="attack_container_right">
                <tr>
                <td class="number">189</td>
                <td class="name"><strong>ProtoMan</strong> released a powerful <strong>Proto Blast</strong> at the opponent! It&apos;s a critical hit!</td>
                <td class="robot"><img src="protoman_attack_shoot.gif" /></td>
                </tr>
                </table>
            </div>

            <div class="action">
                <table class="attack_container_left">
                <tr>
                <td class="robot"><img src="megaman_attack_shoot.gif" /></td>
                <td class="name"><strong>MegaMan</strong> unleashed a stream of <strong>Buster Shot</strong>s on the opponent! Hit 3 times!</td>
                <td class="number">135</td>
                </tr>
                </table>
            </div>

            <div class="action">
                <table class="attack_container_right">
                <tr>
                <td class="number">189</td>
                <td class="name"><strong>ProtoMan</strong> released a powerful <strong>Proto Blast</strong> at the opponent! It&apos;s a critical hit!</td>
                <td class="robot"><img src="protoman_attack_shoot.gif" /></td>
                </tr>
                </table>
            </div>


            <div class="menu">
                <h3 class="prompt">Choose Your Attack</h3>
                <input type="button" class="ability_button nature" value="Leaf Shield" />
                <input type="button" class="ability_button heat" value="Atomic Fire" />
                <input type="button" class="ability_button aqua" value="Bubble Lead" />
                <input type="button" class="ability_button normal" value="Buster Shot" />
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
        <style type="text/css">
            .wrapper {
                background-color: transparent;
                font-family: Arial, Verdana;
                font-size: 12px;
                line-height: 16px;
                color: #393636;
                padding: 0;
                text-align: center;
                vertical-align: top;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }
            table {
                margin: 0;
                padding: 0;
                border-collapse: collapse;
                border-spacing: 0;
                border: 0 none transparent;
            }
            td {
                text-align: center;
                vertical-align: top;
                padding: 0;
            }
            #canvas {
                display: block;
                margin: 40px auto;
                padding-top: 38px;
                width: 320px;
                height: 480px;
                border: 2px solid #202020;
                color: #494646;
                background: #1d1d1d url(html-background.gif) scroll repeat left top;
            }

            #navbar {
                background: #6A6A6A url(gradient_admin-black.gif) scroll repeat-x 0 -25px;
                border-top: 1px solid #494646;
                border-bottom: 1px solid #222222;
                height: 25px;
            }

            .action {
                display: block;
                margin: 4px auto;
                padding: 2px;
                border: 1px solid #222222;
                -moz-border-radius: 0.5em;
                border-top-style: none;
                background: #6A6A6A url(gradient_admin-black.gif) scroll repeat-x 0 -135px;
                width: 300px;
                color: #FFFFFF;
                cursor: pointer;
            }
            .action .attack_container_left,
            .action .attack_container_right {
                width: 300px;
            }
            .action .attack_container_left .robot,
            .action .attack_container_right .robot {
                width: 40px;
                text-align: right;
                vertical-align: middle;
                padding: 4px 0;
            }
            .action .attack_container_left .robot img,
            .action .attack_container_right .robot img {
                display: block;
                vertical-align: middle;
                margin: 0;
            }
            .action .attack_container_right .robot {
                text-align: left;
            }
            .action .attack_container_left .name,
            .action .attack_container_right .name {
                font-size: 10px;
                line-height: 11px;
                text-align:  left;
                vertical-align: middle;
                padding: 4px 6px;
            }
            .action .attack_container_right .name {
                text-align: right;
            }
            .action .attack_container_left .number,
            .action .attack_container_right .number {
                width: 40px;
                font-size: 18px;
                line-height: 20px;
                text-align: left;
                vertical-align: middle;
                padding: 4px 0;
            }
            .action .attack_container_right .number {
                text-align: right;
            }

            .menu {
                display: block;
                margin: 15px auto 4px;
                padding: 8px 2px 12px;
                border: 1px solid #363636;
                -moz-border-radius: 0.5em;
                border-bottom-style: none;
                background: #6A6A6A url(gradient_admin-black.gif) scroll repeat-x 0 -326px;
                width: 300px;
                color: #FFFFFF;
                cursor: pointer;
            }
            .menu .prompt {
                display: block;
                margin: 0 auto 6px;
                font-size: 14px;
                color: #898686;
                text-align: center;
                text-shadow: 2px 2px 2px #222222;
            }
            .menu .ability_button {
                margin: 2px;
                border: 1px solid #222222;
                -moz-border-radius: 0.75em;
                background: #222222 url(gradient_admin-black.gif) scroll repeat-x 0 -126px;
                color: #FFFFFF;
                padding: 6px;
                font-size: 14px;
                text-align: center;
                width: 125px;
                cursor: pointer;
                text-shadow: 2px 2px 2px #222222;
            }
            .menu .ability_button:hover {
                background-position: 0 -145px;
            }
            .menu .nature {
                background-image: url(gradient_ability-nature.gif);
            }
            .menu .heat {
                background-image: url(gradient_ability-heat.gif);
            }
            .menu .aqua {
                background-image: url(gradient_ability-aqua.gif);
            }
            .menu .normal {
                background-image: url(gradient_ability-normal.gif);
            }

        </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
$html->addStyleMarkup($html_styles_markup);

// Start the ouput buffer to collect scripts
ob_start();
    ?>
        <script type="text/javascript" src="scripts/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".action:not(:first)").css({opacity:0.5});
                $(".action:not(:first)").each(function(){
                    $(this).hover(
                        function(){
                            $(this).animate({opacity:1.0},100,'swing');
                            },
                        function(){
                            $(this).animate({opacity:0.5},100,'swing');
                            });
                    });
            });
        </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();
$html->addScriptMarkup($html_scripts_markup);

// Print out the final HTML page markup
$html->printHtmlPage();

?>