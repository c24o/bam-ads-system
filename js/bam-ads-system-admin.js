/**
 * Show and hide fields for the different types of ads.
 */
(function($) {
    $(document).ready(function() {
        // get the attributes containers
        let attributes_containers = $('.bam-ads-attributes');

        // add listener to the type selector of the ad
        let type_selector = $('#bam-ad-type').change(function() {
            selectType($(this).val());
            return true;
        });

        // show and hide the attributes containers
        function selectType(type) {
            attributes_containers.hide();
            $("#bam-atts-" + type).show();
        }

        // init
        selectType(type_selector.val());
    });
})(jQuery);