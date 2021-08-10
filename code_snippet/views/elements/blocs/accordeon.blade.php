@if( isset($content) && VarHelper::goodArray($content) )

    {{-- Répéteur  --}}
    @if( isset($content["accordeon"]) && VarHelper::goodArray($content["accordeon"]) )
        @foreach ($content["accordeon"] as $item)

            {{-- titre --}}
            @if (!empty($item["titre"]))
                {!! $item["titre"] !!}
            @endif
            
            {{-- Texte --}}
            @if (!empty($item["texte"]))
                {!! $item["texte"] !!}
            @endif

        @endforeach
    @endif

@endif
