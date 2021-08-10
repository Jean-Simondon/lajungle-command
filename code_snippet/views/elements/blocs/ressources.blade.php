@if( isset($content) && VarHelper::goodArray($content) )

    @if( !empty( $content["titre"]))
        {!! $content["titre"] !!}
    @endif

    {{-- Appel des card ressource --}}
    @if( isset($content["ressources"]) && VarHelper::goodArray($content["ressources"]) )
        @foreach ($content["ressources"] as $ressource)
            @include("elements.card-ressource", [ 'ressource' => $ressource ])
        @endforeach
    @endif

    {{-- Appel des popins --}}
    @if( isset($content["ressources"]) && VarHelper::goodArray($content["ressources"]) )
        @foreach ($content["ressources"] as $ressource)
            @include("elements.popin-ressource", [ 'ressource' => $ressource ])
        @endforeach
    @endif

@endif