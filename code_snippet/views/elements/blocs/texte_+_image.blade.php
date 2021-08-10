@if( isset($content) && VarHelper::goodArray($content) )

    {{-- Gestion classe position image --}}
    @if( !empty($content["position"]) )
        @php $position_image = $content["position"] ? "class_css_image_a_droite" : "class_css_image_a_gauche"; @endphp
    @else
        @php $position_image = ""; @endphp
    @endif

    {{-- Container avec du reverse colonne si besoin --}}
    <div class="{{ $position_image }}">

        {{-- Image --}}
        @if( $picture = VarHelper::goodKey( $content, "image" ))
            <img class="{{ $position_image }}" {{ VarHelper::goodImage( $picture, "full" ) }}>
        @endif

        {{-- Texte --}}
        @if( !empty( $content["wysiwyg"]))
            {!! $content["wysiwyg"] !!}
        @endif

    </div>

@endif