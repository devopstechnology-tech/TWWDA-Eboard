import {array, nullable,object, string} from 'zod';

export const mediaRequestParser= object({
    collection_name: string().nullable(),
    conversions_disk: string().nullable(),
    created_at: string().nullable(),
    custom_properties: array(string()).nullable(), // Assuming custom_properties is an array of strings
    deleted_at: nullable(string()).nullable(),
    disk: string().nullable(),
    file_name: string().nullable(),
    generated_conversions: array(string()).nullable(), // Assuming generated_conversions is an array of strings
    id: string().nullable(),
    manipulations: array(string()).nullable(), // Assuming manipulations is an array of strings
    mime_type: string().nullable(),
    model_id: string().nullable(),
    model_type: string().nullable(),
    name: string().nullable(),
    order_column: string().nullable(),
    original_url: string().nullable(),
    preview_url: nullable(string()).nullable(),
    responsive_images: array(string()).nullable(), // Assuming responsive_images is an array of strings
    size: string().nullable(),
    updated_at: string().nullable(),
    uuid: string().nullable(),
});
