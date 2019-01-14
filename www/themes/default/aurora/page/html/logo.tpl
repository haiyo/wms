<style>
#logoWrapper {
    padding:10px;
}
#box {
    border:1px solid #ccc;
    width:500px;
    margin:auto;
    margin-top:25px;
    height:90px;
    background:#efefef;
    position:relative;
}
.progressBar {
    position:absolute;
    width:0%;
    height:90px;
    background:#caed77;
    opacity: 0.8;
    filter: alpha(opacity=80);
}
#noImage {
    font-size:25px;
    text-align:center;
    text-transform:uppercase;
    color:#ccc;
    margin-top:30px;
    position:absolute;
    width:100%;
}
.fileinput-button {
    position: absolute;
    overflow: hidden;
    float: left;
    width:500px;
    height:92px;
    top:-2px;
}
.fileinput-button input {
    border-width: 0 0 100px 500px;
    opacity: 0;
    filter: alpha(opacity=0);
    -moz-transform: translate(-300px, 0) scale(4);
    direction: ltr;
    cursor: pointer;
    outline: none;
    width:1px;
}
</style>
<div id="logoWrapper">
  <?LANG_DESCRIPTION?>
  <div id="box">
    <div class="progressBar"></div>
    <div id="preview">
      <div id="noImage"><?LANG_NO_IMAGE?></div>
      <img src="<?TPLVAR_LOGO?>" id="logoImage" border="0" />
      <input type="hidden" id="logo" value="<?TPLVAR_LOGO?>" />
    </div>
    <div class="fileinput-button">
      <input type="file" name="auroraLogo" id="auroraLogo" />
    </div>
  </div>
</div>
