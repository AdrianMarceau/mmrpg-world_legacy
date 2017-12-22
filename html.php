<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $html_title_text ?></title>
        <? if (defined('IS_LEGACY_INDEX')){ ?>
            <meta name="robots" content="index,follow" />
        <? } else { ?>
            <meta name="robots" content="noindex,nofollow" />
        <? } ?>
        <link type="text/css" href="<?= $mmrpg_root_url ?>styles/style.css" rel="stylesheet" />
        <? if (!empty($html_styles_markup)){ echo $html_styles_markup.PHP_EOL; } ?>
    </head>
    <body>
        <div class="website">
            <div class="main">
                <div class="header <?= !defined('IS_LEGACY_INDEX') ? 'has-links' : '' ?>">
                    <h1><?= str_replace('|', '<span class="pipe">|</span>', $html_content_title) ?></h1>
                    <? if (!empty($html_content_description)){ ?><p><?= $html_content_description ?></p><? } ?>
                    <? if (!defined('IS_LEGACY_INDEX')){ ?><div class="links"><a class="link back" href="<?= $mmrpg_root_url ?>"><span>Return to Archive Index</span></a></div><? } ?>
                </div>
                <div class="body">
                    <?= !empty($html_content_markup) ? $html_content_markup : '- page content not found -' ?>
                </div>
            </div>
            <div class="footer">
                <div class="copy">
                    <div class="desc">
                        This website is an archive of legacy content, ideas, images, and prototype versions of the Mega Man RPG.<br />
                        Play the current version of the game at our <a href="http://rpg.megamanpoweredup.net/">main website</a> or
                        <? if (defined('IS_LEGACY_INDEX')){ ?>
                            use the archive index above for a list of legacy content.
                        <? } else { ?>
                            return to the <a href="<?= $mmrpg_root_url ?>">archive index</a> for more legacy content.
                        <? } ?>
                    </div>
                    <div class="credits">
                        This game is fan-made and is not affiliated with nor endorsed by Capcom at all. It is not in any way official.<br />
                        Mega Man and all related names and characters are &copy; <a href="http://www.capcom.com/" target="_blank" rel="nofollow">Capcom</a> 1986 - <?= date('Y') ?>.
                    </div>
                </div>
            </div>
            <? /* <pre>$_GET = <?= print_r($_GET, true) ?></pre> */ ?>
        </div>
        <? if (!empty($html_scripts_markup)){ echo $html_scripts_markup.PHP_EOL; } ?>
        <? if (file_exists($mmrpg_root_dir.'html_analytics.php')){ include($mmrpg_root_dir.'html_analytics.php'); } ?>
    </body>
</html>