<?php

// Require the top files
require('../../config.php');
require('../../apptop.php');

// Define the headers for this file
$html_title_text = 'RPG Prototype 2k11 | '.$html_title_text;
$html_content_title = $html_content_title.' | RPG Prototype 2k11';
$html_content_description = '';

// Include the TOP file
require_once('top.php');

// Start the ouput buffer to collect content
ob_start();
    ?>

    <? include('legacy_header.php'); ?>

    <div class="wrapper legacywrap">

        <div class="index">

            <div id="window">
                <iframe name="battle" src="about:blank" width="502" height="569" frameborder="1" scrolling="no">
                </iframe>
            </div>

            <div id="debug">
                <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-1&this_player_token=dr-light&target_player_token=dr-wily">Light vs Wily<br />Ice Field</a>
                <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-1&this_player_token=dr-wily&target_player_token=dr-light">Wily vs Light<br />Ice Field</a>
                <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-2&this_player_token=dr-light&target_player_token=dr-wily">Light vs Wily<br />Guts Field</a>
                <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-2&this_player_token=dr-wily&target_player_token=dr-light">Wily vs Light<br />Guts Field</a>


                <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-3&this_player_token=debug-one&target_player_token=debug-two">TEST</a>
            </div>

            <?/*
            <pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
            <?=print_r($_SESSION['RPG2k11'], true)?>
            =================================
            <?=print_r($mmrpg_index['robots'], true)?>
            </pre>
            */?>

        </div>

    </div>

    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();

// Start the ouput buffer to collect styles
ob_start();
    ?>
        <link type="text/css" href="styles/reset.noconflict.css" rel="stylesheet" />
        <link type="text/css" href="styles/style.css?20110924s" rel="stylesheet" />
        <link rel="stylesheet" href="styles/mobile.css?20110924s" media="only screen and (max-device-width: 480px)" type="text/css" />
        <? if($flag_wap): ?>
            <link type="text/css" href="styles/mobile.css?20110924s" rel="stylesheet" />
        <? endif; ?>
        <style type="text/css">
            .wrapper {
                text-align: center;
            }
        </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();

// Start the ouput buffer to collect scripts
ob_start();
    ?>
        <script type="text/javascript" src="scripts/jquery.js"></script>
        <script type="text/javascript" src="scripts/script.js?20110917"></script>
        <? if($flag_wap): ?>
            <script type="text/javascript">
                function updateMobileCache(event){ window.applicationCache.swapCache(); }
                window.applicationCache.addEventListener('updateready', updateMobileCache, false);
            </script>
        <? endif; ?>
        <script type="text/javascript">

        </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();

// Require the page template
define('LEGACY_FLAG_SKIP_WRAPPER', true);
require('../../html.php');

?>