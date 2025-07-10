<?php
// CurrentAffairs.php - Single-page news aggregator for UPSC Current Affairs
// Author: Grok 3 (xAI)
// Last Updated: May 16, 2025, 11:06 PM IST
// Description: Fetches news from NewsData.io, displays in a Times of India-inspired interface with sharing, analytics, and archive features, optimized to avoid image loading errors
// Version: 3.1
// License: MIT

// =============================================================================
// Configuration Section
// =============================================================================
// Constants for API key, file paths, and settings
const API_KEY = 'pub_87516dfd5df363c3f992fa8375024cb0ef81f'; // NewsData.io API key
const DATA_FILE = 'data.json'; // Stores news data
const LOG_FILE = 'log.txt'; // Logs errors and events
const ANALYTICS_FILE = 'analytics.json'; // Stores article view counts
const MAX_HEADLINES = 100; // Maximum headlines per day
const CACHE_DIR = 'cache/images/'; // Directory for cached images
const DEFAULT_IMAGE = 'images/fallback.jpg'; // Local fallback image

// Create cache directory if it doesn't exist
if (!is_dir(CACHE_DIR)) {
    mkdir(CACHE_DIR, 0755, true);
}

// Ensure images directory exists
if (!is_dir('images')) {
    mkdir('images', 0755, true);
}

// =============================================================================
// Utility Functions
// =============================================================================

// Logs messages to a file for debugging and monitoring
// Parameters:
// - $message: The message to log
// Returns: None
function logMessage($message) {
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents(LOG_FILE, "[$timestamp] $message\n", FILE_APPEND);
}

// Cleans strings by removing invalid characters
// Parameters:
// - $string: Input string to clean
// Returns: Cleaned string
function cleanString($string) {
    return trim(preg_replace('/[\x00-\x1F\x7F]/u', '', $string));
}

// Caches images locally to reduce external requests
// Parameters:
// - $imageUrl: URL of the image
// Returns: Local path or default image
function cacheImage($imageUrl) {
    try {
        // Validate URL
        if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            logMessage("Invalid image URL: $imageUrl");
            return DEFAULT_IMAGE;
        }

        // Check if image is already cached
        $filename = CACHE_DIR . md5($imageUrl) . '.jpg';
        if (file_exists($filename) && filesize($filename) > 0) {
            return $filename;
        }

        // Fetch image with cURL
        $ch = curl_init($imageUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Reduced timeout to prevent delays
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $imageData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Handle fetch errors
        if ($imageData === false || $httpCode != 200) {
            logMessage("Failed to fetch image: $imageUrl, HTTP $httpCode, $curlError");
            return DEFAULT_IMAGE;
        }

        // Save image to cache
        file_put_contents($filename, $imageData);
        return $filename;
    } catch (Exception $e) {
        logMessage("Image cache error: " . $e->getMessage());
        return DEFAULT_IMAGE;
    }
}

// Fetches news from NewsData.io API
// Parameters:
// - $country: Country code(s) (e.g., 'in' for India)
// - $limit: Maximum articles to fetch
// Returns: Array of news articles
function fetchNews($country = 'in', $limit = 95) {
    try {
        // Build API URL
        $url = "https://newsdata.io/api/1/news?apikey=" . API_KEY . "&country=$country&language=en";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Check for cURL errors
        if ($response === false || $httpCode != 200) {
            logMessage("Error fetching news for $country: HTTP $httpCode, $curlError");
            return [];
        }

        // Decode JSON response
        $data = json_decode($response, true);
        if (!$data || !isset($data['results']) || empty($data['results'])) {
            logMessage("Invalid/empty response for $country");
            return [];
        }

        // Process articles into structured array
        $headlines = [];
        foreach ($data['results'] as $article) {
            if (count($headlines) >= $limit) break;
            if (empty($article['title']) || empty($article['link'])) continue;

            $headlines[] = [
                'title' => cleanString($article['title']),
                'description' => cleanString($article['description'] ?? 'No description available'),
                'url' => $article['link'],
                'source' => $article['source_id'] ?? 'NewsData.io',
                'category' => $article['category'][0] ?? 'General',
                'country' => strtoupper($country),
                'image' => cacheImage($article['image_url'] ?? '')
            ];
        }

        return $headlines;
    } catch (Exception $e) {
        logMessage("News fetch error for $country: " . $e->getMessage());
        return [];
    }
}

// Reads news data from JSON file
// Returns: Array of news data
function readJsonData() {
    try {
        if (!file_exists(DATA_FILE)) {
            return [];
        }
        $content = file_get_contents(DATA_FILE);
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    } catch (Exception $e) {
        logMessage("Error reading JSON: " . $e->getMessage());
        return [];
    }
}

// Writes news data to JSON file
// Parameters:
// - $data: Data to write
// Returns: None
function writeJsonData($data) {
    try {
        file_put_contents(DATA_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    } catch (Exception $e) {
        logMessage("Error writing JSON: " . $e->getMessage());
    }
}

// Reads analytics data from JSON file
// Returns: Array of analytics data
function readAnalyticsData() {
    try {
        if (!file_exists(ANALYTICS_FILE)) {
            return [];
        }
        $content = file_get_contents(ANALYTICS_FILE);
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    } catch (Exception $e) {
        logMessage("Error reading analytics: " . $e->getMessage());
        return [];
    }
}

// Writes analytics data to JSON file
// Parameters:
// - $data: Analytics data to write
// Returns: None
function writeAnalyticsData($data) {
    try {
        file_put_contents(ANALYTICS_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    } catch (Exception $e) {
        logMessage("Error writing analytics: " . $e->getMessage());
    }
}

// Tracks article views by incrementing count
// Parameters:
// - $title: Article title
// Returns: None
function trackView($title) {
    $analytics = readAnalyticsData();
    $titleHash = md5($title);
    if (!isset($analytics[$titleHash])) {
        $analytics[$titleHash] = ['title' => $title, 'views' => 0];
    }
    $analytics[$titleHash]['views']++;
    writeAnalyticsData($analytics);
}

// =============================================================================
// Main Logic
// =============================================================================
try {
    // Fetch news for India and global regions
    $indiaNews = fetchNews('in', 55);
    $worldNews = fetchNews('us,gb,au', 35);
    $allNews = array_merge($indiaNews, $worldNews);

    // Store news if available
    if (empty($allNews)) {
        logMessage("No news fetched.");
    } else {
        $jsonData = readJsonData();
        $today = date('Y-m-d');
        $dayOfWeek = date('l');

        // Initialize today's data
        if (!isset($jsonData[$today])) {
            $jsonData[$today] = [
                'day' => $dayOfWeek,
                'headlines' => []
            ];
        }

        // Add new headlines, avoiding duplicates
        $existingTitles = array_column($jsonData[$today]['headlines'], 'title');
        $newHeadlines = 0;

        foreach ($allNews as $headline) {
            if (!in_array($headline['title'], $existingTitles)) {
                $jsonData[$today]['headlines'][] = $headline;
                $existingTitles[] = $headline['title'];
                $newHeadlines++;
            }
        }

        // Sort alphabetically and limit headlines
        usort($jsonData[$today]['headlines'], fn($a, $b) => strcmp($a['title'], $b['title']));
        $jsonData[$today]['headlines'] = array_slice($jsonData[$today]['headlines'], 0, MAX_HEADLINES);
        writeJsonData($jsonData);
        logMessage("Stored $newHeadlines new headlines for $today.");
    }
} catch (Exception $e) {
    logMessage("Main logic error: " . $e->getMessage());
}

// Load news data and extract categories
$newsData = readJsonData();
$categories = array_unique(array_merge(
    ...array_map(fn($date) => array_column($newsData[$date]['headlines'], 'category'), array_keys($newsData))
));
$analytics = readAnalyticsData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for SEO and responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daily Current Affairs for UPSC preparation, updated with latest news and insights.">
    <title>Daily Current Affairs for UPSC</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Tailwind configuration with TOI-inspired colors
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#003087', // TOI blue
                        secondary: '#6b7280', // Gray for meta text
                        politics: '#dc2626', // Red for politics
                        economy: '#15803d', // Green for economy
                        sports: '#d97706', // Orange for sports
                        technology: '#2563eb', // Blue for technology
                        general: '#6b7280', // Gray for general
                        accent: '#f97316' // TOI orange
                    },
                    fontFamily: {
                        headline: ['Georgia', 'serif'], // TOI-style headlines
                        body: ['Arial', 'sans-serif'] // Clean body text
                    }
                }
            }
        }
    </script>
    <style>
       
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #111827;
            margin: 0;
            background-color: #ffffff;
        }
        .dark body {
            color: #f3f4f6;
            background-color: #111827;
        }

       
        header {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }
        .dark header {
            background-color: #1f2937;
            border-bottom-color: #374151;
        }

      
        .breadcrumbs {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 1rem 0;
        }
        .breadcrumbs a {
            color: #003087;
            text-decoration: none;
        }
        .breadcrumbs a:hover {
            text-decoration: underline;
        }
        .dark .breadcrumbs {
            color: #9ca3af;
        }
        .dark .breadcrumbs a {
            color: #60a5fa;
        }

     
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 1rem 0;
        }
        .news-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height:400px;
            overflow:auto;
        }
        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .dark .news-card {
            background-color: #1f2937;
            border-color: #374151;
        }

      
        .news-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }
        img.lazy {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        img.lazy.loaded {
            opacity: 1;
        }

       
        .category-tag {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            color: #ffffff;
            text-transform: uppercase;
        }

       
        .headline {
            font-family: Georgia, serif;
            font-size: 1.25rem;
            font-weight: bold;
            color: #111827;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }
        .dark .headline {
            color: #f3f4f6;
        }

       =
        .meta {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
            overflow:scroll;
        }
        .dark .meta {
            color: #9ca3af;
        }

       
        .share-button {
            font-size: 0.875rem;
            color: #003087;
            text-decoration: none;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }
        .share-button:hover {
            background-color: #e5e7eb;
        }
        .dark .share-button {
            color: #60a5fa;
        }
        .dark .share-button:hover {
            background-color: #374151;
        }

        /* Loading spinner */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #003087;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Error message */
        .error {
            display: none;
            padding: 1rem;
            background-color: #fee2e2;
            color: #dc2626;
            border-radius: 8px;
            text-align: center;
            margin: 1rem 0;
        }
        .dark .error {
            background-color: #7f1d1d;
            color: #f87171;
        }

        /* Calendar widget for news archive */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            max-width: 300px;
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .dark .calendar {
            background-color: #1f2937;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .calendar-day {
            padding: 8px;
            text-align: center;
            cursor: pointer;
            border-radius: 4px;
            font-size: 0.875rem;
        }
        .calendar-day:hover {
            background-color: #e5e7eb;
        }
        .calendar-day.available {
            background-color: #bfdbfe;
            color: #003087;
            font-weight: 500;
        }
        .dark .calendar-day:hover {
            background-color: #374151;
        }
        .dark .calendar-day.available {
            background-color: #1e40af;
            color: #ffffff;
        }

        /* Collapsible section headers */
        .section-header {
            cursor: pointer;
            padding: 1rem;
            background-color: #f9fafb;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: background-color 0.2s ease;
        }
        .dark .section-header {
            background-color: #1f2937;
        }
        .section-header:hover {
            background-color: #e5e7eb;
        }
        .dark .section-header:hover {
            background-color: #374151;
        }

        /* Back-to-top button */
        #backToTop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            background-color: #003087;
            color: #ffffff;
            padding: 12px;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 100;
            transition: opacity 0.3s ease;
        }
        #backToTop:hover {
            opacity: 0.9;
        }

        /* Footer styling */
        footer {
            background-color: #f9fafb;
            padding: 2rem;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            margin-top: 2rem;
            color: #6b7280;
        }
        .dark footer {
            background-color: #111827;
            border-top-color: #374151;
            color: #9ca3af;
        }
        footer a {
            color: #003087;
            text-decoration: none;
            margin: 0 1rem;
            font-size: 0.875rem;
        }
        footer a:hover {
            text-decoration: underline;
        }
        .dark footer a {
            color: #60a5fa;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .news-grid {
                grid-template-columns: 1fr;
            }
            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .search-filter {
                flex-direction: column;
                gap: 1rem;
            }
            .news-card img {
                height: 160px;
            }
        }

        /* Search input focus */
        #searchInput:focus {
            outline: none;
            ring: 2px solid #003087;
            border-color: #003087;
        }

        /* Highlighted search terms */
        .highlight {
            background-color: #fef08a;
            padding: 0 2px;
        }
        .dark .highlight {
            background-color: #854d0e;
            color: #fef08a;
        }
    </style>
</head>
<body>
    <!-- Main container for content -->
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header with sticky navigation -->
        <header class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-headline font-bold text-primary">UPSC Current Affairs</h1>
            </div>
            <div class="flex items-center gap-4">
                <button id="themeToggle" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600" title="Toggle Dark Mode">
                    <svg class="w-5 h-5 text-gray-800 dark:text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" />
                    </svg>
                </button>
                <div class="flex gap-2">
                    <button id="fontSmall" class="p-2 text-sm bg-gray-100 rounded-full dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600" title="Smaller Font">A-</button>
                    <button id="fontLarge" class="p-2 text-lg bg-gray-100 rounded-full dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600" title="Larger Font">A+</button>
                </div>
            </div>
        </header>

        <!-- Breadcrumbs for navigation -->
        <nav class="breadcrumbs">
            <a href="/">Home</a> > <span>Current Affairs</span>
        </nav>

        <!-- Search and filter controls -->
        <div class="search-filter flex flex-col sm:flex-row gap-4 mb-8">
            <input type="text" id="searchInput" placeholder="Search news..." 
                   class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white flex-1">
            <select id="categoryFilter" class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo htmlspecialchars($category); ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Archive calendar widget -->
        <div class="mb-8">
            <h2 class="text-xl font-headline font-semibold text-gray-900 dark:text-white mb-4">News Archive</h2>
            <div id="calendar" class="calendar"></div>
        </div>

        <!-- Loading spinner -->
        <div id="loading" class="loading">
            <div class="spinner"></div>
        </div>

        <!-- Error message container -->
        <div id="error" class="error">
            Failed to load news. Please try again later.
        </div>

        <!-- News content area -->
        <div id="newsContent" style="display: none;">
            <?php if (empty($newsData)) { ?>
                <p class="text-center text-gray-600 dark:text-gray-300 py-8">No news available. Please check back later.</p>
            <?php } else { ?>
                <?php krsort($newsData); // Sort dates in descending order ?>
                <?php foreach ($newsData as $date => $data) { ?>
                    <section class="mb-12">
                        <div class="section-header flex justify-between items-center">
                            <h2 class="text-2xl font-headline font-semibold text-gray-900 dark:text-white">
                                <?php echo htmlspecialchars($date . ' (' . $data['day'] . ')'); ?>
                            </h2>
                            <button class="toggle-section text-primary hover:text-accent" data-date="<?php echo $date; ?>">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        <div class="news-grid" id="section-<?php echo $date; ?>">
                            <?php foreach ($data['headlines'] as $headline) { ?>
                                <?php trackView($headline['title']); // Track article view ?>
                                <article class="news-card" data-category="<?php echo htmlspecialchars($headline['category']); ?>">
                                    <img src="<?php echo htmlspecialchars($headline['image'] ?: DEFAULT_IMAGE); ?>" 
                                         alt="<?php echo htmlspecialchars($headline['title']); ?>" 
                                         class="lazy"
                                         loading="lazy"
                                         onerror="this.onerror=null; this.src='<?php echo DEFAULT_IMAGE; ?>';">
                                    <div class="p-4">
                                        <span class="category-tag bg-<?php echo strtolower($headline['category']); ?>">
                                            <?php echo htmlspecialchars($headline['category']); ?>
                                        </span>
                                        <h3 class="headline">
                                            <a href="<?php echo htmlspecialchars($headline['url']); ?>" 50
                                               target="_blank" class="hover:text-primary transition-colors duration-200">
                                                <?php echo htmlspecialchars($headline['title']); ?>
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                            <?php echo htmlspecialchars($headline['description']); ?>
                                        </p>
                                        <div class="meta mb-2">
                                            <span>Source: <?php echo htmlspecialchars($headline['source']); ?></span> | 
                                            <span>Country: <?php echo htmlspecialchars($headline['country']); ?></span> | 
                                            <span>Views: <?php echo isset($analytics[md5($headline['title'])]['views']) ? $analytics[md5($headline['title'])]['views'] : 0; ?></span>
                                        </div>
                                        <div class="flex gap-4">
                                            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($headline['title'] . ' ' . $headline['url']); ?>" 
                                               target="_blank" class="share-button">
                                                Twitter
                                            </a>
                                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($headline['title'] . ' ' . $headline['url']); ?>" 
                                               target="_blank" class="share-button">
                                                WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            <?php } ?>
                        </div>
                    </section>
                <?php } ?>
            <?php } ?>
        </div>

        <!-- Back-to-top button -->
        <button id="backToTop">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>

        <!-- Footer with links and copyright -->
        <footer>
           
            <p>© <?php echo date('Y'); ?> Awarcrown corporations. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // JavaScript for interactivity and dynamic behavior
        // Initialize DOM elements
        const themeToggle = document.getElementById('themeToggle');
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const newsCards = document.querySelectorAll('.news-card');
        const loading = document.getElementById('loading');
        const newsContent = document.getElementById('newsContent');
        const backToTop = document.getElementById('backToTop');
        const calendar = document.getElementById('calendar');
        const fontSmall = document.getElementById('fontSmall');
        const fontLarge = document.getElementById('fontLarge');

        // Theme toggle functionality
        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }

        // Font size controls
        function setFontSize(size) {
            document.body.style.fontSize = size + 'px';
            localStorage.setItem('fontSize', size);
        }

        fontSmall.addEventListener('click', () => setFontSize(14));
        fontLarge.addEventListener('click', () => setFontSize(18));

        // Load saved font size
        const savedFontSize = localStorage.getItem('fontSize');
        if (savedFontSize) {
            document.body.style.fontSize = savedFontSize + 'px';
        }

        // Search and filter news articles
        function filterNews() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedCategory = categoryFilter.value;

            newsCards.forEach(card => {
                const title = card.querySelector('.headline').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                const category = card.dataset.category;
                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesCategory = !selectedCategory || category === selectedCategory;

                card.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
            });

            // Highlight search terms
            highlightSearchTerms(searchTerm);
        }

        // Highlight search terms in visible cards
        function highlightSearchTerms(term) {
            newsCards.forEach(card => {
                if (card.style.display !== 'none') {
                    const title = card.querySelector('.headline');
                    const description = card.querySelector('p');
                    if (term) {
                        title.innerHTML = title.textContent.replace(new RegExp(term, 'gi'), match => `<span class="highlight">${match}</span>`);
                        description.innerHTML = description.textContent.replace(new RegExp(term, 'gi'), match => `<span class="highlight">${match}</span>`);
                    } else {
                        title.innerHTML = title.textContent;
                        description.innerHTML = description.textContent;
                    }
                }
            });
        }

        // Attach search and filter event listeners
        searchInput.addEventListener('input', filterNews);
        categoryFilter.addEventListener('change', filterNews);

        // Optimized lazy loading for images
        const lazyImages = document.querySelectorAll('img.lazy');
        let loadedImages = 0;

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.add('loaded');
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                    loadedImages++;
                    // Show content when most images are loaded or after timeout
                    if (loadedImages >= lazyImages.length * 0.8) {
                        loading.style.display = 'none';
                        newsContent.style.display = 'block';
                    }
                }
            });
        }, {
            rootMargin: '0px 0px 100px 0px', // Load images slightly before they appear
            threshold: 0.1
        });

        lazyImages.forEach(img => observer.observe(img));

        // Handle broken images immediately
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('error', () => {
                img.src = '<?php echo DEFAULT_IMAGE; ?>';
                img.classList.add('loaded');
                loadedImages++;
                if (loadedImages >= lazyImages.length * 0.8) {
                    loading.style.display = 'none';
                    newsContent.style.display = 'block';
                }
            });
        });

        // Show content after a short timeout to prevent overloading
        window.addEventListener('load', () => {
            setTimeout(() => {
                if (loading.style.display !== 'none') {
                    loading.style.display = 'none';
                    newsContent.style.display = 'block';
                }
            }, 3000); // Reduced to 3 seconds
        });

        // Back-to-top button visibility
        window.addEventListener('scroll', () => {
            backToTop.style.display = window.scrollY > 300 ? 'block' : 'none';
        });

        // Smooth scroll to top
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Toggle collapsible sections
        document.querySelectorAll('.toggle-section').forEach(button => {
            button.addEventListener('click', () => {
                const date = button.dataset.date;
                const section = document.getElementById(`section-${date}`);
                section.classList.toggle('hidden');
                button.querySelector('svg').classList.toggle('rotate-180');
            });
        });

        // Generate calendar for news archive
        function generateCalendar() {
            const dates = <?php echo json_encode(array_keys($newsData)); ?>;
            const today = new Date();
            const year = today.getFullYear();
            const month = today.getMonth();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDay = new Date(year, month, 1).getDay();

            let html = '<div class="text-center mb-2 font-semibold text-gray-900 dark:text-white">' + 
                       today.toLocaleString('default', { month: 'long', year: 'numeric' }) + '</div>';
            html += '<div class="grid grid-cols-7 text-center text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">';
            ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].forEach(day => {
                html += `<div>${day}</div>`;
            });
            html += '</div>';

            // Add empty days before the first day
            for (let i = 0; i < firstDay; i++) {
                html += '<div class="calendar-day"></div>';
            }

            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const isAvailable = dates.includes(dateStr);
                html += `<div class="calendar-day ${isAvailable ? 'available' : ''}" data-date="${dateStr}">${day}</div>`;
            }

            calendar.innerHTML = html;

            // Add click handlers for available dates
            document.querySelectorAll('.calendar-day.available').forEach(day => {
                day.addEventListener('click', () => {
                    const date = day.dataset.date;
                    document.querySelectorAll('section').forEach(section => {
                        section.style.display = section.querySelector('h2').textContent.includes(date) ? 'block' : 'none';
                    });
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
        }

        // Initialize calendar on page load
        generateCalendar();
    </script>
</body>
</html>