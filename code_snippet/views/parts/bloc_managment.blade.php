@if( !empty($blocs) )
    @foreach( $blocs as $bloc )
        @if( !empty($bloc['acf_fc_layout']) )
            @switch( $bloc['acf_fc_layout'] )

                @case( 'zone_de_rebond' )
                    @include( 'elements.blocs.zone_de_rebond', ['content' => $bloc] )
                @break

                @case( 'wysiwyg' )
                    @include( 'elements.blocs.wysiwyg', ['content' => $bloc] )
                @break

                @default
                @break

            @endswitch
        @endif
    @endforeach
@endif
