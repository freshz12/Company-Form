<?php

namespace App\Http\Controllers;

use App\Models\CareSegment;
use App\Models\CompanyProfile;
use App\Models\CountryInterest;
use App\Models\OtherDocument;
use App\Models\PotentialIds;
use App\Models\PotentialRelation;
use App\Models\Presence;
use App\Models\ProductBrochure;
use App\Models\TypeProducts;
use Exception;
use App\Models\Form;
use App\Mail\SendEmail;
use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Mail\SubmissionEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;


class FormController extends Controller
{
    public function index()
    {
        try {
            // $form = Form::paginate(999999999999999999);

            $form = DB::table('Form as F')
                ->select('F.*', DB::raw('
        (SELECT STUFF((SELECT \', \' + B.description
                       FROM type_of_products A
                       JOIN parameter B ON A.type_of_products_id = B.id
                       WHERE A.form_id = F.form_id
                       FOR XML PATH(\'\')), 1, 2, \'\')) AS type_of_products,
        (SELECT STUFF((SELECT \', \' + B.description
                       FROM presence_of_distributor A
                       JOIN parameter B ON A.presence_of_distributor_id = B.id
                       WHERE A.form_id = F.form_id
                       FOR XML PATH(\'\')), 1, 2, \'\')) AS presence_of_distributor,
        (SELECT STUFF((SELECT \', \' + B.description
                       FROM country_of_interest_for_distribution A
                       JOIN parameter B ON A.country_of_interest_for_distribution_id = B.id
                       WHERE A.form_id = F.form_id
                       FOR XML PATH(\'\')), 1, 2, \'\')) AS country_of_interest_for_distribution,
        (SELECT STUFF((SELECT \', \' + B.description
                       FROM care_segment A
                       JOIN parameter B ON A.care_segment_id = B.id
                       WHERE A.form_id = F.form_id
                       FOR XML PATH(\'\')), 1, 2, \'\')) AS care_segment,
        (SELECT STUFF((SELECT \', \' + B.description
                       FROM potential_service_offered_by_ids A
                       JOIN parameter B ON A.potential_service_offered_by_ids_id = B.id
                       WHERE A.form_id = F.form_id
                       FOR XML PATH(\'\')), 1, 2, \'\')) AS potential_service_offered_by_ids,
        (SELECT STUFF((SELECT \', \' + B.description
                       FROM potential_relationship A
                       JOIN parameter B ON A.potential_relationship_id = B.id
                       WHERE A.form_id = F.form_id
                       FOR XML PATH(\'\')), 1, 2, \'\')) AS potential_relationship
    '))
                ->paginate(999999999999999999);



            return view('index', compact('form'));

        } catch (Exception $e) {
            return redirect('/error');
        }
    }

    public function form()
    {
        try {
            $allcompafile = CompanyProfile::pluck('company_profile');
            $allprodfile = ProductBrochure::pluck('product_brochure');
            $allotherfile = OtherDocument::pluck('other_relevant_file');


            $product_type = Parameter::where('category', 'Type of Products')->get();
            $care_segment = Parameter::where('category', 'Care Segment')->get();
            $presence = Parameter::where('category', 'Presence of distributor')->get();
            $potential_relationship = Parameter::where('category', 'Potential Relationship')->get();
            $potential_service = Parameter::where('category', 'Potential Service offered by')->get();
            $country = Parameter::where('category', 'Country')->pluck('description');


            return view('form', compact('allcompafile', 'allprodfile', 'allotherfile', 'product_type', 'care_segment', 'presence', 'potential_relationship', 'potential_service', 'country'));

        } catch (Exception $e) {
            return redirect('/home')->with('status-mer', 'Something went wrong, if the issue persists contact administrator');
        }
    }

    public function store(Request $request)
    {
        // return count($request->file('other_documents'));

        try {
            DB::beginTransaction();

            $formData = [
                'company_name' => $request->company_name,
                'company_hq_office_address' => $request->hq,
                'company_website' => $request->company_website,
                'company_country_of_origin' => $request->Country_of_origin,
                'year_of_establishment' => $request->year,
                'contact_name' => $request->contact_name,
                'contact_designation' => $request->contact_designation,
                'contact_email_address' => $request->contact_email,
                'contact_phone_number' => $request->contact_phone,
                // 'type_of_products' => implode(',', $request->type_products),
                // 'care_segment' => implode(',', $request->care),
                'main_products' => $request->main_products,
                // 'presence_of_distributor' => implode(',', $request->presence),
                // 'country_of_interest_for_distribution' => implode(',', $request->country_interest),
                'updated_by' => '',
            ];
            Form::create($formData);

            $formid = Form::select('form_id')
                ->where('company_name', $request->company_name)
                ->where('company_hq_office_address', $request->hq)
                ->where('company_website', $request->company_website)
                ->where('company_country_of_origin', $request->Country_of_origin)
                ->where('year_of_establishment', $request->year)
                ->where('contact_designation', $request->contact_designation)
                ->where('contact_email_address', $request->contact_email)
                ->where('contact_phone_number', $request->contact_phone)
                // ->where('type_of_products', implode(',', $request->type_products))
                // ->where('care_segment', implode(',', $request->care))
                ->where('main_products', $request->main_products)
                // ->where('presence_of_distributor', implode(',', $request->presence))
                // ->where('country_of_interest_for_distribution', implode(',', $request->country_interest))
                ->where('updated_by', '')->first();

            foreach ($request->type_products as $type_products) {
                $ty_pro = [
                    'form_id' => $formid->form_id,
                    'type_of_products_id' => $type_products,
                    'updated_by' => '',
                ];
                TypeProducts::create($ty_pro);
            }

            foreach ($request->care as $care) {
                $care_seg = [
                    'form_id' => $formid->form_id,
                    'care_segment_id' => $care,
                    'updated_by' => '',
                ];
                CareSegment::create($care_seg);
            }

            foreach ($request->presence as $presence) {
                $pres = [
                    'form_id' => $formid->form_id,
                    'presence_of_distributor_id' => $presence,
                    'updated_by' => '',
                ];
                Presence::create($pres);
            }

            foreach ($request->country_interest as $country_interest) {
                $cou_int = [
                    'form_id' => $formid->form_id,
                    'country_of_interest_for_distribution_id' => $country_interest,
                    'updated_by' => '',
                ];
                CountryInterest::create($cou_int);
            }


            $companyProfileFiles = $request->file('company_profile');
            $productBrochureFiles = $request->file('product_brochure');
            if ($request->other_documents) {
                $otherDocumentsFiles = $request->file('other_documents');
            } else {
                $OtherDocumentsName = null;
            }

            $otherDocumentsFiles = $request->file('other_documents');
            $filecount = max(count($companyProfileFiles), count($productBrochureFiles), count($companyProfileFiles));


            for ($key = 0; $key < $filecount; $key++) {


                if (array_key_exists($key, $companyProfileFiles) && $companyProfileFiles[$key] !== null) {
                    $CompanyProfileName = $companyProfileFiles[$key]->getClientOriginalName();
                    $companyProfileFiles[$key]->storeAs('uploads/company_profile', $CompanyProfileName, 'public');

                    $files1 = [
                        'form_id' => $formid->form_id,
                        'company_profile' => $CompanyProfileName,
                        'updated_by' => '',
                    ];
                    CompanyProfile::create($files1);
                }

                if (array_key_exists($key, $productBrochureFiles) && $productBrochureFiles[$key] !== null) {
                    $ProductBrochureName = $productBrochureFiles[$key]->getClientOriginalName();
                    $productBrochureFiles[$key]->storeAs('uploads/product_brochure', $ProductBrochureName, 'public');

                    $files2 = [
                        'form_id' => $formid->form_id,
                        'product_brochure' => $ProductBrochureName,
                        'updated_by' => '',
                    ];
                    ProductBrochure::create($files2);
                }

                if ($request->other_documents) {
                    if (array_key_exists($key, $otherDocumentsFiles) && $otherDocumentsFiles[$key] !== null) {
                        $OtherDocumentsName = $otherDocumentsFiles[$key]->getClientOriginalName();
                        $otherDocumentsFiles[$key]->storeAs('uploads/other_documents', $OtherDocumentsName, 'public');

                        if ($OtherDocumentsName !== null) {
                            $files3 = [
                                'form_id' => $formid->form_id,
                                'other_relevant_file' => $OtherDocumentsName ?? null,
                                'updated_by' => '',
                            ];
                            OtherDocument::create($files3);
                        }
                    }
                }

            }

            if ($files1 && $files2) {

                $comfile = $request->file('company_profile');
                $orcompa = [];
                foreach ($comfile as $file) {
                    $orcompa[] = $file->getClientOriginalName();
                }
                $compafl = implode(', ', $orcompa);

                $brofile = $request->file('product_brochure');
                $orbro = [];
                foreach ($brofile as $file) {
                    $orbro[] = $file->getClientOriginalName();
                }
                $brofl = implode(', ', $orbro);

                if ($request->other_documents) {
                    $otfile = $request->file('other_documents');
                    $orot = [];
                    foreach ($otfile as $file) {
                        $orot[] = $file->getClientOriginalName();
                    }
                    $otfl = implode(', ', $orot);
                } else {
                    $otfl = "-";
                }

                $recepient = DB::table('email_recepient')
                    ->select('email_address', 'name')
                    ->where(function ($query) {
                        $query->where('deleted_at', '')
                            ->orWhereNull('deleted_at');
                    })
                    ->where(function ($query) {
                        $query->where('deleted_by', '')
                            ->orWhereNull('deleted_by');
                    })
                    ->get();

                $subject = 'Company';

                $receiversEmail = $request->contact_email;

                $typro = implode(',', $request->type_products);
                $recare = implode(',', $request->care);
                $repres = implode(',', $request->presence);
                $reint = implode(',', $request->country_interest);

                $content = "<p>
                <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Dear $request->contact_name,</font>
            </p>
            <p>
                <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Your submission is already submitted successfully,</font>
            </p>
            <p>
                <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Please find the details below:</font>
            </p>
            <table style='width: 750px' border='1' cellpadding='0' cellspacing='0'>
                <tbody>
                    <tr>
                        <td colspan='4' class='withoutLabel'></td>
                    </tr>
                    <tr>
                        <td align='' style='background-color: #4092e5; color: black; font-weight: bold' colspan='4'>
                            <font size='2'><span style='float: left'>Company</span></font>
                        </td>
                    </tr>
                    <tr>
                        <td align='' style='background-color: #8cbdee; color: black' colspan='4'>
                            <font size='2'><span style='float: left'>Company Details </span></font>
                        </td>
                    </tr>
                    <tr>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Company Name</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->company_name</font>
                        </td>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>HQ Office Address</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->hq</font>
                        </td>
                    </tr>
                    <tr>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Company Website</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->company_website</font>
                        </td>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Country of origin</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->Country_of_origin</font>
                        </td>
                    </tr>
                    <tr>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Year of establishment</font>
                        </td>
                        <td colspan='3' style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                        <font size='2'>$request->year</font>
                        </td>
                    </tr>
                    <tr>
                        <td align='' style='background-color: #8cbdee; color: black' colspan='4' id='form[subReq2]'>
                            <font size='2'><span style='float: left'>Contact Person
                                </span></font>
                        </td>
                    </tr>
                    <tr>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Name</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->contact_name</font>
                        </td>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'> Designation</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->contact_designation</font>
                        </td>
                    </tr>
                    <tr>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Email Address</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->contact_email</font>
                        </td>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Phone Number</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->contact_phone</font>
                        </td>
                    </tr>
                    <td align='' style='background-color: #8cbdee; color: black' colspan='4' id='form[subReq3]'>
                        <font size='2'><span style='float: left'>Products Offering
                            </span></font>
                    </td>
                    <tr>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Products Offering
                            </font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$typro</font>
                        </td>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Care Segment</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$recare</font>
                        </td>
                    </tr>
                    <tr>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Main Products
                            </font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->main_products</font>
                        </td>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Presence of distributor</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$repres</font>
                        </td>
                    </tr>
                    <tr>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Country of interest for distribution</font>
                        </td>
                        <td colspan='3' style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                       <font size='2'>$reint</font>
                        </td>
                    </tr>

                    <td align='' style='background-color: #8cbdee; color: black' colspan='4' id='form[subReq3]'>
                        <font size='2'><span style='float: left'>Documents Files
                            </span></font>
                    </td>
                    <tr>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Company Profile
                            </font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$compafl</font>
                        </td>
                        <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                            <font size='2'>Product Brochure</font>
                        </td>
                        <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$brofl</font>
                        </td>
                    </tr>
                    <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Other relevant Documents</font>
                            </td>
                            <td colspan='3' style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$otfl</font>
                            </td>
                        </tr>
                </tbody>
            </table>
            <p>
                <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Regards,</font>
            </p>
            <p>
                <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Company</font>
            </p>
            ";
                // Send the email
                Mail::send([], [], function ($message) use ($receiversEmail, $subject, $content) {
                    $message->from("NoReply@Company.com");
                    $message->to($receiversEmail);
                    $message->subject($subject);
                    $message->setBody($content, 'text/html');
                });



                foreach ($recepient as $b) {
                    $content2 = "<p>
                <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Dear $b->name,</font>
                </p>
                <p>
                    <font face='arial,helvetica,sans-serif' size='2' style='color:black'>There is a subbmission from $request->contact_name</font>
                </p>
                <p>
                    <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Please find the details below:</font>
                </p>
                <table style='width: 750px' border='1' cellpadding='0' cellspacing='0'>
                    <tbody>
                        <tr>
                            <td colspan='4' class='withoutLabel'></td>
                        </tr>
                        <tr>
                            <td align='' style='background-color: #4092e5; color: black; font-weight: bold' colspan='4'>
                                <font size='2'><span style='float: left'>Company</span></font>
                            </td>
                        </tr>
                        <tr>
                            <td align='' style='background-color: #8cbdee; color: black' colspan='4'>
                                <font size='2'><span style='float: left'>Company Details </span></font>
                            </td>
                        </tr>
                        <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Company Name</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$request->company_name</font>
                            </td>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>HQ Office Address</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$request->hq</font>
                            </td>
                        </tr>
                        <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Company Website</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$request->company_website</font>
                            </td>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Country of origin</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$request->Country_of_origin</font>
                            </td>
                        </tr>
                        <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Year of establishment</font>
                            </td>
                            <td colspan='3' style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'>$request->year</font>
                            </td>
                        </tr>
                        <tr>
                            <td align='' style='background-color: #8cbdee; color: black' colspan='4' id='form[subReq2]'>
                                <font size='2'><span style='float: left'>Contact Person
                                    </span></font>
                            </td>
                        </tr>
                        <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Name</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$request->contact_name</font>
                            </td>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'> Designation</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$request->contact_designation</font>
                            </td>
                        </tr>
                        <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Email Address</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$request->contact_email</font>
                            </td>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Phone Number</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$request->contact_phone</font>
                            </td>
                        </tr>
                        <td align='' style='background-color: #8cbdee; color: black' colspan='4' id='form[subReq3]'>
                            <font size='2'><span style='float: left'>Products Offering
                                </span></font>
                        </td>
                        <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Products Offering
                                </font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$typro</font>
                            </td>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Care Segment</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$recare</font>
                            </td>
                        </tr>
                        <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Main Products
                                </font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$request->main_products</font>
                            </td>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Presence of distributor</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$repres</font>
                            </td>
                        </tr>
                        <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Country of interest for distribution</font>
                            </td>
                            <td colspan='3' style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                        <font size='2'>$reint</font>
                            </td>
                        </tr>

                        <td align='' style='background-color: #8cbdee; color: black' colspan='4' id='form[subReq3]'>
                            <font size='2'><span style='float: left'>Documents Files
                                </span></font>
                        </td>
                        <tr>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Company Profile
                                </font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$compafl</font>
                            </td>
                            <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                <font size='2'>Product Brochure</font>
                            </td>
                            <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$brofl</font>
                            </td>
                        </tr>
                        <tr>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Other relevant Documents</font>
                                </td>
                                <td colspan='3' style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'>$otfl</font>
                                </td>
                            </tr>
                    </tbody>
                </table>
                <p>
                    <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Regards,</font>
                </p>
                <p>
                    <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Company</font>
                </p>
                ";

                    Mail::send([], [], function ($message) use ($subject, $content2, $b) {
                        $message->from("NoReply@Company.com");
                        $message->to($b->email_address);
                        $message->subject($subject);
                        $message->setBody($content2, 'text/html');
                    });
                }

                DB::commit();
                return redirect('/thankyou');
            }

        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/error');
        }

    }


    public function formedit(Request $request)
    {

        try {
            $data = Form::find($request->id);

            $type = TypeProducts::select('type_of_products_id')->where('form_id', $data->form_id)->pluck('type_of_products_id')->toArray();
            $care = CareSegment::select('care_segment_id')->where('form_id', $data->form_id)->pluck('care_segment_id')->toArray();
            $presence_of_distributor = Presence::select('presence_of_distributor_id')->where('form_id', $data->form_id)->pluck('presence_of_distributor_id')->toArray();
            $country_of_interest_for_distribution = CountryInterest::select('country_of_interest_for_distribution_id')->where('form_id', $data->form_id)->pluck('country_of_interest_for_distribution_id')->toArray();
            $potential1 = PotentialRelation::select('potential_relationship_id')->where('form_id', $data->form_id)->pluck('potential_relationship_id')->toArray();
            $potential2 = PotentialIds::select('potential_service_offered_by_ids_id')->where('form_id', $data->form_id)->pluck('potential_service_offered_by_ids_id')->toArray();


            $product_type = Parameter::where('category', 'Type of Products')->get();
            $care_segment = Parameter::where('category', 'Care Segment')->get();
            $presence = Parameter::where('category', 'Presence of distributor')->get();
            $potential_relationship = Parameter::where('category', 'Potential Relationship')->get();
            $potential_service = Parameter::where('category', 'Potential Service offered by Company')->get();
            $country = Parameter::where('category', 'Country')->pluck('description');

            $company_profiles = CompanyProfile::where('form_id', $data->form_id)->pluck('company_profile');
            $product_brochures = ProductBrochure::where('form_id', $data->form_id)->pluck('product_brochure');
            $other_relevant_files = OtherDocument::where('form_id', $data->form_id)->pluck('other_relevant_file');

            $allcompafile = CompanyProfile::pluck('company_profile');
            $allprodfile = ProductBrochure::pluck('product_brochure');
            $allotherfile = OtherDocument::pluck('other_relevant_file');

            return view('formedit', compact('data', 'allcompafile', 'allprodfile', 'allotherfile', 'company_profiles', 'product_brochures', 'other_relevant_files', 'potential1', 'potential2', 'type', 'care', 'presence_of_distributor', 'country_of_interest_for_distribution', 'product_type', 'care_segment', 'presence', 'potential_relationship', 'potential_service', 'country'));

        } catch (Exception $e) {
            return redirect('/home')->with('status-mer', 'Something went wrong, if the issue
            persists contact administrator');
        }
    }

    public function update(Request $request)
    {
        // return $request;
        try {
            DB::beginTransaction();

            $form = form::find($request->id);

            $form->company_name = $request->company_name;
            $form->company_hq_office_address = $request->hq;
            $form->company_website = $request->company_website;
            $form->company_country_of_origin = $request->Country_of_origin;
            $form->year_of_establishment = $request->year;
            $form->contact_name = $request->contact_name;
            $form->contact_designation = $request->contact_designation;
            $form->contact_email_address = $request->contact_email;
            $form->contact_phone_number = $request->contact_phone;
            // $form->type_of_products = implode(',', $request->input('type_products'));
            // $form->care_segment = implode(',', $request->input('care'));
            $form->main_products = $request->main_products;
            // $form->presence_of_distributor = implode(',', $request->input('presence'));
            // $form->country_of_interest_for_distribution = implode(',', $request->input('country_interest'));

            // $form->potential_relationship = implode(',', $request->input('potential_1'));
            // $form->potential_service_offered_by_ids = implode(',', $request->input('potential_2'));
            $request->other_1 ? $form->other_potential_relationship = $request->other_1 : '';
            $request->other_2 ? $form->other_potential_service_offered_by_ids = $request->other_2 : '';
            $form->updated_by = auth()->user()->IDSAP;
            $form->update();


            if ($request->type_products) {
                TypeProducts::where('form_id', $form->form_id)->delete();
                foreach ($request->type_products as $type_products) {
                    $ty_pro = [
                        'form_id' => $form->form_id,
                        'type_of_products_id' => $type_products,
                        'updated_by' => auth()->user()->IDSAP,
                    ];
                    TypeProducts::create($ty_pro);
                }
            }

            if ($request->care) {
                CareSegment::where('form_id', $form->form_id)->delete();
                foreach ($request->care as $care) {
                    $care_seg = [
                        'form_id' => $form->form_id,
                        'care_segment_id' => $care,
                        'updated_by' => auth()->user()->IDSAP,
                    ];
                    CareSegment::create($care_seg);
                }
            }

            if ($request->presence) {
                Presence::where('form_id', $form->form_id)->delete();
                foreach ($request->presence as $presence) {
                    $pres = [
                        'form_id' => $form->form_id,
                        'presence_of_distributor_id' => $presence,
                        'updated_by' => auth()->user()->IDSAP,
                    ];
                    Presence::create($pres);
                }
            }

            if ($request->country_interest) {
                CountryInterest::where('form_id', $form->form_id)->delete();
                foreach ($request->country_interest as $country_interest) {
                    $cou_int = [
                        'form_id' => $form->form_id,
                        'country_of_interest_for_distribution_id' => $country_interest,
                        'updated_by' => auth()->user()->IDSAP,
                    ];
                    CountryInterest::create($cou_int);
                }
            }

            if ($request->potential_1) {
                PotentialRelation::where('form_id', $form->form_id)->delete();
                foreach ($request->potential_1 as $potential_1) {
                    $pot1 = [
                        'form_id' => $form->form_id,
                        'potential_relationship_id' => $potential_1,
                        'updated_by' => auth()->user()->IDSAP,
                    ];
                    PotentialRelation::create($pot1);
                }
            }

            if ($request->potential_2) {
                PotentialIds::where('form_id', $form->form_id)->delete();
                foreach ($request->potential_2 as $potential_2) {
                    $pot2 = [
                        'form_id' => $form->form_id,
                        'potential_service_offered_by_ids_id' => $potential_2,
                        'updated_by' => auth()->user()->IDSAP,
                    ];
                    PotentialIds::create($pot2);
                }
            }


            if ($request->company_profile) {
                for ($key = 0; $key < count($request->file('company_profile')); $key++) {
                    $compa_file = $request->file('company_profile');
                    if (array_key_exists($key, $compa_file) && $compa_file[$key] !== null) {
                        $compaDocumentsName = $compa_file[$key]->getClientOriginalName();
                        $compa_file[$key]->storeAs('uploads/company_profile', $compaDocumentsName, 'public');

                        $companewfile = new CompanyProfile;
                        $companewfile->form_id = $form->form_id;
                        $companewfile->company_profile = $compaDocumentsName;
                        $companewfile->updated_by = auth()->user()->IDSAP;
                        $companewfile->save();
                    }
                }
            }


            if ($request->product_brochure) {
                for ($key = 0; $key < count($request->file('product_brochure')); $key++) {
                    $prod_file = $request->file('product_brochure');
                    if (array_key_exists($key, $prod_file) && $prod_file[$key] !== null) {
                        $prodDocumentsName = $prod_file[$key]->getClientOriginalName();
                        $prod_file[$key]->storeAs('uploads/product_brochure', $prodDocumentsName, 'public');

                        $prodnewfile = new ProductBrochure;
                        $prodnewfile->form_id = $form->form_id;
                        $prodnewfile->product_brochure = $prodDocumentsName;
                        $prodnewfile->updated_by = auth()->user()->IDSAP;
                        $prodnewfile->save();

                    }
                }
            }

            if ($request->other_documents) {
                for ($key = 0; $key < count($request->file('other_documents')); $key++) {
                    $other_file = $request->file('other_documents');
                    if (array_key_exists($key, $other_file) && $other_file[$key] !== null) {
                        $OtherDocumentsName = $other_file[$key]->getClientOriginalName();
                        $other_file[$key]->storeAs('uploads/other_documents', $OtherDocumentsName, 'public');

                        $otnewfile = new OtherDocument;
                        $otnewfile->form_id = $form->form_id;
                        $otnewfile->other_relevant_file = $OtherDocumentsName;
                        $otnewfile->updated_by = auth()->user()->IDSAP;
                        $otnewfile->save();

                    }
                }
            }


            if ($form) {
                DB::commit();
                return redirect('/home')->with('status', 'Form Edited Successfully');
            }

        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/home')->with('status-mer', 'Update Failed');
        }
    }

    public function thankyou()
    {

        return view('thankyou');
    }

    public function error()
    {
        return view('error');
    }

    public function Email()
    {
        $content2 = "<p>
                    <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Dear ,</font>
                    </p>
                    <p>
                        <font face='arial,helvetica,sans-serif' size='2' style='color:black'>There is a subbmission from </font>
                    </p>
                    <p>
                        <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Please find the details below:</font>
                    </p>
                    <table style='width: 750px' border='1' cellpadding='0' cellspacing='0'>
                        <tbody>
                            <tr>
                                <td colspan='4' class='withoutLabel'></td>
                            </tr>
                            <tr>
                                <td align='' style='background-color: #4092e5; color: black; font-weight: bold' colspan='4'>
                                    <font size='2'><span style='float: left'>Company</span></font>
                                </td>
                            </tr>
                            <tr>
                                <td align='' style='background-color: #8cbdee; color: black' colspan='4'>
                                    <font size='2'><span style='float: left'>Company Details </span></font>
                                </td>
                            </tr>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Country of origin</font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Country of origin</font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                            </tr>
                            <tr>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Year of establishment</font>
                                </td>
                                <td colspan='3' style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                <font size='2'></font>
                                </td>
                            </tr>
                            <tr>
                                <td align='' style='background-color: #8cbdee; color: black' colspan='4' id=''>
                                    <font size='2'><span style='float: left'>Contact Person
                                        </span></font>
                                </td>
                            </tr>
                            <tr>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Name</font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'> Designation</font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                            </tr>
                            <tr>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Email Address</font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Phone Number</font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                            </tr>
                            <td align='' style='background-color: #8cbdee; color: black' colspan='4' id='form[subReq3]'>
                                <font size='2'><span style='float: left'>Products Offering
                                    </span></font>
                            </td>
                            <tr>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Products Offering
                                    </font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Care Segment</font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                            </tr>
                            <tr>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Main Products
                                    </font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font></font>
                                </td>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Presence of distributor</font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                            </tr>
                            <tr>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Country of interest for distribution</font>
                                </td>
                                <td colspan='3' style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                            <font size='2'></font>
                                </td>
                            </tr>

                            <td align='' style='background-color: #8cbdee; color: black' colspan='4' id='form[subReq3]'>
                                <font size='2'><span style='float: left'>Documents Files
                                    </span></font>
                            </td>
                            <tr>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Company Profile
                                    </font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                                <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                    <font size='2'>Product Brochure</font>
                                </td>
                                <td style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                </td>
                            </tr>
                            <tr>
                                    <td style=' color: #000000; padding-right: 10px; text-align: right; width: 140px; '>
                                        <font size='2'>Other relevant Documents</font>
                                    </td>
                                    <td colspan='3' style=' width: 200px; background-color: #efefef; color: #000000; padding-left: 5px; '>
                                    <font size='2'></font>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                    <p>
                        <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Regards,</font>
                    </p>
                    <p>
                        <font face='arial,helvetica,sans-serif' size='2' style='color:black'>Company</font>
                    </p>";

        Mail::send([], [], function ($message) use ($content2) {
            $message->from('Company@Company.com');
            $message->to('Company@Company.com');
            $message->subject('Company');
            $message->setBody($content2, 'text/html');
        });

        return redirect('/thankyou');
    }


    public function deletefiles(Request $request)
    {
        // return $request;
        if ($request->other_relevant_files_name) {
            $otfile = OtherDocument::where('other_relevant_file', $request->other_relevant_files_name)
                ->first();
            if ($otfile) {
                $otfile->delete();
                if (Storage::disk('public')->exists($request->other_relevant_files_name)) {
                    Storage::disk('public')->delete($request->other_relevant_files_name);

                    return redirect('/home');
                }
            }
        }

        if ($request->product_brochure_name) {
            $brofile = ProductBrochure::where('product_brochure', $request->product_brochure_name)
                ->first();
            if ($brofile) {
                $brofile->delete();
                if (Storage::disk('public')->exists($request->product_brochure_name)) {
                    Storage::disk('public')->delete($request->product_brochure_name);

                    return redirect('/home');
                }
            }
        }

        if ($request->company_profile_name) {
            $cofile = CompanyProfile::where('company_profile', $request->company_profile_name)
                ->first();
            if ($cofile) {
                $cofile->delete();
                if (Storage::disk('public')->exists($request->company_profile_name)) {
                    Storage::disk('public')->delete($request->company_profile_name);

                    return redirect('/home');
                }
            }
        }




    }


}