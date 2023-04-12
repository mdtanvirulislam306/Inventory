<template>

</template>
<script>
export default {
    created(){
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
        }
    }
}
</script>