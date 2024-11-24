@extends('layouts.main')

@section('content')

<!-- service section -->

  <section class="service_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Seus treinos
        </h2>
      </div>
      <div class="service_container">
        <div class="box">
        <img src="{{url ('assets/images/s-1.jpg')}}" alt="">
          <h6 class="visible_heading">
            Treino de   @if(Auth::check())
                      <p >{{ Auth::user()->name }}</p>
                  @else
                      <p></p>
                  @endif
          </h6>
          <div class="link_box">
            <a href="{{ url('/fichas') }}">
            <img src="{{url ('assets/images/link.png')}}" alt="">
            </a>
            <h6 class="visible_heading">
            Treino de   @if(Auth::check())
                      <p >{{ Auth::user()->name }}</p>
                  @else
                      <p></p>
                  @endif
          </h6>
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