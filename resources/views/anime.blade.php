@extends('layouts.main')

@section('title', $anime["name"])

@section('content')
<div id="anime-page" class="anime-page" style="height: 90dvh; display:flex; align-items:center; justify-content:center"><span class="loader-submit" id="loader-submit" style="display: block"></span></div>
<script>
    const neuroXZY = "\u0068\u0074\u0074\u0070\u0073\u003A\u002F\u002F\u0077\u0069\u0074\u0061\u006E\u0069\u006D\u0065\u002E\u0063\u0079\u006F\u0075\u002F\u0077\u0070\u002D\u006A\u0073\u006F\u006E";
    const quantXZY = @json($anime);
    const animePage = document.getElementById('anime-page');

    // load logic
    const animeStatus = {
    5: "مكتمل",
    4: "يعرض الان",
    22: "لم يعرض بعد",
    };
    
    const animeGenresMap = {
    344: "أطفال",
    35: "مغامرات",
    34: "أكشن",
    19: "خيال",
    6: "كوميدي",
    76: "خيال علمي",
    48: "غموض",
    21: "إثارة",
    20: "نفسي",
    117: "حريم",
    50: "ايتشي",
    27: "مدرسي",
    166: "بوليسي",
    981: "تشويق",
    179: "تاريخي",
    106: "رعب",
    49: "خارق للطبيعة",
    670: "جوسي",
    7: "رومانسي",
    268: "ساخر",
    32: "سينين",
    202: "ميكا",
    8: "دراما",
    65: "رياضي",
    107: "ساموراي",
    89: "فنون قتالية",
    42: "سحر",
    26: "شريحة من الحياة",
    158: "شوجو",
    434: "شوجو آي",
    37: "شونين",
    241: "شياطين",
    176: "عسكري",
    251: "فضاء",
    36: "قوة خارقة",
    63: "لعبة",
    184: "مصاصي دماء",
    114: "موسيقى", 
    };
        
    async function fetchAndMergeAnimeData(slug, title) {
        let witAnimeResponse = await fetch(`${neuroXZY}/custom-api/rest/rnd/v1/anime-term/${slug}`);
        if (!witAnimeResponse.ok) {
            witAnimeResponse = await fetch(`${neuroXZY}/custom-api/rest/rnd/v1/anime-term/${createSlug(slug+' '+title)}`);

            if (!witAnimeResponse.ok) {
                window.location.href = `/search/list/?srry=1&q=${title}`;
                return;
            }
        }
        const witAnimeData = await witAnimeResponse.json();

        const episodes = quantXZY.episodes.map((episode, index) => {
            return {
                ...episode,
                id: witAnimeData.related_episodes[index].id
            };
        });

        const namedGenres = witAnimeData.meta.anime_genres.map(
            (genre) => animeGenresMap[genre] || genre
        );

        const combinedData = {
            ...quantXZY,
            slug: witAnimeData.slug,
            anime_status: animeStatus[witAnimeData.meta.anime_status] || "غير محدد",
            anime_genres: namedGenres,
            anime_source: witAnimeData.meta.anime_source,
            anime_duration: witAnimeData.meta.anime_duration,
            anime_episodes_num: witAnimeData.meta.anime_eposides_num || episodes.length,
            episodes: episodes,
            description: witAnimeData.description,
        };

        renderAnimePage(combinedData)
        }

        function renderAnimePage(anime) {
        const reversedAnimeGenres = anime.anime_genres.reverse();
        const animeList = anime.episodes.reverse();
        const seasonsArabic = {
            winter: 'شتاء'+' '+anime.year,
            spring: 'ربيع'+' '+anime.year,
            summer: 'صيف'+' '+anime.year,
            fall: 'خريف'+' '+anime.year
        };

        const seasonArabic = seasonsArabic[anime["anime_season"]] || 'غير محدد';

        animePage.innerHTML = `
        <div class="anime-banner-info">
            <div class="anime-info-container">
                <h1>
                    <div class="status">
                        <span class="rating">${anime.rating}&nbsp;&nbsp;<i class="fas fa-star"></i></span>
                    </div>
                    ${anime.name}
                </h1>
                <ul class="genre">
                    <li>
                        <a href="${anime.anime_trailer}" target="_blank" class="trailer">
                            العرض التشويقي&nbsp;<i class="fas fa-external-link-alt"></i>
                        </a>
                    </li>
                    ${reversedAnimeGenres.map(genre => `<li>${genre}</li>`).join('')}
                </ul>
                <div class="anime-synopsis">
                    <p>${anime.description}</p>
                </div>
                <div class="anime-info">
                    <div class="info-tyle">
                        <p><span>${anime.show_type}</span><code>:</code><strong>النوع</strong></p>
                        <p><span>${anime.year}</span><code>:</code><strong>بداية العرض</strong></p>
                        <p><span>${anime.anime_status}</span><code>:</code><strong>حالة الأنمي</strong></p>
                        <p><span>${anime.anime_episodes_num}</span><code>:</code><strong>عدد الحلقات</strong></p>
                    </div>
                    <div class="info-tyle">
                        <p><span>${anime.anime_duration}</span><code>:</code><strong>مدة الحلقة</strong></p>
                        <p><span>${seasonArabic}</span><code>:</code><strong>الموسم</strong></p>
                        <p><span>${anime.anime_source}</span><code>:</code><strong>المصدر</strong></p>
                        <a href="https://myanimelist.net/anime/${anime.myanimelist}" target="_blank" class="my-anime-list">
                            <i class="fas fa-external-link-alt"></i><span>Myanimelist</span>
                            <svg width="35px" height="35px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="512" cy="512" r="512" style="fill:#2e51a2"/>
                                <path d="M432.49 410.61V590.3l-44.86-.06V479l-43.31 51.29-42.43-52.44-.43 112.75H256V410.65h47l39.79 54.29 43-54.31zm184.06 44.14.53 135.15h-50.45l-.17-61.25h-59.73c1.49 10.65 4.48 27 8.9 38 3.31 8.13 6.36 16 12.44 24.06l-36.37 24c-7.45-13.57-13.27-28.52-18.73-44.42a198.31 198.31 0 0 1-10.82-46.49c-1.81-16-2.07-31.38 2.28-47.19a83.37 83.37 0 0 1 24.77-39.81c6.68-6.25 16-10.67 23.47-14.66s15.85-5.63 23.62-7.66a158 158 0 0 1 25.41-3.9c8.49-.73 23.62-1.41 51-.6l11.63 37.31h-58.78c-12.65.17-18.73 0-28.61 4.46a47.7 47.7 0 0 0-27.26 41l56.81.7.81-38.61h49.26zM701.72 410v141.35L768 552l-9.17 37.87H656.28V409.33z" style="fill:#fff"/>
                            </svg>    
                        </a>
                    </div>
                </div>
            </div>
            <img src="${anime.cover_image}" alt="Banner">
        </div>

        <h1 class="important-title">حلقات الأنمي</h1>

        <div class="anime-episodes grid-display">
            ${anime.show_type.toLowerCase() === "movie" ? `
                <a href="/watch/${anime.id}/${anime.slug}/${animeList[0].id}" class="episode-card">
                    <div class="episode-image">
                        <img src="${anime.cover_image}" alt="Episode Image">
                    </div>
                    <div class="episode-details">
                        <h2 class="episode-title">فلم</h2>
                        <p class="episode-date">${animeList[0].date}</p>
                    </div>
                </a>
            ` : animeList.map((episode, index) => `
                <a href="/watch/${anime.id}/${anime.slug}/${episode.id}" class="episode-card" style="background-image: url('${anime.cover_image}')">
                    ${episode.rating ? `<div class="status"><span class="rating">${episode.rating}&nbsp;&nbsp;<i class="fas fa-star"></i></span></div>` : ''}
                    <div class="episode-details">
                        <h2 class="episode-title">
                            ${index === animeList.length - 1 && anime.anime_status === "مكتمل" ? 
                                `<span dir="rtl">و الاخيرة</span> ${episode.ep} حلقة` : 
                                `${episode.ep} حلقة`}
                        </h2>
                        <p class="episode-date">${episode.date}</p>
                    </div>
                </a>
            `).join('')}
        </div>
        `;
        animePage.removeAttribute("style");
    }

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

    fetchAndMergeAnimeData("{{ $anime["slug"] }}", "{{ $anime["title_eng"] }}");
</script>
@endsection
