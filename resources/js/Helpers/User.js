import Token from './Token'
import AppStorage from './AppStorage'

class User {

    responseAfterLogin(res){
        const access_token = res.data.access_token
        const username = res.data.user
        if(Token.isValid(access_token)){
            AppStorage.store(access_token,username)
        }
    }
    hasToken(){
        const storeToken = localStorage.getItem('token')
        if(storeToken){
            return Token.isValid(storeToken)?true:false
        }
        false
    }
    loggedin(){
        return this.hasToken()
    }
    logout(){
        AppStorage.clear()
    }
    name(){
        if(this.loggedin()){
            return localStorage.getItem('user')
        }
    }

    id(){
        if(this.loggedin){
            const payload =  Token.payload(localStorage.getItem('token'))
            return payload.sub
        }
        false
    }
}

export default User = new User()