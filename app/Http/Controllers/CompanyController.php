<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class CompanyController extends Controller
{
    public  function Company()
    {
        $pagetitle = 'Company';

        $company = Company::get();
        //   dd($company);
        return view('company', compact('company'));
    }
    public  function SaveCompany(request $request)
    {
        // dd($request);
$pagetitle = 'Company';
        $this->validate(
            $request,
            [

                'Name' => 'required',
                // 'Logo' => 'required|mimes:jpeg,png,jpg,gif,doc,docx,bmp,pdf|max:20000'


            ]
        );

        $logo = $request->file('Logo');
        $signature = $request->file('Signature');

        // dd($logo);

        $input['logo'] = time() . '.' . $logo->extension();
        $input['signature'] = time() . '.' . $signature->extension();

        $destinationPath = public_path('/documents');


        $logo->move($destinationPath, $input['logo']);
        $signature->move($destinationPath, $input['signature']);





        $data = array(

            'Name' => $request->input('Name'),
            'Name2' => $request->input('Name2'),
            'TRN' => $request->input('TRN'),
            'Email' => $request->input('Email'),
            'Mobile' => $request->input('Mobile'),
            'Contact' => $request->input('Contact'),
            'Address' => $request->input('Address'),
            'Website' => $request->input('Website'),
            'Logo' => $input['logo'],
            'BackgroundLogo' => $input['BackgroundLogo'],
            'Signature' => $input['signature'],
            'DigitalSignature' => $request->input('DigitalSignature'),
            'EstimateInvoiceTitle' => $request->input('EstimateInvoiceTitle'),
            'SaleInvoiceTitle' => $request->input('SaleInvoiceTitle'),
            'DeliveryChallanTitle' => $request->input('DeliveryChallanTitle'),
            'CreditNoteTitle' => $request->input('CreditNoteTitle'),
            'PurchaseInvoiceTitle' => $request->input('PurchaseInvoiceTitle'),
            'DebitNoteTitle' => $request->input('DebitNoteTitle'),



        );

        $id = Company::create($data);

 
        return redirect('Company' )->with('error', 'Save Successfully.')->with('class', 'success');
    }
    public  function CompanyEdit($id)
    {


        session::put('menu', 'Company');
        $pagetitle = 'Company';

        $company = Company::where('CompanyID', $id)->get();
        // dd($company);
        return view('company_edit', compact('pagetitle', 'company'));
    }
    public  function CompanyUpdate(request $request)
    {
        $data = array(

            'Name' => $request->Name,
            'Name2' => $request->Name2,
            'TRN' => $request->TRN,
            'Email' => $request->Email,
            'Mobile' => $request->Mobile,
            'Contact' => $request->Contact,
            'Address' => $request->Address,
            'Website' => $request->Website,
           
            'DigitalSignature' => $request->input('DigitalSignature'),
            'EstimateInvoiceTitle' => $request->input('EstimateInvoiceTitle'),
            'SaleInvoiceTitle' => $request->input('SaleInvoiceTitle'),
            'DeliveryChallanTitle' => $request->input('DeliveryChallanTitle'),
            'CreditNoteTitle' => $request->input('CreditNoteTitle'),
            'PurchaseInvoiceTitle' => $request->input('PurchaseInvoiceTitle'),
            'DebitNoteTitle' => $request->input('DebitNoteTitle'),
 
        );
        $destinationPath = public_path('/documents');

         if ($request->hasFile('Logo')) {

            $logo = $request->file('Logo');
            $fileName = time().'.'.$logo->extension();
            $data = array_add($data, 'Logo',  $fileName);
            $logo->move($destinationPath,  $fileName);
        }

         if ($request->hasFile('BackgroundLogo')) {

            $BackgroundLogo = $request->file('BackgroundLogo');
            $fileName = time().'.'.$BackgroundLogo->extension();
            $data = array_add($data, 'BackgroundLogo',  $fileName);
            $BackgroundLogo->move($destinationPath,  $fileName);
        }
        if ($request->hasFile('Signature')) {
            $signature = $request->file('Signature');
            $fileName2 = time().'.'.$signature->extension();
            $data = array_add($data, 'Signature', $fileName2);

            $signature->move($destinationPath, $fileName2);
        }
       

        $id = Company::where('CompanyID', $request->input('CompanyID'))->update($data);
        $pagetitle = 'Company';

        $company = Company::get();
        return redirect('Company')->with('error', 'Save Successfully.')->with('class', 'success');
    }
    public  function CompanyDelete($id)
    {
        $pagetitle = 'Company';

        $company = Company::get();

        $id = Company::where('CompanyID', $id)->delete();
        return redirect('Company')->with('error', 'Deleted Successfully.')->with('class', 'success');
    }
}
