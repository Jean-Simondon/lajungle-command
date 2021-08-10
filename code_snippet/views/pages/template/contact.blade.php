@extends('layouts.main')

@section('content')
    <div class="shell">

        {{-- Titre, Image bannière et fil d'ariane --}}
        <div class="head-banner">
            @include( 'parts.banner-page-interne', [ 'titre' => get_the_title() ])
        </div>

        {{-- Formulaire --}}
        @if( get_field("form-contact") && is_array(get_field("form-contact")) && isset(get_field("form-contact")['id']))
            {!! gravity_form( get_field('form-contact')['id'], false, false, false) !!}
        @endif

    </div>
@endsection