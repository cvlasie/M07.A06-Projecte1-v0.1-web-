import Validator from '../validator';

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('create-post-form');

    if (form) {
        form.addEventListener('submit', function (event) {
            // Resetear los mensajes de error
            document.getElementById("error-upload").textContent = '';

            // Recoger los datos del formulario
            const data = {
                body: document.getElementById('body').value,
                upload: document.getElementById('upload').value,
                latitude: document.getElementById('latitude').value,
                longitude: document.getElementById('longitude').value,
                visibility_id: document.getElementById('visibility_id').value
            };

            // Definir las reglas de validación
            const rules = {
                body: 'required',
                upload: 'required',
                latitude: 'required|numeric',
                longitude: 'required|numeric',
                visibility_id: 'required'
            };

            // Crear el objeto de validación
            const validation = new Validator(data, rules);

            // Comprobar si la validación pasa
            if (!validation.passes()) {
                // Mostrar errores
                console.log(validation.errors.all());
                event.preventDefault();
            }
        });
    }
});
