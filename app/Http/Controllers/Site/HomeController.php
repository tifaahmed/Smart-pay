<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Resource
use App\Http\Resources\Dashboard\SiteSetting\SiteSettingResource ;

// lInterfaces
use App\Repository\SiteSettingRepositoryInterface;

class HomeController extends Controller
{
    private $SiteSettingRepository;
    public function __construct(SiteSettingRepositoryInterface $SiteSettingRepository)
    {
        $this->SiteSettingRepository = $SiteSettingRepository;
    }

    public function admin_panel()
    {
        $site_setting =    $this->SiteSettingRepository->all()    ;
        
        $site_name = '' ; 
        $logo = '' ; 
        foreach ($site_setting as $key => $value) {
            $logo =  $value->id == 1 ? check_image($value->item): $logo;

            if (App()->getLocale() == 'ar' ) {
                $site_name =   $value->id == 4 ? $value->item: $site_name;
            }else {
                $site_name =   $value->id == 3 ? $value->item: $site_name;
            }
        }
         
        return  view( 'admin-panel' , compact('site_name','logo'));
    }
}
