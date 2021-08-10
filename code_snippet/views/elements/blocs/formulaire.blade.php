@if( isset($content) && VarHelper::goodArray($content) )

    @if( !empty($content["titre"]))
        {{ $content["titre"] }}
    @endif
   
    @if ( $content["form-candidature"])
        {!! gravity_form( $content["form-candidature"]['id'] ,false, false, false ) !!}     
    @endif

@endif