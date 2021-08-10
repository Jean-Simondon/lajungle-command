@if( isset($example) && is_object($example))
    <a href="{{ get_the_permalink($example->ID) }}">

        <h3>{!! get_the_title($example->ID) !!}</h3>

        @if( !empty( $example->extrait ))
            <p>{!! $example->extrait !!}</p>
        @endif

        <img style="height:200px;" {{ VarHelper::goodThumbnail( $example->ID, "full") }} >

        {{ get_the_date('d.m.Y', $example->ID) }}

    </a>
@endif
