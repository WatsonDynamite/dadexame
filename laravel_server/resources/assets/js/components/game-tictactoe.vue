<template>
	<div class="gameseparator">
        <div>
            <h2 class="text-center">Blackjack Game {{ game.gameID }}</h2>
            <div v-if="isPlayer1() == true">
                <div v-if="isGameStarted() == false">
                    <p><button class="btn btn-xs btn-success" v-on:click.prevent="startGame">Start game</button></p>
                </div>
            </div>
            <br>
        </div>
        <div class="game-zone-content">       
            <div class="alert" :class="alerttype">
                <strong>{{ message }} &nbsp;&nbsp;&nbsp;&nbsp;<a v-show="game.gameEnded" v-on:click.prevent="closeGame">Close Game</a></strong>
            </div>
            <div>
            Tempo até à próxima jogada: {{ game.turnTimer }}
            </div>
            <div>
                <div v-for="(hand, handIndex) of game.playerCards" >
                <strong> {{ allPlayerNames[handIndex] }} </strong>
                    <div class="board">
                    <b v-for="(card, index) of hand">
                    <img v-bind:src="renderCard(card, index, handIndex)">
                    </b>
                    </div>
                </div>
            </div>
            <div>
                    <p><button class="btn btn-xs btn-success" v-if="canPlayerHit == true" v-on:click.prevent="hit">Pedir</button></p><p>Valor: {{ currentHandValue }}</p>
            </div>
            <div>
                    <p><button class="btn btn-xs btn-failure" v-if="game.playerFolds[this.ownPlayerNumber - 1] == 0" v-on:click.prevent="fold">Fechar</button></p> 
            </div>
            <hr>
        </div>  
    </div>			
</template>

<script type="text/javascript">
	export default {
        props: ['game'],
        data: function(){
			return {
            }
        },
        computed: {
            currentHandValue(){
               var handValue = 0;
               var playerNames = this.allPlayerNames;
               var thisName = this.ownPlayerName;
               var cardValueDelegate = this.getSingleCardValue;
               this.game.playerCards.forEach(function(hand, index) {
                  if(playerNames[index] === thisName){
                      hand.forEach(function(card, index){
                            handValue += cardValueDelegate(card);
                      });
                  }
               });
               console.log(handValue);
               return handValue;
            },
            ownPlayerNumber(){
                if (this.game.player1SocketID == this.$parent.socketId) {
                    return 1;
                } else if (this.game.player2SocketID == this.$parent.socketId) {
                    return 2;
                } 
                return 0;
            },
            ownPlayerName(){
                var ownNumber = this.ownPlayerNumber;
                if (ownNumber == 1)
                    return this.game.player1;
                if (ownNumber == 2)
                    return this.game.player2;
                return "Unknown";
            },
            adversaryPlayerName(){
                var ownNumber = this.ownPlayerNumber;
                if (ownNumber == 1)
                    return this.game.player2;
                if (ownNumber == 2)
                    return this.game.player1;
                return "Unknown";
            },
            allPlayerNames(){
             var names = [];
             for(var i = 0; i < this.game.playerCount; i++){
                switch(i){
                    case 0:
                            names.push(this.game.player1);
                            break;
                    case 1:
                            names.push(this.game.player2);
                            break;
                    case 2:
                            names.push(this.game.player3);
                            break;
                    case 3:
                            names.push(this.game.player4);
                            break;
                    default:
                            break;
                }
             }
             return names;
            },
            message(){
                if (!this.game.gameStarted) {
                    return "Game has not started yet";
                } else if (this.game.gameEnded) {
                    if (this.game.winner == this.ownPlayerNumber) {
                        return "Game has ended. You Win.";
                    } else if (this.game.winner == 0) {
                        return "Game has ended. There was a tie.";
                    } 
                    return "Game has ended and " + this.adversaryPlayerName + " has won. You lost.";
                } else {
                    if (this.game.playerTurn == this.ownPlayerNumber) {
                        return "It's your turn";
                    } else {
                        return "It's " + this.adversaryPlayerName + " turn";
                    }
                }
                return "Game is inconsistent";
            },
            alerttype(){
                if (!this.game.gameStarted) {
                    return "alert-warning";
                } else if (this.game.gameEnded) {
                    if (this.game.winner == this.ownPlayerNumber) {
                        return "alert-success";
                    } else if (this.game.winner == 0) {
                        return "alert-info";
                    } 
                    return "alert-danger";
                } 
                if (this.game.playerTurn == this.ownPlayerNumber) {
                    return "alert-success";    
                } else {
                    return "alert-info";
                }
                
            }
        },
        methods: {
            getSingleCardValue(card){
                var cValue = Number(card.substr(1));
                console.log(cValue);
                if(cValue > 10){
                    cValue = 10;
                }
                if(cValue == 1){
                    cValue = 11;
                }
                return cValue;
            },
            checkBust(){
                if(this.currentHandValue > 21){
                    this.game.queuePlay(this.ownPlayerNumber,'fold');
                }
            },
            pieceImageURL (pieceNumber) {
                var imgSrc = String(pieceNumber);
                return 'img/' + imgSrc + '.png';
            },
            renderCard(card, index, handIndex){
                if(this.allPlayerNames[handIndex] != this.ownPlayerName && index > 0){
                    return 'img/semFace.png';
                }else{
                    return this.pieceImageURL(card);
                }
            },  
            closeGame (){
                this.$parent.close(this.game);
            },
            clickPiece(index){
                if (!this.game.gameEnded) {
                    if (this.game.playerTurn != this.ownPlayerNumber) {
                        alert("It's not your turn to play");
                    } else {
                        if (this.game.board[index] == 0) {
                            this.$parent.play(this.game, index);
                        }
                    }
                }
            },
            startGame (){
                //start the game, set it up, etc
                this.$parent.startGame(this.game);
                //why do we tell it to play?
                //this.$parent.play(this.game, 0);
                //start asking for timings
                //this.$parent.updateTime(this.game);
            },
            isPlayer1(){
                if(this.ownPlayerNumber == 1){
                    return true;
                }
                return false;
            },
            isGameStarted(){
                return this.game.gameStarted;
            },
            canPlayerHit(){
                if (!this.game.gameEnded && this.currentHandValue < 21) {
                    if(this.game.playerFolds[this.ownPlayerNumber - 1] == 1){
                        return false;
                    }else{
                        //se for o primeiro turno so pode ter 3 cartas
                        //se for o segundo turno so pode ter 4 cartas
                        if(this.game.playerTurn == 1){
                            if(this.game.playerCards[this.ownPlayerNumber - 1].length == 2){
                                return true;
                            }
                        }else{
                            if(this.game.playerCards[this.ownPlayerNumber - 1].length == 3){
                                return true;
                            }
                        }

                    }
                }
                return false;
            },
            fold(){
                if (!this.game.gameEnded) {
                    this.$parent.queuePlay(this.game, 'fold');
                }
            },
            hit(){
                if (!this.game.gameEnded) {
                    this.$parent.queuePlay(this.game, 'hit');
                }
            },
        }
    }
</script>

<style scoped>	
.gameseparator{
    border-style: solid;
    border-width: 2px 0 0 0;
    border-color: black;
}
</style>