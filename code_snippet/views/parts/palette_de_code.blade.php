{{-- Une palette de code à copier coller pour aller plus vite --}}

{{-- BOUTON --}}
@if( $tab_bouton = VarHelper::goodKey( /* ici votre get_field('key') */ ))
    @if( VarHelper::goodKeys($tab_bouton, [ 'url', 'title', 'target' ]) )
        <a target="{{ $tab_bouton['target'] }}" href="{{ $tab_bouton['url'] }}">{{ $tab_bouton['title'] }}</a>
    @endif
@endif

{{-- Image --}}
@if( $picture = VarHelper::goodKey( /* ici votre get_field('key') */ ))
    <img style="height:200px;" {{ VarHelper::goodImage( $picture, "full" ) }}>
@endif

{{-- Thumbnail --}}
<img style="height:200px;" {{ VarHelper::goodThumbnail( get_the_ID(), "full") }}>

{{-- VIDEO --}}
@if ( VarHelper::goodKey($bloc, 'video') )
    <a class="thumbnail block-link js-reveal-video" data-iframe-src="{!! MediaHelper::youtubeLink($bloc['video'], true) !!}" href="#" >
        @if( $picture = VarHelper::goodArray( $bloc['vignette'] ))
            <img {{ VarHelper::goodImage( $picture, "full" ) }}>
        @endif
    </a>
@endif

{{-- FILE --}}
@if( VarHelper::goodKey($document['file'], 'link') )
    <a href="{{ $document['file']['link'] }}">Télécharger</a>
@endif

{{-- TITRE --}}
@if( !empty(get_field('value')))
    <h1>{{ get_field('value') }}</h1>
@endif

@if( !empty( $bloc['titre']))
    <h1>{{ $bloc['titre'] }}</h1>
@endif

{{-- TEXTE || TEXT AREA  --}}
@if( !empty(get_field('value')))
    <p>{!! get_field('value') !!}</p>
@endif

@if( !empty( $bloc['texte'] ))
    <p>{!! $bloc['texte'] !!}</p>
@endif




{{-- TEXTE WYSIWYG --}}
@if( !empty(get_field('value')))
    {!! get_field('value') !!}
@endif
@if( !empty( $bloc['texte'] ))
    <p>{!! $bloc['texte'] !!}</p>
@endif



{{-- GOOD ARRAY --}}
@if( VarHelper::goodArray($bloc) )

@endif



{{-- GOOD KEY --}}
@if( VarHelper::goodKey($bloc, 'key') )

@endif



{{-- SHORTCODE --}}
@if( !empty(get_field('shortcode_id')))
    {!! do_shortcode( get_field('shortcode_id') ) !!}
@endif
