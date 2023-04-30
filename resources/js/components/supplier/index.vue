<template>
    <div class="container-fluid"> 
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">All Supplier</h6>
                                    <div class="dropdown no-arrow">
                                        <router-link class="btn btn-primary" to="add-supplier">
                                            Add Supplier
                                        </router-link>
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
                                                <th>Email</th>
                                                <th>Number</th>
                                                <th>Address</th>
                                                <th>NID</th>
                                                <th>Shop</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="supplier in searchData" :key="supplier.id">
                                                <td><img :src="supplier.photo" alt="supplier photo"></td>
                                                <td>{{ supplier.name }}</td>
                                                <td>{{ supplier.email }}</td>
                                                <td>{{ supplier.number }}</td>
                                                <td>{{ supplier.address }}</td>
                                                <td>{{ supplier.nid }}</td>
                                                <td>{{ supplier.shop_name }}</td>
                                                <td>
                                                    <router-link :to="{name:'editSupplier',params:{id:supplier.id}}"><i class="fa fa-pen pr-2"></i></router-link>
                                                    
                                                    <a @click="deleteSupplier(supplier.id)"><i class="fa fa-trash"></i></a>
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
        suppliers:[],
        searchTerm : ''
       }
    },
    computed:{
        searchData(){
           return this.suppliers.filter(supplier=>{return supplier.number.match(this.searchTerm)||supplier.name.match(this.searchTerm)})
        }
    },
    mounted(){
        this.allSupplier()
    },
    methods:{
        allSupplier(){
            axios.get('/api/supplier')
            .then(({data})=>{this.suppliers = data; console.log(data)})
            .catch()
            
        },

        deleteSupplier(id){
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
                    axios.delete('/api/supplier/'+id)
                    .then(()=>{this.suppliers = this.suppliers.filter(supplier=>{return supplier.id!=id})})
                    .catch( this.$router.push({name:'allsupplier'}))
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