
{{-- Titre --}}
    @if( !empty( $titre ))
        <h1>{!! $titre !!}</h1>
    @endif

    {{-- Image bannière --}}
    @if(has_post_thumbnail(get_the_ID(), 'full'))
        <figure>
            <img src="{!! get_the_post_thumbnail_url(get_the_ID(), 'full') !!}" alt="">
    @else
        @if(file_exists(themosis_path('sub-theme').'resources/assets/images/placeholder.png'))
            <img src="{{ iquitheme_assets().'/images/placeholder.png' }}" alt="">
        @endif
        </figure>
    @endif

{{-- Fil d'ariane --}}
{!! BreadcrumbHelper::breadcrumb() !!}