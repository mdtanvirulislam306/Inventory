<template>
    <div class="container"> 
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                     <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                         <h6 class="m-0 font-weight-bold text-primary">Update Employee</h6>
                           <div class="dropdown no-arrow">
                              <router-link class="btn btn-primary" to="/employee">
                                    all Employee
                                </router-link>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form class="user" @submit.prevent="updateEmployee">
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="text" class="form-control" 
                                    placeholder="Name" v-model="form.name">
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="email" class="form-control" 
                                placeholder="Email Address" v-model="form.email">
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="text" class="form-control" 
                                placeholder="Address" v-model="form.address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="text" class="form-control" 
                                placeholder="Salary" v-model="form.salary">
                            </div>
                            
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="text" class="form-control" 
                                placeholder="Number" v-model="form.number">
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="text" class="form-control" 
                                placeholder="NID" v-model="form.nid">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="file" class="form-control" @change="onFileSelected">
                            </div>
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <img :src="form.photo" class="img-thumbnail" style="width: 200px;height: 200;">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="date" class="form-control" v-model="form.joining_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                           
                        </div>
                        </div>
                        <button class="btn btn-primary btn-block">
                            Update Employee
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
            name:'',
            email:'',
            salary:'',
            address:'',
            number:'',
            photo:'',
            newPhoto:'',
            nid:'',
            joinig_date:''
        }
       }
    },
    methods:{
        updateEmployee(){
            let id = this.$route.params.id
            axios.patch('/api/employee/'+id,this.form)
            .then(res=>{
                this.$router.push({name:'allemployee'})
                Toast.fire({
                    type: 'success',
                    text: 'Employee successfully Updated',
                    icon: 'success',
                    confirmButtonText: 'Cool'
                    })
                
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
        onFileSelected(e){
            let file =  e.target.files[0]
            if(file.size>1048785){
                Toast.fire({
                    type: 'warning',
                    text: 'File size must be less than 1MB',
                    confirmButtonText: 'Cool'
                    })
            }else{
                let reader = new FileReader();
                reader.onload = e=>{
                    this.form.newPhoto = e.target.result
                    console.log(e.target.result)
                }
                reader.readAsDataURL(file)
            }
            console.log(e.target.files[0].name);
        }
    },
    mounted(){
        let id = this.$route.params.id
            axios.get('/api/employee/'+id)
            .then(({data})=>{this.form=data;console.log(data)})
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
</script>