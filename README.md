
# Lajungle-command

lajungle-command est un outil afin d'assister la réalisation de site web avec les framework de l'entreprise La Jungle Design tel que Iquitos ou Loreto
L'intérêt est de disposer de nombreuses commande au travers d'une interface graphique facilitant l'accès à ces outils, que ce soit des scripts maison ou des appels simplifié à des outils tel que wp-cli

Le tout est à ajouter à wp-cli comme dépendance afin de pouvoir l'utilitaire à l'aide de la comment wp run-forest

## Auteur

- [@jean Simondon](https://github.com/Jean-Simondon)

## FAQ


##### Ajouter un sous menu

    Pour ajouter un sous menu, il suffit de créer un nouveau répertoire dans le répertoire src/script/scripts_vendor/ . Il sera automatiquement visible dans l'interface quand le programme est lancé.
    L'interface aura alors la même architecture que l'arborescence de répertoire.

#### Ajouter un script    

    Pour ajouter un script, il faut placer son fichier en .php dans l'arboresrence de menu là où on veut le voir apparaitre.
    Il faut prendre exemple sur les autres script pour l'en tête du fichier.
    Le reste du script peut employer n'importe qu'elle instruction en PHP
    Il est aussi possible de faire appel à l'API Script qui facilite la tâche avec des fonctions toute prête.

#### installer en tant que package dans wp-cli.phar

    php wp-cli.phar package install jean-simondon/lajungle-command

### lancer la commande une fois le package installer dans wp-cli.phar 

    avec debug : php -d display_errors=1 wp-cli.phar run_forest
    sans debug : php wp-cli.phar run_forest

#### Compiler en phar

    Cette option date de lorsque l'outil était indépendant de wp-cli. IL est possible de compiler le tout en une archive .phar à l'aide de la commande suivante :

    php -d phar.readonly=off compile.php

    PS : Exécuter une première fois l'outil en passant par php src/index avant compilation pour vous assurer de générer le fichier private_constant.php
