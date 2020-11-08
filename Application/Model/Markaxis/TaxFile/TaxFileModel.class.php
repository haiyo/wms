<?php
namespace Markaxis\TaxFile;
use \Markaxis\Company\CompanyModel;
use \Markaxis\Employee\EmployeeModel;
use \Aurora\User\UserImageModel;
use \Library\Helper\Markaxis\SourceTypeHelper, \Library\Helper\Markaxis\OrgTypeHelper;
use \Library\Helper\Markaxis\IrasPaymentTypeHelper;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: TaxFileModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class TaxFileModel extends \Model {


    // Properties
    protected $TaxFile;



    /**
     * TaxFileModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/TaxFile/TaxFileRes');

        $this->TaxFile = new TaxFile( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByTFID( $tfID ) {
        return $this->TaxFile->getByTFID( $tfID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByFileYear( $year, $batch ) {
        return $this->TaxFile->getByFileYear( $year, $batch );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->TaxFile->getList( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function setCompleted( $tfID ) {
        return $this->TaxFile->update('taxfile', array('completed' => 1), 'WHERE tfID = "' . (int)$tfID . '"' );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isCompleted( $tfID ) {
        return $this->TaxFile->isCompleted( $tfID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isSubmitted( $tfID ) {
        return $this->TaxFile->isSubmitted( $tfID );
    }


    /**
     * Get Table Results
     * @return mixed
     */
    public function getResults( $data ) {
        $this->TaxFile->setLimit( $data['start'], $data['length'] );

        $order = 'fileYear  ';
        $dir   = isset( $data['order'][0]['dir'] ) && $data['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $data['order'][0]['column'] ) ) {
            switch( $data['order'][0]['column'] ) {
                case 1:
                    $order = 'tf.year';
                    break;
                case 2:
                    $order = 'tf.authUserID';
                    break;
                case 3:
                    $order = 'tf.subType';
                    break;
                default:
                    $order = 'tf.empCount';
                    break;
            }
        }
        $results = $this->TaxFile->getResults( $data['search']['value'], $order . $dir );

        if( $results ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $results as $key => $row ) {
                if( isset( $row['authUserID'] ) ) {
                    $results[$key]['photo'] = $UserImageModel->getImgLinkByUserID( $row['authUserID'] );
                }
                if( isset( $row['batch'] ) ) {
                    $results[$key]['batch'] = $row['batch'] == 'O' ? 'Original' : 'Amendment';
                }
            }
        }

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$data['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getEmployeeResults( $post ) {
        $this->TaxFile->setLimit( $post['start'], $post['length'] );

        $order = 'name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'e.idnumber';
                    break;
                case 2:
                    $order = 'name';
                    break;
                case 3:
                    $order = 'd.title';
                    break;
                case 4:
                    $order = 'e.email';
                    break;
                case 5:
                    $order = 'u.mobile';
                    break;
                case 6:
                    $order = 'u.suspended';
                    break;
            }
        }
        $results = $this->TaxFile->getEmployeeResults( $post['officeID'], $post['tfID'], $post['search']['value'], $order . $dir );

        if( $results ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $results as $key => $row ) {
                if( isset( $row['userID'] ) ) {
                    $results[$key]['photo'] = $UserImageModel->getImgLinkByUserID( $row['userID'] );
                }
            }
        }

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getDeclarationResults( $post ) {
        $this->TaxFile->setLimit( $post['start'], $post['length'] );

        $order = 'name';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'e.idnumber';
                    break;
                case 2:
                    $order = 'name';
                    break;
                case 3:
                    $order = 'd.title';
                    break;
                case 4:
                    $order = 'e.email';
                    break;
                case 5:
                    $order = 'u.mobile';
                    break;
                case 6:
                    $order = 'u.suspended';
                    break;
            }
        }
        $results = $this->TaxFile->getDeclarationResults( $post['officeID'], $post['tfID'], $post['search']['value'], $order . $dir );

        if( $results ) {
            $UserImageModel = UserImageModel::getInstance( );

            foreach( $results as $key => $row ) {
                if( isset( $row['userID'] ) ) {
                    $results[$key]['photo'] = $UserImageModel->getImgLinkByUserID( $row['userID'] );
                }
            }
        }

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function updateEmpCount( $tfID, $count ) {
        $info = array( );
        $info['empCount'] = (int)$count;
        return $this->TaxFile->update('taxfile', $info, 'WHERE tfID = "' . (int)$tfID . '"' );
    }


    /**
     * Set Pay Item Info
     * @return bool
     */
    public function createForm( $post ) {
        if( is_numeric( $post['data']['year'] ) && $post['data']['year'] < date('Y')+1 ) {
            $this->info['fileYear'] = $post['data']['year'];
            $this->info['officeID'] = $post['data']['office'];
            $this->info['endDate'] = $post['data']['year'] . '-03-31';
            $this->info['giveEmp'] = ($this->info['fileYear']+1) . '-03-01';
            $this->info['batch'] = $post['data']['batch'] == 'O' ? 'O' : 'A';

            $hasOriginal = $this->getByFileYear( $this->info['fileYear'],'O' );

            // if we already have Original batch, then we should expect Amendment instead..
            if( !$post['data']['tfID'] && $hasOriginal && $hasOriginal['submitted'] && $this->info['batch'] == 'O' ) {
                $this->setErrMsg('This tax record has already been created.' );
                return false;
            }

            // If no original but trying to make amendments...
            if( (!$hasOriginal || !$this->isCompleted( $post['data']['tfID'] ) ) && $this->info['batch'] == 'A' ) {
                $this->setErrMsg('You have no valid "Original" tax record for the selected year. 
                                          You need to create or complete an original tax record before making amendments.' );
                return false;
            }

            $CompanyModel = CompanyModel::getInstance( );
            $companyInfo = $CompanyModel->loadInfo( );

            $this->info['regNumber'] = $companyInfo['regNumber'];
            $this->info['companyName'] = $companyInfo['name'];
            $this->info['companyAddress'] = $companyInfo['address'];

            if( in_array( $post['data']['sourceType'], SourceTypeHelper::getList( ) ) ) {
                $this->info['sourceType'] = $post['data']['sourceType'];
            }
            else {
                $this->setErrMsg('Invalid Form Data' );
                return false;
            }

            if( in_array( $post['data']['orgIDType'], OrgTypeHelper::getList( ) ) ) {
                $this->info['orgIDType'] = $post['data']['orgIDType'];
            }
            else {
                $this->setErrMsg('Invalid Form Data' );
                return false;
            }

            if( in_array( $post['data']['paymentType'], IrasPaymentTypeHelper::getList( ) ) ) {
                $this->info['paymentType'] = $post['data']['paymentType'];
            }
            else {
                $this->setErrMsg('Invalid Form Data' );
                return false;
            }

            $Authenticator = $this->Registry->get( HKEY_CLASS, 'Authenticator' );
            $userInfo = $Authenticator->getUserModel( )->getInfo( 'userInfo' );

            $EmployeeModel = new EmployeeModel( );
            $authUser = $EmployeeModel->getIR8AInfo( $userInfo['userID'] );

            $this->info['authUserID'] = $authUser['userID'];
            $this->info['authName'] = $authUser['name'];
            $this->info['authDesignation'] = $authUser['designation'];
            $this->info['authPhone'] = $authUser['mobile'];
            $this->info['authEmail'] = $authUser['email'];
            $this->info['authDate'] = date('Y-m-d');
            $this->info['created'] = date('Y-m-d');

            if( $post['data']['tfID'] && !$this->isSubmitted( $post['data']['tfID'] ) ) {
                $this->TaxFile->update('taxfile', $this->info, 'WHERE tfID = "' . (int)$post['data']['tfID'] . '"' );
                return 'update';
            }
            else {
                return $this->TaxFile->insert('taxfile', $this->info );
            }
        }
        return false;
    }


    /**
     * Return total count of records
     * @return int
     */
    public function submitIRAS( $tfID ) {
        if( $tfInfo = $this->getByTFID( $tfID ) ) {
            $endpoint = 'https://apisandbox.iras.gov.sg/iras/sb/Authentication/CorpPassAuth?';

            // Registered callback
            //https://staging.hrmscloud.net/admin/iras_sandbox
            //https://hrmscloud.net/admin/iras_sandbox
            //https://hrmscloud.net/admin/iras

            //echo urlencode( 'https://staging.hrmscloud.net/admin/payroll/iras');
            //exit;

            $fields = array(
                'scope' => 'EmpIncomeSub',
                'callback_url' => 'https://www.hrmscloud.net/admin/iras_sandbox',
                'state' => '390b25fa-4427-4b10-9ae2-34d6e0cd91a1',
                'tax_agent' => 'false'
            );

            $fields_string = "";
            foreach($fields as $key => $value) {
                $fields_string .= $key.'='.$value.'&';
            }
            $fields_string = rtrim($fields_string, '&');

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $endpoint . $fields_string,
                //CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => array(
                    'x-ibm-client-id: ' . urlencode('1425d73f-1459-4dc6-9528-7b2b3b76a249' ),
                    'x-ibm-client-secret: ' . urlencode('H4yH5vG6aW3uN7cM3eT5dX0bT5yV4gO7eL5wC4bD1cB5kX0mU1'),
                    'content-type: application/json',
                    'accept: application/json' )
            ));
            $result = curl_exec($ch);
            $result = json_decode( $result );

            if( isset( $result->returnCode ) && $result->returnCode == 10 && isset( $result->data->url ) ) {
                header('location: ' . $result->data->url );
            }
        }
    }
}
?>