# Tests Unitaires avec Pest

Ce projet utilise [Pest](https://pestphp.com/) pour les tests unitaires.

## Installation

Les dépendances sont installées automatiquement dans le conteneur Docker lors du démarrage. Si vous devez réinstaller manuellement :

```bash
docker exec -it cda_formation_php composer install --ignore-platform-reqs
```

## Exécution des tests

Pour exécuter tous les tests depuis votre machine locale :

```bash
docker exec -it cda_formation_php composer test
```

Ou directement avec Pest :

```bash
docker exec -it cda_formation_php vendor/bin/pest
```

## Exécution de tests spécifiques

Pour exécuter un fichier de test spécifique :

```bash
docker exec -it cda_formation_php vendor/bin/pest tests/Unit/MainTest.php
```

Pour exécuter un test spécifique :

```bash
docker exec -it cda_formation_php vendor/bin/pest --filter "nom_du_test"
```

## Structure des tests

Les tests sont organisés dans le répertoire `tests/Unit/` :

- `MainTest.php` - Tests pour le routeur principal
- `SessionTest.php` - Tests pour la gestion des sessions
- `DbTest.php` - Tests pour la connexion à la base de données
- `ViewTest.php` - Tests pour le système de vues Smarty
- `StudentsTest.php` - Tests pour le modèle Students

## Configuration

La configuration Pest se trouve dans `Pest.php` à la racine du projet `src/`.

## Variables d'environnement pour les tests

Certains tests nécessitent des variables d'environnement pour la connexion à la base de données. Elles peuvent être définies dans le fichier `docker-compose.yaml` ou passées lors de l'exécution des tests :

- `DB_HOST` - Hôte de la base de données (par défaut: mariadb)
- `DB_DATABASE` - Nom de la base de données (par défaut: formation)
- `DB_USER` - Utilisateur de la base de données (par défaut: root)
- `DB_PASSWORD` - Mot de passe de la base de données (par défaut: root)

