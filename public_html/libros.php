<!DOCTYPE html>
<html lang="es"><head>
    <meta charset="utf-8">
    <title>Libros - Partido del Trabajo - Quintana Roo</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;family=Teko:wght@300..700&amp;display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="lib/animate/animate.min.css">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/red-style.css" rel="stylesheet">
</head>
<body>


       <!-- Spinner Start -->
    <div id="spinner" class="bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->        
    
<?php
        include "tmplt/navbar.txt";
?>     
    
    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center bg-primary">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="btn bg-light border nput-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->
    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInDown;">Biblioteca Digital</h4>
            <h3 class="text-white wow fadeInDown" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInDown;">Libros y Publicaciones</h3>
        </div>
    </div>
    <!-- Header End -->


    <!-- Books Start -->
    <div class="container-fluid team py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px; visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <h3>Bienvenidas y bienvenidos a nuestra biblioteca digital</h3>
                <p class="mb-0">
                En esta sección encontrarás una colección de libros y publicaciones en formato PDF que reflejan nuestros principios, análisis y propuestas. Te invitamos a explorar, descargar y compartir estos materiales para fomentar el diálogo y el conocimiento.
                </p>
            </div>

            <!-- libro no 01 inicio -->
            <div class="goal-item d-flex p-4">
                <div class="d-flex me-4">
                    <div class="d-inline" style="width: 140px; height: 200px;">
                        <img src="imgs/libro01.png" class="img-fluid" alt="Portada del Libro 01" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                <div>
                    <h4>Métodos de Trabajo de los Comités del Partido</h4>
                    <p class="text-black mb-0">
                        Mao Tse-Tung ofrece doce directrices para un liderazgo efectivo. Compara al secretario del comité con un "jefe de escuadra", destacando la importancia de debatir los problemas abiertamente. <br>Entre los métodos clave se incluyen: el intercambio constante de información para unificar el lenguaje, consultar a los subordinados y "tocar el piano", es decir, gestionar múltiples tareas en torno a una principal. <br>Mao también subraya la necesidad de realizar análisis cuantitativos, ser conciso, trabajar en unidad con quienes tienen opiniones diferentes y evitar la arrogancia. El texto concluye que es crucial distinguir claramente entre revolución y contrarrevolución, así como entre aciertos y errores, para dirigir correctamente el trabajo del Partido.
                    </p>
                    <a href="pdfs/libros/metodos_de_trabajo.pdf"> <span>Descargar PDF</span></a>
                </div>  
            </div>                                 
            <!-- libro no 01 fin -->

            <!-- libro no 02 inicio -->
            <div class="goal-item d-flex p-4">
                <div class="d-flex me-4">
                    <div class="d-inline" style="width: 140px; height: 200px;">
                        <img src="imgs/libro04.png" class="img-fluid" alt="Portada del Libro 02" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                <div>
                    <h4>Algunas Cuestiones Sobre los Métodos de Dirección</h4>
                    <p class="text-black mb-0">Este documento de Mao Tse Tung, "Algunas cuestiones sobre los métodos de dirección", expone los principios fundamentales para un liderazgo comunista efectivo. Sostiene que los dirigentes deben combinar los llamamientos generales con la orientación particular, obteniendo experiencia directa en puntos específicos para luego aplicarla a un contexto más amplio. <br>Se enfatiza la necesidad de forjar una conexión inseparable entre el grupo dirigente y las masas, aplicando el método "de las masas, a las masas": recoger sus ideas, sistematizarlas y devolverlas como directrices para la acción. El texto critica duramente el subjetivismo y la burocracia, promoviendo en su lugar métodos científicos marxistas que aseguren una dirección centralizada pero profundamente arraigada en la realidad y las necesidades del pueblo, estableciendo prioridades claras para evitar la desorganización.</p>
                    <a href="pdfs/libros/algunas_cuestiones_sobre.pdf"> <span>Descargar PDF</span></a>
                </div>  
            </div>                                 
            <!-- libro no 02 fin -->

            <!-- libro no 03 inicio -->
            <div class="goal-item d-flex p-4">
                <div class="d-flex me-4">
                    <div class="d-inline" style="width: 140px; height: 200px;">
                        <img src="imgs/libro03.png" class="img-fluid" alt="Portada del Libro 03" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                <div>
                    <h4>Contra el Estilo de Cliché del Partido</h4>
                    <p class="text-black mb-0">En este texto, Mao Tse-Tung critica fuertemente el "estilo de cliché del Partido", al que considera una expresión de subjetivismo y sectarismo que aleja a las masas. Argumenta que los escritos largos, vacíos y presuntuosos son un obstáculo para la revolución. <br>En su lugar, Mao aboga por un estilo literario marxista-leninista que sea vivo, fresco y accesible para el pueblo. A través de "ocho cargos principales", denuncia la palabrería, la presunción y la falta de contenido, e insta a los miembros del partido a aprender del lenguaje de las masas, a estudiar y a escribir con un profundo sentido de responsabilidad, convirtiendo la palabra en una herramienta eficaz para la causa revolucionaria.</p>
                    <a href="pdfs/libros/contra_el_estilo_de_cliche.pdf"> <span>Descargar PDF</span></a>
                </div>  
            </div>                                 
            <!-- libro no 03 fin -->

            <!-- libro no 04 inicio -->
            <div class="goal-item d-flex p-4">
                <div class="d-flex me-4">
                    <div class="d-inline" style="width: 140px; height: 200px;">
                        <img src="imgs/libro02.png" class="img-fluid" alt="Portada del Libro 04" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                <div>
                    <h4>Los Dirigentes</h4>
                    <p class="text-black mb-0">Esta antología, titulada "Los Dirigentes", define las características y responsabilidades de los líderes y activistas en la lucha política de masas. Describe a los verdaderos dirigentes como personas modestas y desinteresadas que surgen de las luchas populares y se mantienen unidas al pueblo. <br>El documento detalla cómo deben actuar: fomentando el debate, respetando los acuerdos, aprendiendo de las masas antes de enseñarles y corrigiendo sus propios errores. Además, explica la coordinación necesaria entre dirigentes y activistas, y advierte sobre vicios como el autoritarismo, el sectarismo y la burocracia, concluyendo con que el deber fundamental de un líder es amar, escuchar y organizar a las masas en su lucha por una vida más justa.</p>
                    <a href="pdfs/libros/los_dirigentes.pdf"> <span>Descargar PDF</span></a>
                </div>  
            </div>                                 
            <!-- libro no 04 fin -->

            <!-- libro no 05 inicio -->
            <div class="goal-item d-flex p-4">
                <div class="d-flex me-4">
                    <div class="d-inline" style="width: 140px; height: 200px;">
                        <img src="imgs/libro05.png" class="img-fluid" alt="Portada del Libro 05" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                <div>
                    <h4>Alianzas y Negociaciones</h4>
                    <p class="text-black mb-0">Este documento ofrece un marco teórico y práctico sobre las alianzas, los frentes políticos y las negociaciones desde una perspectiva revolucionaria. Define la alianza como una unidad de fuerzas diversas con objetivos comunes, basada en una política de "unidad y lucha". El texto explora distintos tipos de alianzas y destaca al Frente Político como la forma más desarrollada, subrayando la importancia de que el partido revolucionario mantenga su independencia ideológica.<br> Finalmente, aborda las negociaciones como una herramienta política necesaria, especialmente en condiciones desfavorables, explicando que son un proceso de concesiones mutuas condicionado por la fuerza de cada parte, pero que nunca deben sacrificar los intereses fundamentales de la clase trabajadora.</p>
                    <a href="pdfs/libros/alianzas_y_negociaciones.pdf"> <span>Descargar PDF</span></a>
                </div>  
            </div>                                 
            <!-- libro no 05 fin -->

        </div>
    </div>
    <!-- Books End -->

   <?php
        include "tmplt/footer.txt";
   ?>

</body></html>
