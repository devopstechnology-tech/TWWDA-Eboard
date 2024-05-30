import {IconDefinition} from '@fortawesome/free-solid-svg-icons';

export interface Data {
    name: string,
    value: number
}

export type dataType = {
    annotations?: object,
    title: string,
    ytitle?: string,
    series: SeriesData[],
    categories: string[],
}
export type SeriesData = {
    name: string,
    data: number[]
}

export interface response {
    code: number,
    data: Data[],
    message: string
}

export interface graphResponse {
    code: number,
    data: {
        series: SeriesData[],
        categories: string[],
        title: string,
        ytitle?: string,
        annotations?: object,
    },
    message: string
}

export interface SelectItem {
    name: string,
    value: string
}

export type Meta = {
    current_page: number,
    from: number,
    last_page: number,
    per_page: number,
    total: number,
    to: number,
}

export interface CartItem {
    name: string,
    item_id?: number,
    sub_county_id: number,
    ward_id: number,
    class_id: number,
    quantity: number,
    value?: string,
    id: number,
    amount: number,
}

export interface AuthenticateRequestPayload {
    email: string;
    password: string;
    remember: boolean;
}
export interface ForgotPasswordPayload {
    email: string;
}
export interface ChangePasswordPayload {
    otp: string;
    password: string;
    token: string;
}
export interface metaRouteDetails {
    permissions?: string[];
}

export interface menulink {
    title?: string,
    sub_title?: string,
    icon?: IconDefinition,
    to?: symbol,
    open?: boolean,
    children?: menulink[],
    meta?: metaRouteDetails,
}
