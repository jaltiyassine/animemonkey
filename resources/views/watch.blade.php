
@extends('layouts.main')

@section('title', $anime["name"]." مشاهدة")

@section('content')

<section class="watch-container">
    <div class="main-content">

        <div class="video-player" id="video-placeholder">
            <div class="ins-mess" id="loader-iframe-fin"><span>جار البحث عن اسرع سيرفر متوفر</span><span class="loader" id="server-loader"></span></div>
        </div>

        <div class="servers-list" id="servers-list" style="display:flex; align-items:center; justify-content:center"><span class="loader-submit" id="loader-submit" style="display: block;width: 25px;height: 25px;border-width: .2.2em;"></span></div>

        <div class="video-details" id="video-details"></div>

        <div class="comments-section">
            <div class="comments-title">تعليقات</div>
            <div class="comment">
                <div class="avatar" style="background-image: url('{{ url('img/us.png') }}')"></div>
                <div class="comment-content">
                    <p><strong>AnimeMonkey</strong><div dir="rtl">استمتع بمشاهدة <span id="welcome-name-anime">...</span> على موقعنا 😁</div></p>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar" id="sidebar-listing"></div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://witanime.cyou/wp-content/themes/Anime-Online-Theme/assets/js/bootstrap.min.js"></script>
<script>
    const neuroXZY = "\u0068\u0074\u0074\u0070\u0073\u003A\u002F\u002F\u0077\u0069\u0074\u0061\u006E\u0069\u006D\u0065\u002E\u0063\u0079\u006F\u0075\u002F\u0077\u0070\u002D\u006A\u0073\u006F\u006E";
    const quantXZY = @json($anime);
    const videoDetails = document.getElementById('video-details');
    const sidebarList = document.getElementById('sidebar-listing');
    const serversList = document.getElementById('servers-list');
    const videoPlaceholder = document.getElementById('video-placeholder');

    let buttonData;
    let currentIframeValue;

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
            witAnimeResponse = await fetch(`${neuroXZY}/custom-api/rest/rnd/v1/anime-term/${createSlug(slug + ' ' + title)}`);
            
            if (!witAnimeResponse.ok) {
                window.location.href = `/search/list/?srry=1&q=${title}`;
                return;
            }
        }
        const witAnimeData = await witAnimeResponse.json();

        let mainEpData;

        if (witAnimeData.related_episodes && witAnimeData.related_episodes.length === quantXZY.episodes.length) {
            let episodes = quantXZY.episodes.map((episode, index) => {
                if (witAnimeData.related_episodes[index].id === quantXZY.mainEpData) {
                    mainEpData = {
                        ...episode,
                        id: witAnimeData.related_episodes[index].id
                    };
                }
                return {
                    ...episode,
                    id: witAnimeData.related_episodes[index].id
                };
            });

            let realLen = episodes.length;

            episodes = getFiveEpisodes(episodes, mainEpData.ep);

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
                anime_episodes_num: realLen,
                episodes: episodes,
                description: witAnimeData.description,
                mainEpData: mainEpData,
            };

            renderVideoDetails(combinedData);
        }
    }

    async function fetchPlayButton(episodeID) {
        const response = await fetch(`${neuroXZY}/custom-api/blue/ldo/frum/chd/not/loaded/v1/episode/${episodeID}`);

        const data = await response.json();

        buttonData = chooseOptimizedUrl((data.meta).servers);

        if(buttonData.length > 0){
            renderButtons();
        }else{
            serversList.innerHTML = "<span style='color:#ddd;' >لا يوجد سيرفرات</span>";
        }
    }

    function renderButtons(){
        serversList.innerHTML = "";
        buttonData.forEach(x=> {
            serversList.innerHTML += `<button class="server-button ${
            x.name == currentIframeValue? 'activer-but-sel' : ''
            }" ${
            x.name == currentIframeValue? 'disabled' : ''
            } onclick="setIframe('${x.name}','${x.url}')">${x.name}</button>`;
        });
    }

    function setIframe(name, url){
        currentIframeValue = name;
        const iframeVideo = document.getElementById("iframe-videoo");
        iframeVideo.setAttribute("src", url);
        renderButtons();
    }

    function chooseOptimizedUrl(data) {
        if(data.length > 0){
            let url = data[0].url;
            if (data[0].name === "yonaplay - FHD") {
                const separator = url.includes('?') ? '&' : '?';
                url += `${separator}apiKey=dfe54a64-7a9e-4f30-8048-6a921ba208c6`;
            }
            console.log(url);
            const iframeVideo = `<iframe width="100%" id="iframe-videoo" height="100%" src="${url}" frameborder="0" allowfullscreen></iframe>`;
            videoPlaceholder.innerHTML = iframeVideo;
            currentIframeValue = data[0].name;
        }else{
            videoPlaceholder.innerHTML = `<div class="ins-mess" id="loader-iframe-fin"><span>لا يوجد سيرفرات</span></div>`;
        }
        return data;
    }

    function renderVideoDetails(anime) {
        const reversedAnimeGenres = anime.anime_genres.reverse();
        const animeList = anime.episodes.reverse();
        const seasonsArabic = {
            winter: 'شتاء ' + anime.year,
            spring: 'ربيع ' + anime.year,
            summer: 'صيف ' + anime.year,
            fall: 'خريف ' + anime.year
        };

        const seasonArabic = seasonsArabic[anime["anime_season"]] || 'غير محدد';

        let episodeNumber = anime.mainEpData.ep;
        let episodeText = `${episodeNumber} حلقة`;
        let episodeStatus = '';
        let showType = anime.show_type;
        let animeStatus = anime.anime_status;
        let totalEpisodes = anime.anime_episodes_num;

        if (showType.toLowerCase() === "movie") {
            episodeText = 'فلم';
        } else if (totalEpisodes == episodeNumber && animeStatus === "مكتمل") {
            episodeStatus = '<span dir="rtl">و الاخيرة</span>';
        }

        videoDetails.innerHTML = `
            <div class="video-title"><div class="status"><span class="rating">${anime.mainEpData.rating}&nbsp;&nbsp;<i class="fas fa-star"></i></span></div>
                <span>${episodeStatus}&nbsp;${episodeText}&nbsp;-&nbsp;<a href="/anime/${anime.id}/${anime.slug}">${anime.name}</a></span>
            </div>
            
            <div class="video-title">
            <div class="description">
                <img src="${anime.cover_image}" alt="Banner">
                <div class="main-des-area">
                    <ul class="genre">
                        <li>
                            <a href="${anime.anime_trailer}" target="_blank" class="trailer">العرض التشويقي&nbsp;<i class="fas fa-external-link-alt"></i></a>
                        </li>
                        ${anime.anime_genres.map(genre => `<li>${genre}</li>`).join('')}
                    </ul>
                    <p>${anime.description}</p>
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
            </div>
        `;
        renderSidebarList(anime);
        document.getElementById("welcome-name-anime").textContent = anime.name;
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

    function getFiveEpisodes(episodes, currentEpisode) {
        const currentIndex = episodes.findIndex(ep => ep.ep === currentEpisode);

        if (currentIndex === -1) return [];
        
        let startIndex = currentIndex - 2;
        let endIndex = currentIndex + 2;

        if (startIndex < 0) {
            startIndex = 0;
            endIndex = 4;
        } else if (endIndex >= episodes.length) {
            startIndex = episodes.length - 5;
            endIndex = episodes.length - 1;
        }

        let fiveEpisodes = episodes.slice(startIndex, endIndex + 1).filter(ep => ep.ep !== currentEpisode);

        if (fiveEpisodes.length < 5) {
            if (currentIndex < episodes.length / 2) {
                let missingCount = 5 - fiveEpisodes.length;
                let additionalEpisodes = episodes.slice(endIndex + 1, endIndex + 1 + missingCount);
                fiveEpisodes = fiveEpisodes.concat(additionalEpisodes);
            } else {
                let missingCount = 5 - fiveEpisodes.length;
                let additionalEpisodes = episodes.slice(startIndex - missingCount, startIndex);
                fiveEpisodes = additionalEpisodes.concat(fiveEpisodes);
            }
        }

        return fiveEpisodes;
    }

    function renderSidebarList(anime) {
        let sidebarContent = '';

        if (anime.episodes && anime.episodes.length > 0) {
            sidebarContent += `
                <div class="suggestion more">
                    <div>اقتراحات</div>
                </div>
            `;
            
            anime.episodes.forEach(ep => {
                let episodeText = `${ep.ep} حلقة`;
                let episodeStatus = '';

                if (anime.anime_episodes_num == ep.ep && anime.anime_status === "مكتمل") {
                    episodeStatus = '<span dir="rtl">و الاخيرة</span>';
                }

                sidebarContent += `
                    <a href="/watch/${anime.id}/${anime.slug}/${ep.id}" class="suggestion">
                        <div class="thumbnail" style="background-image: url('{{ url('img/play.webp') }}')"></div>
                        <div class="suggestion-info">
                            <p class="suggestion-title">${episodeStatus}&nbsp;${episodeText}</p>
                            <p class="suggestion-details">${ep.date} • <span class="rating suggest-rating">${ep.rating}&nbsp;<i class="fas fa-star"></i></span></p>
                        </div>
                    </a>
                `;
            });
        } else {
            sidebarContent += `
                <div class="suggestion more">
                    <div>لا يوجد حلقات اخرى</div>
                </div>
            `;
        }
        sidebarList.innerHTML = sidebarContent;
    }

    fetchPlayButton("{{ $anime["mainEpData"] }}");
    fetchAndMergeAnimeData("{{ $anime["slug"] }}", "{{ $anime["title_eng"] }}");    
</script>
@endsection
