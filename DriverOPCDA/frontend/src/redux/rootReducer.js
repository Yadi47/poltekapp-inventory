import { combineReducers } from 'redux';
import counterReducer from './Counter/counter.reducer';
import tagGroupsReducer from './TagGroups/tagGroups.reducer';
import userLogin from './UserLogin/userLogin.reducer';
import realtimeValuesReducer from './Realtime/realtime.reducer';

const rootReducer = combineReducers({

    counter: counterReducer,
    state_tag_group: tagGroupsReducer,
    state_realtime_values: realtimeValuesReducer,
    auth: userLogin,

});

export default rootReducer;