<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('image/ai.png')}}" type="image/x-icon">
    <title>L Acadimi </title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --royal-purple: #3e0a6e;
            --royal-pink: #ff1493;
            --pure-white: #ffffff;
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

        /* الهيدر */
        header {
            padding: 25px;
            text-align: center;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
            font-weight: 700;
            transition: 0.3s;
            font-size: 1.1rem;
        }

        nav a:hover {
            color: var(--royal-pink);
            text-shadow: 0 0 10px var(--royal-pink);
        }

        /* المحتوى الرئيسي - زيادة المسافة عن الـ Nav */
        main {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            padding: 120px 10% 120px; /* زيادة الـ padding العلوي لتبتعد الأزرار عن الـ nav */
            min-height: 80vh;
        }

        section {
            perspective: 1000px;
        }

        form { width: 100%; }

     
        button {
            width: 100%;
            height: 250px; /* زيادة طول الزر */
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 2px solid var(--glass-border);
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            
            font-family: 'Cairo', sans-serif;
            font-weight: 900;
            font-size: 2.5rem;
            
            /* تدرج النص الافتراضي */
            color: transparent;
            background-clip: text;
            -webkit-background-clip: text;
            background-image: linear-gradient(135deg, var(--royal-pink), var(--royal-purple));
            filter: drop-shadow(0 0 2px rgba(255, 20, 147, 0.5));
        }

       
        button:hover {
            transform: scale(1.05) translateY(-15px);
            border-color: var(--royal-pink);
            box-shadow: 0 20px 50px rgba(255, 20, 147, 0.3);
            background: rgba(255, 255, 255, 0.08);
            
             color:rgba(81, 3, 72, 0.98);;
            background-image: linear-gradient(135deg, var(--royal-pink), var(--pure-white));
            filter: drop-shadow(0 0 15px var(--royal-pink));
        }

        
        footer {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
            padding: 50px 20px;
            text-align: center;
            border-top: 1px solid var(--glass-border);
        }

        footer img {
            width: 45px;
            height: 45px;
            margin: 0 12px;
            transition: 0.4s;
            filter: drop-shadow(0 0 8px var(--royal-pink));
        }

        footer img:hover {
            transform: rotate(360deg) scale(1.3);
        }

        @media (max-width: 768px) {
            main { padding-top: 80px; }
            button { height: 180px; font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <div id="three-container"></div>

    <header>
        <nav>
            <a href="{{route('userNews')}}" target="_blank">الأخبار</a>
            <a href="{{route('pythonEditor')}}" target="_blank">محرر بايثون</a>
            <a href="{{route('forntEndEditor')}}" target="_blank">محرر الويب</a>
        </nav>
    </header>

    <main>
        @foreach($catigory as $c)
        <section>
            <form action="{{route('catigory.show',$c->id)}}" method="get">
                <button type="submit">{{$c->name}}</button>
            </form>
        </section>
        @endforeach
    </main>

    <footer>
        <p style="font-size: 1.2rem; margin-bottom: 20px;">تواصل بنا</p>
        <div>
           <a href="mailto:lisaalaswadi@gmail.com"> 
               <img src="{{asset('image/email.png')}}" alt="إيميل">
           </a>
           <a href="https://wa.me/779947345" target="_blank"> 
               <img src="{{asset('image/whats.png')}}" alt="واتس اب">
           </a>
        </div>
        <p style="margin-top: 30px; opacity: 0.6;">&copy; 2026 L Acadimi. All rights reserved.</p>
    </footer>

    
    <script type="module">
        import * as THREE from 'https://unpkg.com/three@0.136.0/build/three.module.js';

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('three-container').appendChild(renderer.domElement);

        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 7000;
        const posArray = new Float32Array(particlesCount * 3);
        for(let i=0; i < particlesCount * 3; i++) posArray[i] = (Math.random() - 0.5) * 15;

        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        const material = new THREE.PointsMaterial({ 
            size: 0.07, color: 0xff1493, transparent: true, opacity: 0.7, blending: THREE.AdditiveBlending 
        });

        const mesh = new THREE.Points(particlesGeometry, material);
        scene.add(mesh);
        camera.position.z = 5;

        function animate() {
            requestAnimationFrame(animate);
            mesh.rotation.y += 0.0015;
            mesh.rotation.x += 0.0005;
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