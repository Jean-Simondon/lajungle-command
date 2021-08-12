@extends('layouts.main')

@section('content')

    <div class="shell">

        {{-- Image bannière et fil d'ariane --}}
        {{-- @include( 'parts.banner-page-interne', [
            "banner" => get_field("some_field_key", "params_example"),
        ]) --}}

        {{-- Class js-static-filter pour dire au JS que l'on ne refresh que sur clic du bouton validation --}}
        <div class="js-static-filter">

            {{-- rechercher par mots clef --}}
            <input autocomplete="off" class="js-keyword-filter" type="text" name="search-by-name" placeholder="Recherche par mot clés..." id="search-by-name">
            <button class="js-validator-keyword">Rechercher</button>

            {{-- Filtre sur les example --}}
            {{-- @if( isset($example_filter) && VarHelper::goodArray($example_filter) )
                <select class="js-example-filter" name="example-selector">
                    <option class="active" value="all">Tous les Example</option>
                    @foreach ($example_filter as $example)
                        <option value="{{ $example->slug }}">{{ $example->name }}</option>
                    @endforeach
                </select>
            @endif --}}

        </div>

        {{-- Valider les champs select --}}
        <button class="js-validator-filter">Valider</button>

        {{-- Liste d'example --}}
        <div class="js-list-container">
            @if( isset($examples) && VarHelper::goodArray($examples) )
                @foreach ($examples as $example)
                    @include( "elements.card-example", [ "example" => $example, "loopIndex" => $loopIndex ])
                @endforeach
            @endif
        </div>

        {{-- Répéteur de popin pour chacune --}}
        <div class="js-popin-container">
            @if( isset($examples) && VarHelper::goodArray($examples) )
                @foreach ($examples as $example)
                    @include("elements.popin-example", [ 'example' => $example, "loopIndex" => $loopIndex] )
                @endforeach
            @endif
        </div>

        {{-- Pagination --}}
        <div class="js-pagination-container">
            @if( !empty($pagination))
                {!! $pagination !!}
            @endif
        </div>

        {{-- Ancre javascript pour stock de données --}}
        <div style="display: none;"
            data-action="liste"
            data-method="getexample"
            @if( isset($ppp) ) data-ppp="{{ $ppp }}" @endif
            @if( isset($examples) ) data-offset="{{ count( $examples ) }}" @endif
            class="js-ajax-anchor">
        </div>

    </div>

@endsection