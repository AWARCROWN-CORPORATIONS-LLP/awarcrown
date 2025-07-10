<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Algorithm Innovation Hub</title>
    <link href="algorithmsstylesheet.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4684898612889632" crossorigin="anonymous"></script>
    <link href="algorithmimages/black_logo.png" rel="icon">
</head>
<script>
    function scrollToSection(sectionId) {
    document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
}

function showAlgorithm(algorithm) {
    const contentDiv = document.getElementById('algorithmContent');
    let content = '';

    switch (algorithm) {
        case 'mergeSort':
            content = `
                <h3>Merge Sort</h3>
                <p>Merge Sort is a divide-and-conquer algorithm that recursively divides the input array into two halves, sorts them, and merges the sorted halves.</p>
                <p><strong>Time Complexity:</strong> O(n log n)</p>
                <p><strong>Space Complexity:</strong> O(n)</p>
            `;
            break;
        case 'bubbleSort':
            content = `
                <h3>Bubble Sort</h3>
                <p>Bubble Sort repeatedly steps through the list, compares adjacent elements, and swaps them if they are in the wrong order.</p>
                <p><strong>Time Complexity:</strong> O(n²)</p>
                <p><strong>Space Complexity:</strong> O(1)</p>
            `;
            break;
        case 'quickSort':
            content = `
                <h3>Quick Sort</h3>
                <p>Quick Sort selects a pivot and partitions the array around it, placing smaller elements before and larger elements after.</p>
                <p><strong>Time Complexity:</strong> O(n log n) average, O(n²) worst case</p>
                <p><strong>Space Complexity:</strong> O(log n)</p>
            `;
            break;
        case 'linearsearch':
            content = `
                <h3>Linear Search</h3>
                <p>Linear Search sequentially checks each element in the list until a match is found or the list is fully traversed.</p>
                <p><strong>Time Complexity:</strong> O(n)</p>
                <p><strong>Space Complexity:</strong> O(1)</p>
            `;
            break;
        case 'catSight':
            content = `
                <h3>Cat Sight Algorithm</h3>
                <p>The Cat Sight Algorithm maps numbers to angles on a 360° circular plane, inspired by feline vision. It provides efficient querying and visualization for applications in robotics, AI vision, and data analysis.</p>
                <p><strong>Key Features:</strong></p>
                <ul>
                    <li>Circular mapping for spatial data representation</li>
                    <li>Bio-inspired design for enhanced tracking capabilities</li>
                    <li>Scalable for large datasets using optimized data structures</li>
                    <li>Applications in real-time targeting and visualization systems</li>
                </ul>
                <p><strong>Time Complexity:</strong> O(n) for initialization, O(n) for queries (optimizable to O(log n))</p>
                <p><strong>Space Complexity:</strong> O(n)</p>
            `;
            break;
        default:
            content = `<p>Select an algorithm to view details.</p>`;
    }

    contentDiv.innerHTML = content;
}
</script>
<body>
    <header>
        <nav>
            <h1>Algorithm Innovation Hub</h1>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#research">Research</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Algorithms</a>
                    <div class="dropdown-content">
                                              

                         <a href="#"onclick='window.location.href="https://cybertron7.in/algorithms/Security.awc"'>Security</a>
                        <a href="#" onclick='showAlgorithm("mergeSort")'>Merge Sort</a>
                        <a href="#" onclick='showAlgorithm("bubbleSort")'>Bubble Sort</a>
                        <a href="#"onclick='window.location.href="https://cybertron7.in/algorithms/quicksort.awc"'>Quick Sort</a>
                        <a href="#" onclick='showAlgorithm("linearsearch")'>Linear Search</a>
                        <a href="#" onclick='window.location.href="https://cybertron7.in/algorithms/pagerank.awc"'>Page Ranking Algorithm</a>
                        <a href="#"onclick='window.location.href="https://cybertron7.in/algorithms/a_star.awc"'>A_Star Algorithm</a>
                        
                    </div>
                </li>
                <li><a href="#playground">Playground</a></li>
            </ul>
        </nav>
    </header>

    <section id="home" class="hero">
        <h2>Advancing Algorithmic Research</h2>
        <p>Explore cutting-edge algorithms and collaborate on innovative solutions for real-world challenges.</p>
        <button onclick='scrollToSection("research")'>Discover Our Research</button>
    </section>

    <section id="algorithmDetails">
        <h2>Algorithm Details</h2>
        <div id="algorithmContent"></div>
    </section>

    <section id="research">
        <h2>Latest Research & Developments</h2>
        <div class="research-grid">
            <div class="research-item">
                <h3>Cat Sight Algorithm</h3>
                <p>A novel algorithm that maps numbers to angles on a circular plane, inspired by feline vision, with applications in robotics, AI vision, and data visualization.</p>
                <a href="#">Read More</a>
            </div>
            <div class="research-item">
                <h3>Neural Network Optimization</h3>
                <p>Enhancing deep learning model performance through advanced optimization techniques.</p>
                <a href="#">Read More</a>
            </div>
            <div class="research-item">
                <h3>Sorting Algorithms</h3>
                <p>Innovative approaches to improve the efficiency of sorting large datasets.</p>
                <a href="#">Read More</a>
            </div>
        </div>
    </section>

    <section id="playground">
        <h2>Algorithm Playground</h2>
        <p>Test and experiment with our algorithms in an interactive environment.</p>
        <button onclick='alert("Algorithm simulation coming soon!")'>Launch Playground</button>
    </section>

    <section id="collaborate">
        <h2>Collaborate With Us</h2>
        <p>Join our community to contribute to groundbreaking algorithmic research.</p>
        <form>
            <input id="name" placeholder="Your Name" required>
            <input id="email" placeholder="Your Email" type="email" required>
            <textarea id="message" placeholder="How would you like to collaborate?" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </section>

    <footer>
        <p>© 2025 Algorithm Innovation Hub | Cybertron7</p>
    </footer>

    <script src="algorithmscript.js" defer></script>
</body>
</html>