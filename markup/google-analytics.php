<!-- Global site tag (gtag.js) - Google Analytics -->
<? if (LEGACY_MMRPG_IS_LIVE){ ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= LEGACY_MMRPG_GA_ACCOUNTID ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= LEGACY_MMRPG_GA_ACCOUNTID ?>');
</script>
<? } ?>
<!-- End Global site tag (gtag.js) - Google Analytics -->