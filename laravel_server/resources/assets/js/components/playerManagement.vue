<template>
	<div>
        <h1>UserProfile</h1>
        <div class="jumbotron">
            <div class="form-group">
                <label for="inputNickname">Nickname</label>
                <input
                    type="text" class="form-control" v-model="nickname"
                    name="nickname" id="inputNickname" 
                    placeholder="Nickname"/>
            </div>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input
                    type="text" class="form-control" v-model="name"
                    name="name" id="inputName" 
                    placeholder="Full Name"/>
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                    type="email" class="form-control" v-model="email"
                    name="email" id="inputEmail"
                    placeholder="Email address"/>
            </div>
            <div class="form-group">
                <a class="btn btn-default" v-on:click.prevent="saveUser()">Save</a>
                <a class="btn btn-default" v-on:click.prevent="cancelEdit()">Cancel</a>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
            data: function(){
                return {
                    nickname: "Jorge",
                    name: "Jorge Gabriel",
                    email: "jorge.gabriel@example.com",
                    newPassword: " ",
                    password: "**********",
                }
            },
            methods: {
                saveUser(){

                },
                cancelEdit(){

                }
            },
            mounted() {
                //this.playerName();
            }
    }
</script>