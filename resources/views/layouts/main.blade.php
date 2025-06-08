<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
  <style>
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

    @font-face {
      font-family: 'Almarai';
      font-style: normal;
      font-weight: 400;
      font-display: swap;
      src: url('{{ url("font/tsstApxBaigK_hnnQ1iFo0C3.woff2") }}') format('woff2');
      unicode-range: U+0600-06FF, U+0750-077F, U+0870-088E, U+0890-0891, U+0897-08E1, U+08E3-08FF, U+200C-200E, U+2010-2011, U+204F, U+2E41, U+FB50-FDFF, U+FE70-FE74, U+FE76-FEFC, U+102E0-102FB, U+10E60-10E7E, U+10EC2-10EC4, U+10EFC-10EFF, U+1EE00-1EE03, U+1EE05-1EE1F, U+1EE21-1EE22, U+1EE24, U+1EE27, U+1EE29-1EE32, U+1EE34-1EE37, U+1EE39, U+1EE3B, U+1EE42, U+1EE47, U+1EE49, U+1EE4B, U+1EE4D-1EE4F, U+1EE51-1EE52, U+1EE54, U+1EE57, U+1EE59, U+1EE5B, U+1EE5D, U+1EE5F, U+1EE61-1EE62, U+1EE64, U+1EE67-1EE6A, U+1EE6C-1EE72, U+1EE74-1EE77, U+1EE79-1EE7C, U+1EE7E, U+1EE80-1EE89, U+1EE8B-1EE9B, U+1EEA1-1EEA3, U+1EEA5-1EEA9, U+1EEAB-1EEBB, U+1EEF0-1EEF1;
    }

    @font-face {
      font-family: 'Almarai';
      font-style: normal;
      font-weight: 700;
      font-display: swap;
      src: url('{{ url("font/tssoApxBaigK_hnnS-agtnqWo572.woff2") }}') format('woff2');
      unicode-range: U+0600-06FF, U+0750-077F, U+0870-088E, U+0890-0891, U+0897-08E1, U+08E3-08FF, U+200C-200E, U+2010-2011, U+204F, U+2E41, U+FB50-FDFF, U+FE70-FE74, U+FE76-FEFC, U+102E0-102FB, U+10E60-10E7E, U+10EC2-10EC4, U+10EFC-10EFF, U+1EE00-1EE03, U+1EE05-1EE1F, U+1EE21-1EE22, U+1EE24, U+1EE27, U+1EE29-1EE32, U+1EE34-1EE37, U+1EE39, U+1EE3B, U+1EE42, U+1EE47, U+1EE49, U+1EE4B, U+1EE4D-1EE4F, U+1EE51-1EE52, U+1EE54, U+1EE57, U+1EE59, U+1EE5B, U+1EE5D, U+1EE5F, U+1EE61-1EE62, U+1EE64, U+1EE67-1EE6A, U+1EE6C-1EE72, U+1EE74-1EE77, U+1EE79-1EE7C, U+1EE7E, U+1EE80-1EE89, U+1EE8B-1EE9B, U+1EEA1-1EEA3, U+1EEA5-1EEA9, U+1EEAB-1EEBB, U+1EEF0-1EEF1;
    }

    @font-face {
      font-family: 'Almarai';
      font-style: normal;
      font-weight: 800;
      font-display: swap;
      src: url('{{ url("font/tssoApxBaigK_hnnS_qjtnqWo572.woff2") }}') format('woff2');
      unicode-range: U+0600-06FF, U+0750-077F, U+0870-088E, U+0890-0891, U+0897-08E1, U+08E3-08FF, U+200C-200E, U+2010-2011, U+204F, U+2E41, U+FB50-FDFF, U+FE70-FE74, U+FE76-FEFC, U+102E0-102FB, U+10E60-10E7E, U+10EC2-10EC4, U+10EFC-10EFF, U+1EE00-1EE03, U+1EE05-1EE1F, U+1EE21-1EE22, U+1EE24, U+1EE27, U+1EE29-1EE32, U+1EE34-1EE37, U+1EE39, U+1EE3B, U+1EE42, U+1EE47, U+1EE49, U+1EE4B, U+1EE4D-1EE4F, U+1EE51-1EE52, U+1EE54, U+1EE57, U+1EE59, U+1EE5B, U+1EE5D, U+1EE5F, U+1EE61-1EE62, U+1EE64, U+1EE67-1EE6A, U+1EE6C-1EE72, U+1EE74-1EE77, U+1EE79-1EE7C, U+1EE7E, U+1EE80-1EE89, U+1EE8B-1EE9B, U+1EEA1-1EEA3, U+1EEA5-1EEA9, U+1EEAB-1EEBB, U+1EEF0-1EEF1;
    }

    body {
      background-color: #1F1F1F;
    }
    
    :root {
        --background-color: #010101;
        --primary-color: #ff7925;
        --text-color: #F5F5F5;
        --secondary-color: #FFBE85;
    }

    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background-color: var(--text-colorr);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #666;
        border-radius: 10px;
    }
  </style>
  <script>
    window.onload = function() {
      window.scrollTo(0, 0);
    };
  </script>
  @vite([
  'resources/js/app.js',
  'resources/js/serverFetch.js',
  'resources/css/navbar.css',
  'resources/css/footer.css',
  'resources/css/carousel.css',
  'resources/css/search_bar.css',
  'resources/css/listAnime.css',
  'resources/css/details.css',
  'resources/css/errors.css',
  'resources/css/search.css',
  'resources/css/watch.css',
  ])

  <title>AnimeMonkey - @yield('title')</title>
</head>
<body>
<nav>
  <div class="wrapper">
    <div class="logo"><a href="{{ route('home') }}"><img src="{{ url('img/logo.svg') }}" alt="logo"></a></div>
    <input type="radio" name="slider" id="menu-btn">
    <input type="radio" name="slider" id="close-btn">
    <ul class="nav-links">
      <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
      <li><a href="{{ route('home') }}">قائمة رئيسية</a></li>
      <li><a href="{{ route('anime-list') }}">قائمة الانمي</a></li>
      <li>
        <a href="{{ route('season-anime') }}" class="desktop-item" id="season-anime"><span>انميات الموسم</span>&nbsp;<i class="fas fa-trophy"></i></a>
        <input type="checkbox" id="showMega1">
        {{-- <div class="mega-box">
          <div class="content">
            <div class="row">
              <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-mega-menu-and-dropdown-menu-using-only-html-and-css/img.jpg" alt="">
            </div>
            <div class="row">
              <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-mega-menu-and-dropdown-menu-using-only-html-and-css/img.jpg" alt="">
            </div>
            <div class="row">
              <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-mega-menu-and-dropdown-menu-using-only-html-and-css/img.jpg" alt="">
            </div>
            <div class="row">
              <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-mega-menu-and-dropdown-menu-using-only-html-and-css/img.jpg" alt="">
            </div>
          </div>
        </div> --}}
      </li>
      <li>
        <a href="{{ route('suggest-me') }}" class="desktop-item" id="suggest-anime"><span>اقترح لي انمي</span>&nbsp;<i class="far fa-star"></i></a>
        <input type="checkbox" id="showMega2">
        {{-- <div class="mega-box">
          <div class="content">
            <div class="row" >
              <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-mega-menu-and-dropdown-menu-using-only-html-and-css/img.jpg" alt="">
            </div>
            <div class="row">
              <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-mega-menu-and-dropdown-menu-using-only-html-and-css/img.jpg" alt="">
            </div>
            <div class="row">
              <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-mega-menu-and-dropdown-menu-using-only-html-and-css/img.jpg" alt="">
            </div>
            <div class="row">
              <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-mega-menu-and-dropdown-menu-using-only-html-and-css/img.jpg" alt="">
            </div>
          </div>
        </div> --}}
      </li>
      <li class="acc-container"><a href="#" class="my-acc"><i class="fas fa-user-circle"></i><span>حسابي</span></a></li>
    </ul>
    <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
  </div>
</nav>

<main id="main">
  @yield('content')  
</main>

<footer>
  <div class="footer-container">
    <div class="footer-section">
      <h3>من نحن</h3>
      <p>نحن شغوفون بالأنمي ونسعى لتقديم أحدث المحتويات والأخبار لجمهورنا. ابقَ على تواصل للحصول على إصدارات وتحديثات أنمي مشوقة.</p>
    </div>
    <div class="footer-section">
      <h3>اتصل بنا</h3>
      <p>البريد الإلكتروني: <a href="mailto:contact@animemonkey.fun">contact@animemonkey.fun</a></p>
    </div>
    <div class="footer-section">
      <h3>تابعنا</h3>
      <div class="social-links">
        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2025 AnimeMonkey. جميع الحقوق محفوظة.</p>
  </div>
</footer>
</body>
</html>