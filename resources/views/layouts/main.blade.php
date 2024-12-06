<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>WEBGYM</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/bootstrap.css')}}" />
  
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan|Dosis:400,600,700|Poppins:400,600,700&display=swap"
    rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="{{ url('assets/css/style.css')}}" rel="stylesheet" />

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (necessário para o Bootstrap) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- responsive style -->
  <link href="{{ url('assets/css/responsive.css')}}" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <header>
       
            <div class="container">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                <a class="navbar-brand" href="">
                <center><img src="{{url ('assets/images/logo.png')}}" alt="">
                </center>
                    <span>
                    WEBGYM
                    </span>
                </a>
                <div class="contact_nav" id="">
                    <ul class="navbar-nav ">
                    <li class="nav-item">
                        
                    </li>
                    <li class="nav-item">
                    
                    </li>
                    <li class="nav-item" 
                        @if(Auth::check())
                            <p>Bem-vindo, {{ Auth::user()->name }}!</p>
                        @else
                            <p>Bem-vindo, visitante!</p>
                        @endif
                        
                    </li>
                    </ul>
                </div>
                </nav>
            </div>

            <!-- end header section -->
            <!-- slider section -->
            <div class="container">
                <div class="custom_nav2" style="padding: 0 45px; z-index: 0 !important; position: relative;">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="d-flex  flex-column flex-lg-row align-items-center">
                        <ul class="navbar-nav  ">
                        <li class="nav-item active">
                        <a class="nav-link" href="{{ url( '/logado') }}">Home</a>
                        </li>
                        
                        @if (auth()->user()->tipo == 'P')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url( '/alunos') }}">Alunos</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/treino-aluno') }}">Treinos</a>
                                </li>
                            @endif

                        <li class="nav-item">
                        <a class="nav-link" href="{{ url('/perfil') }}">Perfil</a>
                        </li>
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sair
                            </a>
                        </li>
                        </ul>

                    </div>
                    </div>
                </nav>
                </div>
            </div>
        
        </header>

    @yield('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   
</body>
</html>