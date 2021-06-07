<?php
/**
 * The template for displaying all pages.
 *
 * @package Neve
 * @since   1.0.0
 */
$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-page' );


get_header();?>


    <main id="snak_main">


        <!------FØRSTE SEKTION------>
        <section id="snak_intro">
            <div id="snak_intro_tekst">
                <h1 id="snak_h1">Menstruationssnak</h1>
                <p>Hos Mewalii vil vi gerne være der når du har brug for det. Dette gælder både før, under og efter din menstruation. Derfor har vi skabt et univers hvor du kan læse hvad andre har af spørgsmål, samt få svar på dem du selv skulle have vedrørende menstruation. Vi glæder os til at besvare dine spørgsmål!</p>
            </div>
            <div>
                <img id="snak_img" src="<?php echo get_stylesheet_directory_uri()?>/img/menstruationssnak.svg" alt="talebobler">
            </div>
        </section>

        <!------ANDEN SEKTION------>
        <section id="ugens_sporgsmaal">
            <div id="sporgsmaal_container">
                <div>
                    <img id="pin_img" src="<?php echo get_stylesheet_directory_uri()?>/img/pin.png" alt="pin">
                </div>
                <div>
                    <h2 class="snak_h2">Ugens spørgsmål</h2>
                </div>
            </div>
            <div id="ugens_liste">
                <div id="question_container">
                    <p id="uge_question"></p>
                </div>
                <div class="sygeplejerske_container">
                    <img id="sygeplejerske" src="<?php echo get_stylesheet_directory_uri()?>/img/Sygeplejerske.png" alt="sygeplejerske">
                    <div id="svar_container">
                        <p id="uge_svar"></p>
                    </div>
                </div>
            </div>
        </section>

        <!------TREDJE SEKTION------>
        <section id="sporgsmaal">
            <h2 class="snak_h2">Kategorier</h2>
            <nav id="filtrering"></nav>
            <div id="liste"></div>
            <div id="liste_fortsat"></div>
            <button id="mere">Læs flere</button>
        </section>

        <!------FJERDE SEKTION------>
        <section id="formular">
            <h2 class="snak_h2">Har du et spørgsmål</h2>
            <p id="formular_tekst">Vi vil meget gerne høre fra dig, hvis du har et spørgsmål eller noget du er nysgerrig på</p>
            <div id="formular_container">
                <div>
                    <form id="form" action="">
                        <div id="form_wrapper">
                            <div class="form_container">
                                <label class="label" for="fname">Fornavn:</label>
                                <input class="input" type="text" placeholder="Hvad er dit navn?">
                            </div>
                            <div class="form_container">
                                <label class="label" for="number">Telefonnummer:</label>
                                <input class="input" type="text" placeholder="Hvad er dit nummer?">
                            </div>
                            <div class="">
                                <input class="" type="radio" id="kontakt" value="ja">
                                <label class="label" for="kontakt">Jeg ønsker at modtage besked når der er svar</label>
                            </div>
                            <div class="form_container">
                                <label class="label" for="question">Spørgsmål:</label>
                                <textarea class="input" name="message" id="besked" cols="30" rows="10" placeholder="Hvad har du i tankerne?"></textarea>
                            </div>
                        </div>

                    </form>
                    <button id="send_knap">Send</button>

                    <div id="sendt_besked">
                        <p>Tak for din besked! Vi vil forsøge at besvare dit spørgsmål hurtigst muligt</p>
                    </div>

                </div>
                <div>
                    <img id="form_img" src="<?php echo get_stylesheet_directory_uri()?>/img/strand.jpg" alt="bind">
                </div>
            </div>
        </section>

        <template>
            <div class="question_wrapper">
                <div class="question_container">
                    <p id="question"></p>
                </div>
                <div class="sygeplejerske_container">
                    <img class="sygeplejerske" src="<?php echo get_stylesheet_directory_uri()?>/img/Sygeplejerske.png" alt="sygeplejerske">
                    <div class="svar_container">
                        <p id="svar"></p>
                    </div>
                </div>
            </div>
        </template>


    </main>


    <?php get_footer(); ?>

        <!------SCRIPT BEGYNDER----->
        <script>
            //opretter global variabel der indeholder json
            let questions;
            //opretter global variabel der indeholder kateogri json
            let kategorier;
            //opretter global variabel til filter
            let filter = 26;

            //opretter konstanter til json data
            const dbUrl = "http://emmasvane.dk/mewalii/mewalli/wp-json/wp/v2/qa?per_page=100";
            const dbCat = "http://emmasvane.dk/mewalii/mewalli/wp-json/wp/v2/categories?per_page=20";

            //lytter til om DOM er loaded og kalder getJson
            document.addEventListener("DOMContentLoaded", getJson);

            document.querySelector("#liste_fortsat").classList.add("hide");

            //henter wp REST API ind
            async function getJson() {
                //opretter konstant som fetcher json
                const data = await fetch(dbUrl);
                const catdata = await fetch(dbCat);
                //sætter de oprettede variabler til at indeholde json
                questions = await data.json();
                kategorier = await catdata.json();

                console.log(questions);
                console.log(kategorier);

                //kald visQuestions()
                visQuestions();

                //kald opretKnapper()
                opretKnapper();

            }


            //opretter knapper
            function opretKnapper() {

                let kategorier_vis = [26, 27, 28, 29, 36, 37];

                //opretter en knap for hver kategori, og tilføjer kategori navnet på knappen
                kategorier.forEach(cat => {
                    if (kategorier_vis.includes(cat.id)) {
                        document.querySelector("#filtrering").innerHTML += `<button class="filter" data-kategori="${cat.id}">${cat.name}</button>`;
                    };

                    if (cat.id == 26) {
                        document.querySelector(".filter").classList.add("valgt");
                    };
                })

                //tilføjer .valgt til knap med id 26


                //kald addEventListenersToButtons()
                addEventListenersToButtons();
            }


            function addEventListenersToButtons() {
                //lytter til alle knapper om der bliver klikket
                document.querySelectorAll("#filtrering button").forEach(elm => {
                    elm.addEventListener("click", filtrering);
                })
            }

            function filtrering() {

                //sætter filter variabel til at være lig med værdien af data-kategori atribut som den trykkede knap indeholder
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



            //funktion der viser spørgsmålene i liste funktion
            function visQuestions() {
                console.log("visQuestions");

                //opretter variabel til template
                const skabelon = document.querySelector("template");
                //opretter variabel til #liste
                const liste = document.querySelector("#liste");
                const listeFortsat = document.querySelector("#liste_fortsat");

                //rydder liste hver gang der klikkes på ny kategori
                liste.innerHTML = "";
                listeFortsat.innerHTML = "";

                //opretter variabel som er lig med 0
                let tæller = 0;

                //loop igennem json (questions) og sæt ind i template
                questions.forEach((question) => {

                    //hvis 'question' property (som er et array)indeholder den kategori jeg har klikket på, så skal den vises
                    //--'includes' er en indbygget js funktion som knytter sig til et array
                    //--'parseint' betyder at man laver 'filter' (som er tekst) om til et tal
                    if (question.categories.includes(parseInt(filter))) {
                        const klon = skabelon.cloneNode(true).content;
                        //indsætter spørgsmål json ind i #question
                        klon.querySelector("#question").textContent = question.question;
                        //indsætter ssvar json ind i #uge_svar
                        klon.querySelector("#svar").innerHTML = question.svar + `<br> -Hanne, sygeplejerske`;

                        if (tæller <= 3) {
                            console.log("liste");
                            //tillægger klonen til listen
                            liste.appendChild(klon);
                        } else {
                            //tillægger klonen til listen
                            listeFortsat.appendChild(klon);
                        }

                        //lægger én til tæller variabel
                        tæller++;

                    }
                    //hvis spørgsmålet har kategorien med id 30 skal en vises
                    if (question.categories.includes(30)) {
                        //indsætter spørgsmål json ind i #question
                        document.querySelector("#uge_question").textContent = question.question;
                        //indsætter ssvar json ind i #uge_svar
                        document.querySelector("#uge_svar").innerHTML = question.svar + `<br> -Hanne, sygeplejerske`;
                    }
                })

                //lytter til klik på send knappen
                document.querySelector("#send_knap").addEventListener("click", sendBesked);

                //lytter til klik på 'læs mere'-knap
                document.querySelector("#mere").addEventListener("click", læsFlere);

            }

            function læsFlere() {
                console.log("læsFlere");

                //ændrer tekst på knap til "læs mindre"
                document.querySelector("#mere").textContent = "Læs mindre";
                //fjerner eventlistener
                document.querySelector("#mere").removeEventListener("click", læsFlere);
                //fjerner hide class fra #liste_fortsat
                document.querySelector("#liste_fortsat").classList.remove("hide");
                //lytter til klik på mere knap og kalder læsMindre funktion
                document.querySelector("#mere").addEventListener("click", læsMindre);
            }

            function læsMindre() {
                //ændrer tekst på knap til "læs mere"
                document.querySelector("#mere").textContent = "Læs mere";
                //tilføjer hide class til #liste_fortsat
                document.querySelector("#liste_fortsat").classList.add("hide");
                //lytter til klik på mere knap og kalder læsFlere funktion
                document.querySelector("#mere").addEventListener("click", læsFlere);

            }



            function sendBesked() {
                console.log("besked sendt");
                document.querySelector("#sendt_besked").style.display = "inline";

                forsvindBesked();

            }

            function forsvindBesked() {
                console.log("forsvind");

                document.querySelector("#sendt_besked").classList.add("forsvind");
            }

        </script>
