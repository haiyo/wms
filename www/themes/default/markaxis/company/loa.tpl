<style>
    body {
        font-family: Arial;
        font-size:10pt !important;
    }
    .td{padding:50px;}
    .title{font-weight:bold;}
</style>

<table cellspacing="0" cellpadding="0" width="100%" border="0" class="table" style="margin-bottom:50px;">
    <tr>
        <td valign="top"><img src="<?TPLVAR_LOGO?>" width="250" /></td>
        <td style="text-align:right;">
            <h3>LETTER OF APPOINTMENT</h3>
            <?TPLVAR_COMPANY_NAME?><br />
            <!-- BEGIN DYNAMIC BLOCK: address -->
            <?TPLVAR_COMPANY_ADDRESS?><br />
            <!-- END DYNAMIC BLOCK: address -->
            <!-- BEGIN DYNAMIC BLOCK: phone -->
            <?TPLVAR_COMPANY_PHONE?><br />
            <!-- END DYNAMIC BLOCK: phone -->
            <!-- BEGIN DYNAMIC BLOCK: website -->
            <?TPLVAR_COMPANY_WEBSITE?><br />
            <!-- END DYNAMIC BLOCK: website -->
            <!-- BEGIN DYNAMIC BLOCK: regNumber -->
            Company Registration No. <?TPLVAR_COMPANY_REGNUMBER?>
            <!-- END DYNAMIC BLOCK: regNumber -->
        </td>
    </tr>
</table>

<?TPLVAR_CONTENT?>
