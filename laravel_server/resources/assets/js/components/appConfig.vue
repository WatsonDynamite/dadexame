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
				<input v-model="platform_email_properties[0]" type="text" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Email - Host</h5>
				<input v-model="platform_email_properties[1]" type="text" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Email - Port</h5>
				<input v-model="platform_email_properties[2]" type="text" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Email - Password</h5>
				<input v-model="platform_email_properties[3]" type="password" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Email - Encryption</h5>
				<input v-model="platform_email_properties[4]" type="text" name="platform_email">
				<br><br>

				<h5 class="card-title">Application Image Path</h5	>
				<input v-model="configs.img_base_path" type="text" name="img_base_path">
			</div>
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

			axios.get('http://188.186.86.13/api/configs')
			.then(response => {
				console.log(response.data.data);
				this.configs = response.data.data[0];
				var aux = this.configs.platform_email_properties;
				
				console.log(aux.split(':').pop().split(';').shift()); 

				var array;
				var self = this;
				aux.forEach( function(element, index) {
					array = element.split(",");
					array = element.split(":");
					console.log(array);
					self.platform_email_properties[index] = array[1];
					console.log(self.platform_email_properties);
				});

                });
		},
		setConfig(){
			axios.post('http://188.186.86.13/api/configs')
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