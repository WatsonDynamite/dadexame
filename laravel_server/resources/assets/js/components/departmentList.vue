<template>
	<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>Name</th>
	            <th>Date</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr v-for="department in departments"  :key="department.id">
                <td>{{ department.name }}</td>
                <td>{{ department.date }}</td>
	        </tr>
	    </tbody>
	</table>
</template>

<script type="text/javascript">
	// Component code (not registered)
	module.exports={
		data: function () {
			return {
				departments: []
			}
		},
        mounted(){
			if (this.$root.departments.length === 0) {
				axios.get('api/departments')
  					.then(response=>{
  						this.$root.departments = response.data.data; 
  						this.departments = this.$root.departments;
  					})
  			} else {
  				this.departments = this.$root.departments;
  			}
        }
	}
</script>

<style scoped>
/*	  Specific style applied only on the component*/
</style>