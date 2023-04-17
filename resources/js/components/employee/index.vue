<template>
    <div class="container-fluid"> 
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">All Employee</h6>
                                    <div class="dropdown no-arrow">
                                        <router-link class="btn btn-primary" to="add-employee">
                                            Add Employee
                                        </router-link>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    
                                </div>
                            </div>
            </div>
        </div>
</template>
<script>
export default{
    created(){
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
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