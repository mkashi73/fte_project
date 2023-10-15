<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'login/LoginController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

// login routes
$route['login'] = 'login/LoginController';
$route['login/check'] = 'login/LoginController/checkCredentials';

// Menu routes
$route['show/menu'] = 'menu/MenuController';
$route['add/menu'] = 'menu/MenuController/AddMenu';
$route['menu/delete'] = 'menu/MenuController/DeleteMenu/';
$route['menu/update'] = 'menu/MenuController/UpdateMenu';
// get Product data for form
$route['menu/get/data'] = 'menu/MenuController/GetMenuData';

// Menu Pagination
$route['get/menu/(:any)'] = 'menu/MenuController/GetMenu/$1';

/********************
HOME PAGE FOR LOCALES
********************/
$route['show/locales'] = 'locales/LocalesController';
// $route['get/country/(:any)'] = 'country/CountryController/GetCountry/$1';


/*************
COUNTRY ROUTES
*************/
$route['add/country'] = 'locales/LocalesController/AddCountry';
$route['delete/country/(:any)'] = 'locales/LocalesController/DeleteCountry/$1';
$route['country/get'] = 'locales/LocalesController/GetCountry';
$route['country/update'] = 'locales/LocalesController/UpdateCountry';

/**********
CITY ROUTES
**********/
$route['city/add'] 	= 	'locales/LocalesController/AddCity';
$route['city/get']	=	'locales/LocalesController/GetCity';
$route['city/update'] = 'locales/LocalesController/UpdateCity';
$route['city/delete/(:any)'] = 'locales/LocalesController/DeleteCity/$1';

/***********
STATE ROUTES
***********/
$route['state/add'] 	= 	'locales/LocalesController/AddState';
$route['state/get']	=	'locales/LocalesController/GetState';
$route['state/update'] = 'locales/LocalesController/UpdateState';
$route['state/delete/(:any)'] = 'locales/LocalesController/DeleteState/$1';

// ADD GET STATE, CITY ROUTES
$route['state/get/data/(:any)'] = 'locales/LocalesController/GetAddStateData/$1';
$route['city/get/data/(:any)'] = 'locales/LocalesController/GetAddCityData/$1/$2';

// GET STATE & CITY ROUTES VIA ON CHANGE EVENTS
$route['state/get/data/(:any)/(:any)'] = 'locales/LocalesController/GetStateData/$1/$2';


$route['client/state/get/data/(:any)/(:any)'] = 'locales/LocalesController/GetClientStateData/$1/$2';
$route['client/city/get/data/(:any)/(:any)'] = 'locales/LocalesController/GetClientCityData/$1/$2';



// GET STATE & CITY ROUTES VIA ON CHANGE EVENTS
$route['city/get/data/(:any)/(:any)'] = 'locales/LocalesController/GetCityData/$1/$2';


// logout routes
$route['logout'] = 'login/LoginController/logout';

// dashboard routes
$route['welcome'] = 'dashboard/DashboardController';

// user routes
$route['user']	= 'users/UsersController';


$route['user/add'] = 'users/UsersController/AddUser';
$route['user/get/data'] = 'users/UsersController/GetUserData';
$route['user/delete'] = 'users/UsersController/DeleteUser';
$route['user/update'] = 'users/UsersController/UpdateUser';

// Validate Data
$route['check/data'] = 'common/CommonController/AttributeValidation';

// user roles routes
$route['user/role']	= 'users/UsersRolesController';
$route['user/role/add'] = 'users/UsersRolesController/AddUserRoles';
$route['user/role/update'] = 'users/UsersRolesController/UpdateUserRole';
$route['user/role/delete'] = 'users/UsersRolesController/DeleteUserRole';
$route['get/user/roles/data'] = 'users/UsersRolesController/GetUserRolesData';

// products routes
$route['product'] = 'products/ProductsController';
$route['product/add'] = 'products/ProductsController/AddProduct';
$route['product/update'] = 'products/ProductsController/UpdateProduct';
$route['delete/product'] = 'products/ProductsController/DeleteProduct';
// get Product data for form
$route['get/product/data'] = 'products/ProductsController/GetProductData';

// Product Reports
$route['product/report/invoice/(:any)'] = 'products/ProductsController/ViewInvoiceSlip/$1';
$route['product/report/cnslip/(:any)'] = 'products/ProductsController/ViewCNSlip/$1';
$route['product/report/prohibited/items/(:any)'] = 'products/ProductsController/ViewProhibitedItems/$1';
$route['product/report/fragile/goods/(:any)'] = 'products/ProductsController/ViewFragileGoods/$1';
$route['product/report/invoice/commercial/(:any)'] = 'products/ProductsController/ViewCommercialInvoice/$1';
$route['product/report/terms/(:any)'] = 'products/ProductsController/ViewInvoiceTerms/$1';


// Product Tracking
$route['product/tracking'] = 'products/ProductTrackingController'; // index method
// Search Product Tracking
$route['product/tracking/search'] = 'products/ProductTrackingController/SearchTracking'; 

// Product Status routes
$route['product/status'] = 'products/ProductsStatusController';
$route['product/status/add'] = 'products/ProductsStatusController/AddProductStatus';
$route['product/status/update'] = 'products/ProductsStatusController/UpdateProductStatus';
$route['product/status/delete'] = 'products/ProductsStatusController/DeleteProductStatus';


// get Product data for form
$route['product/status/get/data'] = 'products/ProductsStatusController/GetProductStatusData';

// Product Type routes
$route['product/type'] = 'products/ProductTypeController';
$route['product/type/add'] = 'products/ProductTypeController/AddProductType';
$route['product/type/update'] = 'products/ProductTypeController/UpdateProductType';
$route['product/type/delete'] = 'products/ProductTypeController/DeleteProductType';
// get Product data for form
$route['product/type/get/data'] = 'products/ProductTypeController/GetProductTypeData';

// Product Stage Routes
$route['product/stage'] = 'products/ProductStageController';
$route['product/stage/add'] = 'products/ProductStageController/AddProductStage';
$route['product/stage/get/data'] = 'products/ProductStageController/GetProductStageData';

// Product Search
$route['product/search'] = 'products/ProductStageController/SearchProduct';
/*******************************
UPDATE EXTERNAL AND COMPANY DATA
********************************/
$route['product/stage/update/data'] = 'products/ProductStageController/updateData';

/****************
MUTLIPLE PRODUCTS
****************/
$route['product/multiple'] = 'products/ProductMultipleController';
$route['product/multiple/add'] = 'products/ProductMultipleController/AddMultipleProduct';
$route['product/multiple/show'] = 'products/ProductMultipleController/ShowMultipleProduct';
$route['product/multiple/delete'] = 'products/ProductMultipleController/DeleteMultipleProduct';
$route['product/multiple/get'] = 'products/ProductMultipleController/GetProductMultipleData';
$route['product/multiple/update'] = 'products/ProductMultipleController/UpdateMultipleProduct';

/***************
PRODUCT MANIFEST
***************/
$route['product/manifest'] = 'products/ProductManifestController';
$route['product/manifest/generate'] = 'products/ProductManifestController/GenerateManifest';
$route['product/manifest/report'] = 'products/ProductManifestController/GenerateManifest';


// Downlaod Menifest in Excel
$route['product/manifest/generate/excel'] = 'products/ProductManifestController/GenerateManifestExcel';
$route['product/manifest/generate/excel2'] = 'products/ProductManifestController/GenerateManifestExcel2';

/*************
COMPANY ROUTES
*************/
$route['company'] = 'company/CompanyController';
$route['company/add'] = 'company/CompanyController/AddCompany';
$route['company/update'] = 'company/CompanyController/UpdateCompany';
$route['company/delete'] = 'company/CompanyController/DeleteCompany';
$route['company/data/get']	= 'company/CompanyController/GetCompanyData';




/*************
PRV ROUTES
*************/
$route['prv'] = 'accounts/PrvController';
$route['prv/add'] = 'accounts/PrvController/AddPrv';
$route['prv/update'] = 'accounts/PrvController/UpdatePrv';
$route['prv/delete'] = 'accounts/PrvController/DeletePrv';
$route['prv/data/get']	= 'accounts/PrvController/GetPrvData';
$route['get/prv/page/(:any)'] = 'accounts/PrvController/getPrvPagination/$1';
$route['prv/report/prv_report/(:any)'] = 'accounts/PrvController/ViewPrvReport/$1';

$route['prv/report/view'] = 'accounts/PrvController/PrvDetailView';
$route['prv/report/generate'] = 'accounts/PrvController/GeneratePrvDetailReport';


/*************
PRV ROUTES
*************/
$route['expense'] = 'accounts/ExpenseController';
$route['expense/add'] = 'accounts/ExpenseController/AddExpense';
$route['expense/update'] = 'accounts/ExpenseController/UpdateExpense';
$route['expense/delete'] = 'accounts/ExpenseController/DeleteExpense';
$route['expense/data/get']	= 'accounts/ExpenseController/GetExpenseData';
$route['get/expense/page/(:any)'] = 'accounts/ExpenseController/getExpensePagination/$1';
$route['expense/report/expense_report/(:any)'] = 'accounts/ExpenseController/ViewExpenseReport/$1';

$route['expense/report/view'] = 'accounts/ExpenseController/ExpenseDetailView';
$route['expense/report/generate'] = 'accounts/ExpenseController/GenerateExpenseDetailReport';



/*************
ALL PAGINATION
*************/

// User Pagination

$route['get/user/page/(:any)'] = 'users/UsersController/getUserPagination/$1';

// User Roles Pagination
$route['get/user/roles/page/(:any)'] = 'users/UsersRolesController/getUserRolesPagination/$1';

// Product Pagination
$route['get/product/page/(:any)'] = 'products/ProductsController/getProductPagination/$1';

// Product Status Pagination
$route['get/product/status/page/(:any)'] = 'products/ProductsStatusController/getProductStatusPagination/$1';

// Product Status Pagination
$route['get/product/type/page/(:any)'] = 'products/ProductTypeController/getProductTypePagination/$1';

// Country Pagination
$route['get/country/page/(:any)'] = 'locales/LocalesController/GetCountryPagination/$1';

$route['get/state/page/(:any)'] = 'locales/LocalesController/GetStatePagination/$1';

// CITY PAGINATION
$route['get/city/page/(:any)'] = 'locales/LocalesController/GetCityPagination/$1';

// Company Pagination
$route['get/company/page/(:any)'] = 'company/CompanyController/GetCompanyPagination/$1';




/*****************
ALL PAGINATION END
*****************/

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8


