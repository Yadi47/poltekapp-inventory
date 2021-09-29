
import { SET_REALTIME,SET_REALTIME_SELECTED } from './realtime.types';


const INITIAL_STATE = {
    values: [],
    selected : {}
};

const reducer = (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case SET_REALTIME:
            return {
                ...state, values: action.payload
            };
        case SET_REALTIME_SELECTED:
            return {
                ...state, selected: action.payload
            };
        default: return state;
    }
};
export default reducer;