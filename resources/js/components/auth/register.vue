<template>
    <div class="container">

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                    </div>
                    <form class="user" @submit.prevent="signup">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                    placeholder="First Name" v-model="form.name">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                placeholder="Email Address" v-model="form.email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user"
                                    id="exampleInputPassword" placeholder="Password" v-model="form.password">
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user"
                                    id="exampleRepeatPassword" placeholder="Repeat Password" v-model="form.password_confirmation">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-user btn-block">
                            Register Account
                        </button>
                        <hr>
                        <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                            <i class="fab fa-google fa-fw"></i> Register with Google
                        </a>
                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                            <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                        </a> -->
                    </form>
                    <hr>
                    <div class="text-center">
                        <router-link to="/forgot" class="small">Forgot Password?</router-link>
                    </div>
                    <div class="text-center">
                        <router-link to="/" class="small">Already have an account? Login!</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</template>
<script>
export default{
    created(){
        if(User.loggedIn()){
            this.$router.push({name:'home'})
        }
    },
    data(){ 
       return{
        form:{
            name:null,
            email:null,
            password:null,
            password_confirmation:null
        }
       }
    },
    methods:{
        signup(){
            axios.post('/api/auth/signup',this.form)
            .then(res=>{
                User.responseAfterLogin(res)
                Toast.fire({
                    type: 'success',
                    text: 'Successfully registered!!',
                    confirmButtonText: 'Cool'
                    })
                this.$router.push({name:'home'})
            })
            //.then(res=>console.log(res.data))
            //.catch(error=>console.log(error.response.data))
            .catch(error=>{
                Toast.fire({
                    type: 'warning',
                    text: error.response.data.error,
                    icon: 'error',
                    confirmButtonText: 'Cool'
                    })
            })
        }
    }
}
</script>