<?php

	// Authentication admin Login Routes
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Auth\LoginController@login')->name('admin.postlogin');
	Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');

	//forget and reset password
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.auth.password.reset');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.passwordemail');
	Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('admin.auth.password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.resetpassword');

	//Dashboard Route....
	Route::get('/', 'AdminController@index')->name('admin.dashboard');

	//change password	
	Route::get('/profile/change-admin-password', 'AdminController@changeAdminPassword')->name('changeAdminPassword');
	Route::post('/profile/update-admin-password', 'AdminController@updateAdminPassword')->name('updateAdminPassword');

	Route::get('/profile/pp', 'AdminController@uploadProfilePic')->name('uploadProfile');
	Route::post('/profile/upload-profile', 'AdminController@uploadProfile')->name('uploadProfilepic');
	
	//profile routes
	Route::get('/profile/update-profile', 'AdminController@adminProfile')->name('admin.profile');
	Route::post('/profile/update-profile', 'AdminController@updateProfile')->name('updateProfile');

	Route::post('/get-card-count', 'AdminController@getCardCount')->name('getCardCount');
	Route::post('/student-report', 'AdminController@studentReport')->name('studentReport');
	Route::post('/invoice-report', 'AdminController@invoiceReport')->name('invoiceReport');

	Route::post('/generate-invoice-excel', 'GstController@generateInvoiceExcel')->name('generateInvoiceExcel');
	
	//common routes
	Route::post('/get-city', 'AdminController@getCity')->name('admin.getCity');
	Route::post('/autosuggest-city', 'AdminController@autoSuggestCity')->name('admin.autoSuggestCity');

	//Student Routes
	Route::group(['prefix' => 'student'], function () {
		Route::match(['get','post'],'/student-list', 'StudentController@studentList')->name('admin.studentList');
		Route::get('/add-student', 'StudentController@addStudent')->name('admin.addStudent');
		Route::post('/save-student', 'StudentController@saveStudent')->name('admin.saveStudent');
		Route::get('/edit-student/{id}', 'StudentController@editStudent')->name('admin.editStudent');
		Route::post('/save-edited-student', 'StudentController@saveEditedStudent')->name('admin.saveEditedStudent');
		Route::get('/delete-student/{id}', 'StudentController@deleteStudent')->name('admin.deleteStudent');
		Route::post('/change-student-status', 'StudentController@changeStudentStatus')->name('admin.changeStudentStatus');
		Route::post('/check-student-email', 'StudentController@checkEmail')->name('admin.checkEmail');
		Route::match(['get','post'],'/profile/{uuid}', 'StudentController@getStudentProfile')->name('admin.getStudentProfile');
		Route::get('/link-batch-workshop/{uuid}', 'StudentController@addbatchAndWorkshop')->name('admin.addbatchAndWorkshop');
		Route::post('/save-linked-workshop', 'StudentController@saveLinkedWorkshop')->name('admin.saveLinkedWorkshop');
		Route::post('/unlink-work-shop', 'StudentController@unlinkWorkshop')->name('admin.unlinkWorkshop');

		Route::post('/mark-as-paid', 'StudentController@markAsPaid')->name('admin.markAsPaid');
		Route::get('/block-user-list', 'StudentController@blockUserList')->name('admin.blockUserList');
		Route::get('/unblock-user/{uuid}', 'StudentController@unblockUser')->name('admin.unblockUser');
		
		
	});

	//Faculty Routes
	Route::group(['prefix' => 'faculty'], function () {
		Route::match(['get','post'],'-list', 'FacultyController@facultyList')->name('admin.facultyList');
		Route::get('/add-faculty', 'FacultyController@addFaculty')->name('admin.addFaculty');
		Route::post('/save-faculty', 'FacultyController@saveFaculty')->name('admin.saveFaculty');
		Route::get('/edit-faculty/{uuid}', 'FacultyController@editFaculty')->name('admin.editFaculty');
		Route::post('/save-edited-faculty', 'FacultyController@saveEditedFaculty')->name('admin.saveEditedFaculty');
		Route::get('/delete-faculty/{uuid}', 'FacultyController@deleteFaculty')->name('admin.deleteFaculty');
		Route::post('/change-faculty-status', 'FacultyController@changeFacultyStatus')->name('admin.changeFacultyStatus');
		Route::post('/check-faculty-email', 'FacultyController@checkEmail')->name('admin.checkEmail');
		Route::post('/check-faculty-mobile', 'FacultyController@checkMobile')->name('admin.checkMobile');
		Route::match(['get','post'],'/profile/{uuid}', 'FacultyController@facultyProfile')->name('admin.facultyProfile');
		Route::post('/unlink-faculty', 'FacultyController@unlinkFaculty')->name('admin.unlinkFaculty');
		Route::get('/batch-list/{uuid}', 'FacultyController@getBatchList')->name('admin.getBatchList');
		Route::post('/link-faculty', 'FacultyController@linkFaculty')->name('admin.linkFaculty');
	});
	
	//studio inquiry
	Route::group(['prefix' => 'inquiry'], function () {
		Route::match(['get','post'],'/studio-inquiries', 'StudioController@inquiryList')->name('admin.inquiryList');
		Route::post('/change-inquiry-status', 'StudioController@changeInquiryStatus')->name('admin.changeInquiryStatus');
	});

	//Student Routes
	Route::group(['prefix' => 'studio'], function () {
		Route::match(['get','post'],'/studio-list', 'StudioController@studioList')->name('admin.studioList');
		Route::get('/add-studio', 'StudioController@addStudio')->name('admin.addStudio');
		Route::post('/save-studio', 'StudioController@saveStudio')->name('admin.saveStudio');
		Route::get('/edit-studio/{id}', 'StudioController@editStudio')->name('admin.editStudio');
		Route::post('/save-edited-studio', 'StudioController@saveEditedStudio')->name('admin.saveEditedStudio');
		Route::get('/delete-studio/{id}', 'StudioController@deleteStudio')->name('admin.deleteStudio');
		Route::post('/change-studio-status', 'StudioController@changeStudioStatus')->name('admin.changeStudioStatus');
	});

	//latest work & Gallery & video Routes
	Route::group(['prefix' => 'cms'], function () {

		Route::get('/edit-latest-work', 'CmsController@editLatestWork')->name('admin.editLatestWork');
		Route::post('/save-edited-latest-work', 'CmsController@saveEditedLatestWork')->name('admin.saveEditedLatestWork');

		Route::match(['get','post'],'/gallery-list', 'GalleryController@imageList')->name('admin.imageList');
		Route::get('/add-gallery', 'GalleryController@addImage')->name('admin.addImage');
		Route::post('/save-gallery', 'GalleryController@saveImage')->name('admin.saveImage');
		Route::get('/edit-gallery/{id}', 'GalleryController@editImage')->name('admin.editImage');
		Route::post('/save-edited-gallery', 'GalleryController@saveEditedImage')->name('admin.saveEditedImage');
		Route::get('/delete-gallery/{id}', 'GalleryController@deleteImage')->name('admin.deleteImage');
		Route::post('/change-gallery-status', 'GalleryController@changeImageStatus')->name('admin.changeImageStatus');

		Route::match(['get','post'],'/video-list', 'VideoController@videoList')->name('admin.videoList');
		Route::get('/add-video', 'VideoController@addVideo')->name('admin.addVideo');
		Route::post('/save-video', 'VideoController@saveVideo')->name('admin.saveVideo');
		Route::get('/edit-video/{id}', 'VideoController@editVideo')->name('admin.editVideo');
		Route::post('/save-edited-video', 'VideoController@saveEditedVideo')->name('admin.saveEditedVideo');
		Route::get('/delete-video/{id}', 'VideoController@deleteVideo')->name('admin.deleteVideo');
		Route::post('/change-video-status', 'VideoController@changeVideoStatus')->name('admin.changeVideoStatus');
	});
	
	//workshop module
	Route::group(['prefix' => 'batch'], function () {
		Route::match(['get','post'],'/workshop-list', 'WorkshopController@workshopList')->name('admin.workshopList');
		Route::get('/add-workshop', 'WorkshopController@addWorkshop')->name('admin.addWorkshop');
		Route::post('/save-workshop', 'WorkshopController@saveWorkshop')->name('admin.saveWorkshop');
		Route::get('/edit-workshop/{id}', 'WorkshopController@editWorkShop')->name('admin.editWorkShop');
		Route::post('/save-edited-workshop', 'WorkshopController@saveEditedWorkshop')->name('admin.saveEditedWorkshop');
		Route::get('/delete-workshop/{id}', 'WorkshopController@deleteWorkshop')->name('admin.deleteWorkshop');
		Route::post('/change-workshop-status', 'WorkshopController@changeWorkshopStatus')->name('admin.changeWorkshopStatus');
		Route::post('/change-booking-status', 'WorkshopController@changeBookingStatus')->name('admin.changeBookingStatus');
		Route::post('/update-date', 'WorkshopController@updateDate')->name('admin.updateDate');
		Route::post('/change-invoice-cycle', 'WorkshopController@changeInvoiceCycle')->name('admin.changeInvoiceCycle');
		Route::post('/change-batch-status', 'WorkshopController@changeBatchStatus')->name('admin.changeBatchStatus');
		Route::match(['get','post'],'/engagement-setting/{uuid}', 'WorkshopController@engagementSetting')->name('admin.engagementSetting');
		Route::get('/edit-attendance/{id}', 'WorkshopController@editAttendance')->name('admin.editAttendance');
		Route::post('/save-edited-attendace', 'WorkshopController@saveEditedAttendance')->name('admin.saveEditedAttendance');
		Route::get('/link-engagement-student/{id}', 'WorkshopController@addEngagementStudent')->name('admin.addEngagementStudent');
		Route::post('/save-linked-student', 'WorkshopController@saveLinkedStudent')->name('admin.saveLinkedStudent');
		Route::post('/unlink-student', 'WorkshopController@unlinkUser')->name('admin.unlinkUser');
		Route::post('/get-attendance-detail', 'WorkshopController@getAttendanceDetail')->name('admin.getAttendanceDetail');
		Route::post('/modify-time', 'WorkshopController@modifyTime')->name('admin.modifyTime');
		Route::get('/mark-attendance/{id}', 'WorkshopController@markAttendance')->name('admin.markAttendance');
		Route::post('/save-attendance', 'WorkshopController@saveAttendance')->name('admin.saveAttendance');
		Route::post('/batch/change-update-status', 'WorkshopController@updateStatus')->name('admin.updateStatus');
		Route::post('/change-workshop-student-status', 'WorkshopController@changeWorkshopStudentStatus')->name('admin.changeWorkshopStudentStatus');
	});

	//workshop couse module
	Route::group(['prefix' => 'course'], function () {
		Route::get('/course-list', 'CourseController@courseList')->name('admin.courseList');
		Route::get('/add-course', 'CourseController@addCourse')->name('admin.addCourse');
		Route::post('/save-course', 'CourseController@saveCourse')->name('admin.saveCourse');
		Route::get('/edit-course/{id}', 'CourseController@editCourse')->name('admin.editCourse');
		Route::post('/save-edited-course', 'CourseController@saveEditedCourse')->name('admin.saveEditedCourse');
		Route::get('/delete-course/{id}', 'CourseController@deleteCourse')->name('admin.deleteCourse');
		Route::post('/change-course-status', 'CourseController@changeCourseStatus')->name('admin.changeCourseStatus');
		Route::post('/remove-image-update', 'CourseController@removeImageUpdate')->name('admin.removeImageUpdate');
	});

	//Invoice routes
	Route::group(['prefix' => 'invoice'], function () {
		Route::match(['get','post'],'/invoice-list', 'InvoiceController@invoiceList')->name('admin.invoiceList');
		Route::get('/add-invoice', 'InvoiceController@addInvoice')->name('admin.addInvoice');
		Route::post('/get-student', 'InvoiceController@getStudentJson')->name('admin.getStudentJson');
		Route::post('/get-student-details', 'InvoiceController@getStudentDetails')->name('admin.getStudentDetails');
		Route::post('/generate-invoice', 'InvoiceController@generateInvoice')->name('admin.generateInvoice');
		Route::get('/invoice-list', 'InvoiceController@invoiceList')->name('admin.invoiceList');
		Route::get('/view-invoice/{id}', 'InvoiceController@viewInvoice')->name('admin.viewInvoice');
		Route::get('/edit-invoice/{id}', 'InvoiceController@editInvoice')->name('admin.editInvoice');
		Route::post('/save-edited-invoice', 'InvoiceController@saveEditedInvoice')->name('admin.saveEditedInvoice');
		Route::get('/delete-invoice/{id}', 'InvoiceController@deleteInvoice')->name('admin.deleteInvoice');
		Route::post('/link-list', 'InvoiceController@linkList')->name('admin.linkList');
	});
?>
