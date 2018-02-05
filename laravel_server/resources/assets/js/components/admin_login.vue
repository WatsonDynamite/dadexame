<template>
	<div>
		<div class="loginForm">
			<div class="card-panel blue-grey darken-3">
				<div class="card-content white-text">
	              <h1>Login - Administration App</h1>
					<br>
				<div class="input-field">
					<input v-model="email" class="validate" type="email" placeHolder="Email">
				</div>

				<div class="input-field">
					<input v-model="password" class="validate" type="password" placeHolder="secret">
				</div>
			</div><br>
			<div v-if="failed" class="card-panel red darken-3">
			<div class="card-content white-text">
			{{failedMessage}}
			</div></div><br>
			<div class="card-action">
			<div class="divider"></div> <br>
			<button class="btn waves-effect waves-light" @click="login">Login</button><br>
			</div>	
			</div>	
		</div>

	</div>				
</template>

<script type="text/javascript">

export default {
	data: function() {
		return{
			email: '',
			password: '',
			failed: false,
			failedMessage: ''
		}
	},

	methods: {
		login: function() {
			axios.post('http://128.199.51.26/api/loginAdmin',
			{
				email: this.email,
				password: this.password
			},
			{
				headers: { 'Content-Type': 'application/json', 'Accept': 'application/json'}
			}).then(response=> {
				console.log(response);
				
				if(! (response.data.access_token == undefined) ){
					this.$auth.setToken(response.data.access_token, response.data.expires_in + Date.now());
				}else {
					this.failed = true;
					this.failedMessage = response.data.data.msg;
				}

				if(this.$auth.isAuthenticated()){
					this.$router.push('adminPage');
				}
			});
		}
	},
	mounted() {

	}
}

</script>

<style type="text/css" media="screen">
	.loginForm{
		width: 70%;
		padding-top: 15%;
		padding-left: 25%;

	}

	.input-field {
		
	}

</style>