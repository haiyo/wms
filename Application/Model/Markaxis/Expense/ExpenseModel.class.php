<?php
namespace Markaxis\Expense;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ExpenseModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpenseModel extends \Model {


    // Properties
    protected $Expense;



    /**
     * ExpenseModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Payroll/PayrollRes');

        $this->Expense = new Expense( );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        return $this->Expense->getList( );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function getResults( $post ) {
        $this->Expense->setLimit( $post['start'], $post['length'] );

        $order = 'ei.title';
        $dir   = isset( $post['order'][0]['dir'] ) && $post['order'][0]['dir'] == 'desc' ? ' desc' : ' asc';

        if( isset( $post['order'][0]['column'] ) ) {
            switch( $post['order'][0]['column'] ) {
                case 1:
                    $order = 'ei.title';
                    break;
                case 2:
                    $order = 'ei.amount';
                    break;
            }
        }
        $results = $this->Expense->getResults( $post['search']['value'], $order . $dir );

        $total = $results['recordsTotal'];
        unset( $results['recordsTotal'] );

        return array( 'draw' => (int)$post['draw'],
                      'recordsFiltered' => $total,
                      'recordsTotal' => $total,
                      'data' => $results );
    }
}
?>