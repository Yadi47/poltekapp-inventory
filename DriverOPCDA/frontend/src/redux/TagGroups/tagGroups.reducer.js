
import { SET_TAG_GROUP,SET_TAG_GROUP_TAGS } from './tagGroups.types';


const INITIAL_STATE = {
    TagGroup : {
        "init":123
    },
    TagGroupTags: [0],
};

const reducer = (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case SET_TAG_GROUP:
            return {
                ...state, TagGroup: action.payload
            };
            
        case SET_TAG_GROUP_TAGS:
            return {
                ...state, TagGroupTags: action.payload
            };
        default: return state;
    }

};

export default reducer;