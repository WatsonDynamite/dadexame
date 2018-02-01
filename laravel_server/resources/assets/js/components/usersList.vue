<template>
	<div>
	
	<h2>BlackJack App Users</h2>
	
	<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>Name</th>
	            <th>Nickname</th>
	            <th>Email</th>
	            <th>Total Points</th>
	            <th>Games Played</th>
	            <th>Blocked</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>

	        <tr v-for="user in users"  :key="user.id" :class="{activerow: editingUser === user}">
	            <td>{{ user.name }}</td>
	            <td>{{ user.nickname }}</td>
	            <td>{{ user.email }}</td>
	            <td>{{ user.total_points }}</td>
	            <td>{{ user.total_games_played }}</td>
	            <td v-if="user.blocked == 1">Yes</td>
	            <td v-if="user.blocked == 0">No</td>
	            <td>
	                <a class="waves-effect waves-light btn" v-on:click.prevent="blockUser(user)"><i class="medium material-icons">do_not_disturb</i></a>
	                <a class="waves-effect waves-light btn" v-on:click.prevent="deleteUser(user)"><i class="medium material-icons">delete</i></a>
	            </td>
	        </tr>
	    </tbody>
	</table>

</div>
</template>




<script type="text/javascript">

export default {
	data: function() {
		return{
			users: null,
			editingUser: 0
		}
	},

	methods: {
		getUsers: function() {
			
			var self = this;

			axios.get('http://188.166.86.13/api/users')
			.then(function (response) {
			    self.users = response.data.data;
			});
		},
		deleteUser: function(user){
            axios.delete('http://188.166.86.13/api/users/'+user.id)
                .then(response => {
                    this.getUsers();
                });
		},
		blockUser: function(user) {
			axios.get('http://188.166.86.13/api/users/'+user.id+'/block')
				.then(response => {
					console.log(response);
                    this.getUsers();
                });
		}
	},
	computed:{    
        },
	mounted() {
		this.getUsers();
	}
}

</script>