<x-geomir-layout>
    <header class="bg-taronja p-4 relative flex items-center justify-between">
        <div class="flex items-center">
            <h1 class="text-2xl font-extrabold text-fons-principal font-montserrat text-taronja">GeoPic</h1>
        </div>
        <img src="{{ asset('img/heart.svg') }}" class="w-6 h-6"/>
    </header>

    <body>
        <div class="bg-fons-principal p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('img/pic.png') }}" class="w-8 h-8 rounded-full"/>
                    <div class="ml-2">
                        <p class="font-bold text-fons-secundari text-sm">ies.joaquimmir_</p>
                        <p class="font-bold text-fons-secundari text-sm">40.765475392857844, -73.97644553247858</p>
                    </div>
                </div>
                <img src="{{ asset('img/options.svg') }}" class="w-6 h-6" />
            </div>
        </div>
        <div class="bg-fons-principal">
            <img src="{{ asset('img/postimg.png') }}" class="w-full h-auto mb-6"/>
            <div class="px-4">
                <div class="flex items-center">
                    <img src="{{ asset('img/like.svg') }}" class="like w-6 h-6"/>
                    <img src="{{ asset('img/comment.svg') }}" class="comment w-6 h-6"/>
                </div>
                <div class="ml-2">
                    <p class="text-fons-secundari">Like por <span class="font-bold">ies.joaquimmir_</span> y <span class="font-bold">otros</span></p>
                </div>
                <div class="ml-2">
                    <p class="text-fons-secundari">ies.joaquimmir_: nice GTR R34 <span class="text-lila">...mas</span></p>
                </div>
                <div class="ml-2">
                    <p class="text-lila">Ver mas comentarios</p>
                </div>
            </div>
        </div>
    </body>

    <footer class="bg-fons-secundari p-4 w-full flex justify-between items-center">
        <img src="{{ asset('img/home.svg') }}" class="w-6 h-6"/>
        <img src="{{ asset('img/search.svg') }}" class="w-6 h-6"/>
        <img src="{{ asset('img/add.svg') }}" class="w-6 h-6"/>
        <img src="{{ asset('img/profile.svg') }}" class="w-6 h-6"/>
        <img src="{{ asset('img/settings.svg') }}" class="w-6 h-6"/>
    </footer>

    <style>
        :root {
            --color-taronja: #FF801F;
            --color-taronja-clar: #FF9E1F;
            --color-fons-principal: #FFD899;
            --color-lila: #BC87E8;
            --color-fons-secundari: #2A0052;
        }

        x-geomir-layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        body {
            margin: auto;
        }
        

        footer {
            position: absolute;
            bottom: 0;
        }

        body {
            background-color: #FFD899;
        }

        .like {
            margin-right: 0.5rem;
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
