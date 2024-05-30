import {compile} from 'path-to-regexp';

export const staffApprovalsRoute = compile('api/v1/approvals');
export const staffRolesRoute = compile('api/v1/roles');
export const detachPermissionFromRole = compile<{
    roleId: number, permissionId: number
}>('api/v1/roles/:roleId/detach/:permissionId');
export const attachPermissionFromRole = compile<{
    roleId: number, permissionId: number
}>('api/v1/roles/:roleId/attach/:permissionId');
export const staffPermissionsRoute = compile('api/v1/permissions');
export const staffAuthRoute = compile('api/v1/auth');
export const staffBillsRoute = compile('api/v1/bills');
export const staffBusinessPermitRoute = compile('api/v1/sbps');
export const staffBusinessRoute = compile('api/v1/businesses');
export const staffCessRoute = compile('api/v1/cess');
export const staffCitizenRoute = compile('api/v1/citizens');
export const staffDashboardData = compile('api/v1/dashboard-data');
export const staffDashboardGraphData = compile('api/v1/graph-data');
export const staffExportRoute = compile('api/v1/exports');
export const staffHospitalRoute = compile('api/v1/hospitals');
export const staffHousesRoute = compile('api/v1/houses');
export const staffItemsRoute = compile('api/v1/items');
export const staffLandsRoute = compile('api/v1/lands');
export const staffLoginRoute = compile('api/v1/login');
export const forgotPasswordRoute = compile('api/v1/reset-password');
export const changePasswordRoute = compile('api/v1/change-password');
export const staffLogoutRoute = compile('api/v1/logout');
export const staffMarketsRoute = compile('api/v1/markets');
export const staffModificationsRoute = compile('api/v1/modifications');
export const staffParkingRoute = compile('api/v1/parking-details');
export const staffPaymentsRoute = compile('api/v1/payments');
export const staffPosRoute = compile('api/v1/pos-accounts');
export const staffSchedulesRoute = compile('api/v1/schedules');
export const staffSectionsRoute = compile('api/v1/sections');
export const staffStaffRoute = compile('api/v1/staff');
export const staffStallsRoute = compile('api/v1/stalls');
export const staffSubCountiesRoute = compile('api/v1/sub-counties');
export const staffFoodHandlersCertificateRequestRoute = compile('api/v1/food-handlers-request');
export const staffFoodHandlersCertificatesRoute = compile('api/v1/food-handlers-certificate');
export const staffHealthInspectionRequestRoute = compile('api/v1/health-inspection-request');
export const staffHealthInspectionCertificateRoute = compile('api/v1/health-inspection-certificate');
export const staffFoodHygieneLicenceRoute = compile('api/v1/food-hygiene-licence');
export const staffFoodHygieneLicenceRequestRoute = compile('api/v1/food-hygiene-licence-request');
export const staffLiquorLicenceApplicationRoute = compile('api/v1/liquor-licence-application');
export const staffLiquorLicenceRoute = compile('api/v1/liquor-licence');


export const userRoute = compile('api/v1/user');
