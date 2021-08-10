@if( isset($content) && VarHelper::goodArray($content) )

    @if ( !empty($content["titre"]))
        {!! $content["titre"] !!}
    @endif

    @if( isset($content["apparence"]) && $content["apparence"])

        {{-- Integration pour design de bloc "Auteurs" --}}
        @if( isset($content["personnes"]) && varHelper::goodArray($content["personnes"]) )
            @foreach ($content["personnes"] as $personne)

                @if(has_post_thumbnail($personne->ID, 'full'))
                    <img style="height:200px;" {{ VarHelper::goodThumbnail( $personne->ID, "full") }}>
                @endif

                @if( get_the_title($personne->ID) )
                    <h3>{!! get_the_title($personne->ID) !!}</h3>
                @endif

                @if( get_field("fonction", $personne->ID))
                    <p>{{ get_field("fonction", $personne->ID) }}</p>
                @endif

                @if( get_field("linkedin", $personne->ID))
                    <a href="{{ get_field("linkedin", $personne->ID) }}">Linkedin</a>
                @endif

                @if( get_field("mail", $personne->ID))
                    <a href="mailto:{{ get_field("mail", $personne->ID) }}">Mail</a>
                @endif

            @endforeach
        @endif

    @else

        {{-- Integration pour design de bloc "Equipe" --}}
        @if( isset($content["personnes"]) && varHelper::goodArray($content["personnes"]) )
            @foreach ($content["personnes"] as $personne)
                    
                @if(has_post_thumbnail($personne->ID, 'full'))
                    <img style="height:200px;" {{ VarHelper::goodThumbnail( $personne->ID, "full") }}>
                @endif

                @if( get_the_title($personne->ID) )
                    <h3>{!! get_the_title($personne->ID) !!}</h3>
                @endif

                @if( get_field("fonction", $personne->ID))
                    <p>{{ get_field("fonction", $personne->ID) }}</p>
                @endif

                @if( get_field("linkedin", $personne->ID))
                    <a href="{{ get_field("linkedin", $personne->ID) }}">Linkedin</a>
                @endif

                @if( get_field("mail", $personne->ID))
                    <a href="mailto:{{ get_field("mail", $personne->ID) }}">Mail</a>
                @endif

            @endforeach
        @endif

    @endif

@endif