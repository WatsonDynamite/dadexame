/*jshint esversion: 6 */

class TicTacToeGame {

    constructor(ID, player1Name) {
        this.gameID = ID;
        this.gameEnded = false;
        this.gameStarted = false;
        this.player1= player1Name;
        this.player2= '';
        this.player3= '';
        this.player4= '';
        this.playerTurn = 1;
        this.winner = [];
        this.board = [0,0,0,0,0,0,0,0,0];
        this.deck = [];
        this.playerCards = [];
        this.playerCount = 1;
        this.playerPoints = [];
        this.playerFolds = [];
        this.queuedPlays = [];
        this.turnTimer = 20;
    }

    join(playerName){
        //this.setup();
        if(this.playerCount == 1){
            this.player2 = playerName;
            this.playerCount = 2;
        }else if(this.playerCount == 2){
            this.player3 = playerName;
            this.playerCount = 3;
        }else if(this.playerCount == 3){
            this.player4 = playerName;
            this.playerCount = 4;
        }
    }

    startGame(){
        if(this.playerCount > 1){
            if(this.gameStarted == false){
                this.gameStarted = true;
                this.setup(this.playerCount);
            }
        }
    }

    drawCard(playerCount){
        //client is the one checking if a card can be drawn
        this.playerCards[playerCount - 1].push(this.deck.pop());
    }

    endGame(){
        var totalPoints = [];
        var handValues = [];
        var cardValueDelegate = this.getSingleCardValue;
        this.gameEnded = true;
        this.playerCards.forEach(function(hand, index1) {
            handValues.push(0);
            hand.forEach(function(card, index2){
                handValues[index1] += cardValueDelegate(card);
            });
        });

        console.log(handValues);

        handValues.forEach(function(value, index){
            if(value > 21){
                handValues[index] = 0; //bust
            }
        });

        var winnerValue = Math.max.apply(null, handValues);
        var results = [];
        var numWinners = 0;
        handValues.forEach(function(value, index){
            if(value == winnerValue && winnerValue != 0){
                results[index] = "winner";
                if(winnerValue == 21){
                    results[index] = "winnerBonus";
                }
                numWinners++;
            }else
            if(value == 0){
                results[index] = "bust";
            }else{
                results[index] = "lose";
            }


        });

        console.log("winner value: " + winnerValue);
        console.log("hand values: " + handValues);
        console.log("results: " + results);
        var self = this;
        results.forEach(function(value, index){
            if(value == "winner"){
                if(numWinners > 1){
                    self.playerPoints[index] = 50;
                }else if(numWinners == 1){
                    self.playerPoints[index] = 100;
                }
                self.winner.push(self.allPlayerNames()[index]);
            }
            if(value == "winnerBonus"){
                if(numWinners > 1){
                    self.playerPoints[index] = 100;
                }else if(numWinners == 1){
                    self.playerPoints[index] = 150;
                }
                self.winner.push(self.allPlayerNames()[index]);
            }
            if(value == "bust" || value == "lose"){
                self.playerPoints[index] == 0;
            }

        });

        console.log("playerpoints: " + this.playerPoints);
        console.log("winner: " + this.winner);
        

    }

    getSingleCardValue(card){
        var cValue = Number(card.substr(1));
        //calcula valor de cada carta
        //console.log(cValue);
        if(cValue > 10){
            cValue = 10;
                }
        if(cValue == 1){
            cValue = 11;
        }
        return cValue;
    }

    allPlayerNames(){
             var names = [];
             for(var i = 0; i < this.playerCount; i++){
                switch(i){
                    case 0:
                            names.push(this.player1);
                            break;
                    case 1:
                            names.push(this.player2);
                            break;
                    case 2:
                            names.push(this.player3);
                            break;
                    case 3:
                            names.push(this.player4);
                            break;
                    default:
                            break;
                }
             }
             return names;
            }

    winnerNames(){
            var winnerAux = "";
                this.game.winner.forEach(function(value, index){
                    if(winnerNames != ""){
                        winnerNames += " and ";
                    }
                    winnerNames += allPlayerNames[value - 1];
                });
                this.winnerNames = winnerAux;
            }

    startCountdown(){
        if(this.playerTurn == 3){
            console.log("bOM DIA :)");
            this.endGame();
            return;
        }
        console.log("Timer: " + this.turnTimer);
        var self = this;
        var timer_id = setInterval(function()
        {
            var contNrPlays = 0;
            self.queuedPlays.forEach(function(item, index) {
                if(item != 'none'){
                    contNrPlays ++;
                }
            });
            
            console.log("queuedPlays: " + self.queuedPlays + "\ncontNrPlays: " + contNrPlays);

            if(self.turnTimer > 0 && contNrPlays != self.playerCount){
                self.turnTimer --;
                console.log("Timer : " + self.turnTimer);
            }else{
                clearInterval(timer_id);
                console.log("Timer is stopped!");
                // pede aos clientes as queued plays para este jogo
                self.queuedPlays.forEach(function(item, index) {
                    if(item === 'fold'){
                        self.playerFolds[index] = 1;
                    }
                    if(item === 'hit'){
                        self.drawCard(index + 1);
                    }
                    if(item === 'none'){
                        self.playerFolds[index] = 1;
                    }
                });
                

                // ready next turn
                self.turnTimer = 20;
                self.playerTurn++;
                for(var p = 0; p < self.playerCount; p++){
                if(self.queuedPlays[p] != 'fold'){
                    self.queuedPlays[p] = 'none';
                    }
                }

                console.log("AAAAAAAAAAAAAAAAAAAAAAAAAAA");
                console.log(self);
                self.startCountdown();
            }
        }, 1000, self);
    }
    
    queuePlay(playerNum, play){
        this.queuedPlays[playerNum - 1] = play;

        //later on we can add a return false if we implement an extra layer of security
        //currently, the game itself on the client side is checking for folds
        return true;
    }

    setup(playercount){
        const cartas = ['1','2','3','4','5','6','7','8','9','10','11','12','13'];
        const naipes = ['c','e','o','p'];
        var tempdeck = [];

        //preenche o baralho
        naipes.forEach(function(element) {
            cartas.forEach(function(element2) {
                tempdeck.push(element + element2);
            });
        });
        this.deck = tempdeck;
        //baralha
        this.deck = this.shuffle(this.deck);

        //cria "mãos" vazias para cada jogador
        for(var p = 0; p < this.playerCount; p++){
            this.playerCards.push([]);
        }

        //inicia os pontos a 0 para cada jogador
        for(var p = 0; p < this.playerCount; p++){
            this.playerPoints.push(0);
        }

        //os jogadores comecam o jogo não folded
        for(var p = 0; p < this.playerCount; p++){
            this.playerFolds.push(0);
        }

        //no plays at first
        for(var p = 0; p < this.playerCount; p++){
            this.queuedPlays.push('none');
        }
        
        //distribui as 2 cartas iniciais pelos jogadores
        for(var i= 0; i < 2; i++){
            for(var j = this.playerCount - 1; j > -1; j--){
                this.playerCards[j].push(this.deck.pop());
            }
        }
        
        //inicia os 20 segundos de espera do turno
        this.startCountdown();
    }


    shuffle(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {
            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;
            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    }

    hasRow(value){
        return  ((this.board[0]==value) && (this.board[1]==value) && (this.board[2]==value)) || 
        ((this.board[3]==value) && (this.board[4]==value) && (this.board[5]==value)) || 
        ((this.board[6]==value) && (this.board[7]==value) && (this.board[8]==value)) || 
        ((this.board[0]==value) && (this.board[3]==value) && (this.board[6]==value)) || 
        ((this.board[1]==value) && (this.board[4]==value) && (this.board[7]==value)) || 
        ((this.board[2]==value) && (this.board[5]==value) && (this.board[8]==value)) || 
        ((this.board[0]==value) && (this.board[4]==value) && (this.board[8]==value)) || 
        ((this.board[2]==value) && (this.board[4]==value) && (this.board[6]==value));
    }  

    checkGameEnded(){
        /*
        if (this.hasRow(1)) {
            this.winner = 1;
            this.gameEnded = true;
            return true;
        } else if (this.hasRow(2)) {
            this.winner = 2;
            this.gameEnded = true;
            return true;
        } else if (this.isBoardComplete()) {
            this.winner = 0;
            this.gameEnded = true;
            return true;
        }
        return false;
        */
        return false;
    }

    isBoardComplete(){
        for (let value of this.board) {
            if (value === 0) {
                return false;
            }
        }
        return true;
    }

    play(playerNumber, index){
        if (!this.gameStarted) {
            return false;
        }
        if (this.gameEnded) {
            return false;
        }
        if (playerNumber != this.playerTurn) {
            return false;
        }
        if (this.board[index] !== 0) {
            return false;
        }
        this.board[index] = playerNumber;
        if (!this.checkGameEnded()) {
            this.playerTurn = this.playerTurn == 1 ? 2 : 1;
        }
        return true;
    }

}

module.exports = TicTacToeGame;
