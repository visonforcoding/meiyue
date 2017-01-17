<div class="wraper">
    <div class="activity_initiate bgff">
        <div class="bottom_info info inner">
            <?= $carousel->page; ?>
        </div>
    </div>
</div>

<script>
    LEMON.sys.setTopRight('分享');
    window.onTopRight = function () {
        shareBanner();
    };
    function shareBanner() {
        window.shareConfig.link = '<?= getHost().'/activity/carousel-page/'.$carousel['id']; ?><?= isset($user)?'?ivc='.$user->invit_code:'';?>';
        window.shareConfig.title = '<?= $carousel['title'] ?>';
        window.shareConfig.imgUrl = '<?= getHost().$carousel['url']; ?>';
        var share_desc = '<?= isset($carousel['share_desc'])?$carousel['share_desc']:''; ?>';
        share_desc && (window.shareConfig.desc = share_desc);
        LEMON.show.shareBanner();
    }
    $.util.checkShare();
</script>