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
        this.winner = 0;
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

    drawCard(playerNumber){
        // se o jogo ja comecou
        if(this.gameStarted == true){
            // se o jogador nao tiver dado fold
            if(this.playerFolds[playerNumber - 1] == 0){
                    //se for o 1 turno, so pode ter 3 cartas
                    //se for o 2 turno, pode ter o maximo de 4
                    if(this.playerTurn == 1){
                        if(this.playerCards[playerNumber - 1].length == 2){
                            this.playerCards[playerNumber - 1].push(this.deck.pop());

                            console.log(this.playerCards);
                        }
                    }else{
                        if(this.playerCards[playerNumber - 1].length == 3){
                            this.playerCards[playerNumber - 1].push(this.deck.pop());
                        }
                    }
                }
            }
        }

    startCountdown(){
        console.log("Timer: " + this.turnTimer);
        var self = this;
        var timer_id = setInterval(function()
            {
                if(self.turnTimer > 0){
                    self.turnTimer --;
                    console.log("Timer : " + self.turnTimer);
                }else{
                    clearInterval(timer_id);
                    console.log("Timer is stopped!");
                    self.turnTimer = 20;
                    self.playerTurn = 2;
                }
            }, 1000, self);
    }
    
    queuePlay(playerNum, play){
        queuedPlays[playerNum - 1] = play;
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
