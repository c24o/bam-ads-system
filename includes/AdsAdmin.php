<?php
/**
 * Controller for the administration of ads.
 *
 * This class register the CPT for the adds and contains the functions linked to the admin hooks related to the saving and listing of ads in the admin side.
 */
namespace BamAdsSystem;

class AdsAdmin
{
    public const POST_TYPE_SLUG = 'bam-ad';

    /**
     * Register the JavaScript for the admin area.
     */
    public function enqueueScripts()
    {
        wp_enqueue_script('bam-ads-system-admin', BAM_ADS_SYSTEM_URL . '/js/bam-ads-system-admin.js', ['jquery'], BAM_ADS_SYSTEM_VERSION, false);
    }

    /**
     * Register the custom post type to store the ads.
     */
    public function registerAdsPostType()
    {
        $post_type = self::POST_TYPE_SLUG;
        register_post_type($post_type, [
            'label' => __('Ads', 'bam-ads-system'),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports' => ['title', 'author'],
            'register_meta_box_cb' => function($post) {
                add_meta_box('bam-ads-meta-box', __('Ads Attributes', 'bam-ads-system'), [$this, 'createMetaBoxCustomFields'], $post_type);
            }
        ]);
    }

    /**
     * Get an ad by its ID.
     * 
     * @param integer $id
     * 
     * @return mixed an Ad object or false if the ID is not found.
     */
    public static function getAd($id)
    {
        // get the post
        $post = get_post($id);

        // check that it is an Ad post
        if ($post && $post->post_type == self::POST_TYPE_SLUG && 'publish' == $post->post_status) {
            return new Ad($post);
        }

        return false;
    }

    /**
     * Create the custom fields in the edition page of the ads.
     */
    public function createMetaBoxCustomFields($post)
    {
        // get the list of available types and templates
        $types = Ad::getTypes();
        $templates = Ad::getTemplates();

        // get fields for the view
        $ad = new Ad($post);

        // render the view
        require BAM_ADS_SYSTEM_PATH . "/views/ads-attributes-metabox.php";
    }

    /**
     * Fired after saving the ad post.
     * 
     * @see action hook save_post_{post_type}
     */
    public function saveAdPost($post_id, $post, $update)
    {
        // Skip post revisions
        if (wp_is_post_revision($post_id)) {
            return;
        }

        // create the ad object
        $ad = new Ad($post);

        // save the data of the ad
        $ad->saveData($_POST['ad-atts']);
    }

    /**
     * Add the column headers for type and shortcode in the list of ads.
     * 
     * @see filter hook manage_{post_type}_posts_columns
     */
    public function listAdsColumnHead($defaults) {
        return array_merge([
            'cb' => '',
            'title' => '',
            'shortcode' => __('Shortcode', 'bam-ads-system')
        ], $defaults);
    }


    /**
     * Add the content to the columns of type and shortcode in the list of ads.
     * 
     * @see filter manage_{post_type}_posts_custom_column
     */
    public function addContetAdsColumns($column, $post_id) {
        switch($column) {
            case 'shortcode':
                printf('[bam-ad id="%d"]', $post_id);
                break;
        }
    }
}
