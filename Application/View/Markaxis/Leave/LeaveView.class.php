<?php
namespace Markaxis\Leave;
use \Markaxis\Employee\EmployeeModel;
use \Aurora\User\UserImageModel;
use \Markaxis\Employee\LeaveBalanceModel;
use \Aurora\Admin\AdminView;
use \Library\Util\Date;
use \Library\Runtime\Registry;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: LeaveView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class LeaveView {


    // Properties
    protected $Registry;
    protected $i18n;
    protected $L10n;
    protected $View;
    protected $LeaveModel;


    /**
    * LeaveView Constructor
    * @return void
    */
    function __construct( ) {
        $this->View = AdminView::getInstance( );
        $this->Registry = Registry::getInstance( );
        $this->i18n = $this->Registry->get(HKEY_CLASS, 'i18n');
        $this->L10n = $this->i18n->loadLanguage('Markaxis/Leave/LeaveRes');

        $this->LeaveModel = LeaveModel::getInstance( );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderBalance( $output ) {
        $this->View->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js',
                                                                              'checkboxes.min.js',
                                                                              'mark.min.js'),
                                        'plugins/visualization/d3' => array( 'd3.min.js', 'd3_tooltip.js' ),
                                        'jquery' => array( 'mark.min.js' ),
                                        'markaxis' => 'leave.js',
                                        'locale' => $this->L10n->getL10n( ) ) );

        $vars = array_merge( $this->L10n->getContents( ), array( ) );

        $this->View->setTitle( $this->L10n->getContents('LANG_LEAVE_BALANCE_STATUS') );
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'mi-schedule',
                                            'text' => $this->L10n->getContents('LANG_LEAVE_BALANCE_STATUS') ) );

        $vars['dynamic']['balChart'] = false;

        $TypeModel = TypeModel::getInstance( );
        $chartList = $TypeModel->getByChart( );

        $LeaveBalanceModel = LeaveBalanceModel::getInstance( );
        $EmployeeModel = EmployeeModel::getInstance( );
        $empInfo = $EmployeeModel->getInfo( );
        $id = 0;

        $colors = array( );
        $colors[] = array( '458AF2', 'c3d8f8' );
        $colors[] = array( 'EC407A', 'fad0df' );
        $colors[] = array( 'ffaf23', 'fee8c8' );
        $colors[] = array( '70b754', 'd4f1c8' );

        foreach( $chartList as $ltID => $name ) {
            $balInfo = $LeaveBalanceModel->getByltIDUserID( $ltID, $empInfo['userID'] );

            if( $balInfo['elbID'] ) {
                $vars['dynamic']['balChart'][] = array( 'TPLVAR_ID' => $id,
                                                        'TPLVAR_LEAVE_NAME' => $name,
                                                        'TPLVAR_BALANCE' => (float)$balInfo['balance'],
                                                        'TPLVAR_TOTAL_APPLIED' => (float)$balInfo['totalConsumed'],
                                                        'TPLVAR_TOTAL_PENDING' => (float)$balInfo['totalPending'],
                                                        'TPLVAR_TOTAL_LEAVES' => (float)$balInfo['totalLeaves'],
                                                        'TPLVAR_COLOR_1' => $colors[0][0],
                                                        'TPLVAR_COLOR_2' => $colors[0][1] );
                array_shift($colors);
                $id++;
            }
        }

        $vars['TPL_CONTENT'] = '';
        if( isset( $output['content'] ) ) {
            $vars['TPL_CONTENT'] = $output['content'];
        }
        if( isset( $output['js'] ) ) {;
            $this->View->setJScript( $output['js'] );
        }

        $this->View->printAll( $this->View->render( 'markaxis/leave/balance.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderSettings( $form ) {
        $vars = array_merge( $this->L10n->getContents( ), array( 'TPL_FORM' => $form ) );

        $this->View->setTitle( $this->L10n->getContents('LANG_LEAVE_SETTINGS') );
        $this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-cog2',
                                            'text' => $this->L10n->getContents('LANG_LEAVE_SETTINGS') ) );

        $this->View->setJScript( array( 'plugins/tables/datatables' => array( 'datatables.min.js', 'checkboxes.min.js', 'mark.min.js'),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );

        $this->View->printAll( $this->View->render( 'markaxis/leave/settings.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return string
     */
    public function renderTypeForm( $form, $ltID=0 ) {
        $this->View->setJScript( array( 'plugins/forms' => array( 'wizards/stepy.min.js' ),
                                        'plugins/forms/selects' => array( 'bootstrap_multiselect.js' ),
                                        'plugins/buttons' => array( 'spin.min.js', 'ladda.min.js' ),
                                        'jquery' => array( 'mark.min.js', 'jquery.validate.min.js' ) ) );

        $vars = array_merge( $this->L10n->getContents( ),
                array( 'TPLVAR_LEAVE_TYPE_ID' => $ltID,
                       'TPL_FORM' => $form ) );

        $this->View->setTitle( $this->L10n->getContents('LANG_LEAVE_TYPE_SETTINGS') );
        $this->View->setBreadcrumbs( array( 'link' => 'settings',
                                            'icon' => 'icon-cog2',
                                            'text' => $this->L10n->getContents('LANG_LEAVE_SETTINGS') ) );

        /*$this->View->setBreadcrumbs( array( 'link' => '',
                                            'icon' => 'icon-file-plus2',
                                            'text' => $this->L10n->getContents('LANG_CREATE_NEW_LEAVE_TYPE') ) );*/

        $this->View->printAll( $this->View->render( 'markaxis/leave/typeFormWrapper.tpl', $vars ) );
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderDateDiff( $data ) {
        if( isset( $data['startDate'] ) && isset( $data['endDate'] ) && $data['startDate'] && $data['endDate'] ) {
            $days = (int)$this->LeaveModel->getDateDiff( $data['startDate'], $data['endDate'] );

            return array( 'days' => $days,
                          'text' => $this->L10n->getText( 'LANG_APPLY_DAYS', $days ) );
        }
    }


    /**
     * Render main navigation
     * @return mixed
     */
    public function renderRequest( $request ) {
        if( is_array( $request ) ) {
            $vars = array_merge( $this->L10n->getContents( ), array( ) );

            foreach( $request as $row ) {
                $created = Date::timeSince( $row['created'] );

                $pdVars = array_merge( $this->L10n->getContents( ), array( ) );

                $pdVars['dynamic']['reason'] = false;

                if( $row['reason'] ) {
                    $pdVars['dynamic']['reason'][] = array( 'TPLVAR_REASON' => $row['reason'] );
                }

                if( $row['status'] == 0 ) {
                    $label = 'pending';
                    $status = $this->View->getGlobalRes( )->getContents('LANG_PENDING');
                }
                else if( $row['status'] == 1 ) {
                    $label = 'success';
                    $status = $this->View->getGlobalRes( )->getContents('LANG_APPROVED');
                }
                else {
                    $label = 'danger';
                    $status = $this->View->getGlobalRes( )->getContents('LANG_UNAPPROVED');
                }

                $managers = '';

                if( isset( $row['managers'] ) ) {
                    foreach( $row['managers'] as $manager ) {
                        if( $manager['approved'] == 0 ) {
                            $managers .= '<i class="icon-watch2 text-grey-300 mr-3"></i>';
                        }
                        else if( $manager['approved'] == 1 ) {
                            $managers .= '<i class="icon-checkmark4 text-green-800 mr-3"></i>';
                        }
                        else if( $manager['approved'] == "-1" ) {
                            $managers .= '<i class="icon-cross2 text-warning-800 mr-3"></i>';
                        }
                        $managers .= $manager['name'] . '<br />';
                    }
                }

                $pdVars['TPLVAR_START_DATE'] = $row['startDate'];
                $pdVars['TPLVAR_END_DATE'] = $row['endDate'];
                $reason = $this->View->render( 'markaxis/leave/pending_description.tpl', $pdVars );

                $attachment = '';
                if( $row['uID'] ) {
                    $attachment = '<a target="_blank" href="' . ROOT_URL . 'admin/file/view/leave/' . $row['uID'] .
                        '/' . $row['hashName'] . '"><i class="icon-attachment text-grey-300 mr-3"></i> ' . $row['uploadName'] . '</a>';
                }

                $vars['dynamic']['list'][] = array( 'TPLVAR_TIME_AGO' => $created,
                                                    'TPLVAR_ID' => $row['laID'],
                                                    'TPLVAR_GROUP_NAME' => 'leave',
                                                    'TPLVAR_CLASS' => 'cancelApplyLeave',
                                                    'TPLVAR_TITLE' => $row['name'] . ' (' . $row['code'] . ')',
                                                    'TPLVAR_DESCRIPTION' => $reason,
                                                    'TPLVAR_VALUE' => $row['days'] . ' ' . $this->L10n->getContents('LANG_DAYS'),
                                                    'TPLVAR_LABEL' => $label,
                                                    'TPLVAR_MANAGER' => $managers,
                                                    'TPLVAR_ATTACHMENT' => $attachment,
                                                    'LANG_STATUS' => $status );
            }
            return $this->View->render( 'aurora/page/tableRowRequest.tpl', $vars );
        }
    }
}
?>