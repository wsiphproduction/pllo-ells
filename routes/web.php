<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialiteController;

// CMS Controllers
use App\Http\Controllers\{FileDownloadCategoryController, FileDownloadController, MemberController, PageModalController, SitemapController, FacebookDataDeletionController, GoogleDataDeletionController, FacebookController, QrCodeController, ResourceCategoryController, ResourceController, RegistrationController,MemberProfileController,PolicyReformController,MaintenanceController};

use App\Http\Controllers\Cms4Controllers\{
    ArticleCategoryController, ArticleFrontController, ArticleController, AlbumController, MobileAlbumController, PageController, MenuController, FileManagerController
};

// Settings
use App\Http\Controllers\Settings\{
    PermissionController, AccountController, AccessController, UserController, LogsController, RoleController, WebController
};

// Ecommerce Controller
use App\Http\Controllers\Ecommerce\{
    CustomerController, CustomerFrontController, ProductCategoryController, ProductController, ProductFrontController, InventoryReceiverHeaderController, PromoController, DeliverablecitiesController, CouponController, CouponFrontController, CartController, MyAccountController, SalesController, ReportsController, BrandController, FormAttributeController, ProductReviewController, CustomerFavoriteController, CustomerWishlistController, BannerAdController, ProductCatalogHeaderController
};


// Ecommerce Controller
use App\Http\Controllers\Custom\{
    EventController, ReferenceMaterialController, DownloadableController
};

use App\Http\Controllers\MailingList\{SubscriberController, GroupController, CampaignController, SubscriberFrontController};



//FOR STORAGE LINK
Route::get('/storagelink', function () {
    Artisan::call('storage:link');
});

//FOR PHPINFO
Route::get('/phpinfo', function () {
    phpinfo();
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// CMS4 Front Pages
    Route::get('/', [FrontController::class, 'home'])->name('home');

    Route::get('/event-downloadables', [FrontController::class, 'downloads'])->name('event-downloadables');

    // Route::get('/reference-materials', [FrontController::class, 'reference_materials'])->name('reference-materials');

    Route::get('/privacy-policy/', [FrontController::class, 'privacy_policy'])->name('privacy-policy');
    Route::post('/contact-us', [FrontController::class, 'contact_us'])->name('contact-us');

    Route::get('/search', [FrontController::class, 'search'])->name('search');
    

    // Events
        Route::resource('/events', EventController::class)->except('show');
        Route::get('/events/previous', [EventController::class, 'previous'])->name('events.previous');
        Route::get('/events/view/{id}', [EventController::class, 'view'])->name('events.view');
        Route::get('/events/invitees/{id}', [EventController::class, 'invitees'])->name('events.invitees');
        Route::post('/events/cancel-event/{id}', [EventController::class, 'cancel_event'])->name('events.cancel-event');
        Route::post('/events/register-event/{id}', [EventController::class, 'register_event'])->name('events.register-event');
        Route::post('/events/decline-event/{id}', [EventController::class, 'decline_event'])->name('events.decline-event');
        Route::post('/events/submit-feedback/{id}', [EventController::class, 'submit_feedback'])->name('events.submit-feedback');
        Route::post('/events/upload-downloadables/{id}', [EventController::class, 'upload_downloadables'])->name('events.upload-downloadables');
    //

    // Reference Materials
        Route::resource('/reference-materials', ReferenceMaterialController::class)->except('show');
        Route::post('/reference-materials/single-delete/{id}', [ReferenceMaterialController::class, 'single_delete'])->name('reference-materials.single-delete');
    //
    
    // Downloads
        Route::resource('/downloads', DownloadableController::class)->except('show');
        Route::get('/downloads/republic-acts', [DownloadableController::class, 'republic_acts'])->name('downloads.republic-acts');
        Route::get('/downloads/bills-certified', [DownloadableController::class, 'bills_certified'])->name('downloads.bills-certified');
        Route::get('/downloads/legislative-priorities', [DownloadableController::class, 'legislative_priorities'])->name('downloads.legislative-priorities');
    //
    
    //News Frontend
        Route::get('/news/', [ArticleFrontController::class, 'news_list'])->name('news.front.index');
        Route::get('/news/{slug}', [ArticleFrontController::class, 'news_view'])->name('news.front.show');
        Route::get('/news/{slug}/print', [ArticleFrontController::class, 'news_print'])->name('news.front.print');
        Route::post('/news/{slug}/share', [ArticleFrontController::class, 'news_share'])->name('news.front.share');

        Route::get('/albums/preview', [FrontController::class, 'test'])->name('albums.preview');
        Route::get('/search-result', [FrontController::class, 'seach_result'])->name('search.result');
    //

    // Sitemap
        Route::get('/sitemap', [FrontController::class, 'sitemap'])->name('sitemap');
        // Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');
    // 


    // Resources
        Route::get('/case-details/{slug}', [FrontController::class, 'resource_details'])->name('resource-details.front.show');
        Route::get('/cases', [FrontController::class, 'resource_list'])->name('resource-list.front.show');
        Route::get('/cases/{slug}', [FrontController::class, 'resource_category_list'])->name('resource-category.list');


    Route::post('/subscribe', [SubscriberFrontController::class, 'subscribe'])->name('mailing-list.front.subscribe');
    Route::get('/unsubscribe/{subscriber}/{code}', [SubscriberFrontController::class, 'unsubscribe'])->name('mailing-list.front.unsubscribe');


    // Customer Signup - Signin
    Route::get('/login',                  [CustomerFrontController::class, 'login'])->name('customer-front.login');
    Route::post('/login',                 [CustomerFrontController::class, 'customer_login'])->name('customer-front.customer_login');
    Route::get('/customer-sign-up',       [CustomerFrontController::class, 'sign_up'])->name('customer-front.sign-up');
    Route::post('/customer-sign-up',      [CustomerFrontController::class, 'customer_sign_up'])->name('customer-front.customer-sign-up');
    Route::get('/forgot-password',        [CustomerFrontController::class, 'forgot_password'])->name('customer-front.forgot_password');
    Route::post('/forgot-password',       [CustomerFrontController::class, 'sendNewUserResetLinkEmail'])->name('customer-front.send_new_user_reset_link_email');
    Route::post('/forgot-password',       [CustomerFrontController::class, 'sendResetLinkEmail'])->name('customer-front.send_reset_link_email');
    Route::get('/reset-password/{token}', [CustomerFrontController::class, 'showResetForm'])->name('customer-front.reset_password');
    Route::post('/reset-password',        [CustomerFrontController::class, 'reset'])->name('customer-front.reset_password_post');

    //Socialite Signup -Signin
    Route::get('login/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('login.provider');
    Route::get('login/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);

    Route::post('facebook/data-deletion', [FacebookDataDeletionController::class, 'handle'])->name('facebook.data-deletion');
    Route::post('google/data-deletion', [GoogleDataDeletionController::class, 'handle'])->name('google.data-deletion');
    
    //Chat Plugin
    Route::post('/setup-chat-plugin', [FacebookController::class, 'setupChatPlugin']);

    // Ecommerce Pages
    
    Route::get('/brands', [ProductFrontController::class, 'brands'])->name('product.brands');
    Route::get('/brand-product-categories/{id}', [ProductFrontController::class, 'brand_product_categories'])->name('brand.product-category-list');
    Route::get('/product-sub-categories/{id}', [ProductFrontController::class, 'product_sub_categories'])->name('product.sub-categories');

    // Route::get('/brand-products/{id}', [ProductFrontController::class, 'brand_products'])->name('brand.product-list');
    Route::get('/category-products/{id}', [ProductFrontController::class, 'category_products'])->name('category.product-list');
    
    
    // Cart Management
    Route::get('/cart',                [CartController::class, 'cart'])->name('cart.front.show');
    Route::post('add-to-cart',         [CartController::class, 'add_to_cart'])->name('product.add-to-cart');
    Route::post('ebbok-add-to-cart',         [CartController::class, 'ebook_add_to_cart'])->name('ebook.add-to-cart');
    Route::post('buy-now',             [CartController::class, 'buy_now'])->name('cart.buy-now');
    Route::post('cart-update',         [CartController::class, 'cart_update'])->name('cart.update');
    Route::post('cart-remove-product', [CartController::class, 'remove_product'])->name('cart.remove_product');
    Route::post('proceed-checkout',    [CartController::class, 'proceed_checkout'])->name('cart.front.proceed_checkout');


    Route::post('/payment-notification', [CartController::class, 'receive_data_from_payment_gateway'])->name('cart.payment-notification');



    //Products/Books
    Route::get('books/{category?}', [ProductFrontController::class, 'product_list'])->name('product.front.list');
    Route::get('/book-details/{slug}', [ProductFrontController::class, 'product_details'])->name('product.details');
    // Route::get('/ebook-details/{slug}', [ProductFrontController::class, 'ebook_details'])->name('ebook.details');
    Route::get('/search-products', [ProductFrontController::class, 'search_product'])->name('search-product');
    Route::get('/search-contents', [ProductFrontController::class, 'search_content'])->name('search-content');

    Route::get('/generate-book-qr-code', [QrCodeController::class, 'generate_product_qr'])->name('generate.product.qr');
    Route::get('/book/series', [QrCodeController::class, 'product_series'])->name('product.series');



    // ECOMMERCE CUSTOMER AUTH ROUTES
        Route::group(['middleware' => ['authenticated']], function () {
            // MEMBER
            Route::get('/member/file-downloads', [MemberController::class, 'file_download'])->name('member.file-download');
            Route::get('/member/manage-account', [MemberController::class, 'manage_account'])->name('member.manage-account');
            Route::get('/member/change-password', [MemberController::class, 'change_password'])->name('member.change-password');
            Route::get('/member-logout', [MemberController::class, 'logout'])->name('member.logout');


            Route::post('/add-manual-coupon', [CouponFrontController::class, 'add_manual_coupon'])->name('add-manual-coupon');
            Route::get('/show-coupons', [CouponFrontController::class, 'collectibles'])->name('show-coupons');


            Route::get('/customer/dashboard', [MyAccountController::class, 'dashboard'])->name('customer.dashboard');
            Route::get('/manage-account', [MyAccountController::class, 'manage_account'])->name('customer.manage-account');
            Route::get('/library', [MyAccountController::class, 'library'])->name('customer.library');
            Route::get('/wishlist', [MyAccountController::class, 'wishlist'])->name('customer.wishlist');
            Route::get('/favorites', [MyAccountController::class, 'favorites'])->name('customer.favorites');
            Route::get('/free-ebooks', [MyAccountController::class, 'free_ebooks'])->name('customer.free-ebooks');
            Route::get('/ecredits', [MyAccountController::class, 'ecredits'])->name('customer.ecredits');
            Route::post('/account-update', [MyAccountController::class, 'update_personal_info'])->name('my-account.update-personal-info');
            Route::get('/account/change-password', [MyAccountController::class, 'change_password'])->name('my-account.change-password');
            Route::post('/account/change-password', [MyAccountController::class, 'update_password'])->name('my-account.update-password');
            Route::get('/account-logout', [CustomerFrontController::class, 'logout'])->name('account.logout');
            
            //DEACTIVATE SOCIAL LOGIN 
            Route::post('/deactivate-social-login', [MyAccountController::class, 'deactivate_social_login'])->name('customer.deactivate-social-login');

            Route::get('/my-orders', [MyAccountController::class, 'orders'])->name('profile.sales');
            Route::get('/account/pay/{id}', [MyAccountController::class, 'pay_again'])->name('my-account.pay-again');
            Route::post('/account/cancel/order', [MyAccountController::class, 'cancel_order'])->name('my-account.cancel-order');


            Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.front.checkout');
            Route::post('/temp_save',[CartController::class, 'save_sales'])->name('cart.temp_sales');
            Route::get('/success',[CartController::class, 'success'])->name('cart.success');

            Route::get('/get-lbc-city-list', [CartController::class, 'lbc_cities'])->name('checkout.get-lbc-city-list');
            Route::get('/get-lbc-brgy-list', [CartController::class, 'lbc_barangays'])->name('checkout.get-lbc-brgy-list');

            
            //PRODUCT REVIEW
            Route::resource('/product-review', ProductReviewController::class)->except(['destroy']);
            Route::post('/product-review/single-approve', [ProductReviewController::class, 'single_approve'])->name('product-review.single-approve');
            Route::post('/product-review/single-delete', [ProductReviewController::class, 'single_delete'])->name('product-review.single-delete');
            Route::get('/product-review/restore/{id}', [ProductReviewController::class, 'restore'])->name('product-review.restore');
            Route::post('/product-review-multiple-delete',[ProductReviewController::class, 'multiple_delete'])->name('product-review.multiple.delete');
            Route::post('/product-review-multiple-approve',[ProductReviewController::class, 'multiple_approve'])->name('product-review.multiple-approve');
            Route::post('/product-review-update-review',[ProductReviewController::class, 'update_review'])->name('product-review.update-review');

            //PRODUCT CATALOG
            Route::resource('/product-catalog', ProductCatalogHeaderController::class)->except(['destroy']);
            Route::get('/product-catalog/restore/{id}', [ProductCatalogHeaderController::class, 'restore'])->name('product-catalog.restore');
            Route::get('/product-catalog/{id}/{status}', [ProductCatalogHeaderController::class, 'update_status'])->name('product-catalog.change-status');
            Route::post('/product-catalog/single-delete', [ProductCatalogHeaderController::class, 'single_delete'])->name('product-catalog.single.delete');
            Route::post('/product-catalog/multiple-change-status',[ProductCatalogHeaderController::class, 'multiple_change_status'])->name('product-catalog.multiple.change.status');
            Route::post('/product-catalog/multiple-delete',[ProductCatalogHeaderController::class, 'multiple_delete'])->name('product-catalog.multiple.delete');

            //CUSTOMER FAVORITES
            Route::resource('/customer_favorite', CustomerFavoriteController::class)->except(['destroy']);
            Route::get('/customer_favorite/add-to-favorites/{prd_id}', [CustomerFavoriteController::class, 'add_to_favorites'])->name('add-to-favorites');
            
            //CUSTOMER WISHLIST
            Route::resource('/customer_wishlist', CustomerWishlistController::class)->except(['destroy']);
            Route::get('/customer_wishlist/add-to-wishlist/{prd_id}', [CustomerWishlistController::class, 'add_to_wishlist'])->name('add-to-wishlist');

        });
    //

    //BANNER ADS
    
        Route::get('/ads/click_count/{id}',[BannerAdController::class, 'click_count'])->name('ads.click.count');



// ADMIN ROUTES
Route::group(['prefix' => 'admin-panel'], function (){
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('panel.login');

    Auth::routes();

    Route::group(['middleware' => 'admin'], function (){

        Route::get('/admin-panel', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/admin/ecommerce-dashboard', [DashboardController::class, 'ecommerce'])->name('ecom-dashboard');

        // Account
            Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
            Route::put('/account/update', [AccountController::class, 'update'])->name('account.update');
            Route::put('/account/update_email', [AccountController::class, 'update_email'])->name('account.update-email');
            Route::put('/account/update_password', [AccountController::class, 'update_password'])->name('account.update-password');
        //

        // Website
            Route::get('/website-settings/edit', [WebController::class, 'edit'])->name('website-settings.edit');
            Route::put('/website-settings/update', [WebController::class, 'update'])->name('website-settings.update');
            Route::post('/website-settings/update_contacts', [WebController::class, 'update_contacts'])->name('website-settings.update-contacts');
            Route::post('/website-settings/update-ecommerce', [WebController::class, 'update_ecommerce'])->name('website-settings.update-ecommerce');
            Route::post('/website-settings/update-paynamics', [WebController::class, 'update_paynamics'])->name('website-settings.update-paynamics');
            Route::post('/website-settings/update-signin', [WebController::class, 'update_signin'])->name('website-settings.update-signin');
            Route::post('/website-settings/update_media_accounts', [WebController::class, 'update_media_accounts'])->name('website-settings.update-media-accounts');
            Route::post('/website-settings/update_data_privacy', [WebController::class, 'update_data_privacy'])->name('website-settings.update-data-privacy');
            Route::post('/website-settings/remove_logo', [WebController::class, 'remove_logo'])->name('website-settings.remove-logo');
            Route::post('/website-settings/remove_icon', [WebController::class, 'remove_icon'])->name('website-settings.remove-icon');
            Route::post('/website-settings/remove_media', [WebController::class, 'remove_media'])->name('website-settings.remove-media');
            Route::post('update-coupons-settings', [WebController::class, 'update_coupon_settings'])->name('website-settings.update-coupont-settings');
        //

        // Audit
            Route::get('/audit-logs', [LogsController::class, 'index'])->name('audit-logs.index');
        //

        // Users
            Route::resource('/users', UserController::class);
            Route::post('/users/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
            Route::post('/users/activate', [UserController::class, 'activate'])->name('users.activate');
            Route::get('/user-search/', [UserController::class, 'search'])->name('user.search');
            Route::get('/profile-log-search/', [UserController::class, 'filter'])->name('user.activity.search');
        //

        // Roles
            Route::resource('/role', RoleController::class);
            Route::post('/role/delete',[RoleController::class, 'destroy'])->name('role.delete');
            Route::get('/role/restore/{id}',[RoleController::class, 'restore'])->name('role.restore');
        //

        // Access
            Route::resource('/access', AccessController::class);
            Route::post('/roles_and_permissions/update', [AccessController::class, 'update_roles_and_permissions'])->name('role-permission.update');

            // if (env('APP_DEBUG') == "true") {
                // Permission Routes
                Route::resource('/permission', PermissionController::class)->except(['destroy']);
                Route::get('/permission-search/', [PermissionController::class, 'search'])->name('permission.search');
                Route::post('/permission/destroy', [PermissionController::class, 'destroy'])->name('permission.destroy');
                Route::get('/permission/restore/{id}', [PermissionController::class, 'restore'])->name('permission.restore');
                Route::post('permission/delete', [PermissionController::class, 'delete'])->name('permission.delete');

            // }
        //

        
        ###### CMS4 Standard Routes ######
            //Pages
                Route::resource('/pages', PageController::class);
                Route::get('/pages-advance-search', [PageController::class, 'advance_index'])->name('pages.index.advance-search');
                Route::post('/pages/get-slug', [PageController::class, 'get_slug'])->name('pages.get_slug');
                Route::put('/pages/{page}/default', [PageController::class, 'update_default'])->name('pages.update-default');
                Route::put('/pages/{page}/customize', [PageController::class, 'update_customize'])->name('pages.update-customize');
                Route::put('/pages/{page}/contact-us', [PageController::class, 'update_contact_us'])->name('pages.update-contact-us');
                Route::post('/pages-change-status', [PageController::class, 'change_status'])->name('pages.change.status');
                Route::post('/pages-delete', [PageController::class, 'delete'])->name('pages.delete');
                Route::get('/page-restore/{page}', [PageController::class, 'restore'])->name('pages.restore');
            //

            // Albums
                Route::resource('/albums', AlbumController::class);
                Route::post('/albums/upload', [AlbumController::class, 'upload'])->name('albums.upload');
                Route::delete('/many/album', [AlbumController::class, 'destroy_many'])->name('albums.destroy_many');
                Route::put('/albums/quick/{album}', [AlbumController::class, 'quick_update'])->name('albums.quick_update');
                Route::post('/albums/{album}/restore', [AlbumController::class, 'restore'])->name('albums.restore');
                Route::post('/albums/banners/{album}', [AlbumController::class, 'get_album_details'])->name('albums.banners');
            //

            // Mobile Albums
                Route::resource('/mobile-albums', MobileAlbumController::class);
                Route::post('/mobile-albums/upload', [MobileAlbumController::class, 'upload'])->name('mobile-albums.upload');
                Route::delete('/many/mobile-album', [MobileAlbumController::class, 'destroy_many'])->name('mobile-albums.destroy_many');
                Route::put('/mobile-albums/quick/{mobile_album}', [MobileAlbumController::class, 'quick_update'])->name('mobile-albums.quick_update');
                Route::post('/mobile-albums/{mobile_album}/restore', [MobileAlbumController::class, 'restore'])->name('mobile-albums.restore');
                Route::post('/mobile-albums/banners/{mobile_album}', [MobileAlbumController::class, 'get_album_details'])->name('mobile-albums.banners');
                Route::get('/mobile-albums/change-status/{id}', [MobileAlbumController::class, 'change_status'])->name('mobile-albums.change-status');
            //

            // News
                Route::resource('/news', ArticleController::class)->except(['show', 'destroy']);
                Route::get('/news-advance-search', [ArticleController::class, 'advance_index'])->name('news.index.advance-search');
                Route::post('/news-get-slug', [ArticleController::class, 'get_slug'])->name('news.get-slug');
                Route::post('/news-change-status', [ArticleController::class, 'change_status'])->name('news.change.status');
                Route::post('/news-delete', [ArticleController::class, 'delete'])->name('news.delete');
                Route::get('/news-restore/{news}', [ArticleController::class, 'restore'])->name('news.restore');

                // News Category
                Route::resource('/news-categories', ArticleCategoryController::class)->except(['show']);;
                Route::post('/news-categories/get-slug', [ArticleCategoryController::class, 'get_slug'])->name('news-categories.get-slug');
                Route::post('/news-categories/delete', [ArticleCategoryController::class, 'delete'])->name('news-categories.delete');
                Route::get('/news-categories/restore/{id}', [ArticleCategoryController::class, 'restore'])->name('news-categories.restore');
            //

            // File Manager
                Route::get('laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show')->name('file-manager.show');
                Route::post('laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload')->name('unisharp.lfm.upload');
                Route::get('file-manager', [FileManagerController::class, 'index'])->name('file-manager.index');
            //

            // Menu
                Route::resource('/menus', MenuController::class);
                Route::delete('/many/menu', [MenuController::class, 'destroy_many'])->name('menus.destroy_many');
                Route::put('/menus/quick1/{menu}', [MenuController::class, 'quick_update'])->name('menus.quick_update');
                Route::get('/menu-restore/{menu}', [MenuController::class, 'restore'])->name('menus.restore');
            //

            // Resource Category
                Route::resource('resource-categories', ResourceCategoryController::class);
                Route::post('resource-category-delete', [ResourceCategoryController::class, 'single_delete'])->name('resource-category.single.delete');
                Route::get('resource-category-restore/{id}', [ResourceCategoryController::class, 'restore'])->name('resource-category.restore');
                Route::get('resource-category/{id}/{status}', [ResourceCategoryController::class, 'update_status'])->name('resource-category.change-status');
                Route::post('resource-categories-multiple-change-status',[ResourceCategoryController::class, 'multiple_change_status'])->name('resource-category.multiple.change.status');
                Route::post('resource-categories-multiple-delete',[ResourceCategoryController::class, 'multiple_delete'])->name('resource-category.multiple.delete');
            //

            // Resource List
                Route::resource('resources', ResourceController::class);
                Route::get('resource/{id}/{status}', [ResourceController::class, 'update_status'])->name('resources.change-status');
                Route::post('resource-delete', [ResourceController::class, 'single_delete'])->name('resources.single.delete');
                Route::get('resource-restore/{id}', [ResourceController::class, 'restore'])->name('resources.restore');
                Route::post('resources-multiple-change-status',[ResourceController::class, 'multiple_change_status'])->name('resources.multiple.change.status');
                Route::post('resources-multiple-delete',[ResourceController::class, 'multiple_delete'])->name('resources.multiple.delete');
                Route::post('resource-remove-file', [ResourceController::class, 'remove_file'])->name('resources.remove.file');
            //

        ###### CMS4 Standard Routes ######
        Route::resource('downloadables', FileDownloadController::class);
        Route::post('downloadables/front-store', [FileDownloadController::class, 'front_store'])->name('downloadables.front.store');
        Route::post('file-single-delete', [FileDownloadController::class, 'single_delete'])->name('file.single.delete');
        Route::post('file-multiple-delete',[FileDownloadController::class, 'multiple_delete'])->name('file.multiple.delete');

    });
});

// USER REGISTRAION
Route::get('/register', [RegistrationController::class, 'register'])->name('register');
Route::post('/register/register-store', [RegistrationController::class, 'registerStore'])->name('register-store');
Route::get('/register/register-view-member/{id}', [RegistrationController::class, 'registerViewMember'])->name('register.view.member');
    
    // Agency
        Route::get('/registration/agency-list', [RegistrationController::class, 'agencyList'])->name('registration.agency-list');
        Route::get('/registration/agency-create', [RegistrationController::class, 'agencyCreate'])->name('registration.agency-create');
        Route::post('/registration/agency-store', [RegistrationController::class, 'agencyStore'])->name('registration.agency-store');
        Route::get('/registration/agency-edit/{id}', [RegistrationController::class, 'agencyEdit'])->name('registration.agency-edit');
        Route::post('/registration/agency-delete/{id}', [RegistrationController::class, 'agencyDelete'])->name('registration.agency-delete');
    //

    // MAIL REGISTRATION
        Route::get('/confirm-email', [RegistrationController::class, 'confirmEmail'])->name('confirm.email');

// MEMBER LOGIN
Route::get('/member-login', [RegistrationController::class, 'login'])->name('member.login');
Route::post('/member-online', [RegistrationController::class, 'online'])->name('member.online');
Route::get('/member-logout', [RegistrationController::class, 'logout'])->name('member.logout');
Route::post('/member-resend-email', [RegistrationController::class, 'resendRegisterConfirmation'])->name('member.resend.email');
Route::post('/member-upload-logo', [RegistrationController::class, 'uploadMemberLogo'])->name('member.upload.logo');
Route::get('/member-login-error', [RegistrationController::class, 'loginError'])->name('member.login.error');

// ADMIN USER
Route::get('/admin-dashboard', [RegistrationController::class, 'adminDashboard'])->name('admin.dashboard');
Route::post('/admin-registration-approve', [RegistrationController::class, 'adminRegistrationApprove'])->name('admin.registration.approve');
Route::post('/admin-registration-delete', [RegistrationController::class, 'adminRegistrationDelete'])->name('admin.registration.delete');

// MAINTENANCE
Route::get('/maintenance-dashboard', [MaintenanceController::class, 'maintenanceDashboard'])->name('maintenance.dashboard');

    // Agency Maintenance
    Route::post('/maintenance-agency-store', [MaintenanceController::class, 'maintenanceAgencyStore'])->name('maintenance.agency.store');
    Route::get('/maintenance-agency-edit/{id}', [MaintenanceController::class, 'maintenanceAgencyEdit'])->name('maintenance.agency.edit');
    Route::post('/maintenance-agency-update/{id}', [MaintenanceController::class, 'maintenanceAgencyUpdate'])->name('maintenance.agency.update');
    Route::post('/maintenance-agency-delete', [MaintenanceController::class, 'maintenanceAgencyDelete'])->name('maintenance.agency.delete');
    Route::get('/maintenance-agency-view/{id}', [MaintenanceController::class, 'maintenanceAgencyView'])->name('maintenance.agency.view');

    // Designation Maintenance
    Route::get('/maintenance-designation', [MaintenanceController::class, 'maintenanceDesignation'])->name('maintenance.designation');
    Route::post('/maintenance-designation-store', [MaintenanceController::class, 'maintenanceDesignationStore'])->name('maintenance.designation.store');
    Route::get('/maintenance-designation-edit/{id}', [MaintenanceController::class, 'maintenanceDesignationEdit'])->name('maintenance.designation.edit');
    Route::post('/maintenance-designation-update/{id}', [MaintenanceController::class, 'maintenanceDesignationUpdate'])->name('maintenance.designation.update');
    Route::post('/maintenance-designation-delete', [MaintenanceController::class, 'maintenanceDesignationDelete'])->name('maintenance.designation.delete');

    // Cluster Maintenance
    Route::get('/maintenance-cluster', [MaintenanceController::class, 'maintenanceCluster'])->name('maintenance.cluster');
    Route::post('/maintenance-cluster-store', [MaintenanceController::class, 'maintenanceClusterStore'])->name('maintenance.cluster.store');
    Route::get('/maintenance-cluster-edit/{id}', [MaintenanceController::class, 'maintenanceClusterEdit'])->name('maintenance.cluster.edit');
    Route::post('/maintenance-cluster-update/{id}', [MaintenanceController::class, 'maintenanceClusterUpdate'])->name('maintenance.cluster.update');
    Route::post('/maintenance-cluster-delete', [MaintenanceController::class, 'maintenanceClusterDelete'])->name('maintenance.cluster.delete');

    // Policy Reform Maintenance
    Route::get('/maintenance-policy-reform', [MaintenanceController::class, 'maintenancePolicyReform'])->name('maintenance.policy.reform');
    Route::post('/maintenance-policy-reform-store', [MaintenanceController::class, 'maintenancePolicyReformStore'])->name('maintenance.policy.reform.store');
    Route::get('/maintenance-policy-reform-edit/{id}', [MaintenanceController::class, 'maintenancePolicyReformEdit'])->name('maintenance.policy.reform.edit');
    Route::post('/maintenance-policy-reform-update/{id}', [MaintenanceController::class, 'maintenancePolicyReformUpdate'])->name('maintenance.policy.reform.update');
    Route::post('/maintenance-policy-reform-delete', [MaintenanceController::class, 'maintenancePolicyReformDelete'])->name('maintenance.policy.reform.delete');
    

// Member Profile Routes
Route::get('/member-dashboard', [MemberProfileController::class, 'memberDashboard'])->name('member.dashboard');
Route::post('/member-profile-update', [MemberProfileController::class, 'memberProfileUpdate'])->name('member.profile.update');
Route::post('/member-profile-account-delete', [MemberProfileController::class, 'memberDelete'])->name('member.profile.account.delete');

Route::post('/member-profile-senator-update/{id}', [MemberProfileController::class, 'senatorProfileUpdate'])->name('member.profile.senator.update');
Route::post('/member-profile-hor-update/{id}', [MemberProfileController::class, 'horProfileUpdate'])->name('member.profile.hor.update');

Route::post('/member-profile-remove-contact', [MemberProfileController::class, 'profileRemoveContact'])->name('member.profile.remove.contact');
Route::post('/member-profile-add-contact', [MemberProfileController::class, 'profileAddContact'])->name('member.profile.add.contact');

Route::post('/member-staff-update/{id}', [MemberProfileController::class, 'profileStaffUpdate'])->name('member.staff.update');



// Directory Routes
Route::get('/directory', [MemberProfileController::class, 'directory'])->name('directory');
Route::get('/directory/lls', [MemberProfileController::class, 'llsDirectory'])->name('directory.lls');
Route::get('/directory/pllo', [MemberProfileController::class, 'plloDirectory'])->name('directory.pllo');

Route::get('/directory/senators', [MemberProfileController::class, 'senartorsDirectory'])->name('directory.senators');
Route::get('/directory/senator-staff', [MemberProfileController::class, 'senartorStaffDirectory'])->name('directory.senator.staff');
Route::get('/directory/senators-committee-secretary', [MemberProfileController::class, 'senartorComSecDirectory'])->name('directory.senator.comsec');

Route::get('/directory/house-of-representatives', [MemberProfileController::class, 'horsDirectory'])->name('directory.hors');
Route::get('/directory/house-of-representatives-staff', [MemberProfileController::class, 'horStaffDirectory'])->name('directory.hor.staff');
Route::get('/directory/house-of-representatives-committee-secretary', [MemberProfileController::class, 'horComSecDirectory'])->name('directory.hor.comsec');

// Policy Reform
Route::get('/policy-reform', [PolicyReformController::class, 'index'])->name('policyreform.index');
Route::get('/policy-reform-view/{id}', [PolicyReformController::class, 'view'])->name('policyreform.view');
Route::get('/policy-reform-create', [PolicyReformController::class, 'create'])->name('policyreform.create');
Route::post('/policy-reform-store', [PolicyReformController::class, 'store'])->name('policyreform.store');

// Pages Frontend
Route::get('/{any}', [FrontController::class, 'page'])->where('any', '.*');
