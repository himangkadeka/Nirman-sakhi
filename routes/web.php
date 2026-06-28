<?php

use App\Http\Controllers\Admin\MasterDataControllers\ReasonsController;
use App\Http\Controllers\Worker\PFC\WorkerPfcController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserLoginController;
use App\Http\Controllers\ActsandRulesController;
use App\Http\Controllers\Admin\Benefits\BenefitFormController;
use App\Http\Controllers\Admin\Benefits\BenefitListController;
use App\Http\Controllers\Admin\MasterDataControllers\AgeProofController;
use App\Http\Controllers\Admin\MasterDataControllers\AmountController;
use App\Http\Controllers\Admin\MasterDataControllers\RelationController;
use App\Http\Controllers\Admin\MasterDataControllers\CategoryController;
use App\Http\Controllers\Admin\MasterDataControllers\DesignationController;
use App\Http\Controllers\Admin\MasterDataControllers\DistrictController;
use App\Http\Controllers\Admin\MasterDataControllers\GenderController;
use App\Http\Controllers\Admin\MasterDataControllers\HouseTypeController;
use App\Http\Controllers\Admin\MasterDataControllers\IssuerTypeController;
use App\Http\Controllers\Admin\MasterDataControllers\MaritalStatusController;
use App\Http\Controllers\Admin\MasterDataControllers\NatureOfWorkController;
use App\Http\Controllers\Admin\MasterDataControllers\PostOfficeController;
use App\Http\Controllers\Admin\MasterDataControllers\ProfessionController;
use App\Http\Controllers\Admin\MasterDataControllers\RationTypeController;
use App\Http\Controllers\Admin\MasterDataControllers\ResidenceTypeController;
use App\Http\Controllers\Admin\MasterDataControllers\SchemesController;
use App\Http\Controllers\Admin\MasterDataControllers\SkillController;
use App\Http\Controllers\Admin\MasterDataControllers\StateController;
use App\Http\Controllers\Admin\MasterDataControllers\SubDistrictController;
use App\Http\Controllers\Admin\MasterDataControllers\EducationController;
use App\Http\Controllers\Admin\MasterDataControllers\WorkTypeController;
use App\Http\Controllers\Admin\Office\OfficeController;
use App\Http\Controllers\Admin\Contents\GalleryCategoryController;
use App\Http\Controllers\Admin\Contents\GalleryController;
use App\Http\Controllers\Admin\MasterDataControllers\BankController;
use App\Http\Controllers\Admin\Contents\IndexNotificationController;
use App\Http\Controllers\Admin\Contents\BenefitsReturnedController;
use App\Http\Controllers\Admin\Contents\ContentController;
use App\Http\Controllers\Admin\MISData\PFCDataController;
use App\Http\Controllers\MISDistrictWiseDataController;
use App\Http\Controllers\Admin\MISData\PortalUserController;
use App\Http\Controllers\Admin\MISData\WorkerRegistrationStatusController;
use App\Http\Controllers\Admin\MISData\AlreadyRegisteredStatusController;
use App\Http\Controllers\Admin\MISData\RenewalDataController;
use App\Http\Controllers\Admin\MISData\DistrictWiseDataController;
use App\Http\Controllers\Admin\MISData\OfficeWiseDataController;
use App\Http\Controllers\Admin\MISData\PFCWiseDataController;
use App\Http\Controllers\Admin\MISData\WorkerPAddressOutOfAssamController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MISData\AllUsersDataController;
use App\Http\Controllers\Admin\MISData\DashboardDataController;
use App\Http\Controllers\Admin\MISData\IdCardDataController;
use App\Http\Controllers\Admin\MISData\PaymentDataController;
use App\Http\Controllers\Admin\MISData\ProfessionWiseDataController;
use App\Http\Controllers\Worker\WorkerLoginController;
use App\Http\Controllers\Worker\MasterWorkerController;
use App\Http\Controllers\Worker\pdfs\IdCardController;
use App\Http\Controllers\Worker\pdfs\ReceiptController;
use App\Http\Controllers\Admin\Users\RoleController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Admin\Users\PermissionController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\LogController;
use App\Http\Controllers\Auth\OfficeAuthController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\WorkerAuthController;
use App\Http\Controllers\DataViewController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NomineeRegistrationByNomineeController;
use App\Http\Controllers\Office\ApplicationController;
use App\Http\Controllers\Office\DscController;
use App\Http\Controllers\Office\OfficeDashboardController;
use App\Http\Controllers\Office\OfficeinfoController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CscListController;
use App\Http\Controllers\Worker\AuthOtpController;
use App\Http\Controllers\Worker\ExistingWorkerController;
use App\Http\Controllers\Worker\PhotoController;
use App\Http\Controllers\Worker\MasterRenewalController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Worker\eShramController;
use App\Http\Controllers\Api\PfcController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Office\Benefit\AccountsController;
use App\Http\Controllers\Office\Benefit\DlcDashboardController;
use App\Http\Controllers\Office\Benefit\HdaDashboardController;
use App\Http\Controllers\Office\Benefit\HoDashboardController;
use App\Http\Controllers\Office\Benefit\HoForwardingController;
use App\Http\Controllers\Office\Benefit\LcLmDashboardController;
use App\Http\Controllers\Office\Benefit\ScrutinyManagementController;
use App\Http\Controllers\Office\BenefitManagementController;
use App\Http\Controllers\Office\NomineeManagementController;
use App\Http\Controllers\Office\OfficeProfileController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\Worker\Benefits\BenefitsController;
use \App\Http\Controllers\Office\RenewalApplicationController;
use \App\Http\Controllers\Admin\MISData\AppliucationStatusDataController;
use App\Http\Controllers\Admin\MISData\BulkVaultDataController;
use App\Http\Controllers\Admin\MISData\SubscriptionDataController;
use App\Http\Controllers\Admin\MISData\RenewalDashboardDataController;
use App\Http\Controllers\Admin\Track\AdminAppController;
use App\Http\Controllers\PublicMISController;
use App\Http\Controllers\Worker\Benefits\FamilyAadhaarVerificationController;
use App\Http\Controllers\Worker\Benefits\NomineeRegistrationController;
use App\Http\Controllers\Worker\Benefits\BenefitFormSubmissionController;
use App\Http\Controllers\Worker\Benefits\CashAwardFormSubmissionController;
use App\Http\Controllers\Worker\Benefits\MarriageAssistanceFormSubmissionController;
use App\Http\Controllers\Worker\Benefits\MaternityAssistanceFormSubmissionController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
// if(env('APP_URL')=='http://103.158.205.175'){
//     Route::any('{any}', function () {
//         // Check if the 'access' query parameter matches your secret key
//         if (request()->query('access') === 'labour@98767890') {
//             // Allow normal route access
//             return redirect('/');
//         }

//         // Show the maintenance page to others
//         return view('maintenance');
//     })->where('any', '.*');
// }
// Route::any('{any}', function () {
//         // Check if the 'access' query parameter matches your secret key
//         // if (request()->query('access') === 'labour@98767890') {
//         //     // Allow normal route access
//         //     return redirect('/');
//         // }

//         // Show the maintenance page to others
//         return view('maintenance');
//     })->where('any', '.*');



// ==========================LOCALIZATION==========================
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    //============= PUBLIC ROUTES ========================

    Route::get('update/user/{user_id}', [IdCardDataController::class, 'updateStatus']);

    // FORGET PASSWORRD

    Route::name('password.')->group(function () {
        Route::get('forget-password', [PasswordController::class, 'forgetPassword'])->name('forget-password');
        Route::post('send-otp', [PasswordController::class, 'sendOtp'])->name('send-otp');
        Route::post('verify-otp', [PasswordController::class, 'verifyOtp'])->name('verify-otp');
        Route::get('reset-password', [PasswordController::class, 'resetPass'])->name('reset');
        Route::post('reset-password', [PasswordController::class, 'resetPassword'])->name('reset-password');
    });


    Route::match(['get', 'post'], 'test-site', [IndexController::class, 'testSiteRedirect'])->name('test-site');



    /** Download Acts and Rules **/

    // Route::get('/download', [ActsandRulesController::class,'downloadFile'])->name('download');
    Route::get('/download/{fileName}', [ActsandRulesController::class, 'downloadFile'])->name('download');
    // Route::get('main-worker',function(){
    //     return MainWorkerForm::get();
    // });

    Route::match(['get', 'post'], 'nominee-registration', [NomineeRegistrationByNomineeController::class, 'index'])->name('nominee-registration-by-nominee');
    Route::get('ekyc-success/{nomine_id}', function ($nomine_id) {
        // ...and passes it to the view using compact().
        return view('worker.benefits.nominee.ekyc-thanks', compact('nomine_id'));
    })->name('ekyc-thanks');
    Route::get('download-ekyc-ack/{nominee_id}', [NomineeRegistrationByNomineeController::class, 'downloadKycAcknowledgment'])->name('ekyc-ack-download');
    Route::post('check-id-card', [NomineeRegistrationByNomineeController::class, 'checkIdCard'])->name('check-id-card');
    Route::post('verify-and-get', [AuthOtpCOntroller::class, 'ekycAadhaarWithDecrypt'])->name('aadhar-otp-verify-nominee');


    Route::post('otp/generate-worker', [AuthOtpController::class, 'genOTP'])->name('generate-otp');
    Route::post('otp/generate-worker-new', [AuthOtpController::class, 'genOTPNew'])->name('generate-otp-new');
    Route::post('otp/generate-worker-revert', [AuthOtpController::class, 'genRevertOtp'])->name('generate-otp-revert');
    Route::post('verify/otp', [AuthOtpController::class, 'otpVerificationWorker'])->name('verify-otp-new');
    Route::post('verify/otp-revert', [AuthOtpController::class, 'otpVerificationRevert'])->name('verify-otp-revert');
    Route::name('home.')->group(function () {
        Route::get('qr-code-view/{id}', [IndexController::class, 'qrCode'])->name('qrCode');
        Route::get('show_pdf', [IndexController::class, 'showPdf'])->name('show-pdf');
        Route::get('/', [IndexController::class, 'index'])->name('index');
        Route::post('track/application', [IndexController::class, 'trackApplication'])->name('track.application');
        Route::get('/track-application-mobile', [IndexController::class, 'TrackApplicationMobile'])->name('track-using-mobile');
        Route::post('/get-application-list', [IndexController::class, 'TrackByMobile'])->name('track-by-mobile');
        Route::post('homepageNotifications', [IndexController::class, 'homepageNotifications'])->name('homepageNotifications');
        Route::get('download-acknowledgement-receipt', [IndexController::class, 'downloadAcknowledgement'])->name('download.ack.receipt');
        Route::get('visitor-count', [IndexController::class, 'countVisitor'])->name('visitor-count');
        Route::get('onboarding-criteria', [IndexController::class, 'onboardingCriteria'])->name('onboarding-criteria');
        Route::get('new-registration-criteria', [IndexController::class, 'newRegistrationCriteria'])->name('new-registration-criteria');
        Route::name('about.')->prefix('about')->group(function () {
            Route::get('introduction', [IndexController::class, 'introduction'])->name('introduction');
            Route::get('whos-who', [IndexController::class, 'whosWho'])->name('whos-who');

            Route::get('mission-and-vission', [IndexController::class, 'missionAndVission'])->name('mission-and-vission');
            Route::get('aims-and-objectives', [IndexController::class, 'aimsAndAbjectives'])->name('aims-and-objectives');
            Route::get('functions', [IndexController::class, 'Functions'])->name('functions');
            Route::get('organizations', [IndexController::class, 'organizations'])->name('organizations');
            Route::get('visitor-count', [IndexController::class, 'countVisitor'])->name('visitor-count');
        });

        // services
        Route::name('services.')->prefix('about')->group(function () {


            Route::get('checklistpfc', [IndexController::class, 'checklistpfc'])->name('checklistpfc');
            Route::get('helpdesk', [IndexController::class, 'helpdesk'])->name('helpdesk');
        });
        Route::name('pfcs.')->prefix('about')->group(function () {
            Route::get('cscdetails', [IndexController::class, 'cscdetails'])->name('cscdetails');
            Route::get('showPfcs', [CscListController::class, 'showPfcs'])->name('showPfcs');
            Route::post('search', [CscListController::class, 'search'])->name('search');
        });


        Route::name('schemesandbenefits.')->prefix('about')->group(function () {
            Route::get('benefits', [IndexController::class, 'benefits'])->name('benefits');

            Route::get('listofapprovedpfcs', [IndexController::class, 'listofapprovedpfcs'])->name('listofapprovedpfcs');

            Route::prefix('schemesandbenefits')->group(function () {
                // Add this outside of Admin routes or inside public route groups
                Route::get('/fetch-years', [IndexNotificationController::class, 'getYears'])->name('fetch.years');
                Route::get('disbursed/{year}', [IndexController::class, 'disbursed'])->name('disbursed.year');

                Route::get('returned/{year}', [IndexController::class, 'returned'])->name('returned.year');

                Route::get('/districts-with-notifications', [IndexNotificationController::class, 'showDistrictsWithNotifications'])->name('districts.with.notifications');

                Route::get('/district-files', [IndexController::class, 'getDistrictReturnedFiles'])->name('district-files');
                Route::get('/benefit-files', [IndexController::class, 'getDisbursedBenefitFiles'])->name('benefit-files');
                Route::get('/get-grouped-benefit-files', [IndexNotificationController::class, 'getGroupedBenefitFiles']);
            });
        });


        Route::get('contact-us', [IndexController::class, 'contactUs'])->name('contactus');
        Route::get('iit', [IndexController::class, 'iit'])->name('iit');
        Route::get('actandrules', [IndexController::class, 'actandrules'])->name('actandrules');
        Route::get('benefits', [IndexController::class, 'Benefits'])->name('benefits');

        //   MIS
        Route::get('/mis', [MISDistrictWiseDataController::class, 'index'])->name('mis.index');
        Route::get('/get-date-range-data', [MISDistrictWiseDataController::class, 'getDateRangeData'])->name('getDateRangeData');

        Route::get('downloads', [IndexController::class, 'downloads'])->name('downloads');

        Route::name('mis.')->prefix('mis')->group(function () {
            Route::get('/', [PublicMISController::class, 'index'])->name('index');
        });


        Route::get('sop1', [IndexController::class, 'sop1'])->name('sop1');
        Route::get('sop2', [IndexController::class, 'sop2'])->name('sop2');
        Route::get('sop3', [IndexController::class, 'sop3'])->name('sop3');
        Route::get('sop4', [IndexController::class, 'sop4'])->name('sop4');
        Route::get('sop5', [IndexController::class, 'sop5'])->name('sop5');
        Route::get('sop6', [IndexController::class, 'sop6'])->name('sop6');
        Route::get('sop7', [IndexController::class, 'sop7'])->name('sop7');

        Route::get('tenders', [IndexController::class, 'tenders'])->name('tenders');
        Route::get('benefits2', [IndexController::class, 'benefits2'])->name('benefits2');
        Route::get('cess', [IndexController::class, 'cess'])->name('cess');

        Route::get('grievance', [IndexController::class, 'grievance'])->name('grievance');


        Route::get('gallery', [IndexController::class, 'gallery'])->name('gallery');

        Route::get('sitemaps', [IndexController::class, 'sitemaps'])->name('sitemaps');
        // Route::get('Sitemap', [IndexController::class, 'Sitemap'])->name('Sitemap');
        Route::get('progress-report', [IndexController::class, 'progressreport'])->name('progressreport');
        Route::get('termsofuse', [IndexController::class, 'termsofuse'])->name('termsofuse');
        Route::get('copyrightpolicy', [IndexController::class, 'copyrightpolicy'])->name('copyrightpolicy');
        Route::get('accessibilitypolicy', [IndexController::class, 'accessibilitypolicy'])->name('accessibilitypolicy');
        Route::get('privacypolicy', [IndexController::class, 'privacypolicy'])->name('privacypolicy');
        Route::get('faq', [IndexController::class, 'faq'])->name('faq');
        Route::get('visitor-count', [IndexController::class, 'countVisitor'])->name('visitor-count');
        Route::get('track', [IndexController::class, 'trackApp'])->name('track.form');
    });

    // ===================PFC==================================

    Route::prefix('pfc')->group(function () {
        Route::get('worker/{id}', [WorkerPfcController::class, 'getPFCData'])->name('pfc-register');
        Route::post('save-pfc-data', [WorkerPfcController::class, 'savePfcData'])->name('save-pfc-data');
        Route::get('worker-new-reg', [WorkerPfcController::class, 'newRegistration'])->name('new-registration');
    });


    //================== WORKER DETAILS ===========================
    Route::prefix('worker')->group(function () {
        Route::get('worker-error/{id}/{contact?}', [MasterWorkerController::class, 'errorThrow'])->name('error-show-worker');

        // ================== WORKER BENEFITS ===========================
        Route::get('benefit-list/{category_id}', [BenefitsController::class, 'benefitLists'])->name('benefit-list');
        Route::get('elegible-family-member/{benefit_id}', [BenefitsController::class, 'elegibleFamilyMember'])->name('elegible-family-member');
        Route::get('view-application/{benefit_id}/{member_id}', [BenefitsController::class, 'viewForm'])->name('view-form');
        Route::get('view-scholarship-documents/{path}',[BenefitsController::class,'viewDocs'])->where('path', '.*')->name('view-scholarship-docs');
        Route::post('submit-application/{benefit_id}', [BenefitsController::class, 'submitBenefitApplication'])->name('submit-benefit-application');
        Route::get('worker-scholarship-preview/{application_id}', [BenefitFormSubmissionController::class, 'preview'])->name('worker-scholarship-preview');
        Route::post('submit-education-scholarship-application/{application_id}', [BenefitFormSubmissionController::class, 'finalSubmitEducation'])->name('final-submit-education-scholarship-application');
        Route::get('education-acknowledgement/{application_id}', [BenefitFormSubmissionController::class, 'acknowledgementEdu'])->name('acknowledgement-edu');

        Route::post('submit-cash-award-application/{application_id}', [CashAwardFormSubmissionController::class, 'finalSubmitCashAward'])->name('submit-cash-award-application');
        Route::get('cash-award-acknowledgement/{application_id}', [CashAwardFormSubmissionController::class, 'acknowledgementCash'])->name('acknowledgement-cash');

        Route::post('submit-marriage-assistance-application/{application_id}', [MarriageAssistanceFormSubmissionController::class, 'finalSubmitMarriageAssistance'])->name('submit-marriage-assistance-application');
        Route::get('marriage-assistance-acknowledgement/{application_id}', [MarriageAssistanceFormSubmissionController::class, 'acknowledgementMarriageAssistance'])->name('acknowledgement-marriage');

        Route::post('submit-maternity-assistance-application/{application_id}', [MaternityAssistanceFormSubmissionController::class, 'finalSubmitMaternityAssistance'])->name('submit-maternity-assistance-application');
        Route::get('maternity-assistance-acknowledgement/{application_id}', [MaternityAssistanceFormSubmissionController::class, 'acknowledgementMaternityAssistance'])->name('acknowledgement-maternity');



        Route::get('/apply-ea/start/{benefitId}/{familyMemberId}', [BenefitsController::class, 'startEaApplication'])->name('worker.apply-ea.start');
        Route::get('/apply-now/{benefitId}', [BenefitsController::class, 'index'])->name('worker.apply-now');
        Route::get('/complete-application/{application_id}', [BenefitsController::class, 'completeApplication'])->name('worker.complete-application');
        Route::get('/edit-now/{application_id}', [BenefitsController::class, 'editNow'])->name('worker.edit-now');
        Route::post('submit-form/{benefitId}/{application_id}', [BenefitsController::class, 'submitForm'])->name('worker.submit-form');
        Route::get('preview-application/{benefitId}/{application_id}', [BenefitsController::class, 'previewApplication'])->name('worker.preview-application');
        Route::get('/download-application/{application:id}', [BenefitsController::class, 'printApplicationBenefitPdf'])->name('worker.print-application');
        Route::post('final-submit/{application:id}', [BenefitsController::class, 'finalSubmit'])->name('worker.final-submit');
        Route::post('/get-dependent-field', [BenefitsController::class, 'getDependentField'])->name('worker.get-dependent-field');
        Route::get('/application/file/{data}', [BenefitManagementController::class, 'showFile'])->name('file.show');
        Route::get('application-submitted/{application:id}', [BenefitsController::class, 'showAcknowledgment'])->name('worker.show-acknowledgment');
        Route::get('download-acknowledgment/{application:id}', [BenefitsController::class, 'downloadAcknowledgment'])->name('worker.download-acknowledgment');
        Route::get('/applications/track/{application:id}', [BenefitsController::class, 'track'])->name('applications.track');
        // ================== END WORKER BENEFITS ===========================

        Route::post('/user-login', [WorkerLoginController::class, 'workerLogin']);
        Route::post('/user-logout', [WorkerLoginController::class, 'logoutUser'])->name('user-logout');
        Route::get('/worker-claimed-schemes', [WorkerLoginController::class, 'getScheme'])->name('worker-claimed-schemes');
        Route::get('/worker-id-card', [WorkerLoginController::class, 'getWorkerId'])->name('worker-id-card');
        Route::get('/download-id-card', [WorkerLoginController::class, 'downloadIdCard'])->name('download-id-card');
        Route::get('/view-id-card', [WorkerLoginController::class, 'viewIdCard'])->name('view-id-card');
        Route::post('/generate-id-card', [WorkerLoginController::class, 'generateIDCard'])->name('generate.id.card');
        Route::get('get-worker-passport/{id}/{worker_id}', [WorkerLoginController::class, 'getPassport'])->name('worker-passport');
        Route::get('get-id-card/{id}', [WorkerLoginController::class, 'getIdCard'])->name('get-id-card');
        Route::post('update-profile-family-details', [WorkerLoginController::class, 'updateFamily'])->name('update-profile-family-details');
        Route::get('/worker-profile', [WorkerLoginController::class, 'getProfile'])->name('worker-profile')->middleware('worker-page-disable-middleware');
        Route::post('update-profile-address', [WorkerLoginController::class, 'updateWorkerAddress'])->name('update-current-address');

        Route::post('add-family', [WorkerLoginController::class, 'addFamily'])->name('add-worker-family');
        Route::get('worker-subscription', [WorkerLoginController::class, 'ShowSubscription'])->name('worker-subscription');
        Route::get('worker-subscription-new', [WorkerLoginController::class, 'ShowSubscriptionNew'])->name('worker-subscription-new')->middleware('csc-middleware');
        Route::get('create-subscription-payment', [WorkerLoginController::class, 'createPayment'])->name('create-subscription-payment');
        Route::post('create-worker-subscription', [WorkerLoginController::class, 'createSubscription'])->name('create-worker-subscriptions');
        Route::post('create-worker-subscription-ex', [WorkerLoginController::class, 'createSubscriptionEx'])->name('create-worker-subscriptions-ex');
        Route::post('/check-subscription-type', [WorkerLoginController::class, 'checkSubscriptionType']);
        Route::get('my-subscription', [WorkerLoginController::class, 'mySubscription'])->name('my-subscription')->middleware('csc-middleware');
        ;
        Route::get('worker-renew-application', [WorkerLoginController::class, 'renewApplication'])->name('renew-application')->middleware('csc-middleware');
        ;
        Route::get('update-worker-renew-application', [WorkerLoginController::class, 'renewApplicationUpdate'])->name('renew-application-update');
        Route::post('save-renew-application', [WorkerLoginController::class, 'saveWorkBook'])->name('save-workbook-application');
        Route::post('update-renew-application', [WorkerLoginController::class, 'updateWorkbook'])->name('update-workbook-application');
        Route::post('worker-renewal-payment', [WorkerLoginController::class, 'renewalPayment'])->name('pay-renewal-amount');
        Route::get('preview-renewal-application', [WorkerLoginController::class, 'previewRenewal'])->name('preview-renewal-data');
        Route::get('final-submit', [WorkerLoginController::class, 'SubmitRenewal'])->name('save-renewal');
        Route::get('acknowledgement', [WorkerLoginController::class, 'acknowledgementRenewal'])->name('acknowledgement-renewal');
        Route::get('download-acknowledgement', [WorkerLoginController::class, 'downloadAckPdfRenewal'])->name('download-acknowledgement-renewal');
        Route::get('worker-renewal-history', [WorkerLoginController::class, 'renewalHistory'])->name('worker-renewal-history');
        Route::get('main-worker', [IndexController::class, 'testData']);
        //        Route::get('/application-status', [WorkerLoginController::class, 'getStatus'])->name('application.status');
        Route::get('download-preview-page', [WorkerLoginController::class, 'downloadPreviewPDFRen'])->name('download-preview');




        Route::prefix('receipts')->name('receipts.')->group(function () {
            Route::get('/', [ReceiptController::class, 'index'])->name('index');
            Route::post('/', [ReceiptController::class, 'store'])->name('store');
            Route::post('update', [ReceiptController::class, 'update'])->name('update');
            Route::post('delete', [ReceiptController::class, 'delete'])->name('delete');
        });

        Route::get('payment-details', [WorkerLoginController::class, 'registrationPaymentDetails'])->name('payment-details');
        Route::get('/payment-successful/{department_id}', [WorkerLoginController::class, 'paymentSuccessful'])->name('payment-successful');
        Route::get('/payment-table', [WorkerLoginController::class, 'paymentTable'])->name('payment-table')->middleware('worker-page-disable-middleware');

        Route::get('subscription-payment-receipt/{id}', [WorkerLoginController::class, 'subscriptionReceipt'])
            ->name('download-payment-sub-pdf');


        /**save prelimnary data **/
        Route::get('send-to-onboarding', [MasterWorkerController::class, 'sendToOnboarding'])->name('send-to-onboarding');
        Route::get('new-registration-consent', [MasterWorkerController::class, 'registrationConsent'])->name('new-registration-consent');
        Route::get('worker-new-register-check', [MasterWorkerController::class, 'checkBeforeNewRegister'])->name('new-register');
        Route::get('check-phone-count', [MasterWorkerController::class, 'checkPhoneCount'])->name('check-before-validate');
        Route::post('/delete-worker-tables', [MasterWorkerController::class, 'deleteWorkerData'])->name('delete-worker-data');

        Route::post('change-route', [MasterWorkerController::class, 'changeRoute'])->name('change-route');
        Route::post('/check-phone', [MasterWorkerController::class, 'checkPhone'])->name('check.phone');
        Route::post('account-details', [MasterWorkerController::class, 'getAccountDetails'])->name('account.details');
        Route::post('save-phone-no', [MasterWorkerController::class, 'savePhone'])->name('save-phone-no');
        Route::get('worker-new-register', [MasterWorkerController::class, 'NewRegWorker'])->name('new-auth-uidai-worker');
        Route::post('/worker-registration', [MasterWorkerController::class, 'newRegister'])->name('worker-reg');
        Route::post('/worker-login', [MasterWorkerController::class, 'logMainPage'])->name('login-basic-details');
        Route::post('/verify-phone-number', [MasterWorkerController::class, 'verifyWorkerMobile'])->name('auth-otp-worker');
        Route::get('/otp-verification', [MasterWorkerController::class, 'OTPPage'])->name('OTP-gen-page');
        Route::post('/worker-login-temporary', [MasterWorkerController::class, 'loginWithTempId'])->name('login-with-temp-id');
        Route::get('/worker-login-resubmit/{temp_worker_id}', [MasterWorkerController::class, 'loginWithResubmit'])->name('login-with-resubmit');

        /** route to Basic Deatils page */

        Route::get('update-office-address-page', [MasterWorkerController::class, 'officeAddress'])->name('update-office-address-page');
        Route::post('update-office-address', [MasterWorkerController::class, 'updateWorkerOffice'])->name('update-office-address');

        Route::get('worker-basic-details', [MasterWorkerController::class, 'mainPage'])->name('main-page');

        Route::get('update-payement-details', [MasterWorkerController::class, 'updatePayementDetails'])->name('update-payement-details');
        Route::get('update-previous-payment-details', [MasterWorkerController::class, 'updatePreviousPayementDetails'])->name('update-previous-payment-details');
        Route::post('update-acknowledgement-number', [MasterWorkerController::class, 'updateAcknowledgementNumber'])->name('update-acknowledgement-number');
        /** save basic details */
        Route::post('save-basic-details', [MasterWorkerController::class, 'saveBasic'])->name('save-basic-page');

        /** Update basic data **/
        Route::post('update-basic-data', [MasterWorkerController::class, 'updateBasic'])->name('update-basic-data');

        /** Pass data to address page with view */
        Route::get('worker-registration-address', [MasterWorkerController::class, 'pageAddress'])->name('submit-basic-details');

        /** Save address details */
        Route::post('save-address-details', [MasterWorkerController::class, 'saveAddress'])->name('submit-address');

        /** Update address if user exists */
        Route::post('update-address-data', [MasterWorkerController::class, 'updateAddress'])->name('update-worker-address');

        /** pass data to bank details **/
        Route::get('worker-bank-details', [MasterWorkerController::class, 'pageBank'])->name('save-address');

        /** Save bank details */
        Route::post('save-bank-details', [MasterWorkerController::class, 'saveBankDetails'])->name('save-bank-details');

        /** update bank details */
        Route::post('update-bank-details', [MasterWorkerController::class, 'updateBank'])->name('update-bank-details');

        /** pass data to family details */
        Route::get('worker-family-details', [MasterWorkerController::class, 'pageFamily'])->name('submit-bank');

        /** Save family details */
        Route::post('save-family-details', [MasterWorkerController::class, 'saveFamily'])->name('save-family-details');

        Route::post('/delete-family-member', [MasterWorkerController::class, 'deleteFamilyMember'])->name('delete-family-member');


        /** Update family details */
        Route::post('update-family-details', [MasterWorkerController::class, 'updateFamily'])->name('update-family-details');


        /** Pass data to employer page */
        Route::get('worker-employer-details', [MasterWorkerController::class, 'pageEmployer'])->name('submit-family-details');

        /**save employer data */
        Route::post('save-employer-details', [MasterWorkerController::class, 'saveEmployer'])->name('save-employer-data');
        Route::get('certificate/{worker_id}', [MasterWorkerController::class, 'viewCertificate'])->name('worker.certificate.view');

        /** Update Employer Data **/
        Route::post('update-employer-data', [MasterWorkerController::class, 'updateEmployer'])->name('update-employer-data');
        Route::delete('certificate/{id}', [MasterWorkerController::class, 'destroyCertificate'])->name('certificate.destroy');


        /** pass data to working certificate */
        //    Route::get('worker-working-certificate',[MasterWorkerController::class,'pageSchemes'])->name('submit-employer-details');

        /**save data working certificate */
        //    Route::post('save-worker-certificate',[MasterWorkerController::class,'saveCertificate'])->name('save-certificate-details');

        /** Update working certificate */
        //    Route::post('update-certificate-details',[MasterWorkerController::class,'updateCertificate'])->name('update-certificate-details');

        /** Pass Data to Schemes page */
        Route::get('worker-schemes-details', [MasterWorkerController::class, 'pageSchemes'])->name('submit-employer-details');

        /** Save scheme data **/
        Route::post('save-scheme-details', [MasterWorkerController::class, 'saveScheme'])->name('save-schemes-details');

        /** Update Scheme Data */
        Route::post('update-scheme-details', [MasterWorkerController::class, 'updateScheme'])->name('update-scheme-details');

        /** pass data to documents page */
        Route::get('worker-documents-details', [MasterWorkerController::class, 'pageDocument'])->name('submit-schemes-details');

        /** save documents **/
        Route::post('/save-worker-documents', [MasterWorkerController::class, 'saveDocument'])->name('save-worker-documents');

        /** Pass data to Preview **/
        Route::get('worker-data-preview', [MasterWorkerController::class, 'previewPage'])->name('submit-document-details');

        /** Save Final Worker Data **/
        Route::get('save-worker-data', [MasterWorkerController::class, 'finalSubmit'])->name('save-final-data');

        /** Payment Page */
        Route::get('worker-payment', [MasterWorkerController::class, 'registrationPayment'])->name('submit-worker-payment');

        /** Payment Receipt */
        Route::get('/payment-success', [MasterWorkerController::class, 'paymentSuccessful'])->name('payment-status');

        /** Acknowledge Page */
        Route::get('submit-success', [MasterWorkerController::class, 'ackPage'])->name('print-ack');

        /** update docs from preview */
        Route::get('update-documents-page', [MasterWorkerController::class, 'editDocument'])->name('update-documents');

        /**update documents**/
        Route::post('update-worker-documents', [MasterWorkerController::class, 'updateDocument'])->name('update-worker-documents');

        /**get the preview page from edit docs**/
        Route::get('preview-page', [MasterWorkerController::class, 'previewFromDoc'])->name('preview-page');
        Route::get('/return-home-new', [MasterWorkerController::class, 'returnHomeNew'])->name('return-home-new');

        Route::post('update-office', [MasterWorkerController::class, 'updateOffice'])->name('update-office');

        /** get to schemes page for edit **/
        Route::get('update-schemes-page', [MasterWorkerController::class, 'editSchemes'])->name('update-schemes');

        Route::post('check-worker-phone', [MasterWorkerController::class, 'checkPhone'])->name('check-phone-no');

        /** View Documents start */
        Route::get('get-worker-id-proof/{id}', [MasterWorkerController::class, 'getIdProof'])->name('get-id-proof');
        Route::get('get-worker-res-proof/{id}', [MasterWorkerController::class, 'getResProof'])->name('get-res-proof');
        Route::get('get-worker-age-proof/{id}', [MasterWorkerController::class, 'getAgeProof'])->name('get-age-proof');
        Route::get('get-worker-bank-copy/{id}', [MasterWorkerController::class, 'getWorkerBankCopy'])->name('get-bank-copy');
        Route::get('get-worker-payment-acknowledgement-slip/{id}', [MasterWorkerController::class, 'paymentAcknowledgementSlip'])->name('get-payment-ack-slip');
        Route::get('get-worker-certificate-proof/{id}', [MasterWorkerController::class, 'getCertProof'])->name('get-cert-proof');
        Route::get('get-worker-passport/{id}', [MasterWorkerController::class, 'getPassport'])->name('get-passport');
        Route::get('get-worker-thumb/{id}', [MasterWorkerController::class, 'getThumb'])->name('get-thumb');
        Route::get('get-worker-address-proof/{id}', [MasterWorkerController::class, 'getAddress'])->name('get-address-proof');
        Route::get('get-worker-bank-pass/{id}', [MasterWorkerController::class, 'getBankCopy'])->name('get-bank-pass');
        Route::get('get-worker-decl/{id}', [MasterWorkerController::class, 'decl'])->name('get-decl');
        Route::get('get-nominee_bank_copy/{id}', [MasterWorkerController::class, 'getNomineeBankCopy'])->name('nominee_bank_copy');
        Route::get('get-worker-ration/{id}', [MasterWorkerController::class, 'getRation'])->name('get-ration_card');
        Route::get('get-worker-pan/{id}', [MasterWorkerController::class, 'getPan'])->name('get-pan_card');
        Route::get('get-work-book/{id}', [MasterWorkerController::class, 'getWorkBook'])->name('get-work-book');
        /** View Documents End **/

        Route::post('encrypt-data', [eShramController::class, 'encryptData']);
        Route::post('encrypt-data-uan', [eShramController::class, 'encryptUan']);
        Route::post('generate-auth-token', [eShramController::class, 'generateAuthToken']);
        Route::post('validate-uan-no', [eShramController::class, 'validateUan']);



        Route::get('/otpgeneration', [AuthOtpController::class, 'otpgenerationEnc']);
        Route::get('/authenticationotp', [AuthOtpController::class, 'authenticationotpEnc']);
        Route::get('/ekyc', [AuthOtpController::class, 'ekycEnc']);

        Route::post('generate-otp-aadhaar', [AuthOtpController::class, 'generateAadharOtp'])->name('generate-otp-aadhaar');
        Route::post('ekyc-otp-aadhaar', [AuthOtpController::class, 'ekycAadhaar'])->name('otp-verification');


        Route::prefix('family-aadhaar')->name('family.aadhaar.')->group(function () {
            Route::post('/send-otp', [FamilyAadhaarVerificationController::class, 'sendFamilyMemberOtp'])->name('send-otp');
            Route::post('/verify-otp', [FamilyAadhaarVerificationController::class, 'verifyFamilyMemberOtp'])->name('verify-otp');
            Route::post('/save-details', [FamilyAadhaarVerificationController::class, 'saveKycDetails'])->name('save-details');
        });

        /** Get office list from district */
        Route::get('get-office', [MasterWorkerController::class, 'getOffice'])->name('get-office-reg');

        /** Get district and subdistrict */
        Route::get('get-districts', [MasterWorkerController::class, 'getDistricts']);
        Route::get('get-subdistricts-postoffc', [MasterWorkerController::class, 'getSubdistPostOffc']);
        Route::get('get-subdistricts', [MasterWorkerController::class, 'getSubDist']);
        Route::get('get-pincode', [MasterWorkerController::class, 'getPin']);
        Route::get('/getskills', [MasterWorkerController::class, 'getSkills']);
        Route::get('/getrationtype', [MasterWorkerController::class, 'getRationType']);

        /** Get bank */
        Route::post('get-bank-details', [MasterWorkerController::class, 'getBank'])->name('get-bank-details-ifsc');

        Route::get('acknowledgement-receipt', [MasterWorkerController::class, 'downloadAckPdf'])->name('download-ack-pdf');
        Route::get('payment-receipt', [MasterWorkerController::class, 'paymentReceiptPdf'])->name('download-payment-pdf');

        // Payments
        Route::get("registration-payments", [PaymentController::class, 'index'])->name('payment.reg');
        //        Route::get('/download-pdf', [MasterWorkerController::class, 'downloadPDF'])->name('download-ack-pdf');
        Route::get('/download-preview-pdf', [MasterWorkerController::class, 'downloadPreviewPagePDF'])->name('download-final-preview-pdf');

        // ID Card


    });


    Route::prefix('idcards')->name('idcards.')->group(function () {
        Route::get('/', [IdCardController::class, 'index'])->name('index');
        Route::post('/', [IdCardController::class, 'store'])->name('store');
        Route::post('update', [IdCardController::class, 'update'])->name('update');
        Route::post('delete', [IdCardController::class, 'delete'])->name('delete');
        Route::get('view', [IdCardController::class, 'view'])->name('view');
    });


    Route::prefix('nominee')->name('nominee.')->group(function () {
        Route::get('/', [NomineeRegistrationController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/e-kyc/{id}', [NomineeRegistrationController::class, 'nomineeEkyc'])->name('ekyc');
        Route::get('ekyc-pdf/{family_id}', [NomineeRegistrationController::class, 'downloadKycAcknowledgment'])->name('ekyc-ack');
    });
    // ===================END LOCALIZATION==============================


    // =======================SEWASETU=================================
    Route::prefix('api/sewasetu')->group(function () {
        Route::post('registration', [PfcController::class, 'registration']);
        Route::post('postsubmission', [PfcController::class, 'postSubmissionEnc']);

        Route::get('login/{rtps_trans_id}', [PfcController::class, 'loginforSubscription'])->name('subscriptionLogin');

        Route::get('acknowledgement/{enc_id}', [PfcController::class, 'getAcknowledgement']);

        Route::get('id-card/{enc_id}', [PfcController::class, 'getIdCard']);

        Route::post('get-application-certificate', [PfcController::class, 'getCertificate']);

        Route::post('get-account_details', [PfcController::class, 'getAccountDetails'])->name('sewasetu.accountDetails');


        // Route::post('encrypt',[PfcController::class,'encryptDataforTest']);
        Route::post('postsubmissiondec', [PfcController::class, 'postSubmissionDec']);
    });

    //    // =======================SEWASETU CSC=================================
    Route::prefix('api/csc')->group(function () {
        Route::post('registration', [PfcController::class, 'registration']);
        Route::post('postsubmission', [PfcController::class, 'postSubmissionEnc']);

        Route::get('login/{rtps_trans_id}', [PfcController::class, 'loginforSubscription'])->name('subscriptionLogin');

        Route::get('acknowledgement/{enc_id}', [PfcController::class, 'getAcknowledgement']);

        Route::get('id-card/{enc_id}', [PfcController::class, 'getIdCard']);

        Route::post('get-application-certificate', [PfcController::class, 'getCertificate']);

        Route::post('get-account_details', [PfcController::class, 'getAccountDetails'])->name('sewasetu.accountDetails');

        Route::get('/payment/{cscId}', [\App\Http\Controllers\Worker\CscPaymentController::class, 'index'])
            ->name('payment.initiate');

        Route::get('/store-worker/{workerId}', function ($workerId) {
            session(['worker_id' => $workerId]);
            return response()->json(['status' => 'ok']);
        })->name('store.worker.session');

        Route::get('/subscription-payment/{cscId}', [\App\Http\Controllers\Worker\CscSubscriptionController::class, 'index'])
            ->name('payment-s.initiate-s');

        Route::post('/payment/success', [\App\Http\Controllers\Worker\CscPaymentController::class, 'success'])->name('payment.success');
        Route::post('/payment/response', [\App\Http\Controllers\Worker\CscPaymentController::class, 'handlePaymentResponse'])->name('payment.response');
        Route::post('/subscription-payment/response', [\App\Http\Controllers\Worker\CscSubscriptionController::class, 'handlePaymentResponse'])->name('sub-payment.sub-response');
        Route::get('/payment-log/status', [\App\Http\Controllers\Worker\CscPaymentController::class, 'status'])->name('status-api');
        Route::get('/refund-log', [\App\Http\Controllers\Worker\CscPaymentController::class, 'refundlog'])->name('refund-log');

        //        Route::post('/subscription-payment/response', [\App\Http\Controllers\Worker\CscSubscriptionController::class, 'handlePaymentResponse'])->name('sub-payment.sub-response');


        //

        //
//
//        // Route::post('encrypt',[PfcController::class,'encryptDataforTest']);
//        Route::post('postsubmissiondec', [PfcController::class, 'postSubmissionDec']);
    });

    Route::get('any-text', [IndexController::class, 'anyTest']);
    // ==========================END SEWASETU==========================

    /** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/


    // ===================AUTH ROUTES===================
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('getOtp', [OtpController::class, 'sendOtp'])->name('send-otp');
        Route::post('admin', [AdminAuthController::class, 'authenticate'])->name('admin');
        Route::post('office', [OfficeAuthController::class, 'authenticate'])->name('office');
        Route::post('worker', [WorkerAuthController::class, 'authenticate'])->name('worker');
        Route::post('verify-otp', [OtpController::class, 'otpVerification'])->name('verify-otp');
        Route::post('verify-worker-otp', [OtpController::class, 'workerOtpVerification'])->name('verify-worker-otp');
        Route::get('logout', [LogController::class, 'logout'])->name('logout');
    });
    // ===================== END AUTH ROUTES ========================

    // ================== END PUBLIC ROUTE ======================

    Route::get('error-logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
    // ========================= ADMIN ROUTES ===========================
    Route::prefix('admin')->middleware('authuser')->name('admin.')->group(function () {



        // ================================= DASHBOARD ===================================
        Route::prefix('dashboard')->name('dashboard.')->middleware(['prevent-back-history'])->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');
        });
        // =============================== END DASHBOARD ===============================

        // -------------------------------------------------------------------------------------------------------

        // ==================== MASTERDATA ROUTES ====================

        // ====================== STATE ====================
        Route::prefix('states')->name('states.')->group(function () {
            Route::get('/', [StateController::class, 'index'])->name('index');
            Route::post('/', [StateController::class, 'store'])->name('store');
            Route::post('update', [StateController::class, 'update'])->name('update');
            Route::post('update-status', [StateController::class, 'updateStatus'])->name('status');
        });
        // ==================== END STATE ==================

        // ==================== DISTRICT ===================
        Route::prefix('districts')->name('districts.')->group(function () {
            Route::get('/', [DistrictController::class, 'index'])->name('index');
            Route::post('/', [DistrictController::class, 'store'])->name('store');
            Route::post('update', [DistrictController::class, 'update'])->name('update');
            Route::post('update-status', [DistrictController::class, 'updateStatus'])->name('status');
        });
        // ================== END DISTRICT =================

        // ================== SUB DISTRICT ==================
        Route::prefix('sub-districts')->name('sub-districts.')->group(function () {
            Route::get('/', [SubDistrictController::class, 'index'])->name('index');
            Route::post('/', [SubDistrictController::class, 'store'])->name('store');
            Route::post('update', [SubDistrictController::class, 'update'])->name('update');
            Route::post('delete', [SubDistrictController::class, 'delete'])->name('delete');
        });
        // ================ END SUB DISTRICT ===============

        // ================== BANK ==================
        Route::prefix('banks')->name('banks.')->group(function () {
            Route::get('/', [BankController::class, 'index'])->name('index');
            Route::post('search', [BankController::class, 'search'])->name('search');
            Route::post('/', [BankController::class, 'store'])->name('store');
            Route::post('update', [BankController::class, 'update'])->name('update');
            Route::post('delete', [BankController::class, 'delete'])->name('delete');
        });
        // ================ END BANK ===============

        // ================== POST OFFICE ==================
        Route::prefix('post-offices')->name('post-offices.')->group(function () {
            Route::get('/', [PostOfficeController::class, 'index'])->name('index');
            Route::post('/', [PostOfficeController::class, 'store'])->name('store');
            Route::post('search', [PostOfficecontroller::class, 'search'])->name('search');
            Route::post('update', [PostOfficeController::class, 'update'])->name('update');
            Route::post('delete', [PostOfficeController::class, 'delete'])->name('delete');
        });
        // ================ END POST OFFICE ================

        // ================== CATEGORY ==================
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::post('update', [CategoryController::class, 'update'])->name('update');
            Route::post('delete', [CategoryController::class, 'delete'])->name('delete');
        });
        // ================ END CATEGORY ================

        // ================== EDUCATION ==================
        Route::prefix('educations')->name('educations.')->group(function () {
            Route::get('/', [EducationController::class, 'index'])->name('index');
            Route::post('/', [EducationController::class, 'store'])->name('store');
            Route::post('update', [EducationController::class, 'update'])->name('update');
            Route::post('delete', [EducationController::class, 'delete'])->name('delete');
        });
        // ================ END EDUCATION ================

        // ================== GENDER ==================
        Route::prefix('genders')->name('genders.')->group(function () {
            Route::get('/', [GenderController::class, 'index'])->name('index');
            Route::post('/', [GenderController::class, 'store'])->name('store');
            Route::post('update', [GenderController::class, 'update'])->name('update');
            Route::post('delete', [GenderController::class, 'delete'])->name('delete');
        });
        // ================ END GENDER ================

        // ==================HOUSE TYPE==================
        Route::prefix('house-types')->name('house-types.')->group(function () {
            Route::get('/', [HouseTypeController::class, 'index'])->name('index');
            Route::post('/', [HouseTypeController::class, 'store'])->name('store');
            Route::post('update', [HouseTypeController::class, 'update'])->name('update');
            Route::post('delete', [HouseTypeController::class, 'delete'])->name('delete');
        });
        // ================END HOUSE TYPE================

        // ==================MARITAL STATUS==================
        Route::prefix('marital-statuses')->name('marital-statuses.')->group(function () {
            Route::get('/', [MaritalStatusController::class, 'index'])->name('index');
            Route::post('/', [MaritalStatusController::class, 'store'])->name('store');
            Route::post('update', [MaritalStatusController::class, 'update'])->name('update');
            Route::post('delete', [MaritalStatusController::class, 'delete'])->name('delete');
        });
        // ================END MARITAL STATUS================

        // ==================NATURE OF WORK==================
        Route::prefix('nature-of-works')->name('nature-of-works.')->group(function () {
            Route::get('/', [NatureOfWorkController::class, 'index'])->name('index');
            Route::post('/', [NatureOfWorkController::class, 'store'])->name('store');
            Route::post('update', [NatureOfWorkController::class, 'update'])->name('update');
            Route::post('delete', [NatureOfWorkController::class, 'delete'])->name('delete');
        });
        // ================END NATURE OF WORK================

        // ==================RESIDENCE TYPE==================
        Route::prefix('residence-types')->name('residence-types.')->group(function () {
            Route::get('/', [ResidenceTypeController::class, 'index'])->name('index');
            Route::post('/', [ResidenceTypeController::class, 'store'])->name('store');
            Route::post('update', [ResidenceTypeController::class, 'update'])->name('update');
            Route::post('delete', [ResidenceTypeController::class, 'delete'])->name('delete');
        });
        // ================END RESIDENCE TYPE================

        // ==================ISSUER TYPE==================
        Route::prefix('issuer-types')->name('issuer-types.')->group(function () {
            Route::get('/', [IssuerTypeController::class, 'index'])->name('index');
            Route::post('/', [IssuerTypeController::class, 'store'])->name('store');
            Route::post('update', [IssuerTypeController::class, 'update'])->name('update');
            Route::post('delete', [IssuerTypeController::class, 'delete'])->name('delete');
        });
        // ================END ISSUER TYPE================

        // ==================WORK TYPE==================
        Route::prefix('work-types')->name('work-types.')->group(function () {
            Route::get('/', [WorkTypeController::class, 'index'])->name('index');
            Route::post('/', [WorkTypeController::class, 'store'])->name('store');
            Route::post('update', [WorkTypeController::class, 'update'])->name('update');
            Route::post('delete', [WorkTypeController::class, 'delete'])->name('delete');
        });
        // ================END WORK TYPE================

        // ==================DESIGNATION==================
        Route::prefix('designations')->name('designations.')->group(function () {
            Route::get('/', [DesignationController::class, 'index'])->name('index');
            Route::post('/', [DesignationController::class, 'store'])->name('store');
            Route::post('update', [DesignationController::class, 'update'])->name('update');
            Route::post('delete', [DesignationController::class, 'delete'])->name('delete');
        });
        // ================END DESIGNATION================

        // ==================AGE PROOF==================
        Route::prefix('age-proofs')->name('age-proofs.')->group(function () {
            Route::get('/', [AgeProofController::class, 'index'])->name('index');
            Route::post('/', [AgeProofController::class, 'store'])->name('store');
            Route::post('update', [AgeProofController::class, 'update'])->name('update');
            Route::post('delete', [AgeProofController::class, 'delete'])->name('delete');
        });
        // ================END AGE PROOF================

        // ====================SCHEME====================
        Route::prefix('schemes')->name('schemes.')->group(function () {
            Route::get('/', [SchemesController::class, 'index'])->name('index');
            Route::post('/', [SchemesController::class, 'store'])->name('store');
            Route::post('update', [SchemesController::class, 'update'])->name('update');
            Route::post('delete', [SchemesController::class, 'delete'])->name('delete');
        });
        // ==================END SCHEME==================

        // ====================PROFESSION====================
        Route::prefix('professions')->name('professions.')->group(function () {
            Route::get('/', [ProfessionController::class, 'index'])->name('index');
            Route::post('/', [ProfessionController::class, 'store'])->name('store');
            Route::post('update', [ProfessionController::class, 'update'])->name('update');
            Route::post('delete', [ProfessionController::class, 'delete'])->name('delete');
        });
        // ==================END PROFESSION==================


        // ====================RATION TYPE====================
        Route::prefix('ration-types')->name('ration-types.')->group(function () {
            Route::get('/', [RationTypeController::class, 'index'])->name('index');
            Route::post('/', [RationTypeController::class, 'store'])->name('store');
            Route::post('update', [RationTypeController::class, 'update'])->name('update');
            Route::post('delete', [RationTypeController::class, 'delete'])->name('delete');
        });
        // ==================END RATION TYPE==================

        // ====================Reason TYPE====================
        Route::prefix('reasons')->name('reasons.')->group(function () {
            Route::get('/', [ReasonsController::class, 'index'])->name('index');
            Route::post('/', [ReasonsController::class, 'store'])->name('store');
            Route::post('update', [ReasonsController::class, 'update'])->name('update');
            Route::post('delete', [ReasonsController::class, 'delete'])->name('delete');
            Route::post('update-status', [ReasonsController::class, 'updateStatus'])->name('status');
        });
        // ==================END RATION TYPE==================

        // ====================SKILL====================
        Route::prefix('skills')->name('skills.')->group(function () {
            Route::get('/', [SkillController::class, 'index'])->name('index');
            Route::post('/', [SkillController::class, 'store'])->name('store');
            Route::post('update', [SkillController::class, 'update'])->name('update');
            Route::post('delete', [SkillController::class, 'delete'])->name('delete');
        });
        // ==================END SKILL==================

        // ====================AMOUNTS====================
        Route::prefix('amounts')->name('amounts.')->group(function () {
            Route::get('/', [AmountController::class, 'index'])->name('index');
            Route::post('/', [AmountController::class, 'store'])->name('store');
            Route::post('update', [AmountController::class, 'update'])->name('update');
            Route::post('delete', [AmountController::class, 'delete'])->name('delete');
        });

        Route::prefix('relation')->name('relation.')->group(function () {
            Route::get('/', [RelationController::class, 'index'])->name('index');

            Route::post('update', [RelationController::class, 'update'])->name('update');
            // Route::post('delete/{id}', [RelationController::class, 'destroy'])->name('destroy');


        });
        // ==================END AMOUNTS==================

        // ====================END MASTERDATA====================

        // ----------------------------------------------------------------------------------------------------------

        // ====================OFFICE MANAGEMENT====================

        // ======================OFFICE======================
        Route::prefix('offices')->name('offices.')->group(function () {
            Route::get('/', [OfficeController::class, 'index'])->name('index');
            Route::post('/', [OfficeController::class, 'store'])->name('store');
            Route::post('update', [OfficeController::class, 'update'])->name('update');
            Route::post('update-status', [OfficeController::class, 'updateStatus'])->name('status');
            Route::post('delete', [OfficeController::class, 'delete'])->name('delete');
        });
        // ====================END OFFICE====================

        // ====================END OFFICE MANAGEMENT====================

        // ---------------------------------------------------------------------------------------------------------

        // ====================USER MANAGEMENT====================

        // =======================ROLE=======================
        Route::prefix('user-roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::post('update', [RoleController::class, 'update'])->name('update');
            Route::post('delete', [RoleController::class, 'delete'])->name('delete');
            Route::get('{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('add-permission');
            Route::put('{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole'])->name('give-permission');
        });
        // =====================END ROLE=====================

        // =======================USER=======================
        Route::prefix('users-data')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('transfer-data', [UserController::class, 'indexTransfer'])->name('transfer-index');
            Route::put('/update-document/{id}', [UserController::class, 'updateTransferDocument'])
                ->name('transfer-document-update');

            Route::delete('/delete-document/{id}', [UserController::class, 'deleteDocument'])
                ->name('transfer-document-delete');
            Route::get('/transfer/document/{filename}', [UserController::class, 'viewDocument'])->name('transfer-document-view');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::post('update', [UserController::class, 'update'])->name('update');
            Route::post('transfer', [UserController::class, 'transferUser'])->name('transfer');
            Route::post('update-status', [UserController::class, 'updateStatus'])->name('status');
            Route::post('reset-password', [UserController::class, 'resetPassword'])->name('reset-user-password');
        });


        // =====================PERMISSION=====================


        Route::prefix('user-permission')->name('permission.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
            Route::post('update', [PermissionController::class, 'update'])->name('update');
            Route::post('delete', [PermissionController::class, 'delete'])->name('delete');
        });

        // =====================END USER=====================

        // ====================END USER MANAGEMENT====================
        // ---------------------------------------------------------------------------------------------------
        // ====================CONTENT MANAGEEMENT========================

        // ==================== GALLERY CATEGORY =========================

        Route::prefix('gallery-categories')->name('gallery-categories.')->group(function () {
            Route::get('/', [GalleryCategoryController::class, 'index'])->name('index');
            Route::post('/', [GalleryCategoryController::class, 'store'])->name('store');
            Route::post('update', [GalleryCategoryController::class, 'update'])->name('update');
            Route::post('delete', [GalleryCategoryController::class, 'delete'])->name('delete');
        });
        // ====================END GALLERY CATEGORY =========================

        // ==================== GALLERY =========================

        Route::prefix('galleries')->name('galleries.')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('index');
            Route::post('/', [GalleryController::class, 'store'])->name('store');
            Route::get('/create', [GalleryController::class, 'create'])->name('create');
            Route::post('update', [GalleryController::class, 'update'])->name('update');
            Route::post('delete', [GalleryController::class, 'delete'])->name('delete');
        });
        // =========================END GALLERY=========================

        // ==================== CONTENT =========================
        Route::prefix('contents')->name('contents.')->group(function () {
            Route::get('/', [ContentController::class, 'index'])->name('index');
            Route::post('/', [ContentController::class, 'store'])->name('store');
            Route::post('update', [ContentController::class, 'update'])->name('update');
            Route::post('delete', [ContentController::class, 'delete'])->name('delete');
        });
        // Index Notification Routes
        Route::prefix('index_notification')->name('index_notification.')->group(function () {
            Route::get('/', [IndexNotificationController::class, 'index'])->name('index');

            Route::post('/', [IndexNotificationController::class, 'store'])->name('store');
            Route::get('/create', [IndexNotificationController::class, 'create'])->name('create');

            Route::get('/edit/{id}', [IndexNotificationController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [IndexNotificationController::class, 'update'])->name('update');
            Route::post('/delete', [IndexNotificationController::class, 'delete'])->name('delete');
            // New Route for Index Notifications
            Route::get('/index_notifications', [IndexNotificationController::class, 'indexnotification'])->name('indexnotification');
        });






        // =========================END CONTENT=========================

        // ====================END CONTENT MANAGEEMENT====================

        // ---------------------------------------------------------------------------------------------------

        // ==================== START MIS DATA ==========================

        // ==================== START PFC DATA =========================
        Route::prefix('pfcdata')->name('pfcdata.')->group(function () {
            Route::get('/', [PFCDataController::class, 'index'])->name('index');
            Route::get('/export/{type}', [PFCDataController::class, 'export'])->name('export');
        });

        Route::prefix('application')->name('trackapp.')->group(function () {
            //            Route::get('/', [AdminAppController::class, 'index'])->name('index');
            Route::get('/applications', [AdminAppController::class, 'index'])->name('index');
            Route::get('/applications/list', [AdminAppController::class, 'list'])->name('list');
            Route::get('/applications/track/{worker_id}', [AdminAppController::class, 'track'])
                ->where('worker_id', '.*')
                ->name('track');
            Route::get('/applications/summary', [AdminAppController::class, 'summary'])->name('summary');
            Route::get('/applications/preview/{id}', [AdminAppController::class, 'previewAdmin'])
                ->name('previewadmin');

        });
        // =========================END PFC DATA=========================

        // ==================== START PORTAL USER DATA =========================
        Route::prefix('portalusers')->name('portalusers.')->group(function () {
            Route::get('/', [PortalUserController::class, 'index'])->name('index');
        });

        Route::prefix('otp')->name('otp.')->group(function () {
            Route::get('/', [MISDistrictWiseDataController::class, 'getOtp'])->name('user-otp');
        });

        Route::prefix('bulk-data')->group(function () {
            Route::get('vault', [BulkVaultDataController::class, 'getData'])->name('bulk-data');
            Route::get('vault/export', [BulkVaultDataController::class, 'exportCsv'])->name('vault.export');
            Route::get('migrant-worker', [BulkVaultDataController::class, 'getMigrantData'])->name('migrant-bulk-data');
            Route::get('migrant/export', [BulkVaultDataController::class, 'exportMigrantCsv'])->name('vault.export-migrant');
        });

        // ==================== END PORTAL USER DATA =========================
        Route::prefix('eshram')->name('eshram.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\errorlogs\UanErrorLogsController::class, 'index'])->name('error-log');
        });
        // ==================== START WORKER REGISTRATION DATA =========================
        Route::prefix('workerdata')->name('workerdata.')->group(function () {
            Route::get('/', [WorkerRegistrationStatusController::class, 'index'])->name('index');
            Route::get('/export/{type}', [WorkerRegistrationStatusController::class, 'export'])->name('export');

        });
        // ========================= END WORKER REGISTRATION DATA =========================

        // ==================== START ALREADY REGISTERED DATA =========================
        Route::prefix('alreadyregdata')->name('alreadyregdata.')->group(function () {
            Route::get('/', [AlreadyRegisteredStatusController::class, 'index'])->name('index');
        });
        // ========================= END ALREADY REGISTERED DATA =========================

        // ==================== START RENEWAL DATA =========================
        Route::prefix('renewaldata')->name('renewaldata.')->group(function () {
            Route::get('/', [RenewalDataController::class, 'index'])->name('index');
            Route::get('app/{id}', [RenewalDataController::class, 'previewRenewal'])->name('open-renewal-app');
        });
        // ========================= END END RENEWAL DATA =========================

        // ==================== START DISTRICT WISE DATA =========================
        Route::prefix('districtwise')->name('districtwise.')->group(function () {
            Route::get('/', [DistrictWiseDataController::class, 'index'])->name('index');
            Route::get('/export/{type}', [DistrictWiseDataController::class, 'export'])->name('export');
        });
        // ========================= END DISTRICT WISE DATA =========================

        // ==================== START OFFICE WISE DATA =========================
        Route::prefix('allusers')->name('allusers.')->group(function () {
            Route::get('/', [AllUsersDataController::class, 'index'])->name('index');
            Route::get('/datewise', [AllUsersDataController::class, 'filterUserData'])->name('datewise');
        });

        Route::prefix('profession-wise')->name('profession-wise.')->group(function () {
            Route::get('/', [ProfessionWiseDataController::class, 'index'])->name('index');
        });

        Route::prefix('officewise')->name('officewise.')->group(function () {
            Route::get('/', [OfficeWiseDataController::class, 'index'])->name('index');
            Route::get('/user-data/{office_id}', [OfficeWiseDataController::class, 'getUserData'])->name('user-data');
            Route::get('/filter-data', [OfficeWiseDataController::class, 'filterData'])->name('filter-data');
            Route::get('/filter-user-data', [OfficeWiseDataController::class, 'filterUserData'])->name('filter-user-data');
            Route::get('/export/{type}', [OfficeWiseDataController::class, 'export'])->name('export');
            Route::get('renewal', [OfficeWiseDataController::class, 'indexRenewal'])->name('index-renewal');
        });




        Route::prefix('dashboard-data')->name('dashboard-data.')->group(function () {
            Route::post('/user-wise-data', [DashboardDataController::class, 'UserWiseData'])->name('user-wise-data');
            Route::match(['get', 'post'], '/{application_type}', [DashboardDataController::class, 'index'])->name('index');
        });
        Route::prefix('dashboard-data-renewal')->name('dashboard-data-renewal.')->group(function () {
            Route::post('/user-wise-data-renewal', [RenewalDashboardDataController::class, 'UserWiseData'])->name('user-wise-data-renewal');
            Route::match(['get', 'post'], '/{application_type}', [RenewalDashboardDataController::class, 'index'])->name('index');
        });

        // ========================= END OFFICE WISE DATA =========================

        // ==================== START PFC WISE DATA =========================
        Route::prefix('pfcwise')->name('pfcwise.')->group(function () {
            Route::get('/', [PFCWiseDataController::class, 'index'])->name('index');
            Route::get('/district', [PFCWiseDataController::class, 'districtWise'])
                ->name('district');
            Route::get('/district/{district_code}/offices', [PFCWiseDataController::class, 'officeWise'])
                ->name('office');
            Route::get('/export/{type}', [PFCWiseDataController::class, 'export'])->name('export');
        });
        // ========================= END PFC WISE DATA =========================
        Route::prefix('cscwise')->name('cscwise.')->group(function () {
            Route::get('/', [PFCWiseDataController::class, 'csc'])->name('csc');
            //            Route::get('/export/{type}', [PFCWiseDataController::class, 'export'])->name('export');
        });
        // ==================== START GENDER WISE DATA =========================
        Route::prefix('workerpaddress')->name('workerpaddress.')->group(function () {
            Route::get('/', [WorkerPAddressOutOfAssamController::class, 'index'])->name('index');
        });
        // ========================= END GENDER WISE DATA =========================
        // ========================= ID CARD DATA =========================
        Route::prefix('idcarddata')->name('idcarddata.')->group(function () {
            Route::get('/', [IdCardDataController::class, 'index'])->name('index');
            Route::post('delete', [IdCardDataController::class, 'delete'])->name('delete');
            Route::get('/export/{type}', [IdCardDataController::class, 'export'])->name('export');
        });
        // =================END ID CARD DATA=========================

        // =========================START PAYMENT DATA =========================
        Route::prefix('paymentdata')->name('paymentdata.')->group(function () {
            Route::get('/', [PaymentDataController::class, 'index'])->name('index');
            Route::post('update-payment-status', [PaymentDataController::class, 'updateStatus'])->name('update-payment-status');
            Route::delete('/payments/{id}', [PaymentDataController::class, 'destroy'])->name('destroy');
            Route::get('/export/{type}', [PaymentDataController::class, 'export'])->name('export');
        });
        Route::prefix('cscdata')->name('csc.')->group(function () {
            Route::get('/', [PaymentDataController::class, 'cscWallet'])->name('csc-data');

            //            Route::delete('/payments/{id}', [PaymentDataController::class, 'destroy'])->name('destroy');
            Route::get('/export/{type}', [PaymentDataController::class, 'export'])->name('export');
        });
        // ==================== END PAYMENT DATA =========================

        //=====================TEST============================
        Route::prefix('dataupdate')->name('dataupdate.')->group(function () {
            Route::get('/show-data', [IdCardDataController::class, 'viewData'])->name('index');
            Route::get('/export/{type}', [IdCardDataController::class, 'exportviewData'])->name('exportdata');
            Route::get('/exportappdata/{type}', [IdCardDataController::class, 'exportviewApplicationData'])->name('export');
            Route::get('edit-family-details/{id}', [IdCardDataController::class, 'editFamilyDetails'])->name('edit-family-details');
            Route::get('edit-certificate-details/{id}', [IdCardDataController::class, 'editCertificateDetails'])->name('edit-certificate-details');
            Route::get('delete-family-details/{id}', [IdCardDataController::class, 'deleteFamilyDetails'])->name('delete-family-details');
            Route::get('delete-certificate-details/{id}', [IdCardDataController::class, 'deleteCertificateDetails'])->name('delete-certificate-details');
            Route::get('/View-app-history', [IdCardDataController::class, 'ViewApplicationData'])->name('ViewApp');
            Route::get('/edit-app/{worker_id}', [IdCardDataController::class, 'editApplicationData'])->name('editApp');
            Route::get('/edit/{worker_id}', [IdCardDataController::class, 'editData'])->name('edit');
            Route::post('/update', [IdCardDataController::class, 'updateData'])->name('update');
            Route::post('/update-app', [IdCardDataController::class, 'updateApplicationData'])->name('updateApp');
            Route::get('/vault-token', [IdCardDataController::class, 'getTokenData'])->name('getToken');
            Route::post('/search-vault-token', [IdCardDataController::class, 'searchTokenData'])->name('get-token');
            Route::post('/search-vault-token-worker', [IdCardDataController::class, 'searchVaultTokenWithWorkerID'])->name('get-token-worker-id');
            Route::post('/search-main-vault-token-worker', [IdCardDataController::class, 'searchMainVaultTokenWithWorkerID'])->name('get-main-token-worker-id');
            Route::post('/search-delete-main-vault-token-worker', [IdCardDataController::class, 'searchAndDeleteMainVaultToken'])->name('search-delete-main-token-worker-id');
            Route::post('/get-worker-id-vault-token', [IdCardDataController::class, 'getWorkerIdVaultToken'])->name('get-worker-id-vault-token');
            Route::post('/get-worker-Id', [IdCardDataController::class, 'getWorkerIdByPhoneNumber'])->name('get-worker-id');
            Route::post('/get-subscriptions', [IdCardDataController::class, 'getSubscriptions'])->name('get-subscriptions');
            Route::get('/rejected-list', [IdCardDataController::class, 'getRejected'])->name('rejected-list');
        });

        Route::get('get-application-status', [AppliucationStatusDataController::class, 'index'])->name('get-application-status');
        Route::get(
            'get-roles-by-office/{office_id}',
            [AppliucationStatusDataController::class, 'getRolesByOffice']
        );

        Route::get(
            '/export-office-role-applications',
            [AppliucationStatusDataController::class, 'exportOfficeRoleApplications']
        )->name('export-office-role-applications');
        Route::get('/export/{type}', [AppliucationStatusDataController::class, 'export'])
            ->name('export-application-status');
        Route::get('/export-combined/{type}', [AppliucationStatusDataController::class, 'exportCombined'])
            ->name('export-combined-application-status');
        Route::get(
            '/export-all/{type}',
            [AppliucationStatusDataController::class, 'exportAll']
        )->name('export-all');
        Route::get(
            '/one-click-export',
            [AppliucationStatusDataController::class, 'oneClickExport']
        )->name('application-status.one-click-export');

        Route::get('/application-history/{applicationNo}', [AppliucationStatusDataController::class, 'applicationHistory'])
            ->name('application-history');


        //   Route::get(
        // 'export-officer-applications/{user}/{type}',
        // [AppliucationStatusDataController::class, 'exportOfficerApplications']
        //     )->name('export-officer-applications');


        Route::get('get-application-status-by-role/{role}', [AppliucationStatusDataController::class, 'showByRole'])
            ->name('get-application-status-by-role');
        Route::get('officer-applications/{user}', [AppliucationStatusDataController::class, 'showOfficerApplications'])
            ->name('officer-applications');
        Route::get('get-office-officers/{office_id}', [AppliucationStatusDataController::class, 'getOfficeOfficers'])
            ->name('get-office-officers');
        Route::get('get-pan-ration-status', [AppliucationStatusDataController::class, 'PanRation'])->name('get-pan-ration-status');
        Route::get('get-subscription', [\App\Http\Controllers\Admin\MISDATA\SubscriptionDataController::class, 'index'])->name('get-subscription');
        Route::get('get-application-status', [AppliucationStatusDataController::class, 'index'])->name('get-application-status');
        Route::get('get-pan-ration-status', [AppliucationStatusDataController::class, 'PanRation'])->name('get-pan-ration-status');
        Route::get('get-subscription', [SubscriptionDataController::class, 'index'])->name('get-subscription');
        Route::get('/subscription/{id}/edit', [SubscriptionDataController::class, 'edit'])->name('subscription.edit');
        Route::put('/subscription/{id}', [SubscriptionDataController::class, 'update'])->name('subscription.update');
        Route::delete('/subscription/{id}', [SubscriptionDataController::class, 'destroy'])->name('subscription.destroy');

        // ===================== END MIS DATA ================================//

        // ---------------------------------------------------------------------------------------------------
        // ==================== START BENEFITS ==========================
        Route::prefix('benefit-list')->name('benefit-list.')->group(function () {
            Route::get('/', [BenefitListController::class, 'index'])->name('index');
            Route::post('/', [BenefitListController::class, 'store'])->name('store');
            Route::post('update', [BenefitListController::class, 'update'])->name('update');
            Route::post('update-status', [BenefitListController::class, 'updateStatus'])->name('status');
            Route::post('delete', [BenefitListController::class, 'delete'])->name('delete');
        });

        Route::prefix('benefit-form')->name('benefit-form.')->group(function () {
            Route::get('/{benefit_id}', [BenefitFormController::class, 'index'])->name('index');
            Route::post('/', [BenefitFormController::class, 'store'])->name('store');
            Route::post('update', [BenefitFormController::class, 'update'])->name('update');
            Route::post('update-status', [BenefitFormController::class, 'updateStatus'])->name('status');
            Route::post('delete', [BenefitFormController::class, 'delete'])->name('delete');
            Route::post('update-order', [BenefitFormController::class, 'updateFieldOrder'])->name('updateOrder');
            Route::post('get-key-value', [BenefitFormController::class, 'getKeyValue'])->name('get-key-value');
            Route::post('get-worker-key-value', [BenefitFormController::class, 'getWorkerKeyValue'])->name('get-worker-key-value');
            Route::post('get-field-have-options', [BenefitFormController::class, 'getFieldHaveOptions'])->name('get-field-have-options');
            Route::post('get-field-options', [BenefitFormController::class, 'getFieldOptions'])->name('get-field-options');
        });
        // ==================== END BENEFITS =========================

    });
    // ===================END ADMIN ROUTES===================

    Route::get('bulk-api/{offset}/{limit}', [BulkVaultDataController::class, 'performVerification']);
    Route::get('bulk-migrant-api/{offset}/{limit}', [BulkVaultDataController::class, 'performVerificationMigrant']);

    // -------------------------------------------------------------------------------------------------------------------------------------

    // ===============FETCH MASTERDATA ROUTES=================

    Route::prefix('master')->name('master.')->group(function () {
        // Get Ditrict by State
        Route::post('get-districts', [DataViewController::class, 'getDistrictsByState'])->name('get-districts-by-state');
    });

    // ==============END FETCH MASTERDATA ROUTES==============

    // =================================CHANGE PASSWORD=================================
    Route::prefix('password')->name('password.')->group(function () {
        Route::get('change', [PasswordController::class, 'index'])->name('change');
        Route::post('update', [PasswordController::class, 'update'])->name('update');
    });
    // ===============================END CHANGE PASSWORD===============================

    // --------------------------------------------------------------------------------------------------------------------------------------


    Route::get('test-benefit-page', function () {
        $user = User::find(2);
        Auth::login($user);
        return view('office.benefits.index');
    });


    // ===========================================OFFICE ROUTES===========================================

    Route::prefix('office')->name('office.')->middleware('authuser')->group(function () {
        // =================================DASHBOARD=================================
        Route::prefix('head-office')->name('head-office.')->group(function () {
            Route::get('dashboard', [HoDashboardController::class, 'index'])->name('dashboard.index');
            Route::post('/incoming-applications/lock-batch', [HoDashboardController::class, 'lockBatch'])->name('applications.lockBatch');
            Route::get('/processing-applications', [HoDashboardController::class, 'processingApplications'])->name('dashboard.processing');
            Route::post('/applications/assign-to-da', [HoDashboardController::class, 'assignToDa'])->name('applications.assignToDa');
            Route::get('/hda-reviewed-applications', [HoDashboardController::class, 'hoDaReview'])->name('dashboard.hda-reviewed');
            Route::post('/applications/forward-to-accounts', [HoDashboardController::class, 'forwardToAccounts'])->name('applications.forwardToAccounts');
            Route::get('/accounts', [HoDashboardController::class, 'accounts'])->name('dashboard.accounts');
            Route::get('/accounts/data', [HoDashboardController::class, 'getAccountsData'])->name('accounts.data');
            Route::get('/accounts/export-excel', [HoDashboardController::class, 'exportAccountsExcel'])->name('accounts.export');
            Route::get('/lm-approved-applications', [HoDashboardController::class, 'LmApprovedApplications'])->name('dashboard.lm-approved');
            Route::post('/applications/assign-to-da-ppa', [HoDashboardController::class, 'assignToDaforPPA'])->name('applications.assignToDaforPPA');
            Route::get('/ppa-dispatch-applications', [HoDashboardController::class, 'ppaDispatchApplications'])->name('dashboard.ppa-dispatch');
            Route::get('/incoming/lm-signed', [HoDashboardController::class, 'lmSigned'])->name('dashboard.lm-signed');
            Route::post('/forward-to-hda-for-disbursement', [HoDashboardController::class, 'forwardBatchToHda'])->name('hda.disbursement');
        });

        Route::prefix('head-office-da')->name('head-office-da.')->group(function () {
            Route::get('dashboard', [HdaDashboardController::class, 'index'])->name('dashboard.index');
            Route::post('/process-batch', [HdaDashboardController::class, 'processBatch'])->name('processBatch');
            Route::get('/ppa-genration', [HdaDashboardController::class, 'ppaGenration'])->name('ppa-generation');
            Route::get('/ppa/export', [HdaDashboardController::class, 'exportForPpa'])->name('ppa.export');
            Route::post('/ppa/upload', [HdaDashboardController::class, 'uploadPpa'])->name('ppa.upload');
            Route::get('/fnal-disbursed', [HdaDashboardController::class, 'finalDisbursed'])->name('final-disbursed');
            Route::post('/mark-as-disbursed', [HdaDashboardController::class, 'markBatchAsDisbursed'])->name('markAsDisbursed');
        });

        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('dashboard', [AccountsController::class, 'index'])->name('dashboard.index');
            Route::post('/process-action', [AccountsController::class, 'processAccountAction'])->name('processAction');
            Route::post('/process-bulk-actions', [AccountsController::class, 'processBulkActions'])->name('processBulkActions');
            Route::get('/forwarded-to-dlc', [AccountsController::class, 'forwardedToDlc'])->name('forwarded-to-dlc');
            Route::get('/received-ppa', [AccountsController::class, 'receivedPPA'])->name('received-ppa');
            Route::get('/download-ppa/{batch_id}', [AccountsController::class, 'downloadPpaFile'])->name('ppa.download');
            Route::post('/upload-signed-ppa', [AccountsController::class, 'uploadSignedPpa'])->name('ppa.uploadSigned');
            Route::get('/forward-to-dlc-for-review', [AccountsController::class, 'forwardToDlcForReview'])->name('forwardToDlcForReview');
            Route::get('/download-signed-ppa/{batch_id}', [AccountsController::class, 'downloadSignedPpaFile'])->name('ppa-signed.download');
        });

        Route::prefix('dlc-dashboard')->name('dlc-dashboard.')->group(function () {
            Route::get('dashboard', [DlcDashboardController::class, 'index'])->name('dashboard.index');
            Route::post('applications/forward-to-lc', [DlcDashboardController::class, 'forwardToLc'])->name('forwardToLc');
            Route::get('applications/forwarded-to-lc', [DlcDashboardController::class, 'forwardedToLc'])->name('forwardedToLc');
            Route::get('applications/signed-ppa', [DlcDashboardController::class, 'signedPPA'])->name('signedPPA');
            Route::post('applications/forwarded-to-lc-for-sign', [DlcDashboardController::class, 'forwardToLcForSign'])->name('forwardToLcForSign');
        });
        Route::prefix('lc-lm-dashboard')->name('lc-lm-dashboard.')->group(function () {
            Route::get('dashboard', [LcLmDashboardController::class, 'index'])->name('dashboard.index');
            Route::post('applications/forward-to-lm-approved', [LcLmDashboardController::class, 'forwardToLmApproved'])->name('forwardToLMorApproved');
            Route::get('applications/tosign', [LcLmDashboardController::class, 'applicationsTosign'])->name('applications-tosign');
            Route::get('/download-for-signing/{batch_id}', [LcLmDashboardController::class, 'downloadForSigning'])->name('ppa.downloadForSigning');

            Route::post('/upload-final-signature', [LcLmDashboardController::class, 'uploadFinalSignature'])->name('ppa.uploadFinalSignature');
        });
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/', [OfficeDashboardController::class, 'index'])->name('index');

            Route::post('get-user-by-role', [OfficeDashboardController::class, 'getUserByRole'])->name('get-user-by-role');

            Route::get('benefit', [BenefitManagementController::class, 'index'])->name('benefits');

            Route::get('/benefit/filter-applications', [BenefitManagementController::class, 'filterApplications'])->name('benefits.filter');

            Route::post('/benefit/forward-application', [BenefitManagementController::class, 'forwardApplication'])->name('benefit.forward');
            Route::post('/benefit/pull-back', [BenefitManagementController::class, 'pullBackApplication'])->name('benefit.pull-back');
            Route::post('/benefit/send-back', [BenefitManagementController::class, 'sendBackApplication'])->name('benefit.send-back');
            Route::post('/benefit/approve', [BenefitManagementController::class, 'approveApplication'])->name('benefit.approve');
            Route::post('/benefit/reject', [BenefitManagementController::class, 'rejectApplication'])->name('benefit.reject');
            Route::post('/benefit/revert', [BenefitManagementController::class, 'revertApplication'])->name('benefit.revert');
            Route::get('benefits/scrutiny-data', [BenefitManagementController::class, 'getScrutinyData'])->name('benefits.scrutiny-data');
            Route::get('/applications/{application_id}/preview', [BenefitManagementController::class, 'preview'])->name('applications.preview');
            Route::get('/applications/{application:id}/log', [BenefitManagementController::class, 'logs'])->name('applications.preview');
            Route::get('/application/file/{data}', [BenefitManagementController::class, 'showFile'])->name('file.show');


            Route::get('/benefit/dashboard-reports', function () {
                return view('office.benefits.dashboard-reports');
            })->name('benefit.report');

            Route::get('/benefit/scrutiny-scheduling', [ScrutinyManagementController::class, 'index'])->name('scrutiny.dashboard');
            Route::post('/benefit/scrutiny/reschedule', [ScrutinyManagementController::class, 'reschedule'])->name('benefit.scrutiny.reschedule');
            Route::post('/benefits/scrutiny/send-to-committee', [ScrutinyManagementController::class, 'sendToCommittee'])->name('benefit.scrutiny.send');
            Route::prefix('benefits/scrutiny-members')->name('benefit.scrutiny.members.')->group(function () {
                Route::get('/', [ScrutinyManagementController::class, 'getCommitteeMembers'])->name('list');
                Route::post('/store', [ScrutinyManagementController::class, 'storeCommitteeMember'])->name('store');
                Route::put('/{id}', [ScrutinyManagementController::class, 'updateCommitteeMember'])->name('update');
                Route::delete('/{id}', [ScrutinyManagementController::class, 'deleteCommitteeMember'])->name('delete');
            });
            Route::get('/benefits/ho-forwarding', [HoForwardingController::class, 'index'])->name('benefit.ho-forwarding');
            Route::post('/process-meeting', [HoForwardingController::class, 'processMeetingResults'])->name('benefits.ho-forwarding.process-meeting');
            Route::post('/benefits/ho-forwarding/upload-documents', [HoForwardingController::class, 'uploadDocuments'])->name('benefits.ho-forwarding.upload');
            Route::get('/benefits/ho-forwarding/documents/{document}/{type}', [HoForwardingController::class, 'showDocument'])->name('benefits.ho-forwarding.document.show');
            Route::get('/export-report/{date}', [HoForwardingController::class, 'exportMeetingReport'])->name('benefits.ho-forwarding.export-report');
            Route::post('/benefits/ho-forwarding/bulk-action', [HoForwardingController::class, 'processBulkAction'])->name('benefits.ho-forwarding.bulk-action');
        });
        // =================================END DASHBOARD=================================
        // Nominee
        Route::prefix('nominee')->name('nominee.')->group(function () {
            Route::get('/', [NomineeManagementController::class, 'index'])->name('index');
            Route::patch('/{nominee}/approve', [NomineeManagementController::class, 'approve'])->name('approve');
            Route::patch('/{nominee}/reject', [NomineeManagementController::class, 'reject'])->name('reject');
        });
        // end Nominee
        Route::prefix('office-manual')->name('manual.')->middleware('authuser')->group(function () {
            Route::get('dsc-manual', [ApplicationController::class, 'dscManual'])->name('dsc-manual');
            Route::get('user-manual', [ApplicationController::class, 'userManual'])->name('user-manual');
            Route::get('user-manual-da', [ApplicationController::class, 'userManualDa'])->name('user-manual-da');
        });
        // ================================APPLICATIONS================================
        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('ekyc-vault-office', [ExistingWorkerController::class, 'vaultEnc']);
            Route::post('get-vault-data-office', [ExistingWorkerController::class, 'getVaultData'])->name('get-vault-data');
            Route::get('{status}', [ApplicationController::class, 'index'])->name('index');
            Route::get('preview/{id}', [ApplicationController::class, 'preview'])->name('preview');
            Route::get('preview-application/{id}', [ApplicationController::class, 'previewRenewal'])->name('preview-applications');
            Route::get('/get-offices', [ApplicationController::class, 'getOffices'])->name('get-offices');
            Route::get('logs/{id}', [ApplicationController::class, 'trailLogs'])->name('app-logs');
            Route::get('/app/{id}/get-logs', [ApplicationController::class, 'getLogsApi'])->name('logs-api');
            //            Route::get('/worker/logs', [ApplicationController::class, 'getWorkerLogs'])->name('logs-api');

        });
        Route::prefix('renewal-applications')->name('applications-renewal.')->group(function () {
            Route::get('ekyc-vault-office', [ExistingWorkerController::class, 'vaultEnc']);
            Route::post('get-vault-data-office', [ExistingWorkerController::class, 'getVaultData'])->name('get-vault-data');
            Route::get('{status}', [RenewalApplicationController::class, 'index'])->name('index');
            Route::get('da/application-history', [RenewalApplicationController::class, 'getApplicationHistoryDa'])->name('get-app-history-da');
            Route::get('Ro/application-history', [RenewalApplicationController::class, 'getApplicationHistoryRo'])->name('get-app-history-ro');
            Route::get('Hro/application-history', [RenewalApplicationController::class, 'getApplicationHistoryHro'])->name('get-app-history-hro');
            Route::get('preview/{id}', [ApplicationController::class, 'preview'])->name('preview');
            //            Route::get('preview-applications/{id}', [RenewalApplicationController::class, 'previewRenewal'])->name('preview-applications');
            Route::get('/get-offices', [ApplicationController::class, 'getOffices'])->name('get-offices');
            Route::get('/app/{id}/get-logs-api', [RenewalApplicationController::class, 'getLogsApiRenew'])->name('logs-api-renew');
            //            Route::get('{renewal}', [RenewalApplicationController::class, 'index'])->name('renewals');

        });

        Route::prefix('mis-data')->name('mis-data.')->group(function () {
            //            Route::get('/all-data', [ApplicationController::class, 'misData'])->name('all-data');
//            Route::match(['get', 'post'], '/{application_type}', [ApplicationController::class, 'misData'])->name('all-data');
            Route::match(['get', 'post'], '/{application_type}', [ApplicationController::class, 'misData'])->name('mis-report');

            Route::get('/filter-office-data', [ApplicationController::class, 'filterData'])->name('filter-office-data');
        });


        // ================================END APPLICATIONS================================

        // ================================i REGISTRATION================================
        Route::prefix('dsc')->name('dsc.')->group(function () {
            Route::get('/', [DscController::class, 'index'])->name('index');
            Route::get('iframe', [DscController::class, 'iframe'])->name('iframe');
            Route::post('register', [DscController::class, 'register'])->name('register');
            Route::get('applications', [DscController::class, 'applicationsToSign'])->name('applications');
            Route::get('e-sign-pdf/{id}', [DscController::class, 'eSign'])->name('eSign');
            Route::get('id-card-view/{id}', [DscController::class, 'idCard'])->name('idCard');
            Route::post('get-pdf-string', [DscController::class, 'getPdfString'])->name('pdf-string');
            Route::get('download-id-card/{id}', [DscController::class, 'getIdCard'])->name('download-id-card');
            Route::post('signed-id', [DscController::class, 'signedId'])->name('signed-id');
        });
        // ==============================END DSC REGISTRATION==============================

        // ================================OFFICE PROFILE================================
        Route::prefix('office-profile')->name('office-profile.')->group(function () {
            Route::get('/', [OfficeProfileController::class, 'index'])->name('index');
            Route::post('/', [OfficeProfileController::class, 'store'])->name('store');
            Route::post('update', [OfficeProfileController::class, 'update'])->name('update');
            Route::post('delete', [OfficeProfileController::class, 'delete'])->name('delete');
        });
        // ================================END OFFICE PROFILE================================
    });
    // ===========================================END OFFICE ROUTES===========================================

    Route::get('/reload-captcha', [UserLoginController::class, 'reloadCaptcha']);




    // ===================EGRAS==========================
    Route::post('encEgrass', [PaymentController::class, 'egrasEnc'])->name('egrass-encrypt');
    Route::post('encEgrassGetCin', [PaymentController::class, 'getCinEncrypt'])->name('egrass-encrypt-getcin');
    Route::post('payment-initiate', [PaymentController::class, 'paymentInitiate'])->name('egrass-initiate');
    Route::post('payment-receipt', [PaymentController::class, 'paymentReceipt'])->name('egrass-receipt');
    Route::get('decEgrass', [PaymentController::class, 'egrassDecrypt']);

    Route::post('e-grass/sub-system/response', [PaymentController::class, 'getSubsystemResponse']);
    Route::post('e-grass/get-cin', [PaymentController::class, 'getCin']);
    // ====================END EGRASS====================



    Route::prefix('office')->group(function () {
        Route::get('/officeloginsuccess', [OfficeinfoController::class, 'officeloginSuccess'])->name('officeloginsuccess');

        Route::get('/officeapplications/{id}', [OfficeinfoController::class, 'applicationDetails'])->name('office-applications')->middleware('authuser');
        Route::post('/application-approve', [OfficeinfoController::class, 'approveApplication'])->name('approve_application')->middleware('authuser');
        Route::post('/application-approve-onboarding', [OfficeinfoController::class, 'approveApplicationOnboarding'])->name('approve_application-onboarding')->middleware('authuser');
        Route::post('/renewal-application-approve', [OfficeinfoController::class, 'approveRenewApplication'])->name('approve_renew-application')->middleware('authuser');
        Route::post('/renewal-application-forward', [OfficeinfoController::class, 'forwardRenewApplication'])->name('forward_renew-application')->middleware('authuser');
        Route::post('/renewal-application-ro-forward', [OfficeinfoController::class, 'forwardToRoRenewApplication'])->name('forward-renew-ro-application')->middleware('authuser');
        Route::post('/application-reject', [OfficeinfoController::class, 'rejectApplication'])->name('reject_application')->middleware('authuser');
        Route::post('/application-forward-to-officer', [OfficeinfoController::class, 'forwardApplicationToRo'])->name('forward_application_to_ro_da')->middleware('authuser');
        Route::post('/application-forward', [OfficeinfoController::class, 'forwardApplication'])->name('forward_application')->middleware('authuser');
        Route::post('/application-send-back', [OfficeinfoController::class, 'sendBackApplication'])->name('send-application-back')->middleware('authuser');
        Route::post('/application-send-back-renewal', [OfficeinfoController::class, 'sendBackApplicationRenewal'])->name('send-application-back-re')->middleware('authuser');
        Route::post('/application-send-back-ro', [OfficeinfoController::class, 'sendBackApplicationHro'])->name('send-application-back-hro')->middleware('authuser');
        Route::post('/application-send-back-renewal-ro', [OfficeinfoController::class, 'sendBackApplicationHroRenewal'])->name('send-application-back-hro-renewal')->middleware('authuser');
        Route::post('/application-pullback', [OfficeinfoController::class, 'pullBackApplication'])->name('application-pullback')->middleware('authuser');
        Route::post('/application-pullback-renewal', [OfficeinfoController::class, 'pullBackApplicationRenewal'])->name('application-pullback-renewal')->middleware('authuser');
        Route::post('/application-revert', [OfficeinfoController::class, 'revertBackApplication'])->name('application-revert')->middleware('authuser');
        Route::post('/application-revert-renewal', [OfficeinfoController::class, 'revertRenewalApp'])->name('application-revert-renewal')->middleware('authuser');
        Route::post('/application-reroute-existing', [OfficeinfoController::class, 'reRouteApplicationOnboarding'])->name('application-reroute-existing')->middleware('authuser');
        Route::post('/application-reroute-new', [OfficeinfoController::class, 'reRouteApplicationNew'])->name('application-reroute-new-reg')->middleware('authuser');
        Route::post('/application-forward-to-hda', [OfficeinfoController::class, 'forwardHDA'])->name('application-reroute-forward-da')->middleware('authuser');
        Route::post('/forward-from-state-office', [OfficeinfoController::class, 'forwardApplicationFromStateOffice'])->name('application-forward-after-reroute')->middleware('authuser');
        Route::post('/forward-from-hda-to-ho', [OfficeinfoController::class, 'forwardDaHo'])->name('forward-to-ho-from-da')->middleware('authuser');
        Route::get('/logout', [UserLoginController::class, 'logout']);
        Route::post('/changepassword', [OfficeinfoController::class, 'changePassword'])->name('office.pwChanged')->middleware('authuser');
        Route::get('/application-received', [OfficeinfoController::class, 'applicationReceived'])->name('application-received')->middleware('authuser');
        Route::get('/application-pending', [OfficeinfoController::class, 'applicationPending'])->name('application-pending')->middleware('authuser');
        Route::get('/application-approved', [OfficeinfoController::class, 'applicationApproved'])->name('application-approved')->middleware('authuser');
        Route::get('/application-rejected', [OfficeinfoController::class, 'applicationRejected'])->name('application-rejected')->middleware('authuser');
        Route::get('/application-forwarded', [OfficeinfoController::class, 'applicationForwarded'])->name('application-forwarded')->middleware('authuser');
        Route::get('/application-reverted', [OfficeinfoController::class, 'applicationReverted'])->name('application-reverted')->middleware('authuser');
        Route::post('/applications/send', [OfficeinfoController::class, 'sendApplications'])->name('office.applications.send')->middleware('authuser');

        Route::get('get-worker-old-id-card/{worker_id}', [OfficeinfoController::class, 'getWOldIdCard'])->name('boc-card');
        Route::get('get-worker-res-proof/{worker_id}', [OfficeinfoController::class, 'getResProof'])->name('res-proof');
        Route::get('get-worker-subscription/{worker_id}', [OfficeinfoController::class, 'getOfficeSubscription'])->name('subscription-view');
        Route::get('get-worker-bank-copy/{worker_id}', [OfficeinfoController::class, 'getWorkerBankCopy'])->name('bank-copy');
        Route::get('get-worker-certificate-proof/{worker_id}', [OfficeinfoController::class, 'getOfficeCertProof'])->name('certificate-proof');
        Route::get('get-worker-certificate-proof-new/{worker_id}', [OfficeinfoController::class, 'getCertificateNew'])->name('certificate-proof-new');
        Route::get('get-worker-bank-pass/{worker_id}', [OfficeinfoController::class, 'getBankCopy'])->name('bank-pass');
        Route::get('get-nominee_bank/{worker_id}', [OfficeinfoController::class, 'getNomineeBankCopy'])->name('nominee_bank');
        Route::get('get-worker-ration/{worker_id}', [OfficeinfoController::class, 'getRation'])->name('ration_card');
        Route::get('get-worker-pan/{worker_id}', [OfficeinfoController::class, 'getPan'])->name('pan_card');
        Route::get('get-work-book/{worker_id}', [OfficeinfoController::class, 'getOfficeWorkBook'])->name('work-book');
        Route::get('get-ack-slip/{worker_id}', [OfficeinfoController::class, 'getAckReceipt'])->name('ack-pay-slip');
    });

    Route::get('/worker-dashboard', [WorkerLoginController::class, 'loginDash'])->name('worker-dashboard');
    Route::get('/payment-receipt', [WorkerLoginController::class, 'paymentReceipt'])->name('payment-receipt');
    Route::get('/track-application', [WorkerLoginController::class, 'TrackApplication'])->name('track-application');
    Route::post('/clear-workbook-data', [WorkerLoginController::class, 'clearWorkbookData'])
        ->name('clear-workbook-data');


    Route::get('test/{string}/salt/{key}', [SecurityController::class, 'encrypt']);


    Route::controller(AuthOtpController::class)->group(function () {
        Route::post('generate/otp', 'generate')->name('otp.generate');
    });

    // ========================Nominee/Legal Heir=================

    Route::prefix('nominee')->name('nominee.')->group(function () {
        Route::get('dashboard', [NomineeRegistrationController::class, 'dashboard'])->name('dashboard');
    });


    // ---------------------------------------------------------------------------------------------------
    Route::prefix('existing-worker')->group(function () {
        Route::post('encrypt-data', [eShramController::class, 'encryptData']);
        Route::post('encrypt-data-uan', [eShramController::class, 'encryptUan']);
        Route::get('acknowledgement-receipt-existing', [ExistingWorkerController::class, 'downloadAckPdf'])->name('download-ack-pdf-existing');
        Route::get('payment-receipt-exisiting', [ExistingWorkerController::class, 'paymentReceiptPdf'])->name('download-payment-pdf-existing');
        /** Existing Worker */
        Route::get('check-temp-account-onboarding', [ExistingWorkerController::class, 'checkBeforeOnboarding'])->name('check-before-onboarding');

        Route::post('/check-ex-phone', [ExistingWorkerController::class, 'checkPhoneEx'])->name('check-phone-ex');
        Route::post('account-details', [ExistingWorkerController::class, 'getAccountDetailsEx'])->name('account.details_ex');
        Route::post('/verify-phone-number-on', [ExistingWorkerController::class, 'verifyWorkerMobileEx'])->name('auth-otp-worker-on');
        Route::post('/validate-phone-number', [ExistingWorkerController::class, 'validatePhoneNumber'])->name('validate-phone-number');
        Route::post('/delete-worker-tables', [ExistingWorkerController::class, 'deleteWorkerDataEx'])->name('delete-worker-data-ex');
        Route::get('/otp-verification-on', [ExistingWorkerController::class, 'OTPPageEx'])->name('OTP-gen-page-on');
        //    Route::post('/worker-login-temporary', [MasterWorkerController::class, 'loginWithTempId'])->name('login-with-temp-id');
        Route::post('/worker-login-temporary', [ExistingWorkerController::class, 'loginWithTempIdEx'])->name('login-with-temp-id-ex');
        Route::get('/worker-login-resubmit-onboarding/{temp_worker_id}', [ExistingWorkerController::class, 'loginWithResubmitEx'])->name('login-with-resubmit-ex');

        Route::post('save-phone-onboarding', [ExistingWorkerController::class, 'savePhoneEx'])->name('save-ex-phone-no');
        Route::get('on-boarding', [ExistingWorkerController::class, 'ExRegisterWorker'])->name('ex-reg-worker');
        Route::post('check-worker-phone', [ExistingWorkerController::class, 'checkRecord'])->name('check-phone');
        Route::post('save-worker-reg', [ExistingWorkerController::class, 'saveExReg'])->name('save-existing-reg');
        Route::get('verify-worker-details', [ExistingWorkerController::class, 'getDetails'])->name('existing-data');
        Route::post('get-api-data', [ExistingWorkerController::class, 'postDetails'])->name('existing-worker-data');
        Route::post('set-response-data', [ExistingWorkerController::class, 'setSessionData'])->name('set-response-data');
        Route::post('update-bocw-card-no', [ExistingWorkerController::class, 'updateBocwNo'])->name('update-bocw-reg-number');
        Route::get('check-phone-count-ex', [ExistingWorkerController::class, 'checkPhoneCountEx'])->name('check-before-validate-ex');


        /** Register Existing Worker */
        Route::post('onboarding-existing-worker', [ExistingWorkerController::class, 'RegisterWorker'])->name('ext-worker-reg');

        Route::get('update-existing-office-address-page', [ExistingWorkerController::class, 'officeAddress'])->name('update-existing-office-address-page');
        Route::post('update-existing-office-address', [ExistingWorkerController::class, 'updateWorkerOffice'])->name('update-existing-office-address');
        /** existing worker basic details */
        Route::get('/existing-worker-basic-details', [ExistingWorkerController::class, 'basicPage'])->name('submit-basic-page');
        /** Save existing basic page */
        Route::post('save-basic-details', [ExistingWorkerController::class, 'saveExistingBasic'])->name('save-existing-basic-page');
        /** Update basic data **/
        Route::post('update-existing-basic-data', [ExistingWorkerController::class, 'updateExistingBasic'])->name('update-existing-basic-data');
        /** Pass data to address page with view */
        Route::get('existing-worker-address-details', [ExistingWorkerController::class, 'pageExistingAddress'])->name('submit-existing-basic-details');

        /** Save address details **/
        Route::post('save-address-details', [ExistingWorkerController::class, 'saveExistingAddress'])->name('save-existing-address');
        /** Update address if user exists */

        Route::post('update-existing-address', [ExistingWorkerController::class, 'updateExistingAddress'])->name('update-existing-address-details');
        /** Pass Data to Bank Page */

        Route::get('existing-worker-banking-details', [ExistingWorkerController::class, 'pageExistingBank'])->name('submit-worker-address-details');

        /** Save bank details */
        Route::post('save-bank-details', [ExistingWorkerController::class, 'saveExistingBank'])->name('save-existing-bank');

        Route::post('update-existing-bank-details', [ExistingWorkerController::class, 'updateExistingBank'])->name('update-existing-bank-details');

        /** pass data to family details */
        Route::get('worker-family-details', [ExistingWorkerController::class, 'pageExistingFamily'])->name('submit-bank-details');

        /** Save Family Details */
        Route::post('save-existing-family-details', [ExistingWorkerController::class, 'saveExistingFamily'])->name('save-existing-family');

        Route::post('update-existing-family-details', [ExistingWorkerController::class, 'updateExistingFamily'])->name('update-existing-family-details');
        /** Pass to Employer details */

        Route::post('/delete-family-member', [ExistingWorkerController::class, 'deleteExFamilyMember'])->name('delete-ex-family-member');

        // Route::get('worker-employer-certificate-details', [ExistingWorkerController::class, 'pageExistingEmployer'])->name('submit-existing-family-details');
        /** save employer details */
        // Route::post('save-employer-details', [ExistingWorkerController::class, 'saveExistingEmployer'])->name('save-existing-employer');

        // Route::post('update-existing-employer-details', [ExistingWorkerController::class, 'updateExistingEmployer'])->name('update-existing-employer-details');

        /** Pass to Schemes */
        Route::get('worker-schemes-details', [ExistingWorkerController::class, 'pageExistingSchemes'])->name('submit-existing-employers');

        /** Save Scheme details */
        Route::post('save-scheme-details', [ExistingWorkerController::class, 'saveExistingScheme'])->name('save-existing-scheme');

        Route::post('update-scheme-details', [ExistingWorkerController::class, 'updateExistingScheme'])->name('update-existing-scheme');

        /** Pass to Document page */
        Route::get('worker-documents-details', [ExistingWorkerController::class, 'pageExistingDocument'])->name('submit-existing-schemes');

        Route::post('save-documents-details', [ExistingWorkerController::class, 'saveExistingDocument'])->name('save-existing-documents');

        //    Route::get('update-documents-page', [ExistingWorkerController::class, 'editExistingDocument'])->name('update-exist-documents');

        Route::post('update-documents-details', [ExistingWorkerController::class, 'updateExistingDocument'])->name('update-existing-documents');

        Route::get('worker-preview-application', [ExistingWorkerController::class, 'previewPageExisting'])->name('submit-existing-documents');

        //        Route::get('worker-registration-payment',[ExistingWorkerController::class,'registrationExistingPayment'])->name('submit-existing-preview');

        Route::get('download-existing-preview-pdf', [ExistingWorkerController::class, 'DownloadPreviewPDF'])->name('download-final-pdf');

        /** Payment Receipt */
        Route::get('/payment-success', [ExistingWorkerController::class, 'paymentSuccess'])->name('paymentSuccess');

        Route::get('save-registration-data', [ExistingWorkerController::class, 'FinalExSubmit'])->name('save-final-existing-data');

        /** Acknowledge Page */
        Route::get('registration-successful', [ExistingWorkerController::class, 'acknowledgementPage'])->name('print-acknowledgement');
        Route::get('/return-home', [ExistingWorkerController::class, 'returnHome'])->name('return-home');
        Route::post('check-old-worker-exists', [ExistingWorkerController::class, 'checkIdCard'])->name('check-old-worker-exists');
        /** View Documents start */
        Route::get('get-worker-boc-card/{id}', [ExistingWorkerController::class, 'getBOCCard'])->name('show-old-id-card');
        Route::get('get-worker-res-proof/{id}', [ExistingWorkerController::class, 'getResProof'])->name('show-res-proof');
        Route::get('get-worker-bank-copy/{id}', [ExistingWorkerController::class, 'getBankXerox'])->name('show-bank-copy');
        Route::get('get-worker-workbook/{id}', [ExistingWorkerController::class, 'getWorkBook'])->name('show-work-book');
        Route::get('get-worker-certificate/{id}', [ExistingWorkerController::class, 'getCertificate'])->name('show-cert-proof');
        Route::get('get-nominee_bank_copy/{id}', [ExistingWorkerController::class, 'getNomineeBankCopy'])->name('show_nominee_bank_copy');
        Route::get('get-worker-ration/{id}', [ExistingWorkerController::class, 'getRation'])->name('show-ration_card');
        Route::get('get-worker-pan/{id}', [ExistingWorkerController::class, 'getPan'])->name('show-pan_card');
        Route::get('files/{worker_id}', [ExistingWorkerController::class, 'showFiles'])->name('files.show');
        Route::get('/existing-employer', [ExistingWorkerController::class, 'pageExistingEmployer'])
            ->name('existing-employer');
        Route::post('update-office-existing', [ExistingWorkerController::class, 'updateOffice'])->name('update-office-existing');

        // Route to download files
        Route::get('/files/{filename}', [ExistingWorkerController::class, 'downloadFile'])
            ->name('file.download');

        Route::get('get-worker-subscription/{id}', [ExistingWorkerController::class, 'getSubscription'])->name('show-worker-subscription');
        /** View Documents End **/




        /** Get district and subdistrict */
        Route::get('get-districts', [ExistingWorkerController::class, 'getDistricts']);
        Route::get('get-subdistricts-postoffc', [ExistingWorkerController::class, 'getSubdistPostOffc']);
        Route::get('get-subdistricts', [ExistingWorkerController::class, 'getSubDist']);
        Route::get('get-pincode', [ExistingWorkerController::class, 'getPin']);
        Route::get('/getskills', [ExistingWorkerController::class, 'getSkills']);
        Route::get('/getrationtype', [ExistingWorkerController::class, 'getRationType']);
        Route::get('get-bank-details', [ExistingWorkerController::class, 'getBank']);

        Route::get('/otpgeneration', [AuthOtpController::class, 'otpgenerationEnc']);
        Route::get('/authenticationotp', [AuthOtpController::class, 'authenticationotpEnc']);
        Route::get('/ekyc', [AuthOtpController::class, 'ekycEnc']);


        Route::post('generate-otp-aadhaar', [AuthOtpController::class, 'generateAadharOtp']);
        Route::post('ekyc-otp-aadhaar', [AuthOtpController::class, 'ekycAadhaar']);
        Route::get('ekyc-vault-exist', [ExistingWorkerController::class, 'vaultEnc']);
        Route::post('get-vault-data-exist', [ExistingWorkerController::class, 'getVaultData'])->name('get-vault-data');
    });


    Route::post('encryptEshram', [eShramController::class, 'encryptEshram']);

    Route::get('renewal/get-worker-data', [MasterRenewalController::class, 'fetchWorkerData'])->name('get-worker-data');
    Route::get('renewal/view-worker-data', [MasterRenewalController::class, 'showData'])->name('show-worker-data');
    //    Route::get('renewal/preview-application', [MasterRenewalController::class, 'preview'])->name('preview-renewal-application');
    //    Route::get('renewal/download-acknowledgement', [MasterRenewalController::class, 'downloadAck'])->name('download-ack');
    Route::get('renewal/workbook-details', [MasterRenewalController::class, 'workBookDetails'])->name('workbook-details');
    Route::post('renewal/save-workbook-details', [MasterRenewalController::class, 'saveWorkBook'])->name('save-workbook-details');

    Route::get('renewal/update-worker-basic-details', [MasterRenewalController::class, 'basicPage'])->name('renewal-homepage');
    Route::post('renewal/save-worker-basic-details', [MasterRenewalController::class, 'updateBasicDetails'])->name('save-basic-data');
    Route::get('renewal/update-worker-address-details', [MasterRenewalController::class, 'addressDetails'])->name('residential-details');
    Route::post('renewal/save-worker-address-details', [MasterRenewalController::class, 'updateAddressDetails'])->name('save-residential-details');
    Route::get('renewal/update-bank-details', [MasterRenewalController::class, 'bankDetails'])->name('bank-details');
    Route::post('renewal/save-worker-bank-details', [MasterRenewalController::class, 'UpdateBankDetails'])->name('save-bank-detail');
    Route::get('renewal/update-worker-family-details', [MasterRenewalController::class, 'FamilyDetails'])->name('family-details');
    Route::post('renewal/save-worker-family-details', [MasterRenewalController::class, 'updateFamilyDetails'])->name('save-family');
    Route::get('renewal/update-certificate-details', [MasterRenewalController::class, 'CertificateDetails'])->name('certificate-details');
    Route::post('renewal/save-certificate-details', [MasterRenewalController::class, 'updateCertificate'])->name('save-certificate-details');
    Route::get('renewal/update-scheme-details', [MasterRenewalController::class, 'schemeDetails'])->name('scheme-details');
    Route::post('renewal/save-scheme-details', [MasterRenewalController::class, 'updateScheme'])->name('save-all-scheme');
    Route::get('renewal/update-documents', [MasterRenewalController::class, 'documentDetails'])->name('document-details');
    Route::post('renewal/save-document-details', [MasterRenewalController::class, 'updateDocumentDetails'])->name('save-document-details');
    //Route::get('renewal/preview-application', [MasterRenewalController::class, 'preview'])->name('preview-renewal-application');
    Route::get('renewal/final-submit', [MasterRenewalController::class, 'SubmitRenewal'])->name('save-renewal-data');
    //    Route::get('renewal/acknowledgement', [MasterRenewalController::class, 'acknowledgement'])->name('acknowledgement-renewal');
    Route::get('renewal/fee', [MasterRenewalController::class, 'renewalFee'])->name('get-renewal-fee');
    Route::get('get-worker-res-proof/{id}', [MasterRenewalController::class, 'ViewResProof'])->name('view-res-proof');
    Route::get('get-worker-bank-copy/{id}', [MasterRenewalController::class, 'ViewBankCopy'])->name('view-bank-copy');
    Route::get('get-worker-ration/{id}', [MasterRenewalController::class, 'ViewRation'])->name('view-ration-card');
    Route::get('get-worker-pan/{id}', [MasterRenewalController::class, 'ViewPan'])->name('view-pan-card');
    Route::get('get-worker-workbooks/{id}', [MasterRenewalController::class, 'ViewWorkBook'])->name('view-work-book');
    /**save employer data */
    Route::post('renewal/create-certificate', [MasterRenewalController::class, 'createCertificate'])->name('create-certificate');
    Route::get('/worker/{id}/remarks', [ApplicationController::class, 'getRemarks'])
        ->where('id', '.*')   // allow slashes in worker_id
        ->name('worker.remarks');


    Route::post('save-photo', [PhotoController::class, 'savePhoto']);
});
