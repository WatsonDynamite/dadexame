<template>
	<div>
		<div class="alert alert-success" v-if="showSuccess">
            <strong>
                {{ successMessage }}
            </strong>
        </div>
        <div class="alert alert-danger" v-if="showError">
            <strong>
                {{ errorMessage }}
            </strong>
        </div>
		<div class="jumbotron">
            <p><em>In order to change your password, you must type your current one.</em></p>
            <div class="form-group">
                <label for="inputPassword">New Password</label>
                <input
                    type="password" class="form-control" v-model="newPassword"
                    placeholder=""/>
            </div>
            <div class="form-group">
                <label for="inputPasswordOld">Old Password</label>
                <input
                    type="text" class="form-control" v-model="oldPassword"
                    placeholder=""/>
            </div>
            <a class="btn btn-default" v-on:click.prevent="savePassword()">Save</a>
        </div>
	</div>
</template>

<script type="text/javascript">
    export default {
            data: function(){
                return {
                	newPassword: "",
                    oldPassword: "",
                    showSuccess: false,
	                successMessage: " ",
	                showError: false,
	                errorMessage: " ",
                }
            },
            methods: {
            	savePassword(){
                    var AuthStr = 'Bearer '.concat(this.$auth.getToken());
                    var self = this;
                    axios.put('http://188.166.86.13/api/user/pass',
                    {
                        newPassword: self.newPassword,
                        oldPassword: self.oldPassword
                    },
                    {
                        headers: { 'Authorization': AuthStr,
                                   'Content-Type': 'application/json',
                                   'Accept': 'application/json' }
                    }).then(function(response){
                        if(response.data == "Wrong Password"){
                            self.showSuccess = false;
                            self.showError = true;
                            self.errorMessage = "Unable to update password";
                            self.oldPassword = "";
                            self.newPassword = "";
                        }else{
                            self.showSuccess = true;
                            self.showError = false;
                            self.successMessage = "Password updated successfully";
                            self.oldPassword = "";
                            self.newPassword = "";
                        }
                    }).catch((error) => {
                        self.showSuccess = false;
                        self.showError = true;
                        self.errorMessage = "Unable to update password";
                        self.oldPassword = "";
                        self.newPassword = "";
                    });
                },
                mounted() {

           		}
            }
        }
</script>