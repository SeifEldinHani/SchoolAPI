<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParenttController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post("/register" , [AuthController::class , 'register']); 
Route::post("/login" , [AuthController::class , 'login']); 
Route::get("/user" , function()
{
    return User::get(); 
}); 


Route::group(['middleware' => 'auth:api'], function () {
    
Route::get('/details', [AuthController::class , 'details']);


//Teacher Routes
Route::get('/Teacher' , [TeacherController::class , 'index']);  //index
Route::get('/Teacher/{Teacher_Id}' , [TeacherController::class , 'read']); //Read
Route::post("/Attendance/Class/{Class_id}/Student/{Student_id}" , [TeacherController::class , 'attendance']);   //Set attendance
Route::post('/Teacher/{Teacher_id}/Class/{classroom_id}' , [TeacherController::class , 'setClassroom']); //set Classrooms
Route::get("/Teacher/Class/{Class_id}/Students" , [TeacherController::class , 'getStudents']);    //Return All Students of the class
Route::post("/Attendance/Class/{Class_id}/Student/{Student_id}" , [TeacherController::class , 'attendance']);   //Set attendance


//Classes Routes
Route::get('/Classes' , [ClassroomController::class , 'index']);  //index
Route::get('/Classes/{Class_ID}' , [ClassroomController::class , 'read']); //Read
Route::post('/Classes' , [ClassroomController::class , 'create']); //Create
Route::patch('/Classes/{Class_ID}',[ClassroomController::class , 'edit']); //Update
Route::delete('/Classes/{Class_ID}' , [ClassroomController::class , 'delete']); //Delete


//Grades Routes
Route::get('/Grades' , [GradeController::class , 'index']);  //index
Route::get('/Grades/{Grade_ID}' , [GradeController::class , 'read']); //Read
Route::post('/Grades' , [GradeController::class , 'create']); //Create
Route::patch('/Grades/{Grade_ID}',[GradeController::class , 'edit']); //Update
Route::delete('/Grades/{Grade_ID}' , [GradeController::class , 'delete']); //Delete
Route::get('Grades/{Grade_ID}/GetClasses' , [GradeController::class , 'getclasses']) ; 

//Students Routes
Route::get('/Student' , [StudentController::class , 'index']);  //index
Route::get('/Student/{Student_Id}' , [StudentController::class , 'read']); //Read
Route::post('/Student' , [StudentController::class , 'create']); //Create
Route::patch('/Student/{Student_Id}',[StudentController::class , 'edit']); //Update
Route::delete('/Student/{Student_Id}' , [StudentController::class , 'delete']); //Delete






//School Routes
Route::get('/School' , [SchoolController::class , 'index']);  //index
Route::get('/School/{School_Id}' , [SchoolController::class, 'read']); //Read
Route::post('/School' , [SchoolController::class , 'create']); //Create
Route::patch('/School/{School_Id}',[SchoolController::class , 'edit']); //Update
Route::delete('/School/{School_Id}' , [SchoolController::class , 'delete']); //Delete



//Parent Routes
Route::post("Parent/{Parent_id}/School/{School_id}/" ,[ParenttController::class, 'setSchool']);
Route::get("Parent/GetStudents" , [ParenttController::class, 'getStudents']); 
Route::get("/Attendance/Student/{Student_id}" , [ParenttController::class , 'getStudentAttendance']); //Get attendance


});
