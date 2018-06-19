<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Auth;
use Session;
use Validator;
use Image;
use App\User;
use App\Promo;
use App\PromoStats;
use App\PromoLocations;
use App\Coupon;
use App\Store;
use App\StoreUser;
use App\UserTeam;
use App\Winner;
use App\Wording;
use App\StoreCategory;
use App\SavedCoupons;
use App\DeviceInfo;
use App\Notifications;
use App\UserTable;
use App\PreLaunch;
use App\AppSettings;
use App\ExtendValues;
use App\RetargetCoupon;
use App\RetargetSaved;
use App\RetargetStats;

use App\Mail\UserAcceptance;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Requests\UserPanelRequest;
use App\Http\Controllers\Controller;


use App\Classes\ExtraFunctions;
use App\Classes\Converter;
use App\Classes\PushNotification;

class UserPanelController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if(Auth::user()->usertype == 0){
            $view = view('admin.users_panel.dashboard_admin');
            $view->title = 'Stats';
            $view->users = User::where(['active' => '1'])->count();
            $view->promos = Promo::where(['status' => '1'])->count();
            $view->cpromos = Promo::where(['status' => '0'])->count();
            $view->coupons = Coupon::where(['status' => '1'])->count();
            $view->stores = Store::where(['status' => '1'])->count();
            $view->notifications = Notifications::distinct()->select('user_id')->where('active', '1')->groupBy('user_id')->paginate(10);
        }
        else{
            if(Auth::user()->accepted == '0'){
                return redirect('user/accept');
            }

            $view = view('user.dashboard.dashboard_user');
            $view->title = 'CouponCam::Dashboard';

            $show_pre_launch = 0;
            // get user details
            $get_user_details = UserTable::where(['id' => Auth::id()])->get();
            $is_pre_launch = $get_user_details[0]->is_pre_launch;

            // get app settings
            $app_settings = AppSettings::get();
            $is_award_given = 0;
            foreach ($app_settings as $setting) {
                if($setting->setting_name == 'is_award_given'){
                    $is_award_given = $setting->setting;
                }
            }

            if( ($is_pre_launch == 1) && ($is_award_given == 0) ) {
                $show_pre_launch = 1;
            }

            $view->show_pre_launch = $show_pre_launch;

            $active_stores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
                ->where(['store_user.user_id' => Auth::id(), 'places.status' => 1])
                ->orderBY('updated_at', 'DESC')
                ->get();

            $stores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
                ->where(['store_user.user_id' => Auth::id()])
                ->orderBY('updated_at', 'DESC')
                ->get();

            $get_all_promos = Promo::join('promo_locations', 'promo_locations.promo_id','=','promos.promo_id')
                ->join('store_user', 'store_user.place_id','=','promo_locations.store_id')
                ->where(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 1, 'promos.used' => '1'])
                ->orWhere(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 0, 'promos.used' => '1'])
                ->orWhere(['store_user.user_id' => Auth::id(), 'promo_locations.status' => 1, 'promos.status' => 2, 'promos.used' => '1'])
                ->orderBY('promos.updated_at', 'DESC')
                ->get();



            $today = date('Y-m-d');
            $yesterDay = date('Y-m-d', strtotime($today . ' - 1 days'));
            $weekBefore = date('Y-m-d', strtotime($today . ' - 7 days'));
            $monthBefore = date('Y-m-d', strtotime($today . ' - 1 month'));

            // get stats for stores
            $store_stats = [];

            foreach ($stores as $store) {
                $store_id = $store->place_id;

                // get promo ids by store
                $get_promo_ids = PromoLocations::where('store_id', $store_id)->get();

                // get stats for most recent day
                $stat_y = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0 ];

                // get stats for last week
                $stat_w = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0 ];

                // get stats for last month
                $stat_m = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0 ];

                // get stats for all time
                $stat_a = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0 ];


                // stats for yesterday
                // get coupon counts
                foreach ($get_promo_ids as $get_promos) {
                    // promo id
                    $temp_promo_id = $get_promos->promo_id;

                    // get different device id that saved yesterday
                    $get_svd_yesterday = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id,'created_at' => $yesterDay])->select('device_id')->distinct()->get();

                    // for every saved device
                    foreach ($get_svd_yesterday as $svd_y) {
                        $temp_svd_dv_id = $svd_y->device_id;

                        // getdifferent coupon ids for this promo and device
                        $temp_coup_ids = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id,'created_at' => $yesterDay, 'device_id' => $temp_svd_dv_id])->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                        // get count for each coup
                        foreach ($temp_coup_ids as $temp_coups) {
                            // coupon_id
                            $t_coup_id = $temp_coups->coupon_id;

                            // get count for this coupon
                            $temp_cp_count = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id,'created_at' => $yesterDay, 'device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->count();

                            // get coupon level
                            $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                            if(sizeof($get_cp_level) > 0 ) {
                                $temp_cp_level = $get_cp_level[0]->coupon_level;

                                if($temp_cp_level == 1) {
                                    $stat_y['cp_1'] += $temp_cp_count;
                                } else if($temp_cp_level == 2) {
                                    $stat_y['cp_2'] += $temp_cp_count;
                                } else if($temp_cp_level == 3) {
                                    $stat_y['cp_3'] += $temp_cp_count;
                                } else if($temp_cp_level == 4) {
                                    $stat_y['cp_4'] += $temp_cp_count;
                                }
                            }
                            
                        }
                    }

                }

                // get new customers for this store
                $get_new_c_yesterday = PromoStats::where(['place_id' => $store_id,'created_at' => $yesterDay])->select('device_id')->distinct()->get();

                // check if user is a existing user or not
                foreach ($get_new_c_yesterday as $customer) {
                    // device_id
                    $t_d_id = $customer->device_id;

                    // get all records for this device
                    $get_all_by_id = PromoStats::where(['device_id' => $t_d_id, 'place_id' => $store_id])->count();


                    // get yester day records
                    $get_yesterday  = PromoStats::where(['device_id' => $t_d_id, 'place_id' => $store_id, 'created_at' => $yesterDay])->count();


                    if($get_all_by_id == $get_yesterday) {
                            $stat_y['new_c'] += 1;
                    }
                }
                // end promo stats yesterday


                 // stats for last week
                foreach ($get_promo_ids as $get_promos) {
                    // promo id
                    $temp_promo_id = $get_promos->promo_id;

                    // get different device id that saved yesterday
                    $get_svd_week = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id])->whereBetween('created_at', array($weekBefore, $today))->select('device_id')->distinct()->get();

                    // for every saved device
                    foreach ($get_svd_week as $svd_y) {
                        $temp_svd_dv_id = $svd_y->device_id;

                        // getdifferent coupon ids for this promo and device
                        $temp_coup_ids = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id,'device_id' => $temp_svd_dv_id])->whereBetween('created_at', array($weekBefore, $today))->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                        // get count for each coup
                        foreach ($temp_coup_ids as $temp_coups) {
                            // coupon_id
                            $t_coup_id = $temp_coups->coupon_id;

                            // get count for this coupon
                            $temp_cp_count = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id,'device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->whereBetween('created_at', array($weekBefore, $today))->count();

                            // get coupon level
                            $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                            if(sizeof($get_cp_level) > 0) {
                                $temp_cp_level = $get_cp_level[0]->coupon_level;

                                if($temp_cp_level == 1) {
                                    $stat_w['cp_1'] += $temp_cp_count;
                                } else if($temp_cp_level == 2) {
                                    $stat_w['cp_2'] += $temp_cp_count;
                                } else if($temp_cp_level == 3) {
                                    $stat_w['cp_3'] += $temp_cp_count;
                                } else if($temp_cp_level == 4) {
                                    $stat_w['cp_4'] += $temp_cp_count;
                                }
                            }
                            
                        }
                    }

                }

                // get new customers for last week
                $get_new_c_week = PromoStats::where('place_id', $store_id)
                    ->whereBetween('created_at', array($weekBefore, $today))
                    ->select('device_id')
                    ->distinct()->get();

                foreach ($get_new_c_week as $customer) {
                    // device_id
                    $t_d_id = $customer->device_id;

                    // get all records for this device
                    $get_all_by_id = PromoStats::where(['device_id' => $t_d_id, 'place_id' => $store_id])->count();


                    // get yester day records
                    $get_week  = PromoStats::where(['device_id' => $t_d_id, 'place_id' => $store_id])->whereBetween('created_at', array($weekBefore, $today))->count();


                    if($get_all_by_id == $get_week) {
                        $stat_w['new_c'] += 1;
                    }
                }
                // end promo stats last week



                // stats for last month
                foreach ($get_promo_ids as $get_promos) {
                    // promo id
                    $temp_promo_id = $get_promos->promo_id;

                    // get different device id that saved yesterday
                    $get_svd_month = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id])->whereBetween('created_at', array($monthBefore, $today))->select('device_id')->distinct()->get();

                    // for every saved device
                    foreach ($get_svd_month as $svd_y) {
                        $temp_svd_dv_id = $svd_y->device_id;

                        // getdifferent coupon ids for this promo and device
                        $temp_coup_ids = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id,'device_id' => $temp_svd_dv_id])->whereBetween('created_at', array($monthBefore, $today))->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                        // get count for each coup
                        foreach ($temp_coup_ids as $temp_coups) {
                            // coupon_id
                            $t_coup_id = $temp_coups->coupon_id;

                            // get count for this coupon
                            $temp_cp_count = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id,'device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->whereBetween('created_at', array($monthBefore, $today))->count();

                            // get coupon level
                            $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                            if(sizeof($get_cp_level) > 0) {
                                $temp_cp_level = $get_cp_level[0]->coupon_level;

                                if($temp_cp_level == 1) {
                                    $stat_m['cp_1'] += $temp_cp_count;
                                } else if($temp_cp_level == 2) {
                                    $stat_m['cp_2'] += $temp_cp_count;
                                } else if($temp_cp_level == 3) {
                                    $stat_m['cp_3'] += $temp_cp_count;
                                } else if($temp_cp_level == 4) {
                                    $stat_m['cp_4'] += $temp_cp_count;
                                }
                            }
                            
                        }
                    }

                }

                // get new customers
                $get_new_c_month = PromoStats::where('place_id', $store_id)
                    ->whereBetween('created_at', array($monthBefore, $today))
                    ->select('device_id')
                    ->distinct()->get();

                foreach ($get_new_c_month as $customer) {
                    // device_id
                    $t_d_id = $customer->device_id;

                    // get all records for this device
                    $get_all_by_id = PromoStats::where(['device_id' => $t_d_id, 'place_id' => $store_id])->count();


                    // get yester day records
                    $get_month  = PromoStats::where(['device_id' => $t_d_id, 'place_id' => $store_id])->whereBetween('created_at', array($monthBefore, $today))->count();

                    if($get_all_by_id == $get_month) {
                        $stat_m['new_c'] += 1;
                    }
                }
                // end promo stats last month


                // stats for all time
                foreach ($get_promo_ids as $get_promos) {

                    // promo id
                    $temp_promo_id = $get_promos->promo_id;

                    // get different device id that saved yesterday
                    $get_svd_all_time = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id])->select('device_id')->distinct()->get();

                    // for every saved device
                    foreach ($get_svd_all_time as $svd_y) {
                        $temp_svd_dv_id = $svd_y->device_id;

                        // getdifferent coupon ids for this promo and device
                        $temp_coup_ids = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id,'device_id' => $temp_svd_dv_id])->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                        // get count for each coup
                        foreach ($temp_coup_ids as $temp_coups) {
                            // coupon_id
                            $t_coup_id = $temp_coups->coupon_id;

                            // get count for this coupon
                            $temp_cp_count = PromoStats::where(['place_id' => $store_id, 'promo_id' => $temp_promo_id,'device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->count();

                            // get coupon level
                            $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                            if(sizeof($get_cp_level) > 0) {
                                $temp_cp_level = $get_cp_level[0]->coupon_level;

                                if($temp_cp_level == 1) {
                                    $stat_a['cp_1'] += $temp_cp_count;
                                } else if($temp_cp_level == 2) {
                                    $stat_a['cp_2'] += $temp_cp_count;
                                } else if($temp_cp_level == 3) {
                                    $stat_a['cp_3'] += $temp_cp_count;
                                } else if($temp_cp_level == 4) {
                                    $stat_a['cp_4'] += $temp_cp_count;
                                }
                            }
                            
                        }
                    }

                }

                // get new customers
                $get_new_customers = PromoStats::where('place_id', $store_id)->select('device_id')->distinct()->get();
                $stat_a['new_c'] += sizeof($get_new_customers);
                // end promo stats all time

                // | return | //
                $store_stats[] = [
                    'store_id' => $store_id,
                    'store_name' => $store->contact_name,
                    'city' => $store->street_number . " " . $store->street_address,
                    'recent_day' => $stat_y,
                    '7_day' => $stat_w,
                    '30_day' => $stat_m,
                    'all' => $stat_a
                ];


            }
            // end of stat by store
            // return stats by store
            $view->stores = $store_stats;


            // promo stats
            $promo_stats = [];
            // // get stats by promo
             foreach ($get_all_promos as $ga_promo) {
                 // promo id
                 $promo_id = $ga_promo->promo_id;

                 // get stats for most recent day
                 $stat_p_y = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0, 'ret_c' => 0, 'loy_c' => 0, 'revenue' => 0 ];

                 // get stats for last week
                 $stat_p_w = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0, 'ret_c' => 0, 'loy_c' => 0, 'revenue' => 0 ];

                 // get stats for last month
                 $stat_p_m = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0, 'ret_c' => 0, 'loy_c' => 0, 'revenue' => 0 ];

                 // get stats for all time
                 $stat_p_a = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0, 'ret_c' => 0, 'loy_c' => 0, 'revenue' => 0 ];

                 // stats for yesterday
                 // get coupon count
                 // get different device id that saved yesterday
                 $get_svd_p_yesterday = PromoStats::where(['promo_id' => $promo_id,'created_at' => $yesterDay])->select('device_id')->distinct()->get();

                 // for every saved device
                 foreach ($get_svd_p_yesterday as $svd_y) {
                     $temp_svd_dv_id = $svd_y->device_id;

                     // getdifferent coupon ids for this promo and device
                     $temp_coup_ids = PromoStats::where(['promo_id' => $promo_id,'created_at' => $yesterDay, 'device_id' => $temp_svd_dv_id])->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                     // get count for each coup
                     foreach ($temp_coup_ids as $temp_coups) {
                         // coupon_id
                         $t_coup_id = $temp_coups->coupon_id;

                         // get count for this coupon
                         $temp_cp_count = PromoStats::where(['promo_id' => $promo_id,'created_at' => $yesterDay, 'device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->count();

                         // get coupon level
                         $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                         $temp_cp_level = $get_cp_level[0]->coupon_level;

                         if($temp_cp_level == 1) {
                             $stat_p_y['cp_1'] += $temp_cp_count;
                         } else if($temp_cp_level == 2) {
                             $stat_p_y['cp_2'] += $temp_cp_count;
                         } else if($temp_cp_level == 3) {
                             $stat_p_y['cp_3'] += $temp_cp_count;
                         } else if($temp_cp_level == 4) {
                             $stat_p_y['cp_4'] += $temp_cp_count;
                         }
                     }
                 }

                 // get new customers for this promo
                 $gnc_p_yesterday = PromoStats::where(['promo_id' => $promo_id,'created_at' => $yesterDay])->select('device_id')->distinct()->get();

                 // check if user is a existing user or not
                 foreach ($gnc_p_yesterday as $customer_p) {
                     // device_id
                     $t_d_id = $customer_p->device_id;

                     // get all records for this device
                     $get_p_all_id = PromoStats::where(['device_id' => $t_d_id, 'promo_id' => $promo_id])->count();


                     // get yester day records
                     $get_p_y  = PromoStats::where(['device_id' => $t_d_id, 'promo_id' => $promo_id, 'created_at' => $yesterDay])->count();


                     if($get_p_all_id == $get_p_y) {
                         $stat_p_y['new_c'] += 1;
                     }
                 }
                 // end promo stats yesterday



                 // stat for last week (promo)
                 // get different device id that saved yesterday
                 $get_svd_p_week = PromoStats::where(['promo_id' => $promo_id])->whereBetween('created_at', array($weekBefore, $today))->select('device_id')->distinct()->get();

                 // for every saved device
                 foreach ($get_svd_p_week as $svd_y) {
                     $temp_svd_dv_id = $svd_y->device_id;

                     // getdifferent coupon ids for this promo and device
                     $temp_coup_ids = PromoStats::where(['promo_id' => $promo_id,'device_id' => $temp_svd_dv_id])->whereBetween('created_at', array($weekBefore, $today))->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                     // get count for each coup
                     foreach ($temp_coup_ids as $temp_coups) {
                         // coupon_id
                         $t_coup_id = $temp_coups->coupon_id;

                         // get count for this coupon
                         $temp_cp_count = PromoStats::where(['promo_id' => $promo_id,'device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->whereBetween('created_at', array($weekBefore, $today))->count();

                         // get coupon level
                         $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                         $temp_cp_level = $get_cp_level[0]->coupon_level;

                         if($temp_cp_level == 1) {
                             $stat_p_w['cp_1'] += $temp_cp_count;
                         } else if($temp_cp_level == 2) {
                             $stat_p_w['cp_2'] += $temp_cp_count;
                         } else if($temp_cp_level == 3) {
                             $stat_p_w['cp_3'] += $temp_cp_count;
                         } else if($temp_cp_level == 4) {
                             $stat_p_w['cp_4'] += $temp_cp_count;
                         }
                     }
                 }

                 // get new customers for last week
                 $gnc_p_week = PromoStats::where('promo_id', $promo_id)
                     ->whereBetween('created_at', array($weekBefore, $today))
                     ->select('device_id')
                     ->distinct()->get();

                 foreach ($gnc_p_week as $customer_p) {
                     // device_id
                     $t_d_id = $customer_p->device_id;

                     // get all records for this device
                     $get_p_all_id = PromoStats::where(['device_id' => $t_d_id, 'promo_id' => $promo_id])->count();


                     // get yesterday records
                     $get_p_w  = PromoStats::where(['device_id' => $t_d_id, 'promo_id' => $promo_id])->whereBetween('created_at', array($weekBefore, $today))->count();


                     if($get_p_all_id == $get_p_w) {
                         $stat_p_w['new_c'] += 1;
                     }
                 }
                 // end promo stats last week



                 // get stats last month promo
                 // get different device id that saved yesterday
                    $get_svd_p_month = PromoStats::where(['promo_id' => $promo_id])->whereBetween('created_at', array($monthBefore, $today))->select('device_id')->distinct()->get();

                    // for every saved device
                    foreach ($get_svd_p_month as $svd_y) {
                        $temp_svd_dv_id = $svd_y->device_id;

                        // getdifferent coupon ids for this promo and device
                        $temp_coup_ids = PromoStats::where(['promo_id' => $promo_id,'device_id' => $temp_svd_dv_id])->whereBetween('created_at', array($monthBefore, $today))->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                        // get count for each coup
                        foreach ($temp_coup_ids as $temp_coups) {
                            // coupon_id
                            $t_coup_id = $temp_coups->coupon_id;

                            // get count for this coupon
                            $temp_cp_count = PromoStats::where(['promo_id' => $promo_id,'device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->whereBetween('created_at', array($monthBefore, $today))->count();

                            // get coupon level
                            $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                            $temp_cp_level = $get_cp_level[0]->coupon_level;

                            if($temp_cp_level == 1) {
                                $stat_p_m['cp_1'] += $temp_cp_count;
                            } else if($temp_cp_level == 2) {
                                $stat_p_m['cp_2'] += $temp_cp_count;
                            } else if($temp_cp_level == 3) {
                                $stat_p_m['cp_3'] += $temp_cp_count;
                            } else if($temp_cp_level == 4) {
                                $stat_p_m['cp_4'] += $temp_cp_count;
                            }
                        }
                    }

                 // get new customers
                 $gnc_p_month = PromoStats::where('promo_id', $promo_id)
                     ->whereBetween('created_at', array($monthBefore, $today))
                     ->select('device_id')
                     ->distinct()->get();

                 foreach ($gnc_p_month as $customer_p) {
                     // device_id
                     $t_d_id = $customer_p->device_id;

                     // get all records for this device
                     $get_all_by_id = PromoStats::where(['device_id' => $t_d_id, 'promo_id' => $promo_id])->count();


                     // get yester day records
                     $get_month  = PromoStats::where(['device_id' => $t_d_id, 'promo_id' => $promo_id])->whereBetween('created_at', array($monthBefore, $today))->count();

                     if($get_all_by_id == $get_month) {
                         $stat_p_m['new_c'] += 1;
                     }
                 }
                 // end promo stats last month


                 // stats for all time promo
                 // get different device id that saved yesterday
                 $get_svd_p_all_time = PromoStats::where(['promo_id' => $promo_id])->select('device_id')->distinct()->get();

                 // for every saved device
                 foreach ($get_svd_p_all_time as $svd_y) {
                     $temp_svd_dv_id = $svd_y->device_id;

                     // getdifferent coupon ids for this promo and device
                     $temp_coup_ids = PromoStats::where(['promo_id' => $promo_id,'device_id' => $temp_svd_dv_id])->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                     // get count for each coup
                     foreach ($temp_coup_ids as $temp_coups) {
                         // coupon_id
                         $t_coup_id = $temp_coups->coupon_id;

                         // get count for this coupon
                         $temp_cp_count = PromoStats::where(['promo_id' => $promo_id,'device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->count();

                         // get coupon level
                         $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                         $temp_cp_level = $get_cp_level[0]->coupon_level;

                         if($temp_cp_level == 1) {
                             $stat_p_a['cp_1'] += $temp_cp_count;
                         } else if($temp_cp_level == 2) {
                             $stat_p_a['cp_2'] += $temp_cp_count;
                         } else if($temp_cp_level == 3) {
                             $stat_p_a['cp_3'] += $temp_cp_count;
                         } else if($temp_cp_level == 4) {
                             $stat_p_a['cp_4'] += $temp_cp_count;
                         }
                     }
                 }

                 // get new customers
                 $gnc_p_customers = PromoStats::where('promo_id', $promo_id)->select('device_id')->distinct()->get();
                 $stat_p_a['new_c'] += sizeof($gnc_p_customers);
                 // end promo stats all time

                 $promo_stats[] = [
                     'promo_id' => $ga_promo->promo_id,
                     'promo_name' => $ga_promo->promo_name,
                     'recent_day' => $stat_p_y,
                     '7_day' => $stat_p_w,
                     '30_day' => $stat_p_m,
                     'all' => $stat_p_a
                 ];
             }
            //
            $view->promos = $promo_stats;


            $all_time_stats = [];

            // calculate all time stats
            // get stats for most recent day
            $stat_a_y = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0 ];

            // get stats for last week
            $stat_a_w = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0 ];

            // get stats for last month
            $stat_a_m = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0 ];

            // get stats for all time
            $stat_a_a = [ 'cp_1' => 0, 'cp_2' => 0, 'cp_3' => 0, 'cp_4' => 0, 'new_c' => 0 ];

            // get all stat yesterday
            // get different device id that saved yesterday
            $get_svd_all_yesterday = PromoStats::where(['created_at' => $yesterDay])->select('device_id')->distinct()->get();

            // for every saved device
            foreach ($get_svd_all_yesterday as $svd_y) {
                $temp_svd_dv_id = $svd_y->device_id;

                // getdifferent coupon ids for this promo and device
                $temp_coup_ids = PromoStats::where(['created_at' => $yesterDay, 'device_id' => $temp_svd_dv_id])->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                // get count for each coup
                foreach ($temp_coup_ids as $temp_coups) {
                    // coupon_id
                    $t_coup_id = $temp_coups->coupon_id;

                    // get count for this coupon
                    $temp_cp_count = PromoStats::where(['created_at' => $yesterDay, 'device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->count();

                    // get coupon level
                    $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                    if(sizeof($get_cp_level) > 0) {
                        $temp_cp_level = $get_cp_level[0]->coupon_level;

                        if($temp_cp_level == 1) {
                            $stat_a_y['cp_1'] += $temp_cp_count;
                        } else if($temp_cp_level == 2) {
                            $stat_a_y['cp_2'] += $temp_cp_count;
                        } else if($temp_cp_level == 3) {
                            $stat_a_y['cp_3'] += $temp_cp_count;
                        } else if($temp_cp_level == 4) {
                            $stat_a_y['cp_4'] += $temp_cp_count;
                        }
                    }
                    
                }
            }

            // get new customers
            $get_a_c_yesterday = PromoStats::where(['created_at' => $yesterDay])->select('device_id')->distinct()->get();

            // check if user is a existing user or not
            foreach ($get_a_c_yesterday as $customer_a) {
                // device_id
                $t_d_id = $customer_a->device_id;

                // get all records for this device
                $get_a_all_by_id = PromoStats::where(['device_id' => $t_d_id])->count();


                // get yester day records
                $get_a_yesterday  = PromoStats::where(['device_id' => $t_d_id, 'created_at' => $yesterDay])->count();


                if($get_a_all_by_id == $get_a_yesterday) {
                    $stat_a_y['new_c'] += 1;
                }
            }
            // end promo stats yesterday


            // stat all last week
            // get different device id that saved yesterday
            $get_svd_a_week = PromoStats::whereBetween('created_at', array($weekBefore, $today))->select('device_id')->distinct()->get();

            // for every saved device
            foreach ($get_svd_a_week as $svd_y) {
                $temp_svd_dv_id = $svd_y->device_id;

                // getdifferent coupon ids for this promo and device
                $temp_coup_ids = PromoStats::where(['device_id' => $temp_svd_dv_id])->whereBetween('created_at', array($weekBefore, $today))->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                // get count for each coup
                foreach ($temp_coup_ids as $temp_coups) {
                    // coupon_id
                    $t_coup_id = $temp_coups->coupon_id;

                    // get count for this coupon
                    $temp_cp_count = PromoStats::where(['device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->whereBetween('created_at', array($weekBefore, $today))->count();

                    // get coupon level
                    $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();
                    if(sizeof($get_cp_level) > 0) {
                        $temp_cp_level = $get_cp_level[0]->coupon_level;

                        if($temp_cp_level == 1) {
                            $stat_a_w['cp_1'] += $temp_cp_count;
                        } else if($temp_cp_level == 2) {
                            $stat_a_w['cp_2'] += $temp_cp_count;
                        } else if($temp_cp_level == 3) {
                            $stat_a_w['cp_3'] += $temp_cp_count;
                        } else if($temp_cp_level == 4) {
                            $stat_a_w['cp_4'] += $temp_cp_count;
                        }
                    }
                    
                }
            }

            // get new customers for last week
            $gnc_a_week = PromoStats::whereBetween('created_at', array($weekBefore, $today))
                ->select('device_id')
                ->distinct()->get();

            foreach ($gnc_a_week as $customer_a) {
                // device_id
                $t_d_id = $customer_a->device_id;

                // get all records for this device
                $get_a_all_id = PromoStats::where(['device_id' => $t_d_id])->count();


                // get yesterday records
                $get_a_w  = PromoStats::where(['device_id' => $t_d_id])->whereBetween('created_at', array($weekBefore, $today))->count();


                if($get_a_all_id == $get_a_w) {
                    $stat_a_w['new_c'] += 1;
                }
            }
            // end promo stats last week


            // get stats last month promo
            // get different device id that saved yesterday
            $get_svd_a_month = PromoStats::whereBetween('created_at', array($monthBefore, $today))->select('device_id')->distinct()->get();

            // for every saved device
            foreach ($get_svd_a_month as $svd_y) {
                $temp_svd_dv_id = $svd_y->device_id;

                // getdifferent coupon ids for this promo and device
                $temp_coup_ids = PromoStats::where(['device_id' => $temp_svd_dv_id])->whereBetween('created_at', array($monthBefore, $today))->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                // get count for each coup
                foreach ($temp_coup_ids as $temp_coups) {
                    // coupon_id
                    $t_coup_id = $temp_coups->coupon_id;

                    // get count for this coupon
                    $temp_cp_count = PromoStats::where(['device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->whereBetween('created_at', array($monthBefore, $today))->count();

                    // get coupon level
                    $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();

                    if(sizeof($get_cp_level) > 0) {
                        $temp_cp_level = $get_cp_level[0]->coupon_level;

                        if($temp_cp_level == 1) {
                            $stat_a_m['cp_1'] += $temp_cp_count;
                        } else if($temp_cp_level == 2) {
                            $stat_a_m['cp_2'] += $temp_cp_count;
                        } else if($temp_cp_level == 3) {
                            $stat_a_m['cp_3'] += $temp_cp_count;
                        } else if($temp_cp_level == 4) {
                            $stat_a_m['cp_4'] += $temp_cp_count;
                        }
                    }
                    
                }
            }

            // get new customers
            $gnc_a_month = PromoStats::whereBetween('created_at', array($monthBefore, $today))
                ->select('device_id')
                ->distinct()->get();

            foreach ($gnc_a_month as $customer_a) {
                // device_id
                $t_d_id = $customer_a->device_id;

                // get all records for this device
                $get_a_all_by_id = PromoStats::where(['device_id' => $t_d_id])->count();


                // get yester day records
                $get_a_month  = PromoStats::where(['device_id' => $t_d_id])->whereBetween('created_at', array($monthBefore, $today))->count();

                if($get_a_all_by_id == $get_a_month) {
                    $stat_a_m['new_c'] += 1;
                }
            }
            // end promo stats last month


            // stats for all time promo
            // get different device id that saved yesterday
            $get_svd_a_all_time = PromoStats::select('device_id')->distinct()->get();

            // for every saved device
            foreach ($get_svd_a_all_time as $svd_y) {
                $temp_svd_dv_id = $svd_y->device_id;

                // get different coupon ids for this promo and device
                $temp_coup_ids = PromoStats::where(['device_id' => $temp_svd_dv_id])->select('coupon_id')->distinct()->orderBy('coupon_id','ASC')->get();

                // get count for each coup
                foreach ($temp_coup_ids as $temp_coups) {
                    // coupon_id
                    $t_coup_id = $temp_coups->coupon_id;

                    // get count for this coupon
                    $temp_cp_count = PromoStats::where(['device_id' => $temp_svd_dv_id, 'coupon_id' => $t_coup_id])->count();

                    // get coupon level
                    $get_cp_level = Coupon::where(['coupon_id' => $t_coup_id])->get();

                    if(sizeof($get_cp_level) > 0) {
                        $temp_cp_level = $get_cp_level[0]->coupon_level;

                        if($temp_cp_level == 1) {
                            $stat_a_a['cp_1'] += $temp_cp_count;
                        } else if($temp_cp_level == 2) {
                            $stat_a_a['cp_2'] += $temp_cp_count;
                        } else if($temp_cp_level == 3) {
                            $stat_a_a['cp_3'] += $temp_cp_count;
                        } else if($temp_cp_level == 4) {
                            $stat_a_a['cp_4'] += $temp_cp_count;
                        }
                    }
                   
                }
            }

            // get new customers
            $gnc_a_customers = PromoStats::select('device_id')->distinct()->get();
            $stat_a_a['new_c'] += sizeof($gnc_a_customers);
            // end promo stats all time


            $all_time_stats[] = [
                'recent_day' => $stat_a_y,
                '7_day' => $stat_a_w,
                '30_day' => $stat_a_m,
                'all' => $stat_a_a
            ];

            $view->all_stats = $all_time_stats;
            $view->retargeted_customers = [];

            $view->t_promo = $get_all_promos;
            $view->active_stores = $active_stores;

        }
        return $view;
    }

    public function quick_store() {


        $view = view('user.quick_coupons');
        $view->title = 'Easy Setup';
        $view->notifications = "hello";
        $view->store_categories = StoreCategory::where("status",'1')->get();
        $view->stores = Store::select("place_id","contact_name as name")->where([["status",'1'],["user_id",Auth::id()]])->get();
        $view->promos = Promo::select("promo_id","promo_name as name")->where([["status",'1'],["user_id",Auth::id()],["used","0"]])->get();
        $view->promoused = Promo::select("promo_id","promo_name as name")->where([["status",'1'],["user_id",Auth::id()],["used","1"]])->get();
        return $view;
    }

    public function quick_store_create(Request $request) {

        $x = new Store();
        $x->contact_name = $request->name;
        // $x->email = $request->email;
        // $x->phone_number = $request->contact;
        $x->street_number = $request->address_number;
        $x->street_address = $request->address;
        $x->city = $request->city;
        $x->postal_code = $request->zip_code;
        $x->state = $request->state;
        $x->country = $request->country;
        $x->under_category = json_encode($request->store_category);
        $x->address = $request->full_address;
        $x->latitude =  $request->ar_model_lat;
        $x->longitude =  $request->ar_model_long;
        $x->status =  '1';
        $x->user_id =  Auth::id();
        if($x->save()){
            session('store_id',$x->id);
            return json_encode(["id"=>$x->id,"msg" => "success"]);
        }else{
            return json_encode(["msg" => "error"]);
        }

    }

    public function quick_store_page() {
        $view = view('user.quickforms.create_store');
        $view->store_categories = StoreCategory::where("status",'1')->get();
        return $view;
    }

    public function quick_promo($store = 0) {
        $view = view('user.quickforms.create_promo');
        $view->title = 'Easy Setup';
        if($store == 0){
            $view->store = 0;
            $view->hassome = 0;
        }else{
            $view->hassome = 1;
            $view->store = Store::where("place_id",$store)->first();
        }
        $view->notifications = "hello";
        $view->promos = Promo::select("promo_id","promo_name as name")->where([["status",'1'],["user_id",Auth::id()],["used","0"]])->get();
        $view->promoused = Promo::select("promo_id","promo_name as name")->where([["status",'1'],["user_id",Auth::id()],["used","1"]])->get();
        return $view;
    }

    public function quick_promo_page($id,$store = 0) {
        $view = view('user.quickforms.create_promo_by_id');
        $view->title = 'Easy Setup';
        $view->notifications = "hello";
        if($store == 0){
            $view->store = 0;
            $view->hassome = 0;
        }else{
            $view->hassome = 1;
            $view->store = Store::where("place_id",$store)->first();
        }
        $view->promo = Promo::where("promo_id",$id)->first();
        $view->promos = Promo::select("promo_id","promo_name as name")->where([["status",'1'],["user_id",Auth::id()],["used","0"]])->get();
        $view->promoused = Promo::select("promo_id","promo_name as name")->where([["status",'1'],["user_id",Auth::id()],["used","1"]])->get();
        return $view;
    }

    public function getallpromos($id) {
        $promos = Promo::where([["user_id",Auth::id()],[""]])->get();
    }

    public function getallaboutstore($param) {
        $store = Store::find($param);
        return json_encode($store);
    }
    public function promoinfo($id){
        $vals = Promo::find($id);
        return json_encode($vals);
    }

    public function quick_promos_create(Request $request){
        //echo "<pre>";
        //print_r($_POST);
        //exit();

        $start_time 			= date("H:i:s", strtotime($request->promo_start));
        $promo_length			= $request->promo_lenght;
        $end_time			= date('H:i:s',strtotime("+$promo_length hour",strtotime($start_time)));
        $advance_warn_hr		= $request->advance_warning;
        $warn_start_time 		= date('H:i:s',strtotime("-$advance_warn_hr hour",strtotime($start_time)));

        $xm = "";
        if($request->repeat_promo == 'Days'){
            $xm = json_encode($request->days);
        }elseif($request->repeat_promo == 'Date'){
            $xm = date("Y-m-d H:i:s", strtotime($request->promo_date));
        }else{
            $xm = '';
        }

        $x = new Promo();

        $x->promo_name = trim($request->promo_name);
        $x->user_id = Auth::id();
        $x->start_at = gmdate("H:i:s", strtotime($start_time));
        $x->end_at = gmdate("H:i:s", strtotime($end_time));
        $x->promo_length = $request->promo_lenght;
        $x->advance_warning = $request->advance_warning;
        $x->main_clue = $request->promo_desc;
        $x->warning_start_time = gmdate("H:i:s", strtotime($warn_start_time));
        $x->promo_repeat = $request->repeat_promo;
        $x->promo_repeat_values = $xm;
        $x->internal_promo  = 1;
        $x->place_id = json_encode($request->store_name);
        $x->add_date = date('Y-m-d h:i:s');
        $x->created_at = date('Y-m-d h:i:s');
        $x->updated_at = date('Y-m-d h:i:s');
        if($x->save()){

            $store_locations = [];
            for($n = 0; $n < count($request->store_name); $n++){
                $stid = (int) $request->get('store_name')[$n];
                if(isset($_POST['store_outside_'.$stid])){
                    $lat = $request->get('store_lat_'.$stid);
                    $lng = $request->get('store_lng_'.$stid);
                    $xxx  = '1';
                }else{
                    $inst = Store::where("place_id",$stid)->first();
                    $lat = $inst->latitude;
                    $lng = $inst->longitude;
                    $xxx  = '0';
                }

                $store_locations[] = [
                    'promo_id' => $x->id,
                    'store_id' => $request->get('store_name')[$n],
                    'lat_code' => $lat,
                    'lng_code' => $lng,
                    'is_outside' => $xxx
                ];
            }

            PromoLocations::insert($store_locations);
            return json_encode(["id"=>$x->id,"msg" => "success"]);
        }else{
            return json_encode(["msg" => "error"]);
        }

        $x = new Promo();
        $x->name = trim(trim($_POST["promo_name"]));
        $x->promo_desc = trim(trim($_POST["promo_desc"]));
        $x->user_id = Auth::id();
        $x->start_at = date("H:i:s", strtotime($_POST["promo_start"]));
        $x->promo_lenght = $_POST["promo_lenght"];
        $x->advance_warning = $_POST["advance_warning"];
        $x->promo_repeat    =  $_POST["repeat_promo"];
        $x->store_id = json_encode(array($_POST["new_store_id"]));
        $x->coupon_code = $_POST["coupon_code"];
        if($_POST["repeat_promo"] == 'Days'){
            $x->promo_repeat_values = json_encode($_POST["days"]);
        }elseif($_POST["repeat_promo"] == 'Date'){
            $x->promo_repeat_values = date("Y-m-d H:i:s", strtotime($_POST["promo_date"]));
        }else{
            $x->promo_repeat_values = '';
        }

        $x->promo_address = trim($_POST["promo_address"]);
        $x->promo_ar_model_lat = trim($_POST["promo_ar_model_lat"]);
        $x->promo_ar_model_long = trim($_POST["promo_ar_model_long"]);
        if($x->save()){
            return json_encode(["id"=>$x->id,"msg" => "success"]);
        }else{
            return json_encode(["msg" => "error"]);
        }
    }

    public function create_promos_now() {
        return redirect('quick_coupons/'.$_POST["used_promo_id"].'/step/1');
    }


    public function select_store_form() {
        $varm = isset($_POST['store_name'])?true:false;
        if($varm == true){

            session(['Selected_stores' => $_POST]);
            return 1;
        }else{
            return 0;
        }
    }

    public function create_coupon_quick($promoid,$step) {
        $view = view('user.quickforms.create_coupons');
        $view->title = "Easy Setup";
        $view->promoid = $promoid;
        $view->step = $step;
        $view->expiery_date = ($step < 4)?"":"Unlimited";
        return $view;
    }

    public function quick_coupon_create(Request $request) {
        $n = 1;
        $x = new Coupon();
        $x->coupon_title     = trim($request->get('coupon_name_'.$n));
        $x->estimated_value = trim($request->get('estimated_value_'.$n));
        $x->coupon_availabilty    = trim($request->get('availablity_'.$n));
        $x->terms_conditions = $request->get('term_condition_'.$n);
        $x->coupon_information = $request->get('dterm_condition_'.$n);

        //$x->start_at = $request->promo_name;
        if($request->get('expiery_date_'.$n) == 'Unlimited' || $request->get('expiery_date_'.$n) == ''){
            $x->expire_date   = '';
        }else{
            $x->expire_date   = date("Y-m-d H:i:s", strtotime($request->get('expiery_date_'.$n)));
        }
        $x->promo_id = $request->get('promo_id');
        $x->user_id  =  Auth::id();

        $time = date('ymdhis').rand(11111,9999999);
        if($request->hasFile('photo_'.$n)) {
            $image = $request->file('photo_'.$n);
            $filename = time() . '.' . $image->getClientOriginalExtension();
            if (!file_exists('resources/assets/coupons/full')) {
                mkdir('resources/assets/coupons/full', 0777, true);
            }
            $path = 'resources/assets/coupons/full/' . $filename;
            /* if(file_exists('resources/assets/' .$x->logofile)){
              unlink('resources/assets/'.$x->logofile);
              } */

            Image::make($image->getRealPath())->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);
            $x->coupon_photo = $filename;
        }

        $x->coupon_model = $request->get('3d_photo_'.$n);

        if(!empty($request->get('hidden-image-data_'.$n))) {
            if (!file_exists('resources/assets/coupons')) {
                mkdir('resources/assets/coupons', 0777, true);
            }
            $destinationPath = 'resources/assets/coupons/';

            $file = str_replace('data:image/png;base64,', '', $request->get('hidden-image-data_'.$n));
            $img = str_replace(' ', '+', $file);
            $data = base64_decode($img);
            $filename = time() . ".png";
            $file = $destinationPath . $filename;
            $success = file_put_contents($file, $data);
            $x->photo = $filename;
        }


        if($x->save()){
            if($request->step == 4){
                Promo::where("promo_id",$request->get('promo_id'))->update(["used"=>"1"]);
            }
            $step = $request->step;
            $nextstep = ($step < 4)?$step+1:"finish";
            $msg = ($step < 4)?"Coupon Saved Successfully":"All Coupons created Successfully";
            return redirect('quick_coupons/'.$request->get('promo_id').'/step/'.$nextstep)->with(['success' => $msg]);
        }else{
            return back()->with(['error' => 'Coupon failed to Create']);
        }
    }

    public function notify($userid) {
        $view = view('admin.users_panel.notify_admin');
        $view->title = 'Notifications';
        $view->notifications = Notifications::where(['user_id' => $userid,'active' => '1'])->paginate(10);
        return $view;
    }

    public function profile() {
        if(Auth::user()->accepted == '0'){
            return redirect('user/accept');
        }
        $view = view('admin.users_panel.profile');
        $view->title = 'Profile';
        $view->heading = 'Update Profile';
        $view->user   = Auth::user();
        return $view;
    }

    public function userProfile(){
        if(Auth::user()->accepted == '0'){
            return redirect('user/accept');
        }
        $view = view('admin.users_panel.profile_user');
        $view->title = 'CouponCam::Profile';
        $view->user   = Auth::user();
        return $view;
    }

    public function userTeam() {
        if(Auth::user()->accepted == '0'){
            return redirect('user/accept');
        }

        $view = view('admin.users_panel.team_user');
        $view->title = 'CouponCam::Team';

        $view->stores = Store::join('store_user', 'store_user.place_id', '=', 'places.place_id')
            ->where(['store_user.user_id' => Auth::id(), 'places.status' => 1])
            ->orderBY('updated_at', 'DESC')
            ->get();

        $view->active_members = UserTable::join('user_team', 'user_team.member_id', '=', 'users.id')
            ->select('users.*')
            ->where(['user_team.team_id' => Auth::id(), 'users.active' => '1'])
            ->get();

        $view->inactive_members = UserTable::join('user_team', 'user_team.member_id', '=', 'users.id')
            ->select('users.*')
            ->where(['user_team.team_id' => Auth::id(), 'users.active' => '0'])
            ->get();

        $view->user   = Auth::user();

        return $view;
    }

    public function create_member(Request $request){


        $memId = UserTable::insertGetId([
            'name' => $request->company_name,
            'first_name' => $request->member_name,
            'email' => $request->email,
            'xpass' => $request->password,
            'password' => bcrypt($request->password),
            'contact' => $request->phone_number,
            'usertype' => '1',
            'accepted' => '1',
            'active' => '1',
            'is_member' => 1,
            'position' => $request->position,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if($memId) {
            // add user to stores
            // get stores
            $stores = json_encode($request->store_ids);

            $remove = array("[","]","\"");
            $stm = trim(str_replace($remove, " ", $stores));

            $store_list = explode(',',$stm);

            for($n = 0; $n < sizeof($store_list); $n++) {
                $inst = StoreUser::insert(['place_id' => $store_list[$n], 'user_id' => $memId]);
            }


            // add user to team
            $instTeam = UserTeam::insert([
                'team_id' => Auth::id(),
                'member_id' => $memId,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return redirect('user/team')->with(['success' => 'Member Created successfully']);

        }
        else {
            return back()->with(['error' => 'Unable to Create member']);
        }
    }

    public function get_active_mems(){
        $active_members = UserTable::join('user_team', 'user_team.member_id', '=', 'users.id')
            ->select('users.*')
            ->where(['user_team.team_id' => Auth::id(), 'users.active' => '1'])
            ->get();

        return $active_members;
    }

    public function get_inactive_mems(){
        $inactive_members = UserTable::join('user_team', 'user_team.member_id', '=', 'users.id')
            ->select('users.*')
            ->where(['user_team.team_id' => Auth::id(), 'users.active' => '0'])
            ->get();

        return $inactive_members;
    }

    public function deactivate_member($user_id) {
        $update = UserTable::where('id', $user_id)
            ->update(['active' => '0', 'updated_at' => date('Y-m-d H:i:s') ]);

        if($update) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function activate_member($user_id) {
        $update = UserTable::where('id', $user_id)
            ->update(['active' => '1', 'updated_at' => date('Y-m-d H:i:s') ]);

        if($update) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function update(Request $request) {
        if(Auth::user()->usertype == 0){
            $x = User::find($request->formid);
        }else{
            $x = User::find(Auth::id());
        }
        $x->name = trim($request->name);
        $x->first_name = trim($request->first_name);
        //  $x->last_name = trim($request->last_name);
        $x->email = $request->email;
        //  $x->address = trim($request->address);
        $x->contact = trim($request->contact_details);
        $x->country = trim($request->country);
        $x->position = trim($request->position);
        if($x->save()){
            if(isset($_POST['userProf'])) {
                return redirect('user/profile')->with(['success' => 'Profile Updated successfully']);
            } else {
                return redirect('profile')->with(['success' => 'Profile Updated successfully']);
            }

        }  else {
            return back()->with(['error' => 'Profile failed to Update']);
        }
    }

    public function setting() {
        if(Auth::user()->accepted == '0'){
            return redirect('user/accept');
        } else{
            return redirect('/dashboard');
        }
        // $view = view('user.dashboard.dashboard_user');
        // $view->title = 'Update your password';
        // $view->heading = 'Change Password';
        // $view->col = 1;
        // $view->user   = Auth::user();
        // return $view;
    }

    public function userSetting() {
        if(Auth::user()->accepted == '0'){
            return redirect('user/accept');
        }
        $view = view('admin.users_panel.setting_user');
        $view->title = 'Update your password';
        $view->heading = 'Change Password';
        $view->col = 1;
        return $view;
    }

    public function settingupdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password_confirmation' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->current_password])) {

            // update user table
            $upd = UserTable::where('id', Auth::id())->update([
                'password' => bcrypt($request->password),
                'xpass' => $request->password
            ]);


            $x = User::find(Auth::id());
            $x->password = bcrypt($request->password);
            $x->xpass   =  $request->password;
            if($x->save()){

                if(isset($_POST['userSett'])) {
                    return redirect('user/profile')->with(['success' => 'Password Updated successfully']);
                }
                else {
                    return redirect('settings')->with(['success' => 'Password Updated successfully']);
                }

            }else{
                return back()->with(['error' => 'Password failed to Update']);
            }
        }else{
            return back()->with(['error' => 'Old Password is wrong']);
        }
    }

    public function deactivate(){
        $x = User::find(Auth::id());
        $x->email = 'deactivate-'.$x->email;
        $x->active = '0';
        $x->save();

        Coupon::where('user_id',Auth::id())->update(['status' => '0']);
        Promo::where('user_id',Auth::id())->update(['status' => '0']);
        Store::where('user_id',Auth::id())->update(['status' => '0']);

        Auth::logout();
        return redirect('/');
    }

    public function retrive_promos(){
        //print_r($_GET['storesids']);
        $promos = PromoLocations::select('promo_locations.promo_id as promo_id','promos.promo_name as promo_name')
            ->join('promos','promo_locations.promo_id', '=', 'promos.promo_id')
            ->whereIn('promo_locations.store_id', $_GET['storesids'])->distinct('promo_locations.promo_id')->get();
        $html = '';
        foreach($promos as $key => $promo){
            $html .= '<option value="'.$promo->promo_id.'">'.$promo->promo_name.'</option>';
        }
        return $html;
    }

    public function select_winner() {

        $return = [];
        $device_ids = [];

        $id_pool = [];

        // get give away store
        $gWPromo = Promo::where(['status' => 3])->get();
        $promo_id = $gWPromo[0]->promo_id;

        // get promo_location
        $promo_loc = PromoLocations::where(['promo_id' => $promo_id])->get();
        $lat = $promo_loc[0]->lat_code;
        $lng = $promo_loc[0]->lng_code;

        // get users
        $users = DeviceInfo::where(['app_version' => 1])->get();

        // for all user
        foreach ($users as $user) {

            // get user lat long
            $t_lat = $user->lat;
            $t_lng = $user->lng;

            // calculate distance
            $dist = (((acos(sin(($lat*pi()/180)) * sin(($t_lat*pi()/180))
                        + cos(($lat*pi()/180)) * cos(($t_lat*pi()/180))
                        * cos((($lng - $t_lng)*pi()/180))))
                    * 180/pi())*60*1.1515*1.609344);

            if($dist <= 0.9) {
                array_push($device_ids,$user->device_id);

                $get_saved = PreLaunch::where(['device_id' => $user->device_id])->get();

                foreach ($get_saved as $saved) {
                    array_push($id_pool,$user->device_id);
                }

            }

        }

        // shuffle array
        shuffle($id_pool);
        $index = array_rand($id_pool,1);
        $winner = $id_pool[$index];

        // insert winner into pre launch winner table
        $add_win = Winner::insert(['device_id' => $winner]);

        return ($winner);

    }

    // /app settings
    public function app_settings() {
        $view = view('admin.users_panel.app_settings');
        $view->title = "App Settings";

        // App settings
        $settings = AppSettings::get();

        $is_pre_launch = 0;
        $saving_limit = 0;
        $app_version = 0;

        foreach ($settings as $key => $setting) {
            if($setting->setting_name == 'pre_launch') {
                if($setting->setting == 1) {
                    $is_pre_launch = 1;
                }
            }

            if($setting->setting_name == 'saving_limit') {
                $saving_limit = $setting->setting;

            }

            if($setting->setting_name == 'app_version') {
                $app_version = $setting->setting;

            }

        }

        // End app settings

        // extend values
        $gb = 0;
        $us = 0;
        $ca = 0;
        $nz = 0;
        $au = 0;

        $get_extend_vals = ExtendValues::get();
        foreach ($get_extend_vals as $value) {
            if($value->country == 'GB'){
                $gb = $value->value;
            }
            else if($value->country == 'CA'){
                $ca = $value->value;
            }
            else if($value->country == 'NZ'){
                $nz = $value->value;
            }
            else if($value->country == 'AU'){
                $au = $value->value;
            }
            else if($value->country == 'US'){
                $us = $value->value;
            }

        }

        $wordings = Wording::get();


        $view->pre_launch = $is_pre_launch;
        $view->saving_limit = $saving_limit;
        $view->app_version = $app_version;
        $view->e_gb = $gb;
        $view->e_us = $us;
        $view->e_ca = $ca;
        $view->e_au = $au;
        $view->e_nz = $nz;
        $view->wordings_list = $wordings;



        return $view;
    }

    public function change_app_settings(Request $request) {
        if(isset($_POST['act_pre'])) {

            $update = AppSettings::where('setting_name','pre_launch')->update([
                'setting' => 1
            ]);

            if($update) {

                $upd = AppSettings::where('setting_name','is_main_ready')->update([
                    'setting' => 0
                ]);

                return redirect('admin/app_settings')->with(['success' => "Pre Launch Activated Successfully!!"]);
            }
            else {
                return back()->with(['error' => 'Unable to activate Pre Launch!!']);
            }


        }

        else {

            // get all users
            $get_users = DeviceInfo::get();

            // player ids
            $player_ids_arr = [];

            foreach ($get_users as $user) {
                // player id
                $t_player = $user->player_id;

                if(strlen($t_player) > 0) {
                    array_push($player_ids_arr, $t_player);
                }
            }

            $get_st = Store::join('promo_locations', 'promo_locations.store_id', '=', 'places.place_id')
                ->join('promos', 'promos.promo_id', '=', 'promo_locations.promo_id')
                ->where(['promos.status' => 3, 'promos.used' => '1'])
                ->get();

            if(sizeof($get_st) > 0 ){

                $st_name = $get_st[0]->contact_name;
                $st_add = $get_st[0]->address;

                $player_ids_str = implode(",", $player_ids_arr);
                $player_ids = explode(',', $player_ids_str);

                $update = AppSettings::where('id',1)->update([
                    'setting' => 0
                ]);
                $upd = AppSettings::where('setting_name','is_main_ready')->update([
                    'setting' => 1
                ]);

                if($update && $upd) {
                    // send a push
                    $notification = "RedFriday Event Is Imminent! Get to " . $st_add . "!";
                    $data = [];
                    $devices = $player_ids;
                    PushNotification::create_notification($notification, $data, $devices);

                    return redirect('admin/app_settings')->with(['success' => "Main Launch Activated Successfully!!"]);
                }
                else {
                    return back()->with(['error' => 'Unable to activate Main Launch!!']);
                }
            } else {
                return back()->with(['error' => 'Please create a give away promo first!!']);
            }


        }

    }

    public function update_extend_values(Request $request) {

        // update values
        $upuk = ExtendValues::where('country', 'GB')->update(['value' => trim($request->val_uk)]);
        $upau = ExtendValues::where('country', 'AU')->update(['value' => trim($request->val_au)]);
        $upus = ExtendValues::where('country', 'US')->update(['value' => trim($request->val_us)]);
        $upca = ExtendValues::where('country', 'CA')->update(['value' => trim($request->val_ca)]);
        $upnz = ExtendValues::where('country', 'NZ')->update(['value' => trim($request->val_nz)]);

        return back()->with(['success' => 'Successfully updated values!!']);
    }

    public function update_save_limit(Request $request) {
        $update = AppSettings::where('setting_name', 'saving_limit')->update(['setting' => trim($request->saving_limit)]);
        if($update) {
            return redirect('admin/app_settings')->with(['success' => "Successfully updated Savings Limit!!"]);
        }
        else {
            return back()->with(['error' => 'Unable to updated Savings Limit!!']);
        }
    }

    public function change_app_version(Request $request){
        $update = AppSettings::where('setting_name', 'app_version')->update(['setting' => trim($request->app_version)]);
        if($update) {
            return back()->with(['success' => "Successfully updated Savings Limit!!"]);
        }
        else {
            return back()->with(['error' => 'Unable to updated Savings Limit!!']);
        }
    }

    public function create_retarget(Request $request) {

        // get store id
        $store_id = $request->store_id;

        // get store details
        $get_store_det = Store::where(['place_id' => $store_id])->select('contact_name')->get();

        // store name
        $store_name = $get_store_det[0]->contact_name;

        // check if there are active coupons
        $get_coupos = RetargetCoupon::where(['place_id' => $store_id, 'status' => 1, 'geo_campaign' => 1])->get();

        if(sizeof($get_coupos) > 0) {
            // get coupon id
            $coupon_id = $get_coupos[0]->coupon_id;

            // if geo stop clicked
            if(isset($_POST['stop_geo'])) {

                // update retarget table
                $update = RetargetCoupon::where(['coupon_id' => $coupon_id])->update([
                    'status' => 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                if($update) {
                    return redirect('dashboard')->with(['success' => "Successfully Stopped Geo Campaign!!"]);
                }
                else {
                    return back()->with(['error' => 'Unable to Stop Geo Campaign!!']);
                }
            }

            if(isset($_POST['send_push'])) {
                // is send push clicked
                // add to retarget stats
                $add_ret_st = RetargetStats::insert([
                    'place_id' => $store_id,
                    'coupon_id' => $coupon_id,
                    'is_push' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                // send a push to users

                // get coupon details
                $get_details = RetargetCoupon::where(['coupon_id' => $coupon_id])->get();
                $t_coup_id = $get_details[0]->coupon_id;

                $push_data = [];

                // get device ids from saved coupons
                $devices = SavedCoupons::where(['place_id' => $store_id])
                    ->select('device_id')
                    ->distinct()
                    ->get();

                // for all device
                foreach ($devices as $device) {

                    // check for saved
                    $saved_c = RetargetSaved::where(['place_id' => $store_id, 'device_id' => $device->device_id, 'coupon_id' => $t_coup_id])->count();


                    if($saved_c == 0) {
                        // user haven't got any coupon
                        // add an entry to retarget saved table
                        $inst_svd = RetargetSaved::insert([
                            'place_id' => $store_id,
                            'coupon_id' => $t_coup_id,
                            'device_id' => $device->device_id,
                            'status' => 5,
                            'is_push' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        if($inst_svd) {
                            // get player id
                            $get_player_id = DeviceInfo::where(['device_id' => $device->device_id])->select('player_id')->get();

                            // player id
                            $t_player_id = $get_player_id[0]->player_id;

                            // send push
                            $notification = "Hey there you have got a coupon from " . $store_name ;
                            $data = $push_data;
                            $devices = [$t_player_id];
                            PushNotification::create_notification($notification, $data, $devices);
                        }
                    }



                }

                return redirect('dashboard')->with(['success' => "Successfully sent a push coupon!!"]);
            }
        }

        else {
            // if there are no active coupons for this store
            // insert a coupon
            // validate images
            $coupon_photo = '';
            if($request->hasFile('coupon_photo')) {

                $random = rand(0,1000000);
                $coup_img = $request->file('coupon_photo');
                $coup_extention = $coup_img->getClientOriginalExtension();

                $coup_img_name = 'c'.date('Ymdhis').$random.".".$coup_extention;

                //Move Uploaded File
                $coup_img_path = 'resources/assets/coupons/full/';
                $coup_img->move($coup_img_path,$coup_img_name);

                $coupon_photo = $coup_img_name;
            }

            $geo_campaign = 0;
            $status = 0;
            if(isset($_POST['start_geo'])) {
                $geo_campaign = 1;
                $status = 1;
            }

            $inst = RetargetCoupon::insertGetId([
                'place_id' => $request->store_id,
                'coupon_name' => $request->coupon_name,
                'estimated_value' => $request->coupon_value,
                'coupon_info' => $request->coupon_info,
                'coupon_details' => $request->coupon_condition,
                'coupon_photo' => $coupon_photo,
                'coupon_ar' => $request->ar_coupon_name,
                'coupon_marker' => $request->ar_marker_name,
                'geo_campaign' => $geo_campaign,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')

            ]);


            // id start geo clicked
            if(isset($_POST['start_geo'])) {
                if($inst){
                    $add_ret_st = RetargetStats::insert([
                        'place_id' => $store_id,
                        'coupon_id' => $inst,
                        'is_push' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    return redirect('dashboard')->with(['success' => "Successfully start Geo Campaign!!"]);
                }
                else {
                    return back()->with(['error' => 'Unable to start Geo Campaign!!']);
                }
            }

            if(isset($_POST['send_push'])) {
                // if send push clicked
                // add to retarget stats
                $add_ret_st = RetargetStats::insert([
                    'place_id' => $store_id,
                    'coupon_id' => $inst,
                    'is_push' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);


                // send a push
                if($inst){
                    // get coupon details
                    $get_details = RetargetCoupon::where(['coupon_id' => $inst])->get();
                    $t_coup_id = $get_details[0]->coupon_id;

                    $push_data = [];

                    // get device ids from saved coupons
                    $devices = SavedCoupons::where(['place_id' => $store_id])
                        ->select('device_id')
                        ->distinct()
                        ->get();

                    // for all device
                    foreach ($devices as $device) {

                        // check for saved
                        $saved_c = RetargetSaved::where(['place_id' => $store_id, 'device_id' => $device->device_id, 'coupon_id' => $inst])->count();


                        if($saved_c == 0) {
                            // add an entry to retarget saved table
                            $inst_svd = RetargetSaved::insert([
                                'place_id' => $store_id,
                                'coupon_id' => $t_coup_id,
                                'device_id' => $device->device_id,
                                'status' => 5,
                                'is_push' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

                            if($inst_svd) {
                                // get player id
                                $get_player_id = DeviceInfo::where(['device_id' => $device->device_id])->select('player_id')->get();

                                // player id
                                $t_player_id = $get_player_id[0]->player_id;

                                // send push
                                $notification = "Hey there you have got a coupon from " . $store_name ;
                                $data = $push_data;
                                $devices = [$t_player_id];
                                PushNotification::create_notification($notification, $data, $devices);
                            }
                        }


                    }


                    return redirect('dashboard')->with(['success' => "Successfully Send a push coupon!!"]);
                }
                else {
                    return back()->with(['error' => 'Unable to a push coupon!!']);
                }
            }


        }




    }

    public function get_retarget($store_id) {
        $return = [];
        $count_last_push_received = 0;
        $count_last_push_used = 0;
        $count_all_push_received = 0;
        $count_all_push_used = 0;
        $count_last_geo_received = 0;
        $count_last_geo_used = 0;
        $count_all_geo_received = 0;
        $count_all_geo_used = 0;

        // get active coupon from retarget table
        $get_coupon = RetargetCoupon::where(['place_id' => $store_id, 'status' => 1, 'geo_campaign' => 1])->get();

        // get retarget stats
        // get last push
        $get_last_push = RetargetStats::where(['place_id' => $store_id, 'is_push' => 1])->orderBy('id', 'DESC')->get()->first();
        $coupon_id = $get_last_push['coupon_id'];
        $created_at = date('Y-m-d H:i:s', strtotime($get_last_push['created_at']));

        // get records from saved
        $get_saved_last = RetargetSaved::where(['place_id' => $store_id, 'is_push' => 1, 'coupon_id' => $coupon_id])->get();


        foreach ($get_saved_last as $last) {
            // updated at
            $t_up_at = date('Y-m-d H:i:s', strtotime($last->updated_at));
            $t_status = $last->status;

            if($created_at <= $t_up_at) {
                $count_last_push_received += 1;

                if($t_status == 2) {
                    $count_last_push_used += 1;
                }
            }
        }

        // get all push stats
        $count_all_push_received = RetargetSaved::where(['place_id' => $store_id, 'is_push' => 1])->count();
        $count_all_push_used = RetargetSaved::where(['place_id' => $store_id, 'is_push' => 1, 'status' => 2])->count();


        // get last geo stats
        // get last push
        $get_last_geo = RetargetStats::where(['place_id' => $store_id, 'is_push' => 0])->orderBy('id', 'DESC')->get()->first();
        $geo_coupon_id = $get_last_geo['coupon_id'];
        $geo_created_at = date('Y-m-d H:i:s', strtotime($get_last_geo['created_at']));

        // get records from saved
        $get_geo_saved_last = RetargetSaved::where(['place_id' => $store_id, 'is_push' => 0, 'coupon_id' => $geo_coupon_id])->get();


        foreach ($get_geo_saved_last as $last) {
            // updated at
            $t_up_at = date('Y-m-d H:i:s', strtotime($last->updated_at));
            $t_status = $last->status;

            if($geo_created_at <= $t_up_at) {
                $count_last_geo_received += 1;

                if($t_status == 2) {
                    $count_last_geo_used += 1;
                }
            }
        }

        // get all geo stats
        $count_all_geo_received = RetargetSaved::where(['place_id' => $store_id, 'is_push' => 0])->count();
        $count_all_geo_used = RetargetSaved::where(['place_id' => $store_id, 'is_push' => 0, 'status' => 2])->count();



        $last_push = ['received' => $count_last_push_received, 'used' => $count_last_push_used ];
        $all_push = ['received' => $count_all_push_received, 'used' => $count_all_push_used ];
        $last_geo = ['received' => $count_last_geo_received, 'used' => $count_last_geo_used ];
        $all_geo = ['received' => $count_all_geo_received, 'used' => $count_all_geo_used ];

        $return = [
            'coupon_data' => $get_coupon,
            'last_push' => $last_push,
            'all_push' => $all_push,
            'last_geo' => $last_geo,
            'all_geo' => $all_geo,
        ];

        return $return;
    }

    public function add_wordings(Request $request) {
        $id = Wording::insert([
            'wording' => trim($request->wording_new),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if($id) {
            return redirect('admin/app_settings')->with(['success' => "Successfully add a wording!!"]);
        } else {
            return back()->with(['error' => 'Unable to add wording!!']);
        }
    }
}
