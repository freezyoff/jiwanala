<?php 
namespace App\Libraries\Helpers;

use Carbon\Carbon;
use \App\Libraries\Bauk\Employee;

class DashboardNav{
	private static $_instance = null;
	public static $nav = null;
	
	public static function getInstance (){
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }
	
	public static function createDashboardNavigation(){
		self::$nav = collect();
		self::$nav->put('dashboard', self::createDashboardNav());
		self::$nav->put('system', self::createSystemNav());
		self::$nav->put('bauk', self::createBaukNav());
		return self::getInstance();
	}
	
	public static function getTopNavigations(){
		return self::$nav->toArray();
	}
	
	public static function hasLeftNavigations(){
		return self::getSidebars()->count()>0;
	}
	
	public static function getLeftNavigations(){
		return self::$nav->map(function($item, $key){
			return $item['sideNav'];
		});
	}
	
	public static function getLeftNavigation($key){
		return collect(self::$nav->get($key));
	}
	
	public static function sidebarNavVisible($sidebarKey){
		return $sidebarKey && self::getSidebar($sidebarKey)->get('sideNav')->count()>0;
	}
	
	
	
	
	
	
	static function createDashboardNav(){
		$sideNav = [];
		
		$divisions = \Auth::user()->getRoleOption('division.manager', 'divisions');
		$hasRole = is_array($divisions) && !empty($divisions);
		if (is_array($divisions) && !empty($divisions)){
			$sideNav[] = [
				'display'=>['name'=>'Lembaga', 'icon'=>'fas fa-university'],
				'href'=>'my.dashboard.division.landing',
				'permission'=>'division.subordinates.list'
			];
		}
				
		return [
			'display'=>[ 'name'=>'Dashboard', 'icon'=>'fas fa-home','class'=>'w3-text-light-green'],
			'href'=>'my.dashboard.landing',
			'sideNav'=>$sideNav
		];
	}
	
	static function createSystemNav(){
		return [
			'display'=>[ 'name'=>'System', 'icon'=>'fas fa-server'],
			'href'=>'my.system.landing',
			'permission_context'=>'system',
			'sideNav'=>[
				[
					'display'=>[ 'name'=>'Akun', 'icon'=>'fas fa-users'], 
					'href'=>'my.system.user.index',
					'permission'=>'system.user.list'
				],
				[
					'display'=>[ 'name'=>'Unit / Divisi', 'icon'=>'fas fa-users'], 
					'href'=>'my.system.user.index',
					'permission'=>'system.user.list'
				]
			]
		];
	}
	
	static function createBaukNav(){
										
		return [
			'display'=>[ 'name'=>'BAUK', 'icon'=>'fas fa-fingerprint'],
			'href'=>'my.bauk.landing',
			'permission_context'=>'bauk',
			'sideNav'=>[
				[
					'display'=>[ 'name'=>'Hari Libur', 'icon'=>'fas fa-calendar-check fa-fw' ], 
					'permission'=>'bauk.holiday.list',
					'href'=>'my.bauk.holiday.landing',
				],
				[
					'display'=>[ 'name'=>'Manajemen Karyawan', 'icon'=>'fas fa-user-circle' ],
					'permission'=>'',
					'href'=>'my.bauk.employee.landing',
					'group'=> true,
					'items'=> [
						[
							'permission'=>'bauk.employee.list',
							'display'=>[ 				
								'name'=>'Daftar Karyawan', 
								'icon'=>false,
							], 
							'href'=>'my.bauk.employee.landing',
						],
						[
							'permission'=>'bauk.assignment.list',
							'display'=>[ 
								'name'=>'Penugasan',
								'tag'=>[
									'label'=>"update",
									'color'=>'w3-blue'
								]
							], 
							'href'=>'my.bauk.assignment.landing',
						],
						[
							'permission'=>'bauk.schedule.list',
							'display'=>[ 				
								'name'=>'Jadwal Kerja', 
								'icon'=>false,
								//'tag'=>[
								//	'label'=>"update",
								//	'color'=>'w3-blue'
								//]
							], 
							'href'=>'my.bauk.schedule.landing',
						],
					]
				],
				[
					'display'=>[ 'name'=>'Absensi Kehadiran', 'icon'=>'far fa-eye' ], 
					'permission'=>'bauk.attendance.list',
					'href'=>'my.bauk.attendance.landing',
					'group'=> true,
					'items'=> [
						[
							'permission'=>'bauk.attendance.list',
							'display'=>[ 				
								'name'=>'Riwayat', 
								'icon'=>false ,
								//'tag'=>[
								//	'label'=>"new feature",
								//	'color'=>'w3-green'
								//]
							], 
							'href'=>'my.bauk.attendance.landing',
						],
						[
							'permission'=>'bauk.attendance.post',
							'display'=>[ 				
								'name'=>'Upload Finger', 
								'icon'=>false,
								//'tag'=>[
								//	'label'=>"update",
								//	'color'=>'w3-blue'
								//]
							], 
							'href'=>'my.bauk.attendance.upload',
						],
						[
							'permission'=>'bauk.attendance.report',
							'display'=>[ 				
								'name'=>'Laporan', 
								'icon'=>false,
								//'tag'=>[
								//	'label'=>"new feature",
								//	'color'=>'w3-green'
								//]
							], 
							'href'=>'my.bauk.attendance.report.landing',
						]
					]
				],
			]
		];
	}
}