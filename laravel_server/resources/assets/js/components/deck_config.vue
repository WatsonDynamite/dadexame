<template>
	<div>
		<h2>BlackJack App Deck Manager</h2>


		<div class="card-panel teal darken-1">
			<p>Nr of Complete Decks: {{ nrCompleteDecks }}</p>
			<p>Nr of Incomplete Decks: {{ nrIncompleteDecks }}</p>
		</div>
			
		<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>Deck Name</th>
	            <th>Status</th>
	            <th>Completed</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>

	        <tr v-for="deck in decks"  :key="deck.id" :class="{activerow: editingDeck === deck}">
	            <td>{{ deck.name }}</td>
	            <td v-if="deck.active == 1">Active</td>
	            <td v-if="deck.active == 0">Disabled</td>
	            <td v-if="deck.complete == 1">Yes</td>
	            <td v-if="deck.complete == 0">No</td>
	            <td>
	            	<a class="waves-effect waves-light btn" v-on:click.prevent=""><i class="medium material-icons">details</i></a>
	                <a class="waves-effect waves-light btn" v-on:click.prevent="changeDeckStatus(deck)"><i class="medium material-icons">do_not_disturb</i></a>
	                <!--<a class="waves-effect waves-light btn" v-on:click.prevent="deleteUser(user)"><i class="medium material-icons">delete</i></a> -->
	            </td>
	        </tr>
	    </tbody>
	</table>


		<h4>Upload Card Image</h4>
		<div class="card-panel teal darken-1">

		<form action="#">
		    <div class="file-field input-field">
		    <div class="btn">
		        <span>File</span>
		    	<input type="file" name="image" id="file">
		    </div>
		    <div class="file-path-wrapper">
		        	<input class="file-path validate" type="text">
		    	</div>
			</div><br>

			<select v-for="deck in decks" :key="deck.id" class="browser-default">
		    <option value="" disabled selected>Deck</option>
		    <option value="deckName">{{ deck.name }}</option>
		  </select><br><br>

		  <select class="browser-default">
		    <option value="" disabled selected>Suite</option>
		    <option v-for="suite in suites" value="deckName">{{ suite }}</option>
		  </select><br><br>

		  <select class="browser-default">
		    <option value="" disabled selected>Value</option>
		    <option v-for="value in values" value="deckName">{{ value }}</option>
		  </select><br><br>

		</form>
			<a @click="uploadCard" class="waves-effect waves-light btn">Upload Card</a>
		</div>
	</div>
</template>

 <script type="text/javascript">

export default {
	data: function() {
		return{
			values: ['Ace','2','3','4','5','6','7','8','9','10','Jack','Queen','King'],
			suites: ['Club','Diamond','Heart','Spade'],
			nrCompleteDecks: 0,
			nrIncompleteDecks: 0,
			decks: null,
			editingDeck: null,
			cardFile: null,
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
		changeDeckStatus: function(deck){
			axios.get('http://exame.test/api/decks/'+deck.id+'/changeStatus')
				.then(response => {
					console.log(response);
                    this.getDecks();
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
		},
		deleteCard: function(user){
            axios.delete('http://exame.test/api/decks/'+user.id)
                .then(response => {
                });
		}
	},
	computed:{    
        },
	mounted() {
		this.getDecks();
	}
}

</script>