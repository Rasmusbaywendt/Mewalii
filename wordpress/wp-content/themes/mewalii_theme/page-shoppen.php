<?php
/**
 * The template for displaying all pages.
 *
 * @package Neve
 * @since   1.0.0
 */
$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-page' );

get_header();

?>
<main>
	<h1>SHOPPEN</h1>
	<section class="shop_top">
		<h2>Sådan fungerer det</h2>
		<div class="vejledning">
			<div class="udvaelgelse">
				<img src="" alt="">
				<p>Udvælg dine favoritter</p>
			</div>
			<div class="bestil_og_faa">
				<img src="" alt="">
				<p>Bestil og få produkterne sendte direkte hjem til dig</p>
			</div>
			<div class="tak_dig_selv">
				<img src="" alt="">
				<p>Tak dig selv for at bidrage til en mere bæredygtig hverdag</p>
			</div>
		</div>
	</section>
	<section class="shop_filtreing_knapper">

	</section>

	<article class="shop_indhold">

		<template>
			<img src="" alt="">
			<p class="navn"></p>
			<p class="pris"></p>
		</template>

	</article>
</main>
<?php
<?php get_footer(); ?>

<script>
	//Lav variable//
	let produkter = [];
	let categories;
	//lyt om siden loader//
	document.addEventListener("DOMContentLoaded", start);


	function start() {
		getJson();
	}

	//find data fra produkterne via json her vises max 100//
	const url = "http://emmasvane.dk/mewalii/mewalli/wp-json/wp/v2/produkt?per_page=100";

	//henter data igennem ovenstående//
	async function getJson() {
		let response = await fetch(url);

		produkter = await response.json();

		visProdukter();

	}

	function visProdukter() {
		console.log(produkter);
		let temp = document.querySelector("template");
		produkter.forEach(produkt => {
			console.log(produkt);
			let klon = temp.cloneNode(true).content;
			klon.querySelector("img").src = produkt.billede_1.guid
			klon.querySelector(".navn").textContent = produkt.produktnavn;
			klon.querySelector(".pris").textContent = produkt.pris;



			klon.querySelector("article").addEventListener("click", () => {
				location.href = produkt.link;
			})

			article.appendChild(klon);
		})
	}

</script>
