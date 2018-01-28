<template>
	<div>
		<h2>BlackJack App Configuration</h2>

		<div class="card-panel teal darken-1">
			<div class="card-content white-text">
              
			<div class="input-field">
				<h5 class="card-title">Application Email</h5>
				<input v-model="configs.platform_email" type="email" name="platform_email">
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
			configs: null
		}
	},

	methods: {
		getConfigs: function() {

			axios.get('http://exame.test/api/configs')
			.then(response => {
				console.log(response.data.data);
				this.configs = response.data.data[0];
				console.log(this.configs);
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