{{-- $exampleSLug initialisée dans FeatureViewComposer --}}
@if( isset($content) && VarHelper::goodArray($content) )

    {{-- Titre --}}
    @if( !empty($content["titre"]))
        {!! $content["titre"] . " " .  $content["taxo_name"] !!}
    @endif

    {{-- Répéteur --}}
    @if( !empty($content["actualites"]) && VarHelper::goodArray($content["actualites"]))
        @foreach ($content["actualites"] as $actualite)

            {{-- ouverture lien --}}
            <a href="{{ get_the_permalink($actualite->ID) }}">

                {{-- Image --}}
                <img style="height:200px;" {{ VarHelper::goodThumbnail( $actualite->ID, "full") }}>

                {{-- taxo --}}
                @if( !empty($actualite->type) )
                    {{ $actualite->type }}
                @endif

                {{-- Taxo --}}
                @if( !empty($actualite->pole) )
                    {{ $actualite->pole }}
                @endif

                {{-- Date --}}
                {{ get_the_date('d.m.Y', $actualite->ID) }}

                {{-- Titre --}}
                <h3>{!! get_the_title($actualite->ID) !!}</h3>

                
            </a> {{-- fermeture lien --}}

        @endforeach

        {{-- lien vers page d'archive --}}
        <a href="{{ get_post_type_archive_link( $exampleSlug ) }}"><button>Toutes les Examples</button></a>
    @endif

@endif