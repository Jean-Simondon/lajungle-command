@extends('layouts.main')

@section('content')

    <div class="shell">
        
        {{ the_title() }}

        {{-- Titre, Image bannière et fil d'ariane --}}
        {{-- <div class="head-banner">
            @include( 'parts.banner-page-interne', [
                "title" => get_the_title(),
                "the_date" => get_the_date('d.m.Y'),
            ])
        </div> --}}

        {{-- Appel des modules --}}
        {{-- Placer le tempalte bloc_managment puis décomencer la ligne ci-dessous --}}
        {{-- @if( VarHelper::goodArray( get_field("modules") ))
            @include( 'parts.bloc_managment', ['blocs' => get_field("modules")] )
        @endif --}}

        {{-- Zone de rebond --}}
        {{-- Placer le template zone de rebond puis décomencer la ligne ci-dessous --}}
        {{-- @if( isset($examples) && VarHelper::goodArray($examples))
            @include( 'elements.blocs.zone_de_rebond', ['posts' => $examples] )
        @endif --}}

    </div>

@endsection