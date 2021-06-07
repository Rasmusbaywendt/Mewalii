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

        <section class="shop_top">
            <h1>Sådan fungerer det</h1>
            <div class="vejledning">
                <div class="udvaelgelse">
                    <img class="vejledning_img" src="<?php echo get_stylesheet_directory_uri()?>/1_saadan_gor_du.svg" alt="illustration af bind og tamponer">
                    <p>UDVÆLG</p>
                </div>
                <div class="bestil_og_faa">
                    <img class="vejledning_img" src="<?php echo get_stylesheet_directory_uri()?>/2_saadan_gor_du.svg" alt="illustration af en pakke">
                    <p>BESTIL</p>
                </div>
                <div class="tak_dig_selv">
                    <img class="vejledning_img" src="<?php echo get_stylesheet_directory_uri()?>/3_saadan_gor_du.svg" alt="illustration af en hånd og en plante">
                    <p>BIDRAG</p>
                </div>
            </div>
        </section>
        <section class="shop_filtrering">
            <nav id="filtrering_knap">
                <button class="filter valgt" data-categories="alle">Se alle</button>
            </nav>
        </section>


        <section class="shop_indhold"></section>

        <template>
            <div>
                <div class="image_box">
                    <div class="box_soon">
                        <p class="soon">Kommer snart</p>
                    </div>
                    <img src="" alt="" width="901" height="901">
                </div>
                <div class="temp_bund">
                    <b class="navn"></b>
                    <p class="pris"></p>
                </div>
            </div>
        </template>


    </main>

    <?php get_footer(); ?>

        <script>
            //Lav variabel
            let produkter;
            //Variable, der indeholder json kategorien
            let categories;

            //Variable til filter
            let filter = "alle";


            //opretter konstanter til json data for produkterne
            const url = "http://emmasvane.dk/mewalii/mewalli/wp-json/wp/v2/produkt?per_page=10";
            //opretter konstanter til json data for kategorierne
            const dbCat = "http://emmasvane.dk/mewalii/mewalli/wp-json/wp/v2/categories?per_page=12";

            //lyt om siden loader
            document.addEventListener("DOMContentLoaded", start);

            function start() {
                console.log("start");
                getJson();
            }

            //henter WP rest API
            async function getJson() {
                //opretter konstant som fetcher json
                const response = await fetch(url);
                const catdata = await fetch(dbCat);

                //Variablerne sættes lig med json indholdet
                categories = await catdata.json();
                produkter = await response.json();

                console.log("categories ", categories);

                //kald visProdukter()
                visProdukter();

                //kald opretKnapper()
                opretKnapper();

            }


            //opretter knapper
            function opretKnapper() {

                let kategorierVis = [31, 32, 33, 34, 35, 37];


                categories.forEach(cat => {
                    if (kategorierVis.includes(cat.id)) {
                        console.log(document.querySelector("#filtrering_knap"));
                        document.querySelector("#filtrering_knap").innerHTML += `<button class="filter" data-categories="${cat.id}">${cat.name}</button>`;
                    };
                })
                addEventListernesToButtons();

            }


            //lytter til alle knapper om der bliver klikket
            function addEventListernesToButtons() {
                document.querySelectorAll("#filtrering_knap button").forEach(elm => {
                    elm.addEventListener("click", filtrering);
                })
            }

            function filtrering() {
                //sætter filter variabel til at være lig med værdien af data-kategori atribut som den vakgte knap indeholder
                filter = this.dataset.categories;
                console.log(filter);

                //fjerner valgt fra alle andre knapper som ikke er trykket
                document.querySelectorAll("#filtrering_knap button").forEach(elm =>
                    elm.classList.remove("valgt"));

                //tilføjer valgt class til den klikkede knap
                this.classList.add("valgt");

                visProdukter();

            }

            function visProdukter() {
                console.log(produkter);

                //definere templatet som en variable
                let temp = document.querySelector("template");
                //opretter et konstant som en container, hvor templatet kan klones til.
                const container = document.querySelector(".shop_indhold");

                container.innerHTML = "";


                //looper arrayet igennem enkeltvis for hver af nedenstående kloning.
                produkter.forEach(produkt => {
                    console.log("produkt: ", produkt);

                    if (filter == "alle" || produkt.categories.includes(parseInt(filter))) {
                        let klon = temp.cloneNode(true).content;
                        klon.querySelector("img").src = produkt.billede_2.guid;
                        klon.querySelector("img").width = "901";
                        klon.querySelector("img").height = "901";
                        klon.querySelector(".navn").textContent = produkt.produktnavn;
                        klon.querySelector(".pris").textContent = produkt.pris + " kr";

                        //ved mus henover billede skal den vise billede_2
                        klon.querySelector("img").onmouseout = function() {
                            this.src = produkt.billede_2.guid;
                        };

                        //ved mus væk fra billedet skal den vise billede_1 igen
                        klon.querySelector("img").onmouseover = function() {
                            this.src = produkt.billede_1.guid;
                        };

                        klon.querySelector("img").addEventListener("click", () => {
                            location.href = produkt.link;
                        })

                        container.appendChild(klon);
                    }
                })
            }

        </script>
