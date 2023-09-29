<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\dashboard;

use App\Http\Controllers\workerComment;

use App\Http\Controllers\admin\admin_dashboard;
use App\Http\Controllers\admin\user_add;
use App\Http\Controllers\admin\user_load;
use App\Http\Controllers\admin\user_account;
use App\Http\Controllers\admin\admin_tickets;
use App\Http\Controllers\admin\user_validation;
use App\Http\Controllers\admin\news_and_events;
use App\Http\Controllers\admin\reports;

use App\Http\Controllers\resetInitialPassword;
use App\Http\Controllers\users\users_account;
use App\Http\Controllers\users\tickets;
use App\Http\Controllers\users\news;
use App\Http\Controllers\users\users_dashboard;
use App\Http\Controllers\users\ticketReport;

Auth::routes();
Route::get('/', function () {return redirect('login');});
Route::get('check-comment', [workerComment::class, 'checkComment']);

Route::group(['middleware' => ['protectedPage']], function(){
    Route::get('dashboard', [dashboard::class, 'loadDashBoard'])->name('dashboard');
    Route::view('/user-validation', 'auth/userValidation')->name('user.validation');
    Route::get('reset-initial-password', [resetInitialPassword::class, 'initial_password'])->name('reset.initial.password');
    Route::post('submit-reset-initial-password', [resetInitialPassword::class, 'update_password_submit'])->name('submit.reset.initial.password');

    // Admin route
    Route::middleware(['auth', 'checkUserType:0'])->group(function () {
        Route::get('/admin-dashboard', [admin_dashboard::class, 'dashboard'])->name('admin.dashboard');
        //user management
        Route::get('/add-user-form', [user_add::class, 'add_user_form'])->name('add.user.form');
        Route::post('/submit-registration-form', [user_add::class, 'submit_registration_form'])->name('submit.registration.form');
        Route::get('/registration-notification', [user_add::class, 'send_confirmation'])->name('registration.confirmation');
        Route::get('/view-all-users', [user_load::class, 'user_display_all'])->name('view.all.users');
        Route::post('/update-profile-picture', [user_account::class, 'uploadProfilePicture'])->name('update.profile.picture');
        Route::get('/validate-user', [user_validation::class, 'display_unverified_user'])->name('validate.user');
        Route::get('/verify-user/{id}', [user_validation::class, 'verify_user'])->name('verify.user');
        //account settings
        Route::get('/admin-account', [user_account::class, 'account'])->name('admin.user.account');
        Route::get('/admin-account/update', [user_account::class, 'get_user_details_to_update'])->name('admin.update.account');
        Route::post('/admin-account/update/submit', [user_account::class, 'update_user_account_form'])->name('admin.update.account.submit');
        Route::get('/admin-update-password', [user_account::class, 'update_password'])->name('admin.update.password');
        Route::post('/admin-update-password-submit', [user_account::class, 'update_password_submit'])->name('admin.update.password.submit');
        
        
        Route::get('/test', [admin_tickets::class, 'notifyUsers']);
        
        //tickets
        Route::get('/user-ticket-list', [admin_tickets::class, 'ticket_list'])->name('admin.ticket.list');
        Route::get('/user-ticket-list/view-ticket/{id}/{status}', [admin_tickets::class, 'view_ticket_details'])->name('admin.ticket.details');
        Route::get('/get-ticket-details/{id}', [admin_tickets::class, 'get_ticket_details'])->name('get.ticket.details');
        Route::get('/resolved-ticket', [admin_tickets::class, 'resolved_ticket'])->name('resolved.ticket');
        Route::get('/reports-list', [reports::class, 'displayReports'])->name('reports.list');
        Route::post('/generate-report', [reports::class, 'generateReports'])->name('generate.report');
        Route::get('/export-ticket-report/{from}/{to}/{chapter}', [reports::class, 'exportTicketReport'])->name('export.ticket.report');
        Route::get('/print-ticket/{ticketId}', [reports::class, 'printTicket'])->name('print.ticket');
        Route::get('/mail-ticket-report', [reports::class, 'mailReport'])->name('mail.ticket.report');
        Route::get('/compose-mail-ticket-report/{from}/{to}/{chapter}', [reports::class, 'composeMailTicketReport'])->name('compose.mail.ticket.report');
		Route::get('/return-report-page/{from}/{to}/{chapter}', [reports::class, 'backToReportPage'])->name('return.report.page');
        Route::post('/save-recipients', [reports::class, 'saveRecipient'])->name('save.recipients');
        Route::get('/fetch-emails', [reports::class, 'fetchEmails'])->name('fetch.emails');
        Route::delete('/delete-email', [reports::class, 'deleteEmail']);


        Route::get('/get-ticket-status/{id}', [admin_tickets::class, 'get_status'])->name('get.ticket.status');
        Route::post('/update-priority', [admin_tickets::class, 'update_priority'])->name('update.priority');
        Route::post('/update-status', [admin_tickets::class, 'update_status'])->name('update.status');
        Route::post('/admin-get-comments', [admin_tickets::class, 'getComments'])->name('admin.get.comments');
        Route::post('/admin-delete-comments', [admin_tickets::class, 'deleteComment'])->name('admin.delete.comments');
        Route::post('/admin-get-comments-attachements', [admin_tickets::class, 'getAttachments'])->name('admin.get.comments.attachements');
        Route::post('/admin-send-comment', [admin_tickets::class, 'send_comments'])->name('admin-send.comments');
        //news and updates
        // Route::view('/create-events-form', 'admin/news/create_events')->name('create.events.form');
        Route::get('/create-events-form', [news_and_events::class, 'create_event_form'])->name('create.events.form');
        Route::post('/save-events', [news_and_events::class, 'save_events'])->name('save.events');
        Route::post('/save-image-attachement', [news_and_events::class, 'save_image_attachement'])->name('save.image.attachement');
        Route::post('/remove-pre-attach-image', [news_and_events::class, 'remove_pre_attachement'])->name('remove.pre.attach.image');
        Route::post('/save-news-form', [news_and_events::class, 'save_news'])->name('save.news.form');

        Route::view('/compose-news', 'admin/news/compose_news')->name('compose.news');
        Route::get('/read-news', [news_and_events::class, 'load_news'])->name('read.news');
        Route::get('/news-details/{id}', [news_and_events::class, 'news_details'])->name('news.details');
        Route::get('/events-details/{id}', [news_and_events::class, 'events_details'])->name('events.details');
    });

    // Users route
    Route::middleware(['auth', 'checkUserType:1'])->group(function () {
        Route::get('users-dashboard', [users_dashboard::class, 'dashboard'])->name('users.dashboard');

        Route::get('/users-account', [users_account::class, 'account'])->name('users.account');
        Route::post('/upload-user-profile', [users_account::class, 'uploadUserProfile'])->name('upload.user.profile');

        Route::get('/users-account/update', [users_account::class, 'get_user_details_to_update'])->name('users.update.account');
        Route::post('/users-account/update/submit', [users_account::class, 'update_user_account_form'])->name('users.update.account.submit');
        Route::get('/users-update-password', [users_account::class, 'update_password'])->name('users.update.password');
        Route::post('/users-update-password-submit', [users_account::class, 'update_password_submit'])->name('users.update.password.submit');

        Route::view('/create-ticket-form', 'users/ticket_create')->name('create.ticket.form');
        Route::post('/submit-create-ticket-form', [tickets::class, 'save_ticket_form'])->name('submit.create.ticket.form');
        Route::get('/ticket-list', [tickets::class, 'ticket_list'])->name('ticket.list');
        Route::get('/ticket-list/view-ticket/{id}', [tickets::class, 'view_ticket_details'])->name('ticket.details');
        Route::post('/ticket-list/view-ticket/send-comment', [tickets::class, 'send_comments'])->name('send.comments');
        Route::post('/get-comments', [tickets::class, 'getComments'])->name('get.comments');
        Route::post('/delete-comments', [tickets::class, 'deleteComment'])->name('delete.comments');
        Route::post('/get-comments-attachements', [tickets::class, 'getAttachments'])->name('get.comments.attachements');
        Route::get('/user-get-ticket-status/{id}', [tickets::class, 'get_status'])->name('user.get.ticket.status');

        Route::get('/export-users-tickets/{from}/{to}', [ticketReport::class, 'exportTicketReport'])->name('export.users.tickets');
        Route::get('/user-ticket-reports', [ticketReport::class, 'displayReports'])->name('user.ticket.reports');
        Route::get('/print-ticket-reports/{ticketId}', [ticketReport::class, 'printTicket'])->name('print.ticket.reports');
        Route::post('/generate-user-report', [ticketReport::class, 'generateReports'])->name('generate.user.report');

        Route::get('/news-list', [news::class, 'load_news'])->name('news.list');
        Route::get('/news-details-user/{id}', [news::class, 'news_details'])->name('news.details.user');
        Route::get('/events-details-user/{id}', [news::class, 'events_details'])->name('events.details.user');

    });


});

// Route::get('/dashboard', [App\Http\Controllers\admin\dashboard::class, 'loadAdminDashBoard'])->name('dashboard');