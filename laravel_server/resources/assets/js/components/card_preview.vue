<template>
	<div>
		<h4>Preview Deck</h4>
		<div class="card-panel teal darken-1">
			<div class="card-content white-text">
			<div>
				<div class="previewBox" v-for="(card, index) in previewCards">
					<p>{{card.suite}} - {{card.value}}</p>
					<img class="responsive-img previewImage" :src="card.path" />				
				</div>
			</div>
		</div>
		</div>


	</div>
</template>

<script type="text/javascript">

export default {
	props:['selectedTableDeck'],
	data: function() {
		return{
			previewCards: []
		}
	},

	methods: {
		getDeckCards: function() {
			axios.get('http://188.166.86.13/api/decks/' + this.selectedTableDeck)
			.then(response => {
				this.previewCards = response.data.data;

				var path;
				this.previewCards.forEach( function(card, index) {
					path = card.path;
					card.path = path.replace("public/","storage/");
					card.path = 'http://188.166.86.13/' + card.path;
					console.log('PATH: ' + card.path);
				});

				console.log(this.previewCards);	
                });
		}
	},
	computed:{    
        },
	mounted() {
		this.getDeckCards();
	}
}

</script>

<style type="text/css" media="screen">
	.previewImage{
		width: 100px;
		height: 150px;

	}

	.previewBox{
		display: inline-block;
		padding: 10px;	
	}
</style>