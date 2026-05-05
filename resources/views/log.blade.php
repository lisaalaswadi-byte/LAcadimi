<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{asset('image/ai.png')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | Nebula Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
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
            overflow: hidden; 
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* حاوية محرك Three.js للسديم */
        #three-container { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            z-index: -1; 
        }

        /* تصميم بطاقة تسجيل الدخول الشفافة */
        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            padding: 40px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            animation: cardAppear 1s ease-out;
            position: relative;
            z-index: 10;
        }

        @keyframes cardAppear {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        h2 {
            text-align: center;
            color: var(--royal-pink);
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 0 0 15px rgba(255, 20, 147, 0.4);
        }

        .form-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: white;
            font-family: 'Cairo', sans-serif;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
            text-align: center;
        }

        input:focus {
            border-color: var(--royal-pink);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 15px rgba(255, 20, 147, 0.2);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, var(--royal-purple), var(--royal-pink));
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            font-family: 'Cairo', sans-serif;
            margin-top: 10px;
        }

        button:hover {
            transform: scale(1.03);
            box-shadow: 0 0 20px var(--royal-pink);
        }

    </style>
</head>
<body>

    <div id="three-container"></div>

    {{-- معالجة السيشن والأخطاء بنظام الـ Alerts --}}
    @if(session("f")) 
        <script>alert("{{session('f')}}");</script>
    @endif

    @foreach($errors->all() as $e)
        <script>alert("{{$e}}");</script>
    @endforeach

    <div class="login-card">
        <h2>تسجيل الدخول</h2>
        
        <form action="{{route('setLogin')}}" method="post">
            @csrf  
            
            <div class="form-group">
                <input type="email" name="email" placeholder="ادخل البريد الإلكتروني" required>
            </div>

            <div class="form-group">
                <input type="text" name="name" placeholder="ادخل اسمك بالكامل" required>
            </div>

            <button type="submit">دخول إلى المنصة </button>
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
        const particlesCount = 7000; 
        const posArray = new Float32Array(particlesCount * 3);

        for(let i = 0; i < particlesCount * 3; i++) {
            posArray[i] = (Math.random() - 0.5) * 20; 
        }

        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));

        const material = new THREE.PointsMaterial({ 
            size: 0.07, 
            color: 0xff1493, 
            transparent: true,
            opacity: 0.7,
            blending: THREE.AdditiveBlending
        });

        const particlesMesh = new THREE.Points(particlesGeometry, material);
        scene.add(particlesMesh);

        camera.position.z = 5;

        let mouseX = 0;
        let mouseY = 0;
        document.addEventListener('mousemove', (event) => {
            mouseX = (event.clientX / window.innerWidth) - 0.5;
            mouseY = (event.clientY / window.innerHeight) - 0.5;
        });

        function animate() {
            requestAnimationFrame(animate);

           
            particlesMesh.rotation.y += 0.0012;
            
            particlesMesh.rotation.y += mouseX * 0.04;
            particlesMesh.rotation.x += -mouseY * 0.04;

            renderer.render(scene, camera);
        }

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        animate();
    </script>
</body>
</html>