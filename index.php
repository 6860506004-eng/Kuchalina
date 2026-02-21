<?php
/*
$servername = "s6860506004db-kushalina-ycaivu";
$username = "Nina6860506004";
$password = "1859900347014";
$dbname = "Nina";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
echo "<div style='background: white; padding: 10px; color: green; text-align: center;'>เชื่อมต่อฐานข้อมูล MariaDB สำเร็จ!</div>";
*/
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Binary Search Tree Visualizer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Kanit:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #a855f7;
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --text-dark: #1f2937;
            --node-fill: #ffffff;
            --node-stroke: #6366f1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Kanit', sans-serif;
        }

        body {
            min-height: 100vh;
            background: var(--bg-gradient);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--text-dark);
        }

        .container {
            background: var(--glass-bg);
            width: 100%;
            max-width: 1000px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            padding: 40px;
            backdrop-filter: blur(10px);
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        header h1 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        header p {
            color: #6b7280;
            font-weight: 300;
        }

        .controls {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        input[type="number"] {
            padding: 12px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            outline: none;
            transition: 0.3s;
            width: 150px;
            font-size: 1rem;
        }

        input[type="number"]:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        button {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 500;
            transition: 0.3s;
            font-size: 1rem;
        }

        .btn-insert {
            background: var(--primary-color);
            color: white;
        }

        .btn-insert:hover {
            background: #4f46e5;
            transform: translateY(-2px);
        }

        .btn-reset {
            background: #ef4444;
            color: white;
        }

        .btn-reset:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* Tree Visualization Area */
        #tree-container {
            width: 100%;
            height: 400px;
            border: 2px dashed #e5e7eb;
            border-radius: 20px;
            margin-bottom: 30px;
            position: relative;
            overflow: auto;
            background: #f9fafb;
        }

        svg {
            width: 100%;
            height: 100%;
        }

        .node circle {
            fill: var(--node-fill);
            stroke: var(--node-stroke);
            stroke-width: 3px;
            transition: 0.5s;
        }

        .node text {
            font-weight: 600;
            font-size: 14px;
            fill: var(--text-dark);
        }

        .link {
            fill: none;
            stroke: #cbd5e1;
            stroke-width: 2px;
            transition: 0.5s;
        }

        /* Results Traversal */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .result-card {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 16px;
            border-left: 5px solid var(--secondary-color);
        }

        .result-card h3 {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .result-card p {
            font-size: 1.1rem;
            font-weight: 500;
            word-break: break-all;
            color: var(--text-dark);
        }

        .order-info {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 5px;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        .node { animation: fadeIn 0.4s ease-out; }

    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Binary Search Tree Visualizer</h1>
        <p>เครื่องมือจำลองโครงสร้างข้อมูลแบบต้นไม้</p>
    </header>

    <div class="controls">
        <input type="number" id="node-value" placeholder="ใส่ตัวเลข..." onkeypress="if(event.key === 'Enter') insertNode()">
        <button class="btn-insert" onclick="insertNode()">+ เพิ่มข้อมูล</button>
        <button class="btn-reset" onclick="resetTree()">ล้างข้อมูล</button>
    </div>

    <div id="tree-container">
        <svg id="tree-svg"></svg>
    </div>

    <div class="results-grid">
        <div class="result-card">
            <h3>Preorder</h3>
            <p id="preorder-result">-</p>
            <div class="order-info">(Root → Left → Right)</div>
        </div>
        <div class="result-card">
            <h3>Inorder</h3>
            <p id="inorder-result">-</p>
            <div class="order-info">(Left → Root → Right)</div>
        </div>
        <div class="result-card">
            <h3>Postorder</h3>
            <p id="postorder-result">-</p>
            <div class="order-info">(Left → Right → Root)</div>
        </div>
    </div>
</div>

<script>
    class Node {
        constructor(value) {
            this.value = value;
            this.left = null;
            this.right = null;
            this.x = 0;
            this.y = 0;
        }
    }

    let root = null;
    const svg = document.getElementById('tree-svg');
    const nodeRadius = 22;
    const verticalSpacing = 70;

    function insertNode() {
        const input = document.getElementById('node-value');
        const value = parseInt(input.value);
        
        if (isNaN(value)) return;
        
        const newNode = new Node(value);
        if (root === null) {
            root = newNode;
        } else {
            insertRecursive(root, newNode);
        }
        
        input.value = '';
        input.focus();
        updateVisualization();
    }

    function insertRecursive(current, newNode) {
        if (newNode.value < current.value) {
            if (current.left === null) current.left = newNode;
            else insertRecursive(current.left, newNode);
        } else {
            if (current.right === null) current.right = newNode;
            else insertRecursive(current.right, newNode);
        }
    }

    function resetTree() {
        root = null;
        updateVisualization();
    }

    function updateVisualization() {
        svg.innerHTML = '';
        if (root) {
            // คำนวณตำแหน่ง (ใช้วิธีระบุพิกัดแบบง่าย)
            assignPositions(root, svg.clientWidth / 2, 50, svg.clientWidth / 4);
            drawLinks(root);
            drawNodes(root);
        }
        updateTraversals();
    }

    function assignPositions(node, x, y, spacing) {
        if (!node) return;
        node.x = x;
        node.y = y;
        if (node.left) assignPositions(node.left, x - spacing, y + verticalSpacing, spacing / 1.5);
        if (node.right) assignPositions(node.right, x + spacing, y + verticalSpacing, spacing / 1.5);
    }

    function drawLinks(node) {
        if (!node) return;
        if (node.left) {
            createLine(node.x, node.y, node.left.x, node.left.y);
            drawLinks(node.left);
        }
        if (node.right) {
            createLine(node.x, node.y, node.right.x, node.right.y);
            drawLinks(node.right);
        }
    }

    function createLine(x1, y1, x2, y2) {
        const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
        line.setAttribute("x1", x1);
        line.setAttribute("y1", y1);
        line.setAttribute("x2", x2);
        line.setAttribute("y2", y2);
        line.setAttribute("class", "link");
        svg.appendChild(line);
    }

    function drawNodes(node) {
        if (!node) return;
        
        const g = document.createElementNS("http://www.w3.org/2000/svg", "g");
        g.setAttribute("class", "node");

        const circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
        circle.setAttribute("cx", node.x);
        circle.setAttribute("cy", node.y);
        circle.setAttribute("r", nodeRadius);
        
        const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
        text.setAttribute("x", node.x);
        text.setAttribute("y", node.y + 5);
        text.setAttribute("text-anchor", "middle");
        text.textContent = node.value;

        g.appendChild(circle);
        g.appendChild(text);
        svg.appendChild(g);

        drawNodes(node.left);
        drawNodes(node.right);
    }

    // Traversal Logic
    function updateTraversals() {
        const pre = [];
        const ino = [];
        const pos = [];
        
        preOrder(root, pre);
        inOrder(root, ino);
        postOrder(root, pos);
        
        document.getElementById('preorder-result').textContent = pre.join(', ') || '-';
        document.getElementById('inorder-result').textContent = ino.join(', ') || '-';
        document.getElementById('postorder-result').textContent = pos.join(', ') || '-';
    }

    function preOrder(node, arr) {
        if (!node) return;
        arr.push(node.value);
        preOrder(node.left, arr);
        preOrder(node.right, arr);
    }

    function inOrder(node, arr) {
        if (!node) return;
        inOrder(node.left, arr);
        arr.push(node.value);
        inOrder(node.right, arr);
    }

    function postOrder(node, arr) {
        if (!node) return;
        postOrder(node.left, arr);
        postOrder(node.right, arr);
        arr.push(node.value);
    }

    // ปรับขนาด SVG ตามหน้าจอ
    window.addEventListener('resize', updateVisualization);
</script>

</body>

</html>

