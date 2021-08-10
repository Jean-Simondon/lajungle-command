@extends('layouts.main')

@section('content')

    @if( $picture = VarHelper::goodArray( option("image-de-fond-404") ))
        <section class="e404-wrapper" style="background-image: url({{ MediaHelper::getImage($picture, 'bloc-image') }})">
        {{-- <img style="height:200px;" {{ VarHelper::goodImage( $example->ID, "full") }}> --}}
    @endif
        @if( MediaHelper::ImageExists($picture, 'bloc-image' ))

        @endif
    @elseif(file_exists(themosis_path('sub-theme').'resources/assets/images/placeholder.png'))
        <section class="e404-wrapper" style="background-image: url({{ iquitheme_assets().'/images/placeholder.png' }})">
    @endif

    <div class="shell">

        <figure>
            @if ( pll_current_language() == 'fr' )
                <img src="{{ iquitheme_assets().'/images/404-fr.png' }}" alt="">
            @elseif( pll_current_language() == 'en' )
                <img src="{{ iquitheme_assets().'/images/404-en.png' }}" alt="">
            @endif
        </figure>

        {{-- BOUTON --}}
        @if ( !empty( option("bouton")) )
            <div class="btn-wrapper">
                <a href="{{ esc_url(home_url('/')) }}" class="btn btn-primary">{{ option("bouton") }}</a>
            </div>
        @endif

    </div>
</section>

@endsection