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
      // opcache_reset(); 
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
         'CustomerPhone' => $CustomerPhone,
         'RentalRate' => $request->input('RentalRate'),
         'Address' => $request->input('Address')
      );
      /* FIRT AUTHENTICATE*/
      $token = $this->get_payex_token();
      /* END AUTHORIZATION*/
      $responseLink = SITE_ADDR . Router::$page_name . '/response';
      $accept_url   = SITE_ADDR . Router::$page_name . '/accept';
      $reject_url   = SITE_ADDR . Router::$page_name . '/reject';
      if ($token) {
         try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
               CURLOPT_URL => 'https://api.payex.io/api/v1/PaymentIntents',
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => '',
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 0,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => 'POST',
               CURLOPT_POSTFIELDS => '[
						{
							"amount": ' . $price . ',
							"currency": "MYR", 
							"customer_name": "' . $buyer_name . '",
							"email": "advertisement@gfgproperty.com",
							"contact_number": "' . $phonenumber . '",
							"address": "' . $submeterAddress . '",
							"postcode": "43200",
							"city": "Bandar Makh",
							"state": "SGR",
							"country": "MY", 
							"description": "Payment For Room:' . $roomtype . ' | ' . $metercode . '",
							"reference_number": "' . $rec_id . '",  
							"return_url": "' . $responseLink . '",
							"callback_url": "' . $responseLink . '",
							"accept_url": "' . $accept_url . '",
							"reject_url": "' . $reject_url . '"
						}
						]',
               CURLOPT_HTTPHEADER => array(
                  'Authorization: Bearer ' . $token . '',
                  'Content-Type: application/json',
                  'Cookie: ARRAffinity=d30cc046ce27286e641d8e18d378ae394091489768cf8cf9b268164b427296dd; ARRAffinitySameSite=d30cc046ce27286e641d8e18d378ae394091489768cf8cf9b268164b427296dd'
               ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($response);
            $status = $result->result[0]->error;
            if ($result->status == '00') {
               $status  = $result->message;
            } else {
               $db->rawQuery("UPDATE token SET purchase_id='0' WHERE id ='$id' ");
            }
            $data = [
               'status' => $status,
               'url' => $result->result[0]->url
            ];
            echo json_encode($data);
            exit;
         } catch (Exception $e) {
            $log = "";
            $log .= "Caught exception: " . $e->getMessage() . PHP_EOL;
            $this->createLog('API', $log, 'ERROR');
         }
      } else {
         $data = ['status' => 'Authentication error!', 'url' => $responseLink];
         echo json_encode($data);
      }

      $id = DB::table('customers')->insertGetId($data);
      return redirect('Promo/' . $CustomerPhone)->with('error', 'User Created Successfully')->with('class', 'success');
   }



   public function accept(Request $request)
   {
      $log = '<pre>';
      $log .= print_r($request->all(), true);
      $this->createLog('accept', $log, 'ERROR  ');
      return $this->render_view("purchase2/accept.php", $_REQUEST);
   }

   public function reject(Request $request)
   {
      $log = '<pre>';
      $log .= print_r($request->all(), true);
      $this->createLog('reject', $log, 'ERROR');
   }

   public function response()
   {
   }

   /**
    * Get Payex Token
    *
    * @param   string $url  Payex API Url.
    * @return bool|mixed
    */
   private function get_payex_token()
   {
      $auth = base64_encode("account@gfgproperty.com:mCUTyTmL7nWyIFD4SkPBjbrm7OAGyg8Q");
      try {
         $curl = curl_init();
         curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.payex.io/api/Auth/Token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
               'Authorization: Basic ' . $auth . '',
               'Cookie: ARRAffinity=d30cc046ce27286e641d8e18d378ae394091489768cf8cf9b268164b427296dd; ARRAffinitySameSite=d30cc046ce27286e641d8e18d378ae394091489768cf8cf9b268164b427296dd'
            ),
         ));
         $response = curl_exec($curl);
         curl_close($curl);
         $result =  json_decode($response);
         $token  = $result->token;
      } catch (Exception $e) {
         $log = "";
         $log .= "Caught exception: " . $e->getMessage() . PHP_EOL;
         $this->createLog('API', $log, 'ERROR');
         $token  = false;
      }
      return $token;
   }


   /**
    * Logging method.
    *
    * @param string $file name of log.
    * @param string $logdata content to log.
    * @param string $type LogLevel.
    *
    * @return void
    */
   public function createLog($file, $logdata, $type)
   {
      $folder = __DIR__ . '/../../logs';
      $filepath = $folder . '/' . $file . '_' . date("Ymd") . '.txt';
      if (is_dir($folder) == false) {
         mkdir($folder, 0777);
      }

      if (is_file($filepath) == false) {
         $newlog = date("Y-m-d h:i:s") . PHP_EOL;
      } else {
         $newlog = PHP_EOL . date("Y-m-d h:i:s") . PHP_EOL;
      }

      $newlog .= "LogLevel: " . $type . PHP_EOL;
      $newlog .= $logdata;
      $newlog .= "-------------------------";

      try {
         file_put_contents($filepath, $newlog, FILE_APPEND);
      } catch (Exception $e) {
         echo 'Caught exception: ',  $e->getMessage(), "\n";
      }
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