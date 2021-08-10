@if( isset($content) && VarHelper::goodArray($content) )

    @if (!empty($content["titre"]))
        {!! $content["titre"] !!}
    @endif

    @if( isset($content["vignette"]) && VarHelper::goodArray($content["vignette"]) )
        @foreach ($content["vignette"] as $vignette)

            {{-- Ouverture lien --}}
            @if( !empty($vignette["lien"]) ) <a href="{{ $vignette["lien"] }}"> @endif

                @if (!empty($vignette["titre"]))
                    {!! $vignette["titre"] !!}
                @endif
                
                @if (!empty($vignette["texte"]))
                    {!! $vignette["texte"] !!}
                @endif
                
                {{-- Image --}}
                @if( $picture = VarHelper::goodKey( $vignette, "vignette" ))
                    <img {{ VarHelper::goodImage( $picture, "full" ) }}>
                @endif

            {{-- Femerture lien --}}
            @if( !empty($vignette["lien"]) ) </a> @endif

        @endforeach
    @endif

@endif