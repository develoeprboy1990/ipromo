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
use App\Models\Product;
use App\Models\Order;

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
      $CustomerPhone   = $this->addCodeWithNumber($request->input('Phone'));
      $buyer_name      = $request->input('FullName');
      $submeterAddress = $request->input('Address');
      $price           = $request->input('RentalRate');
      $data = array(
         'AgentID'       =>  $request->input('AgentID'),
         'CustomerName'  => $buyer_name,
         'CustomerPhone' => $CustomerPhone,
         'RentalRate'    => $price,
         'Address'       => $submeterAddress
      );
      $rec_id = DB::table('customers')->insertGetId($data);

      return redirect('Promo/' . $CustomerPhone)->with('error', 'User Created Successfully')->with('class', 'success');
   }


   public function Promo($CustomerPhone)
   {
      $pagetitle    = 'View Promo';
      $OfferID      = 0;
      $now          = date('Y-m-d H:i:s');
      $now_datetime = strtotime($now);
      //echo 'Now DateTime:'.date('Y-m-d H:i:s', $now_datetime).'<Br>';

      $customer =  DB::table('customers')->where(['CustomerPhone' => $CustomerPhone])->first();
      $agent =  DB::table('user')->where(['UserID' => $customer->AgentID])->first();
      $userOffer = DB::table('offers')->orderBy('OfferID', 'asc')->get();
      foreach ($userOffer as $offer) {
         $start_datetime = strtotime($customer->CustomerCreated);
         $end_datetime = strtotime("+" . $offer->Days . " day", $start_datetime);

         if ($end_datetime > $now_datetime) {
            // echo 'Offer Start DateTime:' . date('Y-m-d H:i:s', $start_datetime) . '<Br>';
            // echo 'Offer End DateTime:' . date('Y-m-d H:i:s', $end_datetime) . '<br>';
            $OfferID = $offer->OfferID;
            break;
         }
      }

      $currentOffer = DB::table('offers')->where(['OfferID' => $OfferID])->first();

      if ($OfferID > 0) {
         //echo 'Offer ID: ' . $OfferID;
         $addons = Product::get();
         return view('home.promo', compact('pagetitle', 'currentOffer', 'end_datetime', 'agent', 'addons', 'customer'));
      } else {
         return view('home.expire', compact('pagetitle', 'currentOffer', 'end_datetime', 'agent'));
      }
   }

   public function placeOrder(Request $request)
   {
      // $currentOffer = DB::table('offers')->where(['OfferID' => $request->OfferID])->first();
      $customer     =  DB::table('customers')->where(['CustomerID' => $request->CustomerID])->first();
      /* if ($request->id > 0) {
         $addons = Product::whereId($request->id)->get();
      } */
      $order_id = Order::create($request->all());
      $data = array(
         'customer'      => $customer,
         'OfferID'       => $request->OfferID,
         'product_id'    => $request->id,
         'order_id'      => $order_id,
         'totalprice'    => $request->totalprice,
         'subtotalprice' => $request->subtotalprice
      );
      $this->payexapi($data);
   }


   private function payexapi($data = null)
   {
      /* FIRT AUTHENTICATE*/
      $token = $this->get_payex_token();
      /* END AUTHORIZATION*/
      $responseLink = route('response');
      $accept_url   = route('accept');
      $reject_url   = route('reject');
      $customer     = $data['customer'];
      $order        = $data['order_id'];
      $order_id     = $order->id;
      $amount       = $data['totalprice'] * 100;
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
                           "amount": ' . $amount . ',
                           "currency": "MYR", 
                           "customer_name": "' . $customer->CustomerName . '",
                           "email": "advertisement@gfgproperty.com",
                           "contact_number": "' . $customer->CustomerPhone . '",
                           "address": "' . $customer->Address . '",
                           "postcode": "43200",
                           "city": "Bandar Makh",
                           "state": "SGR",
                           "country": "MY", 
                           "description": "Subscribing an offer:' . $data['OfferID'] . '",
                           "reference_number": "' . $order_id . '",  
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
               $status                     = $result->message;
               $order                      = Order::find($order_id);

               $order->description         = $result->request_id;
               $order->payment_status      = $result->status;
               $order->payment_description = $result->result[0]->key;
               $order->payment_message     = $result->message;
               $order->save();
               header("Location: " . $result->result[0]->url);
            } else {
               $status  = $result->message;
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
            $order = Order::find($order_id);
            $order->log_record = $log;
            $order->save();
            return redirect('Promo/')->with('error', 'Successfully')->with('class', 'success');
         }
      } else {
         $data = ['status' => 'Authentication error!', 'url' => $reject_url];
         echo json_encode($data);
         return redirect('Promo/')->with('error', 'Authentication error!')->with('class', 'success')->with('msg', $data);
      }
   }

   public function accept(Request $request)
   {
      $result = $request->all();
      $order = Order::find($result['reference_number']);
      $order->description         = $order->description . ' After Response from payment gateway' . $result['payment_intent'];
      $order->payment_status      = $order->payment_status . ' After Response from payment gateway auth_code=' . $result['auth_code'];
      $order->payment_description = $order->payment_description . ' After Response from payment gateway customer name = ' . $result['customer_name'] . ' , Description= ' . $result['description'];
      $order->payment_message     = $order->payment_message . ' After Response from payment gateway' . $result['response'];
      $log = '<pre>';
      $log .= print_r($result, true);
      $this->createLog('accept', $log, 'ERROR  ');
      $order->log_record = $log;
      $order->save();
      exit;
   }

   public function reject(Request $request)
   {
      $result = $request->all();
      $order = Order::find($result['reference_number']);
      $order->description         = $order->description . ' After Response from payment gateway' . $result['payment_intent'];
      $order->payment_status      = $order->payment_status . ' After Response from payment gateway auth_code=' . $result['auth_code'];
      $order->payment_description = $order->payment_description . ' After Response from payment gateway customer name = ' . $result['customer_name'] . ' , Description= ' . $result['description'];
      $order->payment_message     = $order->payment_message . ' After Response from payment gateway' . $result['response'];
      $log = '<pre>';
      $log .= print_r($result, true);
      $this->createLog('reject', $log, 'ERROR');
      $order->log_record = $log;
      $order->save();
      exit;
   }

   public function response(Request $request)
   {
      $auth_code           = $request->auth_code; //00
      $response            = $request->response; //Approved 
      $reference_number    = $request->reference_number; //ID from table
      $log                 = print_r($_REQUEST, true);
      $this->createLog('response_' . $reference_number, $log, 'Success');

      if ($auth_code == '00' && $response == 'Approved') {
         $collection_id       = $request->collection_id;
         $fpx_buyer_name      = $request->fpx_buyer_name;
         $fpx_buyer_bank_name = !empty($request->fpx_buyer_bank_name) ? $request->fpx_buyer_bank_name : '';
         date_default_timezone_set("Asia/Kuala_Lumpur");
         $fpx_buyer_bank_id   = $request->fpx_buyer_bank_id;
         $description         = $request->description;
         $description        .= ' Bank Name: ' . $fpx_buyer_bank_name . ' *** fpx_buyer_bank_id = ' . $fpx_buyer_bank_id . '***collection id = ' . $collection_id . '*** fpx_buyer_name= ' . $fpx_buyer_name;
         $txn_type            = $request->txn_type;
         $order = Order::find($reference_number);
         $order->payment_message = $order->payment_message . 'Response Message after success response ' . $response;
         $order->save();

         $customer =  DB::table('customers')->where(['CustomerID' => $order->CustomerID])->first();
         $data = ['payment_api_response' => $customer->payment_api_response . ' == ******************* == ' . $log, 'payment_status' => $response];
         return redirect('Promo/' . $customer->CustomerPhone)->with('error', 'User Created Successfully')->with('class', 'success')->with('msg', $response);
      } else {
         $order                  =  Order::find($reference_number);
         $order->payment_message =  $order->payment_message . ' == Response Message when failure records = ' . $response;
         $order->payment_message =  $order->payment_message . $request->description;
         $order->log_record      =  $request->all();
         $order->save();
         $customer               =  DB::table('customers')->where(['CustomerID' => $order->CustomerID])->first();
         return redirect('Promo/' . $customer->CustomerPhone)->with('error', 'Payment Could not completed')->with('class', 'success')->with('msg', $response);
      }
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
      $folder = public_path('logs');
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
} // end of controller