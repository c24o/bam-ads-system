<?php
/**
 * Default template for the ads.
 * 
 * Use the array $ad object to get the data of the ad.
 */

// create the HTML id for the ad
$ad_id = 'bam-ad-' . rand(100000, 999999);

// get the stop time of the ad
$stop_time = $ad->getProperty('stop-date') ?: 0;
if ($stop_time) {
    $stop_time = DateTime::createFromFormat('Y-m-d H:i', $stop_time)->getTimestamp() * 1000;
}
?>
<div id="<?= $ad_id ?>" class="bam-ad-container pick-ad">
    <div class="content">
        <div class="countdown-container">
            <div class="timer">
                <div class="days">
                    <span><?= __('Days', 'bam-ads-system') ?></span>
                    <span class="num">-</span>
                </div>
                <div class="hours">
                    <span><?= __('Hours', 'bam-ads-system') ?></span>
                    <span class="num">-</span>
                </div>
                <div class="min">
                    <span><?= __('Min', 'bam-ads-system') ?></span>
                    <span class="num">-</span>
                </div>
                <div class="sec">
                    <span><?= __('Sec', 'bam-ads-system') ?></span>
                    <span class="num">-</span>
                </div>
            </div>
            <div class="disclaimer">
                <?= __('Remaining Time To Place Bet', 'bam-ads-system') ?>
            </div>
        </div>
        <div class="title-container">
            <div class="title"><?= $data['title'] ?></div>
            <div class="tagline">
                <?= __('Hurry up! ', 'bam-ads-system') ?>
                <strong>25</strong>
                <?= __(' people have placed this bet', 'bam-ads-system') ?>
            </div>
        </div>
    </div>
    <div class="call-to-action" style="background-color: <?= $data['bg-color'] ?>;">
        <button><?= __('BET & WIN', 'bam-ads-system') ?></button>
        <div><?= __('Trusted Sportsbetting.ag', 'bam-ads-system') ?></div>
    </div>
</div>
<script>
jQuery("#<?= $ad_id ?>").bamPickAd({
    stop: <?= $stop_time ?>
});
</script>