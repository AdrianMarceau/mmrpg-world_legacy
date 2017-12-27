<? if (!strstr($mmrpg_root_url, 'local.')){ ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $mmrpg_analytics_id ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= $mmrpg_analytics_id ?>');
</script>
<!-- End Global site tag (gtag.js) - Google Analytics -->
<? } ?>