import {QueryClient} from '@tanstack/vue-query';
import {Duration} from 'luxon';

const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            refetchOnMount: false,
            retry: false,
            staleTime: Duration.fromObject({seconds: 30}).toMillis(),
            useErrorBoundary: true,
        },
    },
});

export default queryClient;
