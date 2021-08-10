{{-- $tabIcon initialisé dans le viewComposer --}}
@if (!empty($tabIcon))
    <div class="share-element js-section-share" data-icone-partage="{{ implode('-', $tabIcon) }}">
        <button class="share-title js-share-open-list"><span>Partager</span><i class="icon-share"></i></button>
        <div id="js-sharing_tools" class="share-list">
            {{-- ici, sera ajouté dynamiquement la classe jssocials --}}
            {{-- Lien générer par js --}}
        </div>
    </div>
    <div style="display: none;" id="js-email-content" data-email-content="{!! $email_content !!}">{{-- Garder vide et invisible, stock pour le contenu de l'email pour icone de partage au dessus --}}
    </div>
@endif
