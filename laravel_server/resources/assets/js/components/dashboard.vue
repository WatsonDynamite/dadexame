<template>
	<div>
		<h2>DashBoard</h2>
		<button @click="redirectToUsers">Users</button>

		<p>Nr of Players: {{ nrPlayers}}</p>
	</div>				


</template>

<script type="text/javascript">

export default {
	data: function() {
		return{
			email: '',
			password: '',
			nrPlayers: 0
		}
	},

	methods: {
		getStats: function() {
			axios.get('')
			.then(function (response) {
			    console.log(response);
			})
			  .catch(function (error) {
			    console.log(error);
			});
		},
		redirectToUsers: function(){
			this.$router.push('usersList');
		}
	},
	mounted() {

	}
}

</script>