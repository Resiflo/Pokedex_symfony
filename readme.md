readme.md

# Installation

Pour pouvez télécharger le script d'installation et le lancer. 
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


## Controllers

### Home

Le controller Home contient l'affichage et la recherche de chaque pokemon. 
Chaque recherche appel la fonction `findAllPagedAndSorted` qui va chercher dans la base de donnée les informations nécessaire.

L'affichage est controlé par un paginateur qui limite le nombre d'éléments.

Code du controller:

```php
 public function index(Request $request, int $page = 1, PokemonRepository $pokemonRepository, TypeRepository $typeRepository, GenerationRepository $generationRepository ): Response
    {
        
        $nbPokemonByPage = $this->getParameter('NB_POKEMON_BY_PAGE');
        $pokemon = $pokemonRepository->findAllPagedAndSorted($page, $nbPokemonByPage, ['nom'=> $request->request->get('nomSelected'),'type1'=> $request->request->get('type1Selected'),
        'type2'=> $request->request->get('type2Selected'),'generation'=>$request->request->get('generationSelected')]);
        $types = $typeRepository->findBy([],['name'=>'ASC']);
        $generations = $generationRepository->findBy([],['name' => 'ASC']);

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($pokemon) / $nbPokemonByPage),
            'nomRoute' => 'pokemon_index',
            'paramsRoute' => array()
        );
        return $this->render('pokemon/index.html.twig', [
            'pokemon' => $pokemon,
            'pagination' => $pagination,
            'generations' => $generations,
            'types' => $types
        ]);
    }
```
Code du repository :

```php
  /**
  * Récupère une liste d'article paginés et triés par date de création.
  *
  * @param int $page Le numéro de la page
  * @param int $nbMaxByPage Nombre maximum d'articles par page     
  *
  * @throws InvalidArgumentException
  * @throws NotFoundHttpException
  *
  * @return Paginator
  */
  public function findAllPagedAndSorted($page, $nbMaxByPage, $sqlfilters=[])
    {
        if (!is_numeric($page)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
            );
        }
  
        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }
  
        if (!is_numeric($nbMaxByPage)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $nbMaxParPage est incorrecte (valeur : ' . $nbMaxByPage . ').'
            );
        }
  
        
        $qb = $this->createQueryBuilder('pokemon')
            ->andWhere('pokemon.nom like :nom')
            ->setParameter('nom', "%$sqlfilters[nom]%")
            ->leftJoin('pokemon.type1', 'type1')
            ->andWhere('type1.name like :type1')
            ->setParameter('type1', "%$sqlfilters[type1]%")
            ->leftJoin('pokemon.type2', 'type2')
            ->andWhere('type2.name like :type2')
            ->setParameter('type2', "%$sqlfilters[type2]%")
            ->leftJoin('pokemon.generation', 'generation')
            ->andWhere('generation.name like :generation')
            ->setParameter('generation', "%$sqlfilters[generation]%")
            ->orderBy('pokemon.numero', 'ASC');
            
  
        $query = $qb->getQuery();
        $firstResult = ($page - 1) * $nbMaxByPage;
        $query->setFirstResult($firstResult)->setMaxResults($nbMaxByPage);
        $paginator = new Paginator($query);
  
        if ( ($paginator->count() <= $firstResult) && $page != 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas.'); // page 404, sauf pour la première page
        }
  
        return $paginator;
    }
}
```

