
import { INCREMENT, DECREMENT } from './counter.types';


const INITIAL_STATE = {
    count: 9,
};

const reducer = (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case INCREMENT:
            return {
                ...state, count: action.payload.counter,
            };
        case DECREMENT:
            return {
                ...state, count: state.count - 1,
            };
        default: return state;

    }

};

export default reducer;