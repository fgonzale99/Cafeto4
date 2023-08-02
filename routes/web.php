<?php

use App\Http\Controllers\CustomerController;
use App\Http\Livewire\ShowCustomers;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ShowProcesses;

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

Auth::routes();

Route::get('pages/{page}/{subs?}', ['uses' => '\App\Http\Controllers\PageController@index'])
    ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'home']);

Route::get('home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::get('modulos/{idRegistro}', [App\Http\Controllers\HomeController::class, 'module'])->name('modulos');

Route::get('submodulos/{idRegistro}', [App\Http\Controllers\HomeController::class, 'submodule'])->name('submodulos');



Route::get('crud/{model}/list', [App\Http\Controllers\CrudController::class, 'list'])->name('crud.list');

Route::get('crud/{model}/new', [App\Http\Controllers\CrudController::class, 'new'])->name('crud.new');

Route::get('crud/{model}/edit/{id}', [App\Http\Controllers\CrudController::class, 'edit'])->name('crud.edit');

Route::get('crud/{model}/show/{id}', [App\Http\Controllers\CrudController::class, 'show'])->name('crud.show');

Route::get('crud/{model}/board/{id}', [App\Http\Controllers\CrudController::class, 'board'])->name('crud.board');

Route::delete('crud/delete/{id}', [App\Http\Controllers\CrudController::class, 'delete'])->name('crud.delete');

Route::get('crud/duplicate/{id}', [App\Http\Controllers\CrudController::class, 'duplicate'])->name('crud.duplicate');

Route::post('crud/create', [App\Http\Controllers\CrudController::class, 'create'])->name('crud.create');

Route::post('crud/update', [App\Http\Controllers\CrudController::class, 'update'])->name('crud.update');

Route::get('crud/{module}/export', [App\Http\Controllers\CrudController::class, 'export'])->name('crud.export');



Route::get('crud/getModule', [App\Http\Controllers\CrudController::class, 'getModule'])->name('crud.getModule');

Route::get('crud/getlist', [App\Http\Controllers\CrudController::class, 'getlist'])->name('crud.getlist');

Route::get('crud/get', [App\Http\Controllers\CrudController::class, 'get'])->name('crud.get');

Route::get('crud/getEnum', [App\Http\Controllers\CrudController::class, 'getEnum'])->name('crud.getEnum');

Route::get('crud/getOptions', [App\Http\Controllers\CrudController::class, 'getOptions'])->name('crud.getoptions');

Route::get('crud/getFile', [App\Http\Controllers\CrudController::class, 'getFile'])->name('crud.getFile');

Route::get('crud/mail/test', [App\Http\Controllers\CrudController::class, 'mailTest'])->name('crud.mailTest');

//parte nueva
Route::get('formreview/neweditor/{id?}/{page?}',[App\Http\Controllers\FormReviewController::class, 'neweditor'])->name('formreview.neweditor');

Route::post('formreview/guardaModulo',[App\Http\Controllers\FormReviewController::class, 'guardaModulo'])->name('formreview.guardaModulo');

Route::get('/formulario/new/{form_id?}',[App\Http\Controllers\FormReviewController::class, 'new_new'])->name('formreview.new_new');

Route::post('formreview/guarda_header',[App\Http\Controllers\FormReviewController::class, 'guarda_header'])->name('formreview.guarda_header');

Route::get('formreview/new_publish/{form_id}',[App\Http\Controllers\FormReviewController::class, 'new_publish'])->name('formreview.new_publish');


//verifica formulario distinto en un solo proceso

Route::get('formreview/uniqueForm/{process_id}/{form_id}',[App\Http\Controllers\FormReviewController::class, 'uniqueForm'])->name('formreview.uniqueForm');


/* HU 2-2023-03-16 SAMTEL */

Route::get('/reportes',[CustomerController::class,'getViewEvaluations'])->name('reportes');
Route::get('/reportes-customers',[CustomerController::class,'getCustomers'])->name('reportes.customers');
Route::get('/reportes-procesos/{customer_id}',[CustomerController::class,'getProcesses'])->name('reportes.processes');
Route::get('/reportes-proyectos/{customer_id}/{process_id}',[CustomerController::class,'getProjects'])->name('reportes.proyectos');
Route::post('/reportes-resultados',[CustomerController::class,'reporteResultados'])->name('reportes.resultados');

/* FIN HU 2-2023-03-16 SAMTEL */

Route::get('formreview/new', [App\Http\Controllers\FormReviewController::class, 'new'])->name('formreview.new');

Route::get('formreview/questions/{id}/{page}', [App\Http\Controllers\FormReviewController::class, 'new'])->name('formreview.questions');

Route::post('formreview/questions/save', [App\Http\Controllers\FormReviewController::class, 'questionsSave'])->name('formreview.questionsSave');

Route::get('formreview/page/get', [App\Http\Controllers\FormReviewController::class, 'pageGet'])->name('formreview.pageGet');

Route::get('formreview/publish/{id}', [App\Http\Controllers\FormReviewController::class, 'publish'])->name('formreview.publish');

Route::get('formreview/edit/{id}', [App\Http\Controllers\FormReviewController::class, 'edit'])->name('formreview.edit');

Route::get('formreview/rules/{id}', [App\Http\Controllers\FormReviewController::class, 'rules'])->name('formreview.rules');

Route::get('formreview/getform/{id}', [App\Http\Controllers\FormReviewController::class, 'getFormReview'])->name('formreview.getform');

Route::get('formreview/published/{id}', [App\Http\Controllers\FormReviewController::class, 'published'])->name('formreview.published');

Route::get('formreview/draft/{id}', [App\Http\Controllers\FormReviewController::class, 'draft'])->name('formreview.draft');

Route::get('formreview/show/{id}', [App\Http\Controllers\FormReviewController::class, 'show'])->name('formreview.show');



Route::get('review/form/{id}/{page}', [App\Http\Controllers\ReviewController::class, 'form'])->name('review.form');

Route::post('review/page/save', [App\Http\Controllers\ReviewController::class, 'pageSave'])->name('review.pageSave');

Route::get('review/report/{id}', [App\Http\Controllers\ReviewController::class, 'report'])->name('review.report');

Route::get('review/reportstandard/{id}', [App\Http\Controllers\ReviewController::class, 'reportStandard'])->name('review.report.standard');

Route::get('review/reportcustom/{id}', [App\Http\Controllers\ReviewController::class, 'reportCustom'])->name('review.report.custom');

Route::get('review/reportcustom2/{id}', [App\Http\Controllers\ReviewController::class, 'reportCustom2'])->name('review.report.custom2');

Route::get('review/eval/{id}', [App\Http\Controllers\ReviewController::class, 'eval'])->name('review.eval');

Route::get('review/start/{id}', [App\Http\Controllers\ReviewController::class, 'start'])->name('review.start');

Route::get('review/accept', [App\Http\Controllers\ReviewController::class, 'accept'])->name('review.accept');

Route::get('review/decline', [App\Http\Controllers\ReviewController::class, 'decline'])->name('review.decline');


Route::get('review/pageslist/{id}', [App\Http\Controllers\ReviewController::class, 'pagesList'])->name('review.pagesList');

Route::get('review/page/get', [App\Http\Controllers\ReviewController::class, 'pageGet'])->name('review.pageGet');

Route::post('review/page/save/', [App\Http\Controllers\ReviewController::class, 'pageSave'])->name('review.pageSave');

Route::get('review/summary/{id}', [App\Http\Controllers\ReviewController::class, 'summary'])->name('review.summary');

Route::get('review/finish/{id}', [App\Http\Controllers\ReviewController::class, 'finish'])->name('review.finish');

Route::post('review/finishsave', [App\Http\Controllers\ReviewController::class, 'finishSave'])->name('review.finish.save');

Route::get('review/get/{id}', [App\Http\Controllers\ReviewController::class, 'get'])->name('review.get');

Route::get('review/result/{id}', [App\Http\Controllers\ReviewController::class, 'getResult'])->name('review.result');

Route::get('review/getreview/{id}', [App\Http\Controllers\ReviewController::class, 'getReview'])->name('review.getreview');

Route::get('review/track/{id}', [App\Http\Controllers\ReviewController::class, 'track'])->name('review.track');

Route::get('review/gettrack/{id}', [App\Http\Controllers\ReviewController::class, 'getTrack'])->name('review.getTrack');

Route::get('review/certificate/create/{id}', [App\Http\Controllers\ReviewController::class, 'certificate'])->name('review.certificate');

Route::get('certificate/validate/{code}', [App\Http\Controllers\PublicController::class, 'certificateValidate'])->name('certificate.validate');

Route::get('review/ethiccode/download/{id}', [App\Http\Controllers\ReviewController::class, 'ethiccode'])->name('review.ethiccode.download');

Route::get('review/list', [App\Http\Controllers\ReviewController::class, 'list'])->name('review.list');

Route::get('review/board/{id}', [App\Http\Controllers\ReviewController::class, 'reviewBoard'])->name('review.board');

Route::get('review/audit/{id}', [App\Http\Controllers\ReviewController::class, 'reviewAudit'])->name('review.audit');

Route::get('review/auditassign/{id}', [App\Http\Controllers\ReviewController::class, 'auditAssign'])->name('review.auditassign');

Route::get('review/auditassignedit/{id}', [App\Http\Controllers\ReviewController::class, 'auditAssignEdit'])->name('review.auditassign.edit');

Route::get('review/editassign/{id}', [App\Http\Controllers\ReviewController::class, 'editAssign'])->name('review.editassign');

Route::post('audit/assign/save', [App\Http\Controllers\ReviewController::class, 'auditAssignSave'])->name('review.auditassign.save');

Route::post('audit/assign/update', [App\Http\Controllers\ReviewController::class, 'auditAssignUpdate'])->name('review.auditassign.update');

Route::get('audit/review/eval/{id}', [App\Http\Controllers\CommitteeController::class, 'auditReviewEval'])->name('audit.review.eval');

Route::get('review/terms', [App\Http\Controllers\ReviewController::class, 'terms'])->name('review.terms');

Route::get('review/ethiccode/format', [App\Http\Controllers\ReviewController::class, 'ethicCodeFormat'])->name('review.ethiccode.format');

Route::get('review/delete/{id}', [App\Http\Controllers\ReviewController::class, 'delete'])->name('review.delete');

Route::get('review/result/set/{elementId}', [App\Http\Controllers\ReviewController::class, 'setResult'])->name('review.result.set');

Route::get('review/progress/set/{elementId}', [App\Http\Controllers\ReviewController::class, 'setProcess'])->name('review.progress.set');


Route::post('project/assign', [App\Http\Controllers\ProjectController::class, 'reviewerAssign'])->name('project.assign');

Route::get('notification/list', [App\Http\Controllers\NotificationController::class, 'list'])->name('notification.list');

Route::get('notification/board/{id}', [App\Http\Controllers\NotificationController::class, 'board'])->name('notification.board');

Route::get('message/new/{id}', [App\Http\Controllers\NotificationController::class, 'messageNew'])->name('message.new');

Route::post('notification/message/save/', [App\Http\Controllers\NotificationController::class, 'messageSave'])->name('message.save');



Route::get('project/board/{id}', [App\Http\Controllers\ProjectController::class, 'board'])->name('project.board');

Route::get('project/new/', [App\Http\Controllers\ProjectController::class, 'new'])->name('project.new');

Route::get('project/reviewer/{id}', [App\Http\Controllers\ProjectController::class, 'reviewer'])->name('project.reviewer');

Route::get('project/edit/{id}', [App\Http\Controllers\ProjectController::class, 'edit'])->name('project.edit');

Route::get('project/matrix/{id}', [App\Http\Controllers\ProjectController::class, 'reviewsMatrix'])->name('project.matrix');


Route::get('process/new', [App\Http\Controllers\ProcessController::class, 'new'])->name('process.new');

Route::get('process/budget/{id}', [App\Http\Controllers\ProcessController::class, 'budget'])->name('process.budget');

Route::get('process/edit/{id}', [App\Http\Controllers\ProcessController::class, 'edit'])->name('process.edit');


Route::get('process/board/{id}', [App\Http\Controllers\ProcessController::class, 'board'])->name('process.board');

Route::get('process/matrix/{id}', [App\Http\Controllers\ProcessController::class, 'reviewsMatrix'])->name('process.matrix');

Route::get('process/audit/matrix/{id}', [App\Http\Controllers\ProcessController::class, 'auditMatrix'])->name('process.audit.matrix');

Route::get('process/payment/available/{id}', [App\Http\Controllers\ProcessController::class, 'paymentAvailable'])->name('process.payment.available');

Route::get('process/review/list', [App\Http\Controllers\ProcessController::class, 'reviewList'])->name('process.review.list');

Route::get('process/payment/list/{id}', [App\Http\Controllers\ProcessController::class, 'paymentList'])->name('process.payment.list');

Route::get('review/payment/available/{id}', [App\Http\Controllers\ReviewController::class, 'paymentAvailable'])->name('review.payment.available');


Route::get('customer/dashboard', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('customer.dashboard');

Route::get('customer/process/list', [App\Http\Controllers\CustomerController::class, 'processList'])->name('customer.process.list');

Route::get('customer/process/board/{id}', [App\Http\Controllers\CustomerController::class, 'processBoard'])->name('customer.process.board');

Route::get('customer/project/list', [App\Http\Controllers\CustomerController::class, 'projectList'])->name('customer.project.list');

Route::get('customer/project/board/{id}', [App\Http\Controllers\CustomerController::class, 'projectBoard'])->name('customer.project.board');

Route::get('customer/reviews/list/', [App\Http\Controllers\CustomerController::class, 'reviewsList'])->name('customer.reviews.list');

Route::get('customer/review/board/{id}', [App\Http\Controllers\CustomerController::class, 'reviewBoard'])->name('customer.review.board');

Route::post('customer/reviewerchange', [App\Http\Controllers\ProjectController::class, 'reviewerChange'])->name('customer.reviewer.change');


Route::get('reviewer/search', [App\Http\Controllers\ReviewerController::class, 'search'])->name('reviewer.search');

Route::post('reviewer/consultarhv', [App\Http\Controllers\ReviewerController::class, 'consultarHV'])->name('reviewer.consultarhv');

Route::post('reviewer/consultararticulos', [App\Http\Controllers\ReviewerController::class, 'consultarArticulos'])->name('reviewer.consultararticulos');

Route::post('reviewer/consultarproyectos', [App\Http\Controllers\ReviewerController::class, 'consultarProyectos'])->name('reviewer.consultarproyectos');

Route::post('reviewer/consultarlibros', [App\Http\Controllers\ReviewerController::class, 'consultarLibros'])->name('reviewer.consultarlibros');

Route::get('reviewer/projects', [App\Http\Controllers\ReviewerController::class, 'projects'])->name('reviewer.projects');

Route::get('reviewer/getProjects', [App\Http\Controllers\ReviewerController::class, 'getProjects'])->name('reviewer.getProjects');

Route::post('reviewer/setreviewer', [App\Http\Controllers\ReviewerController::class, 'setReviewer'])->name('reviewer.setreviewer');

Route::get('review/payment/enable/{idReview}', [App\Http\Controllers\ReviewController::class, 'paymentEnable'])->name('review.payment.enable');

Route::get('review/payment/profile/{idReview}', [App\Http\Controllers\ReviewController::class, 'paymentProfile'])->name('review.payment.profile');

Route::get('review/payment/request/{idReview}', [App\Http\Controllers\ReviewController::class, 'paymentRequest'])->name('review.payment.request');

Route::get('review/payment/send/{idReview}', [App\Http\Controllers\ReviewController::class, 'paymentSend'])->name('review.payment.send');

Route::get('review/payment/receipt/{idReview}', [App\Http\Controllers\ReviewController::class, 'paymentReceipt'])->name('review.payment.receipt');


Route::get('process/unisono/projects', [App\Http\Controllers\ProcessController::class, 'getUnisonoProjects'])->name('process.unisono.projects');

Route::get('process/unisono/budgets/{id}', [App\Http\Controllers\ProcessController::class, 'getUnisonoBudgets'])->name('process.unisono.budgets');


Route::get('committee/review/list', [App\Http\Controllers\CommitteeController::class, 'reviewList'])->name('committee.review.list');

Route::get('committee/review/eval/{id}', [App\Http\Controllers\CommitteeController::class, 'auditReviewEval'])->name('committee.review.eval');

Route::get('committee/review/getlist', [App\Http\Controllers\CommitteeController::class, 'getReviewList'])->name('committee.review.getlist');

Route::get('committee/summary/{id}', [App\Http\Controllers\CommitteeController::class, 'reviewSummary'])->name('committee.review.summary');

Route::post('committee/eval/save', [App\Http\Controllers\CommitteeController::class, 'auditSave'])->name('committee.audit.save');

Route::post('committee/eval/update', [App\Http\Controllers\CommitteeController::class, 'auditUpdate'])->name('committee.audit.update');

Route::get('committee/audit/show/{id}', [App\Http\Controllers\CommitteeController::class, 'auditShow'])->name('committee.audit.show');

Route::get('committee/audit/summary/{id}', [App\Http\Controllers\CommitteeController::class, 'auditSummary'])->name('committee.audit.summary');

Route::get('review/getaudit/{id}', [App\Http\Controllers\CommitteeController::class, 'getAudit'])->name('review.getaudit');

Route::get('committee/getaudit/{id}', [App\Http\Controllers\CommitteeController::class, 'getCommitteeAudit'])->name('committee.getaudit');

Route::get('committee/reviewer/{id}', [App\Http\Controllers\CommitteeController::class, 'reviewerShow'])->name('committee.reviewer.show');

Route::get('committee/getreviewer/{id}', [App\Http\Controllers\CommitteeController::class, 'getReviewer'])->name('committee.getreviewer');


Route::get('user/profile/edit', [App\Http\Controllers\UserController::class, 'profileEdit'])->name('user.profile.edit');

Route::get('user/profile/documents', [App\Http\Controllers\UserController::class, 'documents'])->name('user.profile.documents');

Route::get('user/profile/show', [App\Http\Controllers\UserController::class, 'profileShow'])->name('user.profile.show');

Route::post('/user/profile/update', [App\Http\Controllers\UserController::class, 'profileUpdate'])->name('user.profile.update');

Route::get('user/getcurrent', [App\Http\Controllers\UserController::class, 'getCurrent'])->name('user.getcurrent');

Route::post('user/documents/upload', [App\Http\Controllers\UserController::class, 'documentsUpload'])->name('user.documents.upload');


Route::get('manager/dashboard', [App\Http\Controllers\ManagerController::class, 'dashboard'])->name('manager.dashboard');

Route::get('dashboard/customer/state', [App\Http\Controllers\DashboardController::class, 'customerByState'])->name('dashboard.customer.state');



//limpia cache
Route::get('/clear', function() {

  Artisan::call('cache:clear');
  Artisan::call('config:clear');
  Artisan::call('config:cache');
  Artisan::call('view:clear');
  Artisan::call('clear-compiled');
  Artisan::call('route:cache');
  Artisan::call('route:clear');
  Artisan::call('optimize');
  return "Cleared!";

});
