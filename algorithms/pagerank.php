<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PageRank R&D Simulator</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" onerror="handleScriptError('Three.js failed to load')"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js?config=TeX-MML-AM_CHTML" onerror="handleScriptError('MathJax failed to load')"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.30.1/min/vs/loader.min.js" onerror="handleScriptError('Monaco Editor failed to load')"></script>
    <style>
        :root {
            --bg-color: #0a0a0a;
            --node-color: #00b7ff;
            --edge-color: #00ff88;
            --text-color: #ffffff;
            --highlight-color: #ffeb3b;
            --panel-bg: rgba(20, 20, 20, 0.95);
            --modal-bg: #1a1a1a;
            --sidebar-width: 320px;
            --particle-color: #00ff88;
            --tooltip-bg: #333;
        }

        body {
            margin: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--panel-bg);
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
            position: fixed;
            height: 100%;
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed {
            transform: translateX(calc(-1 * var(--sidebar-width)));
        }

        .toggle-sidebar {
            position: fixed;
            top: 10px;
            left: 10px;
            background: var(--node-color);
            border: none;
            color: var(--text-color);
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1001;
        }

        .canvas-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            position: relative;
        }

        .canvas-container.collapsed {
            margin-left: 0;
        }

        canvas, #threeCanvas {
            background: var(--bg-color);
            cursor: move;
        }

        button {
            padding: 10px;
            background-color: var(--node-color);
            border: none;
            color: var(--text-color);
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.2s;
            position: relative;
        }

        button:hover {
            background-color: var(--highlight-color);
            color: #000;
            transform: scale(1.05);
        }

        button:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--tooltip-bg);
            color: var(--text-color);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
        }

        .input-form, .settings, .metrics-panel, .achievements {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
        }

        input, select {
            padding: 8px;
            border-radius: 5px;
            border: none;
            background: #333;
            color: var(--text-color);
            font-size: 14px;
        }

        .progress-bar {
            width: 100%;
            height: 15px;
            background: #222;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background: var(--highlight-color);
            transition: width 0.5s ease-in-out;
        }

        .info-panel, .leaderboard, .rank-chart, .metrics-panel, .achievements {
            background: var(--panel-bg);
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            border: 1px solid #444;
        }

        .info-panel {
            max-height: 150px;
            overflow-y: auto;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: var(--modal-bg);
            padding: 20px;
            border-radius: 5px;
            max-width: 800px;
            max-height: 85vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.3);
        }

        .modal-content h2 {
            margin-top: 0;
            color: var(--highlight-color);
        }

        .modal-content pre {
            background: #222;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 12px;
            line-height: 1.5;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: var(--highlight-color);
        }

        .close-btn:hover {
            color: #fff;
        }

        #codeEditor {
            height: 200px;
            border: 1px solid #444;
            border-radius: 5px;
        }

        .theme-toggle {
            display: flex;
            gap: 10px;
        }

        .theme-toggle label {
            cursor: pointer;
        }

        .high-contrast {
            --bg-color: #000000;
            --node-color: #00ffff;
            --edge-color: #00ff00;
            --text-color: #ffffff;
            --highlight-color: #ffff00;
            --panel-bg: rgba(50, 50, 50, 0.95);
            --modal-bg: #333333;
            --particle-color: #00ff00;
        }
    </style>
</head>
<body>
    <button class="toggle-sidebar" onclick="toggleSidebar()" data-tooltip="Toggle Sidebar" aria-label="Toggle Sidebar">☰</button>
    <div class="sidebar" id="sidebar">
        <button onclick="startGame()" data-tooltip="Run PageRank simulation" aria-label="Start Simulation">Start Simulator</button>
        <button onclick="resetGame()" data-tooltip="Reset ranks and votes" aria-label="Reset Simulation">Reset</button>
        <button onclick="showExplanation()" data-tooltip="Learn how PageRank works" aria-label="Show Explanation">Show Explanation</button>
        <button onclick="saveGraph()" data-tooltip="Save graph to local storage" aria-label="Save Graph">Save Graph</button>
        <button onclick="loadGraph()" data-tooltip="Load saved graph" aria-label="Load Graph">Load Graph</button>
        <button onclick="exportData()" data-tooltip="Export rank history as CSV" aria-label="Export Data">Export Data</button>
        <button onclick="runBatchAnalysis()" data-tooltip="Run simulations with varying damping factors" aria-label="Batch Analysis">Batch Analysis</button>
        <button onclick="startTutorial()" data-tooltip="Start guided tutorial" aria-label="Start Tutorial">Start Tutorial</button>
        <button onclick="startChallenge()" data-tooltip="Try a predefined challenge" aria-label="Start Challenge">Start Challenge</button>
        <button onclick="recordVideo()" data-tooltip="Record simulation as video" aria-label="Record Video">Record Video</button>
        <div class="input-form">
            <label for="nodeInputs">Website Names:</label>
            <div id="nodeInputs">
                <input type="text" id="node0" placeholder="Node 0 Name" value="Wikipedia" aria-label="Node 0 Name">
                <input type="text" id="node1" placeholder="Node 1 Name" value="BBC" aria-label="Node 1 Name">
                <input type="text" id="node2" placeholder="Node 2 Name" value="CNN" aria-label="Node 2 Name">
                <input type="text" id="node3" placeholder="Node 3 Name" value="Blog" aria-label="Node 3 Name">
                <input type="text" id="node4" placeholder="Node 4 Name" value="Forum" aria-label="Node 4 Name">
            </div>
            <button onclick="addNode()" data-tooltip="Add a new website (max 50)" aria-label="Add Website">Add Website</button>
            <button onclick="removeNode()" data-tooltip="Remove the last website" aria-label="Remove Website">Remove Website</button>
            <label for="fromNode">Manage Links:</label>
            <select id="fromNode" aria-label="From Node"></select>
            <select id="toNode" aria-label="To Node"></select>
            <input type="number" id="linkWeight" min="0.1" max="1.0" step="0.1" value="1.0" aria-label="Link Weight">
            <button onclick="addLink()" data-tooltip="Add a weighted hyperlink" aria-label="Add Link">Add Link</button>
            <button onclick="removeLink()" data-tooltip="Remove a hyperlink" aria-label="Remove Link">Remove Link</button>
        </div>
        <div class="settings">
            <label for="dampingFactor">Damping Factor (0.5-0.95):</label>
            <input type="number" id="dampingFactor" min="0.5" max="0.95" step="0.05" value="0.85" aria-label="Damping Factor">
            <label for="convergenceThreshold">Convergence Threshold:</label>
            <input type="number" id="convergenceThreshold" min="0.001" max="0.1" step="0.001" value="0.01" aria-label="Convergence Threshold">
            <label for="algorithm">Algorithm:</label>
            <select id="algorithm" aria-label="Select Algorithm">
                <option value="pagerank">PageRank</option>
                <option value="hits">HITS</option>
            </select>
            <label>Theme:</label>
            <div class="theme-toggle">
                <label><input type="radio" name="theme" value="default" checked onchange="setTheme('default')" aria-label="Default Theme"> Default</label>
                <label><input type="radio" name="theme" value="neon" onchange="setTheme('neon')" aria-label="Neon Theme"> Neon</label>
                <label><input type="radio" name="theme" value="matrix" onchange="setTheme('matrix')" aria-label="Matrix Theme"> Matrix</label>
            </div>
            <label><input type="checkbox" id="highContrast" onchange="toggleHighContrast()" aria-label="High Contrast Mode"> High Contrast</label>
            <label for="viewMode">View Mode:</label>
            <select id="viewMode" onchange="toggleViewMode()" aria-label="View Mode">
                <option value="2d">2D Canvas</option>
                <option value="3d">3D WebGL</option>
            </select>
        </div>
        <label for="voteButtons">Vote for Websites:</label>
        <div id="voteButtons">
            <button onclick="voteForNode(0)" data-tooltip="Boost Node 0's rank" aria-label="Vote for Node 0">Vote Node 0</button>
            <button onclick="voteForNode(1)" data-tooltip="Boost Node 1's rank" aria-label="Vote for Node 1">Vote Node 1</button>
            <button onclick="voteForNode(2)" data-tooltip="Boost Node 2's rank" aria-label="Vote for Node 2">Vote Node 2</button>
            <button onclick="voteForNode(3)" data-tooltip="Boost Node 3's rank" aria-label="Vote for Node 3">Vote Node 3</button>
            <button onclick="voteForNode(4)" data-tooltip="Boost Node 4's rank" aria-label="Vote for Node 4">Vote Node 4</button>
        </div>
        <div class="progress-bar">
            <div class="progress" id="progress"></div>
        </div>
        <div class="info-panel" id="info">Click 'Start Simulator' to run PageRank. Customize the web graph and adjust settings for research.</div>
        <div class="leaderboard" id="leaderboard">Leaderboard:<br>Calculating...</div>
        <div class="rank-chart">
            <canvas id="rankChart" width="280" height="150"></canvas>
        </div>
        <div class="metrics-panel">
            <h3>Graph Metrics</h3>
            <p>Density: <span id="graphDensity">0.00</span></p>
            <p>Max In-Degree: <span id="maxInDegree">0</span></p>
            <p>Clustering Coefficient: <span id="clusteringCoefficient">0.00</span></p>
            <canvas id="degreeChart" width="280" height="100"></canvas>
            <canvas id="convergenceChart" width="280" height="100"></canvas>
        </div>
        <div class="achievements">
            <h3>Achievements</h3>
            <ul id="achievementList"></ul>
        </div>
    </div>
    <div class="canvas-container" id="canvasContainer">
        <canvas id="canvas" width="800" height="600"></canvas>
        <div id="threeCanvas" style="display: none;"></div>
    </div>
    <div class="modal" id="explanationModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">×</span>
            <h2>PageRank Algorithm: R&D Perspective</h2>
            <p>Google's PageRank algorithm ranks web pages by importance in a directed graph where pages are nodes and hyperlinks are edges. This simulator is designed for advanced research and experimentation.</p>
            <h3>How It Works</h3>
            <ul>
                <li><strong>Graph Model</strong>: Pages are nodes; hyperlinks are weighted edges. Add/remove nodes (up to 50) and links.</li>
                <li><strong>Initial Rank</strong>: Nodes start with rank 1. Voting boosts ranks, simulating external authority.</li>
                <li><strong>Rank Distribution</strong>: A node with rank R and N weighted outgoing links distributes \( R \times w_i / \sum w \) to each linked node, where \( w_i \) is the link weight.</li>
                <li><strong>Damping Factor</strong>: Adjustable damping factor (d, 0.5–0.95) models random surfing. Base rank: \( (1 - d)/N \).</li>
                <li><strong>Mathematical Formulation</strong>: For node \( i \), PageRank is:
                    \[
                    PR(i) = \frac{1 - d}{N} + d \sum_{j \in B_i} \frac{PR(j) \cdot w_{ji}}{\sum_{k \in L_j} w_{jk}}
                    \]
                    where \( B_i \) is nodes linking to \( i \), \( w_{ji} \) is the weight of the link from \( j \) to \( i \), and \( L_j \) is \( j \)'s outgoing links.</li>
                <li><strong>HITS Algorithm</strong>: Hyperlink-Induced Topic Search assigns authority and hub scores:
                    \[
                    A(i) = \sum_{j \in B_i} H(j), \quad H(i) = \sum_{j \in L_i} A(j)
                    \]
                    Normalized after each iteration.</li>
                <li><strong>Convergence</strong>: Iterates until total change < threshold or 10 iterations. Higher-ranked nodes have more incoming links from high-ranked nodes.</li>
                <li><strong>R&D Applications</strong>:
                    <ul>
                        <li><strong>Web Search</strong>: Prioritizes authoritative pages.</li>
                        <li><strong>Network Analysis</strong>: Social, citation, biological networks.</li>
                        <li><strong>Recommendations</strong>: Ranks items by connectivity.</li>
                        <li><strong>Research</strong>: Study graph algorithms, convergence, and parameter effects.</li>
                    </ul>
                </li>
                <li><strong>Simulator Features</strong>:
                    <ul>
                        <li>Build graphs with weighted links and draggable nodes.</li>
                        <li>Adjust damping factor, convergence threshold, and algorithm (PageRank/HITS).</li>
                        <li>Save/load graphs to local storage and export CSV.</li>
                        <li>Analyze metrics (density, in-degree, clustering) and convergence.</li>
                        <li>Run batch simulations, tutorials, and challenges.</li>
                        <li>Record videos, customize algorithms, and earn achievements.</li>
                    </ul>
                </li>
            </ul>
            <h3>Interactive Equation Editor</h3>
            <p>Modify the damping factor in the PageRank equation:</p>
            <div id="equation">\[ PR(i) = \frac{1 - <span id="dampingDisplay">0.85</span>}{N} + <span id="dampingDisplay2">0.85</span> \sum_{j \in B_i} \frac{PR(j) \cdot w_{ji}}{\sum_{k \in L_j} w_{jk}} \]</div>
            <label>Damping Factor: <input type="number" id="equationDamping" min="0.5" max="0.95" step="0.05" value="0.85" oninput="updateEquation()"></label>
            <h3>Custom Algorithm</h3>
            <div id="codeEditor"></div>
            <button onclick="runCustomAlgorithm()" data-tooltip="Run custom ranking function">Run Custom Algorithm</button>
            <h3>PageRank Code Example</h3>
            <pre>
function computePageRank(nodes, damping) {
    const n = nodes.length;
    const newRanks = new Array(n).fill(0);
    let totalChange = 0;

    nodes.forEach((node, i) => {
        newRanks[i] = (1 - damping) / n;
        nodes.forEach(other => {
            if (other.links.some(l => l.id === node.id)) {
                const weight = other.links.find(l => l.id === node.id).weight;
                const totalWeight = other.links.reduce((sum, l) => sum + l.weight, 0);
                newRanks[i] += damping * (other.rank * weight / totalWeight);
            }
        });
    });

    nodes.forEach((node, i) => {
        totalChange += Math.abs(node.rank - newRanks[i]);
        node.rank = newRanks[i];
        node.rankHistory.push(node.rank);
        if (node.rankHistory.length > 10) node.rankHistory.shift();
    });

    return totalChange;
}
            </pre>
            <p>Experiment with graph structures, algorithms, and settings. Use metrics and exports for in-depth analysis.</p>
        </div>
    </div>
    <div class="modal" id="tutorialModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeTutorial()">×</span>
            <h2>Tutorial</h2>
            <p id="tutorialText"></p>
            <button onclick="nextTutorialStep()" data-tooltip="Proceed to next step">Next</button>
        </div>
    </div>
    <script>
        // Error handling
        function handleScriptError(message) {
            const infoPanel = document.getElementById('info');
            if (infoPanel) {
                infoPanel.innerHTML = `Error: ${message}. Some features may be unavailable.`;
            }
            console.error(message);
        }

        // Initialize Monaco Editor
        let editor;
        try {
            require.config({ paths: { vs: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.30.1/min/vs' } });
            require(['vs/editor/editor.main'], () => {
                editor = monaco.editor.create(document.getElementById('codeEditor'), {
                    value: `function customRank(nodes, damping) {\n    // Example: Modify ranks\n    nodes.forEach(node => {\n        node.rank *= 1.1;\n    });\n    return 0; // Return total change\n}`,
                    language: 'javascript',
                    theme: 'vs-dark',
                    minimap: { enabled: false }
                });
            });
        } catch (e) {
            handleScriptError('Failed to initialize Monaco Editor: ' + e.message);
        }

        // Web Worker setup
        let worker;
        try {
            worker = new Worker(URL.createObjectURL(new Blob([`
                self.onmessage = function(e) {
                    try {
                        const { nodes, damping, algorithm } = e.data;
                        let totalChange = 0;
                        const newRanks = new Array(nodes.length).fill(0);
                        const messages = [];

                        if (algorithm === 'pagerank') {
                            nodes.forEach((node, i) => {
                                newRanks[i] = (1 - damping) / nodes.length;
                                nodes.forEach(other => {
                                    const link = other.links.find(l => l.id === node.id);
                                    if (link) {
                                        const weight = link.weight;
                                        const totalWeight = other.links.reduce((sum, l) => sum + l.weight, 0);
                                        const contribution = damping * (other.rank * weight / totalWeight);
                                        newRanks[i] += contribution;
                                        messages.push(\`\${other.name} sends \${contribution.toFixed(2)} to \${node.name}\`);
                                    }
                                });
                            });

                            nodes.forEach((node, i) => {
                                totalChange += Math.abs(node.rank - newRanks[i]);
                                node.rank = newRanks[i];
                                node.rankHistory.push(node.rank);
                                if (node.rankHistory.length > 10) node.rankHistory.shift();
                            });
                        } else if (algorithm === 'hits') {
                            let authorities = new Array(nodes.length).fill(1);
                            let hubs = new Array(nodes.length).fill(1);

                            nodes.forEach((node, i) => {
                                authorities[i] = nodes.reduce((sum, other) => 
                                    other.links.some(l => l.id === node.id) ? sum + hubs[other.id] : sum, 0);
                            });

                            nodes.forEach((node, i) => {
                                hubs[i] = node.links.reduce((sum, link) => sum + authorities[link.id], 0);
                            });

                            const authSum = Math.sqrt(authorities.reduce((sum, a) => sum + a * a, 0));
                            const hubSum = Math.sqrt(hubs.reduce((sum, h) => sum + h * h, 0));
                            nodes.forEach((node, i) => {
                                const oldRank = node.rank;
                                node.rank = authorities[i] / authSum;
                                node.hub = hubs[i] / hubSum;
                                totalChange += Math.abs(oldRank - node.rank);
                                node.rankHistory.push(node.rank);
                                if (node.rankHistory.length > 10) node.rankHistory.shift();
                                messages.push(\`\${node.name}: Authority \${node.rank.toFixed(2)}, Hub \${node.hub.toFixed(2)}\`);
                            });
                        }

                        self.postMessage({ totalChange, newRanks, messages });
                    } catch (e) {
                        self.postMessage({ error: e.message });
                    }
                };
            `], { type: 'text/javascript' })));
        } catch (e) {
            handleScriptError('Failed to initialize Web Worker: ' + e.message);
        }

        // Audio setup
        let audioCtx;
        try {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        } catch (e) {
            handleScriptError('AudioContext not supported: ' + e.message);
        }

        function playSound(frequency, type = 'sine', duration = 0.1, volume = 0.2) {
            if (!audioCtx) return;
            try {
                const oscillator = audioCtx.createOscillator();
                const gainNode = audioCtx.createGain();
                oscillator.type = type;
                oscillator.frequency.setValueAtTime(frequency, audioCtx.currentTime);
                gainNode.gain.setValueAtTime(volume, audioCtx.currentTime);
                oscillator.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                oscillator.start();
                oscillator.stop(audioCtx.currentTime + duration);
            } catch (e) {
                console.warn('Sound playback failed: ' + e.message);
            }
        }

        function playBackgroundSound() {
            if (!audioCtx) return null;
            try {
                const oscillator = audioCtx.createOscillator();
                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(100, audioCtx.currentTime);
                const gainNode = audioCtx.createGain();
                gainNode.gain.setValueAtTime(0.05, audioCtx.currentTime);
                oscillator.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                oscillator.start();
                return oscillator;
            } catch (e) {
                console.warn('Background sound failed: ' + e.message);
                return null;
            }
        }

        let backgroundSound = playBackgroundSound();

        // Particle system
        class Particle {
            constructor(width, height) {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.vx = (Math.random() - 0.5) * 4;
                this.vy = (Math.random() - 0.5) * 4;
                this.size = Math.random() * 2 + 1;
                this.alpha = Math.random() * 0.4 + 0.2;
                this.trailLength = Math.random() * 10 + 5;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;
                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
                this.alpha = 0.2 + 0.4 * Math.sin(Date.now() * 0.003 + this.x);
            }

            draw(ctx) {
                ctx.beginPath();
                const gradient = ctx.createLinearGradient(
                    this.x, this.y,
                    this.x - this.vx * this.trailLength, this.y - this.vy * this.trailLength
                );
                gradient.addColorStop(0, `rgba(0, 255, 136, ${this.alpha})`);
                gradient.addColorStop(1, 'rgba(0, 255, 136, 0)');
                ctx.moveTo(this.x, this.y);
                ctx.lineTo(this.x - this.vx * this.trailLength, this.y - this.vy * this.trailLength);
                ctx.strokeStyle = gradient;
                ctx.lineWidth = this.size;
                ctx.stroke();
            }
        }

        // Node class
        class Node {
            constructor(id, x, y, name) {
                this.id = id;
                this.x = x;
                this.y = y;
                this.name = name || `Node ${id}`;
                this.rank = 1;
                this.hub = 1;
                this.newRank = 0;
                this.targetRadius = 20;
                this.currentRadius = 20;
                this.links = [];
                this.votes = 0;
                this.rankHistory = [1];
                this.isDragging = false;
                this.annotation = '';
            }

            draw(ctx) {
                this.currentRadius += (this.targetRadius - this.currentRadius) * 0.1;
                this.targetRadius = 15 + this.rank * 25;

                ctx.shadowBlur = this.rank > 1.5 ? 20 : 0;
                ctx.shadowColor = `rgba(0, 183, 255, ${Math.min(this.rank / 2, 1)})`;

                ctx.beginPath();
                const gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.currentRadius * 1.5);
                gradient.addColorStop(0, `rgba(0, 183, 255, ${Math.min(this.rank, 1)})`);
                gradient.addColorStop(1, 'rgba(0, 183, 255, 0)');
                ctx.arc(this.x, this.y, this.currentRadius * 1.5, 0, Math.PI * 2);
                ctx.fillStyle = gradient;
                ctx.fill();

                ctx.beginPath();
                ctx.arc(this.x, this.y, this.currentRadius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(0, 183, 255, ${Math.min(this.rank, 1)})`;
                ctx.fill();
                ctx.strokeStyle = this.isDragging ? '#ff4081' : 'rgba(255, 255, 255, 0.8)';
                ctx.stroke();
                ctx.shadowBlur = 0;

                ctx.fillStyle = '#fff';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = '12px Segoe UI';
                const rankText = document.getElementById('algorithm')?.value === 'hits' 
                    ? `${this.name} (A: ${this.rank.toFixed(2)}, H: ${this.hub.toFixed(2)})`
                    : `${this.name} (${this.rank.toFixed(2)})`;
                ctx.fillText(rankText, this.x, this.y + this.currentRadius + 15);
                ctx.fillText(`Votes: ${this.votes}`, this.x, this.y - this.currentRadius - 15);
                if (this.annotation) {
                    ctx.fillText(this.annotation, this.x, this.y + this.currentRadius + 30);
                }
            }
        }

        // Graph class
        class Graph {
            constructor() {
                this.nodes = [];
                this.damping = 0.85;
                this.convergenceThreshold = 0.01;
                this.iteration = 0;
                this.maxIterations = 10;
                this.animating = false;
                this.messages = [];
                this.totalChange = 0;
                this.changeHistory = [];
                this.sessionLog = [];
                this.plugins = [];
            }

            addNode(node) {
                if (this.nodes.length < 50) {
                    this.nodes.push(node);
                    this.sessionLog.push({ action: 'addNode', id: node.id, x: node.x, y: node.y, name: node.name });
                    updateUI();
                    this.draw();
                    checkAchievements();
                }
            }

            removeNode() {
                if (this.nodes.length > 1) {
                    const node = this.nodes.pop();
                    this.nodes.forEach(n => {
                        n.links = n.links.filter(l => l.id < this.nodes.length);
                    });
                    this.sessionLog.push({ action: 'removeNode', id: node.id });
                    updateUI();
                    this.draw();
                }
            }

            addLink(fromId, toId, weight) {
                if (fromId !== toId && !this.nodes[fromId].links.some(l => l.id === toId)) {
                    this.nodes[fromId].links.push({ id: toId, weight });
                    this.sessionLog.push({ action: 'addLink', fromId, toId, weight });
                    playSound(800, 'sine', 0.1);
                    this.draw();
                    checkAchievements();
                }
            }

            removeLink(fromId, toId) {
                if (this.nodes[fromId].links.some(l => l.id === toId)) {
                    this.nodes[fromId].links = this.nodes[fromId].links.filter(l => l.id !== toId);
                    this.sessionLog.push({ action: 'removeLink', fromId, toId });
                    playSound(600, 'sine', 0.1);
                    this.draw();
                }
            }

            addAnnotation(id, type, text) {
                if (type === 'node') {
                    this.nodes[id].annotation = text;
                    this.sessionLog.push({ action: 'annotateNode', id, text });
                }
                this.draw();
            }

            vote(nodeId) {
                this.nodes[nodeId].votes++;
                this.nodes[nodeId].rank += 0.5;
                this.sessionLog.push({ action: 'vote', nodeId });
                playSound(1000, 'sine', 0.1);
                this.updateLeaderboard();
                this.draw();
                checkAchievements();
            }

            updateNodeNames() {
                this.nodes.forEach((node, i) => {
                    const input = document.getElementById(`node${i}`);
                    if (input) {
                        node.name = input.value.trim() || `Node ${i}`;
                    }
                });
                updateUI();
                this.draw();
            }

            drawEdges(ctx, iteration) {
                this.nodes.forEach(node => {
                    node.links.forEach(link => {
                        const toNode = this.nodes[link.id];
                        drawLaserEdge(node.x, node.y, toNode.x, toNode.y, link.weight, iteration, ctx);
                    });
                });
            }

            drawHeatmap(ctx) {
                const heatmapCanvas = document.createElement('canvas');
                heatmapCanvas.width = canvas.width;
                heatmapCanvas.height = canvas.height;
                const hCtx = heatmapCanvas.getContext('2d');
                this.nodes.forEach(node => {
                    const gradient = hCtx.createRadialGradient(node.x, node.y, 0, node.x, node.y, 100);
                    gradient.addColorStop(0, `rgba(0, 255, 136, ${node.rank / 3})`);
                    gradient.addColorStop(1, 'rgba(0, 255, 136, 0)');
                    hCtx.fillStyle = gradient;
                    hCtx.fillRect(node.x - 100, node.y - 100, 200, 200);
                });
                ctx.globalAlpha = 0.3;
                ctx.drawImage(heatmapCanvas, 0, 0);
                ctx.globalAlpha = 1;
            }

            computePageRank() {
                return new Promise((resolve, reject) => {
                    if (!worker) {
                        handleScriptError('Web Worker not available');
                        reject('Web Worker not available');
                        return;
                    }

                    worker.onmessage = e => {
                        if (e.data.error) {
                            handleScriptError('Worker error: ' + e.data.error);
                            reject(e.data.error);
                            return;
                        }
                        this.totalChange = e.data.totalChange;
                        this.messages = e.data.messages;
                        this.nodes.forEach((node, i) => {
                            node.rank = e.data.newRanks[i];
                            if (document.getElementById('algorithm').value === 'hits') {
                                node.hub = e.data.newRanks[i];
                            }
                        });
                        this.changeHistory.push(this.totalChange);
                        this.sessionLog.push({ action: 'iteration', iteration: this.iteration, totalChange: this.totalChange });
                        resolve(this.totalChange);
                    };

                    worker.onerror = e => {
                        handleScriptError('Worker error: ' + e.message);
                        reject(e.message);
                    };

                    worker.postMessage({
                        nodes: this.nodes.map(node => ({
                            id: node.id,
                            rank: node.rank,
                            hub: node.hub,
                            links: node.links,
                            name: node.name,
                            rankHistory: node.rankHistory
                        })),
                        damping: parseFloat(document.getElementById('dampingFactor')?.value) || this.damping,
                        algorithm: document.getElementById('algorithm')?.value || 'pagerank'
                    });
                });
            }

            updateLeaderboard() {
                const leaderboard = document.getElementById('leaderboard');
                if (!leaderboard) return;
                const sortedNodes = [...this.nodes].sort((a, b) => b.rank - a.rank);
                leaderboard.innerHTML = `Leaderboard:<br>${sortedNodes.map(n => 
                    document.getElementById('algorithm')?.value === 'hits'
                        ? `${n.name}: A: ${n.rank.toFixed(2)}, H: ${n.hub.toFixed(2)}`
                        : `${n.name}: ${n.rank.toFixed(2)}`
                ).join('<br>')}`;
            }

            getScore() {
                const linkCount = this.nodes.reduce((sum, node) => sum + node.links.length, 0);
                return Math.max(0, 100 - this.totalChange * 10 + linkCount * 2).toFixed(0);
            }

            save() {
                try {
                    const graphData = {
                        nodes: this.nodes.map(node => ({
                            id: node.id,
                            x: node.x,
                            y: node.y,
                            name: node.name,
                            links: node.links,
                            votes: node.votes,
                            annotation: node.annotation
                        })),
                        damping: this.damping,
                        convergenceThreshold: this.convergenceThreshold
                    };
                    localStorage.setItem('pageRankGraph', JSON.stringify(graphData));
                } catch (e) {
                    handleScriptError('Failed to save graph: ' + e.message);
                }
            }

            load() {
                try {
                    const saved = localStorage.getItem('pageRankGraph');
                    if (saved) {
                        const graphData = JSON.parse(saved);
                        this.nodes = graphData.nodes.map(node => {
                            const n = new Node(node.id, node.x, node.y, node.name);
                            n.links = node.links;
                            n.votes = node.votes;
                            n.annotation = node.annotation;
                            n.rank = 1;
                            n.rankHistory = [1];
                            return n;
                        });
                        this.damping = graphData.damping;
                        this.convergenceThreshold = graphData.convergenceThreshold;
                        const dampingInput = document.getElementById('dampingFactor');
                        const thresholdInput = document.getElementById('convergenceThreshold');
                        if (dampingInput) dampingInput.value = this.damping;
                        if (thresholdInput) thresholdInput.value = this.convergenceThreshold;
                        updateUI();
                        this.draw();
                    }
                } catch (e) {
                    handleScriptError('Failed to load graph: ' + e.message);
                }
            }

            exportData() {
                try {
                    const headers = ['Iteration', ...this.nodes.map(n => n.name)];
                    const rows = Array.from({ length: this.nodes[0].rankHistory.length }, (_, i) => [
                        i,
                        ...this.nodes.map(n => n.rankHistory[i].toFixed(4))
                    ]);
                    const csv = [headers, ...rows].map(row => row.join(',')).join('\n');
                    const blob = new Blob([csv], { type: 'text/csv' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'pagerank_data.csv';
                    a.click();
                    URL.revokeObjectURL(url);
                } catch (e) {
                    handleScriptError('Failed to export data: ' + e.message);
                }
            }

            draw(iteration = this.iteration) {
                if (document.getElementById('viewMode')?.value === '2d') {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    this.drawHeatmap(ctx);
                    particles.forEach(p => p.draw(ctx));
                    this.drawEdges(ctx, iteration);
                    this.nodes.forEach(node => node.draw(ctx));
                } else {
                    try {
                        render3DGraph();
                    } catch (e) {
                        handleScriptError('3D rendering failed: ' + e.message);
                        document.getElementById('viewMode').value = '2d';
                        toggleViewMode();
                    }
                }
            }

            registerPlugin(plugin) {
                this.plugins.push(plugin);
                plugin.init(this);
            }
        }

        // 3D rendering
        let scene, camera, renderer, threeCanvas;
        function init3DGraph() {
            try {
                threeCanvas = document.getElementById('threeCanvas');
                if (!threeCanvas) throw new Error('Three.js canvas not found');
                threeCanvas.style.width = `${canvas.width}px`;
                threeCanvas.style.height = `${canvas.height}px`;
                scene = new THREE.Scene();
                camera = new THREE.PerspectiveCamera(75, canvas.width / canvas.height, 0.1, 1000);
                renderer = new THREE.WebGLRenderer({ canvas: threeCanvas, alpha: true });
                renderer.setSize(canvas.width, canvas.height);
                camera.position.z = 500;
            } catch (e) {
                handleScriptError('Failed to initialize 3D graph: ' + e.message);
            }
        }

        function render3DGraph() {
            if (!scene || !camera || !renderer) {
                throw new Error('3D rendering not initialized');
            }
            scene.children = [];
            const nodeGeometry = new THREE.SphereGeometry(10, 32, 32);
            const edgeGeometry = new THREE.BufferGeometry();
            const positions = [];

            graph.nodes.forEach(node => {
                const material = new THREE.MeshBasicMaterial({ color: 0x00b7ff, transparent: true, opacity: node.rank });
                const sphere = new THREE.Mesh(nodeGeometry, material);
                sphere.position.set(node.x - canvas.width / 2, canvas.height / 2 - node.y, 0);
                scene.add(sphere);
                node.links.forEach(link => {
                    const toNode = graph.nodes[link.id];
                    positions.push(node.x - canvas.width / 2, canvas.height / 2 - node.y, 0);
                    positions.push(toNode.x - canvas.width / 2, canvas.height / 2 - toNode.y, 0);
                });
            });

            edgeGeometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
            const edgeMaterial = new THREE.LineBasicMaterial({ color: 0x00ff88 });
            const edges = new THREE.LineSegments(edgeGeometry, edgeMaterial);
            scene.add(edges);

            renderer.render(scene, camera);
        }

        function drawLaserEdge(fromX, fromY, toX, toY, weight, iteration, ctx) {
            const headLength = 10;
            const dx = toX - fromX;
            const dy = toY - fromY;
            const angle = Math.atan2(dy, dx);
            const fromNode = graph.nodes.find(n => n.x === fromX && n.y === fromY);
            const toNode = graph.nodes.find(n => n.x === toX && n.y === toY);
            const fromRadius = fromNode.currentRadius;
            const toRadius = toNode.currentRadius;

            const startX = fromX + Math.cos(angle) * fromRadius;
            const startY = fromY + Math.sin(angle) * fromRadius;
            const endX = toX - Math.cos(angle) * toRadius;
            const endY = toY - Math.sin(angle) * toRadius;

            const gradient = ctx.createLinearGradient(startX, startY, endX, endY);
            gradient.addColorStop(0, 'rgba(0, 255, 136, 0.1)');
            gradient.addColorStop(0.5, `rgba(0, 255, 136, ${0.7 + 0.3 * Math.sin(iteration * 0.3)})`);
            gradient.addColorStop(1, 'rgba(0, 255, 136, 0.1)');

            ctx.beginPath();
            ctx.moveTo(startX, startY);
            ctx.lineTo(endX, endY);
            ctx.strokeStyle = gradient;
            ctx.lineWidth = 1 + weight * 3;
            ctx.stroke();

            if (graph.animating) {
                const pulseProgress = (Date.now() % 1500) / 1500;
                const pulseX = startX + (endX - startX) * pulseProgress;
                const pulseY = startY + (endY - startY) * pulseProgress;
                ctx.beginPath();
                ctx.arc(pulseX, pulseY, 5, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(0, 255, 136, ${0.5 + 0.5 * Math.sin(pulseProgress * Math.PI)}`;
                ctx.fill();
            }

            ctx.beginPath();
            ctx.moveTo(endX, endY);
            ctx.lineTo(endX - headLength * Math.cos(angle - Math.PI / 6), endY - headLength * Math.sin(angle - Math.PI / 6));
            ctx.moveTo(endX, endY);
            ctx.lineTo(endX - headLength * Math.cos(angle + Math.PI / 6), endY - headLength * Math.sin(angle + Math.PI / 6));
            ctx.strokeStyle = `rgba(0, 255, 136, ${0.7 + 0.3 * Math.sin(iteration * 0.3)})`;
            ctx.stroke();
        }

        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const rankChart = document.getElementById('rankChart');
        const chartCtx = rankChart?.getContext('2d');
        const degreeChart = document.getElementById('degreeChart');
        const degreeCtx = degreeChart?.getContext('2d');
        const convergenceChart = document.getElementById('convergenceChart');
        const convergenceCtx = convergenceChart?.getContext('2d');
        const particles = Array.from({ length: 80 }, () => new Particle(canvas.width, canvas.height));
        const graph = new Graph();

        // Initialize 3D rendering
        init3DGraph();

        // Tutorial system
        class Tutorial {
            constructor() {
                this.steps = [
                    { text: 'Add a new website by clicking "Add Website".', check: () => graph.nodes.length > 5 },
                    { text: 'Add a link from Node 0 to Node 1.', check: () => graph.nodes[0].links.some(l => l.id === 1) },
                    { text: 'Vote for Node 0 to boost its rank.', check: () => graph.nodes[0].votes > 0 },
                    { text: 'Start the simulator to see PageRank in action.', check: () => graph.iteration > 0 }
                ];
                this.currentStep = 0;
            }

            start() {
                if (this.currentStep < this.steps.length) {
                    const modal = document.getElementById('tutorialModal');
                    if (modal) modal.style.display = 'flex';
                    const text = document.getElementById('tutorialText');
                    if (text) text.textContent = this.steps[this.currentStep].text;
                }
            }

            next() {
                if (this.steps[this.currentStep].check()) {
                    this.currentStep++;
                    if (this.currentStep < this.steps.length) {
                        const text = document.getElementById('tutorialText');
                        if (text) text.textContent = this.steps[this.currentStep].text;
                    } else {
                        closeTutorial();
                        const infoPanel = document.getElementById('info');
                        if (infoPanel) infoPanel.innerHTML = 'Tutorial completed! Explore more features.';
                    }
                } else {
                    const infoPanel = document.getElementById('info');
                    if (infoPanel) infoPanel.innerHTML = 'Complete the current step first!';
                }
            }
        }

        const tutorial = new Tutorial();

        // Challenge system
        const challenges = [
            {
                name: 'Cycle Master',
                graph: {
                    nodes: [
                        { id: 0, x: 200, y: 200, name: 'Node 0' },
                        { id: 1, x: 400, y: 200, name: 'Node 1' },
                        { id: 2, x: 300, y: 350, name: 'Node 2' }
                    ],
                    links: [
                        { from: 0, to: 1, weight: 1 },
                        { from: 1, to: 2, weight: 1 },
                        { from: 2, to: 0, weight: 1 }
                    ]
                },
                goal: () => graph.nodes.every(n => Math.abs(n.rank - 1) < 0.1),
                description: 'Create a 3-node cycle and achieve balanced ranks.'
            }
        ];

        // Achievements system
        const achievements = [
            { id: 'graphMaster', name: 'Graph Master', condition: () => graph.nodes.length >= 10, awarded: false },
            { id: 'convergencePro', name: 'Convergence Pro', condition: () => graph.getScore() > 90, awarded: false },
            { id: 'linkWizard', name: 'Link Wizard', condition: () => graph.nodes.reduce((sum, n) => sum + n.links.length, 0) >= 20, awarded: false }
        ];

        function checkAchievements() {
            achievements.forEach(a => {
                if (!a.awarded && a.condition()) {
                    a.awarded = true;
                    const infoPanel = document.getElementById('info');
                    if (infoPanel) infoPanel.innerHTML = `Achievement Unlocked: ${a.name}!`;
                    updateAchievements();
                    setTimeout(() => {
                        if (infoPanel) {
                            infoPanel.innerHTML = graph.animating ? `Iteration ${graph.iteration}:<br>${graph.messages.join('<br>')}` 
                                : "Click 'Start Simulator' to run PageRank.";
                        }
                    }, 2000);
                }
            });
            try {
                localStorage.setItem('achievements', JSON.stringify(achievements));
            } catch (e) {
                console.warn('Failed to save achievements: ' + e.message);
            }
        }

        function updateAchievements() {
            const list = document.getElementById('achievementList');
            if (list) {
                list.innerHTML = achievements.map(a => `<li>${a.name}: ${a.awarded ? 'Unlocked' : 'Locked'}</li>`).join('');
            }
        }

        // Plugin system
        const plugins = {
            customMetric: {
                init: graph => {
                    graph.plugins.push({
                        render: () => {
                            const avgRank = graph.nodes.reduce((sum, n) => sum + n.rank, 0) / graph.nodes.length;
                            const infoPanel = document.getElementById('info');
                            if (infoPanel) infoPanel.innerHTML += `<br>Average Rank: ${avgRank.toFixed(2)}`;
                        }
                    });
                }
            }
        };

        graph.registerPlugin(plugins.customMetric);

        // Initialize nodes
        const nodePositions = [
            { x: 200, y: 200, name: 'Wikipedia' },
            { x: 400, y: 150, name: 'BBC' },
            { x: 600, y: 200, name: 'CNN' },
            { x: 300, y: 350, name: 'Blog' },
            { x: 500, y: 400, name: 'Forum' }
        ];
        nodePositions.forEach((pos, i) => graph.addNode(new Node(i, pos.x, pos.y, pos.name)));

        graph.addLink(0, 1, 1);
        graph.addLink(1, 2, 1);
        graph.addLink(2, 0, 1);
        graph.addLink(2, 3, 1);
        graph.addLink(3, 4, 1);
        graph.addLink(4, 2, 1);

        function updateUI() {
            const nodeInputs = document.getElementById('nodeInputs');
            const voteButtons = document.getElementById('voteButtons');
            const fromNode = document.getElementById('fromNode');
            const toNode = document.getElementById('toNode');

            if (nodeInputs) {
                nodeInputs.innerHTML = graph.nodes.map((node, i) => `
                    <input type="text" id="node${i}" placeholder="Node ${i} Name" value="${node.name}" aria-label="Node ${i} Name">
                `).join('');
            }
            if (voteButtons) {
                voteButtons.innerHTML = graph.nodes.map((node, i) => `
                    <button onclick="voteForNode(${i})" data-tooltip="Boost ${node.name}'s rank" aria-label="Vote for Node ${i}">Vote Node ${i}</button>
                `).join('');
            }
            if (fromNode) {
                fromNode.innerHTML = graph.nodes.map((node, i) => `<option value="${i}">${node.name}</option>`).join('');
            }
            if (toNode) {
                toNode.innerHTML = graph.nodes.map((node, i) => `<option value="${i}">${node.name}</option>`).join('');
            }
            updateMetrics();
        }

        function updateMetrics() {
            const n = graph.nodes.length;
            const edgeCount = graph.nodes.reduce((sum, node) => sum + node.links.length, 0);
            const density = n > 1 ? edgeCount / (n * (n - 1)) : 0;
            const inDegrees = graph.nodes.map(node => 
                graph.nodes.reduce((sum, other) => sum + (other.links.some(l => l.id === node.id) ? 1 : 0), 0)
            );
            const maxInDegree = Math.max(...inDegrees);
            const clustering = graph.nodes.reduce((sum, node) => {
                const neighbors = node.links.map(l => l.id);
                const neighborPairs = neighbors.reduce((count, n1, i) => 
                    count + neighbors.slice(i + 1).reduce((c, n2) => 
                        c + (graph.nodes[n1].links.some(l => l.id === n2) ? 1 : 0), 0), 0);
                const possiblePairs = neighbors.length * (neighbors.length - 1) / 2;
                return sum + (possiblePairs > 0 ? neighborPairs / possiblePairs : 0);
            }, 0) / n;

            const densitySpan = document.getElementById('graphDensity');
            const maxInDegreeSpan = document.getElementById('maxInDegree');
            const clusteringSpan = document.getElementById('clusteringCoefficient');

            if (densitySpan) densitySpan.textContent = density.toFixed(2);
            if (maxInDegreeSpan) maxInDegreeSpan.textContent = maxInDegree;
            if (clusteringSpan) clusteringSpan.textContent = clustering.toFixed(2);

            if (degreeCtx) {
                degreeCtx.clearRect(0, 0, degreeChart.width, degreeChart.height);
                const maxDegree = Math.max(...inDegrees);
                inDegrees.forEach((degree, i) => {
                    degreeCtx.fillStyle = '#00b7ff';
                    degreeCtx.fillRect(40 + i * 10, 90 - (degree / maxDegree) * 80, 8, (degree / maxDegree) * 80);
                });
            }

            if (convergenceCtx) {
                convergenceCtx.clearRect(0, 0, convergenceChart.width, convergenceChart.height);
                convergenceCtx.beginPath();
                convergenceCtx.moveTo(40, 90);
                graph.changeHistory.forEach((change, i) => {
                    convergenceCtx.lineTo(40 + (i / graph.maxIterations) * 220, 90 - (change / 0.5) * 80);
                });
                convergenceCtx.strokeStyle = '#ffeb3b';
                convergenceCtx.stroke();
            }
        }

        function drawRankChart() {
            if (!chartCtx) return;
            chartCtx.clearRect(0, 0, rankChart.width, rankChart.height);
            chartCtx.strokeStyle = '#444';
            chartCtx.beginPath();
            chartCtx.moveTo(40, 10);
            chartCtx.lineTo(40, 130);
            chartCtx.lineTo(260, 130);
            chartCtx.stroke();
            chartCtx.fillStyle = '#fff';
            chartCtx.font = '10px Segoe UI';
            chartCtx.textAlign = 'right';
            chartCtx.fillText(document.getElementById('algorithm')?.value === 'hits' ? 'Authority' : 'Rank', 35, 10);
            chartCtx.textAlign = 'center';
            chartCtx.fillText('Iteration', 150, 140);

            const colors = ['#00b7ff', '#ffeb3b', '#ff4081', '#4caf50', '#e91e63', '#9c27b0', '#2196f3', '#ff9800', '#795548', '#607d8b'];
            graph.nodes.forEach((node, i) => {
                chartCtx.beginPath();
                chartCtx.strokeStyle = colors[i % colors.length];
                chartCtx.moveTo(40, 130 - (node.rankHistory[0] / 3) * 120);
                node.rankHistory.forEach((rank, j) => {
                    chartCtx.lineTo(40 + (j / (graph.maxIterations + 1)) * 220, 130 - (rank / 3) * 120);
                });
                chartCtx.stroke();
                chartCtx.fillStyle = colors[i % colors.length];
                chartCtx.fillText(node.name, 10, 20 + i * 15);
            });
        }

        async function animate() {
            if (!graph.animating) return;
            const thresholdInput = document.getElementById('convergenceThreshold');
            graph.convergenceThreshold = parseFloat(thresholdInput?.value) || graph.convergenceThreshold;
            try {
                const totalChange = await graph.computePageRank();
                graph.iteration++;
                const progress = document.getElementById('progress');
                if (progress) progress.style.width = `${(graph.iteration / graph.maxIterations) * 100}%`;
                const infoPanel = document.getElementById('info');
                if (infoPanel) infoPanel.innerHTML = `Iteration ${graph.iteration}:<br>${graph.messages.join('<br>')}`;
                graph.updateLeaderboard();
                drawRankChart();
                updateMetrics();
                graph.draw();
                if (graph.iteration < graph.maxIterations && totalChange > graph.convergenceThreshold) {
                    setTimeout(() => requestAnimationFrame(animate), 1500);
                } else {
                    graph.animating = false;
                    const score = graph.getScore();
                    if (infoPanel) infoPanel.innerHTML = `Simulation Complete! Score: ${score}/100 (based on convergence and graph complexity).`;
                    checkAchievements();
                }
            } catch (e) {
                graph.animating = false;
                handleScriptError('Simulation failed: ' + e);
            }
        }

        function startGame() {
            if (!graph.animating) {
                graph.updateNodeNames();
                graph.animating = true;
                graph.iteration = 0;
                graph.changeHistory = [];
                graph.nodes.forEach(node => node.rankHistory = [node.rank]);
                const infoPanel = document.getElementById('info');
                if (infoPanel) infoPanel.innerHTML = "Starting simulation...";
                drawRankChart();
                updateMetrics();
                requestAnimationFrame(animate);
            }
        }

        function resetGame() {
            graph.animating = false;
            graph.nodes.forEach(node => {
                node.rank = 1;
                node.hub = 1;
                node.votes = 0;
                node.currentRadius = 20;
                node.rankHistory = [1];
            });
            graph.iteration = 0;
            graph.changeHistory = [];
            const progress = document.getElementById('progress');
            if (progress) progress.style.width = '0%';
            const infoPanel = document.getElementById('info');
            if (infoPanel) infoPanel.innerHTML = "Click 'Start Simulator' to run PageRank.";
            graph.updateNodeNames();
            graph.updateLeaderboard();
            drawRankChart();
            updateMetrics();
            graph.draw();
        }

        function addNode() {
            if (!graph.animating && graph.nodes.length < 50) {
                const id = graph.nodes.length;
                const x = 200 + Math.random() * 400;
                const y = 150 + Math.random() * 300;
                graph.addNode(new Node(id, x, y, `Node ${id}`));
                playSound(1200, 'sine', 0.1);
            }
        }

        function removeNode() {
            if (!graph.animating) {
                graph.removeNode();
                playSound(600, 'sine', 0.1);
            }
        }

        function addLink() {
            if (!graph.animating) {
                const fromNode = parseInt(document.getElementById('fromNode')?.value);
                const toNode = parseInt(document.getElementById('toNode')?.value);
                const weight = parseFloat(document.getElementById('linkWeight')?.value) || 1;
                if (!isNaN(fromNode) && !isNaN(toNode)) {
                    graph.addLink(fromNode, toNode, weight);
                }
            }
        }

        function removeLink() {
            if (!graph.animating) {
                const fromNode = parseInt(document.getElementById('fromNode')?.value);
                const toNode = parseInt(document.getElementById('toNode')?.value);
                if (!isNaN(fromNode) && !isNaN(toNode)) {
                    graph.removeLink(fromNode, toNode);
                }
            }
        }

        function voteForNode(id) {
            if (!graph.animating) {
                graph.vote(id);
            }
        }

        function saveGraph() {
            graph.save();
            const infoPanel = document.getElementById('info');
            if (infoPanel) infoPanel.innerHTML = 'Graph saved to local storage!';
            setTimeout(() => {
                if (infoPanel) {
                    infoPanel.innerHTML = graph.animating ? `Iteration ${graph.iteration}:<br>${graph.messages.join('<br>')}` 
                        : "Click 'Start Simulator' to run PageRank.";
                }
            }, 2000);
        }

        function loadGraph() {
            if (!graph.animating) {
                graph.load();
                const infoPanel = document.getElementById('info');
                if (infoPanel) infoPanel.innerHTML = 'Graph loaded from local storage!';
                setTimeout(() => {
                    if (infoPanel) infoPanel.innerHTML = "Click 'Start Simulator' to run PageRank.";
                }, 2000);
            }
        }

        function exportData() {
            graph.exportData();
            playSound(800, 'sine', 0.1);
        }

        async function runBatchAnalysis() {
            if (!graph.animating) {
                const results = [];
                for (let d = 0.5; d <= 0.95; d += 0.05) {
                    graph.damping = d;
                    graph.iteration = 0;
                    graph.nodes.forEach(node => node.rank = 1);
                    let totalChange = Infinity;
                    while (graph.iteration < graph.maxIterations && totalChange > graph.convergenceThreshold) {
                        try {
                            totalChange = await graph.computePageRank();
                            graph.iteration++;
                        } catch (e) {
                            handleScriptError('Batch analysis failed: ' + e);
                            return;
                        }
                    }
                    results.push({ damping: d, iterations: graph.iteration, finalChange: totalChange });
                }
                try {
                    const csv = ['Damping,Iterations,FinalChange\n' + results.map(r => 
                        `${r.damping},${r.iterations},${r.finalChange.toFixed(4)}`).join('\n')];
                    const blob = new Blob([csv], { type: 'text/csv' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'batch_analysis.csv';
                    a.click();
                    URL.revokeObjectURL(url);
                    const infoPanel = document.getElementById('info');
                    if (infoPanel) infoPanel.innerHTML = 'Batch analysis complete! CSV downloaded.';
                } catch (e) {
                    handleScriptError('Failed to export batch analysis: ' + e);
                }
            }
        }

        function startTutorial() {
            tutorial.start();
        }

        function nextTutorialStep() {
            tutorial.next();
        }

        function closeTutorial() {
            const modal = document.getElementById('tutorialModal');
            if (modal) modal.style.display = 'none';
        }

        function startChallenge() {
            if (!graph.animating) {
                const challenge = challenges[0];
                graph.nodes = challenge.graph.nodes.map(node => new Node(node.id, node.x, node.y, node.name));
                challenge.graph.links.forEach(link => graph.addLink(link.from, link.to, link.weight));
                updateUI();
                graph.draw();
                const infoPanel = document.getElementById('info');
                if (infoPanel) infoPanel.innerHTML = `Challenge: ${challenge.name}. Goal: ${challenge.description}`;
                setTimeout(() => {
                    if (challenge.goal()) {
                        if (infoPanel) infoPanel.innerHTML = 'Challenge completed!';
                        checkAchievements();
                    }
                }, 5000);
            }
        }

        let mediaRecorder, recordedChunks = [];
        function recordVideo() {
            try {
                const stream = canvas.captureStream(60);
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.ondataavailable = e => recordedChunks.push(e.data);
                mediaRecorder.onstop = () => {
                    try {
                        const blob = new Blob(recordedChunks, { type: 'video/mp4' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'simulation.mp4';
                        a.click();
                        URL.revokeObjectURL(url);
                        recordedChunks = [];
                    } catch (e) {
                        handleScriptError('Failed to save video: ' + e);
                    }
                };
                mediaRecorder.start();
                setTimeout(() => {
                    mediaRecorder.stop();
                }, 10000);
                const infoPanel = document.getElementById('info');
                if (infoPanel) infoPanel.innerHTML = 'Recording video for 10 seconds...';
            } catch (e) {
                handleScriptError('Video recording failed: ' + e);
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const canvasContainer = document.getElementById('canvasContainer');
            if (sidebar && canvasContainer) {
                sidebar.classList.toggle('collapsed');
                canvasContainer.classList.toggle('collapsed');
            }
        }

        function showExplanation() {
            const modal = document.getElementById('explanationModal');
            if (modal) modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('explanationModal');
            if (modal) modal.style.display = 'none';
        }

        function runCustomAlgorithm() {
            if (!editor) {
                handleScriptError('Code editor not initialized');
                return;
            }
            try {
                const customCode = editor.getValue();
                const customFn = new Function('nodes', 'damping', customCode);
                const totalChange = customFn(graph.nodes, graph.damping);
                graph.totalChange = totalChange;
                graph.messages = ['Custom algorithm applied.'];
                graph.iteration++;
                const progress = document.getElementById('progress');
                if (progress) progress.style.width = `${(graph.iteration / graph.maxIterations) * 100}%`;
                const infoPanel = document.getElementById('info');
                if (infoPanel) infoPanel.innerHTML = `Iteration ${graph.iteration}: Custom algorithm applied.`;
                graph.updateLeaderboard();
                drawRankChart();
                updateMetrics();
                graph.draw();
                if (graph.iteration >= graph.maxIterations || totalChange < graph.convergenceThreshold) {
                    graph.animating = false;
                    const score = graph.getScore();
                    if (infoPanel) infoPanel.innerHTML = `Custom Simulation Complete! Score: ${score}/100.`;
                    checkAchievements();
                }
            } catch (e) {
                handleScriptError('Error in custom algorithm: ' + e.message);
            }
        }

        function updateEquation() {
            const input = document.getElementById('equationDamping');
            const display1 = document.getElementById('dampingDisplay');
            const display2 = document.getElementById('dampingDisplay2');
            const dampingInput = document.getElementById('dampingFactor');
            if (input && display1 && display2 && dampingInput) {
                const d = parseFloat(input.value) || 0.85;
                display1.textContent = d.toFixed(2);
                display2.textContent = d.toFixed(2);
                dampingInput.value = d;
                if (window.MathJax) {
                    MathJax.Hub.Queue(['Typeset', MathJax.Hub, 'equation']);
                }
            }
        }

        function setTheme(theme) {
            document.body.classList.remove('neon', 'matrix');
            if (theme === 'neon') {
                document.body.classList.add('neon');
                document.body.style.setProperty('--node-color', '#ff00ff');
                document.body.style.setProperty('--edge-color', '#ff00ff');
                document.body.style.setProperty('--particle-color', '#ff00ff');
            } else if (theme === 'matrix') {
                document.body.classList.add('matrix');
                document.body.style.setProperty('--node-color', '#00ff00');
                document.body.style.setProperty('--edge-color', '#00ff00');
                document.body.style.setProperty('--particle-color', '#00ff00');
            }
        }

        function toggleHighContrast() {
            document.body.classList.toggle('high-contrast');
        }

        function toggleViewMode() {
            const viewMode = document.getElementById('viewMode');
            const canvas = document.getElementById('canvas');
            const threeCanvas = document.getElementById('threeCanvas');
            if (viewMode && canvas && threeCanvas) {
                const mode = viewMode.value;
                canvas.style.display = mode === '2d' ? 'block' : 'none';
                threeCanvas.style.display = mode === '3d' ? 'block' : 'none';
                graph.draw();
            }
        }

        // Event handlers
        let draggedNode = null;
        canvas.addEventListener('mousedown', e => {
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            draggedNode = graph.nodes.find(node => {
                const dx = x - node.x;
                const dy = y - node.y;
                return Math.sqrt(dx * dx + dy * dy) < node.currentRadius;
            });
            if (draggedNode) {
                draggedNode.isDragging = true;
            } else if (e.detail === 2) {
                const node = graph.nodes.find(node => {
                    const dx = x - node.x;
                    const dy = y - node.y;
                    return Math.sqrt(dx * dx + dy * dy) < node.currentRadius;
                });
                if (node) {
                    const text = prompt('Enter annotation for node:');
                    if (text) graph.addAnnotation(node.id, 'node', text);
                }
            }
        });

        canvas.addEventListener('mousemove', e => {
            if (draggedNode) {
                const rect = canvas.getBoundingClientRect();
                draggedNode.x = Math.max(50, Math.min(canvas.width - 50, e.clientX - rect.left));
                draggedNode.y = Math.max(50, Math.min(canvas.height - 50, e.clientY - rect.top));
                graph.draw();
            }
        });

        canvas.addEventListener('mouseup', () => {
            if (draggedNode) {
                draggedNode.isDragging = false;
                draggedNode = null;
            }
        });

                // Touch support
        canvas.addEventListener('touchstart', e => {
            try {
                e.preventDefault();
                const rect = canvas.getBoundingClientRect();
                const x = e.touches[0].clientX - rect.left;
                const y = e.touches[0].clientY - rect.top;
                draggedNode = graph.nodes.find(node => {
                    const dx = x - node.x;
                    const dy = y - node.y;
                    return Math.sqrt(dx * dx + dy * dy) < node.currentRadius;
                });
                if (draggedNode) {
                    draggedNode.isDragging = true;
                }

                // Detect double-tap for annotation
                const now = Date.now();
                if (lastTouchTime && now - lastTouchTime < 300) {
                    const node = graph.nodes.find(node => {
                        const dx = x - node.x;
                        const dy = y - node.y;
                        return Math.sqrt(dx * dx + dy * dy) < node.currentRadius;
                    });
                    if (node) {
                        const text = prompt('Enter annotation for node:');
                        if (text) {
                            graph.addAnnotation(node.id, 'node', text);
                            playSound(800, 'sine', 0.1);
                        }
                    }
                }
                lastTouchTime = now;
            } catch (e) {
                handleScriptError('Touch start error: ' + e.message);
            }
        });

        canvas.addEventListener('touchmove', e => {
            try {
                e.preventDefault();
                if (draggedNode) {
                    const rect = canvas.getBoundingClientRect();
                    draggedNode.x = Math.max(50, Math.min(canvas.width - 50, e.touches[0].clientX - rect.left));
                    draggedNode.y = Math.max(50, Math.min(canvas.height - 50, e.touches[0].clientY - rect.top));
                    graph.draw();
                }
            } catch (e) {
                handleScriptError('Touch move error: ' + e.message);
            }
        });

        canvas.addEventListener('touchend', e => {
            try {
                e.preventDefault();
                if (draggedNode) {
                    draggedNode.isDragging = false;
                    draggedNode = null;
                    graph.draw();
                }
            } catch (e) {
                handleScriptError('Touch end error: ' + e.message);
            }
        });

        // Initialize last touch time for double-tap detection
        let lastTouchTime = 0;

        // Animation loop for particles
        function updateParticles() {
            particles.forEach(p => p.update());
            if (!graph.animating) {
                graph.draw();
            }
            requestAnimationFrame(updateParticles);
        }

        // Start particle animation
        updateParticles();

        // Resize handler
        window.addEventListener('resize', () => {
            try {
                const container = document.getElementById('canvasContainer');
                if (container) {
                    canvas.width = container.clientWidth;
                    canvas.height = container.clientHeight;
                    threeCanvas.style.width = `${canvas.width}px`;
                    threeCanvas.style.height = `${canvas.height}px`;
                    if (renderer) {
                        renderer.setSize(canvas.width, canvas.height);
                        camera.aspect = canvas.width / canvas.height;
                        camera.updateProjectionMatrix();
                    }
                    particles.forEach(p => {
                        p.x = p.x * (canvas.width / p.x);
                        p.y = p.y * (canvas.height / p.y);
                    });
                    graph.draw();
                }
            } catch (e) {
                handleScriptError('Resize error: ' + e.message);
            }
        });

        // Initial UI update
        updateUI();
        updateAchievements();
        graph.draw();

        // Load saved achievements
        try {
            const savedAchievements = localStorage.getItem('achievements');
            if (savedAchievements) {
                const parsed = JSON.parse(savedAchievements);
                achievements.forEach(a => {
                    const saved = parsed.find(s => s.id === a.id);
                    if (saved) a.awarded = saved.awarded;
                });
                updateAchievements();
            }
        } catch (e) {
            console.warn('Failed to load achievements: ' + e.message);
        }
    </script>
</body>
</html>