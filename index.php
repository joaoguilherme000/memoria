<?php
$score = 0;

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
$letras = ['a', 'b', 'c', 'd', 'e', 'f',];

// Embaralhar as letras
$letras_embaralhadas = shuffle_array($letras);

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
        SCORE = <?php echo $score; ?>
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
        foreach ($letras_embaralhadas as $letra) {
            echo "<div class='card'>$letra</div>";
        }
        ?>
    </div>
    <script>
        const cards = document.querySelectorAll('.card');
        let matchedCards = 0;
        let hasFlippedCard = false;
        let lockBoard = false;
        let firstCard, secondCard;

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

            // Incrementa o score em 1 ponto
            <?php $score += 1; ?>

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
            // Cria uma div para a tela de vitória
            const victoryScreen = document.createElement('div');
            victoryScreen.classList.add('victory-screen');
            victoryScreen.innerHTML = `
                <h2>Parabéns! Você ganhou!</h2>
                <button onclick="restartGame()">Jogar Novamente</button>
            `;

            // Adiciona a tela de vitória ao body
            document.body.appendChild(victoryScreen);
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