<template>
    <div class="container-fluid"> 
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                     <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                         <h6 class="m-0 font-weight-bold text-primary">Add Employee</h6>
                           <div class="dropdown no-arrow">
                              <router-link class="btn btn-primary" to="/employee">
                                    all Employee
                                </router-link>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form class="user" @submit.prevent="signup">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control" id="exampleFirstName"
                                    placeholder="First Name" v-model="form.name">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="email" class="form-control" id="exampleInputEmail"
                                placeholder="Email Address" v-model="form.email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control" id="exampleInputEmail"
                                placeholder="Salary" v-model="form.salary">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control" id="exampleInputEmail"
                                placeholder="Address" v-model="form.address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="file" class="form-control" @change="onFileSelected">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="date" class="form-control" v-model="form.address">
                            </div>
                        </div>
                        <div class="form-group row">
                           <img :src="form.photo" class="thumnail">
                        </div>
                        <button class="btn btn-primary btn-block">
                            Register Account
                        </button>
                        
                    </form>
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
            salary:null,
            address:null,
            photo:null,
            nid:null,
            joinig_date:null
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
        },
        onFileSelected(){}
    }
}
</script>