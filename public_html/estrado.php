<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title>Partido del Trabajo -Quintana Roo-</title>
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
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInDown;">Estrado Electrónico</h4>
            <h3 class="text-white wow fadeInDown" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInDown;">Notificaciones y Comunicaciones oficiales</h3>
        </div>
    </div>
    <!-- Header End -->


    <!-- Team Start -->
    <div class="container-fluid team py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px; visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <p class="mb-0">
                    Consulta en nuestra plataforma digital notificaciones, comunicaciones oficiales, convocatorias <br> y otros documentos legales de manera electrónica.
                </p>
            </div>

            <!-- convocatoria inicio -->
            <div class="goal-item d-flex p-4">
                <div class="d-flex me-4">
                    <div class="bg-primary d-inline p-3" style="width: 80px; height: 80px;">
                        <img src="img/convocatoria.png" class="img-fluid" alt="">
                    </div>
                </div>
                <div>
                    <h4>Convocatoria al 12o Congreso Nacional Ordinario</h4>
                    <p class="text-black mb-0">Que se llevará a cabo en el inmueble de la Expo Reforma, Cámara Nacional de Comercio de la Ciudad de México, el día 26 de abril de 2025</p>
                    <a href="pdfs/Congreso-Nacional.pdf"> <span>ver PDF</span></a>
                </div>  
            </div>                                 
            <!-- convocatoria fin -->

            <!-- convocatoria inicio -->
            <div class="goal-item d-flex p-4">
                <div class="d-flex me-4">
                    <div class="bg-primary d-inline p-3" style="width: 80px; height: 80px;">
                        <img src="img/convocatoria.png" class="img-fluid" alt="">
                    </div>
                </div>
                <div>
                    <h4>Convocatoria Congreso Estatal Extraordinario del Partido del Trabajo en Quintana Roo </h4>
                    <p class="text-black mb-0">Que se llevará a cabo en el “Salón de Eventos Eros” ubicado en Avenida José López Portillo,súpermanzana 98 lote 20, C.P. 77537, Cancún – Benito Juárez, Estado de Quintana Roo, el día sábado 29 de marzo de 2025</p>
                    <a href="pdfs/Congreso-QuintanaRoo.pdf"> <span>ver PDF</span></a>
                </div>  
            </div>                                 
            <!-- convocatoria fin -->
            
            <!-- convocatoria inicio -->
            <div class="goal-item d-flex p-4">
                <div class="d-flex me-4">
                    <div class="bg-primary d-inline p-3" style="width: 80px; height: 80px;">
                        <img src="img/convocatoria.png" class="img-fluid" alt="">
                    </div>
                </div>
                <div>
                    <h4>Convocatoria Congresos Municipales Extraordinarios en el estado de Quintana Roo </h4>
                    <p class="text-black mb-0">Que se llevarán a cabo de conformidad con el siguiente calendario...</p>
                    <a href="pdfs/Conv CongrMplsExtr PT QRoo 2025 -dif.pdf"> <span>ver PDF</span></a>
                </div>  
            </div>                                 
            <!-- convocatoria fin -->            

        </div>
    </div>
    <!-- Team End -->

            <!-- Footer Start -->
    <div class="container-fluid footer py-1 wow fadeIn" data-wow-delay="0.2s" id="foot" style="visibility: hidden; animation-delay: 0.2s; animation-name: none;">
        <div class="container py-4">
            <div class="row g-5 mb-5 align-items-center">
                <div class="col-lg-7">
                    <div class="position-relative d-flex" style="transform: skew(18deg);">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                        <a class="btn btn-primary btn-md-square me-3" href="https://www.facebook.com/share/1BCvcaesYq/?mibextid=wwXIfr"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-primary btn-md-square me-3" href="https://x.com/ptqroo_?s=21&amp;t=YNqj3JCYJAitvqxwN3WXyg"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-primary btn-md-square me-3" href="https://www.instagram.com/ptquintanaroo?igsh=bWppemF1dTBmZWVt&amp;utm_source=qr"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-primary btn-md-square me-3" href="https://youtube.com/@partidodeltrabajoquintanaroo?si=kVRNu2hcRFiJ6HRE"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-primary btn-md-square me-0" href="https://www.tiktok.com/@ptqroo?_t=ZM-8ub6O1AfWcP&amp;_r=1"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item">
                        <h4 class="text-white mb-4"><i class="fas fa-hand-rock text-primary me-2"></i> PT QRoo</h4>
                        <p class="mb-0 text-white">“Por el bien de todos, primero los pobres”, “Cero corrupción e impunidad”,
                            “Austeridad republicana”, “No robar, no mentir y no traicionar al pueblo”.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Enlaces rápidos</h4>
                        <a href="index.php"> Inicio</a>
                        <a href="index.php#sobrenos"> Nuestro Partido</a>
                        <a href="index.php#prensa"> Sala de Prensa</a>
                        <a href="index.php#trsp"> Transparencia</a>
                        <a href="index.php#dips"> Conoce a tu diputad@</a>
                        <a href="index.php#afiliate"> Afiliación</a>
                        <a href="contacto.php"> Contacto</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item">
                        <h4 class="text-white mb-4"> Contacto</h4>
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="d-flex">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <div>
                                        <h5 class="text-white mb-2">Dirección</h5>
                                        <p class="mb-0 text-white">Av. Nipchupte Sm 15 Mz. 10 Lt. 3 casa 11 C.P. 77505, Cancún, Quintana Roo</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <div>
                                        <h5 class="text-white mb-2">Correo electrónico</h5>
                                        <p class="mb-0 text-white">info@example.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex">
                                    <i class="fa fa-phone-alt text-primary me-2"></i>
                                    <div>
                                        <h5 class="text-white mb-2">Teléfono</h5>
                                        <p class="mb-0 text-white">(+012) 3456 7890 123</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Footer End -->

    
    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>Partido del Trabajo Quintana Roo</a>, Derechos Reservados.</span>
                </div>
                <div class="col-md-6 text-center text-md-end text-body">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                    Diseñado por <a class="border-bottom text-white" href="https://htmlcodex.com">HTML Codex</a>
                    Distribuida por <a href="https://themewagon.com/">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <div class="back-to-top">
        <a href="#" class="btn"><i class="fa fa-arrow-up"></i></a>  
    </div> 

    
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script> 



</body></html>