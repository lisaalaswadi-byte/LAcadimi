<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="{{asset('image/ai.png')}}" type="image/x-icon">

    <title>L Acadimi News </title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --royal-purple: #3e0a6e;
            --royal-pink: #ff1493;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            margin: 0;
            background: #050505;
            color: white;
            font-family: 'Cairo', sans-serif;
            overflow-x: hidden;
        }

        #three-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* حاوية الأخبار - ترتيب من اليسار إلى اليمين */
        main {
            display: flex;
            flex-wrap: wrap; /* النزول لسطر جديد تلقائياً */
            justify-content: center; /* توسيط البطاقات */
            gap: 30px;
            padding: 50px 5%;
            perspective: 1000px;
        }

        /* تصميم بطاقة الخبر 3D */
        .news-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            width: 350px; /* عرض ثابت للبطاقة */
            display: flex;
            flex-direction: column;
            transition: all 0.5s ease;
            transform-style: preserve-3d;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .news-card:hover {
            transform: translateY(-10px) rotateY(5deg);
            border-color: var(--royal-pink);
            box-shadow: 0 20px 40px rgba(255, 20, 147, 0.2);
        }

        /* حاوية الصورة */
        .image-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 20px 20px 0 0;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* تفاصيل الخبر */
        .content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        article {
            font-size: 1.1rem;
            line-height: 1.6;
            font-weight: 700;
            margin-bottom: 15px;
            color: #fff;
        }

        .date-badge {
            align-self: flex-start;
            padding: 4px 12px;
            background: linear-gradient(90deg, var(--royal-purple), var(--royal-pink));
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .page-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 900;
            margin-top: 40px;
            background: linear-gradient(to bottom, #fff, var(--royal-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>

    <div id="three-container"></div>

    <h1 class="page-title">أخبار الأكاديمية</h1>

    <main>
        @foreach($news as $n)
        <div class="news-card">
            
            
            @if($n->image)
            <div class="image-container">
                <img src="{{asset('storage/'.$n->image)}}" alt="News Image">
            </div>
            @endif
            
            <div class="content">
                <article>{{$n->info}}</article>
                <div class="date-badge">
                    {{$n->created_at->format("Y-M-D")}}
                </div>
            </div>
        </div>
        @endforeach
    </main>

    <!-- محرك السديم الملكي 3D -->
    <script type="module">
        import * as THREE from 'https://unpkg.com/three@0.136.0/build/three.module.js';

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('three-container').appendChild(renderer.domElement);

        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 4000;
        const posArray = new Float32Array(particlesCount * 3);
        for(let i=0; i < particlesCount * 3; i++) posArray[i] = (Math.random() - 0.5) * 15;

        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        const material = new THREE.PointsMaterial({ 
            size: 0.03, color: 0xff1493, transparent: true, opacity: 0.6, blending: THREE.AdditiveBlending 
        });

        const mesh = new THREE.Points(particlesGeometry, material);
        scene.add(mesh);
        camera.position.z = 5;

        function animate() {
            requestAnimationFrame(animate);
            mesh.rotation.y += 0.001;
            renderer.render(scene, camera);
        }
        animate();

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html>