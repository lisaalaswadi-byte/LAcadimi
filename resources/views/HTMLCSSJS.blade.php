<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
        <link rel="icon" href="{{asset('image/ai.png')}}" type="image/x-icon">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Code Editor </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --royal-purple: #3e0a6e;
            --royal-pink: #ff1493;
            --glass-bg: rgba(255, 255, 255, 0.08);
            --text-color: #ffffff;
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        body { 
            margin: 0; 
            background: #050505; 
            color: var(--text-color); 
            font-family: 'Segoe UI', sans-serif; 
            overflow: hidden; 
        }

        
        #three-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; }

        /* الهيكل */
        header { display: flex; justify-content: space-between; padding: 20px 40px; align-items: center; z-index: 10; }
        .container { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 20px; height: 80vh; }

        /* تصميم الألواح الملكي (Glassmorphism) */
        .pane { 
            background: var(--glass-bg); 
            backdrop-filter: blur(15px);
            border-radius: 25px; 
            padding: 20px; 
            display: flex; 
            flex-direction: column; 
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }

        .pane:hover {
            transform: translateY(-5px);
            border-color: var(--royal-pink);
            box-shadow: 0 0 30px rgba(255, 20, 147, 0.3);
        }

        .pane-header { display: flex; align-items: center; margin-bottom: 15px; font-weight: bold; color: var(--text-color); }
        .pane-header i { margin-left: 10px; font-size: 1.4rem; }

        textarea { 
            width: 100%; height: 100%; border: none; outline: none; 
            background: transparent; color: #fff; 
            font-family: 'Courier New', monospace; resize: none; font-size: 15px;
        }

        iframe { width: 100%; height: 100%; background: #fff; border-radius: 15px; border: none; }

        .switch { position: relative; display: inline-block; width: 60px; height: 30px; }
        .switch input { opacity: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #333; border-radius: 34px; transition: .4s; }
        .slider:before { position: absolute; content: ""; height: 22px; width: 22px; left: 4px; bottom: 4px; background: white; border-radius: 50%; transition: .4s; }
        input:checked + .slider { background: linear-gradient(to right, var(--royal-pink), var(--royal-purple)); }
        input:checked + .slider:before { transform: translateX(30px); }
    </style>
</head>
<body>

    <div id="three-container"></div>

    <header>
        <h2 style="margin: 0; letter-spacing: 2px;">CODE EDITOR</h2>
        <label class="switch">
            <input type="checkbox" onclick="toggleTheme()">
            <span class="slider"></span>
        </label>
    </header>

    <div class="container">
        <div class="pane">
            <div class="pane-header"><i class="fab fa-html5" style="color: #ff5722;"></i> HTML</div>
            <textarea id="html" onKeyup="run()" placeholder=""></textarea>
        </div>
        <div class="pane">
            <div class="pane-header"><i class="fab fa-css3-alt" style="color: #2196f3;"></i> CSS</div>
            <textarea id="css" onKeyup="run()" placeholder="/* start designing*/"></textarea>
        </div>
        <div class="pane">
            <div class="pane-header"><i class="fab fa-js-square" style="color: #fdd835;"></i> JS</div>
            <textarea id="js" onKeyup="run()" placeholder="// code logic"></textarea>
        </div>
        <div class="pane">
            <div class="pane-header"><i class="fas fa-magic" style="color: #9c27b0;"></i> Output</div>
            <iframe id="output"></iframe>
        </div>
    </div>

    <script type="module">
        import * as THREE from 'https://unpkg.com/three@0.136.0/build/three.module.js';

       
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.getElementById('three-container').appendChild(renderer.domElement);

        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 3000;
        const posArray = new Float32Array(particlesCount * 3);
        for(let i = 0; i < particlesCount * 3; i++) posArray[i] = (Math.random() - 0.5) * 15;
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        const material = new THREE.PointsMaterial({ size: 0.03, color: 0xff1493, transparent: true, opacity: 0.6 });
        const particlesMesh = new THREE.Points(particlesGeometry, material);
        scene.add(particlesMesh);
        camera.position.z = 5;

        function animate() {
            requestAnimationFrame(animate);
            particlesMesh.rotation.y += 0.002;
            renderer.render(scene, camera);
        }
        animate();

        // وظائف المحرر
        function run(){
            let htmlCode = document.getElementById("html").value;
            let cssCode = "<style>" + document.getElementById("css").value + "</style>";
            let jsCode = document.getElementById("js").value;
            let output = document.getElementById("output").contentDocument;
            output.open();
            output.write(htmlCode + cssCode + `<script>${jsCode}<\/script>`);
            output.close();
        }
        window.run = run;

        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
        }
        window.toggleTheme = toggleTheme;
    </script>
</body>
</html>