<?php
namespace Markaxis\Expense;
use \Markaxis\Employee\EmployeeModel;
use \Markaxis\Company\OfficeModel;
use \Aurora\Component\CountryModel;
use \Library\Util\Money;
use \Library\Validator\Validator;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Saturday, August 4th, 2012
 * @version $Id: ExpenseModel.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class ExpenseModel extends \Model {


    // Properties
    protected $Expense;
    private $expenseList;


    /**
     * ExpenseModel Constructor
     * @return void
     */
    function __construct( ) {
        parent::__construct( );
        $i18n = $this->Registry->get( HKEY_CLASS, 'i18n' );
        $this->L10n = $i18n->loadLanguage('Markaxis/Expense/ExpenseRes');

        $this->Expense = new Expense( );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function isFoundByeiID( $eiID ) {
        return $this->Expense->isFoundByeiID( $eiID );
    }


    /**
     * Return total count of records
     * @return int
     */
    public function getByeiID( $eiID ) {
        $eInfo = $this->Expense->getByeiID( $eiID );

        if( $eInfo ) {
            $eInfo['max_amount'] = Money::format( $eInfo['max_amount'] );
        }
        return $eInfo;
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getList( ) {
        if( $this->expenseList ) {
            return $this->expenseList;
        }

        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );

        $OfficeModel = OfficeModel::getInstance( );
        $officeInfo = $OfficeModel->getByoID( $empInfo['officeID'] );

        return $this->expenseList = $this->Expense->getList( $officeInfo['countryID'] );
    }


    /**
     * Return user data by userID
     * @return mixed
     */
    public function getMaxAmount( $eiID ) {
        if( $exInfo = $this->getByeiID( $eiID ) ) {
            if( $exInfo['max_amount'] ) {
                return $this->L10n->strReplace( 'maxAmount', $exInfo['currencyCode'] .
                                                             $exInfo['currencySymbol'] . $exInfo['max_amount'],
                                                'LANG_MAX_AMOUNT_CLAIMABLE' );
            }
        }
        else {
            $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_CLAIM_TYPE') );
            return false;
        }
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

        if( $results ) {
            foreach( $results as $key => $row ) {
                if( isset( $row['countryID'] ) && $row['countryID'] ) {
                    $results[$key]['max_amount'] = $row['currencyCode'] .
                                                   $row['currencySymbol'] . Money::format( $row['max_amount'] );
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
     * Return user data by userID
     * @return mixed
     */
    public function getAllItems( $data ) {
        return $this->Expense->getList( $data['office']['countryID'] );
    }


    /**
     * Get File Information
     * @return mixed
     */
    public function saveExpenseType( $data ) {
        $eiID = (int)$data['eiID'];
        $this->info['title'] = Validator::stripTrim( $data['expenseTitle'] );
        $this->info['countryID'] = (int)$data['expenseCountry'];
        $this->info['max_amount'] = Validator::stripTrim( $data['expenseAmount'] );

        $CountryModel = CountryModel::getInstance( );

        if( !$CountryModel->isFound( $this->info['countryID'] ) ) {
            $this->setErrMsg( $this->L10n->getContents('LANG_INVALID_COUNTRY') );
            return false;
        }

        $this->info['max_amount'] = preg_replace("/[^0-9]/",'', $this->info['max_amount'] );

        if( $this->isFoundByeiID( $eiID ) ) {
            $this->Expense->update( 'expense_item', $this->info, 'WHERE eiID = "' . (int)$eiID . '"' );
            $this->info['eiID'] = $eiID;
        }
        else {
            $this->info['eiID'] = $this->Expense->insert('expense_item', $this->info );
        }
        return $this->info['eiID'];
    }


    /**
     * Return total count of records
     * @return int
     */
    public function deleteExpense( $data ) {
        if( isset( $data['eiID'] ) ) {
            return $this->Expense->update('expense_item', array( 'deleted' => 1 ), 'WHERE eiID = "' . (int)$data['eiID'] . '"');
        }
    }
}
?>