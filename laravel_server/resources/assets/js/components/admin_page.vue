<template>
	<div>

		<div class="navbar">
			<div class="card-panel blue-grey darken-3">
				<a @click="showUsers" class="waves-effect waves-light btn">Users</a>
				<a @click="showAppConfig" class="waves-effect waves-light btn">App Configurations</a>
				<a @click="showStats" class="waves-effect waves-light btn">Statistics</a>
				<a @click="showDeckConfig" class="waves-effect waves-light btn">Decks</a>
				<a @click="showEditPassword" class="waves-effect waves-light btn">Change Password</a>
				<a @click="logout" class="waves-effect waves-light btn" style="float: right" >Logout</a>
			</div>	
		</div>
		<users-list :users="users" v-if="index == 1" ref="usersListRef"></users-list>
		<stats v-if="index ==2" ></stats>
		<app-config v-if="index == 3"></app-config>
		<deck-config v-if="index == 4"></deck-config>		
		<admin-pass v-if="index == 5"></admin-pass>		
	</div>				
</template>

<script type="text/javascript">
	import UsersList from './usersList.vue';
	import AppConfig from './appConfig.vue';
	import Statistics from './statistics.vue';
	import DeckConfig from './deck_config.vue';
	import AdminPass from './admin_pass.vue';

	export default {
		data: function(){
			return { 
		        users: [],
		        index: 1
		    }
		},
	    methods: {
	    	showUsers: function(){
	            this.index = 1;
	        },
	        logout: function(){
	        	this.$router.push('login');
                this.$auth.destroyToken();
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
	        showEditPassword: function() {
	        	this.index = 5;
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
	    	'deck-config': DeckConfig,
	    	'admin-pass': AdminPass
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