<?php
/**
 * Class to represent an ad in the system.
 */
namespace BamAdsSystem;

class Ad
{
    /**
     * post used to store the ad in the database.
     */
    protected $post = null;

    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Get the ID of the saved ad.
     * 
     * @return int ID.
     */
    public function getId()
    {
        return $this->post->ID ?? 0;
    }

    /**
     * Get the title of the ad.
     * 
     * @return string
     */
    public function getTitle()
    {
        return get_the_title($this->post);
    }

    /**
     * Get the type of the ad.
     * 
     * @return string
     */
    public function getType()
    {
        return $this->getProperty('type');
    }

    /**
     * Get the template linked to the ad.
     * 
     * @return string the name of the template.
     */
    public function getTemplate()
    {
        return $this->getProperty('template');
    }

    /**
     * Get the background color for the ad.
     * 
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->getProperty('bg-color');
    }

    /**
     * Get a property of the ad.
     * 
     * @param string $property name of the property.
     * 
     * @return mixed false if the property is not found.
     */
    public function getProperty($property)
    {
        // check if the ad is valid and then get the property
        return $this->getId()
            ? get_post_meta($this->getId(), $property, true)
            : false;
    }

    /**
     * Save a property of the ad.
     * 
     * @param string $property name of the property.
     * @param mixed $value value to save.
     * 
     * @return bool true on success, otherwise false.
     */
    public function saveProperty($property, $value)
    {
        // check if the ad is valid and then save
        return $this->getId()
            ? update_post_meta($this->getId(), $property, $value)
            : false;
    }

    /**
     * Save the data/properties of an ad.
     * 
     * @param array $data dictionary of proerties and values.
     */
    public function saveData($data)
    {
        // check if the ad is valid
        if (! $this->getId()) {
            return;
        }

        $valid_fields = ['type', 'bg-color', 'template'];
        foreach ($valid_fields as $field) {
            // if the field is not present
            if (empty($data[$field])) {
                // delete the field in the database
                delete_post_meta($this->getId(), $field);
            }
            // save the field
            else {
                update_post_meta($this->getId(), $field, $data[$field]);
            }
        }

        // call hooks to extend saving of ads
        do_action("bam_save_{$data['type']}_ad", $this, $data);
        do_action("bam_save_ad", $this, $data);
    }

    /**
     * Get the types of ads registered.
     * 
     * @return array dictionary of types registered, the key is the slug of the type and the value is the label.
     */
    static public function getTypes()
    {
        return apply_filters('bam_get_ads_types', [
            'basic' => __('Basic', 'bam-ads-system')
        ]);
    }

    /**
     * Get the templates registered to render the ads.
     * 
     * @return array dictionary of templates, the key is the name of the template and the value the path to the template.
     */
    static public function getTemplates()
    {
        return apply_filters('bam_get_ads_templates', [
            'Default' => BAM_ADS_SYSTEM_PATH . '/views/default-ads-template.php'
        ]);
    }
}