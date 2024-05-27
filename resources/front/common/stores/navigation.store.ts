import {
    faBank,
    faBookAtlas,
    faBowlFood,
    faCheck,
    faDashboard,
    faEye,
    faHomeAlt,
    faHomeLg,
    faHospital,
    faHourglassStart,
    faIcons,
    faLandmark,
    faList,
    faMapMarked,
    faMobileAndroid,
    faMoneyBill,
    faMoneyBillTransfer,
    faMoneyBillTrendUp,
    faMoneyBillWheat,
    faMoneyCheck,
    faShield,
    faUserAlt,
    faUsers,
    faWineBottle,
} from '@fortawesome/free-solid-svg-icons';
import {defineStore, storeToRefs} from 'pinia';
import {computed, ref} from 'vue';
import {
    STAFF_APPLY_LIQUOR_LICENCE,
    STAFF_APPROVALS,
    STAFF_BUSINESS_REGISTRY,
    STAFF_CESS,
    STAFF_CHECK_LIQUOR_LICENCE,
    STAFF_FINES_AND_PENALTIES,
    STAFF_FOOD_HANDLERS_CERT,
    STAFF_FOOD_HEALTH_INSPECTION,
    STAFF_FOOD_HYGIENE_LICENCE,
    STAFF_HOSPITAL_REGISTRY,
    STAFF_HOUSE_REGISTRY,
    STAFF_ITEM_ZONES,
    STAFF_ITEMS,
    STAFF_LAND_BILLS,
    STAFF_LAND_REGISTRY,
    STAFF_MAIN,
    STAFF_MARKET_REGISTRY,
    STAFF_PARKING,
    STAFF_PERMISSIONS,
    STAFF_POS_DEVICE,
    STAFF_ROLE_PERMISSIONS,
    STAFF_ROLES,
    STAFF_SBP,
    STAFF_SCHEDULES,
    STAFF_SECTIONS,
    STAFF_STALL_REGISTRY,
    STAFF_USER_CITIZEN,
    STAFF_USER_ROLES,
    STAFF_USER_STAFF,
} from '@/common/constants/staffRouteNames';
import {Permission} from '@/common/parsers/permissionParser';
import authStore from '@/common/stores/auth.store';
import {menulink} from '@/common/types/types';

const {user} = storeToRefs(authStore());
const useNavigationStore = defineStore('navigation', () => {
    const navItems = ref<menulink[]>(
        [
            {
                title: 'Dashboard',
                icon: faDashboard,
                to: STAFF_MAIN,
                meta: {
                    permissions: [],
                },
            },
            {
                title: 'Approval Requests',
                icon: faCheck,
                to: STAFF_APPROVALS,
            },
            {
                title: 'Fines and Penalties',
                icon: faMoneyBillWheat,
                to: STAFF_FINES_AND_PENALTIES,
            },
            // {
            //     title: 'Bills',
            //     icon: faMoneyBill,
            //     to: STAFF_BILLS,
            // },
            // {
            //     title: 'Notifications',
            //     icon: faMessage,
            //     to: STAFF_NOTIFICATIONS,
            // },
            // {
            //     title: 'System Logs',
            //     icon: faCog,
            //     to: STAFF_LOGS,
            // },
            // {
            //     title: 'Administration',
            // },
            {
                title: 'User Roles & Permissions',
                open: true,
                icon: faShield,
                children: [
                    {
                        title: 'Roles',
                        icon: faList,
                        to: STAFF_ROLES,
                    },
                    {
                        title: 'Permissions',
                        icon: faCheck,
                        to: STAFF_PERMISSIONS,
                    },
                    {
                        title: 'Role-Permissions',
                        icon: faUserAlt,
                        to: STAFF_ROLE_PERMISSIONS,
                    },
                    {
                        title: 'Role-Users',
                        icon: faUserAlt,
                        to: STAFF_USER_ROLES,
                    },
                ],
            },
            {
                title: 'Users',
                open: false,
                icon: faUsers,
                children: [
                    {
                        title: 'Citizens',
                        icon: faUsers,
                        to: STAFF_USER_CITIZEN,
                    },
                    {
                        title: 'Staff',
                        icon: faUserAlt,
                        to: STAFF_USER_STAFF,
                    },
                ],
            },
            {
                title: 'Liquor Licencing',
                open: false,
                icon: faWineBottle,
                children: [
                    {
                        title: 'Apply',
                        icon: faHourglassStart,
                        to: STAFF_APPLY_LIQUOR_LICENCE,
                    },
                    {
                        title: 'Check',
                        icon: faEye,
                        to: STAFF_CHECK_LIQUOR_LICENCE,
                    },
                ],
            },
            {
                title: 'Receive Payments',
                open: false,
                icon: faMoneyBillTransfer,
                children: [
                    {
                        title: 'SBP',
                        icon: faMoneyBillTrendUp,
                        to: STAFF_SBP,
                        // meta: {
                        //     permissions: [STAFF_PERMISSION_CREATE_BUSINESS_PERMIT],
                        // },
                    },
                    {
                        title: 'Parking',
                        icon: faIcons,
                        to: STAFF_PARKING,
                        // meta: {
                        //     permissions: [STAFF_PERMISSION_CREATE_PARKING_DETAIL],
                        // },
                    },
                    {
                        title: 'Cess',
                        icon: faMoneyBill,
                        to: STAFF_CESS,
                        // meta: {
                        //     permissions: [STAFF_PERMISSION_CREATE_CESS],
                        // },
                    },
                    // {
                    //     title: 'Land',
                    //     icon: faLandmark,
                    //     to: STAFF_LAND,
                    // },
                    // {
                    //     title: 'Markets',
                    //     icon: faLandmark,
                    //     to: STAFF_MARKETS,
                    // },
                    // {
                    //     title: 'Stalls',
                    //     icon: faHouse,
                    // },
                    // {
                    //     title: 'Houses',
                    //     icon: faHouse,
                    // },
                ],
            },
            {
                title: 'Create Bills',
                open: false,
                icon: faMoneyBill,
                children: [
                    {
                        title: 'Land',
                        icon: faLandmark,
                        to: STAFF_LAND_BILLS,
                        // meta: {
                        //     permissions: [STAFF_PERMISSION_CREATE_BILLS],
                        // },
                    },
                    // {
                    //     title: 'Markets',
                    //     icon: faLandmark,
                    // },
                    // {
                    //     title: 'Stalls',
                    //     icon: faHouse,
                    // },
                    // {
                    //     title: 'Houses',
                    //     icon: faHouse,
                    // },
                ],
            },
            // {
            //     title: 'System Configuration',
            // },
            {
                title: 'Finance Settings',
                open: false,
                icon: faMoneyCheck,
                children: [
                    {
                        title: 'Schedules',
                        icon: faMoneyBillTrendUp,
                        to: STAFF_SCHEDULES,
                        // meta: {
                        //     permissions: [STAFF_PERMISSION_DELETE_SCHEDULE],
                        // },
                    },
                    {
                        title: 'Sections',
                        icon: faIcons,
                        to: STAFF_SECTIONS,
                        // meta: {
                        //     permissions: [STAFF_PERMISSION_CREATE_SECTION],
                        // },
                    },
                    {
                        title: 'Items',
                        icon: faMoneyBill,
                        open: false,
                        to: STAFF_ITEMS,
                        // meta: {
                        //     permissions: [STAFF_PERMISSION_CREATE_ITEM],
                        // },
                    },
                    {
                        title: 'Item Zones',
                        icon: faMapMarked,
                        to: STAFF_ITEM_ZONES,
                        // meta: {
                        //     permissions: [STAFF_PERMISSION_CREATE_ITEM],
                        // },
                    },
                ],
            },
            {
                title: 'Device/Pos Management',
                open: false,
                icon: faMobileAndroid,
                children: [
                    {
                        title: 'Devices',
                        icon: faMobileAndroid,
                        to: STAFF_POS_DEVICE,
                        // meta: {
                        //     permissions: [STAFF_PERMISSION_CREATE_POS_ACCOUNT],
                        // },
                    },
                    // {
                    //     title: 'Collectors',
                    //     icon: faUsers,
                    // },
                    // {
                    //     title: 'Distribution',
                    //     icon: faMapMarker,
                    // },
                ],
            },
            // {
            //     title: 'Role/Permission Management',
            //     open: false,
            //     children: [
            //         {
            //             title: 'Roles',
            //             icon: faMobileAndroid,
            //         },
            //         {
            //             title: 'Permissions',
            //             icon: faUsers,
            //         },
            //         {
            //             title: 'Role Permissions',
            //             icon: faUsers,
            //         },
            //         {
            //             title: 'User Roles',
            //             icon: faMapMarker,
            //         },
            //     ],
            // },
            {
                title: 'Food and Hygiene',
                open: false,
                icon: faBowlFood,
                children: [
                    {
                        title: 'Health Inspection',
                        icon: faLandmark,
                        to: STAFF_FOOD_HEALTH_INSPECTION,
                    },
                    {
                        title: 'Handlers Certificate',
                        icon: faLandmark,
                        to: STAFF_FOOD_HANDLERS_CERT,
                    },
                    {
                        title: 'Hygiene Licence',
                        icon: faLandmark,
                        to: STAFF_FOOD_HYGIENE_LICENCE,
                    },
                ],
            },
            // {
            //     title: 'Physical Planning',
            // },
            // {
            //     title: 'Approvals',
            //     open: false,
            //     children: [
            //         {
            //             title: 'Building Plans Approval',
            //             icon: faLandmark,
            //         },
            //     ],
            // },
            // {
            //     title: 'Administration',
            //     open: false,
            //     children: [
            //         {
            //             title: 'Change of Use',
            //             icon: faRedo,
            //         },
            //         {
            //             title: 'Building Permit',
            //             icon: faMapMarker,
            //         },
            //     ],
            // },
            // {
            //     title: 'OSHA',
            //     open: false,
            //     children: [
            //         {
            //             title: 'Fire Permit',
            //             icon: faHospitalWide,
            //         },
            //         {
            //             title: 'Inspection Permit',
            //             icon: faGauge,
            //         },
            //         {
            //             title: 'Environmental Permit',
            //             icon: faTree,
            //         },
            //     ],
            // },
            // {
            //     title: 'Registry/Assets',
            // },
            {
                title: 'Registry',
                open: false,
                icon: faBookAtlas,
                children: [
                    {
                        title: 'Lands Registry',
                        icon: faLandmark,
                        to: STAFF_LAND_REGISTRY,
                    },
                    {
                        title: 'Houses',
                        icon: faHomeAlt,
                        to: STAFF_HOUSE_REGISTRY,
                    },
                    {
                        title: 'Stalls',
                        icon: faHomeLg,
                        to: STAFF_STALL_REGISTRY,
                    },
                    {
                        title: 'Markets',
                        icon: faHospital,
                        to: STAFF_MARKET_REGISTRY,
                    },
                    {
                        title: 'Businesses',
                        icon: faBank,
                        to: STAFF_BUSINESS_REGISTRY,
                    },
                    {
                        title: 'Hospitals',
                        icon: faHospital,
                        to: STAFF_HOSPITAL_REGISTRY,
                    },
                ],
            },
            // {
            //     title: 'Reports',
            // },
            // {
            //     title: 'Payment Reports',
            //     open: false,
            //     children: [
            //         {
            //             title: 'Schedule Reports',
            //             icon: faMoneyBillTrendUp,
            //         },
            //         {
            //             title: 'Section Report',
            //             icon: faIcons,
            //         },
            //         {
            //             title: 'Item Report',
            //             icon: faMoneyBill,
            //         },
            //     ],
            // },
            // {
            //     title: 'Device/Pos Management',
            //     open: false,
            //     children: [
            //         {
            //             title: 'Device Report',
            //             icon: faMobileAndroid,
            //         },
            //         {
            //             title: 'Collectors Reports',
            //             icon: faUsers,
            //         },
            //     ],
            // },
            // {
            //     title: 'My Account',
            // },
            // {
            //     title: 'Account Management',
            //     open: false,
            //     children: [
            //         {
            //             title: 'Change Password',
            //             icon: faAsterisk,
            //         },
            //     ],
            // },
            // {
            //     title: 'Settings',
            //     open: false,
            //     children: [
            //         {
            //             title: 'Edit Profile',
            //             icon: faMobileAndroid,
            //         },
            //     ],
            // },
        ],
    );
    const activeNavItems = computed<menulink[]>(() => {
        return filterMenuItems(navItems.value, user.value?.permissions || []);
    });

    function filterMenuItems(menuItems: menulink[], userPermissions: Permission[]) {
        return menuItems.filter(item => {
            if (item.meta && item.meta.permissions) {
                // Check if the user has any of the required permissions
                const hasPermission = item.meta.permissions.some((permission) => {
                    return userPermissions.some(userPerm => userPerm.name === permission);
                });

                // If the user has the required permission, keep the item
                if (hasPermission) {
                    if (item.children) {
                        // Recursively filter the children
                        item.children = filterMenuItems(item.children, userPermissions);
                    }
                    return true;
                }

                // If the user doesn't have the required permission, exclude the item
                return false;
            }

            // If there are no permissions specified, keep the item
            return true;
        });
    }

    return {
        activeNavItems,
        navItems,
    };
});

export default useNavigationStore;
