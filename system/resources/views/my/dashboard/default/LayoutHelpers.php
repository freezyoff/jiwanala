<?php 

/**
 *	Autoload via composer.json
 */

if (! function_exists('getCurrentHeaderBrandDropdownCaption')) {
    function getCurrentHeaderBrandDropdownCaption() {
        $key = getCurrentHeaderBrandDropdownKey();
		return getHeaderBrandDropdownList($key)['caption'];
    }
}

if (! function_exists('getCurrentHeaderBrandDropdownKey')) {
    function getCurrentHeaderBrandDropdownKey() {
        $routeName = Request::route()->getName();
		$exp = explode('.',$routeName);
		return $exp[0];
    }
}

if (! function_exists('getHeaderBrandDropdownList')) {
	function getHeaderBrandDropdownList($key=null){
		if ($key === null) return config('jn.brandDropdown');
		return config('jn.brandDropdown.'.$key);
	}
};

if (! function_exists('getAsideList')) {
	function getAsideList($key=null){
		if ($key === null) return config('jn.aside');
		return config('jn.aside.'.$key);
	}
};

if (! function_exists('getCurrentAsideList')) {
	function getCurrentAsideList($key=null){
		return getAsideList(getCurrentHeaderBrandDropdownKey());
	}
};

if (! function_exists('currentAsideHasList')) {
	function currentAsideHasList(){
		return count(getAsideList(getCurrentHeaderBrandDropdownKey()))>0;
	}
};

if (! function_exists('getCurrentSubHeaderConfig')) {
	function getCurrentSubHeaderConfig(){
		$routeName = Request::route()->getName();
		return config('jn.subHeader.'.$routeName);
	}
}; 

if (! function_exists('getCurrentSubHeaderTitle')) {
	function getCurrentSubHeaderTitle(){
		$subHeader = getCurrentSubHeaderConfig();
		return $subHeader['caption'];
	}
}; 

if (! function_exists('currentSubHeaderHasBreadcrumb')) {
	function currentSubHeaderHasBreadcrumb(){
		$subHeader = getCurrentSubHeaderBreadcrumbList();
		return count($subHeader)>1;
	}
}; 

if (! function_exists('getCurrentSubHeaderBreadcrumbList')) {
	function getCurrentSubHeaderBreadcrumbList(){
		$subHeader = Request::route()->getName();
		$exp = explode('.',$subHeader);
		$loop = count($exp);
		$brc = [];
		$currentKey = null;
		for($i=0; $i<$loop; $i++){
			if ($currentKey === null){
				$currentKey = $exp[$i];
			}
			else{
				$currentKey .= '.'.$exp[$i];
				$brc[] = ['type'=>'separator'];
			}
			
			$currentBrc = config('jn.subHeader.'.$currentKey.'.breadcrumb');
			if ( !isset($currentBrc['caption']) ){
				$currentBrc['caption'] = config('jn.subHeader.'.$currentKey.'.caption');
			}
			$brc[] = $currentBrc;
		}
		return $brc;
	}
}

if (! function_exists('currentSubHeaderHasQuickAction')) {
	function currentSubHeaderHasQuickAction(){
		$subHeader = getCurrentSubHeaderConfig();
		if (array_key_exists('quickAction', $subHeader)) {
			$qa = $subHeader['quickAction'];
			return isset($qa['type']) && isset($qa['view']);
		}
		return false;
	}
}

if (! function_exists('getCurrentSubHeaderQuickAction')) {
	function getCurrentSubHeaderQuickAction(){
		if (currentSubHeaderHasQuickAction()){
			$subHeader = getCurrentSubHeaderConfig();
			return $subHeader['quickAction'];
		}
		return [];
	}
}

if (! function_exists('getCurrentSubHeaderQuickActionType')) {
	function getCurrentSubHeaderQuickActionType(){
		if (currentSubHeaderHasQuickAction()){
			$subHeader = getCurrentSubHeaderConfig();
			return $subHeader['quickAction']['type'];
		}
		return false;
	}
}

if (! function_exists('getCurrentSubHeaderQuickActionView')) {
	function getCurrentSubHeaderQuickActionView(){
		if (currentSubHeaderHasQuickAction()){
			$subHeader = getCurrentSubHeaderConfig();
			return $subHeader['quickAction']['view'];
		}
		return false;
	}
}
