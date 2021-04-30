<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//create
Route::get('/user/{user_id}/createrole/{role_name}', function ($user_id, $role_name) {

    $user = User::findOrFail($user_id);
    $role = new Role(['name'=>$role_name]);
    $user->roles()->save($role);

});

//read
Route::get('/user/{user_id}/readroles', function($user_id){

    $user = User::findOrFail($user_id);
    foreach ($user->roles as $role) {
        return $role;
    }
});


//update
Route::get('/user/{user_id}/updateroles/{old_role_name}/{role_name}', function($user_id,$old_role_name, $new_role_name) {

    $user = User::findOrFail($user_id);
    if($user->has('roles')){        
        foreach($user->roles as $role){
            
            if($role->name == $old_role_name){
                $role->name = $new_role_name;
                $role->save();
            }
        }
    }
});

//delete
Route::get('/user/{user_id}/deleterole/{role_name}', function($user_id, $role_name) {
    $user = User::findOrFail($user_id);
    $user->roles()->whereName($role_name)->delete();
});


Route::get('user/{user_id}/attachrole/{role_id}', function($user_id, $role_id){
    $user = User::findOrFail($user_id);

    $user->roles()->attach($role_id);
});


Route::get('/user/{user_id}/detachrole/{role_id}', function($user_id, $role_id){

    $user = User::findOrFail($user_id);

    $user->roles()->detach($role_id);
});


Route::get('/user/{user_id}/syncrole/{role_id}', function($user_id, $role_id){
    
    $user = User::findOrFail($user_id);
    $user->roles()->sync([$role_id]);

});