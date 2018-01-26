<template>
	<div>
		<div class="form-group">
			<input
			v-model="email"
			class="form-control"
			type="email"
			placeHolder="Email">
		</div>

		<div class="form-group">
			<input
			v-model="password"
			class="form-control"
			type="password"
			placeHolder="secret">
		</div>

		<button @click="login">LOGIN</button>
		<button @click="register">REGISTER</button>

				
	</div>	


</template>

<script type="text/javascript">

export default {
	data: function() {
		return{
			email: '',
			password: '',
		}
	},

	methods: {
		login: function() {
			axios.post('http://exame.test/api/login',
			{
				email: this.email,
				password: this.password
			},
			{
				headers: { 'Content-Type': 'application/json', 'Accept': 'application/json'}
			}).then(response=> {

				console.log('----------');
				console.log(response);
				console.log('----------');

				if(! (response.data.access_token == undefined) ){
					this.$auth.setToken(response.data.access_token, response.data.expires_in + Date.now());
				}
				
				if(this.$auth.isAuthenticated()){
					this.$router.push('multitictactoe');
				}
			});
		},
		register:  function(){
			this.$router.push('register');
		}
	},
	mounted() {

	}
}

</script>