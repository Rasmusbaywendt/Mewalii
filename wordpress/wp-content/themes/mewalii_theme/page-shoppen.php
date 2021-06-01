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
        <section class="shop_filtreing_knapper">

        </section>

        <section class="shop_indhold">
        </section>

        <template>

            <div>
                <img src="" alt="">
                <div>
                    <p class="navn"></p>
                    <p class="pris"></p>
                </div>
            </div>
        </template>


    </main>

    <?php get_footer(); ?>

        <script>
            //Lav variable
            let produkter = [];
            //	let categories;
            //lyt om siden loader
            document.addEventListener("DOMContentLoaded", start);


            function start() {
                console.log("start");
                getJson();
            }

            //find data fra produkterne via json her vises max 100
            const url = "http://emmasvane.dk/mewalii/mewalli/wp-json/wp/v2/produkt?per_page=100";

            //henter data igennem ovenstående
            async function getJson() {
                let response = await fetch(url);

                produkter = await response.json();

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
            // function opretKnapper() {
            //
            // //opretter en knap for hver kategori, og tilføjer kategori navnet på knappen
            // kategorier.forEach(cat => {
            // document.querySelector("#filtrering").innerHTML += `<button class="filter" data-kategori="${cat.id}">${cat.name}</button>`;
            // })
            //
            // //hvis data-kategori har id 26 skal den tilføje .valgt
            // if (`data-kategori=26`) {
            // document.querySelector(".filter").classList.add("valgt");
            // }
            //
            // //kald addEventListenersToButtons()
            // addEventListenersToButtons();
            // }
            //
            //
            // function addEventListenersToButtons() {
            // //lytter til alle knapper om der bliver klikket
            // document.querySelectorAll("#filtrering button").forEach(elm => {
            // elm.addEventListener("click", filtrering);
            // })
            // }

        </script>
