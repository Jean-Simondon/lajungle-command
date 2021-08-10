
# LJD CLI

LJD CLI est un outil afin d'assister la réalisation de site web avec les framework de l'entreprise La Jungle Design tel que Iquitos ou Loreto
L'intérêt est de disposer de nombreuses commande au travers d'une interface graphique facilitant l'accès à ces outils, que ce soit des scripts maison ou des appels simplifié à des outils tel que wp-cli
Le tout est compilé en une archive phar, donc un seul et même fichier, qu'il suffira de dépôser à la racine de son projet et de lancer en ligne de commande

## Auteur

- [@jean Simondon](https://github.com/Jean-Simondon)

## FAQ

#### Compiler en phar

    php -d phar.readonly=off compile.php

    PS : Exécuter une première fois l'outil en passant par php src/index avant compilation pour vous assurer de générer le fichier private_constant.php

#### Mode d'emploi

    Placer le fichier à la racine d'un projet (même projet vierge) et lancer php ljd.phar

#### Exécuter avant compilation

    php src/index

#### Exécuter avant compilation et en affichant les erreurs
  
    php -d display_errors=1 src/index

#### Développer sur le projet:

##### Ajouter un sous menu

    Pour ajouter un sous menu, tout se passe dans src/config/config-menu
    Choisissez le fichier qui doit logiquement déclarer votre sous menu, puis placer sa variable de retour dans le tableau "submenus" du menu parent
    actuellement :
        all_menu =>

##### Ajouter une option à un menu

    L'option se déclare dans src/config-script/scripts_****.php
    ensuite, la variable sera à insérer dans l'entrée "scripts" du menu de votre choix
    Il faut bien sûr créer le script qui correspond

##### Ajouter un script

    Il suffit de déposer un fichier en .php dans l'arborescence de répertoire dont la racine est scripts > scripts_vendor

#### installer en tant que package dans wp-cli.phar

    php wp-cli.phar package install jean-simondon/lajungle-command

### lancer la commande une fois le package installer dans wp-cli.phar 

    avec debug : php -d display_errors=1 wp-cli.phar run_forest
    sans debug : php wp-cli.phar run_forest
