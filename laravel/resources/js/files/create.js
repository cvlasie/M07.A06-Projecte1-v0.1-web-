import Validator from '../validator';

const form = document.getElementById("create-file-form");

if (form) {
    form.addEventListener("submit", function(event) {
        // Reset errors messages
        document.getElementById("error-upload").textContent = '';

        // Get form inputs values
        let data = {
            "upload": document.getElementsByName("upload")[0].value,
        };
        let rules = {
            "upload": "required",
        };

        // Create validation
        let validation = new Validator(data, rules);

        // Validate fields
        if (!validation.passes()) {
            // Get error messages
            let errors = validation.errors.all();

            // Show error messages
            for (let inputName in errors) {
                let error = errors[inputName];
                document.getElementById(`error-${inputName}`).textContent = error;
            }

            // Avoid submit
            event.preventDefault();
            return false;
        }
    });
}
