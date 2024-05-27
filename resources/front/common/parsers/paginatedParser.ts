import {array, number, object, output, ZodType} from 'zod';

const paginationMetaParser = object({
    current_page: number(),
    from: number(),
    last_page: number(),
    per_page: number(),
    total: number(),
    to: number(),
});

export type PaginationMeta = output<typeof paginationMetaParser>;

export interface PaginatedResponse<ResourceType> {
    data: ResourceType[];
    meta: PaginationMeta;
}
export interface response<ResourceType> {
    code: number,
    data: {
        data: ResourceType[],
        meta:PaginationMeta
    },
    message: string
}

export function createPaginatedResponseParser<ResourceType extends ZodType>(dataParser: ResourceType) {
    return object({
        data: array(dataParser),
        meta: paginationMetaParser,
    });
}
