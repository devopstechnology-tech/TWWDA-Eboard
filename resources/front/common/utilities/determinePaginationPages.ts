import {PaginationMeta} from '@/common/parsers/paginatedParser';

export default function determinePaginationPages(
    pagination: PaginationMeta,
    distanceFromCurrent: number,
): Array<number|undefined> {
    // firstPage (1 item) + distanceFromCurrent + currentPage (1 item) + distanceFromCurrent + lastPage (1 item)
    const maxDisplayedPages = 1 + distanceFromCurrent + 1 + distanceFromCurrent + 1;

    if (maxDisplayedPages > pagination.last_page) {
        return Array.from({length: pagination.last_page}, (_, i) => i + 1);
    }

    const dynamicDisplayedPageCount = maxDisplayedPages - 2;

    const fillFrom = pagination.current_page + distanceFromCurrent >= pagination.last_page - 1
        ? pagination.last_page - dynamicDisplayedPageCount
        : Math.max(2, pagination.current_page - distanceFromCurrent);

    const pages = Array.from({length: dynamicDisplayedPageCount}, (_, i) => {
        const page = i + fillFrom;

        if (i === 0 && page !== 2) {
            return undefined;
        }

        if (i === dynamicDisplayedPageCount - 1 && page !== pagination.last_page - 1) {
            return undefined;
        }

        return page;
    });

    pages.unshift(1);
    pages.push(pagination.last_page);

    return pages;
}
