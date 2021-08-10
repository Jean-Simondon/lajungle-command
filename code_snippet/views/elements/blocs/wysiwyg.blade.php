@if ( isset($bloc) && VarHelper::goodArray($bloc))
    @if( !empty( $bloc['wysiwyg'] ))
        <section class="section section-wysiwyg">
            {!! $bloc['wysiwyg'] !!}
        </section>
    @endif
@endif