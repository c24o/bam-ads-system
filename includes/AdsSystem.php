<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 */
namespace BamAdsSystem;

class AdsSystem
{
    /**
     * Init the plugin.
     */
    public function __construct()
    {
        $this->defineAdminHooks();
        $this->definePublicHooks();

        // register the pick ads
        (new PickAd)->init();
    }

    /**
     * Register all of the hooks related to the admin area functionality of the plugin.
     */
    private function defineAdminHooks()
    {
        $ads_admin = new AdsAdmin;
        add_action('admin_enqueue_scripts', [$ads_admin, 'enqueueScripts']);
        add_filter('manage_' . AdsAdmin::POST_TYPE_SLUG . '_posts_columns', [$ads_admin, 'listAdsColumnHead']);
        add_action('manage_' . AdsAdmin::POST_TYPE_SLUG . '_posts_custom_column' , [$ads_admin, 'addContetAdsColumns'], 10, 2 );

        // register the post type for the ads
        add_action('init', [$ads_admin, 'registerAdsPostType']);

        // save the content of the ads
        add_action('save_post_' . AdsAdmin::POST_TYPE_SLUG, [$ads_admin, 'saveAdPost'], 10, 3);
    }

    /**
     * Register all of the hooks related to the public-facing functionality of the plugin.
     */
    private function definePublicHooks()
    {
        // register the WP shortcode
        $ads_shortcode = new AdsShortcode();
        add_shortcode('bam-ad', [$ads_shortcode, 'process_shortcode']);
        
        // change background color of ads based on post categories
        $bg_color_setter = new ColorizePostsAdsBackground;
        add_filter('bam_ad_shortcode_data', [$bg_color_setter, 'changeBackgroundColor'], 10, 2);
    }
}
