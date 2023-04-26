<template>
    <div class="container"> 
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                     <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                         <h6 class="m-0 font-weight-bold text-primary">Update Supplier</h6>
                           <div class="dropdown no-arrow">
                              <router-link class="btn btn-primary" to="/supplier">
                                    All Supplier
                                </router-link>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form class="user" @submit.prevent="updateSupplier">
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
                                placeholder="Shop Name" v-model="form.shop_name">
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
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                           
                        </div>
                        </div>
                        <button class="btn btn-primary btn-block">
                            Update Supplier
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
    mounted(){
        let id = this.$route.params.id
        
            axios.get('/api/supplier/'+id)
            .then(({data})=>{this.form=data;console.log(data)})
            .catch(error=>{
                Toast.fire({
                    type: 'warning',
                    text: error.response.data.error,
                    icon: 'error',
                    confirmButtonText: 'Cool'
                    })
            })
    },
    data(){ 
       return{
        form:{
            name:'',
            email:'',
            address:'',
            number:'',
            photo:'',
            newPhoto:'',
            nid:'',
            shop_name:''
        }
       }
    },
    methods:{
        
        updateSupplier(){
            let id = this.$route.params.id
            axios.patch('/api/supplier/'+id,this.form)
            .then(res=>{
                this.$router.push({name:'allsupplier'})
                Toast.fire({
                    type: 'success',
                    text: 'Supplier successfully updated',
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
    }
}
</script> 