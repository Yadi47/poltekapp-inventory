import { INCREMENT, DECREMENT } from './counter.types';


export const increaseCounter = (payload) => {

    return {
        type: INCREMENT,
        payload : {
            counter : payload
        }
    };

};

export const decreaseCounter = () => {

    return {
        type: DECREMENT,
    };

};