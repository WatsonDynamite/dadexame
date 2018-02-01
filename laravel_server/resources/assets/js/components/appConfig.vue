<template>
	<div>
		<h2>BlackJack App Configuration</h2>
		<br>
		<div class="card-panel teal darken-1">
			<div class="card-content white-text">
              
			<div class="input-field">
				<h5 class="card-title">Application Email</h5>
				<input v-model="configs.platform_email" type="email" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Email - Driver</h5>
				<input v-model="platform_email_properties.driver" type="text" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Email - Host</h5>
				<input v-model="platform_email_properties.host" type="text" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Email - Port</h5>
				<input v-model="platform_email_properties.port" type="text" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Email - Password</h5>
				<input v-model="platform_email_properties.password" type="password" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Email - Encryption</h5>
				<input v-model="platform_email_properties.encryption" type="text" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Image Path</h5	>
				<input v-model="configs.img_base_path" type="text" name="img_base_path">
			</div>
			<a @click="setConfig" class="waves-effect waves-light btn">Submit</a>
		</div>
		</div>
			
	</div>
</template>
 <script type="text/javascript">

export default {
	data: function() {
		return{
			configs: null,
			platform_email_properties: []
		}
	},

	methods: {
		getConfigs: function() {

			axios.get('http://exame.test/api/configs')
			.then(response => {
				console.log(response.data.data);
				this.configs = response.data.data[0];
				this.platform_email_properties =JSON.parse( this.configs.platform_email_properties);
				console.log(this.platform_email_properties);
                });
		},
		setConfig(){
<<<<<<< HEAD
			axios.post('http://exame.test/api/configs')
=======
			axios.post('http://exame.test/api/configs',{
				driver: this.platform_email_properties.driver,
				host: this.platform_email_properties.host,
				port: this.platform_email_properties.port,
				password: this.platform_email_properties.password ,
				encryption: this.platform_email_properties.encryption,
				email: this.configs.platform_email

			})
>>>>>>> 4a78de9569e54a8121a72bccd04ba51b5211c133
			.then(response => {
				console.log(response);
			});
		}
	},
	computed:{    
        },
	mounted() {
		this.getConfigs();
	}
}

</script>



