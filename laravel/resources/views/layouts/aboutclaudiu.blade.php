<x-geomir-layout>

    <body>
        <div class="member-container" ondragover="handleDragOver(event)" ondrop="handleDrop(event)">
            <div class="member" id="rick-sanchez" draggable="true" onmouseover="changeInfo('rick-sanchez')"
                onmouseout="resetInfo('rick-sanchez')"
                onclick="openVideoModal('{{ asset('videos/intro.mp4') }}', '{{ asset('videos/intro2.mp4') }}')">
                <img class="serious-photo" src="{{ asset('img/serious-photo.jpg') }}" alt="Rick Sanchez">
                <img class="fun-photo" src="{{ asset('img/fun-photo.jpg') }}" alt="Rick Sanchez Fun">
                <audio id="sound-rick" src="{{ asset('sounds/rick.mp3') }}"></audio>
                <div class="member-info">
                    <p>Rick Sanchez</p>
                    <p>CEO</p>
                </div>
            </div>
            <div class="member" id="morty-smith" draggable="true" onmouseover="changeInfo('morty-smith')"
                onmouseout="resetInfo('morty-smith')"
                onclick="openVideoModal('{{ asset('videos/intro.mp4') }}', '{{ asset('videos/intro2.mp4') }}')">
                <img class="serious-photo" src="{{ asset('img/serious-photo-morty.jpg') }}" alt="Morty Smith">
                <img class="fun-photo" src="{{ asset('img/fun-photo-morty.jpg') }}" alt="Morty Smith">
                <audio id="sound-morty" src="{{ asset('sounds/rick.mp3') }}"></audio>
                <div class="member-info" id="morty-smith-info">
                    <p>Morty Smith</p>
                    <p>CO-OWNER</p>
                </div>
            </div>
        </div>

        <div class="modal" id="video-modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal('video-modal')">&times;</span>
                <div class="carousel-container">
                    <div class="carousel-content">
                        <!-- Videos se agregarán dinámicamente aquí -->
                    </div>
                </div>
                <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
                <a class="next" onclick="changeSlide(1)">&#10095;</a>
                <button id="startSecondVideo" class="start-button" onclick="startSecondVideo()">Iniciar Segundo
                    Video</button>
            </div>
        </div>

        <script>
    document.addEventListener('DOMContentLoaded', function () {
        const memberContainer = document.querySelector('.member-container');
        
        memberContainer.addEventListener('dragover', handleDragOver);
        memberContainer.addEventListener('drop', handleDrop);

        const members = document.querySelectorAll('.member');

        members.forEach(member => {
            member.addEventListener('dragstart', handleDragStart);
            member.addEventListener('dragend', handleDragEnd);
        });
    });

    function handleDragStart(e) {
        e.dataTransfer.setData('text/plain', e.target.id);
    }

    function handleDragOver(e) {
        e.preventDefault();

        const draggedMember = document.querySelector('.dragging');
        if (!draggedMember) return;

        const boundingBox = draggedMember.getBoundingClientRect();
        const offsetY = e.clientY - boundingBox.top;

        let targetElement = e.target;
        while (targetElement && targetElement.classList && !targetElement.classList.contains('member')) {
            targetElement = targetElement.parentElement;
        }

        if (!targetElement) return;

        if (offsetY < boundingBox.height / 2) {
            memberContainer.insertBefore(draggedMember, targetElement);
        } else {
            memberContainer.insertBefore(draggedMember, targetElement.nextElementSibling);
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        const draggedMember = document.querySelector('.dragging');
        if (!draggedMember) return;

        memberContainer.removeChild(draggedMember);

        let targetElement = e.target;
        while (targetElement && targetElement.classList && !targetElement.classList.contains('member')) {
            targetElement = targetElement.parentElement;
        }

        if (!targetElement) return;

        memberContainer.insertBefore(draggedMember, targetElement);
        draggedMember.classList.remove('dragging');
    }

    function handleDragEnd() {
        const members = document.querySelectorAll('.member');
        members.forEach(member => {
            member.classList.remove('dragging');
        });
    }

            function openVideoModal(...videoUrls) {
                const videoModal = document.getElementById('video-modal');
                videoModal.style.display = 'block';

                const carouselContent = document.querySelector('.carousel-content');
                carouselContent.innerHTML = "";

                videoUrls.forEach((url, index) => {
                    const videoElement = document.createElement('video');
                    videoElement.src = url;
                    videoElement.autoplay = index === 0;
                    videoElement.muted = true;
                    videoElement.classList.add('carousel-item');

                    carouselContent.appendChild(videoElement);

                    if (index === 0) {
                        videoElement.addEventListener('ended', startSecondVideo);
                    }
                });

                currentSlide = 0;
                showSlide(currentSlide);

                secondVideoStarted = false;
                secondVideo = document.querySelectorAll('.carousel-item')[1];
                if (secondVideo) {
                    secondVideo.addEventListener('ended', () => {
                        secondVideoStarted = true;
                    });
                }
            }

            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                modal.style.display = 'none';

                const carouselContent = document.querySelector('.carousel-content');
                carouselContent.innerHTML = "";
            }

            function changeSlide(n) {
                currentSlide += n;
                showSlide(currentSlide);
            }

            function showSlide(n) {
                const videos = document.querySelectorAll('.carousel-item');
                if (n >= videos.length) {
                    currentSlide = 0;
                } else if (n < 0) {
                    currentSlide = videos.length - 1;
                }

                videos.forEach((video, index) => {
                    video.style.display = index === currentSlide ? 'block' : 'none';
                });
            }

            function startSecondVideo() {
                if (!secondVideoStarted) {
                    const videos = document.querySelectorAll('.carousel-item');
                    if (videos.length > 1) {
                        videos[1].autoplay = true;
                        videos[1].play();
                        secondVideoStarted = true;
                    }
                }
            }

            function changeInfo(memberId) {
                const member = document.getElementById(memberId);
                const info = member.querySelector('.member-info');
                const audio = member.querySelector('audio');

                if (memberId === 'rick-sanchez') {
                    info.innerHTML = "<p>Rick Sanchez</p><p>Amante De La fiesta</p>";
                } else if (memberId === 'morty-smith') {
                    info.innerHTML = "<p>Morty Smith</p><p>Aventurero</p>";
                }

                audio.play();
            }

            function resetInfo(memberId) {
                const member = document.getElementById(memberId);
                const info = member.querySelector('.member-info');
                const audio = member.querySelector('audio');

                if (memberId === 'rick-sanchez') {
                    info.innerHTML = "<p>Rick Sanchez</p><p>CEO</p>";
                } else if (memberId === 'morty-smith') {
                    info.innerHTML = "<p>Morty Smith</p><p>CO-OWNER</p>";
                }

                audio.pause();
                audio.currentTime = 0;
            }
        </script>
    </body>
    <style>
        .start-button {
            display: block;
            margin: 10px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .start-button:hover {
            background-color: #45a049;
        }

        .carousel-item:hover {
            cursor: pointer;
        }

        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .carousel-item {
            width: 100%;
            display: none;
        }

        .member-container {
            display: flex;
        }

        .member {
            position: relative;
            width: 200px;
            height: 300px;
            margin: 10px;
            background-size: cover;
            transition: transform 0.5s ease;
        }

        .member:hover {
            transform: rotate(1080deg);
        }

        .serious-photo,
        .fun-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            position: absolute;
            top: 0;
            left: 0;
            transition: opacity 0.5s ease, filter 0.5s ease;
            filter: grayscale(100%);
        }

        .fun-photo {
            opacity: 0;
            filter: contrast(150%);
        }

        .member:hover .fun-photo {
            opacity: 1;
        }

        .member-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 8px;
            text-align: center;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
            padding-top: 60px;
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 800px;
        }

        .carousel-container {
            overflow: hidden;
        }

        .carousel-content {
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel-item {
            width: 100%;
        }

        video {
            width: 100%;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #808080;
        }

        #youtube-video {
            width: 100%;
            max-width: 800px;
            max-height: 480px;
            margin: 0 auto;
            display: block;
        }
    </style>
</x-geomir-layout>