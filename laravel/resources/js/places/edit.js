// edit_place.js
import Validator from '../validator';

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('edit-place-form');

    if (form) {
        form.addEventListener('submit', function (event) {
            // Reset errors messages
            document.getElementById("error-upload").textContent = '';
            
            // Recollir les dades del formulari
            const data = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                upload: document.getElementById('upload').value,
                latitude: document.getElementById('latitude').value,
                longitude: document.getElementById('longitude').value,
                visibility_id: document.getElementById('visibility_id').value
            };

            // Definir les regles de validació
            const rules = {
                name: 'required',
                description: 'required',
                // L'upload pot no ser obligatori en l'edició
                latitude: 'required|numeric',
                longitude: 'required|numeric',
                visibility_id: 'required'
            };

            // Crear l'objecte de validació
            const validation = new Validator(data, rules);

            // Comprovar si la validació passa
            if (!validation.passes()) {
                // Mostrar errors
                console.log(validation.errors.all());
                event.preventDefault();
            }
        });
    }
});
