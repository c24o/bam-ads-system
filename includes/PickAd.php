<?php
/**
 * Create a new type of ad called Pick.
 * 
 * This class register the new type, its attributes and the template to render the ads.
 */
namespace BamAdsSystem;

class PickAd
{
    /**
     * Run the process to register the new type of ads in the system.
     */
    public function init()
    {
        add_filter('bam_get_ads_types', [$this, 'registerType']);
        add_filter('bam_get_ads_templates', [$this, 'registerTemplate']);
        add_action('bam_pick_ads_attributes', [$this, 'addMetaboxAttributes']);
        add_action('bam_save_pick_ad', [$this, 'saveAttributes'], 10, 2);
        add_action('admin_notices', [$this, 'displayErrorNotice']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * Register the type.
     * 
     * @see filter hook bam_get_ads_types
     */
    public function registerType($types)
    {
        $types['pick'] = __('Pick', 'bam-ads-system');
        return $types;
    }

    /**
     * Register the template.
     * 
     * @see filter hook bam_get_ads_templates
     */
    public function registerTemplate($templates)
    {
        $templates['Pick'] = BAM_ADS_SYSTEM_PATH . '/views/pick-ads-template.php';
        return $templates;
    }

    /**
     * Add the fields for the attributes of the pick ad.
     * 
     * @see action hook bam_{type}_ads_attributes
     */
    public function addMetaboxAttributes($ad)
    {
        include BAM_ADS_SYSTEM_PATH . '/views/pick-ads-attributes.php';
    }

    /**
     * Save the attributes when the ad is saved.
     * 
     * @see action hook bam_save_{type}_ad
     */
    public function saveAttributes($ad, $data)
    {
        // validate the stop
        if (empty($data['stop-date'])) {
            add_option('bam_saving_ad_error', __('Please add an stop date.', 'bam-ads-system'));
            return;
        }

        // validate that the stop date is a date 
        $stop_date = date_create_from_format('Y-m-d H:m', $data['stop-date']);
        if (!$stop_date) {
            add_option('bam_saving_ad_error', __('Please insert a valid date(YYYY-MM-DD HH:MM) for the stop date.', 'bam-ads-system'));
            return;
        }

        // TODO: validate that the stop date is in the future?

        // save the stop date
        $ad->saveProperty('stop-date', $data['stop-date']);
    }

    /**
     * Display errors after the saving of an ad.
     * 
     * @param string $message error message to display.
     */
    public function displayErrorNotice()
    {
        $message = get_option('bam_saving_ad_error');
        if ($message) {
            delete_option('bam_saving_ad_error');
            include BAM_ADS_SYSTEM_PATH . '/views/pick-ads-error-notice.php';
        }
    }

    /**
     * Enqueue the scripts and styles styles for the pick ad template.
     */
    public function enqueueScripts()
    {
        wp_enqueue_style('bam-pick-ads-styles', BAM_ADS_SYSTEM_URL . '/css/pick-ad.css', [], BAM_ADS_SYSTEM_VERSION);
        wp_enqueue_script('bam-pick-ads-script', BAM_ADS_SYSTEM_URL . '/js/pick-ad.js', ['jquery'], BAM_ADS_SYSTEM_VERSION);
    }
}