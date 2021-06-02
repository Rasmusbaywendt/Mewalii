<?php
/**
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      28/08/2018
 *
 * @package Neve
 */

$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-post' );

get_header();

?>

    <main>
        <section id="top_section">
            <div id="overskrift_container">
                <button id="tilbage" class="button_single">tilbage</button>
                <h1 id="single_h1"></h1>
            </div>
            <div id="produkt_wrapper">
                <div id="billede_container">
                    <div>
                        <img id="main_pic" src="" alt="">
                    </div>
                    <div id="ekstra_container">
                        <img class="ekstra_billede" id="main_pic2" src="" alt="">
                        <img class="ekstra_billede" id="second_pic" src="" alt="">
                        <img class="ekstra_billede" id="third_pic" src="" alt="">
                    </div>
                </div>
                <div>
                    <p id="beskrivelse"></p>
                    <p id="pris"></p>
                    <button class="button_single">Læg i kurven</button>
                </div>
            </div>
        </section>

        <section id="bottom_section">
            <h2 id="single_h2">Forslåede produkter til dig</h2>
            <div>
                <img src="" alt="">
                <img src="" alt="">
                <img src="" alt="">
                <img src="" alt="">
            </div>
        </section>

    </main>





    <script>
        let produkt;

        let aktuelPodcast = <?php echo get_the_ID() ?>;

        //kun det relevante produkt bliver hentet ind
        const dbUrl = "http://emmasvane.dk/mewalii/mewalli/wp-json/wp/v2/produkt/" + aktuelPodcast;

        //lytter til om DOM er loaded
        document.addEventListener("DOMContentLoaded", getJson);

        async function getJson() {
            const data = await fetch(dbUrl);
            produkt = await data.json();
            console.log("produkt: ", produkt);

            visProdukt();

        }

        function visProdukt() {
            console.log("visProdukt");

            document.querySelector("h1").textContent = produkt.title.rendered;

            document.querySelector("#main_pic").src = produkt.billede_1.guid;
            document.querySelector("#main_pic").alt = produkt.title.rendered;
            document.querySelector("#main_pic").title = produkt.title.rendered;

            document.querySelector("#main_pic2").src = produkt.billede_1.guid;
            document.querySelector("#main_pic2").alt = produkt.title.rendered + "_2";
            document.querySelector("#main_pic2").title = produkt.title.rendered + "_2";

            document.querySelector("#second_pic").src = produkt.billede_2.guid;
            document.querySelector("#second_pic").alt = produkt.title.rendered + "_3";
            document.querySelector("#second_pic").title = produkt.title.rendered + "_3";

            document.querySelector("#third_pic").src = produkt.billede_3.guid;
            document.querySelector("#third_pic").alt = produkt.title.rendered + "_4";
            document.querySelector("#third_pic").title = produkt.title.rendered + "_4";

            document.querySelector("#beskrivelse").textContent = produkt.beskrivelse;
            document.querySelector("#pris").innerHTML = produkt.pris + " kr";

            document.querySelector("#tilbage").addEventListener("click", tilbageKnap);

        }

        //opretter konstant indeholdende de ekstra produkt billeder
        const ekstraBilleder = document.querySelectorAll(".ekstra_billede");
        //eventlistener der lytter til at der bliver klikket på de små billeder
        ekstraBilleder.forEach(knap => knap.addEventListener("click", skiftBillede));

        function skiftBillede() {
            console.log(this);
            //skifter det store billede ud med billedet, der er blevet klikket på
            document.querySelector("#main_pic").src = this.src;
        }

        function tilbageKnap() {
            history.back();
        }

    </script>
    <?php
get_footer();
