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
        document.querySelector(".elementor-110 .elementor-element.elementor-element-2213600 .elementor-heading-title").textContent = "Mikkel";

    </script>

    <?php
get_footer();
