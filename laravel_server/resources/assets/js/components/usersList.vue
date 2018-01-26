<template>
	<div>
	
	<h2>BlackJack App Users</h2>
	
	<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>Name</th>
	            <th>Nickname</th>
	            <th>Email</th>
	            <th>Blocked</th>
	            <th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>

	        <tr v-for="user in users"  :key="user.id" :class="{activerow: editingUser === user}">
	            <td>{{ user.name }}</td>
	            <td>{{ user.nickname }}</td>
	            <td>{{ user.email }}</td>
	            <td>{{ user.blocked }}</td>
	            <td>
	                <a class="btn btn-xs btn-danger" v-on:click.prevent="blockUser(user)">Block</a>
	                <a class="btn btn-xs btn-danger" v-on:click.prevent="deleteUser(user)">Delete</a>
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

			axios.get('http://exame.test/api/users')
			.then(function (response) {
			    console.log(response.data.data);
			    self.users = response.data.data;
			    console.log("-------USERS------" );
			    console.log(self.users);
			});
		},
		deleteUser: function(user){
            axios.delete('http://exame.test/api/users/'+user.id)
                .then(response => {
                    this.getUsers();
                });
		},
		blockUser: function(user) {
			axios.get('http://exame.test/api/users/'+user.id+'/block')
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