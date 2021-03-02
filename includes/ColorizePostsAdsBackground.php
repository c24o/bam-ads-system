<?php
/**
 * Change the background color of the ads in posts based on the categories of the posts.
 */
namespace BamAdsSystem;

class ColorizePostsAdsBackground
{
    /**
     * @see filter hook bam_ad_shortcode_data
     */
    public function changeBackgroundColor($data, $ad)
    {
        // get the categories of the current post
        $categories = wp_get_post_categories(get_the_ID(), [
            'fields' => 'all'
        ]);

        // check the categories for the target categories to change the colors
        $targets = [
            'nfl' => 'black',
            'nba' => 'orange',
            'mlb' => 'blue'
        ];
        foreach ($categories as $cat) {
            if (isset($targets[$cat->slug])) {
                $data['bg-color'] = $targets[$cat->slug];
                break;
            }
        }

        return $data;
    }
}