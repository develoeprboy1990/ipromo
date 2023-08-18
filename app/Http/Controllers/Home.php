<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
// for API data receiving from http source
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
// use Datatables;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
// for excel export
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
// end for excel export

use Session;
use DB;
use URL;
use Image;
use File;
use PDF;
use App\Models\Company;

use Maatwebsite\Excel\Facades\Excel;

class Home extends Controller
{

   public function __construct()
   {
      opcache_reset(); 
   }


   public function Show()
   {

      $pagetitle = 'User';
      $agents = DB::table('user')->where(['UserType' => 'Agent'])->get();
      $agent_requested = '';
      return  view('home.home', compact('pagetitle', 'agents', 'agent_requested'));
   }

   public function ShowAgent($Agent)
   {

      $pagetitle = 'User';
      $agents = DB::table('user')->where(['UserType' => 'Agent', 'FullName' => $Agent])->get();
      $agent_requested = $Agent;
      return  view('home.home', compact('pagetitle', 'agents', 'agent_requested'));
   }



   public function UserAdd(request $request)
   {
      $CustomerPhone = $this->addCodeWithNumber($request->input('Phone'));
      $data = array(
         'AgentID' =>  $request->input('AgentID'),
         'CustomerName' => $request->input('FullName'),
         'CustomerPhone' => $CustomerPhone
      );

      $id = DB::table('customers')->insertGetId($data);

      return redirect('Promo/' . $CustomerPhone)->with('error', 'User Created Successfully')->with('class', 'success');
   }

   private function addCodeWithNumber($number)
   {
      if (preg_match('/^\+601\d{9}/', $number))
         $phone = $number;
      elseif (preg_match('/^601\d{9}/', $number))
         $phone = '+' . $number;
      elseif (preg_match('/^01\d{9}/', $number))
         $phone = '+6' . $number;
      else
         $phone = $number;

      return $phone;
   }

   public function Promo($CustomerPhone)
   {
      $pagetitle = 'View Promo';

      $OfferID = 0;
      $now = date('Y-m-d H:i:s');
      $now_datetime = strtotime($now);
      //echo 'Now DateTime:'.date('Y-m-d H:i:s', $now_datetime).'<Br>';


      $customer =  DB::table('customers')->where(['CustomerPhone' => $CustomerPhone])->first();
      $agent =  DB::table('user')->where(['UserID' => $customer->AgentID])->first();
      $userOffer = DB::table('offers')->orderBy('OfferID', 'asc')->get();
      foreach ($userOffer as $offer) {
         $start_datetime = strtotime($customer->CustomerCreated);
         $end_datetime = strtotime("+" . $offer->Days . " day", $start_datetime);


         if ($end_datetime > $now_datetime) {
            echo 'Offer Start DateTime:' . date('Y-m-d H:i:s', $start_datetime) . '<Br>';
            echo 'Offer End DateTime:' . date('Y-m-d H:i:s', $end_datetime) . '<br>';
            $OfferID = $offer->OfferID;
            break;
         }
      }

      $currentOffer = DB::table('offers')->where(['OfferID' => $OfferID])->first();
      if ($OfferID > 0) {
         echo 'Offer ID: ' . $OfferID;
         return view('home.promo', compact('pagetitle', 'currentOffer', 'end_datetime', 'agent'));
      } else {
         return view('home.expire', compact('pagetitle', 'currentOffer', 'end_datetime', 'agent'));
      }
   }



   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
} // end of controller