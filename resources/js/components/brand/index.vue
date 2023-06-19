<template>
    <div class="container-fluid"> 
            <div class="col-lg-12">
                <!-- Category Add -->
                <div class="card shadow mb-4" v-if="!brand_update">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Add Brand</h6>
                    </div>
                    <div class="card-body py-3 d-flex flex-row align-items-center justify-content-between">
                        <form class="" @submit.prevent="addBrand">
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="text" class="form-control" 
                                    placeholder="Name" v-model="form.name">
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="file" class="form-control" @change="onFileSelected">
                            </div>
                           
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <button class="btn btn-primary">
                            Add Brand
                        </button>
                            </div>
                        </div>
                        
                        
                    </form>
                    </div>
                </div>
                <!-- End Category Add -->
                <!-- Category update -->
                <div class="card shadow mb-4" v-else>
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">update Brand</h6>
                    </div>
                    <div class="card-body py-3 d-flex flex-row align-items-center justify-content-between">
                        <form class="" @submit.prevent="updateBrand(form.id)">
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="text" class="form-control" 
                                    placeholder="Name" v-model="form.name">
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <input type="file" class="form-control" @change="onFileSelected">
                            </div>
                           
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <button class="btn btn-primary">
                            Update Brand
                        </button>
                            </div>
                        </div>
                        
                        
                    </form>
                    </div>
                </div>
                <!-- End Category Update -->
                <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">All Brand</h6>
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-primary" @click="editToAdd" v-if="brand_update">
                                            Add Brand
                                        </button>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <label for="">Search</label>
                                    <input type="text" v-model="searchTerm">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="brand in searchData" :key="brand.id">
                                                <td><img :src="brand.image" alt="brand photo"></td>
                                                <td>{{ brand.name }}</td>
                                                <td>
                                                    <a @click="editBrand(brand.id)"><i class="fa fa-pen pr-2"></i></a>
                                                    
                                                    <a @click="deleteBrand(brand.id)"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
            photo:'',
            newPhoto:''
        
        },
        brand_update:false,
        brands:[],
        searchTerm : ''
       }
    },
    computed:{
        searchData(){
           return this.brands.filter(brand=>{return brand.name.match(this.searchTerm)})
        }
    },
    mounted(){
        this.allBrand()
    },
    methods:{
        addBrand(){
            axios.post('/api/brand',this.form)
            .then(res=>{
                this.allBrand()
                this.$router.push({name:'allbrand'})
                Toast.fire({
                    type: 'success',
                    text: 'Brand successfully added',
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
        editBrand(id){
            this.brand_update = true
            
            axios.get('/api/brand/'+id)
            .then(({data})=>{this.form=data})
            .catch(error=>{
                Toast.fire({
                    type: 'warning',
                    text: error.response.data.error,
                    icon: 'error',
                    confirmButtonText: 'Cool'
                    })
            })
            },
            editToAdd(){
            this.brand_update = false
            },
            form_empty(){
               this.form.id='', 
               this.form.name='', 
               this.form.photo=''
            },
        updateBrand(id){
            this.editToAdd()
            axios.patch('/api/brand/'+id,this.form)
            .then(res=>{
                this.allBrand()
                Toast.fire({
                    type: 'success',
                    text: 'Brand successfully updated',
                    icon: 'success',
                    confirmButtonText: 'Cool'
                    })
                    this.form_empty()
                
            })
            //.then(res=>console.log(res.data))
            //.catch(error=>console.log(error.response.data))
            .catch(error=>{
                console.log(error)
                Toast.fire({
                    type: 'warning',
                    text: error,
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
                    if(this.brand_update){
                        this.form.newPhoto = e.target.result
                    }else{
                        this.form.photo = e.target.result
                    }
                    
                    console.log(this.form.newPhoto)
                }
                reader.readAsDataURL(file)
            }
            console.log(e.target.files[0].name);
        },
        allBrand(){
            axios.get('/api/brand')
            .then(({data})=>{this.brands = data; console.log(data)})
            .catch()
            
        },

        deleteBrand(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    console.log(result)
                if (result.value) {
                    axios.delete('/api/brand/'+id)
                    .then(()=>{this.brands = this.brands.filter(brand=>{return brand.id!=id})})
                    .catch( this.$router.push({name:'allbrand'}))
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                    }
                    })
                }
        
    }
}
</script>
<style scoped>
img{
    width: 50px;
    border-radius: 50%;
}
</style>