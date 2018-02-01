<template>
	<div>
        <p><button class="btn btn-xs btn-failure" v-on:click.prevent="goBack">Return to Lobby</button></p>
        <h2 class="text-center">{{ title }}</h2>
        <div class="text-center" v-if="checkLoaded() == false">
            <h3>Loading...</h3>
        </div>
        <div class="jumbotron" v-if="checkLoaded() == true">
            <h3>Nickname : {{ nickname }}</h3>
            <h3>Name : {{ name }}</h3>
            <h3>Email : {{ email }}</h3>
            <br>
            <button type="button" class="btn waves-effect waves-light" v-on:click="editingUser=true">Edit</button>
            <button type="button" class="btn waves-effect waves-light" v-on:click="editingPassword=true">Change Password</button>
            <button type="button" class="btn waves-effect waves-light" v-on:click="deleteUser=true">Delete Account</button>

        </div>
        <div class="jumbotron" v-if="editingUser">
            <p><em>Type in the fields you want to change.</em></p>
            <div class="form-group">
                <label for="inputNickname">Nickname</label>
                <input
                    type="text" class="form-control" v-model="newNickname"
                    placeholder="Nickname"/>
            </div>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input
                    type="text" class="form-control" v-model="newName"
                    placeholder="Full Name"/>
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                    type="email" class="form-control" v-model="newEmail"
                    placeholder="Email address"/>
            </div>
            <div class="form-group">
                <a class="btn btn-default" v-on:click.prevent="saveUser()">Save</a>
                <a class="btn btn-default" v-on:click.prevent="cancelEdit()">Cancel</a>
            </div>
        </div>
        <div class="jumbotron" v-if="editingPassword">
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
            <a class="btn btn-default" v-on:click.prevent="cancelPassword()">Cancel</a>
        </div>
        <div class="jumbotron" v-if="deleteUser">
            <p><em>Once your account is deleted all data will be lost</em></p>
            <p><em>Are you sure you want to delete?</em></p>
            <a class="btn btn-default" v-on:click.prevent="confirmDelete()">I'm sure</a>
            <a class="btn btn-default" v-on:click.prevent="cancelDelete()">Cancel</a>
        </div>
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
    </div>
</template>

<script type="text/javascript">
    export default {
            data: function(){
                return {
                    title: "My Profile",
                    nickname: "Loading...",
                    name: "Loading...",
                    email: "Loading...",
                    newNickname: "Loading...",
                    newName: "Loading...",
                    newEmail: "Loading...",
                    newPassword: "",
                    oldPassword: "",
                    editingUser: false,
                    editingPassword : false,
                    showSuccess: false,
                    successMessage: " ",
                    showError: false,
                    errorMessage: " ",
                    deleteUser: false,
                }
            },
            methods: {
                goBack(){
                    this.$router.push('multitictactoe');
                },
                checkLoaded(){
                    return !(this.nickname === 'Loading...');
                },
                saveUser(){
                    var AuthStr = 'Bearer '.concat(this.$auth.getToken());
                    var self = this;
                    axios.put('http://exame.test/api/user/profile',
                    {
                        name: self.newName,
                        email: self.newEmail,
                        nickname: self.newNickname,
                    },
                    {
                        headers: { 'Authorization': AuthStr,
                                   'Content-Type': 'application/json',
                                   'Accept': 'application/json' }
                    }).then(function(response){
                        self.editingUser = false;
                        self.showSuccess = true;
                        self.showError = false;
                        self.successMessage = "User profile updated successfully";
                        self.loadPlayer();
                    }).catch((error) => {
                        self.editingUser = false;
                        self.showSuccess = false;
                        self.showError = true;
                        self.errorMessage = "Unable to update user profile";
                        self.loadPlayer();
                    });
                },
                savePassword(){
                    var AuthStr = 'Bearer '.concat(this.$auth.getToken());
                    var self = this;
                    axios.put('http://exame.test/api/user/pass',
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
                            //self.editingPassword = false;
                            self.showSuccess = false;
                            self.showError = true;
                            self.errorMessage = "Unable to update password";
                            self.oldPassword = "";
                            self.newPassword = "";
                            self.loadPlayer();
                        }else{
                            self.editingPassword = false;
                            self.showSuccess = true;
                            self.showError = false;
                            self.successMessage = "Password updated successfully";
                            self.oldPassword = "";
                            self.newPassword = "";
                            self.loadPlayer();
                        }
                    }).catch((error) => {
                        self.editingPassword = false;
                        self.showSuccess = false;
                        self.showError = true;
                        self.errorMessage = "Unable to update password";
                        self.oldPassword = "";
                        self.newPassword = "";
                        self.loadPlayer();
                        console.log(error);
                    });
                },
                confirmDelete(){
                    var AuthStr = 'Bearer '.concat(this.$auth.getToken());
                    var self = this;
                    axios.delete('http://exame.test/api/user',
                    {
                        headers: { 'Authorization': AuthStr}
                    }).then(function(response){
                        self.$router.push('/');
                        self.$auth.destroyToken();
                        console.log(response.data);
                    }).catch((error) => {
                        self.deleteUser = false;
                        self.showSuccess = false;
                        self.showError = true;
                        self.errorMessage = "Unable to delete user profile";
                        console.log(error);
                    });
                },
                cancelEdit(){
                    this.showSuccess = false;
                    this.showError = false;
                    this.editingUser = false;
                    this.newName =  this.name;
                    this.newNickname =  this.nickname;
                    this.newEmail =  this.email;
                },
                cancelPassword(){
                    this.showSuccess = false;
                    this.showError = false;
                    this.editingPassword = false;
                    this.newPassword =  "";
                    this.oldPassword =  "";
                },
                cancelDelete(){
                    this.deleteUser = false;
                },
                loadPlayer(){
                    var AuthStr = 'Bearer '.concat(this.$auth.getToken());
                    axios.get('http://exame.test/api/user', {headers: { Authorization: AuthStr} })
                    .then(response => {
                        this.name =  response.data.name;
                        this.nickname =  response.data.nickname;
                        this.email =  response.data.email;
                        this.newName =  response.data.name;
                        this.newNickname =  response.data.nickname;
                        this.newEmail =  response.data.email;
                    })
                    .catch((error) => {
                        this.nickname = 'Error';
                    });
                },
            },
            mounted() {
                this.loadPlayer();
            }
    }
</script>