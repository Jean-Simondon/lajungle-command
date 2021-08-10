@if( isset($bloc) && VarHelper::goodArray($bloc) )
    <section class="section section-map">
        @if( $adresse = VarHelper::goodKey($bloc, 'adresse') )
            @if( !empty($adresse["lat"]) && !empty($adresse["lng"]))
                <div class="acf-map" data-zoom="16">
                    <div class="marker" data-lat="{{ esc_attr( $adresse['lat']) }}" data-lng="{{ esc_attr( $adresse['lng']) }}"></div>
                </div>
            @endif
        @endif
    </section>
@endif