# CraftCorner

Backend Laravel du projet CraftCorner

## About

Un leBoncoin "like" pour les artisans et les créateurs.

## Installation

1. Clonez le dépôt :

```bash
git clone https://github.com/MaximePolese/projetLaravel
```

2. Installez les dépendances :

```bash
composer install
```

3. Lancez le serveur :

```bash
php artisan serve
```

4. Lancez les migrations :

```bash 
php artisan migrate
```

5. optionnel : Lancez les seeders :

```bash
php artisan db:seed
```

## API

### Boutiques

- `GET /shops`: Récupère une liste de toutes les boutiques.
- `GET /shops/{shop}`: Récupère les détails d'une boutique spécifique.
- `POST /shops`: Crée une nouvelle boutique. Le corps de la requête doit contenir les détails de la boutique au format
  JSON.
- `PUT /shops/{shop}`: Met à jour les détails d'une boutique spécifique. Le corps de la requête doit contenir les
  détails de la boutique mis à jour au format JSON.
- `DELETE /shops/{shop}`: Supprime une boutique spécifique.

### Produits

- `GET /products/sort`: Trie les produits en fonction des paramètres fournis.
- `GET /products/filter`: Filtre les produits en fonction des paramètres fournis.
- `GET /products/search`: Recherche des produits en fonction du terme de recherche fourni.
- `GET /products`: Récupère une liste de tous les produits.
- `GET /products/{product}`: Récupère les détails d'un produit spécifique.
- `POST /products`: Crée un nouveau produit. Le corps de la requête doit contenir les détails du produit au format JSON.
- `PUT /products/{product}`: Met à jour les détails d'un produit spécifique. Le corps de la requête doit contenir les
  détails du produit mis à jour au format JSON.
- `DELETE /products/{product}`: Supprime un produit spécifique.

### Commandes

- `GET /orders`: Récupère une liste de toutes les commandes.
- `GET /orders/{order}`: Récupère les détails d'une commande spécifique.
- `POST /orders`: Crée une nouvelle commande. Le corps de la requête doit contenir les détails de la commande au format
  JSON.
- `PUT /orders/{order}`: Met à jour les détails d'une commande spécifique. Le corps de la requête doit contenir les
  détails de la commande mis à jour au format JSON.
- `DELETE /orders/{order}`: Supprime une commande spécifique.

### Utilisateurs

- `GET /users`: Récupère une liste de tous les utilisateurs.
- `GET /users/{user}`: Récupère les détails d'un utilisateur spécifique.
- `POST /register`: Enregistre un nouvel utilisateur. Le corps de la requête doit contenir les détails de l'utilisateur
  au format JSON.
- `PUT /users/{user}`: Met à jour les détails d'un utilisateur spécifique. Le corps de la requête doit contenir les
  détails de l'utilisateur mis à jour au format JSON.
- `DELETE /users/{user}`: Supprime un utilisateur spécifique.

## Tests

Pour lancer les tests, utilisez la commande suivante :

```bash
php artisan test
```

## Contributing

## Code of Conduct

## Security Vulnerabilities

## License
