<!DOCTYPE html>
<html lang="en">

    <?php
        include "tmplt/head.txt";
   ?>

    <body>

    <?php
        include "tmplt/spinner.txt";
        include "tmplt/navbar.txt";
        include "tmplt/modal.txt";
   ?>

        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Contacto</h4>
            </div>
        </div>
        <!-- Header End -->

        <!-- Contact Start -->
        <div class="container-fluid contact py-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="mb-4">
                            <h4 class="text-primary">Partido del Trabajo Quintana Roo</h4>
                            <h1 class="display-4 mb-4">Contáctanos</h1>
                            <p class="mb.4">
                                Hoy, en Quintana Roo, como en todo el pais, los petistas tenemos el gran reto y responsabilidad de seguir contribuyendo a consolidar la Cuarta Transformación en beneficio del pueblo de México.
                            </p>
                            <p class="mb-4">
                                Nuestro partido, su dirección estatal y toda la militancia del estado, tienen la gran responsabilidad de fortalecer la presencia política de nuestro partido y ser el medio a través del cual la ciudadania accede al ejercicio del poder politico. 
                            </p>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="bg-white d-flex">
                                        <i class="fas fa-map-marker-alt fa-2x text-primary me-2"></i>
                                        <div>
                                            <h4>Dirección</h4>
                                            <p class="mb-0">Av. Nipchupte Sm 15 Mz. 10 Lt. 3 casa 11 C.P. 77505, Cancún, Quintana Roo</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="bg-white d-flex">
                                        <i class="fas fa-envelope fa-2x text-primary me-2"></i>
                                        <div>
                                            <h4>Envíanos un correo</h4>
                                            <p class="mb-0">info@ptqroo.org.mx</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="bg-white d-flex">
                                        <i class="fa fa-phone-alt fa-2x text-primary me-2"></i>
                                        <div>
                                            <h4>Teléfono oficinas</h4>
                                            <p class="mb-0">+52 (998) 630 3373 </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="bg-white d-flex">
                                        <i class="far fa-address-card fa-2x text-primary me-2"></i>
                                        <div>
                                            <h4>Afíliate</h4>
                                            <p class="mb-0"></p>
                                            <p class="mb-0">afiliacionptqroo@gmail.com</p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex ms-2 mb-5">

                            <a class="btn btn-dark py-2 px-3 px-sm-4 me-2" href="https://www.facebook.com/share/1BCvcaesYq/?mibextid=wwXIfr"><i class="fab fa-facebook-f fa-2x"></i></a>
                            <a class="btn btn-dark py-2 px-3 px-sm-4 me-2" href="https://x.com/ptqroo_?s=21&t=YNqj3JCYJAitvqxwN3WXyg"><i class="fab fa-x fa-2x"></i></a>
                            <a class="btn btn-dark py-2 px-3 px-sm-4 me-2" href="https://www.instagram.com/ptquintanaroo?igsh=bWppemF1dTBmZWVt&utm_source=qr"><i class="fab fa-instagram fa-2x"></i></a>
                            <a class="btn btn-dark py-2 px-3 px-sm-4 me-2" href="https://youtube.com/@partidodeltrabajoquintanaroo?si=kVRNu2hcRFiJ6HRE"><i class="fab fa-youtube fa-2x"></i></a>
                            <a class="btn btn-dark py-2 px-3 px-sm-4 me-0" href="https://www.tiktok.com/@ptqroo?_t=ZM-8ub6O1AfWcP&_r=1"><i class="fab fa-tiktok fa-2x"></i></a>
                        </div>
                        <div class="">
                            <div class="row g-0">
                                <img src="img/oficina.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.4s">
                        <div class="form-section bg-primary p-5 h-100">
                            <h1 class="display-4 text-white mb-4">Buzón de Quejas</h1>
                            <form action="recibeQueja.php" method="POST">
                                <div class="row g-4">
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating form-section-col">
                                            <input type="text" class="form-control border-0" id="name" name="name" placeholder="Nombre">
                                            <label for="name">Nombre(s)</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating form-section-col">
                                            <input type="text" class="form-control border-0" id="lastname" name="lastname" placeholder="Apellidos">
                                            <label for="lastname"> Apellidos</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating form-section-col">
                                            <input type="phone" class="form-control border-0" id="phone" name="phone" placeholder="Teléfono">
                                            <label for="phone">Teléfono</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xl-6">
                                        <div class="form-floating form-section-col">
                                            <input type="email" class="form-control border-0" id="email" name="email" placeholder="email">
                                            <label for="email">Correo Electrónico</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating form-section-col">
                                            <input type="text" class="form-control border-0" id="subject" name="subject" placeholder="Tema">
                                            <label for="subject">Tema</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control border-0" placeholder="Leave a message here" id="message" name="message" style="height: 160px;"></textarea>
                                            <label for="message">Mensaje</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="#" id="flexCheck">
                                            <label class="form-check-label" for="flexCheck">Estoy de acuerdo con las políticas de privacidad.</label>
                                          </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-section-col">
                                            <button class="btn-warning w-100 py-3 px-5">Enviar Queja</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="h-100 overflow-hidden">

                            <iframe class="w-100" style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d435.8851063903873!2d-86.82649875323398!3d21.144247306729024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f4c2b003b0d699b%3A0x1c69ae759c452f47!2sPartidodelTrabajo!5e0!3m2!1sen!2smx!4v1741899083867!5m2!1sen!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->


        <?php
        include "tmplt/footer.txt";
        ?>        

    </body>

</html>