/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap'

import Routing from 'fos-router';
const routes = require('./js/routes.json');
Routing.setRoutingData(routes);
console.log(Routing.generate('app_article_coucou'));

import axios from "axios";

document.getElementById('coucou-btn').addEventListener('click', function(){
// Requêter un utilisateur avec un ID donné.
	axios.get(Routing.generate('app_article_coucou'))
		.then(function (response) {
			// en cas de réussite de la requête
			console.log(response);
			document.getElementById('coucou-msg').innerHTML = response.data;
		})

})
