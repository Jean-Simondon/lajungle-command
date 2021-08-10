@if( isset($post) && is_object($post))

    {{-- Thumbnail --}}
    @if(has_post_thumbnail( $post->ID ,'full'))
        <img style="height:200px;" {{ VarHelper::goodThumbnail( $post->ID, "full") }}>
    @endif

    @if( !empty($post->taxoThemeActu) )
        {{ $post->taxoThemeActu }}
    @endif
    @if( !empty($post->taxoPole) )
        {{ $post->taxoPole }}
    @endif

    {{-- la date --}}
    {{ get_the_date("d.m.Y", $post->ID ) }}

    {{-- le titre --}}
    <h3>{!! get_the_title($post->ID) !!}</h3>

@endif