/**
 * jQuery plugin to control the count down in the pick ads.
 */
(function($){
    $.fn.bamPickAd = function(options) {
        return this.each(function(){
            let ad = $(this);

            // sanitize input
            let settings = $.extend({
                stop: (new Date).getTime()
            }, options);

            // get the countdown HTML element
            let countdown = ad.find('.countdown-container .timer');

            // get the stop date
            let stop_time = settings.stop;

            // update the countdown
            let timer_id = setInterval(function() {
                // get the current time
                let current_time = (new Date).getTime();

                // stop timer if stop time is reached
                if (current_time >= stop_time) {
                    updateCountdown(0);
                    clearInterval(timer_id);
                }
                else {
                    // update the countdown
                    updateCountdown(stop_time - current_time);
                }
            },1000);

            /**
             * Update the HTML of the countdown
             */
            function updateCountdown(diff) {
                // get the diff
                let SEC = 1000;
                let MIN = 60 * SEC;
                let HOUR = 60 * MIN;
                let DAY = 24 * HOUR;
                let days_diff = diff / DAY;
                diff = diff % DAY;
                let hours_diff = diff / HOUR;
                diff = diff % HOUR;
                let mins_diff = diff / MIN;
                diff = diff % MIN;
                let secs_diff = diff / SEC;

                // update the HTML
                countdown.find('.days .num').text(formatCountdownNumber(days_diff));
                countdown.find('.hours .num').text(formatCountdownNumber(hours_diff));
                countdown.find('.min .num').text(formatCountdownNumber(mins_diff));
                countdown.find('.sec .num').text(formatCountdownNumber(secs_diff));
            }

            /**
             * Format the number as an integer with 2 digits
             */
            function formatCountdownNumber(num) {
                num = parseInt(num);
                return num < 10 ? ('0' + num) : num;
            }
        });
    }
})(jQuery);