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

<main class="main_shop">
	<h1 class="shop_title">Prokukterne er snart på markedet</h1>
	<section class="shop_top">
		<h2>Sådan fungerer det</h2>
		<div class="vejledning">
			<div class="udvaelgelse">
				<img src="<?php echo get_stylesheet_directory_uri()?>/1_saadan_gor_du.svg" alt="illustration af bind og tamponer">
				<p>Udvælg dine favoritter</p>
			</div>
			<div class="bestil_og_faa">
				<img src="<?php echo get_stylesheet_directory_uri()?>/2_saadan_gor_du.svg" alt="illustration af en pakke">
				<p>Bestil og få produkterne sendte direkte hjem til dig</p>
			</div>
			<div class="tak_dig_selv">
				<img src="<?php echo get_stylesheet_directory_uri()?>/3_saadan_gor_du.svg" alt="illustration af en hånd og en plante">
				<p>Tak dig selv for at bidrage til en mere bæredygtig hverdag</p>
			</div>
		</div>
	</section>
	<section class="shop_filtrering">
		<nav id="filtrering_knap"></nav>
	</section>

	<section class="shop_indhold">
		<h2 class="shop_alle">Alle produkter</h2>
	</section>

	<template>

		<div>
			<img src="" alt="">
			<div class="temp_bund">
				<b class="navn"></b>
				<p class="pris"></p>
			</div>
		</div>
	</template>


</main>

<?php get_footer(); ?>

<script>
	//Lav variable
	let produkter = [];
	//Variable, der indeholder json kategorien
	let categories;
	//Variable til filter
	let filter;

	//lyt om siden loader
	document.addEventListener("DOMContentLoaded", start);


	function start() {
		console.log("start");
		getJson();
	}

	//opretter konstanter til json data for produkterne
	const url = "http://emmasvane.dk/mewalii/mewalli/wp-json/wp/v2/produkt?per_page=100";
	//opretter konstanter til json data for kategorierne
	const dbCat = "http://emmasvane.dk/mewalii/mewalli/wp-json/wp/v2/categories";


	//henter WP rest API
	async function getJson() {
		//opretter konstant som fetcher json
		const response = await fetch(url);
		const catdata = await fetch(dbCat);

		//Variablerne sættes lig med json indholdet
		categories = await catdata.json();
		produkter = await response.json();

		//kald visProdukter()
		visProdukter();

		//kald opretKnapper()
		opretKnapper();

	}

	function visProdukter() {
		console.log(produkter);

		//definere templatet som en variable
		let temp = document.querySelector("template");

		//opretter et konstant som en container, hvor templatet kan klones til.
		const container = document.querySelector(".shop_indhold");
		//looper arrayet igennem enkeltvis for hver af nedenstående kloning.
		produkter.forEach(produkt => {
			console.log(produkt);
			let klon = temp.cloneNode(true).content;
			klon.querySelector("img").src = produkt.billede_1.guid
			klon.querySelector(".navn").textContent = produkt.produktnavn;
			klon.querySelector(".pris").textContent = produkt.pris + " kr";



			klon.querySelector("img").addEventListener("click", () => {
				location.href = produkt.link;
			})

			container.appendChild(klon);
		})
	}




	//opretter knapper
	function opretKnapper() {

		//opretter en knap for hver kategori, og tilføjer kategori navnet på knappen
		categories.forEach(cat => {
			document.querySelector("#filtrering_knap").innerHTML += `<button class="filter" data-kategori="${cat.id}">${cat.name}</button>`;
		})

		addEventListernesToButtons();

	}

	function addEventListenersToButtons() {
		//lytter til alle knapper om der bliver klikket
		document.querySelectorAll("#filtrering_knap button").forEach(elm => {
			elm.addEventListener("click", filtrering);
		})
	}

	function filtrering() {

		//sætter filter variabel til at være lig med værdien af data-kategori atribut som den vakgte knap indeholder
		filter = this.dataset.kategori;
		console.log(filter);

		//fjerner valgt fra alle andre knapper som ikke er trykket
		document.querySelectorAll("#filtrering button").forEach(elm =>
			elm.classList.remove("valgt"));

		//tilføjer valgt class til den klikke knap
		this.classList.add("valgt");


		//kalder visQuestions()
		visQuestions();

	}

</script>
