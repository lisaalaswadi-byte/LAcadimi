<!DOCTYPE html>
<html lang="ar" dir="rtl">
        <link rel="icon" href="{{asset('image/ai.png')}}" type="image/x-icon">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Python IDE </title>
    <script src="https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js"></script>
    <style>
        :root {
            --royal-purple: #3e0a6e;
            --royal-pink: #ff1493;
            --glass-bg: rgba(255, 255, 255, 0.05);
        }
        body { margin: 0; background: #050505; color: white; font-family: sans-serif; overflow: hidden; }
        #three-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; }
        
        .container { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 20px; height: 90vh; }
        
        .pane { 
            background: var(--glass-bg); 
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; 
            padding: 20px;
            display: flex; flex-direction: column;
        }

        textarea { 
            flex-grow: 1; background: transparent; border: none; color: #fff; 
            font-family: 'Courier New', monospace; font-size: 16px; outline: none; resize: none;
        }

        #output { 
            background: rgba(0,0,0,0.3); border-radius: 10px; padding: 15px; 
            color: #00ff00; font-family: monospace; white-space: pre-wrap; overflow-y: auto;
        }

        button {
            padding: 10px 20px; background: linear-gradient(to right, var(--royal-purple), var(--royal-pink));
            border: none; border-radius: 10px; color: white; font-weight: bold; cursor: pointer;
            margin-bottom: 10px; transition: 0.3s;
        }
        button:hover { transform: scale(1.05); box-shadow: 0 0 15px var(--royal-pink); }
    </style>
</head>
<body>

    <div id="three-container"></div>

    <div class="container">
        <div class="pane">
            <h3 style="color:var(--royal-pink)">Code Editor</h3>
            <button onclick="runPython()">Run Python 🚀</button>
            <textarea id="code" placeholder="print('Hello, Royal Python!')"></textarea>
        </div>
        <div class="pane">
            <h3 style="color:var(--royal-purple)">Console Output</h3>
            <div id="output">...</div>
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
        const posArray = new Float32Array(3000 * 3);
        for(let i=0; i<3000*3; i++) posArray[i] = (Math.random()-0.5)*15;
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        const material = new THREE.PointsMaterial({ size: 0.03, color: 0xff1493 });
        const mesh = new THREE.Points(particlesGeometry, material);
        scene.add(mesh);
        camera.position.z = 5;

        function animate() {
            requestAnimationFrame(animate);
            mesh.rotation.y += 0.002;
            renderer.render(scene, camera);
        }
        animate();
    </script>

    <script>
        let pyodide;
        async function init() {
            pyodide = await loadPyodide();
            document.getElementById('output').innerText = "Python Ready! ✨";
        }
        init();

        async function runPython() {
            const code = document.getElementById('code').value;
            const outputDiv = document.getElementById('output');
            outputDiv.innerText = "Running...";
            
            try {
               
                pyodide.runPython(`
import sys
from io import StringIO
sys.stdout = StringIO()
`);
                await pyodide.runPythonAsync(code);
                const result = pyodide.runPython("sys.stdout.getvalue()");
                outputDiv.innerText = result;
            } catch (err) {
                outputDiv.innerText = err;
            }
        }
    </script>
</body>
</html>