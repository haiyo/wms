<?php
namespace Aurora\Form;

/**
 * @author Andy L.W.L <support@markaxis.com>
 * @since Monday, September 27, 2010
 * @version $Id: UserMultiListView.class.php, v 2.0 Exp $
 * @copyright Copyright (c) 2010, Markaxis Corporation
 */

class UserMultiListView extends MultiListView {


    // Properties


    /**
    * UserMultiListView Constructor
    * @return void
    */
    function __construct( ) {
        parent::__construct( );
	}


    /**
    * Build Multi List
    * @return string
    */
    public function build( $name, $arrayList, $selected='' ) {
        $vars = array( 'TPLVAR_NAME'  => $name,
                       'TPLVAR_CLASS' => $this->class );
        $label = 1;
        $option = array( );

        $UserAvatarView = new UserAvatarView( );

        foreach( $arrayList as $value => $key ) {
            if( $value === 'total' ) break;
            $select = '';
            if( $selected != '' ) {
                if( $selected == $key['userID'] ) {
                	$select = ' checked="checked"';
    	        }
                else if( is_array( $selected ) && in_array( $key['userID'], $selected ) ) {
                	$select = ' checked="checked"';
    	        }
            }
            /*if( $key['image'] == '' ) {
                $image = $key['gender'] == 'm' ? 'male50x50.png' : 'female50x50.png';
                $image = 'www/themes/' . $this->theme . '/img/user/' . $image;
            }
            else {
                $image = explode( '.', $key['image'] );
                $image = PROFILE_DIR . $key['userID'] . '/' . $image[0] . '_small.' . $image[1];
            }*/
            $option[] = array( 'TPLVAR_LIST_ID' => $name . $label,
                               'TPLVAR_SELECT'  => $select,
                               //'TPLVAR_IMAGE'   => $image,
                               'TPL_AVATAR'     => $UserAvatarView->renderAvatar( $key, 'micro' ),
                               'TPLVAR_USERID'  => $key['userID'],
                               'TPLVAR_FNAME'   => $key['fname'],
                               'TPLVAR_LNAME'   => $key['lname'] );
            $label++;
        }
        $vars['dynamic']['list'] = $option;
        return $this->render( 'aurora/form/html/userMultilist.tpl', $vars );
    }
}
?>