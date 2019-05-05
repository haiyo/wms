<?php
namespace Markaxis\Expense;
use \Aurora\User\UserModel;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ClaimModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ClaimModel extends \Model {


    // Properties
    protected $Claim;



    /**
     * ClaimModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Claim = new Claim( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $userInfo = UserModel::getInstance( )->getInfo( );
        $this->Claim->setLimit( $post['start'], $post['length'] );

        $order = 'ei.title';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'ei.title';
                    break;
                case 2:
                    $order = 'ec.descript';
                    break;
                case 3:
                    $order = 'ec.amount';
                    break;
            }
        }
        $results = $this->Claim->getResults( $userInfo['userID'], $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }
}
?>