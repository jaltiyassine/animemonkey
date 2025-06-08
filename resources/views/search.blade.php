@extends('layouts.main')

@section('title', 'نتائج البحث')

@section('content')
<section class="list-anime search-special">
    <h1 class="important-title">نتائج البحث</h1>
    @if($srry)
        <h2 class="srry">:للأسف، لم نستطع العثور على الأنمي الذي طلبته. إليك بعض الأنميات المشابهة</h2>
    @endif
    <div class="grid-display" id="pop-anime-sec"></div>
</section>
<script>
    const animes = @json($data);
    const animeContainer = document.getElementById("pop-anime-sec");
    const neuroXZY = "\u0068\u0074\u0074\u0070\u0073\u003A\u002F\u002F\u0077\u0069\u0074\u0061\u006E\u0069\u006D\u0065\u002E\u0063\u0079\u006F\u0075\u002F\u0077\u0070\u002D\u006A\u0073\u006F\u006E";

    const createSlug = (text) =>
    text
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/^-+|-+$/g, "");

    animes.forEach(async (anime) => {
    let isAvailable = false;

    try {
        let witAnimeResponse = await fetch(
        `${neuroXZY}/custom-api/rest/rnd/v1/anime-term/${anime.slug}`,
        { method: "HEAD" }
        );

        if (!witAnimeResponse.ok) {
        const modifiedSlug = createSlug(`${anime.slug} ${anime.eng_title}`);
        witAnimeResponse = await fetch(
            `${neuroXZY}/custom-api/rest/rnd/v1/anime-term/${modifiedSlug}`,
            { method: "HEAD" }
        );
        }

        if (witAnimeResponse.ok) {
        isAvailable = true;
        }
    } catch (error) {}

    if(isAvailable){
        const animeCard = document.createElement("a");
        animeCard.href = `/anime/${anime.jikanID}/${anime.slug}/${anime.eng_title}`;
        animeCard.title = anime.name;
        animeCard.className = "anime-card";
        animeCard.style.backgroundImage = `url('${anime.cover_image}')`;

        animeCard.innerHTML = `
            <div class="status">
            <span class="rating">${anime.rating}&nbsp;&nbsp;<i class="fas fa-star"></i></span>
            </div>
            <div class="general-info">
            <div class="anime-name">${anime.name}</div>
            <div class="sudo-info">
                <span class="release-date">${anime.year}</span>
                <i class="fas fa-circle"></i>
                <span class="show-type">${anime.show_type}</span>
            </div>
            </div>
        `;
        animeContainer.appendChild(animeCard);
    }
    });
</script>
@endsection
