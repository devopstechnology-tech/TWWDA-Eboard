import {compile} from 'path-to-regexp';

export const agendaRoute = compile('api/v1/agendas');
export const meetingAgendasRoute = compile('api/v1/agendas/meeting');
export const agendaMemberRoute = compile('api/v1/agendas/members');



