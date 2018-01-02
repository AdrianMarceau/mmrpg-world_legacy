<!-- Global site tag (gtag.js) - Google Analytics -->
<? if (true || !empty($MMRPG_CONFIG['IS_LIVE'])){ ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $MMRPG_CONFIG['ANALYTICS_ACCOUNT'] ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= $MMRPG_CONFIG['ANALYTICS_ACCOUNT'] ?>');
</script>
<? } ?>
<!-- End Global site tag (gtag.js) - Google Analytics -->