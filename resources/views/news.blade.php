<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
        <link rel="icon" href="{{asset('image/ai.png')}}" type="image/x-icon">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نشر الأخبار </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --royal-purple: #3e0a6e;
            --royal-pink: #ff1493;
            --glass-bg: rgba(255, 255, 255, 0.06);
            --text-color: #ffffff;
        }

        body { 
            margin: 0; background: #050505; color: var(--text-color); 
            font-family: 'Segoe UI', sans-serif; display: flex; 
            justify-content: center; align-items: center; height: 100vh;
            overflow: hidden;
        }

        #three-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; }

        .panel {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }

        h2 { margin-bottom: 25px; color: var(--royal-pink); }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.05);
            border: 1px dashed var(--royal-pink);
            border-radius: 15px;
            color: #fff;
            cursor: pointer;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 15px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 15px;
            color: white;
            font-family: sans-serif;
            resize: none;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, var(--royal-purple), var(--royal-pink));
            border: none;
            border-radius: 15px;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover { transform: scale(1.02); box-shadow: 0 0 20px rgba(255, 20, 147, 0.5); }
    </style>
</head>
<body>

    <div id="three-container"></div>

    <div class="panel">
        @if(session("pop"))
        <script>
            alert("successfully published");
        </script>
        @endif
        <h2>نشر خبر جديد 📢</h2>
        <form action="{{route('setInfos')}}" method="POST" enctype="multipart/form-data">
            @csrf 
            <input type='file' name='image' id='video' title='اختر ملف للخبر'>
            <textarea name='info' placeholder="اكتب تفاصيل الخبر هنا..."></textarea>
            <button type='submit' title='نشر الخبر'>نشر الآن</button>
        </form>
    </div>

    <script type="module">
        import * as THREE from 'https://unpkg.com/three@0.136.0/build/three.module.js';
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('three-container').appendChild(renderer.domElement);

        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 2000;
        const posArray = new Float32Array(particlesCount * 3);
        for(let i = 0; i < particlesCount * 3; i++) posArray[i] = (Math.random() - 0.5) * 15;
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        const material = new THREE.PointsMaterial({ size: 0.03, color: 0xff1493, transparent: true, opacity: 0.6 });
        const particlesMesh = new THREE.Points(particlesGeometry, material);
        scene.add(particlesMesh);
        camera.position.z = 5;

        function animate() {
            requestAnimationFrame(animate);
            particlesMesh.rotation.y += 0.001;
            renderer.render(scene, camera);
        }
        animate();
    </script>
</body>
</html>