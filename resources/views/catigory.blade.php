<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
        <link rel="icon" href="{{asset('image/ai.png')}}" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$course->name}} | L Acadimi Lessons</title>
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

        .page-header {
            text-align: center;
            padding: 60px 20px;
            z-index: 10;
            position: relative;
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(to bottom, #fff, var(--royal-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }

        /* شبكة الفيديوهات - 3 فيديوهات في الصف */
        main {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* عرض 3 أعمدة متساوية */
            gap: 30px;
            padding: 20px 5% 100px;
            z-index: 10;
            position: relative;
        }

        article {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s ease;
            transform-style: preserve-3d;
        }

        article:hover {
            transform: translateY(-10px) rotateX(2deg);
            border-color: var(--royal-pink);
            box-shadow: 0 15px 40px rgba(255, 20, 147, 0.2);
        }

        /* أبعاد الفيديو مثل يوتيوب 16:9 */
        .video-wrapper {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* نسبة الارتفاع للعرض (9/16 * 100) */
            background: #000;
        }

        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        p {
            padding: 20px;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
            text-align: center;
            background: rgba(0, 0, 0, 0.2);
            color: #fff;
            border-top: 1px solid var(--glass-border);
        }

        /* منع التحميل للجوال عبر لمسة طويلة */
        video {
            -webkit-touch-callout: none;
        }

        /* تنسيق الاستجابة للشاشات الصغيرة */
        @media (max-width: 1100px) {
            main { grid-template-columns: repeat(2, 1fr); } /* فيديوهين في الصف */
        }

        @media (max-width: 768px) {
            main { grid-template-columns: 1fr; } /* فيديو واحد في الصف */
            .page-header h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <div id="three-container"></div>

    <header class="page-header">
        <h1>{{$course->name}}</h1>
    </header>

    <main>
        @foreach($course->videos as $c)
        <article>
            <div class="video-wrapper">
                <video 
                    controls 
                    controlsList="nodownload" 
                    oncontextmenu="return false;" 
                    poster="{{asset('image/l.png')}}">
                    <source src="{{asset('storage/'.$c->video)}}" type="video/mp4">
                    متصفحك لا يدعم تشغيل الفيديو.
                </video>
            </div>
            <p>{{$c->title}}</p>
        </article>
        @endforeach
    </main>

    <script type="module">
        import * as THREE from 'https://unpkg.com/three@0.136.0/build/three.module.js';

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('three-container').appendChild(renderer.domElement);

        const particlesGeometry = new THREE.BufferGeometry();
        const posArray = new Float32Array(5000 * 3);
        for(let i=0; i < 5000 * 3; i++) posArray[i] = (Math.random() - 0.5) * 15;
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