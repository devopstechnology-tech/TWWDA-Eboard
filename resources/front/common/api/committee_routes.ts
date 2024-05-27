import {compile} from 'path-to-regexp';

export const committeeRoute = compile('api/v1/committees');
export const committeeMemberRoute = compile('api/v1/committees/members');
