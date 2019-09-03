<style>
    .td{padding:50px;}
    .title{font-weight:bold;}
</style>

<table cellspacing="0" cellpadding="0" width="100%" border="0" class="table" style="margin-bottom:50px;">
    <tr>
        <td valign="top"><img src="<?TPLVAR_LOGO?>" width="250" /></td>
        <td style="text-align:right;">
            <h2>PAYSLIP</h2>
            Markaxis Private Limited<br />30 Pasir Panjang #07-35<br />Singapore 435344<br />Tel: 6744 5439</td>
    </tr>
</table>

<table cellspacing="0" cellpadding="0" width="100%" border="0" class="table">
    <tr>
        <td width="20%" style="padding:2px;" class="title">Employer Name:</td>
        <td width="42%"><?TPLVAR_FNAME?> <?TPLVAR_LNAME?></td>
        <td width="20%" style="padding:2px;" class="td title">Join Date:</td>
        <td width="23%"><?TPLVAR_START_DATE?></td>
    </tr>
    <tr>
        <td style="padding:2px;" class="td title">Department:</td>
        <td><?TPLVAR_DEPARTMENT?></td>
        <td style="padding:2px;" class="td title">Contract Type:</td>
        <td><?TPLVAR_CONTRACT_TYPE?></td>
    </tr>
    <tr>
        <td style="padding:2px;" class="td title">Designation:</td>
        <td><?TPLVAR_DESIGNATION?></td>
        <td style="padding:2px;" class="td title">Pay Period:</td>
        <td><?TPLVAR_PAY_PERIOD?></td>
    </tr>
</table>

<table cellspacing="0" cellpadding="0" width="100%" border="0" class="table" style="margin:50px 0;">
    <tr>
        <td class="title" style="padding:5px;background-color:#efefef;">Item Type</td>
        <td class="title" style="padding:5px;background-color:#efefef;">Amount</td>
        <td class="title" style="padding:5px;background-color:#efefef;">Remark</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <!-- BEGIN DYNAMIC BLOCK: item -->
    <tr>
        <td style="padding:5px;padding-bottom:10px;border-bottom:1px solid #ccc;"><?TPLVAR_PAYROLL_ITEM?></td>
        <td style="padding:5px;padding-bottom:10px;margin-bottom:5px;border-bottom:1px solid #ccc;"><?TPLVAR_AMOUNT?></td>
        <td style="padding:5px;padding-bottom:10px;margin-bottom:5px;border-bottom:1px solid #ccc;"><?TPLVAR_REMARK?></td>
    </tr>
    <!-- END DYNAMIC BLOCK: item -->
</table>

<table cellspacing="0" cellpadding="0" width="100%" border="0" class="table">
    <tr>
        <td class="title" style="padding:5px;text-align:right;width:80%;">Total Gross:</td>
        <td style="padding:5px;"><?TPLVAR_CURRENCY?><?TPLVAR_GROSS_AMOUNT?></td>
    </tr>
    <!-- BEGIN DYNAMIC BLOCK: deductionSummary -->
    <tr>
        <td class="title" style="padding:5px;text-align:right;"><?TPLVAR_TITLE?>:</td>
        <td style="padding:5px;"><?TPLVAR_CURRENCY?><?TPLVAR_AMOUNT?></td>
    </tr>
    <!-- END DYNAMIC BLOCK: deductionSummary -->
    <tr>
        <td class="title" style="padding:5px;text-align:right;">Total Net Payable:</td>
        <td style="padding:5px;"><?TPLVAR_CURRENCY?><?TPLVAR_NET_AMOUNT?></td>
    </tr>
</table>