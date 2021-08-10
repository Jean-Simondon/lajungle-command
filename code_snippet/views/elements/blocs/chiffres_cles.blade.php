@if( isset($content) && VarHelper::goodArray($content) )

    {{-- Titre --}}
    @if( !empty($content["titre"]))
        {{ $content["titre"]}}
    @endif

    {{-- Répéteur --}}
    @if( VarHelper::goodKey($content, "chiffre-cle"))
        @if( VarHelper::goodArray($content["chiffre-cle"]))
            @foreach ($content["chiffre-cle"] as $cc)
                
                    {{-- Picto --}}
                    @if( $picture = VarHelper::goodKey( $cc, "picto" ))
                        <img {{ VarHelper::goodImage( $picture, "full" ) }}>
                    @endif

                    {{-- Chiffre --}}
                    @if( !empty($cc["numerique"]))
                        {{ $cc["numerique"] }}
                    @endif

                    {{-- suffixe --}}
                    @if( !empty($cc["alphabetique"]))
                        {{ $cc["alphabetique"] }}
                    @endif

                    {{-- texte --}}
                    @if( !empty($cc["description"]))
                        {{ $cc["description"] }}
                    @endif

            @endforeach
        @endif
    @endif


@endif