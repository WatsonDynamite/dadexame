<template>
	
	<div>

		<h2>BlackJack App Statistics</h2>

		<div class="row">
			<div class="col-lg-2">
			    <div id="test-circle"></div>
			</div>
		</div>


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
		}
	},

	methods: {
		getDecks: function() {

			axios.get('http://exame.test/api/decks')
			.then(response => {
				console.log(response.data.data);
				this.decks = response.data.data;
                });
		},
		uploadCard: function() {
			var formData = new FormData();
			var imagefile = document.querySelector('#file');
			formData.append("image", imagefile.files[0]);

			axios.post('http://exame.test/api/decks',formData,{
				'Content-Type': 'multipart/form-data'	
			})
			.then(response => {
				console.log(response)
                });
		}
	},
	computed:{    
        },
	mounted() {
	}
}

</script>