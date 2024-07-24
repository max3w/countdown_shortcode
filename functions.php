function countdown_shortcode($atts) {
    $atts = shortcode_atts(array(
        'year' => '2024',
        'month' => '12',
        'day' => '25',
        'hour' => '5',
        'minute' => '12',
        'second' => '0'
    ), $atts, 'countdown');

    $target_date = "{$atts['year']}-{$atts['month']}-{$atts['day']} {$atts['hour']}:{$atts['minute']}:{$atts['second']}";
    $target_timestamp = strtotime($target_date);

    ob_start();
    ?>
    <div id="countdown-timer" data-timestamp="<?php echo esc_attr($target_timestamp); ?>">
        <div class="countdown-item">
            <span class="countdown-value countdown-years">00</span>
            <span class="countdown-label">років</span>
        </div>
        <div class="countdown-item">
            <span class="countdown-value countdown-months">00</span>
            <span class="countdown-label">місяців</span>
        </div>
        <div class="countdown-item">
            <span class="countdown-value countdown-days">00</span>
            <span class="countdown-label">днів</span>
        </div>
        <div class="countdown-item">
            <span class="countdown-value countdown-hours">00</span>
            <span class="countdown-label">годин</span>
        </div>
        <div class="countdown-item">
            <span class="countdown-value countdown-minutes">00</span>
            <span class="countdown-label">хвилин</span>
        </div>
        <div class="countdown-item">
            <span class="countdown-value countdown-seconds">00</span>
            <span class="countdown-label">секунд</span>
        </div>
    </div>

    <style>
        #countdown-timer {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .countdown-item {
            text-align: center;
            flex: 1 1 calc(33.33% - 40px);
        }

        .countdown-value {
            display: block;
            font-size: 2em;
        }

        .countdown-label {
            display: block;
            font-size: 1em;
        }

        @media (max-width: 600px) {
            #countdown-timer {
                flex-wrap: wrap;
            }
            .countdown-item {
                flex: 1 1 calc(50% - 20px);
            }
        }
    </style>

    <script>
        jQuery(document).ready(function($) {
            function updateCountdown() {
                var timerElement = $('#countdown-timer');
                var targetTimestamp = parseInt(timerElement.data('timestamp'));
                var currentTime = Math.floor(Date.now() / 1000);

                var remainingTime = targetTimestamp - currentTime;

                if (remainingTime <= 0) {
                    clearInterval(countdownInterval);
                    timerElement.text('Час вийшов!');
                    return;
                }

                var years = Math.floor(remainingTime / (365 * 24 * 60 * 60));
                remainingTime %= 365 * 24 * 60 * 60;

                var months = Math.floor(remainingTime / (30 * 24 * 60 * 60));
                remainingTime %= 30 * 24 * 60 * 60;

                var days = Math.floor(remainingTime / (24 * 60 * 60));
                remainingTime %= 24 * 60 * 60;

                var hours = Math.floor(remainingTime / (60 * 60));
                remainingTime %= 60 * 60;

                var minutes = Math.floor(remainingTime / 60);
                var seconds = remainingTime % 60;

                timerElement.find('.countdown-years').text(years.toString().padStart(2, '0'));
                timerElement.find('.countdown-months').text(months.toString().padStart(2, '0'));
                timerElement.find('.countdown-days').text(days.toString().padStart(2, '0'));
                timerElement.find('.countdown-hours').text(hours.toString().padStart(2, '0'));
                timerElement.find('.countdown-minutes').text(minutes.toString().padStart(2, '0'));
                timerElement.find('.countdown-seconds').text(seconds.toString().padStart(2, '0'));
            }

            var countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown();
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('countdown', 'countdown_shortcode');
