
<?php
// Log request details for debugging
$logFile = 'debug.log';
$requestUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$logMessage = date('Y-m-d H:i:s') . " - Method: {$_SERVER['REQUEST_METHOD']}, URL: $requestUrl, Headers: " . json_encode(getallheaders()) . ", POST: " . json_encode($_POST) . ", Referer: " . ($_SERVER['HTTP_REFERER'] ?? 'none') . "\n";
file_put_contents($logFile, $logMessage, FILE_APPEND);

// Handle CORS preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    header('HTTP/1.1 204 No Content');
    exit;
}

// Set headers for JSON response and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Check for redirects (e.g., trailing slash)
if (isset($_SERVER['REDIRECT_STATUS']) || $_SERVER['REQUEST_URI'] !== '/RajnitiKutir/upload.php') {
    $logMessage = date('Y-m-d H:i:s') . " - Possible redirect detected. REDIRECT_STATUS: " . ($_SERVER['REDIRECT_STATUS'] ?? 'none') . ", Requested URI: {$_SERVER['REQUEST_URI']}\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if videoLink is provided
    if (empty($_POST['videoLink'])) {
        echo json_encode(['success' => false, 'message' => 'Video link is required']);
        exit;
    }

    $videoLink = trim($_POST['videoLink']);

    // Extract YouTube video ID
    $videoId = '';
    $regex = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
    if (preg_match($regex, $videoLink, $match)) {
        $videoId = $match[1];
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid YouTube link']);
        exit;
    }

    // Fetch video title from YouTube API
    $apiKey = 'AIzaSyDnggax2xl_zfkxlqUbywdfGs38wVROCJo'; // Replace with your Google API key
    $apiUrl = "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=$videoId&key=$apiKey";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpCode !== 200 || $curlError) {
        $errorMsg = 'Error fetching video title: ' . ($curlError ?: 'API error (HTTP ' . $httpCode . ')');
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - $errorMsg\n", FILE_APPEND);
        echo json_encode(['success' => false, 'message' => $errorMsg]);
        exit;
    }

    $data = json_decode($response, true);
    if (empty($data['items'])) {
        echo json_encode(['success' => false, 'message' => 'Video not found']);
        exit;
    }

    $videoTitle = $data['items'][0]['snippet']['title'];

    // Load existing videos
    $jsonFile = 'videos.json';
    $videos = [];
    if (file_exists($jsonFile)) {
        $videos = json_decode(file_get_contents($jsonFile), true);
        if ($videos === null) {
            echo json_encode(['success' => false, 'message' => 'Error reading JSON file']);
            exit;
        }
    }

    // Add new video
    $newVideo = [
        'id' => uniqid(),
        'title' => $videoTitle,
        'link' => $videoLink,
        'added_at' => date('Y-m-d H:i:s')
    ];
    $videos[] = $newVideo;

    // Save to JSON file
    if (file_put_contents($jsonFile, json_encode($videos, JSON_PRETTY_PRINT)) === false) {
        echo json_encode(['success' => false, 'message' => 'Error saving data to JSON file']);
        exit;
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method: ' . $_SERVER['REQUEST_METHOD']]);
}
?>