<!-- resources/views/home.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h1 class="text-4xl font-bold text-fons-principal">GeoMIR</h1>
    </x-slot>

    <div class="bg-crema text-black font-sans">

        <!-- Contenido Principal -->
        <main class="container mx-auto my-8">

            <!-- Sección Destacada -->
            <section class="bg-fons-principal p-8 rounded-lg shadow-lg mb-8">
                <h2 class="text-taronja text-2xl font-bold mb-4">Títol Destacat</h2>
                <p class="text-gray-800">Contingut de la secció destacada...</p>
            </section>

            <!-- Otras secciones, listas, tablas, formularios, etc. -->

        </main>

        <!-- Pie de Página -->
        <footer class="bg-taronja text-morat p-4">
            <p class="text-sm">&copy; 2023 La Teva Empresa</p>
        </footer>

    </div>

    <style>
        /* Definición de colores personalizados */
        :root {
            --color-taronja: #FF801F;
            --color-taronja-clar: #FF9E1F;
            --color-fons-principal: #FFD899;
            --color-lila: #BC87E8;
            --color-fons-secundari: #2A0052;
        }

        /* Estilos con colores personalizados */
        .bg-taronja {
            background-color: var(--color-taronja);
        }

        .text-taronja {
            color: var(--color-taronja);
        }

        .bg-taronja-clar {
            background-color: var(--color-taronja-clar);
        }

        .text-taronja-clar {
            color: var(--color-taronja-clar);
        }

        .text-fons-principal {
            color: var(--color-fons-principal);
        }

        .bg-lila {
            background-color: var(--color-lila);
        }

        .text-lila {
            color: var(--color-lila);
        }

        .bg-fons-secundari {
            background-color: var(--color-fons-secundari);
        }

        .text-fons-secundari {
            color: var(--color-fons-secundari);
        }
    </style>
</x-app-layout>
