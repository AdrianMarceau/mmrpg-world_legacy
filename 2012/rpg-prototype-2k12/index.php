<?php

// Include the TOP file
require_once('top.php');

// Define the headers for this HTML page
$html->addTitle('RPG Prototype 2k12');
$html->setContentDescription('');

// Start the ouput buffer to collect content
ob_start();
    ?>

    <? include('legacy_header.php'); ?>

    <div class="wrapper legacywrap">
        <div class="index">
            <div id="window">
                <?if(!$flag_wap):?>
                <iframe name="battle" src="prototype.php?wap=false" width="768" height="1004" frameborder="1" scrolling="no"></iframe>
                <?else:?>
                <iframe name="battle" src="prototype.php?wap=true" width="768" height="684" frameborder="0" scrolling="no"></iframe>
                <?endif;?>
            </div>
            <? /*
            <pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
                <?=print_r($_SESSION['RPG2k12'], true)?>
                =================================
                <?=print_r($mmrpg_index['robots'], true)?>
            </pre>
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
        <link type="text/css" href="styles/reset.noconflict.css" rel="stylesheet" />
        <link type="text/css" href="styles/style.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
        <?if($flag_wap):?>
            <link type="text/css" href="styles/mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
        <?endif;?>
        <style type="text/css">

        </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
$html->addStyleMarkup($html_styles_markup);

// Start the ouput buffer to collect scripts
ob_start();
    ?>
        <script type="text/javascript" src="scripts/jquery.js"></script>
        <script type="text/javascript" src="scripts/script.js?<?=$MMRPG_CONFIG['CACHE_DATE']?>"></script>
        <?if($flag_wap):?>
            <script type="text/javascript">
                // Define the key client variables
                gameWAP = <?= $flag_wap ? 'true' : 'false' ?>;
                gameCache = '<?=$MMRPG_CONFIG['CACHE_DATE']?>';
                // When the document is ready for event binding
                $(document).ready(function(){

                    // Check if we're running the game in mobile mode
                    if (gameWAP){

                        // Let the user know about the full-screen option for mobile browsers
                        if (('standalone' in window.navigator) && !window.navigator.standalone){
                            alert('Please use "Add to Home Screen" option for best view! :)');
                            } else if (('standalone' in window.navigator) && window.navigator.standalone){
                            //alert('launched from full-screen ready browser, and in full screen!');
                            } else {
                            //alert('launched from a regular old browser...');
                            }

                    }

                    // DEBUG : Alert the user of the cache date
                    //alert('gameCache : '+gameCache);

                });
                //function updateMobileCache(event){ window.applicationCache.swapCache(); }
            </script>
        <?endif;?>
        <script type="text/javascript">

        </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();
$html->addScriptMarkup($html_scripts_markup);

// Print out the final HTML page markup
define('LEGACY_FLAG_SKIP_WRAPPER', true);
$html->printHtmlPage();

?>