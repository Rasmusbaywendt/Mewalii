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
            <div>
                <button>tilbage</button>
                <h1></h1>
            </div>
            <div>
                <div>
                    <div>
                        <img id="main_pic" src="" alt="">
                    </div>
                    <div>
                        <img id="main_pic2" src="" alt="">
                        <img id="second_pic" src="" alt="">
                        <img id="third_pic" src="" alt="">
                    </div>
                </div>
                <div>
                    <p id="beskrivelse"></p>
                    <p id="pris"></p>
                    <button>Læg i kurven</button>
                </div>
            </div>
        </section>

        <section id="bottom_section"></section>

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
            document.querySelector("#main_pic2").alt = produkt.title.rendered;
            document.querySelector("#main_pic2").title = produkt.title.rendered;

            document.querySelector("#second_pic").src = produkt.billede_2;
            document.querySelector("#second_pic").alt = produkt.title.rendered;
            document.querySelector("#second_pic").title = produkt.title.rendered;

            document.querySelector("#third_pic").src = produkt.billede_3;
            document.querySelector("#third_pic").alt = produkt.title.rendered;
            document.querySelector("#third_pic").title = produkt.title.rendered;

            document.querySelector("#beskrivelse").textContent = produkt.beskrivelse;
            document.querySelector("#pris").innerHTML = produkt.pris;



        }

    </script>
    <?php
get_footer();
