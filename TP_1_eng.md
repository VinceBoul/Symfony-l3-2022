# Sujet TP 1

Make a mini website to manage a vehicule park.

Each vehicule has the following properties :
* Model name
* Brand
* Mileage (integer)
* Date of manufacture
* Date of circulation
* Price (float)

## Éxercice 1

* Create an entity corresponding to a vehicule, with the needed fields contraints.
> Generate/edit an entity : `symfony console make:entity`
> 
> Generate a migration file :  `symfony console make:migration`
> 
> Execute the migration : `symfony console doctrine:migrations:migrate`
 
* Generate a Crud for this entity, and create many vehicules
> symfony console make:crud

**Result : Lister/add/edit/delete a véhicule**

## Éxercice 2

The admin wants to edit vehicules' quantity directly from the list page

* In the list, add two buttons for each vehicule, one to increment (+1), one to decrease (-1)
* Add an action and a route in a controller to increase the quantity 
* Add an action and a route in a controller to decrease the quantity 
> To make it clean, create only one action to both increase/decrease

**Result : when you clique on "increase"/"decrease" , the list page is reloaded and the quantity is updated**
 
## Éxercice 3

The admin want to sort and filter the list.

* Possible filters : 
  * Mileage min / max (`<input>`)
* Possibles sorts :
  * Quantity et price (ASC / DESC) (`<select>`)  

* Add HTML inputs to sort and filter
* Pass sort/filters to the "index" action as GET parameters
* Create a function in the `VehiculeRepository` to handle filters
  * This function can has as many parameters as filter/sort criterias  

**Result : When you use filters/sorts, the list is updated and sorted/filtered**

## Éxercice 4

The admin wants to filter the vehicules by brand.

* Create a new entity "Brand"
  * Remove the old property "brand" from Vehicule entity
* Update vehicule entity to create a relation with Brand entity
> A vehicule can only has one brand
>
> A brand may has many vehicules
  
* Generate a CRUD for the Brand entity
* Modifier le formulaire des véhicules pour pouvoir sélectionner une marque
* Dans la page qui liste les véhicules, ajouter une liste déroulante qui permet de filtrer par marque

**Résultat attendu : Il est possible d'ajouter/supprimer/éditer/lister les marques, il est possible de modifier la marque d'un véhicule, et lorsqu'on filtre par marque, la liste est acutalisée et filtrée**

## Éxercice 5
L'administrateur souhaite créer un espace publique qui mette en avant certains véhicules.

* Créer une page d'accueil
* Ajouter à l'entité véhicule les propriétés suivantes
  * mise en avant en page d'accueil
  * meilleur rapport qualité/prix
  * Mettre à jour le formulaire pour mettre en place des cases à cocher pour ces nouvelles propriétés
* Dans la page d'accueil
  * Créer un encart des véhicules mis en avant
  * Créer un encart pour les véhicules ayant un meilleur rapport qualité/prix
  
** Résultat attendu : La page d'accueil contient deux liste de véhicules, ceux mis en avant, et ceux ayant le meilleur rapport qualité prix

 ## Éxercice 6
L'administrateur souhaite avoir un espace d'administration sécurisé par une connexion
 
* Utiliser la commande "make:user" pour générer l'entité User
* Utiliser la commande "make:auth" pour mettre en place un formulaire de connexion
* Utiliser la commande "make:registration-form" pour mettre en place un formulaire d'inscription
> **Prenez le temps de lire le résultat de chaque commande**
* Mettre en place les règles de sécurité pour que :
  * seul un utilisateur connecté puisse accéder à l'interface d'administration des véhicules
  * un utilisateur anonyme ne peut accéder qu'à la page d'accueil 
  
** Résultat attendu : N'importe qui peut consulter la page d'accueil, mais il faut être connecté pour pouvoir administrer les véhicules et les marques"

## Éxercice 7
 
 L'administrateur souhaite pouvoir recevoir des demandes de contact via un formulare sur le site
 * Créer une entité "Contact" avec les propriétés suivantes :
    * Nom
    * Email
    * Message
 * Générer un CRUD de l'entité Contact et placer le formulaire dans la page d'accueil
 * Intégrer dans l'espace d'administration une page qui liste les demandes de contact
 
 ## Éxercice 8
 
 Ajouter du style.
 Installer la librarie "Webpack Encore" et ajouter Bootstrap. 
