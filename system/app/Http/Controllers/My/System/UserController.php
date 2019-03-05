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
		
		$fill = [];
		$fill['name'] = $employee->nip;
		$fill['email'] = $email;
		$fill['password'] = \Hash::make(rand(0,1000));
		
		$user = new \App\Libraries\Service\Auth\User($fill);
		$user->save();
		
		//attach to employee
		$employee->user_id = $user->id;
		$employee->save();
		
		$user->sendNewUserInvitationNotification(\Password::broker()->getRepository()->create($user));
		
		return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
