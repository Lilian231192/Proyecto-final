<?php
include('conexion.php');

// OMDB API key
$omdb_api_key = '4e7cc3a3';

// Function to get movie recommendations from OMDB
function getMovieRecommendations($genres) {
    global $omdb_api_key;
    $recommendations = [];

    foreach ($genres as $genre) {
        $url = "http://www.omdbapi.com/?apikey={$omdb_api_key}&s={$genre}&type=movie";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (isset($data['Search'])) {
            $recommendations = array_merge($recommendations, array_slice($data['Search'], 0, 3));
        }
    }

    return array_slice($recommendations, 0, 10);
}

// Function to get anime recommendations from Jikan API
function getAnimeRecommendations($genres) {
    $recommendations = [];

    foreach ($genres as $genre) {
        $url = "https://api.jikan.moe/v4/anime?genres={$genre}&order_by=score&sort=desc&limit=3";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (isset($data['data'])) {
            $recommendations = array_merge($recommendations, $data['data']);
        }
    }

    return array_slice($recommendations, 0, 10);
}

// Function to get user preferences
function getUserPreferences($user_id) {
    global $conn;
    $sql = "SELECT * FROM gusto WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $preferences = $result->fetch_assoc();
    
    $genres = [];
    foreach ($preferences as $key => $value) {
        if ($value > 0 && $key != 'id_user') {
            $genres[] = $key;
        }
    }
    
    return $genres;
}

// Function to get recommendations
function getRecommendations($user_id) {
    $genres = getUserPreferences($user_id);
    $movie_recommendations = getMovieRecommendations($genres);
    $anime_recommendations = getAnimeRecommendations($genres);

    return [
        'movies' => $movie_recommendations,
        'anime' => $anime_recommendations
    ];
}

// API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'get_recommendations' && isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        $recommendations = getRecommendations($user_id);
        echo json_encode($recommendations);
        exit;
    }
}
?>

