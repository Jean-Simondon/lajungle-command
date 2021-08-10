@extends('layouts.main')

@section('content')
    <div class="shell">

        @include( 'parts.banner-page-interne', [
                'titre' => get_the_title()
                ])

        {{-- Appel des modules --}}
        @if( VarHelper::goodArray( get_field("modules") ))
            @include( 'parts.bloc_managment', ['blocs' => get_field("modules")] )
        @endif

    </div>
@endsection