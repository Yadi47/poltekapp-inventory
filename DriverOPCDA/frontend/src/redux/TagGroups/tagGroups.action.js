
import {SET_TAG_GROUP,SET_TAG_GROUP_TAGS } from './tagGroups.types';


export const setTagGroup = (payload) => {
    return {
        type: SET_TAG_GROUP,
        payload
    };
};

export const setTagGroupTags = (payload) => {
    return {
        type: SET_TAG_GROUP_TAGS,
        payload
    };
};

