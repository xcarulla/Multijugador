<?php
// Initialize SQLite database
$db = new PDO('sqlite:game.db');

// Create a table to store player and game state if it doesn't exist
$db->exec('CREATE TABLE IF NOT EXISTS game_state (id INTEGER PRIMARY KEY, player INT, score1 INT, score2 INT, game_over INT)');

// Handle GET requests here
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'get_circles') {
        // Generate random circles and send them to the clients
        $circles = generateRandomCircles();
        echo json_encode($circles);
    } elseif ($_GET['action'] === 'update_score') {
        $circleId = $_GET['circle_id'];
        $player = $_GET['player'];

        // Update the score in the database based on the player and circle ID
        updateScore($player, $circleId);

        // Return the updated scores
        $scores = getScores();
        echo json_encode($scores);
    } elseif ($_GET['action'] === 'get_game_state') {
        // Check if the game is over
        $gameOver = isGameOver();
        echo json_encode(['gameOver' => $gameOver]);
    }
}

function generateRandomCircles() {
    $circles = [];
    for ($i = 0; $i < 1; $i++) {
        $circle = [
            'id' => uniqid(),
            'x' => rand(50, 750),
            'y' => rand(50, 350),
            'color' => getRandomColor()
        ];
        $circles[] = $circle;
    }
    return $circles;
}

function getRandomColor() {
    $colors = ['#FF5733', '#33FF57', '#5733FF', '#FF33A1', '#A133FF'];
    return $colors[array_rand($colors)];
}

function updateScore($player, $circleId) {
    global $db;
    $stmt = $db->prepare('UPDATE game_state SET score' . $player . ' = score' . $player . ' + 1 WHERE id = :circle_id');
    $stmt->bindParam(':circle_id', $circleId, PDO::PARAM_STR);
    $stmt->execute();
}

function getScores() {
    global $db;
    $stmt = $db->query('SELECT score1, score2 FROM game_state LIMIT 1');
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function isGameOver() {
    global $db;
    $stmt = $db->query('SELECT score1, score2 FROM game_state LIMIT 1');
    $scores = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($scores['score1'] >= 10 || $scores['score2'] >= 10);
}

?>
