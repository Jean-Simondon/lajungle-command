@extends('layouts.main')

@section('content')

    <div class="shell">
        
        {{-- Titre, Image bannière et fil d'ariane --}}
        @include( 'parts.banner-page-interne', [ 'titre' => get_the_title() ])


        

    </div>

@endsection