<template>
	<div>

		<div class="loginForm">
			<div class="card-panel blue-grey darken-3">
				<div class="card-content white-text">
	              <h1>Login - BlackJack App</h1>
					<br>
				<div class="input-field">
					<input v-model="name" class="validate" type="text" placeHolder="Email">
				</div>
				<div class="input-field">
					<input v-model="nickname" class="validate" type="text" placeHolder="Email">
				</div>
				<div class="input-field">
					<input v-model="email" class="validate" type="email" placeHolder="Email">
				</div>
				<div class="input-field">
					<input v-model="password" class="validate" type="password" placeHolder="secret">
				</div>
			</div><br>
			<div class="card-action">
			<div class="divider"></div><br>
			<button class="btn waves-effect waves-light" @click="register">Register</button>
			<br>
			</div>	
			</div>	
		</div>
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
		register: function() {
			axios.post('http://188.186.86.13/api/users',
			{
				name: this.name,
				nickname: this.nickname,
				email: this.email,
				password: this.password
			},
			{
				headers: { 'Content-Type': 'application/json', 'Accept': 'application/json'}
			}).then(response=> {
					this.$router.push('login');
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
	
</style>