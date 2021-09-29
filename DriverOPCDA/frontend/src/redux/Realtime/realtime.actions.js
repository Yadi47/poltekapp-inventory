
import { SET_REALTIME,SET_REALTIME_SELECTED } from './realtime.types';


export const setRealtime = (payload) => {
    return {
        type: SET_REALTIME,
        payload
    };
};
export const setSelectedRealtime = (payload) => {
    return {
        type: SET_REALTIME_SELECTED,
        payload
    };
};

