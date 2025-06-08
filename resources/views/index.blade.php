@extends('layouts.main')

@section('title', 'افضل موقع لمشاهدة الانمي')

@section('content')
{{-- carousel part --}}
<section class="carousel">
    <ol class="carousel__viewport">
      <li id="carousel__slide1"
          tabindex="0"
          class="carousel__slide" style="background-image: url('{{ url('img/Bleach-Sennen-Kessen-hen-Slider.jpg') }}')">
        <div class="carousel__snapper">
          <div class="animte-status">
            <span class="hot"><i class="fas fa-fire-alt"></i>Hot</span>
          </div>
          <div class="shadowed-caption">
            <div class="anime-name">Bleach</div>
            <p class="description">القصة تدور حول كوروساكي إتشيجو وهو فتى في الخامسة عشر من عمره يمتلك القدرة على رؤية الأرواح/الأشباح وبسبب هذه القدرة تمكّن من لقاء شينجامي أنثى تُدعى كوتشيكي روكيا لإنقاذ عائلته من أرواح شريرة تُدعى الهولو.</p>
            <a href="/anime/269/bleach" style="all: unset"><button class="watch-button">شاهد الان</button></a>
          </div>
        </div>
      </li>
      <li id="carousel__slide2"
          tabindex="0"
          class="carousel__slide" style="background-image: url('{{ url('img/Dr.-Stone-Stone-Wars-Slide.webp') }}')">
        <div class="carousel__snapper">
          <div class="animte-status">
            <span class="hot"><i class="fas fa-fire-alt"></i>Hot</span>
          </div>
          <div class="shadowed-caption">
            <h1 class="anime-name">Dr. Stone</h1>
            <p class="description">في حادثة أًصبحت كُل الكائنات الحية عبارةً عن تماثيل حجرية، يُناضل كروم وسينكو سويةً ليُنقذوا البشر من حادثة التحجر في زمنٍ خالٍ من التقنية والحضارة.</p>
            <a href="/anime/38691/dr-stone" style="all: unset"><button class="watch-button">شاهد الان</button></a>
          </div>
        </div>
      </li>
      <li id="carousel__slide3"
          tabindex="0"
          class="carousel__slide" style="background-image: url('{{ url('img/Sakamoto-Days-Slider-scaled.jpg') }}')">
        <div class="carousel__snapper">
          <div class="animte-status">
            <span class="hot"><i class="fas fa-fire-alt"></i>Hot</span>
          </div>
          <div class="shadowed-caption">
            <h1 class="anime-name">Sakamoto Days</h1>
            <p class="description">القصة تتحدث عن مغتال أسطوري متقاعد أصبح رب أسرة بدينًا ليُجر ثانيةً إلى عالم الجريمة ولكن الآن لحماية عائلته من منظمة قاسية تسعى للانتقام.</p>
            <a href="/anime/58939/sakamoto-days" style="all: unset"><button class="watch-button">شاهد الان</button></a>
          </div>
        </div>
      </li>
      <li id="carousel__slide4"
          tabindex="0"
          class="carousel__slide" style="background-image: url('{{ url('img/Solo-Leveling-Ore-dake-Level-Up-na-Ken-Slider.jpg') }}')">
        <div class="carousel__snapper">
          <div class="animte-status">
            <span class="hot"><i class="fas fa-fire-alt"></i>Hot</span>
          </div>
          <div class="shadowed-caption">
            <h1 class="anime-name">Ore dake Level Up na Ken Season 2</h1>
            <p class="description">الموسم الثاني من الأنمي.</p>
            <a href="/anime/58567/solo-leveling-season-2-arise-from-the-shadow-ore-dake-level-up-na-ken-season-2" style="all: unset"><button class="watch-button">شاهد الان</button></a>
          </div>
        </div>
      </li>
    </ol>
    <aside class="carousel__navigation">
      <ol class="carousel__navigation-list">
        <li class="carousel__navigation-item">
          <button class="carousel__navigation-button" data-slide="0"></button>
        </li>
        <li class="carousel__navigation-item">
          <button class="carousel__navigation-button" data-slide="1"></button>
        </li>
        <li class="carousel__navigation-item">
          <button class="carousel__navigation-button" data-slide="2"></button>
        </li>
        <li class="carousel__navigation-item">
          <button class="carousel__navigation-button" data-slide="3"></button>
        </li>
      </ol>
    </aside>
    <button class="carousel__prev"><i class="fas fa-chevron-left"></i></button>
    <button class="carousel__next"><i class="fas fa-chevron-right"></i></button>
</section>
{{-- end carousel part --}}

{{-- search part --}}
<section class="search-sec">
    <div class="search-container">
        <div class="search-suggest-container">
          <input
          autocomplete="off" type="search"
          name="search" title="search" aria-label="search" id="search-g"
          style="width: 100%; border: none; margin: 0px; height: auto; outline: none;"
          placeholder=""
          dir="ltr" spellcheck="false"
          />
          <ul class="suggest-list" id="search-data-holder"></ul>
        </div>
        <button id="ex-search-act"><svg
            viewBox="0 0 13 13">
            <title>search</title>
            <path d="m4.8495 7.8226c0.82666 0 1.5262-0.29146 2.0985-0.87438 0.57232-0.58292 0.86378-1.2877 0.87438-2.1144 0.010599-0.82666-0.28086-1.5262-0.87438-2.0985-0.59352-0.57232-1.293-0.86378-2.0985-0.87438-0.8055-0.010599-1.5103 0.28086-2.1144 0.87438-0.60414 0.59352-0.8956 1.293-0.87438 2.0985 0.021197 0.8055 0.31266 1.5103 0.87438 2.1144 0.56172 0.60414 1.2665 0.8956 2.1144 0.87438zm4.4695 0.2115 3.681 3.6819-1.259 1.284-3.6817-3.7 0.0019784-0.69479-0.090043-0.098846c-0.87973 0.76087-1.92 1.1413-3.1207 1.1413-1.3553 0-2.5025-0.46363-3.4417-1.3909s-1.4088-2.0686-1.4088-3.4239c0-1.3553 0.4696-2.4966 1.4088-3.4239 0.9392-0.92727 2.0864-1.3969 3.4417-1.4088 1.3553-0.011889 2.4906 0.45771 3.406 1.4088 0.9154 0.95107 1.379 2.0924 1.3909 3.4239 0 1.2126-0.38043 2.2588-1.1413 3.1385l0.098834 0.090049z"></path>
        </svg></button>
    </div>

</section>
{{-- end search part --}}

{{-- list anime part --}}
<section class="list-anime">
  <h1 class="important-title">الانميات الاكثر شعبية</h1>
  <div class="grid-display" id="pop-anime-sec">
    @foreach($data as $anime)
      <a href="/anime/{{ $anime["jikanID"] }}/{{ $anime["slug"] }}/{{ $anime["eng_title"] }}" title="{{ $anime["name"] }}" class="anime-card" style="background-image: url('{{ url($anime["cover_image"]) }}')">
          <div class="status"><span class="rating">{{ $anime["rating"] }}&nbsp;&nbsp;<i class="fas fa-star"></i></span></div>
          <div class="general-info">
              <div class="anime-name">{{ $anime["name"] }}</div>
              <div class="sudo-info"><span class="release-date">{{ $anime["year"] }}</span><i class="fas fa-circle"></i><span class="show-type">{{ $anime["show_type"] }}</span></div>
          </div>
      </a>
    @endforeach
  </div>
  <br>
  <button class="load-a-more" id="load-a-more"><span>تحميل المزيد</span>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
      <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z"/>
    </svg>
  </button>
  <span class="loader-submit" id="loader-submit"></span>
  <span id="waiter-there"></span>
  <br>
</section>
{{-- end list anime part --}}
@endsection