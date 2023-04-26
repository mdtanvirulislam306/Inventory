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
                                                <th>Salary</th>
                                                <th>Joining Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="employee in searchData" :key="employee.id">
                                                <td><img :src="employee.photo" alt="employee photo"></td>
                                                <td>{{ employee.name }}</td>
                                                <td>{{ employee.email }}</td>
                                                <td>{{ employee.number }}</td>
                                                <td>{{ employee.address }}</td>
                                                <td>{{ employee.nid }}</td>
                                                <td>{{ employee.salary }}</td>
                                                <td>{{ employee.joining_date }}</td>
                                                <td>
                                                    <router-link :to="{name:'editEmployee',params:{id:employee.id}}" class="btn btn-info" >Edit</router-link>
                                                    <button @click="deleteEmployee(employee.id)" class="btn btn-danger" >Delete</button>
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
        employees:[],
        searchTerm : ''
       }
    },
    computed:{
        searchData(){
           return this.employees.filter(employee=>{return employee.number.match(this.searchTerm)||employee.name.match(this.searchTerm)})
        }
    },
    mounted(){
        this.allEmployee()
    },
    methods:{
        allEmployee(){
            axios.get('/api/employee')
            .then(({data})=>{this.employees = data; console.log(data)})
            .catch()
            
        },
        deleteEmployee(id){
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
        axios.delete('/api/employee/'+id)
        .then(()=>{this.employees = this.employees.filter(employee=>{return employee.id!=id})})
        .catch( this.$router.push({name:'allemployee'}))
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