<?php

/*
 |--------------------------------------------------------------------------
 | Web Routes
 |--------------------------------------------------------------------------
 |
 */

// Public website
Route::get('/', '\Platform\Controllers\Website\WebsiteController@home')->name('home');

/*
 |--------------------------------------------------------------------------
 | Platform routes
 |--------------------------------------------------------------------------
 */

// JavaScript language vars
Route::get('assets/javascript', '\Platform\Controllers\App\AssetController@appJs');

// Coupon
Route::get('c/{hash_id}', '\Platform\Controllers\Coupons\RenderController@showCoupon');
Route::get('c/{hash_id}/manifest.json', '\Platform\Controllers\Coupons\RenderController@showManifest');

// Redeem coupon
Route::get('c/r/{hash_id}/{confirmation_code}', '\Platform\Controllers\Coupons\RenderController@showRedeemCoupon');
Route::post('c/r/{hash_id}/{confirmation_code}', '\Platform\Controllers\Coupons\RenderController@postRedeemCoupon');

// Secured web routes
Route::group(['middleware' => 'auth:web'], function () {

  // Main layout
  Route::get('platform', '\Platform\Controllers\App\MainController@main')->name('main');

  /*
   |--------------------------------------------------------------------------
   | Partials
   |--------------------------------------------------------------------------
   */

  // Dashboard
  Route::get('platform/dashboard', '\Platform\Controllers\App\DashboardController@showDashboard');

  // Analytics
  Route::get('platform/analytics', '\Platform\Controllers\Analytics\AnalyticsController@showAnalytics');

  // Members
  Route::get('platform/members', '\Platform\Controllers\Members\MemberController@showMembers');
  Route::get('platform/members/export', '\Platform\Controllers\Members\MemberController@getExport');
  Route::get('platform/members/data', '\Platform\Controllers\Members\MemberController@getMemberData');
  Route::get('platform/member/edit', '\Platform\Controllers\Members\MemberController@showEditMember');
  Route::post('platform/member/update', '\Platform\Controllers\Members\MemberController@postMember');
  Route::post('platform/member/delete', '\Platform\Controllers\Members\MemberController@postMemberDelete');
  Route::post('platform/member/upload-avatar', '\Platform\Controllers\Members\MemberController@postAvatar');
  Route::post('platform/member/delete-avatar', '\Platform\Controllers\Members\MemberController@postDeleteAvatar');

  // Profile
  Route::get('platform/profile', '\Platform\Controllers\App\AccountController@showProfile');
  Route::post('platform/profile', '\Platform\Controllers\App\AccountController@postProfile');
  Route::post('platform/profile-avatar', '\Platform\Controllers\App\AccountController@postAvatar');
  Route::post('platform/profile-avatar-delete', '\Platform\Controllers\App\AccountController@postDeleteAvatar');

  // Media
	Route::get('platform/media/browser', '\Platform\Controllers\App\MediaController@showBrowser');
	Route::get('platform/media/picker', '\Platform\Controllers\App\MediaController@showPicker');
	Route::any('elfinder/connector', '\Barryvdh\Elfinder\ElfinderController@showConnector');
  Route::get('elfinder/tinymce', '\Platform\Controllers\App\MediaController@showTinyMCE');

  // Coupons
	Route::get('platform/coupon/new', '\Platform\Controllers\Coupons\EditController@showNewCoupon');
	Route::post('platform/coupon/new', '\Platform\Controllers\Coupons\EditController@postNewCoupon');
	Route::get('platform/coupon/edit', '\Platform\Controllers\Coupons\EditController@showCouponEditor');
	Route::post('platform/coupon/delete', '\Platform\Controllers\Coupons\EditController@postCouponDelete');
	Route::post('platform/coupon/update', '\Platform\Controllers\Coupons\EditController@postCouponUpdate');
  Route::post('platform/coupon/upload-avatar', '\Platform\Controllers\Coupons\EditController@postAvatar');
  Route::post('platform/coupon/delete-avatar', '\Platform\Controllers\Coupons\EditController@postDeleteAvatar');

  // For coupon previews
	Route::get('c', '\Platform\Controllers\Coupons\RenderController@showCoupon');

  // For admins
  Route::group(['middleware' => 'role:admin'], function () {

    // User management
    Route::get('platform/admin/users', '\Platform\Controllers\App\UserController@showUsers');
    Route::get('platform/admin/users/data', '\Platform\Controllers\App\UserController@getUserData');
    Route::get('platform/admin/user/new', '\Platform\Controllers\App\UserController@showNewUser');
    Route::post('platform/admin/user/new', '\Platform\Controllers\App\UserController@postNewUser');
    Route::get('platform/admin/user/edit', '\Platform\Controllers\App\UserController@showEditUser');
    Route::post('platform/admin/user/update', '\Platform\Controllers\App\UserController@postUser');
    Route::post('platform/admin/user/delete', '\Platform\Controllers\App\UserController@postUserDelete');
    Route::post('platform/admin/user/upload-avatar', '\Platform\Controllers\App\UserController@postAvatar');
    Route::post('platform/admin/user/delete-avatar', '\Platform\Controllers\App\UserController@postDeleteAvatar');
    Route::get('platform/admin/user/login-as/{sl}', '\Platform\Controllers\App\UserController@getLoginAs');
  });
});

/*
 |--------------------------------------------------------------------------
 | Auth Platform
 |--------------------------------------------------------------------------
 */

// Login Routes
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// Registration Routes
if (\Config::get('auth.allow_registration', true)) {
  Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
  Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);
}

// Password Reset Routes
Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);

/*
 |--------------------------------------------------------------------------
 | Auth Members
 |--------------------------------------------------------------------------
 */

//Member Login
Route::get('member/login', 'AuthMember\LoginController@showLoginForm');
Route::post('member/login', 'AuthMember\LoginController@login');
Route::post('member/logout', 'AuthMember\LoginController@logout');
Route::get('member/logout', 'AuthMember\LoginController@logout');

//Member Register
Route::get('member/register', 'AuthMember\RegisterController@showRegistrationForm');
Route::post('member/register', 'AuthMember\RegisterController@register');

//Member Passwords
Route::post('member/password/email', 'AuthMember\ForgotPasswordController@sendResetLinkEmail');
Route::post('member/password/reset', 'AuthMember\ResetPasswordController@reset');
Route::get('member/password/reset', 'AuthMember\ForgotPasswordController@showLinkRequestForm');
Route::get('member/password/reset/{token}', 'AuthMember\ResetPasswordController@showResetForm');

// Reset everything
Route::get('reset/{key}', '\Platform\Controllers\App\InstallationController@reset');
?>