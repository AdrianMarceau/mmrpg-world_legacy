<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $this->seo_title ?></title>
        <? if (LEGACY_MMRPG_IS_LIVE === true && defined('IS_LEGACY_INDEX')){ ?>
            <meta name="robots" content="index,follow" />
        <? } else { ?>
            <meta name="robots" content="noindex,nofollow" />
        <? } ?>
        <link type="text/css" href="<?= $this->root_url ?>styles/legacy-index.css?<?= $this->cache_date ?>" rel="stylesheet" />
        <? if (!empty($this->styles_markup)){ echo $this->styles_markup.PHP_EOL; } ?>
    </head>
    <body>
        <? if (defined('LEGACY_FLAG_SKIP_WRAPPER') && LEGACY_FLAG_SKIP_WRAPPER === true){ ?>

            <?= !empty($this->content_markup) ? $this->content_markup : '- page content not found -' ?>

        <? } else { ?>

            <div class="website">
                <div class="main">
                    <div class="header <?= !defined('IS_LEGACY_INDEX') ? 'has-links' : '' ?>">
                        <h1><?= str_replace('|', '<span class="pipe">|</span>', $this->content_title) ?></h1>
                        <? if (!empty($this->content_description)){ ?><p><?= $this->content_description ?></p><? } ?>
                        <? if (!defined('IS_LEGACY_INDEX')){ ?><div class="links"><a class="link back" href="<?= $this->root_url ?>"><span>Return to Archive Index</span></a></div><? } ?>
                    </div>
                    <div class="body">
                        <?= !empty($this->content_markup) ? $this->content_markup : '- page content not found -' ?>
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
                                return to the <a href="<?= $this->root_url ?>">archive index</a> for more legacy content.
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

        <? } ?>

        <? if (!empty($this->scripts_markup)){ echo $this->scripts_markup.PHP_EOL; } ?>

        <? include($this->root_dir.'markup/google-analytics.php'); ?>

    </body>
</html>