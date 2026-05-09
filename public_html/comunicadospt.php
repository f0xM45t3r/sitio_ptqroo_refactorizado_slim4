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

        <!-- Contact Start -->
        <div class="container-fluid contact py-5">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Sección principal del artículo -->
                    <div class="col-lg-9 wow fadeInLeft " data-wow-delay="0.2s">
                        <div class="row text-black">
                            <div class="col-lg-9 mx-auto">
                                <h1 class="card-title">Comunicados</h1>
                                <span class="badge bg-primary">21 de julio de 2025 | Comisión Ejecutiva Nacional  </span>
                            </div>
                        </div>

                        <div class="row text-black">
                            <div class="col-lg-9 mx-auto">
                                <article class="card shadow-sm">
                                    <div class="contenedor-esquela">
                                        <img src="img/esquela-01.jpg" alt="Esquela" class="imagen-esquela">
                                    </div>
                                    <div class="card-body  ">
                                           
                                        <br>
                                        <blockquote class="blockquote p-3 bg-light border-start border-3 border-primary">
                                            <p class="mb-0">  Lamentamos profundamente el fallecimiento del Sr. <strong>Miguel Alday Flores</strong>, padre de nuestro compañero <strong>Dip. Hugo Alday Nieto</strong>. Nuestra solidaridad con su familia y seres queridos. Descanse en paz.</p>
                                            <br>
                                            <footer class="blockquote-footer"> Mtro. Gerardo Rodríguez  </footer>
                                        </blockquote>

                                    

                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                     include "tmplt/recientes.txt";
                    ?>                    

                </div>
            </div>
        </div>
        <!-- Contact End -->

        <?php
        include "tmplt/footer.txt";
        ?>         

    </body>

</html>