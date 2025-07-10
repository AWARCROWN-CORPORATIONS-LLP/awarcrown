<?php
// Configuration
const API_KEY = 'pub_87516dfd5df363c3f992fa8375024cb0ef81f'; // Replace with your NewsData.io API key
const DATA_FILE = 'data.json';
const LOG_FILE = 'log.txt';
const MAX_HEADLINES = 50; // Total headlines to fetch (25 India + 25 World)

// Function to log messages
function logMessage($message) {
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents(LOG_FILE, "[$timestamp] $message\n", FILE_APPEND);
}

// Function to clean string (remove invalid characters)
function cleanString($string) {
    return trim(preg_replace('/[\x00-\x1F\x7F]/u', '', $string));
}

// Function to fetch news from NewsData.io
function fetchNews($country = 'in', $limit = 25) {
    $url = "https://newsdata.io/api/1/news?apikey=" . API_KEY . "&country=$country&language=en";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $httpCode != 200) {
        logMessage("Error fetching news for country $country: HTTP $httpCode");
        return [];
    }

    $data = json_decode($response, true);
    if (!$data || !isset($data['results'])) {
        logMessage("Invalid response for country $country");
        return [];
    }

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
            'country' => strtoupper($country)
        ];
    }

    return $headlines;
}

// Function to read existing JSON data
function readJsonData() {
    if (!file_exists(DATA_FILE)) {
        return [];
    }
    $content = file_get_contents(DATA_FILE);
    return json_decode($content, true) ?: [];
}

// Function to write JSON data
function writeJsonData($data) {
    file_put_contents(DATA_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

// Main logic
try {
    // Fetch news (25 from India, 25 from worldwide)
    $indiaNews = fetchNews('in', 25);
    $worldNews = fetchNews('us,gb,au', 25); // Example: US, UK, Australia for world news
    $allNews = array_merge($indiaNews, $worldNews);

    if (empty($allNews)) {
        logMessage("No news fetched. Exiting.");
        exit;
    }

    // Read existing JSON data
    $jsonData = readJsonData();
    $today = date('Y-m-d');
    $dayOfWeek = date('l');

    // Initialize today's data if not exists
    if (!isset($jsonData[$today])) {
        $jsonData[$today] = [
            'day' => $dayOfWeek,
            'headlines' => []
        ];
    }

    // Check for duplicates and add new headlines
    $existingTitles = array_column($jsonData[$today]['headlines'], 'title');
    $newHeadlines = 0;

    foreach ($allNews as $headline) {
        if (!in_array($headline['title'], $existingTitles)) {
            $jsonData[$today]['headlines'][] = $headline;
            $existingTitles[] = $headline['title'];
            $newHeadlines++;
        }
    }

    // Sort headlines by title (optional)
    usort($jsonData[$today]['headlines'], function($a, $b) {
        return strcmp($a['title'], $b['title']);
    });

    // Trim to max 50 headlines per day
    $jsonData[$today]['headlines'] = array_slice($jsonData[$today]['headlines'], 0, MAX_HEADLINES);

    // Write updated JSON data
    writeJsonData($jsonData);
    logMessage("Successfully fetched and stored $newHeadlines new headlines for $today.");

} catch (Exception $e) {
    logMessage("Error: " . $e->getMessage());
}
?>