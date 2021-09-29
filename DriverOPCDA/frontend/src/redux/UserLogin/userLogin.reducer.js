import { SET_USER_AUTH, SET_USER_TOKEN, SET_IS_AUTH } from "./userLogin.types"

const INITIAL_STATE = {
    isAuth : false,
    token:"",
    userAuth: {
    },
};

const reducer = (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case SET_USER_AUTH:
            return {
                ...state,userAuth:action.payload
            }
        case SET_USER_TOKEN:
            return {
                ...state,token:action.payload
            }
        case SET_IS_AUTH:
            return {
                ...state, isAuth:action.payload
            }
        default: return state
    }
}



export default reducer;