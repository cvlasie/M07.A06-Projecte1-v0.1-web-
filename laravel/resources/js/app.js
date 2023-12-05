import './bootstrap';
import Alpine from 'alpinejs';
import './twe.js'

// Importa el teu script personalitzat
import './files/create';

// Importa els scripts de validació de places
import './places/create';
import './places/edit';

// Importa els scripts de validació de posts
import './posts/create';
import './posts/edit';

window.Alpine = Alpine;

Alpine.start();
