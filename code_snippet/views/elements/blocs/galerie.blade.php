@if( isset($content) && VarHelper::goodArray($content) )

    @if( $slides = VarHelper::goodKey($content, "galerie"))

        @foreach ($slides as $slide)
            
            @if( isset($slide["photo-video"]) && $slide["photo-video"] )

                {{-- Photo --}}
                @if( $picture = VarHelper::goodKey( $slide, 'photo' ))
                    <img {{ VarHelper::goodImage( $picture, "full" ) }}>
                @endif

            @else

                {{-- Video --}}
                @if ( VarHelper::goodKey($slide, 'video') )
                    {{-- VIDEO EN BACKGROUND --}}
                    <a class="thumbnail block-link js-reveal-video" data-iframe-src="{!! MediaHelper::youtubeLink($slide['video'], true) !!}" href="#" >
                        {{-- VIGNETTE --}}
                        @if( $picture = VarHelper::goodArray( $slide['photo'] ))
                            <img {{ VarHelper::goodImage( $picture, "full" ) }}>
                        @endif
                    </a>
                @endif

            @endif

            {{-- la légende  --}}
            @if( !empty($slide["legende"]))
                {{ $slide["legende"]}}
            @endif
        
        @endforeach

    @endif



@endif