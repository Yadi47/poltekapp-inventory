
import { SET_USER_AUTH, SET_USER_TOKEN, SET_IS_AUTH} from "./userLogin.types"
export const setUserAuth = (payload) =>{
    return{
        type: SET_USER_AUTH,
        payload 
    }
}
export const setUserToken = (payload) =>{
    return{
        type: SET_USER_TOKEN,
        payload 
    }
}
export const setIsAuth = (payload) =>{
    return{
        type: SET_IS_AUTH,
        payload 
    }
}