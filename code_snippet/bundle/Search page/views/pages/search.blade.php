@extends('layouts.main')

@section('content')

    {{-- Titre, Image bannière et fil d'ariane --}}
    <div class="head-banner">
        @include( 'parts.banner-page-interne')
    </div>

    <div class="section section-search-result">
        <div class="shell">

            {{-- titre --}}
            @if( !empty( $research_word))
                <h2 class="section-title">{{ tt::txt("Votre recherche :") }}<br />
                <strong class="result-keyword">{{ $research_word  }}</strong></h2>
            @endif

            {{-- Recherche avec le mot : --}}
            <p class="result-number">
                {{ $nb_result }}
                    @if( $nb_result == 1 || $nb_result == 0 )
                        {{ tt::txt("résultat de recherche :") }}
                    @else
                        {{ tt::txt("résultats de recherche :") }}
                    @endif
            </p>

            {{-- Résultat de la recherche  --}}
            <section class="results-list">
                @if( isset($posts) && VarHelper::goodArray($posts))
                    @foreach ($posts as $post)
                        <article class="result-item">
                            <a href="{{ get_the_permalink($post->ID) }}">
                                {{-- Post type --}}
                                <span class="result-item__type">{{ $post->post_type }}</span>
                                {{-- Titre --}}
                                <h3 class="result-item__title">{{ strip_tags( get_the_title($post->ID) ) }}</h3>
                                {{-- Extrait --}}
                                @if (!empty($post->extrait))
                                    <p class="result-item__excerpt">{{ $post->extrait}}</p>
                                @endif
                            </a>
                        </article>
                    @endforeach
                @endif            
            </section>

            {{-- Pagination --}}
            @if ( !empty($pagination))
                {!! $pagination !!}
            @endif

        </div>
    </div>

@endsection