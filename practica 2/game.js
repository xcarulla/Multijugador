document.addEventListener('DOMContentLoaded', () => {
    const playerLabel = document.getElementById('player-label');
    const startButton = document.getElementById('start-button');
    const gameContainer = document.getElementById('game-container');
    let currentPlayer = null;
    let gameStarted = false;

    // Determine the player number based on the URL query parameter
    const params = new URLSearchParams(window.location.search);
    if (params.get('player') === '1') {
        currentPlayer = 1;
        playerLabel.textContent = 'Player 1';
        startButton.textContent = 'Waiting for Player 2';
    } else if (params.get('player') === '2') {
        currentPlayer = 2;
        playerLabel.textContent = 'Player 2';
        startButton.textContent = 'Start Game';
        startButton.disabled = false;
    }

    startButton.addEventListener('click', () => {
        if (!gameStarted) {
            gameStarted = true;
            startButton.disabled = true;
            startButton.textContent = 'Game in progress';
            initiateGame();
        }
    });

    gameContainer.addEventListener('click', (e) => {
        if (gameStarted && e.target.classList.contains('circle')) {
            const circle = e.target;
            const circleId = circle.getAttribute('data-circle-id');
            e.target.classList.remove('circle');
            e.target.style.visibility = 'hidden';
            // Send the circle ID to the server to update the score
            updateScore(circleId);
        }
    });

    function initiateGame() {
        // Request circles from the server immediately
        requestCircles();

        // Poll the server for game state updates every second
        setInterval(() => {
            if (gameStarted) {
                requestGameState();
            }
        }, 1000);
    }

    function updateScore(circleId) {
        // Send an AJAX request to the server to update the score
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `game.php?action=update_score&circle_id=${circleId}&player=${currentPlayer}`, true);
        xhr.send();

        xhr.onload = () => {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(`Player 1: ${response.score1}, Player 2: ${response.score2}`);
            }
        };
    }

    function requestCircles() {
        // Send an AJAX request to the server to get circles
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'game.php?action=get_circles', true);
        xhr.send();

        xhr.onload = () => {
            if (xhr.status === 200) {
                const circles = JSON.parse(xhr.responseText);
                renderCircles(circles);
            }
        };
    }

    function requestGameState() {
        // Poll the server for game state updates
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'game.php?action=get_game_state', true);
        xhr.send();

        xhr.onload = () => {
            if (xhr.status === 200) {
                const gameState = JSON.parse(xhr.responseText);
                // Check if the game is over
                if (gameState.gameOver) {
                    gameStarted = false;
                    startButton.disabled = true;
                    startButton.textContent = 'Game Over';
                }
            }
        };
    }

    function renderCircles(circles) {
        gameContainer.innerHTML = ''; // Clear existing circles
        circles.forEach((circle) => {
            const circleElement = document.createElement('div');
            circleElement.classList.add('circle');
            circleElement.style.left = `${circle.x}px`;
            circleElement.style.top = `${circle.y}px`;
            circleElement.setAttribute('data-circle-id', circle.id);
            circleElement.style.backgroundColor = circle.color;
            circleElement.style.visibility = 'visible';
            gameContainer.appendChild(circleElement);
        });
    }
});
