<script>
$(document).ready( function( ) {
    
    
    $(".nodeExpand").live("click", function( ) {
        var id = $(this).attr("id");
        
        if( $(this).hasClass("expand") ) {
            $("#details_" + id).show( );
            $(this).addClass("collapse").removeClass("expand");
            this.src = Aurora.ROOT_URL + "www/themes/admin/jquery/images/classic/dataTables/collapse.png";
            //
            //oTable.fnClose( nTr );
        }
        else {
            $("#details_" + id).hide( );
            this.src = Aurora.ROOT_URL + "www/themes/admin/jquery/images/classic/dataTables/expand.png";
            $(this).addClass("expand").removeClass("collapse");
            //oTable.fnOpen( nTr, fnFormatDetails($(this).attr("id")), 'details' );
            //$("#detail_" + id).fadeIn("slow");
        }
        return false;
    });

    /* Formating function for row details */
    function fnFormatDetails ( id ) {
        var sOut = '<table cellpadding="2" cellspacing="0" border="0" width="100%" style="padding-left:40px; display:none;" id="detail_' + id + '">';
        sOut += '<tr><td width="50"><strong>Description:</strong></td><td>' + $("#descript_" + id).val( ) + '</td></tr>';
        sOut += '<tr><td><strong>Publisher:</strong></td><td><a href="' + $("#website_" + id).val( ) + '" target="_blank">' + $("#website_" + id).val( ) + '</a></td></tr>';
        sOut += '<tr><td colspan="2"><div class="buttons" style="float:left;"><button type="submit" id="update' + id + '" class="update" value="' + id + '">' + Aurora.i18n.AppRes.LANG_CHECK_UPDATE + '</button><button type="submit" id="visit' + id + '" class="visit" style="display:none;">' + Aurora.i18n.AppRes.LANG_VIEW_CHANGELOG + '</button><span id="upgrade' + id + '"></span><button type="submit" class="orange backup" value="' + id + '">' + Aurora.i18n.AppRes.LANG_BACKUP_DATA + '</button><button type="submit" class="orange restore" value="' + id + '">' + Aurora.i18n.AppRes.LANG_RESTORE_DATA + '</button><button type="submit" class="delete uninstall" value="' + id + '">' + Aurora.i18n.AppRes.LANG_UNINSTALL + '</button></div></td></tr>';
        sOut += '</table>';
        return sOut;
    }
    
    $(".uninstall").live("click", function( ) {
        alert($(this).attr("value"))
    });

    $(".update").live("click", function( ) {
        $(this).html( Aurora.UI.showSpinner( Aurora.i18n.AppRes.LANG_CHECK_UPDATE ) );
        $(this).attr("disabled", true);

        var data = {
            bundle: { "appID" : $(this).attr("value") },
            beforeSend: false,
            success: function( res ) {
                var obj = $.parseJSON( res );
                $(".update").html( Aurora.i18n.AppRes.LANG_CHECK_UPDATE );
                $(".update").attr("disabled", false);
                if( $("#version_" + obj.appID ).text( ) != obj.version ) {
                    $("#version_" + obj.appID).val( obj.version );
                    $("#upgrade" + obj.appID).html( '<button type="submit" class="upgrade" value="' + obj.appID + '">' + Aurora.i18n.AppRes.LANG_UPGRADE + ' ' + obj.version + '</button>' );
                    $("#update" + obj.appID).hide( );
                    $("#visit" + obj.appID).show( ).attr("onclick","openWindow('" + obj.website + "')");
                    alert( "A new update version " + obj.version + " is available." +
                           "\r\n\r\nClick the View Changelog button to visit the publisher's website for more information on this upgrade " +
                           "or click the Upgrade button to start the upgrade process." );
                }
                else {
                    alert("Application is up to date.")
                    $("#upgrade" + obj.appID).html("");
                }
            }
        };
        Aurora.WebService.AJAX( "admin/appstore/checkUpdate", data );
    });

    $(".backup").live("click", function( ) {
        var appID = $(this).attr("value");
        if( confirm( "You've selected to backup the " + $("#title_" + appID).html( ) + " data. " +
                     "All database data and uploaded materials related to this application will be " +
                     "consolidated into a zip file. You will be prompt to download the file to your computer." +
                     "\r\n\r\nDo you want to continue?" ) ) {
            $(this).html( Aurora.UI.showSpinner( Aurora.i18n.AppRes.LANG_BACKUP_DATA ) ).attr("disabled", true);

            var data = {
                bundle: { "appID" : appID },
                beforeSend: function( ) {
                    $("#spinner").html( Aurora.UI.showSpinner( "Consolidating data..." ) );
                },
                success: function( res ) {
                    var obj = $.parseJSON( res );
                    if( obj.bool == 0 ) {
                        alert(obj.errMsg);
                        $("#spinner").html("");
                    }
                    else {
                        var iframe = document.createElement("iframe");
                        iframe.src = Aurora.ROOT_URL + "admin/appstore/getData/" + obj.hash;
                        iframe.onload = function( ) {}
                        iframe.style.display = "none";
                        document.body.appendChild(iframe);
                        $("#spinner").html("");
                        $(".backup").html( Aurora.i18n.AppRes.LANG_BACKUP_DATA ).attr("disabled", false );
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/appstore/backupData", data );
        }
    });

    function fileDownloaded( ) {
        alert("d")
    }

    $(".upgrade").live("click", function( ) {
        var appID = $(this).attr("value");
        if( confirm( "You've selected to upgrade " + $("#title_" + appID).html( ) + " to version " + $("#version_" + $(this).attr("value")).val( ) + "." +
                     "\r\n\r\nNOTE: Make sure you have already tried upgrading this application on a development " +
                     "Aurora platform and has confirmed the application work as expected before upgrading on the " +
                     "production platform. Backing up your data is also strongly recommended before proceed." +
                     "\r\n\r\nDuring the upgrade process, all database tables related to this application will be locked " +
                     "to prevent data corruption. Application itself will not be usable until it is fully upgraded." +
                     "\r\n\r\nClick OK to begin with the upgrade." ) ) {

            $(this).html( Aurora.UI.showSpinner( Aurora.i18n.AppRes.LANG_UPGRADE ) ).attr("disabled", true);

            var data = {
                bundle: { "appID" : appID },
                beforeSend: function( ) {
                    $("#spinner").html( Aurora.UI.showSpinner( "Verifying license information..." ) );
                },
                success: function( res ) {
                    var obj = $.parseJSON( res );
                    if( obj.license == 1 ) {
                        $("#spinner").html( Aurora.UI.showSpinner( "Downloading upgrade..." ) );
                        $(".backup").attr("disabled", true );
                        $(".restore").attr("disabled", true );
                        $(".uninstall").attr("disabled", true );
                    }
                    else {
                        $(".upgrade").html( Aurora.i18n.AppRes.LANG_UPGRADE );
                        $(".upgrade").attr("disabled", false);
                        $("#spinner").html("");
                        alert("Invalid license.")
                    }
                }
            };
            Aurora.WebService.AJAX( "admin/appstore/checkLicense", data );
        }
    });
});
function openWindow( website ) {
    window.open(website)
}
</script>
<div class="serverInfo"><strong>Powered by:</strong> Aurora Core 2.0</div>
<div id="mainWrapper">
  <div id="main">
    <div style="width:100%; height:50px; padding: 10px; margin-bottom: 25px;">
      The following list display the applications already installed in Aurora. You may check for updates release for
      a specific application, backup the application data or to uninstall the application. To browse and install new
      application, click on the <strong>Browse App Store</strong> link.
    </div>
    <table id="tableMain" width="100%" cellspacing="0" cellpadding="5">
      <thead>
        <tr>
          <th width="10%">&nbsp;</th>
          <th width="59%">Name</th>
          <th>Installed</th>
          <th>Version</th>
        </tr>
      </thead>
    </table>
    <div style="float:left; padding:10px 5px; margin-top:1px; width: 100%; height: 393px; overflow:auto;">
    <table id="tableApps" class="" width="558" cellspacing="0" cellpadding="5">
      <!-- BEGIN DYNAMIC BLOCK: app -->
      <tr>
        <td width="10%" valign="top" align="center"><img src="<?TPLVAR_ROOT_URL?>www/themes/admin/jquery/img/classic/dataTables/expand.png" border="0" class="nodeExpand expand" id="<?TPLVAR_APPID?>" style="cursor:pointer;" /></td>
        <td width="60%"><span id="title_<?TPLVAR_APPID?>" class="title"><?TPLVAR_TITLE?></span>
            <div id="details_<?TPLVAR_APPID?>" style="display:none; width: 320px; padding:10px 0;">
            <?TPLVAR_DESCRIPT?>
            <a href="<?TPLVAR_WEBSITE?>" target="_blank">Visit site</a>
            </div>
        </td>
        <td width="18%"><?TPLVAR_INSTALLED_ON?></td>
        <td id="version_<?TPLVAR_APPID?>"><?TPLVAR_VERSION?></td>
      </tr>
      <!-- END DYNAMIC BLOCK: app -->
    </table>
    </div>
  </div>
</div>
<div id="sidebar">
  <h2>Applications</h2>
  <p id="" class="link active"><a href="" id="link">Installed Apps</a></p>
  <p id="" class="link"><a href="" id="link">Upload Zip File</a></p>
  <h2>Browse App Store</h2>
  <p id="" class="link"><a href="" id="link">Newly Added</a></p>
  <p id="" class="link"><a href="" id="link">Popular Downloads</a></p>
  <h2>Aurora Update</h2>
  <p id="" class="link"><a href="" id="link">Core Version Update</a></p>
  <p id="" class="link"><a href="" id="link">Aurora Themes</a></p>
  <p id="" class="link"><a href="" id="link">Aurora Language Packs</a></p>
</div>