<template>
	<div>
        <div>
            <h3 class="text-center">{{ title }}</h3>
            <br>
            <h2>Current Player : {{ currentPlayer }}</h2>
            <p><em>Player name replaces authentication! Use different names on different browsers, and don't change it frequently.</em></p>
            <hr>
            <h3 class="text-center">Lobby</h3>
            <p><button class="btn btn-xs btn-success" v-if="checkUsernameLoaded() == true" v-on:click.prevent="createGame">Create a New Game</button></p>
            <p><button class="btn btn-xs btn-success" v-if="checkUsernameLoaded() == true" v-on:click.prevent="goToProfile">My Profile</button></p>
            <hr>
            <h4>Pending games (<a @click.prevent="loadLobby">Refresh</a>)</h4>
            <lobby :games="lobbyGames" @join-click="join"></lobby>
            <template v-for="game in activeGames">
                <game :game="game"></game>
            </template>
        </div>
    </div>
</template>

<script type="text/javascript">
    import Lobby from './lobby.vue';
    import GameTicTocToe from './game-tictactoe.vue';

	export default {
        data: function(){
			return {
                title: 'Online BlackJack',
                currentPlayer: 'Loading...',
                lobbyGames: [],
                activeGames: [],
                socketId: "",
            }
        },
        sockets:{
            connect(){
                console.log('socket connected');
                this.socketId = this.$socket.id;
            },
            discconnect(){
                console.log('socket disconnected');
                this.socketId = "";
            },
            lobby_changed(){
                this.loadLobby();
            },
            my_active_games_changed(){
                this.loadActiveGames();
            },
            my_active_games(games){
                this.activeGames = games;
            },
            my_lobby_games(games){
                this.lobbyGames = games;
            },
            invalid_play(errorObject){
                if (errorObject.type == 'Invalid_Game') {
                    alert("Error: Game does not exist on the server");
                } else if (errorObject.type == 'Invalid_Player') {
                    alert("Error: Player not valid for this game");
                } else if (errorObject.type == 'Invalid_Play') {
                    alert("Error: Move is not valid or it's not your turn");
                } else {
                    alert("Error: " + errorObject.type);
                }

            },
            game_changed(game){
                for (var lobbyGame of this.lobbyGames) {
                    if (game.gameID == lobbyGame.gameID) {
                        Object.assign(lobbyGame, game);
                        break;
                    }
                }
                for (var activeGame of this.activeGames) {
                    if (game.gameID == activeGame.gameID) {
                        Object.assign(activeGame, game);
                        break;
                    }
                }
            },
            givePoints(game){
                var numPlayer = 0;

                if (game.player1 == this.currentPlayer) {
                    numPlayer = 1;
                } else if (game.player2 == this.currentPlayer) {
                    numPlayer = 2;
                } else if (game.player3 == this.currentPlayer) {
                    numPlayer = 3;
                } else if (game.player4 == this.currentPlayer) {
                    numPlayer = 4;
                }

                
                //if this player is one of the winners
                if(game.winner.includes(this.currentPlayer)){
                    console.log("give points to: " + this.currentPlayer + " and his number " + numPlayer);

                    //Get his token
                    const AuthStr = 'Bearer '.concat(this.$auth.getToken());

                    //his points from this game
                    var points = 0;
                    //his games played
                    var games = 0;

                    //get the points he has right now and the games he's played
                    axios.get('http://exame.test/api/user', {headers: { Authorization: AuthStr} })
                    .then(response => {
                        points =  response.data.total_points;
                        games =  response.data.total_games_played;
                    })
                    .catch((error) => {
                        console.log("Error fetching user data");
                    });

                    //print out some data
                    console.log("You've played " + games + " games so far");
                    games++;
                    console.log("with this game, you've played  " + games);
                    console.log("right now you have "+ points + " points");
                    console.log("you won " + game.playerPoints[numPlayer -1] + " points");
                    points = points + game.playerPoints[numPlayer -1];
                    console.log("Now you have a total of "+ points +" points");

                    //UPDATE authenticated user's PARAMETERS
                    axios.put('http://exame.test/api/user',
                    {
                        total_points: points,
                        total_games_played: games
                    },
                    {
                        headers: { 'Authorization': AuthStr,
                                   'Content-Type': 'application/json',
                                   'Accept': 'application/json' }
                    }).then(function(response){
                        console.log("User updated with success!");
                    }).catch((error) => {
                        console.log("Error while trying to update user");
                    });
                }
            },
        },        
        methods: {
            checkUsernameLoaded(){
              return !(this.currentPlayer === 'Loading...');
            },
            loadLobby(){
                this.$socket.emit('get_my_lobby_games');
            },
            loadActiveGames(){
                this.$socket.emit('get_my_activegames');
            },
            createGame(){
                if (this.currentPlayer == "") {
                    alert('Current Player is Empty - Cannot Create a Game');
                    return;
                }
                else {
                    this.$socket.emit('create_game', { playerName: this.currentPlayer });   
                }
            },
            goToProfile(){
                this.$router.push('playermanagement');
            },
            join(game){
                if (game.player1 == this.currentPlayer || game.player2 == this.currentPlayer || game.player3 == this.currentPlayer || game.player4 == this.currentPlayer) {
                    alert('Cannot join a game because there already is a player with your name in this lobby');
                    return;
                }
                if(game.playerCount == 4){
                    alert('This lobby is full.');
                }
                this.$socket.emit('join_game', {gameID: game.gameID, playerName: this.currentPlayer });   
            },
            play(game, index){
                this.$socket.emit('play', {gameID: game.gameID, index: index });   
            },
            drawCard(game){
                this.$socket.emit('draw_Card', {gameID: game.gameID});
            },
            startGame(game){
                this.$socket.emit('start', {gameID: game.gameID});  
            },
            close(game){
                this.$socket.emit('remove_game', {gameID: game.gameID });   
            },
            playerName(){
                const AuthStr = 'Bearer '.concat(this.$auth.getToken());
                axios.get('http://exame.test/api/user', {headers: { Authorization: AuthStr} })
                .then(response => {
                    this.currentPlayer =  response.data.nickname;
                })
                .catch((error) => {
                    this.currentPlayer = 'Missing';
                });
            },
            queuePlay(game, option){
                this.$socket.emit('queuePlay', {gameID: game.gameID, playerOption: option});
            },
            askForPoints(game){
                this.$socket.emit('askForPoints', {gameID: game.gameID});
            },
        },
        components: {
            'lobby': Lobby,
            'game': GameTicTocToe,
        },
        mounted() {
            this.loadLobby();
            this.playerName();
        }

    }
</script>

<style>	
    
</style>