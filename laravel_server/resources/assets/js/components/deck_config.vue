<template>
	<div>
		<h2>BlackJack App Deck Manager</h2>


		<div class="card-panel teal darken-1">
			<div class="card-content white-text">
			<p>Nr of Complete Decks: {{ nrCompleteDecks }}</p>
			<p>Nr of Incomplete Decks: {{ nrIncompleteDecks }}</p>
			</div>
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
	            	<a class="waves-effect waves-light btn" v-on:click.prevent="previewCard(deck)"><i class="medium material-icons">details</i></a>
	                <a class="waves-effect waves-light btn" v-on:click.prevent="changeDeckStatus(deck)"><i class="medium material-icons">do_not_disturb</i></a>
	                <!--<a class="waves-effect waves-light btn" v-on:click.prevent="deleteUser(user)"><i class="medium material-icons">delete</i></a> -->
	            </td>
	        </tr>
	    </tbody>
	</table><br>
		<card-preview :selectedTableDeck="selectedTableDeck" v-if="showPreview"></card-preview>

		<br><br>	
		<h4>Create New Deck</h4>
		<div class="card-panel teal darken-1">
			<div class="card-content white-text">

				<form action="#">
					<p>Deck Name:</p>
					<input v-model="newDeckTitle" type="text">
				    <div class="file-field input-field">
				      <div class="btn">
				        <span>File</span>
				        <input type="file" name="image" id="deckfile">
				      </div>
				      <div class="file-path-wrapper">
				        <input class="file-path validate" type="text">
				      </div>
				    </div>
				    <a @click="createDeck" class="waves-effect waves-light btn">Create Deck</a>
				</form>
			</div>
		</div>


		<br><br>	
		<h4>Upload Card Image</h4>
		<div class="card-panel teal darken-1">
			<div class="card-content white-text">
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
			<p>Deck:</p>
			<select class="browser-default" v-model="selectedDeck">
		    <option disabled selected>Deck</option>
		    <option v-for="deck in decks">{{ deck.name }}</option>
		  </select><br>
		  <p>Suite:</p>
		  <select class="browser-default" v-model="selectedSuite"> 
		    <option disabled selected style="color:#000">Suite</option>
		    <option v-for="suite in suites">{{ suite }}</option>
		  </select><br>
		  <p>Value:</p>
		  <select class="browser-default" v-model="selectedValue">
		    <option disabled selected >Value</option>
		    <option v-for="value in values">{{ value }}</option>
		  </select><br>

		</form>
			<a @click="uploadCard" class="waves-effect waves-light btn">Upload Card</a>
		</div>
		</div>
	</div>
</template>

 <script type="text/javascript">
import CardPreview from './card_preview.vue';

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
			newDeckTitle: '',
			/////Deck Preview /////////////////
			showPreview: false,
			selectedTableDeck: 0,
			/////Upload Card Variables/////////
			selectedSuite: null,
			selectedDeck: null,
			selectedValue: null
		}
	},

	methods: {
		getDecks: function() {
			axios.get('http://exame.test/api/decks')
			.then(response => {
				this.decks = response.data.data;
				var self = this;
				this.decks.forEach( function(deck, index) {
					console.log(deck);
					(deck.complete == 0) ? self.nrIncompleteDecks++ : self.nrCompleteDecks++;
				});

            });
		},
		previewCard: function(deck){

			if(this.selectedTableDeck == deck.id){
				(this.showPreview == true) ? this.showPreview = false : this.showPreview = true;
			}else{
				this.selectedTableDeck = deck.id;
			}
		},
		changeDeckStatus: function(deck){
			axios.get('http://exame.test/api/decks/'+deck.id+'/changeStatus')
				.then(response => {
                    this.getDecks();
                });
		},
		uploadCard: function() {
			if(this.validateUploadForm()){
				var formData = new FormData();
				var imagefile = document.querySelector('#file');
				formData.append("image", imagefile.files[0]);
				formData.append("deck", this.selectedDeck);
				formData.append("suite", this.selectedSuite);
				formData.append("value", this.selectedValue);
				axios.post('http://exame.test/api/cards',formData,{
					'Content-Type': 'multipart/form-data'	

				})
				.then(response => {
					this.forcePreview();
	                });
			}
		},
		deleteCard: function(user){
            axios.delete('http://exame.test/api/decks/'+user.id)
                .then(response => {
                });
		},
		createDeck: function(){
			if(! this.newDeckTitle == ''){
				var formData = new FormData();
				var imagefile = document.querySelector('#deckfile');
				formData.append("image", imagefile.files[0]);
				formData.append("name", this.newDeckTitle);
				axios.post('http://exame.test/api/decks',formData,{
					'Content-Type': 'multipart/form-data'	
				})
				.then(response => {
					this.newDeckTitle = '';
					this.getDecks();
	            });
			}
		},validateUploadForm: function(){
			if((this.values.includes(this.selectedValue)) || 
					(this.suites.includes(this.selectedSuite)) )
			{
				return true

			}else{ 
				return false;
			}
		}
	},
	components: {
	    	'card-preview': CardPreview
	    },
	computed:{    
        },
	mounted() {
		this.getDecks();
	}
}

</script>

<style type="text/css" media="screen">
	select{
		color: #000;
	}
</style>