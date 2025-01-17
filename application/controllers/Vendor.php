<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
require APPPATH . '/libraries/REST_Controller.php';
// require APPPATH . '/libraries/JWT.php';
class Vendor extends REST_Controller
{
    public $device = "";
    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        header('Content-Type:  multipart/form-data');
        header('Authorization: token');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        // header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        header("HTTP/1.1 200 OK");
        die();
        }

        $this->load->library("applib", array("controller" => $this));
        $this->load->model("app_model");
        $this->load->model("shop_model");
        $this->load->model("dealer_model");
        $this->load->model("vendor_model");
        $this->load->model("login_model");
        $this->load->model("employee_model");
    }
    public function InsertNewVendor_post()
    {
        $vendorinsertsuccess = $this->vendor_model->InsertNewVendor();
        $this->response($vendorinsertsuccess);
    }

    public function InsertVendorContact_get()
{
    $ContactBusiness=$_GET['ContactBusiness'];
    $ContactBusinessArr = json_decode($ContactBusiness,true);
    // $ContactBusinessArr = (array) $ContactBusiness;
    // $ContactBusinessArr2 = (array) $ContactBusinessArr;
    var_dump($ContactBusinessArr);
    // $vendorid = "test";
    if($ContactBusinessArr["VendorContactPrimary"] == true) {
        $ContactBusinessArr["VendorContactPrimary"] = 1;
    }
    else {
        $ContactBusinessArr["VendorContactPrimary"] = 0;
    }

    if($ContactBusinessArr["VendorContactPrimary"] == true) {
        $ContactBusinessArr["VendorContactActive"] = 1;
    }
    else {
        $ContactBusinessArr["VendorContactActive"] = 0;
    }
    $result = $this->vendor_model->insert_vendorContact("10",
    $ContactBusinessArr["contact_name"],
    $ContactBusinessArr["business_phone"],
    $ContactBusinessArr["title"],
    $ContactBusinessArr["business_email"],
    $ContactBusinessArr["VendorContactPrimary"],
    $ContactBusinessArr["VendorContactActive"],
//     $ContactBusinessArr["contact_name"],
//     $ContactBusinessArr["contact_name"]
);
                $data['success'] = $result;
    // var_dump($ContactBusinessArr[0]);

    // $vendorMgmt=$_GET['vendorMgmt'];


    // $queryresponse= $this->app_model->Addwhislisttodb($whislist,$Customer_id,$date,$city_id);
    //$this->response($ContactBusiness);
}

public function GetVendorType_get()
{
   // $dealer_id = $this->applib->verifyToken();
    $data['vendortype'] = $this->vendor_model->getVendorType();
    $this->response($data);

}


public function AdduserDetails_post()
{

    $json = file_get_contents('php://input');
        // Converts it into a PHP object
                $request = json_decode($json,true);
                $registercontactinformation = $request->registercontactinformation;
                // var_dump($MasterserviceForm);
                $UserTypeId = $registercontactinformation->UserTypeId;
    if($request["UserTypeId"]=="EMPLOY")
    {
        $UserId = $request["UserId"];
    $UserTypeId = $request["UserTypeId"];
    $UserStatusId = $request["UserStatusId"];
    $UserPassword = $request["UserPassword"];
    $EmployeeId = NULL;
    $VendorId = NULL;
    $CreatedDate = date('Y-m-d');
    // $CreatedUserId = $request["UserId"];
    $UpdatedDate = date('Y-m-d');
    // $UpdatedUserid = $request["UserId"];
    // var_dump($UpdatedUserid);
    $AdminUser = $request["AdminUser"];
    if($AdminUser == true){
        $AdminUser = 1;
    }
    else {
        $AdminUser = 0;
    }

// employee tbl insert
$FirstName = $request["FirstName"];
$LastName = $request["LastName"];
$Phone = $request["Phone"];
$EmploymentTypeId = $request["EmploymentTypeId"];
    $JobTitleId = $request["JobTitleId"];
    $StartDate = $request["JobStartDate"];
    $CreatedDate = date('Y-m-d');
// $CreatedUserId = $request["CreatedUserId"];
$UpdatedDate = date('Y-m-d');
// $UpdatedUserId = $request["UpdatedUserId"];



    // insert into employee address
    $AddressTypeId = 'C';
    $AStartDate = $request["StartDate"];
    $EndDate = $request["EndDate"];
    $Address1 = $request["Address1"];
    $Address2 = $request["Address2"];

    $DistrictId = $request["DistrictId"];
    $CityId = $request["CityId"];
    $StateId = $request["StateId"];
    $Zipcode = $request["Zipcode"];
    $CountryId = $request["CountryId"];

    $data = array('UserId' => $UserId, 'UserTypeId' => $UserTypeId, 'UserStatusId' => $UserStatusId,
    'UserPassword' => $UserPassword, 'EmployeeId' => $EmployeeId, 'VendorId' => $VendorId,'CreatedDate' => $CreatedDate,
    'CreatedUserId' => $UserId, 'UpdatedDate' => $UpdatedDate,
    'UpdatedUserid' => $UserId, 'AdminUser' => $AdminUser,'FirstName'=>$FirstName,'LastName'=>$LastName,'Phone'=>$Phone,
    'EmploymentTypeId'=>$EmploymentTypeId,'JobTitleId'=>$JobTitleId,'StartDate'=>$StartDate, 'AddressTypeId'=>$AddressTypeId,'AStartDate'=>$AStartDate,'Address1'=>$Address1,'StateId'=>$StateId,'Zipcode'=>$Zipcode,
    'CountryId'=>$CountryId  );





                 $result = $this->employee_model->AdduserDetailsEmployee($data);
                 $data = [
                   'ErrorCode' => $result
            ];

            return $this->response($data);

                }
//                 // insert vendor
    else if($request["UserTypeId"]=="VENDOR")
     {

$UserId = $request["UserId"];
    $UserTypeId = $request["UserTypeId"];
    $UserStatusId = $request["UserStatusId"];
    $UserPassword = $request["UserPassword"];
    $EmployeeId = NULL;
    $VendorId = NULL;
    $CreatedDate = date('Y-m-d');
    // $CreatedUserId = $request["UserId"];
    $UpdatedDate = date('Y-m-d');
    // $UpdatedUserid = $request["UserId"];
    // var_dump($UpdatedUserid);
    $AdminUser = NULL;

    $OutreachEmailOptIn = $request["OutreachEmailOptIn"];
    if($OutreachEmailOptIn == true){
        $OutreachEmailOptIn = 1;
    }
    else {
        $OutreachEmailOptIn = 0;
    }

    // vendor tbl insert
$FirstName = $request["FirstName"];
$LastName = $request["LastName"];
// $Phone = $request["Phone"];
$VendorTypeId = $request["VendorTypeId"];



if($VendorTypeId == true) {
    $VendorTypeId = "B";
    $BusinessSize = $request["BusinessSize"];
    $BEClassificationId = $request["BEClassificationId"];
    $BusinessRegisteredInDistrict = $request["BusinessRegisteredInDistrict"];
    $BusinessRegisteredInSCC = $request["BusinessRegisteredInSCC"];
    $BusinessIsFranchisee = $request["BusinessIsFranchisee"];
    // $OutreachEmailOptIn = $request["OutreachEmailOptIn"];
    $EIN_SSN = '';
}
else {
    $VendorTypeId = "I";
    $BusinessSize = '';
    $BEClassificationId = '';
    $BusinessRegisteredInDistrict = '';
    $BusinessRegisteredInSCC = '';
    $BusinessIsFranchisee = '';
    // $OutreachEmailOptIn = $request["OutreachEmailOptIn"];
    // $OutreachEmailOptIn = 1;
    $EIN_SSN = $request["EIN_SSN"];
}
;
    // $Email = $request["Email"];



    $CreatedDate = date('Y-m-d');

$UpdatedDate = date('Y-m-d');
$CreatedUserId = $request["UserId"];
$UpdatedUserId = $request["UserId"];


    // address vendor
    $AddressTypeId = 'C';
    $StartDate = $request["StartDate"];
    $EndDate = $request["EndDate"];
    $Address1 = $request["Address1"];
    $Address2 = $request["Address2"];

    $DistrictId = $request["DistrictId"];
    $CityId =  1; //$request["CityId"];
    $StateId = $request["StateId"];
    $Zipcode = $request["Zipcode"];
    $CountryId = $request["CountryId"];
    // $EndDate = $request["EndDate"];





    $data = array('UserId' => $UserId, 'UserTypeId' => $UserTypeId, 'UserStatusId' => $UserStatusId,
    'UserPassword' => $UserPassword, 'EmployeeId' => $EmployeeId, 'VendorId' => $VendorId,'CreatedDate' => $CreatedDate,
    'CreatedUserId' => $UserId, 'UpdatedDate' => $UpdatedDate,
    'UpdatedUserid' => $UserId, 'AdminUser' => $AdminUser,'VendorTypeId'=>$VendorTypeId,'LegalName'=>$LastName,'TradeName'=>$FirstName,'EIN_SSN'=>$EIN_SSN,
    'BusinessSize'=>$BusinessSize,'BEClassificationId'=>$BEClassificationId,'BusinessRegisteredInDistrict'=>$BusinessRegisteredInDistrict,
    'BusinessRegisteredInSCC'=>$BusinessRegisteredInSCC,'BusinessIsFranchisee'=>$BusinessIsFranchisee,'OutreachEmailOptIn'=>$OutreachEmailOptIn,
    'AddressTypeId'=>$AddressTypeId,'StartDate'=>$StartDate,'EndDate'=>$EndDate,'Address1'=>$Address1,'StateId'=>$StateId,'DistrictId'=>$DistrictId,'CityId'=>$CityId,'Zipcode'=>$Zipcode,'CountryId'=>$CountryId);


                 $result = $this->employee_model->AdduserDetailsVendor($data);
                //  if($result)
                //  {
                //     $this->response('', 200, 'success')
                //  }
                //  else
                //  {

                //        $this->response('', 404, 'Notsuccess')

                //  }
                $data = [
                    'ErrorCode' => $result
             ];

             return $this->response($data);
}


}

public function GetAllVendors_get()
{

    $data['VendorList']=$this->vendor_model->GetVendorList();
    $this->response($data);

}

public function GetVendorById_get()
{
    $VendorId=$_GET['VendorId'];
    $data['SingleVendorDetails']=$this->vendor_model->GetVendorById($VendorId);
    $this->response($data);

}

public function GetVendorAddressById_get()
{
    $VendorId=$_GET['VendorId'];
    $data['SingleVendorAddressDetails']=$this->vendor_model->GetVendorAddressById($VendorId);
    $this->response($data);

}
public function UpdateVendor_post(){

    $json = file_get_contents('php://input');
    $request = json_decode($json,true);
    // $vendorMgmt = $request->vendorMgmt;

    $VendorId = $request["VendorId"];
    $VendorTypeId = $request["VendorTypeId"];
    $Address1 = $request["Address1"];
    $Address2 = $request['Address2'];
    $CityId = $request['CityId'];
    $Zipcode = $request['Zipcode'];
    $DistrictId = $request['DistrictId'];
    $StateId = $request['StateId'];
    $CountryId = $request['CountryId'];
    $OutreachEmailOptIn = $request["OutreachEmailOptIn"];

    $NAICSCodes = $request["NAICSCodes"];
    $BusinessRegisteredInDistrict = $request["BusinessRegisteredInDistrict"];
    $BusinessIsFranchisee = $request["BusinessIsFranchisee"];
    $DUNS = $request["DUNS"];
    $CommodityCodes = $request["CommodityCodes"];
    $Website = $request["Website"];
    $BusinessRegisteredInSCC = $request["BusinessRegisteredInSCC"];
    $ContactName = $request["ContactName"];
    $JobTitle = $request["JobTitle"];
    $VendorContactPrimary = $request["VendorContactPrimary"];
    $VendorContactActive = $request["VendorContactActive"];
    $Phone = $request["Phone"];
    $Email = $request["Email"];
    $BusinessEmail = $request["BusinessEmail"];
    $BusinessPhone = $request["BusinessPhone"];

    if($VendorTypeId == "B") {

         $LegalName = $request["LegalName"];
         $TradeName = $request["TradeName"];
         $AliasName = $request["AliasName"];
         $EIN_SSN = $request["EIN_SSN"];

     }
    else {

        $TradeName = $request["FirstName"];
        $LegalName = $request["LastName"];
        $AliasName = $request["MiddleName"];
        $EIN_SSN = $request["EIN_SSN"];

      }

    //   $vendordata = array('vendorid'=>$vendorid,'VendorTypeId'=>$VendorTypeId,
    //    'LegalName'=>$LegalName,'TradeName'=>$TradeName,'EIN_SSN'=>$EIN_SSN,
    //    'DUNS'=>$DUNS,'NAICSCodes'=>$NAICSCodes,'CommodityCodes'=>$CommodityCodes, 'BusinessRegisteredInDistrict'=>$BusinessRegisteredInDistrict,'BusinessRegisteredInSCC'=>$BusinessRegisteredInSCC,
    // //    'BusinessIsFranchisee'=>$BusinessIsFranchisee,'Website'=>$Website,'Phone'=>$Phone,'Email'=>$Email,
    //    ,'UpdatedUserId'=>"Test00001",'AliasName'=>$AliasName
    //  );
    var_dump($VendorId);

     $vendordata = array('VendorId'=>$VendorId,'VendorTypeId'=>$VendorTypeId,'LegalName'=>$LegalName,'TradeName'=>$TradeName

     );


      $result = $this->vendor_model->updatevendorDetails($vendordata);
      $data['success'] = $result;

    // $this->response('', 404, 'fail', $request["FirstName"]);

}

}

