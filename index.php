<?php
// Função para embaralhar um array
function shuffle_array($array) {
    for ($i = count($array) - 1; $i > 0; $i--) {
        $j = mt_rand(0, $i);
        $temp = $array[$i];
        $array[$i] = $array[$j];
        $array[$j] = $temp;
    }
    return $array;
}

// Array de letras para embaralhar
$letras = ['a', 'b', 'c', 'd', 'e', 'f'];
$letras2 = ['a', 'b', 'c', 'd', 'e', 'f'];

// Embaralhar as letras
$letras_embaralhadas = shuffle_array($letras);
$letras_embaralhadas2 = shuffle_array($letras2);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/reset.css">
    <title>Jogo da memória</title>
</head>
<body>
    <div class="score">
        SCORE = <span id="score">0</span>
    </div>
    <div class="row">
        <?php
        // Exibir as cartas com as letras embaralhadas
        foreach ($letras_embaralhadas as $letra) {
            echo "<div class='card'>$letra</div>";
        }
        ?>
    </div>
    <div class="row">
        <?php
        // Exibir as cartas com as letras embaralhadas
        foreach ($letras_embaralhadas2 as $letra) {
            echo "<div class='card'>$letra</div>";
        }
        ?>
    </div>
    <div class="victory-screen" style="display: none;">
        <h2>Parabéns! Você ganhou!</h2>
        <button onclick="location.reload()">Jogar Novamente</button>
    </div>
    
    <script>
        const cards = document.querySelectorAll('.card');
        let matchedCards = 0;
        let hasFlippedCard = false;
        let lockBoard = false;
        let firstCard, secondCard;
        let score = 0;

        function flipCard() {
            if (lockBoard) return;
            if (this === firstCard) return;

            this.classList.add('flipped');

            if (!hasFlippedCard) {
                hasFlippedCard = true;
                firstCard = this;
                return;
            }

            secondCard = this;
            checkForMatch();
        }

        function checkForMatch() {
            let isMatch = firstCard.textContent === secondCard.textContent;
            isMatch ? disableCards() : unflipCards();
        }

        function disableCards() {
            firstCard.removeEventListener('click', flipCard);
            secondCard.removeEventListener('click', flipCard);
            firstCard.classList.add('matched');
            secondCard.classList.add('matched');
            firstCard.classList.remove('flipped');
            secondCard.classList.remove('flipped');

            matchedCards += 1;
            
            score += 1;
            document.getElementById('score').textContent = score;

            resetBoard();
        }

        function unflipCards() {
            lockBoard = true;

            setTimeout(() => {
                firstCard.classList.remove('flipped');
                secondCard.classList.remove('flipped');

                resetBoard();
            }, 1000);
        }

        function showVictoryScreen() {
            console.log("ganhou");
            const rows = document.querySelectorAll('.row');
            rows.forEach(row => {
                row.style.display = 'none';
            });
            const victoryScreen = document.querySelector('.victory-screen');

            victoryScreen.style.display = 'block';
        }

        function resetBoard() {
            [hasFlippedCard, lockBoard] = [false, false];
            [firstCard, secondCard] = [null, null];

            // Verifica se todas as cartas foram correspondidas
            if (matchedCards === <?php echo count($letras_embaralhadas); ?>) {
                showVictoryScreen();
            }
        }

        cards.forEach(card => card.addEventListener('click', flipCard));
    </script>
</body>
</html>
