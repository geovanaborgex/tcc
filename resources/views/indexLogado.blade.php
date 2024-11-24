@extends('layouts.main')

@section('content')

    <section class=" slider_section position-relative">
      
      <div class="slider_container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container">
                <div class="row">
                  <div class="col-lg-6 col-md-7 offset-md-6 offset-md-5">
                    <div class="detail-box">
                      <h2 style="font-size: 40px;">
                        Por dentro dos resultados
                      </h2>
                      <h3 style="color: white;">
                          Com profissionais qualificados ao seu lado e uma plataforma para acesso às suas fichas de treino, você alcançará seus objetivos com técnica e segurança, dando o seu melhor a cada repetição!            
                      </h3><br>
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item ">
              <div class="container">
                <div class="row">
                  <div class="col-lg-6 col-md-7 offset-md-6 offset-md-5">
                    <div class="detail-box">
                      <h2 style="font-size: 40px;">
                      </h2>
                      <h3 style="color: white;">
                        "Vá além dos limites, transforme suor em conquistas!"  </h3>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
      </div><br>
      <br>
    </section>
    <!-- end slider section -->
    <section class="us_section layout_padding">
      <div class="container">
        <div class="heading_container">
          <h2>
            Porque nos escolher 
          </h2>
        </div>
        <div class="us_container">
          <div class="box">
            <div class="img-box">
              <img src="{{url ('assets/images/u-1.png')}}" alt="">
            </div>
            <div class="detail-box">
              <h5>
                ACOMPANHAMENTO PROFISSIONAL
              </h5>
              <p>
                abordagem personalizada e orientada para alcançar seus objetivos de condicionamento físico de forma eficaz.
              </p>
            </div>
          </div>
          <div class="box">
            <div class="img-box">
            <img src="{{url ('assets/images/u-2.png')}}" alt="">
            </div>
            <div class="detail-box">
              <h5>
                TREINAMENTO INDIVIDUAL
              </h5>
              <p>
                acesso a rotinas de exercícios, acompanhamento de progresso adaptado às necessidades de cada aluno.
              </p>
            </div>
          </div>
          <div class="box">
            <div class="img-box">
            <img src="{{url ('assets/images/u-3.png')}}" alt="">

            </div>
            <div class="detail-box">
              <h5>
                MONITORAMENTO EVOLUÇÕES
              </h5>
              <p>
                garantia que os treinos sejam progressivos, permitindo que os treinadores ajustem os programas conforme necessário.
              </p>
            </div>
          </div>
          <div class="box">
            <div class="img-box">
            <img src="{{url ('assets/images/u-4.png')}}" alt="">
            </div>
            <div class="detail-box">
              <h5>
                CONFIANÇA E SEGURANÇA
              </h5>
              <p>
                tranquilidade ao acessar e compartilhar informações pessoais, garantindo integridade dos dados.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>

  <script>
    function openNav() {
      document.getElementById("myNav").classList.toggle("menu_width");
      document
        .querySelector(".custom_menu-btn")
        .classList.toggle("menu_btn-style");
    }
  </script>
@endsection