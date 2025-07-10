<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans&display=swap" rel="stylesheet">

    <title>A* Pathfinding Visualization</title>
    <style>
      :root {
    --color-bg-light: #f9fafb;
    --color-panel-light: #ffffff;
    --color-text-dark: #1e293b;
    --color-accent: #2dd4bf;
    --color-primary-light: #1e3a8a;
    --color-border-light: #e2e8f0;
    --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --transition-default: all 0.3s ease;
    --font-main: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

[data-theme="dark"] {
    --color-bg-light: #1e293b;
    --color-panel-light: #334155;
    --color-text-dark: #f1f5f9;
    --color-primary-light: #60a5fa;
    --color-border-light: #475569;
    --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: var(--color-bg-light);
    color: var(--color-text-dark);
    font-family: var(--font-main);
    overflow: hidden;
    transition: var(--transition-default);
}

#canvas {
    display: block;
    background: var(--color-bg-light);
}

#sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: var(--color-panel-light);
    padding: 20px;
    border-right: 1px solid var(--color-border-light);
    box-shadow: var(--box-shadow);
    z-index: 1000;
    overflow-y: auto;
    transition: var(--transition-default);
}

#sidebar.collapsed {
    width: 60px;
    padding: 20px 10px;
}

#sidebar.collapsed .section-content,
#sidebar.collapsed label,
#sidebar.collapsed select,
#sidebar.collapsed input:not([type="checkbox"]) {
    display: none;
}

#toggle-sidebar {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--color-primary-light);
    color: #fff;
    border: none;
    padding: 8px;
    border-radius: 6px;
    cursor: pointer;
    width: 120px;
    transition: var(--transition-default);
}

#toggle-sidebar:hover {
    background: #2563eb;
    transform: scale(1.05);
}

.section {
    margin-bottom: 16px;
}

.section-header {
    font-size: 14px;
    font-weight: 600;
    color: var(--color-accent);
    padding: 8px 0;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-content {
    padding: 8px 0;
}

button {
    width: 100%;
    padding: 10px;
    margin: 4px 0;
    border: none;
    background: linear-gradient(135deg, var(--color-primary-light), #3b82f6);
    color: white;
    font-size: 14px;
    font-weight: 500;
    border-radius: 6px;
    cursor: pointer;
    transition: var(--transition-default);
}

button:hover {
    background: linear-gradient(135deg, #2563eb, #60a5fa);
}

button.active {
    background: linear-gradient(135deg, #dc2626, #f87171);
}

select,
input[type="range"],
input[type="file"] {
    width: 100%;
    padding: 8px;
    margin: 4px 0;
    border: 1px solid var(--color-border-light);
    border-radius: 6px;
    background: var(--color-panel-light);
    color: var(--color-text-dark);
    font-size: 14px;
    transition: var(--transition-default);
}

input[type="checkbox"] {
    margin-right: 8px;
    accent-color: var(--color-accent);
}

label {
    font-size: 13px;
    color: var(--color-text-dark);
    margin: 4px 0;
    display: block;
}

#info,
#metrics-panel {
    position: absolute;
    right: 20px;
    width: 260px;
    background: var(--color-panel-light);
    padding: 16px;
    border-radius: 8px;
    border: 1px solid var(--color-border-light);
    box-shadow: var(--box-shadow);
    font-size: 13px;
    line-height: 1.5;
    transition: var(--transition-default);
}

#info {
    top: 20px;
}

#metrics-panel {
    bottom: 20px;
}

#progress-bar {
    width: 100%;
    height: 8px;
    background: var(--color-border-light);
    border-radius: 4px;
    margin-top: 8px;
}

#progress-fill {
    height: 100%;
    background: var(--color-accent);
    border-radius: 4px;
    transition: width 0.3s ease;
}

#tooltip {
    position: absolute;
    background: #1e293b;
    color: #f1f5f9;
    padding: 8px;
    border-radius: 4px;
    font-size: 12px;
    z-index: 2000;
    display: none;
}

#footer {
    position: absolute;
    bottom: 20px;
    right: 20px;
    font-size: 14px;
    color: var(--color-text-dark);
    background: var(--color-panel-light);
    padding: 8px 12px;
    border-radius: 6px;
    box-shadow: var(--box-shadow);
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 10px;
}

#theme-toggle {
    background: var(--color-primary-light);
    color: #fff;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
}

#theme-toggle:hover {
    background: #2563eb;
}

#modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 3000;
    justify-content: center;
    align-items: center;
    transition: var(--transition-default);
}

#modal-content {
    background: var(--color-panel-light);
    padding: 24px;
    border-radius: 10px;
    max-width: 700px;
    width: 90%;
    max-height: 85vh;
    overflow-y: auto;
    box-shadow: var(--box-shadow);
    position: relative;
    transition: var(--transition-default);
}

#modal-content h3 {
    font-size: 20px;
    font-weight: 600;
    color: var(--color-text-dark);
    margin-bottom: 16px;
    background: linear-gradient(135deg, var(--color-primary-light), var(--color-accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

#modal-content h4 {
    font-size: 16px;
    font-weight: 600;
    color: var(--color-accent);
    margin: 16px 0 8px;
}

#modal-content p,
#modal-content ul,
#modal-content pre {
    font-size: 14px;
    line-height: 1.6;
    color: var(--color-text-dark);
}

#modal-content ul {
    padding-left: 20px;
}

#modal-content pre {
    background: var(--color-border-light);
    padding: 12px;
    border-radius: 6px;
    overflow-x: auto;
    font-size: 13px;
}

#close-modal {
    position: absolute;
    top: 12px;
    right: 12px;
    background: linear-gradient(135deg, #dc2626, #f87171);
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: var(--transition-default);
}

#close-modal:hover {
    background: linear-gradient(135deg, #b91c1c, #ef4444);
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #sidebar {
        width: 240px;
    }

    #sidebar.collapsed {
        width: 50px;
    }

    #info,
    #metrics-panel {
        width: 220px;
        font-size: 12px;
    }

    #modal-content {
        width: 95%;
        padding: 16px;
    }

    #modal-content h3 {
        font-size: 18px;
    }

    #modal-content h4 {
        font-size: 14px;
    }

    #modal-content p,
    #modal-content ul,
    #modal-content pre {
        font-size: 13px;
    }
}

@media (max-width: 480px) {
    #sidebar {
        width: 100%;
        height: auto;
        max-height: 50vh;
    }

    #sidebar.collapsed {
        width: 100%;
        max-height: 60px;
    }

    #info,
    #metrics-panel {
        width: 90%;
        right: 5%;
    }
}

    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="sidebar">
        <button id="toggle-sidebar" aria-label="Toggle Sidebar">☰</button>
        <br>
        <br>
        <div class="section">
            <div class="section-header" data-section="grid-setup">Grid Setup <span>▼</span></div>
            <div class="section-content">
                <button id="startBtn" class="glow" aria-label="Set Start Node">Set Start</button>
                <button id="endBtn" class="glow" aria-label="Set End Node">Set End</button>
                <button id="wallBtn" class="glow" aria-label="Set Wall">Set Wall</button>
                <button id="randomWallsBtn" class="glow" aria-label="Generate Random Walls">Random Walls</button>
                <select id="obstaclePattern" aria-label="Select Obstacle Pattern">
                    <option value="none">Select Obstacle Pattern</option>
                    <option value="maze">Maze</option>
                    <option value="corridors">Corridors</option>
                    <option value="clusters">Clusters</option>
                </select>
                <button id="clearBtn" class="glow" aria-label="Clear Grid">Clear</button>
            </div>
        </div>
        <div class="section">
            <div class="section-header" data-section="algorithm-settings">Algorithm Settings <span>▼</span></div>
            <div class="section-content">
                <button id="runBtn" class="glow" aria-label="Run A* Algorithm">Run A*</button>
                <button id="stepBtn" class="glow" aria-label="Run Step-by-Step">Step-by-Step</button>
                <button id="nextStepBtn" class="glow" style="display: none;" aria-label="Next Step">Next Step</button>
                <label for="gridSize">Grid Size:</label>
                <select id="gridSize" aria-label="Select Grid Size">
                    <option value="20">Small (20x20)</option>
                    <option value="30">Medium (30x30)</option>
                    <option value="40">Large (40x40)</option>
                </select>
                <label for="speed">Animation Speed (ms):</label>
                <input type="range" id="speed" min="10" max="100" value="30" aria-label="Adjust Animation Speed">
                <label for="diagonalMovement">Diagonal Movement:</label>
                <input type="checkbox" id="diagonalMovement" aria-label="Toggle Diagonal Movement">
                <label for="heuristicWeight">Heuristic Weight:</label>
                <input type="range" id="heuristicWeight" min="0" max="2" step="0.1" value="1" aria-label="Adjust Heuristic Weight">
            </div>
        </div>
        <div class="section">
            <div class="section-header" data-section="visualization-tools">Visualization Tools <span>▼</span></div>
            <div class="section-content">
                <label for="highlightNodes">Highlight Nodes:</label>
                <input type="checkbox" id="highlightNodes" aria-label="Toggle Node Highlighting">
                <label for="heuristicHeatmap">Heuristic Heatmap:</label>
                <input type="checkbox" id="heuristicHeatmap" aria-label="Toggle Heuristic Heatmap">
            </div>
        </div>
        <div class="section">
            <div class="section-header" data-section="data-export">Data Export <span>▼</span></div>
            <div class="section-content">
                <button id="saveGridBtn" class="glow" aria-label="Save Grid Configuration">Save Grid</button>
                <input type="file" id="loadGridInput" accept=".json" style="display: none;" aria-label="Load Grid Configuration">
                <button id="loadGridBtn" class="glow" aria-label="Load Grid Configuration">Load Grid</button>
                <button id="exportMetricsBtn" class="glow" aria-label="Export Metrics">Export Metrics</button>
                <button id="explainBtn" class="glow" aria-label="Show Explanation">Show Explanation</button>
            </div>
        </div>
    </div>
    <div id="info">
        <strong>Status:</strong> Click to select: Start (Neon Cyan), End (Neon Magenta), Wall (Neon White)<br>
        <strong>Heuristic Weight:</strong> <span id="heuristicWeightText">1.0</span><br>
        <strong>Diagonal Movement:</strong> <span id="diagonalMovementText">Off</span><br>
        <strong>Animation Delay:</strong> <span id="speedText">360 ms</span><br>
        <div id="step-counter"><strong>Steps:</strong> 0</div>
        <div id="current-costs"><strong>Current Node Costs:</strong> g=0, h=0, f=0</div>
        <div id="progress-bar"><div id="progress-fill" style="width: 0%;"></div></div>
    </div>
    <div id="metrics-panel">
        <strong>Performance Metrics:</strong><br>
        Execution Time: <span id="executionTime">0 ms</span><br>
        Nodes Explored: <span id="nodesExplored">0</span><br>
        Path Cost: <span id="pathCost">0</span><br>
        Memory Usage: <span id="memoryUsage">0 KB</span>
    </div>
    <div id="modal">
        <div id="modal-content">
            <button id="close-modal" aria-label="Close Modal">Close</button>
            <h3 id="modal-title">A* Pathfinding Visualization</h3>
            <div id="modal-message">
                <h4>Overview of A* Algorithm</h4>
                <p>The A* (A-star) algorithm is a widely used pathfinding algorithm in computer science, known for its efficiency in finding the shortest path between two points in a weighted graph or grid. It combines the strengths of Dijkstra’s algorithm (guaranteed shortest path) and greedy best-first search (heuristic-guided exploration). A* is particularly valuable in applications such as robotics, video game AI, and geographic information systems.</p>
                <p>A* evaluates nodes using the cost function:</p>
                <pre>f(n) = g(n) + h(n)</pre>
                <p>Where:</p>
                <ul>
                    <li><strong>g(n)</strong>: Cost from the start node to node n (actual distance traveled).</li>
                    <li><strong>h(n)</strong>: Estimated cost from node n to the goal (heuristic).</li>
                    <li><strong>f(n)</strong>: Total estimated cost of the cheapest path through n.</li>
                </ul>
                <p>The algorithm maintains an <em>open set</em> (nodes to explore) and a <em>closed set</em> (nodes already evaluated), prioritizing nodes with the lowest f(n).</p>

                <h4>Pseudocode</h4>
                <pre>
function A*(start, goal):
    openSet = {start}
    closedSet = {}
    start.g = 0
    start.h = heuristic(start, goal)
    start.f = start.g + start.h

    while openSet is not empty:
        current = node in openSet with lowest f
        if current == goal:
            return reconstruct_path(current)
        
        remove current from openSet
        add current to closedSet
        
        for each neighbor of current:
            if neighbor in closedSet or neighbor is obstacle:
                continue
            tentative_g = current.g + distance(current, neighbor)
            
            if neighbor not in openSet:
                add neighbor to openSet
            else if tentative_g >= neighbor.g:
                continue
                
            neighbor.previous = current
            neighbor.g = tentative_g
            neighbor.h = heuristic(neighbor, goal)
            neighbor.f = neighbor.g + neighbor.h
    
    return failure
                </pre>

                <h4>Key Concepts</h4>
                <ul>
                    <li><strong>Heuristic Function</strong>: The heuristic estimates the cost to the goal. This visualization uses:
                        <ul>
                            <li><em>Manhattan Distance</em> (for 4-directional movement): |x1 - x2| + |y1 - y2|</li>
                            <li><em>Octile Distance</em> (for 8-directional movement): Combines straight (cost 1) and diagonal (cost √2) moves for accuracy.</li>
                        </ul>
                        The heuristic must be <em>admissible</em> (never overestimate the true cost) to guarantee the shortest path.
                    </li>
                    <li><strong>Heuristic Weight</strong>: Adjusts the influence of h(n). A weight of 0.0 mimics Dijkstra’s algorithm (no heuristic), while >1.0 makes A* greedier, potentially faster but less optimal.</li>
                    <li><strong>Diagonal Movement</strong>: Toggles between 4-directional (up, down, left, right) and 8-directional (includes diagonals) movement, affecting path length and computation.</li>
                </ul>

                <h4>Features for Academic Use</h4>
                <p>This visualization is designed for university students and professors to explore A* in educational and research contexts:</p>
                <ul>
                    <li><strong>Interactive Grid</strong>: Set start (Neon Cyan), end (Neon Magenta), and walls (Neon White) to create custom scenarios.</li>
                    <li><strong>Obstacle Patterns</strong>: Generate Maze, Corridors, or Clusters to simulate real-world environments (e.g., robotics navigation, game levels).</li>
                    <li><strong>Performance Metrics</strong>: Analyze execution time, nodes explored, path cost, and memory usage. Export as CSV for lab reports or research papers.</li>
                    <li><strong>Save/Load Configurations</strong>: Save grid setups as JSON files to share assignments or revisit experiments.</li>
                    <li><strong>Real-Time Node Highlighting</strong>: Visualize open (green) and closed (red) sets during pathfinding to understand A*’s exploration process.</li>
                    <li><strong>Heuristic Heatmap</strong>: Display h(n) values as a color gradient, illustrating how the heuristic guides the search.</li>
                    <li><strong>Step-by-Step Mode</strong>: Manually step through the algorithm to study each node evaluation, ideal for classroom demonstrations.</li>
                    <li><strong>Export Path Details</strong>: Include path coordinates and costs in the metrics CSV, useful for detailed analysis.</li>
                </ul>

                <h4>How to Use</h4>
                <ul>
                    <li>Click "Set Start" and a grid cell to place the start node (Neon Cyan).</li>
                    <li>Click "Set End" and a cell for the goal (Neon Magenta).</li>
                    <li>Click "Set Wall" to add/remove walls (Neon White).</li>
                    <li>Use "Random Walls" or select an "Obstacle Pattern" (Maze, Corridors, Clusters).</li>
                    <li>Choose grid size (20x20, 30x30, 40x40) and animation speed (higher slider = faster, 10ms to 460ms).</li>
                    <li>Toggle "Diagonal Movement" for 8-directional paths.</li>
                    <li>Adjust "Heuristic Weight" (0.0 to 2.0) to experiment with A*’s behavior.</li>
                    <li>Toggle "Highlight Nodes" to show open (green) and closed (red) sets.</li>
                    <li>Toggle "Heuristic Heatmap" to visualize h(n) values.</li>
                    <li>Click "Run A*" for automatic pathfinding or "Step-by-Step" for manual control.</li>
                    <li>Use "Save Grid" to download the current setup and "Load Grid" to upload a saved JSON file.</li>
                    <li>Click "Export Metrics" to download performance data and path details as CSV.</li>
                </ul>

                <h4>Visual Guide</h4>
                <ul>
                    <li><strong>Blue Lasers</strong>: Indicate edges checked during exploration.</li>
                    <li><strong>Blue Path</strong>: Final shortest path, with thicker lasers and blue nodes.</li>
                    <li><strong>Green Nodes</strong>: Open set (nodes to explore, if "Highlight Nodes" is on).</li>
                    <li><strong>Red Nodes</strong>: Closed set (nodes evaluated, if "Highlight Nodes" is on).</li>
                    <li><strong>Heatmap</strong>: Color gradient (blue to red) showing h(n) values (if "Heuristic Heatmap" is on).</li>
                    <li><strong>Progress Bar</strong>: Shows exploration progress (% of grid).</li>
                    <li><strong>Step Counter</strong>: Counts nodes processed.</li>
                    <li><strong>Costs</strong>: g (distance from start), h (estimated to goal), f (total).</li>
                    <li><strong>Metrics Panel</strong>: Displays execution time, nodes explored, path cost, and memory usage.</li>
                </ul>

                <h4>Applications in Academia and Industry</h4>
                <ul>
                    <li><strong>Coursework</strong>: Use for assignments in algorithms, AI, or robotics courses to study pathfinding behavior.</li>
                    <li><strong>Research</strong>: Analyze A* performance across grid sizes, obstacle patterns, or heuristic weights for optimization studies.</li>
                    <li><strong>Teaching</strong>: Demonstrate A* in lectures using step-by-step mode and node highlighting.</li>
                    <li><strong>Industry</strong>: Apply insights to robotics (e.g., warehouse robots), game development (NPC navigation), or GPS systems.</li>
                </ul>

                <h4>Tips for Students and Professors</h4>
                <ul>
                    <li><strong>Students</strong>: Experiment with heuristic weights and diagonal movement to see their impact on path length and computation time. Save configurations to compare results.</li>
                    <li><strong>Professors</strong>: Create specific grid setups for assignments (e.g., complex mazes) and share JSON files with students. Use the heatmap and node highlighting for interactive lectures.</li>
                    <li><strong>Researchers</strong>: Export metrics and path details to analyze A*’s efficiency in different scenarios, supporting publications or grant proposals.</li>
                </ul>
            </div>
            <p id="current-step"></p>
        </div>
    </div>
    <div id="tooltip"></div>
    <div id="footer">
        <span><b>Powered by Awarcrown Corporations</b></span>
        <button id="theme-toggle" aria-label="Toggle Theme">🌙</button>
    </div>
    <canvas id="canvas"></canvas>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tween.js/18.6.4/tween.umd.js"></script>
    <script>
        let GRID_SIZE = 20;
        const CELL_SIZE = 1;
        let nodes = [];
        let startNode = null, endNode = null;
        let mode = 'start';
        let speed = 30;
        let stepCount = 0;
        let isStepByStep = false;
        let isPaused = false;
        let allowDiagonal = false;
        let heuristicWeight = 1.0;
        let highlightNodes = false;
        let heuristicHeatmap = false;
        let metrics = { executionTime: 0, nodesExplored: 0, pathCost: 0, memoryUsage: 0 };
        let finalPath = [];

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('canvas'), antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);

        class Node {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.f = this.g = this.h = 0;
                this.neighbors = [];
                this.previous = null;
                this.isWall = false;
                this.mesh = this.createMesh();
            }

            createMesh() {
                const geometry = new THREE.BoxGeometry(CELL_SIZE * 0.9, CELL_SIZE * 0.9, 0.2);
                const material = new THREE.MeshBasicMaterial({ color: 0x1a1a4a, transparent: true, opacity: 1 });
                const mesh = new THREE.Mesh(geometry, material);
                mesh.position.set(this.x * CELL_SIZE, this.y * CELL_SIZE, 0);
                scene.add(mesh);
                return mesh;
            }

            setColor(color, animate = false) {
                this.mesh.material.color.setHex(color);
                console.log(`Setting node at (${this.x}, ${this.y}) to color ${color.toString(16)}`);
            }
        }

        class Confetti {
            constructor() {
                this.particles = [];
                if (endNode) {
                    this.createParticles();
                }
            }

            createParticles() {
                for (let i = 0; i < 50; i++) {
                    const geometry = new THREE.SphereGeometry(0.1, 8, 8);
                    const material = new THREE.MeshBasicMaterial({ color: Math.random() > 0.5 ? 0x00eaff : 0xff00ff });
                    const particle = new THREE.Mesh(geometry, material);
                    particle.position.set(endNode.x * CELL_SIZE, endNode.y * CELL_SIZE, 1);
                    scene.add(particle);
                    this.particles.push(particle);
                    new TWEEN.Tween(particle.position)
                        .to({
                            x: particle.position.x + (Math.random() - 0.5) * 5,
                            y: particle.position.y + (Math.random() - 0.5) * 5,
                            z: particle.position.z + Math.random() * 2
                        }, 1000)
                        .easing(TWEEN.Easing.Quadratic.Out)
                        .onComplete(() => scene.remove(particle))
                        .start();
                }
            }
        }

        function drawLaser(fromNode, toNode, color = 0x00b7eb, duration = 500, isPath = false) {
            console.log(`Drawing laser from (${fromNode.x}, ${fromNode.y}) to (${toNode.x}, ${toNode.y})`);
            const points = [
                new THREE.Vector3(fromNode.x * CELL_SIZE, fromNode.y * CELL_SIZE, 0.1),
                new THREE.Vector3(toNode.x * CELL_SIZE, toNode.y * CELL_SIZE, 0.1)
            ];
            const geometry = new THREE.BufferGeometry().setFromPoints(points);
            const material = new THREE.LineBasicMaterial({
                color: color,
                linewidth: isPath ? 3 : 1,
                transparent: true,
                opacity: 0.5
            });
            const line = new THREE.Line(geometry, material);
            scene.add(line);
            new TWEEN.Tween(line.material)
                .to({ opacity: 1 }, duration / 2)
                .yoyo(true)
                .repeat(isPath ? 3 : 1)
                .onComplete(() => {
                    if (!isPath) {
                        scene.remove(line);
                        geometry.dispose();
                        material.dispose();
                    }
                })
                .start();
            return line;
        }

        function initGrid() {
            scene.children
                .filter(child => child.isMesh || child.isLine)
                .forEach(child => {
                    scene.remove(child);
                    if (child.geometry) child.geometry.dispose();
                    if (child.material) child.material.dispose();
                });
            nodes = [];
            startNode = endNode = null;
            stepCount = 0;
            finalPath = [];
            metrics = { executionTime: 0, nodesExplored: 0, pathCost: 0, memoryUsage: 0 };
            updateMetricsPanel();
            const stepCounter = document.getElementById('step-counter');
            const progressFill = document.getElementById('progress-fill');
            const currentCosts = document.getElementById('current-costs');
            const speedText = document.getElementById('speedText');
            const infoElement = document.getElementById('info');
            if (stepCounter) stepCounter.innerHTML = '<strong>Steps:</strong> 0';
            if (progressFill) progressFill.style.width = '0%';
            if (currentCosts) currentCosts.innerHTML = '<strong>Current Node Costs:</strong> g=0, h=0, f=0';
            if (speedText) speedText.innerText = `${(510 - speed * 5)} ms`;
            if (infoElement) {
                infoElement.innerHTML = `<strong>Status:</strong> Click to select: Start (Neon Cyan), End (Neon Magenta), Wall (Neon White)<br>` +
                    `<strong>Heuristic Weight:</strong> <span id="heuristicWeightText">${heuristicWeight.toFixed(1)}</span><br>` +
                    `<strong>Diagonal Movement:</strong> <span id="diagonalMovementText">${allowDiagonal ? 'On' : 'Off'}</span><br>` +
                    `<strong>Animation Delay:</strong> <span id="speedText">${(510 - speed * 5)} ms</span><br>` +
                    `<div id="step-counter"><strong>Steps:</strong> 0</div>` +
                    `<div id="current-costs"><strong>Current Node Costs:</strong> g=0, h=0, f=0</div>` +
                    `<div id="progress-bar"><div id="progress-fill" style="width: 0%;"></div></div>`;
            }
            for (let x = 0; x < GRID_SIZE; x++) {
                nodes[x] = [];
                for (let y = 0; y < GRID_SIZE; y++) {
                    nodes[x][y] = new Node(x, y);
                    nodes[x][y].g = nodes[x][y].h = nodes[x][y].f = 0;
                    nodes[x][y].previous = null;
                    nodes[x][y].isWall = false;
                }
            }
            for (let x = 0; x < GRID_SIZE; x++) {
                for (let y = 0; y < GRID_SIZE; y++) {
                    const node = nodes[x][y];
                    if (x > 0) node.neighbors.push(nodes[x - 1][y]);
                    if (x < GRID_SIZE - 1) node.neighbors.push(nodes[x + 1][y]);
                    if (y > 0) node.neighbors.push(nodes[x][y - 1]);
                    if (y < GRID_SIZE - 1) node.neighbors.push(nodes[x][y + 1]);
                    if (allowDiagonal) {
                        if (x > 0 && y > 0) node.neighbors.push(nodes[x - 1][y - 1]);
                        if (x > 0 && y < GRID_SIZE - 1) node.neighbors.push(nodes[x - 1][y + 1]);
                        if (x < GRID_SIZE - 1 && y > 0) node.neighbors.push(nodes[x + 1][y - 1]);
                        if (x < GRID_SIZE - 1 && y < GRID_SIZE - 1) node.neighbors.push(nodes[x + 1][y + 1]);
                    }
                }
            }
            camera.position.set(GRID_SIZE / 2, GRID_SIZE / 2, GRID_SIZE * 0.8);
            camera.lookAt(GRID_SIZE / 2, GRID_SIZE / 2, 0);
            if (heuristicHeatmap) updateHeuristicHeatmap();
        }

        function heuristic(a, b) {
            const dx = Math.abs(a.x - b.x);
            const dy = Math.abs(a.y - b.y);
            if (allowDiagonal) {
                const D = 1;
                const D2 = Math.sqrt(2);
                return D * (dx + dy) + (D2 - 2 * D) * Math.min(dx, dy);
            } else {
                return Math.abs(a.x - b.x) + Math.abs(a.y - b.y);
            }
        }

        function updateHeuristicHeatmap() {
            if (!endNode) return;
            let maxH = 0;
            nodes.flat().forEach(node => {
                node.h = heuristic(node, endNode);
                if (node.h > maxH) maxH = node.h;
            });
            nodes.flat().forEach(node => {
                if (node !== startNode && node !== endNode && !node.isWall) {
                    const t = node.h / maxH;
                    const r = Math.floor(t * 255);
                    const b = Math.floor((1 - t) * 255);
                    const color = (r << 16) | (0 << 8) | b;
                    node.setColor(color);
                }
            });
        }

        function updateMetricsPanel() {
            document.getElementById('executionTime').innerText = `${metrics.executionTime.toFixed(2)} ms`;
            document.getElementById('nodesExplored').innerText = metrics.nodesExplored;
            document.getElementById('pathCost').innerText = metrics.pathCost.toFixed(2);
            document.getElementById('memoryUsage').innerText = `${metrics.memoryUsage.toFixed(2)} KB`;
        }

        function exportMetrics() {
            let csvContent = [
                "Execution Time (ms),Nodes Explored,Path Cost,Memory Usage (KB),Path Coordinates,Path Node Costs (g)"
            ];
            let pathCoords = finalPath.length > 0 ? finalPath.map(node => `(${node.x},${node.y})`).join(';') : 'None';
            let pathCosts = finalPath.length > 0 ? finalPath.map(node => node.g.toFixed(2)).join(';') : 'None';
            csvContent.push(
                `${metrics.executionTime.toFixed(2)},${metrics.nodesExplored},${metrics.pathCost.toFixed(2)},${metrics.memoryUsage.toFixed(2)},${pathCoords},${pathCosts}`
            );
            const blob = new Blob([csvContent.join('\n')], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'pathfinding_metrics.csv';
            a.click();
            URL.revokeObjectURL(url);
        }

        function saveGrid() {
            const gridData = {
                gridSize: GRID_SIZE,
                start: startNode ? { x: startNode.x, y: startNode.y } : null,
                end: endNode ? { x: endNode.x, y: endNode.y } : null,
                walls: nodes.flat().filter(node => node.isWall).map(node => ({ x: node.x, y: node.y })),
                diagonalMovement: allowDiagonal,
                heuristicWeight: heuristicWeight
            };
            const blob = new Blob([JSON.stringify(gridData, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'grid_config.json';
            a.click();
            URL.revokeObjectURL(url);
        }

        function loadGrid(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const gridData = JSON.parse(e.target.result);
                    if (gridData.gridSize && gridData.gridSize >= 20 && gridData.gridSize <= 40) {
                        GRID_SIZE = gridData.gridSize;
                        document.getElementById('gridSize').value = GRID_SIZE;
                    }
                    allowDiagonal = !!gridData.diagonalMovement;
                    document.getElementById('diagonalMovement').checked = allowDiagonal;
                    heuristicWeight = gridData.heuristicWeight || 1.0;
                    document.getElementById('heuristicWeight').value = heuristicWeight;
                    initGrid();
                    if (gridData.start) {
                        startNode = nodes[gridData.start.x][gridData.start.y];
                        startNode.setColor(0x00eaff);
                    }
                    if (gridData.end) {
                        endNode = nodes[gridData.end.x][gridData.end.y];
                        endNode.setColor(0xff00ff);
                    }
                    if (gridData.walls) {
                        gridData.walls.forEach(wall => {
                            if (nodes[wall.x] && nodes[wall.x][wall.y]) {
                                nodes[wall.x][wall.y].isWall = true;
                                nodes[wall.x][wall.y].setColor(0xffffff);
                            }
                        });
                    }
                    updateInfoText();
                } catch (err) {
                    showModal('Error', 'Invalid grid configuration file.');
                }
            };
            reader.readAsText(file);
        }

        function generateObstaclePattern(pattern) {
            nodes.flat().forEach(node => {
                if (node !== startNode && node !== endNode) {
                    node.isWall = false;
                    node.setColor(0x1a1a4a);
                }
            });
            if (pattern === 'maze') {
                for (let x = 0; x < GRID_SIZE; x += 2) {
                    for (let y = 0; y < GRID_SIZE; y += 2) {
                        if (Math.random() > 0.3 && nodes[x][y] !== startNode && nodes[x][y] !== endNode) {
                            nodes[x][y].isWall = true;
                            nodes[x][y].setColor(0xffffff);
                            if (x + 1 < GRID_SIZE) {
                                nodes[x + 1][y].isWall = true;
                                nodes[x + 1][y].setColor(0xffffff);
                            }
                        }
                    }
                }
            } else if (pattern === 'corridors') {
                for (let x = 0; x < GRID_SIZE; x += 3) {
                    for (let y = 0; y < GRID_SIZE; y++) {
                        if (nodes[x][y] !== startNode && nodes[x][y] !== endNode) {
                            nodes[x][y].isWall = true;
                            nodes[x][y].setColor(0xffffff);
                        }
                    }
                }
            } else if (pattern === 'clusters') {
                for (let i = 0; i < 5; i++) {
                    const cx = Math.floor(Math.random() * GRID_SIZE);
                    const cy = Math.floor(Math.random() * GRID_SIZE);
                    for (let x = cx - 2; x <= cx + 2; x++) {
                        for (let y = cy - 2; y <= cy + 2; y++) {
                            if (x >= 0 && x < GRID_SIZE && y >= 0 && y < GRID_SIZE && Math.random() > 0.5 &&
                                nodes[x][y] !== startNode && nodes[x][y] !== endNode) {
                                nodes[x][y].isWall = true;
                                nodes[x][y].setColor(0xffffff);
                            }
                        }
                    }
                }
            }
            if (heuristicHeatmap) updateHeuristicHeatmap();
        }

        function showModal(title, message) {
            const modal = document.getElementById('modal');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');
            const currentStep = document.getElementById('current-step');
            if (modalTitle) modalTitle.innerText = title;
            if (modalMessage) modalMessage.innerHTML = `<p>${message}</p>`;
            if (currentStep) currentStep.innerText = '';
            if (modal) modal.style.display = 'flex';
        }

        async function aStar() {
            if (!startNode || !endNode) {
                showModal('Error', 'Please set start and end points.');
                return;
            }
            const startTime = performance.now();
            const currentStep = document.getElementById('current-step');
            const stepCounter = document.getElementById('step-counter');
            const currentCosts = document.getElementById('current-costs');
            const progressFill = document.getElementById('progress-fill');
            if (currentStep) currentStep.innerText = 'Step: Starting the search from the cyan start node.';
            const openSet = [startNode];
            const closedSet = [];
            startNode.g = 0;
            startNode.h = heuristic(startNode, endNode) * heuristicWeight;
            startNode.f = startNode.g + startNode.h;
            stepCount = 0;
            metrics.nodesExplored = 0;
            finalPath = [];
            if (stepCounter) stepCounter.innerHTML = `<strong>Steps:</strong> 0`;
            if (progressFill) progressFill.style.width = '0%';

            while (openSet.length > 0) {
                let current = openSet.reduce((a, b) => a.f < b.f ? a : b);
                stepCount++;
                metrics.nodesExplored++;
                if (stepCounter) stepCounter.innerHTML = `<strong>Steps:</strong> ${stepCount}`;
                if (currentCosts) currentCosts.innerHTML = `<strong>Current Node Costs:</strong> g=${current.g.toFixed(2)}, h=${current.h.toFixed(2)}, f=${current.f.toFixed(2)}`;
                if (currentStep) currentStep.innerText = `Step: Checking node at (${current.x}, ${current.y}) with f=${current.f.toFixed(2)}.`;
                if (progressFill) {
                    const progress = (closedSet.length / (GRID_SIZE * GRID_SIZE)) * 100;
                    progressFill.style.width = `${progress}%`;
                }

                if (current === endNode) {
                    const path = [];
                    let pathCost = current.g;
                    while (current) {
                        path.push(current);
                        current = current.previous;
                    }
                    finalPath = path.reverse();
                    finalPath.forEach((node, i) => {
                        if (node !== startNode && node !== endNode) {
                            setTimeout(() => {
                                node.setColor(0x00b7eb);
                                if (node.previous) drawLaser(node, node.previous, 0x00b7eb, 1000, true);
                            }, i * 100);
                        }
                    });
                    metrics.executionTime = performance.now() - startTime;
                    metrics.pathCost = pathCost;
                    metrics.memoryUsage = (metrics.nodesExplored * 0.1);
                    updateMetricsPanel();
                    showModal('Success', `Path Found! Cost: ${pathCost.toFixed(2)} 🎉`);
                    if (currentStep) currentStep.innerText = `Step: Path found! Total cost: ${pathCost.toFixed(2)}.`;
                    new Confetti();
                    return;
                }

                openSet.splice(openSet.indexOf(current), 1);
                closedSet.push(current);

                if (highlightNodes) {
                    nodes.flat().forEach(node => {
                        if (node !== startNode && node !== endNode && !node.isWall) {
                            if (openSet.includes(node)) {
                                node.setColor(0x00ff00);
                            } else if (closedSet.includes(node)) {
                                node.setColor(0xff0000);
                            } else if (!heuristicHeatmap) {
                                node.setColor(0x1a1a4a);
                            }
                        }
                    });
                }

                for (let neighbor of current.neighbors) {
                    if (closedSet.includes(neighbor) || neighbor.isWall) continue;

                    const isDiagonal = allowDiagonal && Math.abs(current.x - neighbor.x) + Math.abs(current.y - neighbor.y) > 1;
                    const moveCost = isDiagonal ? Math.sqrt(2) : 1;
                    const tentativeG = current.g + moveCost;
                    drawLaser(current, neighbor);
                    if (currentStep) currentStep.innerText = `Step: Checking neighbor at (${neighbor.x}, ${neighbor.y}).`;
                    if (!openSet.includes(neighbor)) {
                        openSet.push(neighbor);
                    } else if (tentativeG >= neighbor.g) {
                        continue;
                    }

                    neighbor.previous = current;
                    neighbor.g = tentativeG;
                    neighbor.h = heuristic(neighbor, endNode) * heuristicWeight;
                    neighbor.f = neighbor.g + neighbor.h;
                    if (isStepByStep) {
                        isPaused = true;
                        const nextStepBtn = document.getElementById('nextStepBtn');
                        if (nextStepBtn) nextStepBtn.style.display = 'block';
                        await new Promise(resolve => {
                            if (nextStepBtn) {
                                nextStepBtn.onclick = () => {
                                    isPaused = false;
                                    nextStepBtn.style.display = 'none';
                                    resolve();
                                };
                            } else {
                                resolve();
                            }
                        });
                    } else {
                        const delay = 510 - speed * 5;
                        await new Promise(resolve => setTimeout(resolve, delay));
                    }
                }
            }
            metrics.executionTime = performance.now() - startTime;
            metrics.pathCost = 0;
            metrics.memoryUsage = (metrics.nodesExplored * 0.1);
            updateMetricsPanel();
            showModal('Error', 'No path found!');
            if (currentStep) currentStep.innerText = 'Step: No path exists to the goal.';
        }

        function generateRandomWalls() {
            nodes.flat().forEach(node => {
                if (node !== startNode && node !== endNode && Math.random() < 0.2) {
                    node.isWall = true;
                    node.setColor(0xffffff);
                }
            });
            if (heuristicHeatmap) updateHeuristicHeatmap();
        }

        const raycaster = new THREE.Raycaster();
        const mouse = new THREE.Vector2();

        function onMouseClick(event) {
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
            raycaster.setFromCamera(mouse, camera);
            const intersects = raycaster.intersectObjects(scene.children);
            if (intersects.length > 0) {
                const mesh = intersects[0].object;
                const node = nodes.flat().find(n => n.mesh === mesh);
                if (!node) return;

                if (mode === 'start') {
                    if (startNode) startNode.setColor(0x1a1a4a);
                    startNode = node;
                    node.setColor(0x00eaff);
                } else if (mode === 'end') {
                    if (endNode) endNode.setColor(0x1a1a4a);
                    endNode = node;
                    node.setColor(0xff00ff);
                    if (heuristicHeatmap) updateHeuristicHeatmap();
                } else if (mode === 'wall') {
                    if (node !== startNode && node !== endNode) {
                        node.isWall = !node.isWall;
                        node.setColor(node.isWall ? 0xffffff : 0x1a1a4a);
                        if (heuristicHeatmap) updateHeuristicHeatmap();
                    }
                }
            }
        }

        function onMouseMove(event) {
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
            raycaster.setFromCamera(mouse, camera);
            const intersects = raycaster.intersectObjects(scene.children);
            scene.children.forEach(child => {
                if (child.material) child.material.opacity = 1;
            });
            const tooltip = document.getElementById('tooltip');
            if (tooltip && intersects.length > 0) {
                const mesh = intersects[0].object;
                const node = nodes.flat().find(n => n.mesh === mesh);
                if (node) {
                    mesh.material.opacity = 0.7;
                    tooltip.style.display = 'block';
                    tooltip.style.left = `${event.clientX + 10}px`;
                    tooltip.style.top = `${event.clientY + 10}px`;
                    tooltip.innerText = `Node: (${node.x}, ${node.y})\n` +
                                       `g: ${node.g.toFixed(2)}, h: ${node.h.toFixed(2)}, f: ${node.f.toFixed(2)}\n` +
                                       `Status: ${node.isWall ? 'Wall' : node === startNode ? 'Start' : node === endNode ? 'End' : 'Normal'}`;
                }
            } else if (tooltip) {
                tooltip.style.display = 'none';
            }
        }

        function updateInfoText() {
            const heuristicWeightText = document.getElementById('heuristicWeightText');
            const diagonalMovementText = document.getElementById('diagonalMovementText');
            const speedText = document.getElementById('speedText');
            if (heuristicWeightText) heuristicWeightText.innerText = heuristicWeight.toFixed(1);
            if (diagonalMovementText) diagonalMovementText.innerText = allowDiagonal ? 'On' : 'Off';
            if (speedText) speedText.innerText = `${(510 - speed * 5)} ms`;
        }

        document.getElementById('diagonalMovement').addEventListener('change', (e) => {
            allowDiagonal = e.target.checked;
            initGrid();
            updateInfoText();
        });

        document.getElementById('heuristicWeight').addEventListener('input', (e) => {
            heuristicWeight = parseFloat(e.target.value);
            updateInfoText();
        });

        document.getElementById('speed').addEventListener('input', (e) => {
            speed = parseInt(e.target.value);
            updateInfoText();
        });

        document.getElementById('highlightNodes').addEventListener('change', (e) => {
            highlightNodes = e.target.checked;
            if (!highlightNodes) {
                nodes.flat().forEach(node => {
                    if (node !== startNode && node !== endNode && !node.isWall && !heuristicHeatmap) {
                        node.setColor(0x1a1a4a);
                    }
                });
            }
        });

        document.getElementById('heuristicHeatmap').addEventListener('change', (e) => {
            heuristicHeatmap = e.target.checked;
            if (heuristicHeatmap) {
                updateHeuristicHeatmap();
            } else {
                nodes.flat().forEach(node => {
                    if (node !== startNode && node !== endNode && !node.isWall) {
                        node.setColor(0x1a1a4a);
                    }
                });
            }
        });

        document.getElementById('obstaclePattern').addEventListener('change', (e) => {
            if (e.target.value !== 'none') {
                generateObstaclePattern(e.target.value);
                e.target.value = 'none';
            }
        });

        document.getElementById('startBtn').addEventListener('click', () => setMode('start'));
        document.getElementById('endBtn').addEventListener('click', () => setMode('end'));
        document.getElementById('wallBtn').addEventListener('click', () => setMode('wall'));
        document.getElementById('randomWallsBtn').addEventListener('click', generateRandomWalls);
        document.getElementById('clearBtn').addEventListener('click', () => {
            scene.children
                .filter(child => child.isLine)
                .forEach(line => {
                    scene.remove(line);
                    if (line.geometry) line.geometry.dispose();
                    if (line.material) line.material.dispose();
                });
            nodes.flat().forEach(node => {
                node.isWall = false;
                node.previous = null;
                node.g = node.f = node.h = 0;
                node.setColor(0x1a1a4a);
            });
            startNode = endNode = null;
            finalPath = [];
            metrics = { executionTime: 0, nodesExplored: 0, pathCost: 0, memoryUsage: 0 };
            updateMetricsPanel();
            const infoElement = document.getElementById('info');
            const currentStep = document.getElementById('current-step');
            const stepCounter = document.getElementById('step-counter');
            const progressFill = document.getElementById('progress-fill');
            const currentCosts = document.getElementById('current-costs');
            const speedText = document.getElementById('speedText');
            if (infoElement) {
                infoElement.innerHTML = `<strong>Status:</strong> Click to select: Start (Neon Cyan), End (Neon Magenta), Wall (Neon White)<br>` +
                    `<strong>Heuristic Weight:</strong> <span id="heuristicWeightText">${heuristicWeight.toFixed(1)}</span><br>` +
                    `<strong>Diagonal Movement:</strong> <span id="diagonalMovementText">${allowDiagonal ? 'On' : 'Off'}</span><br>` +
                    `<strong>Animation Delay:</strong> <span id="speedText">${(510 - speed * 5)} ms</span><br>` +
                    `<div id="step-counter"><strong>Steps:</strong> 0</div>` +
                    `<div id="current-costs"><strong>Current Node Costs:</strong> g=0, h=0, f=0</div>` +
                    `<div id="progress-bar"><div id="progress-fill" style="width: 0%;"></div></div>`;
            }
            if (currentStep) currentStep.innerText = '';
            if (stepCounter) stepCounter.innerHTML = '<strong>Steps:</strong> 0';
            if (progressFill) progressFill.style.width = '0%';
            if (currentCosts) currentCosts.innerHTML = '<strong>Current Node Costs:</strong> g=0, h=0, f=0';
            if (speedText) speedText.innerText = `${(510 - speed * 5)} ms`;
        });
        document.getElementById('runBtn').addEventListener('click', () => {
            isStepByStep = false;
            const nextStepBtn = document.getElementById('nextStepBtn');
            if (nextStepBtn) nextStepBtn.style.display = 'none';
            aStar();
        });
        document.getElementById('stepBtn').addEventListener('click', () => {
            isStepByStep = true;
            aStar();
        });
        document.getElementById('gridSize').addEventListener('change', (e) => {
            GRID_SIZE = parseInt(e.target.value);
            initGrid();
        });
        document.getElementById('saveGridBtn').addEventListener('click', saveGrid);
        document.getElementById('loadGridBtn').addEventListener('click', () => {
            document.getElementById('loadGridInput').click();
        });
        document.getElementById('loadGridInput').addEventListener('change', loadGrid);
        document.getElementById('exportMetricsBtn').addEventListener('click', exportMetrics);
        document.getElementById('explainBtn').addEventListener('click', () => {
            const modal = document.getElementById('modal');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');
            if (modalTitle) modalTitle.innerText = 'A* Pathfinding Visualization';
            if (modalMessage) {
                modalMessage.innerHTML = `
                    <h4>Overview of A* Algorithm</h4>
                    <p>The A* (A-star) algorithm is a widely used pathfinding algorithm in computer science, known for its efficiency in finding the shortest path between two points in a weighted graph or grid. It combines the strengths of Dijkstra’s algorithm (guaranteed shortest path) and greedy best-first search (heuristic-guided exploration). A* is particularly valuable in applications such as robotics, video game AI, and geographic information systems.</p>
                    <p>A* evaluates nodes using the cost function:</p>
                    <pre>f(n) = g(n) + h(n)</pre>
                    <p>Where:</p>
                    <ul>
                        <li><strong>g(n)</strong>: Cost from the start node to node n (actual distance traveled).</li>
                        <li><strong>h(n)</strong>: Estimated cost from node n to the goal (heuristic).</li>
                        <li><strong>f(n)</strong>: Total estimated cost of the cheapest path through n.</li>
                    </ul>
                    <p>The algorithm maintains an <em>open set</em> (nodes to explore) and a <em>closed set</em> (nodes already evaluated), prioritizing nodes with the lowest f(n).</p>

                    <h4>Pseudocode</h4>
                    <pre>
function A*(start, goal):
    openSet = {start}
    closedSet = {}
    start.g = 0
    start.h = heuristic(start, goal)
    start.f = start.g + start.h

    while openSet is not empty:
        current = node in openSet with lowest f
        if current == goal:
            return reconstruct_path(current)
        
        remove current from openSet
        add current to closedSet
        
        for each neighbor of current:
            if neighbor in closedSet or neighbor is obstacle:
                continue
            tentative_g = current.g + distance(current, neighbor)
            
            if neighbor not in openSet:
                add neighbor to openSet
            else if tentative_g >= neighbor.g:
                continue
                
            neighbor.previous = current
            neighbor.g = tentative_g
            neighbor.h = heuristic(neighbor, goal)
            neighbor.f = neighbor.g + neighbor.h
    
    return failure
                    </pre>

                    <h4>Key Concepts</h4>
                    <ul>
                        <li><strong>Heuristic Function</strong>: The heuristic estimates the cost to the goal. This visualization uses:
                            <ul>
                                <li><em>Manhattan Distance</em> (for 4-directional movement): |x1 - x2| + |y1 - y2|</li>
                                <li><em>Octile Distance</em> (for 8-directional movement): Combines straight (cost 1) and diagonal (cost √2) moves for accuracy.</li>
                            </ul>
                            The heuristic must be <em>admissible</em> (never overestimate the true cost) to guarantee the shortest path.
                        </li>
                        <li><strong>Heuristic Weight</strong>: Adjusts the influence of h(n). A weight of 0.0 mimics Dijkstra’s algorithm (no heuristic), while >1.0 makes A* greedier, potentially faster but less optimal.</li>
                        <li><strong>Diagonal Movement</strong>: Toggles between 4-directional (up, down, left, right) and 8-directional (includes diagonals) movement, affecting path length and computation.</li>
                    </ul>

                    <h4>Features for Academic Use</h4>
                    <p>This visualization is designed for university students and professors to explore A* in educational and research contexts:</p>
                    <ul>
                        <li><strong>Interactive Grid</strong>: Set start (Neon Cyan), end (Neon Magenta), and walls (Neon White) to create custom scenarios.</li>
                        <li><strong>Obstacle Patterns</strong>: Generate Maze, Corridors, or Clusters to simulate real-world environments (e.g., robotics navigation, game levels).</li>
                        <li><strong>Performance Metrics</strong>: Analyze execution time, nodes explored, path cost, and memory usage. Export as CSV for lab reports or research papers.</li>
                        <li><strong>Save/Load Configurations</strong>: Save grid setups as JSON files to share assignments or revisit experiments.</li>
                        <li><strong>Real-Time Node Highlighting</strong>: Visualize open (green) and closed (red) sets during pathfinding to understand A*’s exploration process.</li>
                        <li><strong>Heuristic Heatmap</strong>: Display h(n) values as a color gradient, illustrating how the heuristic guides the search.</li>
                        <li><strong>Step-by-Step Mode</strong>: Manually step through the algorithm to study each node evaluation, ideal for classroom demonstrations.</li>
                        <li><strong>Export Path Details</strong>: Include path coordinates and costs in the metrics CSV, useful for detailed analysis.</li>
                    </ul>

                    <h4>How to Use</h4>
                    <ul>
                        <li>Click "Set Start" and a grid cell to place the start node (Neon Cyan).</li>
                        <li>Click "Set End" and a cell for the goal (Neon Magenta).</li>
                        <li>Click "Set Wall" to add/remove walls (Neon White).</li>
                        <li>Use "Random Walls" or select an "Obstacle Pattern" (Maze, Corridors, Clusters).</li>
                        <li>Choose grid size (20x20, 30x30, 40x40) and animation speed (higher slider = faster, 10ms to 460ms).</li>
                        <li>Toggle "Diagonal Movement" for 8-directional paths.</li>
                        <li>Adjust "Heuristic Weight" (0.0 to 2.0) to experiment with A*’s behavior.</li>
                        <li>Toggle "Highlight Nodes" to show open (green) and closed (red) sets.</li>
                        <li>Toggle "Heuristic Heatmap" to visualize h(n) values.</li>
                        <li>Click "Run A*" for automatic pathfinding or "Step-by-Step" for manual control.</li>
                        <li>Use "Save Grid" to download the current setup and "Load Grid" to upload a saved JSON file.</li>
                        <li>Click "Export Metrics" to download performance data and path details as CSV.</li>
                    </ul>

                    <h4>Visual Guide</h4>
                    <ul>
                        <li><strong>Blue Lasers</strong>: Indicate edges checked during exploration.</li>
                        <li><strong>Blue Path</strong>: Final shortest path, with thicker lasers and blue nodes.</li>
                        <li><strong>Green Nodes</strong>: Open set (nodes to explore, if "Highlight Nodes" is on).</li>
                        <li><strong>Red Nodes</strong>: Closed set (nodes evaluated, if "Highlight Nodes" is on).</li>
                        <li><strong>Heatmap</strong>: Color gradient (blue to red) showing h(n) values (if "Heuristic Heatmap" is on).</li>
                        <li><strong>Progress Bar</strong>: Shows exploration progress (% of grid).</li>
                        <li><strong>Step Counter</strong>: Counts nodes processed.</li>
                        <li><strong>Costs</strong>: g (distance from start), h (estimated to goal), f (total).</li>
                        <li><strong>Metrics Panel</strong>: Displays execution time, nodes explored, path cost, and memory usage.</li>
                    </ul>

                    <h4>Applications in Academia and Industry</h4>
                    <ul>
                        <li><strong>Coursework</strong>: Use for assignments in algorithms, AI, or robotics courses to study pathfinding behavior.</li>
                        <li><strong>Research</strong>: Analyze A* performance across grid sizes, obstacle patterns, or heuristic weights for optimization studies.</li>
                        <li><strong>Teaching</strong>: Demonstrate A* in lectures using step-by-step mode and node highlighting.</li>
                        <li><strong>Industry</strong>: Apply insights to robotics (e.g., warehouse robots), game development (NPC navigation), or GPS systems.</li>
                    </ul>

                    <h4>Tips for Students and Professors</h4>
                    <ul>
                        <li><strong>Students</strong>: Experiment with heuristic weights and diagonal movement to see their impact on path length and computation time. Save configurations to compare results.</li>
                        <li><strong>Professors</strong>: Create specific grid setups for assignments (e.g., complex mazes) and share JSON files with students. Use the heatmap and node highlighting for interactive lectures.</li>
                        <li><strong>Researchers</strong>: Export metrics and path details to analyze A*’s efficiency in different scenarios, supporting publications or grant proposals.</li>
                    </ul>
                `;
            }
            if (modal) modal.style.display = 'flex';
        });
        document.getElementById('close-modal').addEventListener('click', () => {
            const modal = document.getElementById('modal');
            if (modal) modal.style.display = 'none';
        });

        function setMode(newMode) {
            mode = newMode;
            ['startBtn', 'endBtn', 'wallBtn'].forEach(id => {
                const btn = document.getElementById(id);
                if (btn) btn.classList.remove('active');
            });
            const activeBtn = document.getElementById(newMode + 'Btn');
            if (activeBtn) activeBtn.classList.add('active');
        }

        // UI Interactions
        document.getElementById('toggle-sidebar').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        });

        document.querySelectorAll('.section-header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                content.style.display = content.style.display === 'none' ? 'block' : 'none';
                header.querySelector('span').textContent = content.style.display === 'none' ? '▶' : '▼';
            });
        });

        document.getElementById('theme-toggle').addEventListener('click', () => {
            document.body.dataset.theme = document.body.dataset.theme === 'dark' ? 'light' : 'dark';
            document.getElementById('theme-toggle').textContent = document.body.dataset.theme === 'dark' ? '☀️' : '🌙';
        });

        // Keyboard Navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modal');
                if (modal && modal.style.display === 'flex') {
                    modal.style.display = 'none';
                }
            }
        });

        function animate() {
            requestAnimationFrame(animate);
            TWEEN.update();
            renderer.render(scene, camera);
        }

        window.addEventListener('click', onMouseClick);
        window.addEventListener('mousemove', onMouseMove);

        initGrid();
        animate();
    </script>
</body>
</html>