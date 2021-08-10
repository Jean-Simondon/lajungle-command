
@if( isset($example) && is_object($example))

    <a href="{{ get_the_permalink($example->ID) }}">

        {{-- Thumbnail --}}
        <img style="height:200px;" {{ VarHelper::goodThumbnail( $example->ID, "full") }}>

        {{-- transformé en 2 rubrique --}}
        @if( !empty($example->taxoExample) )
            {{ $example->taxoExample }}
        @endif

        {{-- la date --}}
        {{ get_the_date("d.m.Y", $example->ID ) }}

        <h3>{!! get_the_title($example->ID) !!}</h3>

    </a>

@endif