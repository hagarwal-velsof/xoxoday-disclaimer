<?php

namespace Xoxoday\Disclaimer\Http\Controller;

use Illuminate\Routing\Controller;
use Config;

class DisclaimerController extends Controller
{
    /*
     * Function to show the login page
     */
    public function index()
    {   

    $terms_url = Config('disclaimer.xoxoday_disclaimer_terms_condition_url');
    $redirect_url = Config('disclaimer.xoxoday_disclaimer_redirect_url');
      return view('disclaimer::disclaimer',compact(['terms_url','redirect_url']));
    }

}
