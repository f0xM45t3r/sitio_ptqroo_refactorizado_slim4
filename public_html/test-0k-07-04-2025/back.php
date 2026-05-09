<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Fitness - Fitness Website Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Teko:wght@300..700&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link rel="stylesheet" href="lib/animate/animate.min.css"/>
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/red-style.css" rel="stylesheet">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <div class="container-fluid header-top">
            <div class="nav-shaps-2"></div>
            <div class="container d-flex align-items-center">
                <div class="d-flex align-items-center h-100">
                    <a href="#" class="navbar-brand" style="height: 125px;">
                        <h1 class="text-primary mb-0"><img src="img/logopt.svg" alt="Logo" width="50 px" height="50 px"></i>  PT QRoo</h1>
                        <!-- <img src="img/logo.png" alt="Logo"> -->
                    </a>
                </div>
                <div class="w-100 h-100">
                    <div class="topbar px-0 py-2 d-none d-lg-block" style="height: 45px;">
                        <div class="row gx-0 align-items-center">
                            <div class="col-lg-8 text-center text-lg-center mb-lg-0">
                                <div class="d-flex flex-wrap">
                                    <div class="pe-4">
                                        
                                    </div>
                                    <div class="pe-0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center text-lg-end">
                                <div class="d-flex justify-content-end">
                                    <div class="d-flex align-items-center small">
                                    </div>
                                    <div class="d-flex pe-3">
                                        <a class="btn p-0 text-light me-3" href="#"><i class="fab fa-facebook-f"></i></a>
                                        <a class="btn p-0 text-light me-3" href="#"><i class="fab fa-twitter"></i></a>
                                        <a class="btn p-0 text-light me-3" href="#"><i class="fab fa-instagram"></i></a>
                                        <a class="btn p-0 text-light me-0" href="#"><i class="fab fa-linkedin-in"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-bar px-0 py-lg-0" style="height: 80px;">
                        <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-lg-end">
                            <a href="#" class="navbar-brand-2">
                                <h1 class="text-primary mb-0"><img src="img/logopt.svg" alt="Logo" width="50 px" height="50 px"></i> PT QRoo</h1>
                                <!-- <img src="img/logo.png" alt="Logo"> -->
                            </a> 
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                                <span class="fa fa-bars"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarCollapse">
                                <div class="navbar-nav mx-0 mx-lg-auto">
                                    <a href="index.html" class="nav-item nav-link active">Inicio</a>
                                    <div class="nav-item dropdown">
                                        <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                            <span class="dropdown-toggle">Nuestro Partido</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a href="testimonial.html" class="dropdown-item">¿Quiénes Somos?</a>
                                            <a href="team.html" class="dropdown-item">Prensa</a>
                                            <a href="feature.html" class="dropdown-item">Documentos Básicos</a>
                                            <a href="team.html" class="dropdown-item">Principios</a>
                                            <a href="404.html" class="dropdown-item">Estructura estatal</a>
                                        </div>
                                    </div>
                                    <a href="course.html" class="nav-item nav-link">Transparencia</a>
                                    <a href="blog.html" class="nav-item nav-link">Estrado Electrónico</a>
                                    <a href="contact.html" class="nav-item nav-link">Afiliación</a>
                                    <a href="contact.html" class="nav-item nav-link">Contacto</a>
                                    <div class="nav-btn ps-3">
                                        <p class="btn-search btn  btn-md-square mt-2 mt-lg-0 mb-4 mb-lg-0 flex-shrink-0" ></p>
                                    </div>
                                    <div class="nav-shaps-1"></div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

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


        <!-- Carousel Start -->
        <div class="header-carousel owl-carousel overflow-hidden bg-dark">
            <div class="header-carousel-item hero-section">
                <div class="hero-bg-half-1"></div>
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-7 animated fadeInLeft">
                                <div class="text-sm-center text-md-start">
                                    <h3 class="text-primary text-uppercase fw-bold mb-4">Afirma nuevo Delegado</h3>
                                    <h2 class="display-1 text-white mb-4">No cederemos espacios en la mesa de negociación</h2>
                                    <p class="mb-5 fs-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy... 
                                    </p>
                                    <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-4">
                                        <a class="btn btn-dark py-3 px-4 px-md-5 me-2" href="#"><i class="fas fa-play-circle me-2"></i> <span>Watch Video</span></a>
                                        <a class="btn btn-primary py-3 px-4 px-md-5 ms-2" href="#"><span>Learn More</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-carousel-item hero-section">
                <div class="hero-bg-half-2"></div>
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-7 animated fadeInLeft">
                                <div class="text-sm-center text-md-start">
                                    <h3 class="text-primary text-uppercase fw-bold mb-4">Le ha regresado la dignidad a este país</h3>
                                    <h2 class="display-2 text-white mb-4">Hoy México hace historia con su primer Presidenta</h2>
                                    <p class="mb-5 fs-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy... 
                                    </p>
                                    <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-4">
                                        <a class="btn btn-dark py-3 px-4 px-md-5 me-2" href="#"><i class="fas fa-play-circle me-2"></i> <span>Watch Video</span></a>
                                        <a class="btn btn-primary py-3 px-4 px-md-5 ms-2" href="#"><span>Learn More</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->

        <!-- About Start -->
        <div class="container-fluid about pt-5">
            <div class="container pt-5">
                <div class="row g-5">
                    <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="about-content h-100">
                            <h4 class="text-warning">Acerca del Partido del Trabajo Quintana Roo</h4>
                            <h1 class="display-4 text-white mb-4">¿Quiénes Somos?</h1>
                            <p class="mb-4">Somos proyecto integral, que no aspira al poder por el poder mismo, sino como punto de apoyo para impulsar la movilización del pueblo y la transformación de la realidad política de México.</p>
                            <div class="tab-class pb-4">
                                <ul class="nav d-flex mb-2">
                                    <li class="nav-item mb-3">
                                        <a class="d-flex py-2 active" data-bs-toggle="pill" href="#tab-1">
                                            <span style="width: 150px;">Documentos </span>
                                        </a>
                                    </li>
                                    <li class="nav-item mb-3">
                                        <a class="d-flex py-2 mx-3" data-bs-toggle="pill" href="#tab-2">
                                            <span style="width: 150px;">Principios</span>
                                        </a>
                                    </li>
                                    <li class="nav-item mb-3">
                                        <a class="d-flex py-2" data-bs-toggle="pill" href="#tab-3">
                                            <span style="width: 150px;">Dirigencia  Estatal </span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane fade show p-0 active">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center border-top border-bottom py-4">
                                                    <span class="fas fa-rocket text-white fa-4x me-4"></span>
                                                    <p class="mb-0">
                                                        <strong>El Partido del Trabajo</strong> en su ideología establece construir una nueva filosofía basada en la ética, la honestidad, la verdad, la cooperatividad, la justicia, la libertad y la democracia. En pocas palabras busca «Servir al Pueblo».
                                                        <a href="#">Documentos Básicos</a>
                                                    </p>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane fade show p-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center border-top border-bottom py-4">
                                                    <span class="fas fa-rocket text-white fa-4x me-4"></span>
                                                    <p class="mb-0">
                                                        <strong>La línea de masas</strong>, consiste en apoyarse en la movilización de los grupos sociales más humildes, para conseguir la transformación del país.
                                                        Es fundamental para todo trabajo que se realice, tanto en su interior como entre las masas, que permita ir construyendo el poder popular alternativo
                                                        <a href="#">Declaración de Principios</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-3" class="tab-pane fade show p-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center border-top border-bottom py-4">
                                                    <span class="fas fa-rocket text-white fa-4x me-4"></span>
                                                    <p class="mb-0">
                                                        El Partido del Trabajo está formado por organizaciones políticas, partidos locales y ciudadanos que desean participar activamente en la construcción de su propio destino, creando un país con igualdad de oportunidades para todos                                                    
                                                        <a href="#">Dirigencia Estatal</a>                                                   
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                 
                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="about-img h-100">
                            <div class="about-img-inner d-flex h-100">
                                <img src="img/quienes.png" class="img-fluid w-100" style="object-fit: cover;" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Sala de Prensa Start -->
        <div class="container-fluid feature bg-light py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary"> Comunicación Social</h4>
                    <h1 class="display-4 mb-4">Sala de Prensa</h1>
                    <p class="mb-0">
                        Conoce los boletines y notas informativas con Información de Interés Nacional,<br> Estatal y Coyuntura que difunde el Partido del Trabajo Quintana Roo
                    </p>
                </div>
                <div class="feature-carousel owl-carousel">
                    <div class="feature-item wow fadeInUp" data-wow-delay="0.2s">
                        <div class="feature-img">
                            <img src="img/nota01.jpg" class="img-fluid w-100"  alt="">
                        </div>
                        <div class="feature-content p-4">
                            <h4 class="mb-3">Congreso Estatal 2025</h4>
                            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur obcaecati voluptatum,
                            </p>
                            <a href="#" class="btn btn-primary py-2 px-4"> <span>Leer más</span></a>
                        </div>
                    </div>
                    <div class="feature-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="feature-img">
                            <img src="img/nota02.jpg" class="img-fluid w-100"  alt="">
                        </div>
                        <div class="feature-content p-4">
                            <h4 class="mb-3">Es tiempo de Mujeres</h4>
                            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur obcaecati voluptatum,
                            </p>
                            <a href="#" class="btn btn-primary py-2 px-4"> <span>Leer más</span></a>
                        </div>
                    </div>
                    <div class="feature-item wow fadeInUp" data-wow-delay="0.6s">
                        <div class="feature-img">
                            <img src="img/nota03.jpg" class="img-fluid w-100"  alt="">
                        </div>
                        <div class="feature-content p-4">
                            <h4 class="mb-3">Combate a la delincuencia</h4>
                            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur obcaecati voluptatum,
                            </p>
                            <a href="#" class="btn btn-primary py-2 px-4"> <span>Leer más</span></a>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-img">
                            <img src="img/nota04.jpg" class="img-fluid w-100"  alt="">
                        </div>
                        <div class="feature-content p-4">
                            <h4 class="mb-3">Congreso Político Municipal</h4>
                            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur obcaecati voluptatum,
                            </p>
                            <a href="#" class="btn btn-primary py-2 px-4"> <span>Leer más</span></a>
                        </div>
                    </div>
                </div>
                <div class="feature-shaps"></div>
            </div>
        </div>
        <!-- Sala de Prensa End -->

        <!-- Transparencia start -->
        <div class="container-fluid goal pt-5">
            <div class="container pt-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="goal-content">
                            <h4 class="text-primary">Acceso a la Información</h4>
                            <h1 class="display-4 mb-4">Transparencia</h1>
                            <div class="goal-item d-flex p-4">
                                <div class="d-flex me-4">
                                    <div class="bg-primary d-inline p-3" style="width: 80px; height: 80px;">
                                        <img src="img/icon-1.png" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div>
                                    <h4>Solicitud de información al PT</h4>
                                    <p class="text-white mb-0"> partir del 05/mayo/2016, acceder a la <a href="#">Plataforma Nacional de Transparencia</a>.</p>
                                </div>
                            </div>
                            <div class="goal-item d-flex p-4 mb-4">
                                <div class="d-flex me-4">
                                    <div class="bg-primary d-inline p-3" style="width: 80px; height: 80px;">
                                        <img src="img/icon-6.png" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div>
                                    <h4>Aviso de privacidad</h4>
                                    <p class="text-white mb-0">es un documento que indica cómo se recopilan, usan, comparten y protegen los datos personales. 
                                    </p>
                                </div>
                            </div>
                            <div class="ms-1">
                                <a href="#" class="btn btn-primary py-3 px-5 ms-2"> <span>Conoce más</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="h-100">
                            <img src="img/fitness-goal-banner copy.png" class="img-fluid h-100 " style="object-fit: cover;" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Transparencia End -->

        <!-- Conoce a tu diputado Start -->
        <div class="container-fluid blog py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">  Congreso de Quintana Roo</h4>
                    <h1 class="display-4 mb-4">Conoce a tu Diputad@</h1>
                    <p class="mb-0">
                        Conoce el trabajo que realizan para garantizar que las voces locales se transformen en acciones concretas, construyendo una sociedad más justa, equitativa y con mayores oportunidades para todos los quintanarroenses.
                    </p>
                </div>
                <div class="blog-carousel owl-carousel">
                    
                    <div class="blog-item wow fadeInUp" data-wow-delay="0.4s">
                        <div class="blog-img p-4 pb-0">
                            <a href="#">
                                <img src="img/feature-3.jpg" class="img-fluid w-100" alt="">
                            </a>
                        </div>
                        <div class="blog-content p-4">
                            <div class="blog-comment d-flex justify-content-between py-2 px-3 mb-4">
                                <div class="small"><span class="fa fa-user text-primary me-2"></span> Dip. Ruben Carrillo Buenfil</div>
                                <div class="small"><span class="fa fa-calendar text-primary me-2"></span> Dtto.  III </div>
                            </div>
                            <a href="#" class="h4 d-inline-block mb-3">Dip. Ruben Carrillo Buenfil</a>
                            <p class="mb-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius libero soluta impedit eligendi? Quibusdam, laudantium.</p>
                            <a href="#" class="btn btn-primary py-2 px-4 ms-2"> <span class="me-2">Leer más</span>  <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="blog-item wow fadeInUp" data-wow-delay="0.6s">
                        <div class="blog-img p-4 pb-0">
                            <a href="#">
                                <img src="img/feature-2.jpg" class="img-fluid w-100" alt="">
                            </a>
                        </div>
                        <div class="blog-content p-4">
                            <div class="blog-comment d-flex justify-content-between py-2 px-3 mb-4">
                                <div class="small"><span class="fa fa-user text-primary me-2"></span> Dip. Diana Frine</div>
                                <div class="small"><span class="fa fa-calendar text-primary me-2"></span> Dtto.  XIV</div>
                            </div>
                            <a href="#" class="h4 d-inline-block mb-3">Dip. Diana Frine</a>
                            <p class="mb-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius libero soluta impedit eligendi? Quibusdam, laudantium.</p>
                            <a href="#" class="btn btn-primary py-2 px-4 ms-2"> <span class="me-2">Leer más</span>  <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="blog-item">
                        <div class="blog-img p-4 pb-0">
                            <a href="#">
                                <img src="img/feature-1.jpg" class="img-fluid w-100" alt="">
                            </a>
                        </div>
                        <div class="blog-content p-4">
                            <div class="blog-comment d-flex justify-content-between py-2 px-3 mb-4">
                                <div class="small"><span class="fa fa-user text-primary me-2"></span> Dip. Hugo Alday Nieto</div>
                                <div class="small"><span class="fa fa-calendar text-primary me-2"></span> Dtto. V</div>
                            </div>
                            <a href="#" class="h4 d-inline-block mb-3">Dip. Hugo Alday Nieto</a>
                            <p class="mb-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eius libero soluta impedit eligendi? Quibusdam, laudantium.</p>
                            <a href="#" class="btn btn-primary py-2 px-4 ms-2"> <span class="me-2">Leer más</span>  <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Conoce a tu diputado End -->

        <!-- Afíliate Start -->
        <div class="container-fluid explore py-5 wow zoomIn" data-wow-delay="0.2s">
            <div class="container py-5 text-center">
                <h1 class="display-1 text-white mb-0"> Afíliate</h1>
                <a class="btn btn-primary py-3 px-4 px-md-5 me-2" href="https://www.youtube.com/embed/DWRcNpR6Kdc"><i class="fas fa-play-circle me-2"></i> <span>Más información</span></a>
            </div>
        </div>
        <!-- Afíliate End -->





        <!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="row g-5 mb-5 align-items-center">
                    <div class="col-lg-7">
                        <div class="position-relative d-flex" style="transform: skew(18deg);">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex align-items-center justify-content-center justify-content-lg-end">
                            <a class="btn btn-primary btn-md-square me-3" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-md-square me-3" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-md-square me-3" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-primary btn-md-square me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item">
                            <h4 class="text-white mb-4"><i class="fas fa-hand-rock text-primary me-2"></i> PT QRoo</h4>
                            <p class="mb-0">“Por el bien de todos, primero los pobres”, “Cero corrupción e impunidad”,
                                “Austeridad republicana”, “No robar, no mentir y no traicionar al pueblo”.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">Enlaces rápidos</h4>
                            <a href="#"> Inicio</a>
                            <a href="#"> Nuestro Partido</a>
                            <a href="#"> Prensa</a>
                            <a href="#"> Transparencia</a>
                            <a href="#"> Afiliación</a>
                            <a href="#"> Contacto</a>
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
                                            <p class="mb-0">123 street New York</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <div>
                                            <h5 class="text-white mb-2">Correo electrónico</h5>
                                            <p class="mb-0">info@example.com</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <i class="fa fa-phone-alt text-primary me-2"></i>
                                        <div>
                                            <h5 class="text-white mb-2">Teléfono</h5>
                                            <p class="mb-0">(+012) 3456 7890 123</p>
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
    </body>

</html>