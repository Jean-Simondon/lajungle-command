@extends('layouts.main')

@section('content')

    <div class="shell">

        {!! get_the_title() !!}

        {{-- Appel des modules --}}
        @if( VarHelper::goodArray( get_field("modules") ))
            {{-- Placer le tempalte bloc_managment puis décomencer la ligne ci-dessous --}}
            {{-- @include( 'parts.bloc_managment', ['blocs' => get_field("modules")] ) --}}
        @endif

        {{-- Zone de rebond --}}
        @if( isset($actualites) && VarHelper::goodArray($actualites))
            {{-- Placer le tempalte zone_de_rebond puis décomencer la ligne ci-dessous --}}
            {{-- @include( 'elements.blocs.zone_de_rebond', ['posts' => $actualites] ) --}}
        @endif

    </div>

@endsection