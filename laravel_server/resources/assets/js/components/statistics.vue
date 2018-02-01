<template>
	
	<div>

		<h2>BlackJack App Statistics</h2><br><br>

		<h4>Total nr of players: {{ totalNrPlayers }}</h4><br>
		
		<h4>Total nr of games played: {{ totalNrPlayedGames }}</h4><br><br>

		<h4>Top 5 Highscores</h4>
		<table class="table table-striped">
		    <thead>
		        <tr>
		            <th>Name</th>
		            <th>Nickname</th>
		            <th>Highscore</th>
		        </tr>
		    </thead>
		    <tbody>

		        <tr v-for="user in topPlayersPoints"  :key="user.id">
		            <td>{{ user.name }}</td>
		            <td>{{ user.nickname }}</td>
		            <td>{{ user.total_points }}</td>
		        </tr>
		    </tbody>
		</table><br><br>

		<h4>Top 5 Players with the most games played</h4>
		<table class="table table-striped">
		    <thead>
		        <tr>
		            <th>Name</th>
		            <th>Nickname</th>
		            <th>Games Played</th>
		        </tr>
		    </thead>
		    <tbody>

		        <tr v-for="user in topPlayersGames"  :key="user.id">
		            <td>{{ user.name }}</td>
		            <td>{{ user.nickname }}</td>
		            <td>{{ user.total_games_played }}</td>
		        </tr>
		    </tbody>
		</table><br><br>


		<h4>Top 5 Players with the best Avg</h4>
		<table class="table table-striped">
		    <thead>
		        <tr>
		            <th>Name</th>
		            <th>Nickname</th>
		            <th>Avg</th>
		        </tr>
		    </thead>
		    <tbody>

		        <tr v-for="user in topPlayersBestAvg"  :key="user.id">
		            <td>{{ user.name }}</td>
		            <td>{{ user.nickname }}</td>
		            <td>{{ Number((user.total_points/user.total_games_played).toFixed(1)) }}</td>
		        </tr>
		    </tbody>
		</table><br><br>


	</div>
</template>
<!--
Stats:

	Nr of games played

	Nr of players

	games played today

	average of games per user

	games played per day

	most used decks 

	-->
 <script type="text/javascript">

export default {
	data: function() {
		return{
			topPlayersPoints: [],
			topPlayersGames: [],
			topPlayersBestAvg: [],
			totalNrPlayers: 0,
			totalNrPlayedGames: 0
		}
	},

	methods: {
		getStats: function() {

			axios.get('http://188.166.86.13/api/stats/totalPlayers')
			.then(response => {
				this.totalNrPlayers = response.data;
				console.log(response.data);
            });

            axios.get('http://188.166.86.13/api/stats/totalGames')
			.then(response => {
				this.totalNrPlayedGames = response.data;
				console.log(response.data);
            });

			axios.get('http://188.166.86.13/api/stats/topPlayersMorePoints')
			.then(response => {
				this.topPlayersPoints = response.data.data;
				console.log(response.data);
            });

            axios.get('http://188.166.86.13/api/stats/topPlayersMoreGames')
			.then(response => {
				this.topPlayersGames = response.data.data;
				console.log(response.data);
            });

			axios.get('http://188.166.86.13/api/stats/topPlayersBestAvg')
			.then(response => {
				this.topPlayersBestAvg = response.data.data;
				console.log(response.data);
            });

		}
	},
	computed:{    
        },
	mounted() {
		this.getStats();
	}
}

</script>