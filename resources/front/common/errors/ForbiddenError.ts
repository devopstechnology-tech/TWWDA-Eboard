export default class ForbiddenError extends Error {
    public readonly name = 'ForbiddenError';

    constructor(public readonly permissions: string[]) {
        super('You lack the permission to access this page.');
    }
}
