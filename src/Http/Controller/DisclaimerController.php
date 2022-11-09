<?php

namespace Xoxoday\Disclaimer\Http\Controller;

use Illuminate\Routing\Controller;
use Config;
use  Xoxoday\Disclaimer\Models\Xocode;
use  Xoxoday\Disclaimer\Models\XocodeAttempt;
use Xoxoday\Disclaimer\Models\User;
use Xoxoday\Disclaimer\Http\Requests\XouserRequest;
use Session;

class DisclaimerController extends Controller
{
    /*
     * Function to show the login page
     */
    public function showDisclaimerPage()
    {   

      $terms_url = Config('xoform.xoxoday_disclaimer_terms_condition_url');
      return view('xoform::xodisclaimer',compact(['terms_url']));

    }

    public function showFormPage(){
        $terms_url = Config('xoform.xoxoday_disclaimer_terms_condition_url');
        return view('xoform::xoform',compact(['terms_url']));
    }


    /*
     * Function to handle form data for POST request
     */
    public function postFormData(XouserRequest $request)
    {
        $ouput = $request->validated();

        $one_hour_ago_dateTime = $date = date('Y-m-d H:i:s', strtotime('-1 hour'));

        try {
            $count = XocodeAttempt::where('ip', $request->ip())->where('date_time', ">", $one_hour_ago_dateTime)->count(); //fetching number of attempts made by the customer IP
        } catch (QueryException $ex) {
          return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
        }

        /*
         * checking if user has already made 5 attempts in last one hour.
         */
        if ($count == Config('xoform.attempt_limit')) {
            return \Redirect::back()->withErrors(['errors' => ['You have entered an invalid code. Please try again']])->withInput();
        } else {

            $params = $request->post(); // storing all the form post data ia a variable

            $code = strtoupper($params['code']); //converting code in the POST request to upper case as all the code store in db are in upper case.

            try {
                $code_exist = Xocode::where('code', $code)->where('used', '!=', 'Yes')->first(); //fetching the code details from db.
            } catch (QueryException $ex) {
              return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
            }

            /*
             * checking if not used code exist.
             */
            if ($code_exist) {

                /*
                 * checking if user exist or not and updating/creating user on the basis of this.
                 */
                try {
                    $user_exist = User::where('mobile', $params['mobile'])->first();
                } catch (QueryException $ex) {
                    return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                }

                if ($user_exist) {
                    try {
                        $user_result = User::where('mobile', $params['mobile'])->update(['email' => $params['email'], 'name' => $params['name']]);
                    } catch (QueryException $ex) {
                        return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                    }
                } else {
                    try {
                        $user_result = User::create([
                            'name' => $params['name'],
                            'email' => $params['email'],
                            'password' => bcrypt(Config('xoform.default_otp')),
                            'mobile' => $params['mobile'],
                            'city' => $params['city'],
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                        
                    } catch (QueryException $ex) {
                        return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                    }
                }

                /*
                 * Removing all the entries of the user attempt made by user and updating the code status to In-Queue
                 */

                if ($user_result) {

                    try {
                        $user = User::where('mobile', $params['mobile'])->first();
                    } catch (QueryException $ex) {
                        return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                    }

                    try {
                        $deleting_attempts = XocodeAttempt::where('ip', $request->ip())->delete(); //fetching the code details from db.
                    } catch (QueryException $ex) {
                        return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                    }

                    if ($code_exist['used'] == 'In-Queue') {
                        $code_status_update = 1;
                    } else {
                        try {
                            $code_status_update = Xocode::where('code', $code)->update(['used' => 'In-Queue']); //fetching the code details from db.
                        } catch (QueryException $ex) {
                            return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                        }
                    }

                }else{
                    return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                }

                if ($code_status_update) {
                    Session::put('form', '1');
                    Session::put('user_data', json_encode($params));
                    return \Redirect::route(Config('xoform.xoxoday_form_redirect_route'));
                } else {
                    return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                }

            } else {

                try {
                    $count = XocodeAttempt::where('ip', $request->ip())->count(); //fetching number of attempts made by the customer IP
                } catch (QueryException $ex) {
                  return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                }

                /*
                 * checking if user made more than 5 attempts in last one hour.If yes then invalid code error will be show and first entry of the user attempt will be , if not then an entry will be created for the same and invalid message will be show.
                 */
                if ($count < 5) {
                    try {
                        $attempt_created = XocodeAttempt::create([
                            'name' => $params['name'],
                            'email' => $params['email'],
                            'mobile' => $params['mobile'],
                            'code' => $code,
                            'ip' => $request->ip(),
                            'date_time' => date('Y-m-d H:i:s'),
                        ]);
                    } catch (QueryException $ex) {
                      return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                    }
                    return \Redirect::back()->withErrors(['errors' => ['You have entered an invalid code. Please try again']])->withInput();

                } else {

                    try {
                        $deleting_attempts = XocodeAttempt::where('ip', $request->ip())->orderBy('id', "asc")->first()->delete(); //fetching the code details from db.
                    } catch (QueryException $ex) {
                       
                        return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                    }

                    try {
                        $attempt_created = XocodeAttempt::create([
                            'name' => $params['name'],
                            'email' => $params['email'],
                            'mobile' => $params['mobile'],
                            'code' => $code,
                            'ip' => $request->ip(),
                            'date_time' => date('Y-m-d H:i:s'),
                        ]);
                    } catch (QueryException $ex) {
                      return \Redirect::back()->withErrors(['errors' => ['Request failed. Please try again']])->withInput();
                    }

                    return \Redirect::back()->withErrors(['errors' => ['You have entered an invalid code. Please try again']])->withInput();
                }

            }
        }

    }

}
