<!-- Global site tag (gtag.js) - Google Analytics -->
<? if (MMRPG_CONFIG_IS_LIVE){ ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= MMRPG_ANALYTICS_ACCOUNT ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= MMRPG_ANALYTICS_ACCOUNT ?>');
</script>
<? } ?>
<!-- End Global site tag (gtag.js) - Google Analytics -->