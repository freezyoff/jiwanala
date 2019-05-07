<?php

namespace App\Http\Controllers\My\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Service\Auth\User;
use App\Libraries\Bauk\Employee;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$keywords = request('keywords', false);
		$active_status = request('active_status', 1);
		
		$employees = Employee::search($keywords);
	
		if ($active_status > -1){ $employees->where('active', '=', $active_status); }
		
		return view('my.system.user.landing',[
			'employees'=>$employees->paginate(),
			'active_status'=>$active_status,
			'keywords'=>$keywords,
		]);
    }

    /**
     * create new user for given $NIP
     * @param $nip - 
     * @return \Illuminate\Http\Response
     */
    public function create($nip, $email)
    {
		$nip = request('nip',$nip);
		$email = request('email',$email);
		
        $employee = Employee::findByNIP($nip);
		if (!$employee) return redirect()->back();
		
		$registeredUser = User::where('name','=',$employee->nip)->first();
		if ($registeredUser){
			//update email
			$registeredUser->email = $email;
		}
		else{
			//create new record
			$registeredUser = new \App\Libraries\Service\Auth\User([
				'name'=>$employee->nip,
				'email'=>$email,
				'password'=>\Hash::make(rand(0,1000)),
			]);
		}
		$registeredUser->save();
		
		//attach to employee
		$employee->user_id = $registeredUser->id;
		$employee->save();
		
		$registeredUser->sendNewUserInvitationNotification(\Password::broker()->getRepository()->create($registeredUser));
		
		return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $registeredUser = User::find($id);
		if ($registeredUser){
			
			//unlink employee with this user
			$employee = $registeredUser->asEmployee;
			if ($employee){
				$employee->user_id = null;
				$employee->save();
			}
			
			//remove user
			$registeredUser->delete();
		}
		
		return redirect()->back();
    }
	
	public function reset($id){
		$registeredUser = User::find($id);
		$registeredUser->password = \Hash::make(rand(0,1000));
		$registeredUser->sendPasswordResetNotification(\Password::broker()->getRepository()->create($registeredUser));
		return redirect()->back();
	}
}
