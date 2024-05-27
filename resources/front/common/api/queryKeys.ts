import {compile} from 'path-to-regexp';

export const getBillsKeys = 'get_sub_counties';
export const getSubCountiesKey = 'get_sub_counties';
export const postSubCountiesKey = 'post_sub_counties';
export const showSubCountiesKey = compile<{
    sub_county: string | number;
}>('get_sub_counties/:sub_county');
export const getSubCountyWardsKey = compile<{
    sub_county: string | number;
}>('get_sub_counties/:sub_county/wards');
export const updateSubCountiesKey = compile<{
    sub_county: string | number;
}>('update_sub_counties/:sub_county');
