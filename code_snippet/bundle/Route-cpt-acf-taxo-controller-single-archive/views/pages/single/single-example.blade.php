@extends('layouts.main')

@section('content')

    <div class="shell">
        
        {{-- Titre, Image bannière et fil d'ariane --}}
        <div class="head-banner">
            @include( 'parts.banner-page-interne', [
                "title" => get_the_title(),
                "the_date" => get_the_date('d.m.Y'),
            ])
        </div>

        {{-- Appel des modules --}}
        @if( VarHelper::goodArray( get_field("modules") ))
            {{-- Placer le tempalte bloc_managment puis décomencer la ligne ci-dessous --}}
            {{-- @include( 'parts.bloc_managment', ['blocs' => get_field("modules")] ) --}}
        @endif

        {{-- Zone de rebond --}}
        @if( isset($examples) && VarHelper::goodArray($examples))
            {{-- Placer le tempalte zone de rebond puis décomencer la ligne ci-dessous --}}
            {{-- @include( 'elements.blocs.zone_de_rebond', ['posts' => $examples] ) --}}
        @endif

    </div>

@endsection