# Pre-requis Linux & Mac
Avoir installé docker et docker-compose

# Pre-requis Windows
Avoir installer Linux WSL2 et DockerDesktop, puis sous WSL, docker et docker-compose.

# Utilisation

## Utilisateurs WSL, Linux, MAC

__Ce tp est fait pour fonctionner dans WSL (ou linux ou mac).__

## Utilisateurs Windows (cmd, powershell) (déconseillé)

erreur connue : "Error: No such container: –it" 

Lors du collage de la commande "docker exec –it php-mediatheque /bin/bash",

Windows remplace le tiret de la commande (tiret du 6) par un tiret long qui provoque le message d'erreur

Solution : Taper les commandes plutôt que les copier-coller.

# IDE (Integrated Development Environment) 

Use an IDE with css, twig, js, php, yaml, symfony extension.

For instance Visual Studio Code with following extensions:

* Twig
* Twig Langage
* Twig Langage 2
* Yaml
* PHP intellephense
* PHPDoc Comment
* Symfony for VSCode
* Javascript (ES6) code snippets
* HTML CSS Support

You can add also other usefull extension like WSL, Docker, VSCode Great Icon, Emmet live, Bracket Pair color, ...

To open the projetMediatheque with vscode, use in your WSL:

`code ProjetMediatheque`