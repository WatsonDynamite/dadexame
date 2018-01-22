/*jshint esversion: 6 */

var TicTacToeGame = require('./gamemodel.js');

class GameList {
	constructor() {
        this.contadorID = 0;
        this.games = new Map();
    }

    gameByID(gameID) {
    	let game = this.games.get(gameID);
    	return game;
    }

    createGame(playerName, socketID) {
    	this.contadorID = this.contadorID+1;
    	var game = new TicTacToeGame(this.contadorID, playerName);
    	game.player1SocketID = socketID;
    	this.games.set(game.gameID, game);
    	return game;
    }

    joinGame(gameID, playerName, socketID) {
    	let game = this.gameByID(gameID);
    	if (game===null) {
    		return null;
    	}
        if(game.playerCount == 1){
            game.join(playerName);
            game.player2SocketID = socketID;
        }else{
            if(game.playerCount == 2){
                game.join(playerName);
                game.player3SocketID = socketID;
            }else{
                if(game.playerCount == 3){
                    game.join(playerName);
                    game.player4SocketID = socketID;
                }
            }
        }
    	
    	return game;
    }

    startGame(gameID) {
        let game = this.gameByID(gameID);
        if (game===null) {
            return null;
        }
        if(game.playerCount > 1){
            game.startGame();
            console.log(game);
            return game;
        }
        return null;
    }
        
        

    removeGame(gameID, socketID) {
    	let game = this.gameByID(gameID);
    	if (game===null) {
    		return null;
    	}
    	if (game.player1SocketID == socketID) {
    		game.player1SocketID = "";
    	} else if (game.player2SocketID == socketID) {
    		game.player2SocketID = "";
    	} 
    	if ((game.player1SocketID === "") && (game.player2SocketID === "")) {
    		this.games.delete(gameID);
    	}
    	return game;
    }

    getConnectedGamesOf(socketID) {
    	let games = [];
    	for (var [key, value] of this.games) {
    		if ((value.player1SocketID == socketID) || (value.player2SocketID == socketID) || (value.player3SocketID == socketID) || (value.player4SocketID == socketID)) {
    			games.push(value);
    		}
		}
		return games;
    }

    getLobbyGamesOf(socketID) {
    	let games = [];
    	for (var [key, value] of this.games) {
    		if ((!value.gameStarted) && (!value.gameEnded))  {
    			if ((value.player1SocketID != socketID) && (value.player2SocketID != socketID) && (value.player3SocketID != socketID) && (value.player4SocketID != socketID)) {
    				games.push(value);
    			}
    		}
		}
		return games;
    }
}

module.exports = GameList;
