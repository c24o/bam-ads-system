<?php
/**
 * Controller for the WP shortcode of ads.
 */
namespace BamAdsSystem;

class AdsShortcode
{
    /**
     * Process the WP shortcode and create the visualization of the ad.
     */
    public function process_shortcode($atts = [])
    {
        \ob_start();
        require BAM_ADS_SYSTEM_PATH . '/views/invalid-ad-template.php';
        $error_msg = \ob_get_contents();
        \ob_end_clean();

        // validate ID in atts
        if (empty($atts['id'])) {
            return $error_msg;
        }

        // get and validate the ad
        $ad = AdsAdmin::getAd($atts['id']);
        if (!$ad) {
            return $error_msg;
        }

        // get the template path to render the ad
        $templates = Ad::getTemplates();
        $template_path = $templates[$ad->getTemplate()] ?? false;
        if (!$template_path) {
            return $error_msg;
        }

        // get the data of the ad
        $data = apply_filters('bam_ad_shortcode_data', [
            'title' => $atts['title'] ?? $ad->getTitle(),
            'bg-color' => $ad->getBackgroundColor()
        ], $ad);

        // prepare the content of the ad
        \ob_start();
        include $template_path;
        $content = \ob_get_contents();
        \ob_end_clean();

        return $content;
    }
}