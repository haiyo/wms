<strong>Organisation Name:</strong> <?TPLVAR_COMPANY_NAME?><br />
<strong>Organisation Tax Ref No.:</strong> <?TPLVAR_REG_NUMBER?><br />
<strong>File For Year:</strong> <?TPLVAR_FILE_YEAR?><br />

<!-- BEGIN DYNAMIC BLOCK: ErrorDescript -->
There are some errors return from IRAS during validation process. Please identify each employee record below to rectify the problem.
<!-- END DYNAMIC BLOCK: ErrorDescript -->

<!-- BEGIN DYNAMIC BLOCK: PassDescript -->
The income tax filing has been successfully submitted to IRAS. Below are the information for future reference.
<!-- END DYNAMIC BLOCK: PassDescript -->
<hr style="margin-left:0;" />

<!-- BEGIN DYNAMIC BLOCK: A8A -->
<h3>Appendix 8A</h3>
<!-- END DYNAMIC BLOCK: A8A -->

<!-- BEGIN DYNAMIC BLOCK: A8AErrorSet -->
<p><?TPLVAR_FNAME?> <?TPLVAR_LNAME?> (<?TPLVAR_NRIC?>)</p>

<?TPLVAR_ERROR?>
<!-- END DYNAMIC BLOCK: A8AErrorSet -->

<br />
<!-- BEGIN DYNAMIC BLOCK: IR8A -->
<h3>IR8A</h3>
<!-- END DYNAMIC BLOCK: IR8A -->

<!-- BEGIN DYNAMIC BLOCK: IR8AErrorSet -->
<p><?TPLVAR_FNAME?> <?TPLVAR_LNAME?> (<?TPLVAR_NRIC?>)</p>

<?TPLVAR_ERROR?>
<!-- END DYNAMIC BLOCK: IR8AErrorSet -->