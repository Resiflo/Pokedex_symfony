readme.md

# Installation

Pour pouvez télécharger le script d'installation et le lancer. 

Pour cela il faut simplement pull le projet git et ensuite éxécuter le script d'installation : 
```bash
curl https://github.com/Resiflo/Pokedex_symfony/blob/main/install.sh | bash
```

L'import des pokemon est se fait avec le fichier pokemon.csv ou avec la requete sql dans le fichier pokemon.sql disponibles dans la racine du projet.


Une version fonctionnelle du projet se trouve à l'adresse suivante :
 
http://91.121.146.228:29829

## Nginx

Nginx version : 1.14.2

## Symfony

Symfony version : 5.2.5

# TP pokedex sous symfony - fonctionnalités

Le but du TP est d'apprendre et utiliser les fonctionnalité de symfony pour faire un pokedex. 

## Bundle

### API PLATFORM

Dans ce projet j'ai utiliser API platform et fait des groupes sur les entités pour pouvoir ressortir chaque pokemon avec ses champs et relations. 

L'api est disponible avec un GET sous l'url : http://91.121.146.228:29829/api/pokemon.json 

Exemple: 
```json
[
  {
    "id": 3,
    "numero": 1,
    "nom": "Bulbasaur",
    "type1": {
      "name": "Grass"
    },
    "type2": {
      "name": "Poison"
    },
    "vie": 45,
    "attaque": 49,
    "defense": 49,
    "legendaire": false,
    "generation": {
      "name": "1"
    }
  },
  {
    "id": 4,
    "numero": 2,
    "nom": "Ivysaur",
    "type1": {
      "name": "Grass"
    },
    "type2": {
      "name": "Poison"
    },
    "vie": 60,
    "attaque": 62,
    "defense": 63,
    "legendaire": false,
    "generation": {
      "name": "1"
    }
  },
  ```


## 