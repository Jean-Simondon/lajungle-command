@if( isset($content) && VarHelper::goodArray($content) )

    {{-- titre --}}
    @if( !empty($content["titre"]))
        <h1>{!! $content["titre"] !!}</h1>
    @endif

    {{-- Texte --}}
    @if( !empty($content["texte"]))
        <p>{{ $content["texte"] }}</p>
    @endif

    {{-- Bouton --}}
    @if( $tab_bouton = VarHelper::goodKey( $content, 'bouton' ))
        @if( VarHelper::goodKeys($tab_bouton, [ 'url', 'title', 'target' ]) )
            <a target="{{ $tab_bouton['target'] }}" href="{{ $tab_bouton['url'] }}">{{ $tab_bouton['title'] }}</a>
        @endif
    @endif

    {{-- Image de background --}}
    @if( $picture = VarHelper::goodKey( $content, 'full' ))
        <img {{ VarHelper::goodImage( $picture, "full" ) }}>
    @endif

@endif