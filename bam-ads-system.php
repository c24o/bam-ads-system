<?php
/**
 * Plugin Name:     BAM Ads System
 * Description:     Ads system for BAM
 * Author:          Carlos Guzman <caralbgm@gmail.com>
 * Text Domain:     bam-ads-system
 * Domain Path:     /languages
 * Version:         0.1.0
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 */
define('BAM_ADS_SYSTEM_VERSION', '0.1.0');

/**
 * Plugin path location and URL.
 */
define('BAM_ADS_SYSTEM_PATH', \dirname(__FILE__));
define('BAM_ADS_SYSTEM_URL', plugins_url('', __FILE__));

/**
 * Autoload
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Begins execution of the plugin.
 */
function run_bam_ads_system()
{
    $plugin = new BamAdsSystem\AdsSystem();
}
run_bam_ads_system();
