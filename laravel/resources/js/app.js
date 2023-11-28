import './bootstrap';
import Alpine from 'alpinejs';

// Importa el teu script personalitzat
import './files/create';

// Importa els scripts de validació de places
import './places/create';
import './places/edit';

window.Alpine = Alpine;

Alpine.start();
