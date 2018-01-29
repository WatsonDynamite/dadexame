<template>
	<div>

		<div class="navbar">
			<div class="card-panel blue-grey darken-3">
				<a @click="showUsers" class="waves-effect waves-light btn">Users</a>
				<a @click="showAppConfig" class="waves-effect waves-light btn">App Configurations</a>
				<a @click="showStats" class="waves-effect waves-light btn">Statistics</a>
				<a @click="showDeckConfig" class="waves-effect waves-light btn">Decks</a>
			</div>	
		</div>
		<users-list :users="users" v-if="index == 1" ref="usersListRef"></users-list>
		<stats v-if="index ==2" ></stats>
		<app-config v-if="index == 3"></app-config>
		<deck-config v-if="index == 4"></deck-config>		
	</div>				
</template>

<script type="text/javascript">
	import UsersList from './usersList.vue';
	import AppConfig from './appConfig.vue';
	import Statistics from './statistics.vue';
	import DeckConfig from './deck_config.vue';

	export default {
		data: function(){
			return { 
		        users: [],
		        index: 0
		    }
		},
	    methods: {
	    	showUsers: function(){
	            this.index = 1;
	        },
	        showStats: function(){
	            this.index = 2;
	        },
	        showAppConfig: function(){
	        	this.index = 3;
	        },
	        showDeckConfig: function(){
	        	this.index = 4;
	        },
	        savedUser: function(){
	            this.currentUser = null;
	            this.$refs.usersListRef.editingUser = null;
	            this.showSuccess = true;
	            this.successMessage = 'User Saved';
	        },
	        cancelEdit: function(){
	            this.currentUser = null;
	            this.$refs.usersListRef.editingUser = null;
	            this.showSuccess = false;
	        },
	        getUsers: function(){
	            axios.get('api/users')
	                .then(response=>{this.users = response.data.data; });
			},
			childMessage: function(message){
				this.showSuccess = true;
	            this.successMessage = message;
			}
	    },
	    components: {
	    	'users-list': UsersList,
	    	'app-config': AppConfig,
	    	'stats': Statistics,
	    	'deck-config': DeckConfig
	    },
	    mounted() {
			
		}

	}
</script>

<style scoped>	
	.card a{
		padding: 0 1rem;
	}
</style>