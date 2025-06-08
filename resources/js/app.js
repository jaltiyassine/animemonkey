import './bootstrap';

let lastScrollTop = 0;
const navbar = document.querySelector('nav');

window.addEventListener('scroll', function() {
  const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

  if (currentScroll > 85) {
    if (currentScroll > lastScrollTop) {
      navbar.classList.add('hidden');
    } else {
      navbar.classList.remove('hidden');
    }
  } else {
    navbar.classList.remove('hidden');
  }

  lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
});

const carouselViewport = document.querySelector('.carousel__viewport');
const slides = document.querySelectorAll('.carousel__slide');
const totalSlides = slides.length;
let currentIndex = 0;

const updateCarouselPosition = () => {
  if(carouselViewport){
    carouselViewport.style.transition = 'transform 0.3s ease-in-out';
    carouselViewport.style.transform = `translateX(-${currentIndex * 100}%)`;
    updateActiveDot();
  }
};

const updateActiveDot = () => {
  const navigationButtons = document.querySelectorAll('.carousel__navigation-button');
  navigationButtons?.forEach((button, index) => {
    button.classList.remove('active');
    if (index === currentIndex) {
      button.classList.add('active');
    }
  });
};

const goToNextSlide = () => {
  currentIndex = (currentIndex + 1) % totalSlides;
  updateCarouselPosition();
};

const goToPrevSlide = () => {
  currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
  updateCarouselPosition();
};

const navigationButtons = document.querySelectorAll('.carousel__navigation-button');
navigationButtons?.forEach((button, index) => {
  button.addEventListener('click', (event) => {
    event.preventDefault();
    currentIndex = index;
    updateCarouselPosition();
    resetAutoSlide();
  });
});

const nextButton = document.querySelector('.carousel__next');
const prevButton = document.querySelector('.carousel__prev');
nextButton?.addEventListener('click', () => {
  goToNextSlide();
  resetAutoSlide();
});
prevButton?.addEventListener('click', () => {
  goToPrevSlide();
  resetAutoSlide();
});

let autoSlideInterval = setInterval(goToNextSlide, 5000);

const resetAutoSlide = () => {
  clearInterval(autoSlideInterval);
  autoSlideInterval = setInterval(goToNextSlide, 5000);
};

updateActiveDot();

let popularAnimes = [];
let animeIndex = 0;
let charIndex = 0;
let typingInterval;
let mainInterval;
const searchInput = document.getElementById('search-g');

async function fetchPopularAnimes() {
  try {
    const response = await fetch('https://api.jikan.moe/v4/top/anime');
    const data = await response.json();
    popularAnimes = data.data.map(anime => anime.title);
    if (popularAnimes.length > 0) {
      startTyping();
      mainInterval = setInterval(() => {
        if (!searchInput.matches(':focus') && document.visibilityState === 'visible') {
          searchInput.setAttribute('placeholder', '');
          startTyping();
        }
      }, 5000);
    }
  } catch (error) {
    console.error('Failed to fetch popular anime titles:', error);
    popularAnimes = ["Error fetching anime titles"];
    startTyping();
  }
}

function typePlaceholder() {
  if (charIndex < popularAnimes[animeIndex]?.length) {
    const currentPlaceholder = searchInput.getAttribute('placeholder');
    const newPlaceholder = currentPlaceholder + popularAnimes[animeIndex][charIndex];

    if (newPlaceholder.length > Math.max(...popularAnimes.map(anime => anime.length))) {
      clearInterval(typingInterval);
      searchInput.setAttribute('placeholder', '');
      charIndex = 0;
      animeIndex = 0;
      return;
    }

    searchInput.setAttribute('placeholder', newPlaceholder);
    charIndex++;
  } else {
    if (animeIndex >= popularAnimes.length) {
      animeIndex = 0;
    } else {
      charIndex = 0;
      animeIndex++;
    }
    clearInterval(typingInterval);
  }
}

function startTyping() {
  if (!searchInput?.matches(':focus') && document.visibilityState === 'visible') {
    typingInterval = setInterval(typePlaceholder, 50);
  }
}

searchInput?.addEventListener('focus', () => {
  clearInterval(typingInterval);
  charIndex = 0;
});

document.addEventListener('visibilitychange', () => {
  if (document.visibilityState === 'visible' && searchInput) {
    clearInterval(typingInterval);
    clearInterval(mainInterval);
    searchInput?.setAttribute('placeholder', '');
    charIndex = 0;
    startTyping();
    mainInterval = setInterval(() => {
      if (!searchInput.matches(':focus') && document.visibilityState === 'visible') {
        searchInput.setAttribute('placeholder', '');
        startTyping();
      }
    }, 5000);
  }
});

if (window.location.pathname === '/') {
  fetchPopularAnimes();
}

// search logic

function createSlug(title) {
  if (!title) {
      return "not-found";
  }

  let slug = title.toLowerCase();

  slug = slug.replace(/[^\p{L}\p{N}\p{Pd}\s]+/gu, '');

  slug = slug.replace(/[\s\-]+/g, '-');

  slug = slug.replace(/^-+|-+$/g, '');

  return slug || "not-found";
}

let debounceTimer;
const searchButton = document.getElementById("ex-search-act");

searchInput?.addEventListener('keyup', function(){
  let holder = document.getElementById("search-data-holder");
  holder.style.display = "flex";
  holder.innerHTML = `<img src="img/loading.gif" width="25px" id="loading-ic" alt="loading">`;

  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    if (searchInput.value.length >= 3) {
      fetch(`/search/?q=${searchInput.value}`)
      .then(res => res.json())
      .then(async finalRes => {
        const neuroXZY = "\u0068\u0074\u0074\u0070\u0073\u003A\u002F\u002F\u0077\u0069\u0074\u0061\u006E\u0069\u006D\u0065\u002E\u0063\u0079\u006F\u0075\u002F\u0077\u0070\u002D\u006A\u0073\u006F\u006E";
        const FinalDataRes = await Promise.all(
          finalRes.map(async (x) => {
            x.isAv = false;
            try {
              let witAnimeResponse = await fetch(`${neuroXZY}/custom-api/rest/rnd/v1/anime-term/${x.slug}`,
                {method:"head"}
              );
              if (!witAnimeResponse.ok) {
                witAnimeResponse = await fetch(`${neuroXZY}/custom-api/rest/rnd/v1/anime-term/${createSlug(x.slug + ' ' + x.eng_title)}`,
                  {method:"head"}
                );
              }
              if (witAnimeResponse.ok) {
                x.isAv = true;
              }
            } catch (error) {}
            return x;
          })
        );
    
        const available = FinalDataRes.filter(x => x.isAv);
        const unavailable = FinalDataRes.filter(x => !x.isAv);
    
        const combined = [...available, ...unavailable];
    
        let HtmlStruct = "";
        combined.forEach((x) => {
          HtmlStruct += `<li>
            <a href="/anime/${x.mal_id}/${x.slug}/${x.eng_title}" onclick="${x.isAv ? '' : 'return false'}" class="search-anime-result">
              <img src="${x.poster}" alt="anime banner" class="search-anime-banner">
              <div class="search-anime-info">
                <h1><span class="header-text">${x.name}</span><span class="search-anime-rating"><span>${x.rating}</span><i class="fas fa-star"></i></span></h1>
                <div class="search-anime-status">${x.status}</div>
                <div class="search-anime-time"><small>${x.date}</small></div>
              </div>
              <span class="badge-search-status" style="background-color:${x.isAv ? "#28a745" : "#bb2124"};">${x.isAv ? "متوفر" : "غير متوفر"}</span>
            </a>
          </li>`;
        });
    
        if (HtmlStruct === "") {
          HtmlStruct = `<code style="margin:10px 0; color: #666;">لا نتائج</code>`;
        } else {
          HtmlStruct += `<em style="margin:10px 0; color: #333; font-size: 0.9" class="more-search-re">للمزيد من النتائج اضغط على زر البحث</em>`;
        }
    
        holder.innerHTML = HtmlStruct;
      })
      .catch(error => {
        console.error("Error fetching search results:", error);
      });    
    }else{
      let holder = document.getElementById("search-data-holder");
      holder.style.display = "none";
      holder.innerHTML = `<img src="img/loading.gif" width="25px" id="loading-ic" alt="loading">`;
    }
  }, 500);
});

searchInput?.addEventListener('input', () => {
  if (searchInput.value == "") {
    let holder = document.getElementById("search-data-holder");
    holder.style.display = "none";
    holder.innerHTML = `<img src="img/loading.gif" width="25px" id="loading-ic" alt="loading">`;
  }
});

searchInput?.addEventListener('keyup', function(e){
  if( (e.key).toLowerCase() == "enter" && searchInput.value.length >= 3){
    window.location.href = `/search/list/?q=${searchInput.value}`;
  }
})

searchButton?.addEventListener('click', function(){
  if(searchInput.value.length >= 3){
    window.location.href = `/search/list/?q=${searchInput.value}`;
  }
});

// anime load
const animeSec = document.getElementById("pop-anime-sec");
const loaderSubmit = document.getElementById("loader-submit");
const loadMoreButton = document.getElementById("load-a-more");
const waiterThere = document.getElementById("waiter-there");
let CurrentLoadPage = 2;

function loadMoreAnime() {
  loaderSubmit.style.display = "inline-block";
  loadMoreButton.style.display = "none";
  fetch(`/?page=${CurrentLoadPage}`)
    .then(response => response.json())
    .then(responseData => {
      CurrentLoadPage++;
      let HtmlStruct = "";
      responseData.forEach((anime) => {
        HtmlStruct += `
        <a href="/anime/${anime.jikanID}/${anime.slug}/${anime.eng_title}" title="${anime.name}" class="anime-card" style="background-image: url('${anime.cover_image}')">
          <div class="status"><span class="rating">${anime.rating}&nbsp;&nbsp;<i class="fas fa-star"></i></span></div>
          <div class="general-info">
            <div class="anime-name">${anime.name}</div>
            <div class="sudo-info"><span class="release-date">${anime.year}</span><i class="fas fa-circle"></i><span class="show-type">${anime.show_type}</span></div>
          </div>
        </a>`;
      });

      animeSec.innerHTML += HtmlStruct;
      loaderSubmit.style.display = "none";
      loadMoreButton.style.display = "flex";
    })
    .catch(error => {
      console.error("Error loading more anime:", error);
      loaderSubmit.style.display = "none";
      loadMoreButton.style.display = "flex";
    });
}

const handleScroll = () => {
  if (waiterThere) {
    const rect = waiterThere.getBoundingClientRect();
    const isVisible = rect.top >= 0 && rect.bottom <= window.innerHeight;

    if (isVisible) {
      document.removeEventListener("scroll", handleScroll);
      loadMoreAnime();
    }
  }
};

if(animeSec && loadMoreButton){
  loadMoreButton.addEventListener('click',loadMoreAnime);
  document.addEventListener("scroll", handleScroll);    
}