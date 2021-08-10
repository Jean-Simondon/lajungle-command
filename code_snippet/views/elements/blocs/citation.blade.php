@if( isset($content) && VarHelper::goodArray($content) )

    {{-- Texte --}}
    @if ( !empty($content["citation"]) )
        {{ $content["citation"] }}
    @endif

    @if( isset($content["auteur"]) && is_object($content["auteur"]) )

        @if(has_post_thumbnail( $content["auteur"]->ID, 'full'))
            <img style="height:200px;" {{ VarHelper::goodThumbnail( $content["auteur"]->ID, "full") }}>
        @endif

        @if( get_the_title($content["auteur"]->ID))
            <h3>{!! get_the_title($content["auteur"]->ID) !!}</h3>
        @endif

        @if( get_field("fonction", $content["auteur"]->ID))
            <p>{{ get_field("fonction", $content["auteur"]->ID) }}</p>
        @endif

        @if( get_field("linkedin", $content["auteur"]->ID))
            <a href="{{ get_field("linkedin", $content["auteur"]->ID) }}">Linkedin</a>
        @endif

        @if( get_field("mail", $content["auteur"]->ID))
            <a href="mailto:{{ get_field("mail", $content["auteur"]->ID) }}">Mail</a>
        @endif

    @endif

@endif