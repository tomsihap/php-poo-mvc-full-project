# TP : Créer un projet en MVC avec PHP

## 1. Présentation du projet
Un projet en MVC est composé de plusieurs éléments :

### Les éléments de MVC
- Des **Models**, qui sont des classes qui schématiseront nos tables en base de données. Leur rôle est de contenir des données, comme des arrays mais en mieux grâce aux méthodes qu'on peut rajouter, aux typages qu'on peut donner à nos données, etc !
- Des **Vues**, qui sont les pages qui afficheront des données mais sans faire de travail dessus : en effet, leur rôle n'est que d'afficher les données qui auront déjà été traitées ailleurs dans notre code.
- Des **Controllers**, qui servent à faire le lien entre les Models et les vues (en effet, le Model ne sert pas à l'affichage, la vue ne récupère pas de données... Il faut un lien entre les deux !)

### Les outils en plus
- Des classes **services**, de faire du traitement de données (les récupérer en base de données, travailler dessus, les traduire si besoin...)
- Un **routeur**, qui sert à lire l'URL donnée par l'utilisateur, et appeler le bon Controller au bon moment.


## 2. Comment fonctionne un projet MVC ?

Voyons concrètement comment un projet en MVC s'exécute :

1. **Une requête HTTP** : l'utilisateur va sur une page, un formulaire est envoyé... Par exemple : `example.com`, `example.com/home`, `example.com/users/`, `example.com/articles/3`

> Bon, et comment on gère ces URL au juste ? On ne voit aucun fichier `*.php` ni `*.html` dans l'URL, comment on fait pour gérer ces pages ?!

2. **Un routeur** : c'est un outil qui nous permet de lire l'URL et de choisir en fonction l'action à faire. Ça veut dire que dorénavant, on n'utilisera plus de fichiers PHP qui seront directement ouverts par l'utilisateur (comme `battle.php`, `show.php`, `form.php`, `list.php`...). En fait, le routeur va lire l'URL (exemple : `example.com/users`) et gérer l'action à faire (`"afficher la page de liste des utilisateurs"`).

3. **Un Controller** : Bon, comment le routeur gère "l'action à faire" ? En fait, le routeur est un petit fichier à qui on dit : "si l'utilisateur va **ici**, va dans **cette méthode de cette classe** pour faire l'action". Et cette fameuse classe... C'est le Controller. C'est une classe qui contient plusieurs méthodes, une par page en général. Ces méthodes, en général, vont : a. récupérer les données si besoin, b. appeler la page template qui correspond, c'est un des fichiers qui contient du HTML.

4. **Un Model** : C'est notre classe qui représente les données. Le Controller demande au Model les données nécessaires pour la page qui lui a été demandée par le routeur.

5. **Une Vue** : C'est le template ! C'est le seul fichier qui contiendra du HTML. Le Controller, qui a récupéré les données auprès du Model, envoie les données à la Vue qui les affiche enfin.

6. Un peu partout... **Des services**. Eux, ils restent là. On en a encore besoin de partout ! Enfin plus exactement, c'est le Controller qui appellera des services quand il en aura besoin.

## Un projet MVC en pratique
Les étapes dans un cas d'exemple :

1. L'utilisateur va sur `example.com/users`
2. Dans le fichier routeur, on aura écrit que d'aller sur `/users`, ça correspond à actionner la méthode de `list()` de `UsersController` (ou autrement dit : `UsersController::list()`).
3. `UsersController()`, ou plutôt sa méthode `list()`, aura besoin de récupérer la liste des Users. On fera appel à un service, gérés par un service container, par exemple: `$container->getUsersManager()->findAll()`, qui nous retourne un tableau d'objets `User`.
4. Ensuite, après les traitements éventuels effectués sur la liste de `User` (`$users`), il faut afficher la page : on affiche le fichier `Vue`, qui peut être par exemple `templates/users/list.php` et qui a besoin d'une variable `$users` pour fonctionner (eh oui, notre vue ne sert qu'à afficher des users, pas à les récupérér au préalable).

# Créer le projet

> Vous allez créer un système de location de voitures. Les fonctionnalités seront :
> - CRUD voitures
> - CRUD utilisateurs
> - CRUD locations (un utilisateur loue une voiture)
> - Système de connexion
> - Système de rôles (rôle Administrateur, rôle Conducteur, rôle Loueur)

## 1. Structurer le projet
Créez la structure de projet suivante :
```bash
/hb-locatcars                       # Le projet
    /config                         # Fichiers de configuration
        config.php                  # Configuration générale
        routes.php                  # Les routes
    /src                            # Les classes du projet
        /service                    # Les services
            ServiceContainer.php    # Le Service Container
        /model                      # Les Models
        /controller                 # Les Controllers
    /template                       # Les Vues
    index.php                       # La porte d'entrée de notre application
```

### Github !
C'est le moment de mettre votre projet sur Github ! Pour cela : créez un nouveau repository sur Github (https://github.com/new), idéalement en public pour montrer au monde vos nouvelles oeuvres. Une fois créé, une page apparaît avec les rubriques suivantes :

- Quick setup — if you’ve done this kind of thing before
  - *Dedans, vérifiez que vous avez bien coché HTTP ! On apprendra SSH plus tard.*
- …or create a new repository on the command line
  - *Rien d'intéressant pour nous ici*
- …or push an existing repository from the command line
  - *Dedans, copiez-collez la ligne qui commence par `git remote add origin https://...`*
- …or import code from another repository
  - *Rien d'intéressant pour nous ici*

Dans votre projet, ouvrez un terminal **EXACTEMENT** dans le dossier du projet (**VÉRIFIEZ** votre VSCode ! Il ne doit PAS être ouvert dans un dossier au dessus ou en dessous, il ne doit y avoir QUE le projet `hb-locatcars` et rien d'autre du tout !).
Le terminal ouvert, saisissez :
```bash
git init
git remote add origin https://.... # La ligne copiée collée
```

### Que...quoi ?
`git init` sert à indiquer à notre projet qu'il sera versionné. En fait, on peut utiliser Git sans Github ! Une fois `git init` de tapé, on est déjà capables de faire des commits. Mais sans `remote`, on ne pourra pas les envoyer en ligne.

`git remote add origin https://....` ajoute justement une `remote`. C'est l'URL du serveur vers lequel envoyer nos commits quand on fait un `push`.

Et c'est tout ! Vous êtes dorénavant capables de faire des commits dans votre projet. Pour cela, deux choix :

1. **VSCode :** sur le côté, vous avez une icône, la troisième en général, qui correspond au versionning. Cliquez dessus. Pour faire un commit : saisissez quelque chose dans le champ `Message` puis tapez `Ctrl+Entrée` (ou `Cmd+Entrée` sous Mac). Validez les fenêtres éventuelles qui peuvent apparaître (en cliquant sur `Yes/Always/Toujours` quand c'est possible). Votre commit est fait ! Pour pusher (envoyer sur le serveur), vous devez cliquer sur l'icône située à droite de `master`, tout en bas à gauche de VSCode. Ça peut être selon l'état du projet ou la version de VSCode un petit nuage ou une roue, ou des flèches haut/bas ou en rond... Dans tous les cas, survolant la souris dessus, ça doit indiquer "synchronize changes".


2. **Terminal :** Dans le terminal, saisissez :
```bash
git add -A # Ajout de tous les fichiers au commit
git commit -m "Message du commit"
git push
```

## 2. Utiliser Composer pour installer un routeur
Dans notre projet, nous voudrons accéder aux pages en indiquant une URL "REST", c'est à dire qui représente nos données, sans indiquer de fichier en particulier. C'est exactement comme on peut trouver dans des API REST : en allant sur `/users/2`, on accède à l'utilisateur #2, sans savoir si il y a un fichier `users.php`, `listUsers.php` ou quoi que ce soit d'appelé. L'idée est d'avoir des URL propres et prévisibles !

Pour cela, on va utiliser un routeur : on déclarera des routes, c'est à dire des chemins d'URL, et on indiquera grâce au routeur quel fichier/classe/méthode sera utilisé réellement.

Plutôt que de réinventer la roue, on va utiliser un gestionnaire de dépendances pour utiliser une librairie déjà existante ! Comme `npm` avec Javascript, on utilisera `Composer` pour PHP. La liste des packages existants est disponible sur `packagist.org`. Recherchez le routeur `bramus router`.

Dans la documentation, on voit comment l'installer : on a besoin de l'outil Composer, puis de saisir dans la console : `composer require bramus/router ~1.4` :

### Installer Composer
L'installateur de Composer est disponible sur https://getcomposer.org/download/. Une fois installé, ouvrez un terminal et saisissez `composer --version` pour vérifier si Composer a bien été installé !

### Installer le routeur
Maintenant que Composer est installé, ouvrez un terminal **DANS le dossier du projet** (c'est à dire : pas dans un dossier au dessus ni en dessous ni ailleurs !). Dans notre structure de projet par exemple, notre terminal est situé dans `hb-locatcars`.

> Rappels terminal : pour lister les fichiers dans lequel je suis : `ls` (`ls -alh` pour plus de détails). Pour aller dans un dossier : `cd nomDuDossier` (ou encore `cd ..` pour remonter d'un dossier au dessus).

Une fois sûrs de vous, tapez dans la console la ligne indiquée dans la rubrique Installation sur la page du routeur sur Packagist.org (en ce moment : `composer require bramus/router ~1.4`). 

> Rappels SemVer : les versions sont en notation SemVer (Semantic Versionning) : https://putaindecode.io/articles/semver-c-est-quoi/

### Utiliser des packages issus de Composer
Comment fonctionne Composer ? Si on regarde notre projet, on voit :

- un nouveau dossier : `vendor`. C'est en fait ici où sont installées les dépendances venues de Composer !
- un nouveau fichier : `composer.json`. C'est un fichier qui contient la liste des dépendances requises pour utiliser notre projet. 
- un autre fichier : `composer.lock`. C'est un fichier qui sert au fonctionnement de Composer, qui lui indique quelles sont les dépendances actuellement installées et dans quelles versions, pour savoir s'il doit les mettre à jour ou non. À ne jamais modifier à la main !

**IMPORTANT** Nous voulons dire à Git que nous ne voulons pas commiter ce projet. C'est super important ! Les dépendances pouvant contenir plusieurs centaines de milliers de fichiers selon la taille du projet, on a aucune envie de les commiter : non seulement ce serait terriblement long à uploader, mais en plus c'est redondant, car la liste des dépendances existe dans `composer.json`. Si on veut récupérer le projet, il nous suffira alors de faire simplement `composer install` pour réinstaller les dépendances dans `vendor` !

Pour dire à Git d'éviter ce dossier, créez à la racine du projet un fichier `.gitignore`. Dedans, saisissez simplement `/vendor`. Normalement, il devrait se griser dans VSCode : ça nous indique que le dossier ne sera pas commité. Parfait !

C'est le moment parfait pour faire un nouveau commit. Nommez le par exemple `Add router dependancy to Composer : bramus/router`.

### Dire à notre projet que nous utilisons des packages venus de Composer
Notre routeur est enfin installé. Parfait ! Maintenant, comment l'utiliser en pratique dans notre projet ? Il va falloir l'importer dans nos fichiers. En fait, on va trouver une solution élégante pour ne pas avoir à `require_once` toutes les classes importées avec Composer (on en aurait plusieurs milliers à faire sinon !).

La solution : Composer vient avec un Autoloader. C'est un fichier qui sert à charger automatiquement toutes les classes, par défaut celles du dossier `vendor` mais aussi les notres, comme on verra plus tard. Pour l'instant, on ne souhaite qu'importer les classes de `vendor`.

Comme on ne veut pas polluer notre `index.php` avec de la configuration, on va gérer ça dans `config.php`:

```php
// index.php
require_once __DIR__ . '/config/config.php';
```

```php
// config.php
require_once __DIR__ . '/../vendor/autoload.php';
```

Et voilà, pour le moment... C'est tout !

## 3. Utiliser notre routeur
Notre routeur fonctionne ainsi : on déclare une "route" (c'est à dire une URL), et on indique l'action à effectuer quand cette route est tappée par un utilisateur.

Pour déclarer nos routes, on va utiliser un fichier dédié pour cela, c'est plus pratique ! Ce fichier, c'est `config/routes.php`.

Comme on aura besoin de nos routes dans tous le projet, on commence par importer le fichier dans `config.php` :

```php
// config.php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/routes.php';    
```

Comme ça, en allant dans `index.php` : on importe `config.php`, qui lui importe les classes avec `autoload.php`, et notre liste de routes avec `routes.php`.

### Un fichier .htaccess
Avant toute chose, on va devoir faire une petite modification technique : jusque-là, on a vu que Apache lisait l'URL et retournait le fichier demandé (`example.com`, `example.com/users/list.php`...). Maintenant, en utilsiant un routeur, on va faire un truc un peu bizarre : dans tous les cas (que ce soit `example.com`, `example.com/users`, `example.com/cars/3`...) l'utilisateur ira sans le savoir vers `index.php`, qui appelera le routeur, qui ensuite effectuera l'action.

Il va falloir dire à Apache comment gérer nos nouvelles URL (on appelle ça l'URL Rewriting). Pour ça, on va utiliser un fichier `.htaccess`: c'est une liste d'instructions spécifiques à notre projet. Ajoutez à la racine du projet le fichier suivant (**n'oubliez pas le "point" dans le nom de fichier !**) :

`.htaccess`
```bash
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php [L]
```

> Ça semble être un moment idéal pour faire un commit, par exemple appelé "Add htaccess for URL Rewriting".

## 4. Nos premières routes
> Vérifiez bien que vos fichiers soient bien tous sauvegardés (et éventuellement commités) : à partir de maintenant, on va utiliser des fonctions avancées de l'éditeur de texte qui vont nous faciliter la vie, mais il va falloir faire preuve de beaucoup de rigueur.

Testons tout cela ! Avant toute chose : **UTILISEZ L'AUTO-COMPLÉTION !** C'est vraiment obligatoire en POO. En fait, on va commencer à taper le nom de nos classes, et l'éditeur de code va rajouter des bouts de code super utiles. Donc en étant vigileants, dans `routes.php`, commencez à saisir :

```php
// routes.php
<?php

$router = new Router;
```

Normalement, en tappant les premières lettres de `Rout...`, une fenêtre d'autocomplétion vous proposait une classe `Router`. Utilisez-la ! Quand la fenêtre apparaît, séléctionnez la classe voulue avec les flèches du clavier si nécessaire, et appuyez sur `Entrée` ou `Tab`.

Si les choses ont bien fonctionné, vous devriez avoir la ligne `use Bramus\Router\Router;` qui a apparu. Appelez-moi immédiatement si ça n'a pas fonctionné avant de poursuivre.

### Écrire une route
Commençons tout de suite ! Créons une première route, par exemple `/hello`, ce qui correspond à, par exemple, quelque chose comme `http://localhost:8000/projets/hb-locatcars/hello` (votre dossier projet + la route). En prod, ça représenterait `example.com/hello`.

Dans `routes.php` :

```php
use Bramus\Router\Router;

$router = new Router;

// Quand je vais sur "/hello", j'effectue l'action suivante, qui est définie
// dans la fonction anonyme notée juste après : function() { /* action */ } 
$router->get('/hello', function() { 
    echo "Hello world !";
});

$router->run(); # À ne jamais oublier sinon le routeur ne se lance pas !
```
Testez ! Allez sur l'URL `/hello` et vérifiez que `Hello world!` s'affiche.

### Oulà, qu'est-ce qu'il vient de se passer au juste ?

Bon, voilà un comportement curieux. On est allé sur `/hello` (qui n'est pas `hello.php`) et quelque chose s'est affiché. Encore une fois, `hello.php` n'existe pas.

- En fait, l'application est allée dans `index.php`. Ce fichier appelle juste la configuration `config.php`.
- Dans la configuration, on demande d'importer toutes les classes installées avec Composer (dont notre router)
- Et notre fichier contenant nos routes, `routes.php`.
- Dans notre fichier de routes, on a dit : "lorsque l'utilisateur va sur notre site, sur le chemin `/hello`, fais quelque chose".
- Ce quelque chose, c'est : `echo "Hello world";` !

Dorénavant, on ne va plus coder comme avant, avec une page par URL, mais on va déclarer nos routes dans un fichier qui jouera le chef d'orchestre en indiquant quelle route fait quoi : notre routeur va être au centre de l'application !

## 5. Le service container et les namespaces
Un autre point de configuration : les namespaces. On va vu que l'autoloader de Composer importait les classes très facilement, nous n'avons eu qu'à require l'autoloader et les classes sont d'elle-mêmes importées.

Pour l'exemple, on va créer notre Service Container : en effet, nous avons utilisé notre routeur tel quel mais normalement, c'est le rôle du containeur de services de nous donner le routeur, et pas à nous de faire `new Router`.

Ce serait super de pouvoir faire exactement la même chose avec les classes de notre création ! Et c'est ce que nous allons faire. En fait, nous allons utiliser l'autoloader de Composer pour importer nos classes **partout** dans le projet sans avoir à les `require` à la main !

> Rappel : les normes PSR (PHP Standard Recommandations) : https://www.php-fig.org/psr/

Pour cela, nous utiliserons une norme PSR-4 qui nous permet d'importer nos classes automatiquement via un autoloader. Ça demande un peu de rigueur, mais ça nous évite de la configuration (`Convention Over Conviguration`, "la convention avant la configuration").

En fait, on va dire à PHP que nos classes se situent toutes dans des sortes de dossiers virtuels. Pourquoi virtuels ? Parce que mon chemin vers ma classe peut être autant `src/service/ServiceController.php` que `lib/services/ServiceController.php` que `libraries/classes/ServiceController.php`, pour PHP, je veux que le chemin soit toujours le même, disons `App/Service/ServiceContainer`.

On commence par expliquer ces chemins-là à PHP en modifiant le fichier `composer.json` ainsi (attention, pas de commentaires possibles dans un fichier json):

```json
{
    "require": {
        "bramus/router": "^1.4",
        "twig/twig": "^3.0"
    },

    "autoload": {
        "psr-4": {
            "App\\": "src/",
            "Controller\\": "controller/",
            "Model\\": "model/"
        }
    }
}
```

J'indique que, pour PHP :
- mon dossier `src` sera virtuellement nommé `App`
- mon dossier `controller` sera virtuellement nommé `Controller`
- mon dossier `model` sera virtuellement nommé `Model`

Et voilà !

Créons notre Service Container :

```php
// /src/service/ServiceContainer.php
namespace App\Service;

class ServiceContainer {

}
```

C'est une simple classe comme on sait le faire dorénavant, mais avec une instruction un peu nouvelle : le namespace !

Grâce à ça, on précise à PHP que ce fichier se trouve dans le chemin virtuel `App/Controller` (donc le chemin réel `src/service`).

Et comment on utilise ça ? Modifions notre `config.php` et importons notre service container. **Attention :** comme toujours, UTILISEZ l'auto-complétion **obligatoirement** !

```php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/routes.php';

$container = new ServiceContainer;
```

En tappant ce code, normalement la ligne `use App\Service\ServiceContainer;` s'est ajoutée automatiquement ! À quoi correspond-elle ? Au namespace que nous avons donné à notre classe.

Dorénavant, nous n'avons plus besoin de faire de `require_once...` pour importer les classes : il suffit de donner à PHP le chemin virtuel (le namespace) de la classe dans le fichier de la classe, et c'est tout ! En utilisant l'autocomplétion, la classe sera importée automatiquement au besoin, grâce à l'instruction `use`.

### Le Service Container

Dans notre container de services, ajoutons notre routeur. Voici le schéma pour tous les services à rajouter :

1. Dans la classe: on ajoute un attribut privé qui correspond au service
2. Dans la classe: on ajoute un getter dans le container, qui instancie le service avec éventuellement ses configurations si besoin (PDO par exemple)
3. Dans le getter: on teste si le service existe. Si ça n'est pas le cas, on l'instancie. Sinon, on le retourne.

Voilà le schéma de base à reproduire à chaque nouveau service :

```php
namespace App\Service;

use Bramus\Router\Router;

class ServiceContainer {

    private $router;

    public function getRouter() {
        if ($this->router === null) {
            $this->router = new Router;
        }
        return $this->router;
    }
}
```

Remarquez que notre routeur a bien été importé car nous avons utilisé l'auto-complétion !

### Modifications de fichiers

Modifions maintenant les fichiers `config.php` et `routes.php` pour prendre en compte le service container (promis, on n'aura plus vraiment à modifier nos fichiers par la suite) :

```php
// config.php
<?php

use App\Service\ServiceContainer;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/routes.php';

$container = new ServiceContainer;
```

```php
// routes.php
<?php

$router = $container->getRouter();

$router->get('/hello', function() {
    echo "Hello world";
});

$router->run();

```

## 6. Utiliser des templates avec Twig

## 7. Utiliser des contrôleurs

## 8. Créer le modèle de données
## 9. Créer les services

## 10. Utiliser les services pour se connecter à la base de données
