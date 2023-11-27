<x-geomir-layout class="bg-fons-principal">
    <header class="bg-taronja p-6 relative flex items-center justify-between">
        <div class="flex items-center">
            <h1 class="text-2xl font-extrabold text-fons-principal font-montserrat text-taronja">GeoPic</h1>
        </div>
        <img src="{{ asset('img/heart.svg') }}" class="w-6 h-6"/>
    </header>

    <body class="bg-fons-principal">
        <div class="bg-fons-principal p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('img/pic.png') }}" class="w-8 h-8 rounded-full" alt="User Image" />
                    <div class="ml-2">
                        <p class="font-bold text-fons-secundari text-sm">ies.joaquimmir_</p>
                        <div class="font-bold text-fons-secundari text-sm">40.765475392857844, -73.97644553247858</div>
                    </div>
                </div>
                <img src="{{ asset('img/options.svg') }}" class="w-6 h-6" alt="Options Icon" />
            </div>
        </div>
        <img src="{{ asset('img/postimg.png') }}" class="w-full h-auto mb-6" alt="Post Image" />
    </body>

    <style>
        :root {
            --color-taronja: #FF801F;
            --color-taronja-clar: #FF9E1F;
            --color-fons-principal: #FFD899;
            --color-lila: #BC87E8;
            --color-fons-secundari: #2A0052;
        }

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

        .bg-fons-principal {
            background-color: var(--color-fons-principal);
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
</x-geomir-layout>
