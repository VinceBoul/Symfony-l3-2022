## Cloner le projet 

En ligne de commande : 
`git clone url_projet nom_dossier_projet`

Se placer dans le projet : 

`cd nom_dossier_projet`

### Installer les dépendances

`composer install`

### Générer un fichier `.env` propre au projet

`composer dump-env dev`

### Ignorer les modifications du dossier `migrations`

* `git rm -r -cached migrations`
* Ajouter dans `.gitignore` la ligne `/migrations/`
* Pousser le fichier `.gitignore` sur le repo git
