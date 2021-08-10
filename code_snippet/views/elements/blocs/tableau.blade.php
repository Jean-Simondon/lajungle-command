@if( isset($content) && VarHelper::goodArray($content) )
    @if( isset($content["tableau"]) )
        {!! do_shortcode( "[table id=" . $content["tableau"] . " /]" ) !!}
    @endif
@endif
