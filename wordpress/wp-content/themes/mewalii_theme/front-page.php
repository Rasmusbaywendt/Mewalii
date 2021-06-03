<?php
/**
 * Template Name: Page Builder Full Width (Neve)
 *
 * The template for the page builder full-width.
 *
 * It contains header, footer and 100% content width.
 *
 * @package Neve
 */

get_header();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', 'pagebuilder' );
	}
}

?>

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("Aug 15, 2021 15:00:00").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.querySelector(".elementor-110 .elementor-element.elementor-element-2213600 .elementor-heading-title").classList.add("countdown");

            // Output the result in an element with id="countdown"
            document.querySelector(".elementor-110 .elementor-element.elementor-element-2213600 .elementor-heading-title").innerHTML = days + ": " + hours + ": " +
                minutes + ": " + seconds + " ";

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                document.querySelector(".elementor-110 .elementor-element.elementor-element-2213600 .elementor-heading-title").innerHTML = "Find produkterne i vores shop!";
            }
        }, 1000);

    </script>

    <?php
get_footer();
