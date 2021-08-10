@extends('layouts.main')

@section('content')

    <div class="shell">

        {{-- Titre, Image bannière et fil d'ariane --}}
        @include( 'parts.banner-page-interne', [ 'titre' => get_field("titre", "params_example") ])

        @if( !isset($examples) && VarHelper::goodArray($examples) )
            @foreach ($examples as $example)
                @include( 'elements.card-examples', [ 'example' => $example ])
            @endforeach
        @endif
        
    </div>

@endsection