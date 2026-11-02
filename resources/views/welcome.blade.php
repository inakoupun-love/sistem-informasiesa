<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>SIPAKAL-Desa Kalinaun</title>

    <!-- Preconnect untuk stabilisasi koneksi aset lokal dan eksternal -->
    <link rel="preconnect" href="{{ url('/') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preload" href="{{ asset('mentahan2/vendor/bootstrap/css/bootstrap.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('mentahan2/assets/css/templatemo-edu-meeting.css') }}" as="style">
    <link rel="preload" href="{{ asset('mentahan2/assets/images/pantaipaal.jpg') }}" as="image">
    <link rel="preload" href="{{ asset('mentahan2/assets/images/logodesa.png') }}" as="image">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('mentahan2/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{asset('mentahan2/assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('mentahan2/assets/css/templatemo-edu-meeting.css')}}">
    <link rel="stylesheet" href="{{asset('mentahan2/assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{asset('mentahan2/assets/css/lightbox.css')}}">
  </head>

<body>
  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                     
                      <a href="{{ route('welcome') }}" class="logo" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                          <img src="{{ asset('mentahan2/assets/images/logodesa.png') }}" alt="Desa Kalinaun" style="height: 40px; width: auto;">
                          <span style="font-weight: bold; color: #ffffffff; font-size: 16px;">Desa Kalinaun</span>
                      </a>
                    
                      <!-- <ul class="nav">
                          <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                          <li><a href="meetings.html">Meetings</a></li>
                          <li class="scroll-to-section"><a href="#apply">Apply Now</a></li>
                          <li class="has-sub">
                              <a href="javascript:void(0)">Pages</a>
                              <ul class="sub-menu">
                                  <li><a href="meetings.html">Upcoming Meetings</a></li>
                                  <li><a href="meeting-details.html">Meeting Details</a></li>
                              </ul>
                          </li>
                          <li class="scroll-to-section"><a href="#courses">Courses</a></li> 
                          <li class="scroll-to-section"><a href="#contact">Contact Us</a></li> 
                      </ul>         -->
                      <ul class="nav justify-content-end">
                          <li><a href="{{ route('profil-desa') }}" class="btn btn-outline-light btn-sm"><i class="fa fa-building"></i> Profil Desa</a></li>
                          <li><a href="{{ route('cekbansos') }}" class="btn btn-outline-light btn-sm"><i class="fa fa-boxes"></i> Cek Bansos</a></li>
                      </ul>
                      <a class='menu-trigger'>
                          <span>Menu</span>
                      </a>
                    
                  </nav>
              </div>
          </div>
      </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <!-- ***** Main Banner Area Start ***** -->
  <section class="section main-banner" id="top" data-section="section1">
      <div class="video-overlay header-text">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="caption">
              <h6>Selamat datang di</h6>
              <h2>SISTEM PELAYANAN ADMINISTRASI KALINAUN</h2>
              <p>Membantu Masyarakat untuk mewujudkan kehidupan yang sejahtera</p>
              <div class="main-button-red">
                  <a href="{{ route('login') }}">Login</a>
              </div>
              <div class="main-button-red mt-2">
                  <a href="{{ route('cekbansos') }}" style="background-color: #1f272b;"><i class="fa fa-boxes"></i> Cek Bantuan Sosial</a>
              </div>
          </div>
              </div>
            </div>
          </div>
      </div>
  </section>
  <!-- ***** Main Banner Area End ***** -->

  <section class="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-service-item owl-carousel">
            @forelse($informasis->take(5) as $index => $info)
            @php
              preg_match('/<img.+src="([^"]+)"/', $info->konten, $matches);
              $firstImg = !empty($matches[1]) ? $matches[1] : null;
            @endphp
            <div class="item" onclick="window.location='{{ route('informasi.detail', $info->id) }}'" style="cursor: pointer;">
              <div class="icon">
                @if($firstImg)
                  <img src="{{ $firstImg }}" alt="{{ $info->judul }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                @else
                  <img src="{{asset('mentahan2/assets/images/service-icon-0' . (($index % 3) + 1) . '.jpg')}}" alt="">
                @endif
              </div>
              <div class="down-content">
                <h4>{{ Str::limit($info->judul, 20) }}</h4>
                <p>{!! Str::limit(strip_tags($info->konten), 80) !!}</p>
              </div>
            </div>
            @empty
            <div class="item">
              <div class="icon">
                <img src="{{asset('mentahan2/assets/images/service-icon-01.jpg')}}" alt="">
              </div>
              <div class="down-content">
                <h4>Belum Ada Informasi</h4>
                <p>Silakan input informasi terbaru melalui dashboard admin.</p>
              </div>
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="upcoming-meetings" id="meetings">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>Informasi Desa Terbaru</h2>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="categories">
            <h4>Kategori Informasi</h4>
            <ul>
              <li><a href="#" class="filter-category active" data-category="all">Semua Kategori</a></li>
              @forelse($kategoriInformasis as $kat)
                <li><a href="#" class="filter-category" data-category="{{ $kat->kategori }}">{{ $kat->kategori }}</a></li>
              @empty
                <li><a href="#">Umum</a></li>
              @endforelse
            </ul>
            <div class="main-button-red mt-3">
              <a href="#meetings" class="filter-category" data-category="all">Tampilkan Semua</a>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row">
            @forelse($informasis as $index => $info)
            @php
              preg_match('/<img.+src="([^"]+)"/', $info->konten, $matches);
              $firstImg = !empty($matches[1]) ? $matches[1] : null;
            @endphp
            <div class="col-lg-6 information-card mb-4" data-category="{{ $info->kategori ?? 'Umum' }}">
              <div class="meeting-item">
                <div class="thumb">
                  <div class="price">
                    <span>{{ $info->kategori ?? 'Umum' }}</span>
                  </div>
                  <a href="{{ route('informasi.detail', $info->id) }}">
                    @if($firstImg)
                      <img src="{{ $firstImg }}" alt="{{ $info->judul }}" style="width: 100%; height: 250px; object-fit: cover;">
                    @else
                      <img src="{{asset('mentahan2/assets/images/meeting-0' . (($index % 4) + 1) . '.jpg')}}" alt="{{ $info->judul }}">
                    @endif
                  </a>
                </div>
                <div class="down-content">
                  <div class="date">
                    <h6>{{ $info->created_at->format('M') }} <span>{{ $info->created_at->format('d') }}</span></h6>
                  </div>
                  <a href="{{ route('informasi.detail', $info->id) }}"><h4>{{ Str::limit($info->judul, 40) }}</h4></a>
                  <p>{!! Str::limit(strip_tags($info->konten), 85) !!}</p>
                  <div class="text-end mt-2">
                    <a href="{{ route('informasi.detail', $info->id) }}" class="text-danger fw-semibold" style="font-size: 13px;">Baca Selengkapnya <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                  </div>
                </div>
              </div>
            </div>
            @empty
            <div class="col-12 text-center text-white py-5">
              <h5>Belum ada informasi yang diposting oleh admin.</h5>
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
    <script src="{{asset('mentahan2/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('mentahan2/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('mentahan2/assets/js/isotope.min.js')}}"></script>
    <script src="{{asset('mentahan2/assets/js/owl-carousel.js')}}"></script>
    <script src="{{asset('mentahan2/assets/js/lightbox.js')}}"></script>
    <script src="{{asset('mentahan2/assets/js/tabs.js')}}"></script>
    <script src="{{asset('mentahan2/assets/js/video.js')}}"></script>
    <script src="{{asset('mentahan2/assets/js/slick-slider.js')}}"></script>
    <script src="{{asset('mentahan2/assets/js/custom.js')}}"></script>
    <script>
        /according to loftblog tut
        $('.nav li:first').addClass('active');

        var showSection = function showSection(section, isAnimate) {
          var
          direction = section.replace(/#/, ''),
          reqSection = $('.section').filter('[data-section="' + direction + '"]'),
          reqSectionPos = reqSection.offset().top - 0;

          if (isAnimate) {
            $('body, html').animate({
              scrollTop: reqSectionPos },
            800);
          } else {
            $('body, html').scrollTop(reqSectionPos);
          }

        };

        var checkSection = function checkSection() {
          $('.section').each(function () {
            var
            $this = $(this),
            topEdge = $this.offset().top - 80,
            bottomEdge = topEdge + $this.height(),
            wScroll = $(window).scrollTop();
            if (topEdge < wScroll && bottomEdge > wScroll) {
              var
              currentId = $this.data('section'),
              reqLink = $('a').filter('[href*=\\#' + currentId + ']');
              reqLink.closest('li').addClass('active').
              siblings().removeClass('active');
            }
          });
        };

        $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function (e) {
          e.preventDefault();
          showSection($(this).attr('href'), true);
        });

        $(window).scroll(function () {
          checkSection();
        });

        // jQuery Category Filter for Informasi Desa
        $('.filter-category').on('click', function(e) {
          e.preventDefault();
          $('.filter-category').removeClass('active');
          
          // Match categories inside sidebar and bottom button
          var category = $(this).data('category');
          $('.filter-category[data-category="' + category + '"]').addClass('active');
          
          if (category === 'all') {
            $('.information-card').fadeIn();
          } else {
            $('.information-card').hide();
            $('.information-card[data-category="' + category + '"]').fadeIn();
          }
        });
    </script>


</body>
</html>
