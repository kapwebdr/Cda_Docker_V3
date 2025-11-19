# Guide des Tests Unitaires avec Pest

Ce document explique comment installer, configurer et utiliser le système de tests unitaires avec Pest dans le projet Cda_Docker_V3.

## 📋 Table des matières

1. [Introduction](#introduction)
2. [Installation](#installation)
3. [Structure des tests](#structure-des-tests)
4. [Exécution des tests](#exécution-des-tests)
5. [Écrire des tests](#écrire-des-tests)
6. [Bonnes pratiques](#bonnes-pratiques)
7. [Dépannage](#dépannage)

---

## 🎯 Introduction

Ce projet utilise [Pest](https://pestphp.com/), un framework de test PHP moderne et élégant basé sur PHPUnit. Pest offre une syntaxe plus simple et expressive pour écrire des tests.

### Pourquoi Pest ?

- ✅ Syntaxe simple et lisible
- ✅ API expressive avec `test()` et `expect()`
- ✅ Compatible avec PHPUnit
- ✅ Excellent support pour les tests fonctionnels et unitaires
- ✅ Configuration minimale requise

---

## 🚀 Installation

### Prérequis

- Docker et Docker Compose installés
- Le conteneur PHP doit être démarré

### Étapes d'installation

1. **Démarrer les conteneurs Docker** (si ce n'est pas déjà fait) :
   ```bash
   docker-compose up -d
   ```

2. **Installer les dépendances Composer** dans le conteneur :
   ```bash
   docker exec -it cda_formation_php composer install --ignore-platform-reqs
   ```
   
   Cette commande installera automatiquement Pest et toutes ses dépendances.

3. **Vérifier l'installation** :
   ```bash
   docker exec -it cda_formation_php vendor/bin/pest --version
   ```

### Structure des fichiers de configuration

Les fichiers suivants ont été créés pour la configuration des tests :

- `src/Pest.php` - Configuration principale de Pest
- `src/phpunit.xml` - Configuration PHPUnit (utilisée par Pest)
- `src/composer.json` - Dépendances et scripts de test

---

## 📁 Structure des tests

Les tests sont organisés dans le répertoire `src/tests/` :

```
src/
├── tests/
│   ├── Unit/              # Tests unitaires
│   │   ├── MainTest.php          # Tests du routeur
│   │   ├── SessionTest.php       # Tests des sessions
│   │   ├── DbTest.php            # Tests de la base de données
│   │   ├── ViewTest.php          # Tests des vues Smarty
│   │   └── StudentsTest.php      # Tests du modèle Students
│   ├── Helpers/           # Classes helper pour les tests
│   │   └── TestController.php
│   └── README.md          # Documentation supplémentaire
├── Pest.php               # Configuration Pest
└── phpunit.xml            # Configuration PHPUnit
```

### Organisation des tests

- **Tests unitaires** (`tests/Unit/`) : Testent des unités de code isolées (classes, méthodes)
- **Helpers** (`tests/Helpers/`) : Classes utilitaires pour faciliter l'écriture des tests

---

## ▶️ Exécution des tests

### Exécuter tous les tests

```bash
docker exec -it cda_formation_php composer test
```

Ou directement avec Pest :

```bash
docker exec -it cda_formation_php vendor/bin/pest
```

### Exécuter un fichier de test spécifique

```bash
docker exec -it cda_formation_php vendor/bin/pest tests/Unit/MainTest.php
```

### Exécuter un test spécifique par nom

```bash
docker exec -it cda_formation_php vendor/bin/pest --filter "Router retourne 404"
```

### Exécuter les tests en mode verbose

```bash
docker exec -it cda_formation_php vendor/bin/pest --verbose
```

### Exécuter les tests avec couverture de code

```bash
docker exec -it cda_formation_php vendor/bin/pest --coverage
```

### Exécuter les tests en mode watch (surveillance)

```bash
docker exec -it cda_formation_php vendor/bin/pest --watch
```

### Options utiles

| Option | Description |
|--------|-------------|
| `--filter="nom"` | Exécute uniquement les tests correspondant au filtre |
| `--stop-on-failure` | Arrête l'exécution au premier échec |
| `--parallel` | Exécute les tests en parallèle |
| `--coverage` | Génère un rapport de couverture |
| `--verbose` | Mode verbose avec plus de détails |

---

## ✍️ Écrire des tests

### Syntaxe de base

Pest utilise une syntaxe simple et expressive :

```php
<?php

use App\Controller\Main;

test('description du test', function () {
    // Arrange : Préparer les données
    $value = 42;
    
    // Act : Exécuter l'action
    $result = someFunction($value);
    
    // Assert : Vérifier le résultat
    expect($result)->toBe(42);
});
```

### Exemple complet : Test du routeur

```php
<?php

use App\Controller\Main;

test('Router retourne 404 pour une route inexistante', function () {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/route-inexistante';
    
    ob_start();
    Main::Router([]);
    $output = ob_get_clean();
    
    expect($output)->toContain('404');
});
```

### Assertions avec `expect()`

Pest fournit de nombreuses assertions via `expect()` :

```php
// Égalité
expect($value)->toBe(42);
expect($value)->not->toBe(0);

// Types
expect($value)->toBeInt();
expect($value)->toBeString();
expect($value)->toBeArray();
expect($value)->toBeBool();

// Collections
expect($array)->toHaveCount(3);
expect($array)->toContain('value');
expect($array)->not->toBeEmpty();

// Chaînes
expect($string)->toContain('substring');
expect($string)->toStartWith('prefix');
expect($string)->toEndWith('suffix');

// Objets
expect($object)->toBeInstanceOf(MyClass::class);
expect($object)->toHaveProperty('name');

// Exceptions
expect(fn() => riskyFunction())->toThrow(Exception::class);
```

### Configuration avant/après chaque test

Utilisez `beforeEach()` et `afterEach()` pour configurer l'environnement :

```php
beforeEach(function () {
    // Code exécuté avant chaque test
    $_SESSION = [];
    $_SERVER['REQUEST_METHOD'] = 'GET';
});

afterEach(function () {
    // Code exécuté après chaque test
    // Nettoyage si nécessaire
});
```

### Tests avec données (Data Providers)

```php
test('addition fonctionne correctement', function ($a, $b, $expected) {
    expect($a + $b)->toBe($expected);
})->with([
    [1, 2, 3],
    [5, 5, 10],
    [10, -5, 5],
]);
```

### Tests conditionnels (skip)

```php
test('test nécessitant une base de données', function () {
    // Code du test
})->skip(fn() => !getenv('DB_HOST'));
```

### Groupes de tests

```php
test('test dans un groupe', function () {
    // Code du test
})->group('integration');
```

Exécuter un groupe :
```bash
docker exec -it cda_formation_php vendor/bin/pest --group=integration
```

---

## 📚 Tests existants dans le projet

### MainTest.php

Tests pour le routeur principal (`App\Controller\Main`) :
- ✅ Route 404 pour route inexistante
- ✅ Erreur 405 pour méthode non autorisée
- ✅ Dispatch de route valide
- ✅ Gestion des paramètres de route
- ✅ Décodage des URIs encodées
- ✅ Ignorer les paramètres de requête

### SessionTest.php

Tests pour la gestion des sessions (`App\Controller\Session`) :
- ✅ Vérification d'existence de clé
- ✅ Vérification de valeur vide
- ✅ Récupération de valeurs
- ✅ Stockage de valeurs
- ✅ Suppression de clés
- ✅ Support de différents types de données

### DbTest.php

Tests pour la connexion à la base de données (`App\Model\Db`) :
- ✅ Initialisation de la connexion PDO
- ✅ Pattern singleton
- ✅ Configuration UTF-8 et FETCH_ASSOC

### ViewTest.php

Tests pour le système de vues (`App\Controller\View`) :
- ✅ Initialisation de Smarty
- ✅ Configuration des répertoires
- ✅ Pattern singleton

### StudentsTest.php

Tests pour le modèle Students (`Projects\Altera\Model\Students`) :
- ✅ Héritage de Db
- ✅ Existence de méthodes
- ✅ Récupération d'étudiants (nécessite DB)

---

## 💡 Bonnes pratiques

### 1. Nommage des tests

Utilisez des descriptions claires et descriptives :

```php
// ✅ Bon
test('Router retourne 404 pour une route inexistante', function () { });

// ❌ Mauvais
test('test router', function () { });
```

### 2. Structure AAA (Arrange-Act-Assert)

```php
test('exemple avec structure AAA', function () {
    // Arrange : Préparer
    $input = 'test';
    
    // Act : Exécuter
    $result = process($input);
    
    // Assert : Vérifier
    expect($result)->toBe('processed');
});
```

### 3. Un test = Une assertion (quand c'est possible)

```php
// ✅ Bon : Un test, une responsabilité
test('Session::Set stocke une valeur', function () {
    Session::Set('key', 'value');
    expect(Session::Get('key'))->toBe('value');
});

test('Session::Get retourne null pour clé inexistante', function () {
    expect(Session::Get('inexistante'))->toBeNull();
});
```

### 4. Isolation des tests

Chaque test doit être indépendant :

```php
beforeEach(function () {
    // Réinitialiser l'état avant chaque test
    $_SESSION = [];
    TestController::reset();
});
```

### 5. Tests rapides

Les tests unitaires doivent être rapides. Évitez les opérations lentes (appels réseau, fichiers, etc.) ou utilisez des mocks.

### 6. Utiliser des helpers

Créez des classes helper pour éviter la duplication :

```php
// tests/Helpers/TestController.php
class TestController
{
    public static $called = false;
    
    public function testMethod() {
        self::$called = true;
    }
}
```

---

## 🔧 Dépannage

### Erreur : "Class not found"

**Problème** : Les classes ne sont pas trouvées lors de l'exécution des tests.

**Solution** :
```bash
docker exec -it cda_formation_php composer dump-autoload
```

### Erreur : "Pest not found"

**Problème** : Pest n'est pas installé.

**Solution** :
```bash
docker exec -it cda_formation_php composer install --ignore-platform-reqs
```

### Tests échouent à cause de la base de données

**Problème** : Les tests nécessitent une connexion DB mais elle n'est pas disponible.

**Solution** : Utilisez `skip()` pour ignorer ces tests :
```php
test('test DB', function () {
    // Code du test
})->skip(fn() => !getenv('DB_HOST'));
```

### Problème avec les sessions dans les tests

**Problème** : Les sessions ne fonctionnent pas correctement dans les tests.

**Solution** : Assurez-vous de démarrer la session dans `beforeEach()` :
```php
beforeEach(function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION = [];
});
```

### Tests qui interfèrent entre eux

**Problème** : Les tests modifient l'état global et interfèrent.

**Solution** : Réinitialisez l'état dans `beforeEach()` :
```php
beforeEach(function () {
    $_SERVER = [];
    $_SESSION = [];
    $_GET = [];
    $_POST = [];
});
```

### Voir plus de détails sur les erreurs

Utilisez le mode verbose :
```bash
docker exec -it cda_formation_php vendor/bin/pest --verbose
```

---

## 📖 Ressources supplémentaires

- [Documentation officielle Pest](https://pestphp.com/docs)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Guide des assertions Pest](https://pestphp.com/docs/expectations)

---

## 🎓 Exemple complet : Créer un nouveau test

Voici un exemple complet pour créer un nouveau test :

1. **Créer le fichier de test** :
   ```bash
   # Dans votre éditeur, créez : src/tests/Unit/MonTest.php
   ```

2. **Écrire le test** :
   ```php
   <?php
   
   use App\Controller\MaClasse;
   
   test('MaClasse fait quelque chose', function () {
       $instance = new MaClasse();
       $result = $instance->maMethode();
       
       expect($result)->toBe('expected_value');
   });
   ```

3. **Exécuter le test** :
   ```bash
   docker exec -it cda_formation_php vendor/bin/pest tests/Unit/MonTest.php
   ```

---

## ✅ Checklist pour un nouveau test

- [ ] Le test a un nom descriptif
- [ ] Le test suit la structure AAA (Arrange-Act-Assert)
- [ ] Le test est isolé (pas de dépendances avec d'autres tests)
- [ ] Le test est rapide
- [ ] Les assertions sont claires
- [ ] Le test couvre un cas d'usage spécifique
- [ ] Le test est dans le bon répertoire (`tests/Unit/`)

---

**Dernière mise à jour** : Configuration initiale avec Pest 3.0

