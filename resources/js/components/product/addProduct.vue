<template>
    <div class="container"> 
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                     <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                         <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
                           <div class="dropdown no-arrow">
                              <router-link class="btn btn-primary" to="/product">
                                    All Products
                                </router-link>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form class="user" @submit.prevent="addProduct">
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <label for="" class="form-label">Product Name</label>
                                <input type="text" class="form-control" v-model="form.product_name">
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <label for="" class="form-label">Supplier Name</label>
                                <select class="form-select" placeholder="Name" v-model="form.supplier_id" aria-label="Default select example">
                                <option selected> select Supplier</option>
                                <option v-for="supplier in suppliers" :value="supplier.id" :key="supplier.id">{{supplier.supplier_name}}</option>
                                </select>
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <label for="" class="form-label">Category Name</label>
                                <select class="form-select" v-model="form.category_id" aria-label="Default select example">
                                <option selected>select Category</option>
                                <option v-for="category in categories" :value="category.id" :key="category.id">{{category.category_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <label for="" class="form-label">Brand Name</label>
                                <select class="form-select" v-model="form.brand_id" aria-label="Default select example">
                                <option selected>select brand</option>
                                <option v-for="brand in brands" :value="brand.id" :key="brand.id">{{brand.brand_name}}</option>
                                </select>
                            </div>
                            
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <label for="" class="form-label">Purchase Price</label>
                                <input type="text" class="form-control"  v-model="form.purchase_price">
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <label for="" class="form-label">Selling Price</label>
                                <input type="text" class="form-control" v-model="form.selling_price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <label for="" class="form-label">Quantity</label>
                                <input type="text" class="form-control" v-model="form.qty">
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <label for="" class="form-label">Purchase Date</label>
                                <input type="date" class="form-control" v-model="form.purchase_date">
                            </div>
                            <div class="col-sm-4 mb-3 mb-sm-0">
                                <label for="" class="form-label">Selling Date</label>
                                <input type="date" class="form-control" v-model="form.selling_date">
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
                        <button class="btn btn-primary btn-block">
                            Add Product
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
        suppliers:[],
        categories:[],
        brands:[],
        form:{
            product_name:null,
            supplier_id:null,
            category_id:null,
            brand_id:null,
            purchase_price:null,
            selling_price:null,
            qty:null,
            purchase_date:null,
            expair_date:null,
            photo:'https://avatarairlines.com/wp-content/uploads/2020/05/Male-placeholder.jpeg',
        }
       }
    },
    mounted(){
        this.allSupplier()
        this.allCategory()
        this.allBrands()
    },
    methods:{
        addProduct(){
            console.log(this.form)
            axios.post('/api/product',this.form)
            .then(res=>{
                this.$router.push({name:'allproduct'})
                Toast.fire({
                    type: 'success',
                    text: 'Product successfully added',
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
        allSupplier(){
            axios.get('/api/supplier')
            .then(({data})=>{this.suppliers = data; console.log(data)})
            .catch()
            
        },
        allCategory(){
            axios.get('/api/category')
            .then(({data})=>{this.categories = data; console.log(data)})
            .catch()
            
        },
        allBrands(){
            axios.get('/api/brand')
            .then(({data})=>{this.brands = data; console.log(data)})
            .catch()
            
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
        }
    }
}
</script>