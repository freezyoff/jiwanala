<?php 
namespace App\Libraries\Foundation\Console;

trait AllowLocalAndRemoteConnection{
	function getRemoteConnectionSignature(){
		return '
			{--ld|local-driver=			: local connection driver}
			{--lo|local-host=			: local connection host}
			{--lu|local-username=		: local connection username}
			{--lp|local-password=		: local connection password}
			{--lnp|remote-no-password	: local connection need no password}
			
			{--rd|remote-driver=		: remote connection driver}
			{--ro|remote-host=			: remote connection host}
			{--ru|remote-username=		: remote connection username}
			{--rp|remote-password=		: remote connection password}
			{--rnp|remote-no-password	: remote connection need no password}
		';
	}
}