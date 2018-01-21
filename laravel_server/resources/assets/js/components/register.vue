<template>
	<div>
		<div class="form-group">
			<input
			v-model="name"
			class="form-control"
			type="name"
			placeHolder="Name">
		</div>

		<div class="form-group">
			<input
			v-model="nickname"
			class="form-control"
			type="NickName"
			placeHolder="Nickname">
		</div>

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
		<button @click="test">LOGIN</button>
	</div>				


</template>

<script type="text/javascript">

export default {
	data: function() {
		return{
			name: '',
			nickname: '',
			email: '',
			password: '',
		}
	},

	methods: {
		test: function() {
			axios.post('http://exame.test/api/login',
			{
				email: this.email,
				password: this.password
			},
			{
				headers: { 'Content-Type': 'application/json', 'Accept': 'application/json'}
			}).then(response=> {
				this.$auth.setToken(response.data.access_token, response.data.expires_in + Date.now());
				//console.log(response);
				//console.log(this.$auth.getToken());
				//console.log(this.$auth.isAuthenticated());
				if(this.$auth.isAuthenticated()){
					this.$router.push('multitictactoe');
				}
			});
		}
	},
	mounted() {

	}
}

</script>