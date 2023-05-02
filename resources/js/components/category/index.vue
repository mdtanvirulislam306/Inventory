<template>
    <div class="container-fluid"> 
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Add Category</h6>
                    </div>
                    <div class="card-body py-3 d-flex flex-row align-items-center justify-content-between">
                        <form class="" @submit.prevent="addCategory">
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
                            Add Category
                        </button>
                            </div>
                        </div>
                        
                        
                    </form>
                    </div>
                </div>
                <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">All Category</h6>
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
                                                <th>Created_at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="category in searchData" :key="category.id">
                                                <td><img :src="category.image" alt="category photo"></td>
                                                <td>{{ category.name }}</td>
                                                <td>{{ category.created_at }}</td>
                                                <td>
                                                    <router-link :to="{name:'editSupplier',params:{id:category.id}}"><i class="fa fa-pen pr-2"></i></router-link>
                                                    
                                                    <a @click="deleteCategory(category.id)"><i class="fa fa-trash"></i></a>
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
        
        },
        categories:[],
        searchTerm : ''
       }
    },
    computed:{
        searchData(){
           return this.categories.filter(category=>{return category.name.match(this.searchTerm)})
        }
    },
    mounted(){
        this.allCategory()
    },
    methods:{
        addCategory(){
            axios.post('/api/category',this.form)
            .then(res=>{
                this.allCategory()
                this.$router.push({name:'allcategory'})
                Toast.fire({
                    type: 'success',
                    text: 'Category successfully added',
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
                    this.form.photo = e.target.result
                    console.log(e.target.result)
                }
                reader.readAsDataURL(file)
            }
            console.log(e.target.files[0].name);
        },
        allCategory(){
            axios.get('/api/category')
            .then(({data})=>{this.categories = data; console.log(data)})
            .catch()
            
        },

        deleteCategory(id){
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
                    axios.delete('/api/category/'+id)
                    .then(()=>{this.categories = this.categories.filter(category=>{return category.id!=id})})
                    .catch( this.$router.push({name:'allcategory'}))
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