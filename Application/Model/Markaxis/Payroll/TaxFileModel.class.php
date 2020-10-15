<?php
namespace Markaxis\Payroll;
use \Aurora\User\UserImageModel;
use \Library\Validator\Validator;
use \Library\Validator\ValidatorModule\IsEmpty;
use \Library\Exception\ValidatorException;

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
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->TaxFile = new TaxFile( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFound( $piID ) {
        return $this->TaxFile->isFound( $piID );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->TaxFile->getList( );
    }


    /**
     * Get Table Results
     * @return mixed
     */
    public function getResults( $data ) {
        $this->TaxFile->setLimit( $data['start'], $data['length'] );

        $order = 'pi.title';
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
                if( isset( $row['userID'] ) ) {
                    $results[$key]['photo'] = $UserImageModel->getImgLinkByUserID( $row['authUserID'] );
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
     * Set Pay Item Info
     * @return bool
     */
    public function isValid( $data ) {
        $Validator = new Validator( );

        $this->info['piID'] = (int)$data['piID'];
        $this->info['title'] = Validator::stripTrim( $data['payItemTitle'] );

        $Validator->addModule('payItemTitle', new IsEmpty( $this->info['title'] ) );

        try {
            $Validator->validate( );
        }
        catch( ValidatorException $e ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_ENTER_REQUIRED_FIELDS') );
            return false;
        }

        if( $data['payItemType'] == 'basic' ) {
            $this->info['basic'] = 1;
        }
        else if( $data['payItemType'] == 'deduction' ) {
            $this->info['deduction'] = 1;
        }
        else if( $data['payItemType'] == 'claim' ) {
            $this->info['claim'] = 1;
        }
        return true;
    }


    /**
     * Save Pay Item information
     * @return int
     */
    public function save( ) {
        if( !$this->info['piID'] ) {
            unset( $this->info['piID'] );
            $this->info['piID'] = $this->Item->insert( 'payroll_item', $this->info );
        }
        else {
            $this->Item->update( 'payroll_item', $this->info, 'WHERE piID = "' . (int)$this->info['piID'] . '"' );
        }
        return $this->info['piID'];
    }


    /**
     * Delete Pay Item
     * @return int
     */
    public function delete( $data ) {
        $deleted = 0;

        if( is_array( $data ) ) {
            foreach( $data as $piID ) {
                $info = array( );
                $info['deleted'] = 1;
                $this->Item->update( 'payroll_item', $info, 'WHERE piID = "' . (int)$piID . '"' );
                $deleted++;
            }
        }
        return $deleted;
    }

    /*
    $endpoint = 'https://apisandbox.iras.gov.sg/iras/sb/Authentication/CorpPassAuth?';

        // Registered callback
        //https://staging.hrmscloud.net/admin/iras_sandbox
        //https://hrmscloud.net/admin/iras_sandbox
        //https://hrmscloud.net/admin/iras

        //echo urlencode( 'https://staging.hrmscloud.net/admin/payroll/iras');
        //exit;

        $fields = array(
            'scope' => 'EmpIncomeSub',
            'callback_url' => urlencode('https://www.markaxis.com/admin/iras_sandbox'),
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
            CURLOPT_HTTPHEADER => array( 'x-ibm-client-id: ' . urlencode('1425d73f-1459-4dc6-9528-7b2b3b76a249' ),
                                         'x-ibm-client-secret: ' . urlencode('H4yH5vG6aW3uN7cM3eT5dX0bT5yV4gO7eL5wC4bD1cB5kX0mU1'),
                                         'content-type: application/json',
                                         'accept: application/json' )
        ));
        $result = curl_exec($ch);
        $result = json_decode( $result );

        var_dump($result); exit;

     * */
}
?>