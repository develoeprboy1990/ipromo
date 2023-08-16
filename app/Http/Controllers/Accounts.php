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
use App\Models\Job;
use App\Models\Company;

use Maatwebsite\Excel\Facades\Excel;
 
class Accounts extends Controller
{

    public function __construct()
    {
        if(session::get('UserID')==1)
        {
            echo  "null";
        }
    }
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/

    public function Dashboard()
    {
        session::put('menu','Dashboard');

        $pagetitle='Dashboard';

        return view ('dashboard',compact('pagetitle'));
    }

    public  function Logout()
    {
        Session::flush(); // removes all session data
        return redirect ('/')->with('error', 'Logout Successfully.')->with('class','success');
    }

    public function Login()
    {        return view ('login');
    }
public function UserVerify( request $request)
{
//dd($request->all());
$input = $request->only(['username', 'password']);


$username = $input['username'];
$password =  $input['password'];

$data=DB::table('user')->where('Email', '=', $username )
->where('Password', '=', $password )
->where('Active', '=', 'Yes' )
->where('UserType', '=', 'Admin' )
->get();
$company = Company::get();

if(count($data)>0)
{
Session::put('FullName', $data[0]->FullName);
Session::put('UserID', $data[0]->UserID);
Session::put('Email', $data[0]->Email);
Session::put('UserType', $data[0]->UserType);
Session::put('Currency', $company[0]->Currency);
Session::put('CompanyName', $company[0]->Name . ' '.$company[0]->Name2);
// Session::put('isAdmin', $data[0]->isAdmin);



return redirect('Dashboard')->with('error','Welcome to '. session::get('CompanyName').' Software')->with('class','success');

}

else
{
//session::flash('error', 'Invalid username or Password. Try again');
return redirect ('Login')->withinput($request->all())->with('error', 'Invalid username or Password. Try again')->with('class','danger');
}


// for staff login
}


public function Offers()
     {

 session::put('menu','Offers');     
        $pagetitle = 'User';

           $offers = DB::table('offers')->get();

        
        return  view ('offers',compact('offers','pagetitle'));
     }




    public function Clients()
     {

 session::put('menu','Clients');     
        $pagetitle = 'Clients';

           $clients = DB::table('customers')
           ->join('user', 'user.UserID', '=', 'customers.AgentID')
           ->get();

        
        return  view ('clients',compact('clients','pagetitle'));
     }


     public function CustomerDelete($id)
     {  

            $id = DB::table('customers')->where('CustomerID',$id)->delete();
            return redirect('Clients')->with('error','Customer Deleted Successfully')->with('class','success');

     }








} // end of controller