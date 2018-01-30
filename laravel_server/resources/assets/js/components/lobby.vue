<template>
	<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>ID</th>
	            <th>Player 1</th>
                <th>Player Count</th>
                <th>Created at:</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr v-for="game in games"  :key="game.gameID">
	            <td>{{ game.gameID }}</td>
	            <td>{{ game.player1 }}</td>
                <td>{{ game.playerCount }}/4</td>
                <td>{{ game.dateCreated }} </td>
	            <td>
	                <a class="btn btn-xs btn-primary" v-on:click.prevent="join(game)">Join</a>
	            </td>
	        </tr>
	    </tbody>
	</table>
</template>

<script type="text/javascript">
	// Component code (not registered)
	module.exports={
		props: ['games'],
        methods: {
            join(game) {
            	this.$emit('join-click', game);
            },		
        }
	}
</script>

<style scoped>

</style>