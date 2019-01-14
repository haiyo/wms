<style>
.profileWrapper {
    float:left;
    width:100%;
    background:url(../../../../../../../../www/themes/admin/aurora/user/img/classic/en_us/profileHeaderBg.png) repeat-x;
}
.sidebar {
    float:left;
    width:160px;
    text-align:center;
    padding: 10px;
}

.sideBarLink {
    margin:10px 0 0 0px;
	list-style: none;
	padding-left: 1em;
    text-indent:5px;
}

.sideTitle {
    width:200px;
    min-height:1px; /* force empty div to take up space */
    margin-right:10px;
    font-weight:bold;
    color:#88201b;
    text-align:right;
}

.data { width:400px; }
.leftButton { float:left; }

.main {
    float:left;
    width:675px;
    padding: 10px 0;
}

.mainData {
    width:100%;
    float:left;
    margin-bottom:5px;
}

.nameTitle {
    font-size:26px;
    margin:0 0 3px 10px;
    color:#fff;
    text-shadow: 1px 1px 0px #000;
}

.jobTitle {
    font-size:18px;
    margin:0px 0px 20px 10px;
    color:#fff;
    text-shadow: 1px 1px 0px #000;
}

.statusCaption {
    float:left;
    margin:0px 0px 20px 10px;
}

.statusUpdate {
    float:left;
    color:#666;
}

.eventTabs {
	float: left;
	list-style: none;
	height: 14px;
	padding-left: 0px;
    margin-top:15px;
	width: 100%;
    font-weight:bold;
}
.eventTabs li {
	float: left;
	margin: 0;
	padding: 0;
	height: 29px;
	line-height: 25px;
	border: 1px solid #999;
    border-left: none;
	overflow: hidden;
	position: relative;
	background: #e0e0e0;
}
.eventTabs li:first-child {
    margin-left:10px;
}
/*.eventTabs li:last-child {
    width: 153px;
    border-top: none;
    border-right: none;
    background: transparent;
}*/
.eventTabs li a {
	text-decoration: none;
	color: #333;
	display: block;
	padding: 0 10px;
	border: 1px solid #fff;
    border-bottom:none;
	outline: none;
}
.eventTabs li a:hover {
	background: #ccc;
}
.eventTabs li.active {
	background: #fff;
	border-bottom: 1px solid #fff;
}
.eventTabs li.active a:hover  {
    background:#fff;
}
.eventTabs .first {
    border-left: 1px solid #999;
}
.eventTabs .spacer {
    float: left;
    width:1px;
    border:none;
    background: #fff;
}
.tabContainer {
	overflow:auto;
	clear: both;
	float: left;
    width: 100%;
    height:412px;
    padding:10px;
    margin-top: 2px;
    border-top:1px solid #999;
}

.tabContent {
    float:left;
    width:100%;
}

.edit a {
    display:block;
	text-indent:-9999px;
}
.edit {
    display:inline-block;
    width:10px;
	height:10px;
    margin: 3px 0 0 5px;
    background:url(../../../../../../../../www/themes/admin/aurora/core/img/classic/en_us/imageset.png);
    background-position: -60px -69px;
}
.edit:hover { background-position: -70px -69px; }

.editButton {
    padding:2px 2px 2px 2px;
    margin-right:10px;
    float:right;
    font-weight:bold;
    font-size:11px;
    color:#999;
    display:block;
}
.editButton:link { color:#999; text-decoration:none; }
.editButton:active  { color:#666; text-decoration:none; }
.editButton:visited { color:#999; text-decoration:none; }
.editButton:hover { color:#666; text-decoration:none; }

.editIco {
    width:10px;
	height:10px;
    background:url(../../../../../../../../www/themes/admin/aurora/core/img/classic/en_us/imageset.png);
    background-position: -60px -69px;
}

.hr {
    float:left;
    background-color:#ccc;
    height:1px;
    width:100%;
    margin:10px 0 10px 0;
}

.titleBar {
    float:left;
    width:100%;
    margin:10px 0 10px 0;
    border-bottom:1px solid #ccc;
}

.title { font-weight:bold; color:#999; }
.title a:link { color:#999; text-decoration:none; }
.title a:active  { color:#666; text-decoration:none; }
.title a:visited { color:#999; text-decoration:none; }
.title a:hover { color:#666; text-decoration:none; }

.formTitle { color:#88201b; }

.linkSep {
    float:left;
    width:100%;
    margin-bottom:6px;
    font-size:11px;
    text-decoration:none;
}
.linkSep a:link { }
.linkSep a:hover { }
.linkSep a:visited { text-decoration:none; }
.linkSep a:active { text-decoration:none; }

.linkInactive a:link { color:#666; }
.linkInactive a:hover { color:#0033FF; text-decoration:none; }
.linkInactive a:visited { color:#666; text-decoration:none; }
.linkInactive a:active { color:#666; text-decoration:none; }

.contactInput {
    float:left;
    width:370px;
}

.typeList {
    float:right;
    width:120px;
}

.projForm {
    float:left;
    margin-top:10px;
    background-color:#efefef;
    display:none;
}

.projTitle {
    width:80px;
    text-align:right;
    font-weight:bold;
}

.projInput {
    width:370px;
    padding-right:15px;
}

.profileInput {
    margin-top:0px;
}

.unspecified { font-style:italic; color:#999; }

.dataTable {
    border:1px solid #ccc;
    border-collapse: collapse;
}
.btn.btnAction {
    color: #fff;
    border: 1px solid #0f467f;
    border-bottom-color: #0f467f;
    background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #4c9bea), color-stop(100%, #1460ac));
    background-image: -webkit-linear-gradient(#4c9bea, #1460ac);
    background-image: -moz-linear-gradient(#4c9bea, #1460ac);
    background-image: -o-linear-gradient(#4c9bea, #1460ac);
    background-image: -ms-linear-gradient(#4c9bea, #1460ac);
    background-image: linear-gradient(#4c9bea, #1460ac);
    -moz-box-shadow: inset 0 1px 0 #7ab5f0, 0px 1px 5px rgba(0, 0, 0, 0.55);
    -webkit-box-shadow: inset 0 1px 0 #7ab5f0, 0px 1px 5px rgba(0, 0, 0, 0.55);
    -o-box-shadow: inset 0 1px 0 #7ab5f0, 0px 1px 5px rgba(0, 0, 0, 0.55);
    box-shadow: inset 0 1px 0 #7ab5f0, 0px 1px 5px rgba(0, 0, 0, 0.55);
}
.btn {
  display: inline-block;
  position: relative;
  color: #fff;
  font-size:14px;
  font-weight: bold;
  text-shadow: 0 -1px 0 #004e87, 0 1px 0 #0059b0;
  text-decoration: none;
  padding:5px 16px;
  border: 1px solid #0f467f;
  border-bottom-color: #0f467f;
  cursor: pointer;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  -o-border-radius: 4px;
  -ms-border-radius: 4px;
  -khtml-border-radius: 4px;
  border-radius: 4px;
}
.btn:hover, .btn:focus {
  color: #fff;
  text-decoration:none;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #3d93e9), color-stop(100%, #1460ac));
  background-image: -webkit-linear-gradient(#3d93e9, #1460ac);
  background-image: -moz-linear-gradient(#3d93e9, #1460ac);
  background-image: -o-linear-gradient(#3d93e9, #1460ac);
  background-image: -ms-linear-gradient(#3d93e9, #1460ac);
  background-image: linear-gradient(#3d93e9, #1460ac);
}
.btn:active {
  -moz-box-shadow: inset 0 1px 0 #1460ac, 0px 1px 5px rgba(0, 0, 0, 0.55);
  -webkit-box-shadow: inset 0 1px 0 #1460ac, 0px 1px 5px rgba(0, 0, 0, 0.55);
  -o-box-shadow: inset 0 1px 0 #1460ac, 0px 1px 5px rgba(0, 0, 0, 0.55);
  box-shadow: inset 0 1px 0 #1460ac, 0px 1px 5px rgba(0, 0, 0, 0.55);
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #12579d), color-stop(100%, #1460ac));
  background-image: -webkit-linear-gradient(#12579d, #1460ac);
  background-image: -moz-linear-gradient(#12579d, #1460ac);
  background-image: -o-linear-gradient(#12579d, #1460ac);
  background-image: -ms-linear-gradient(#12579d, #1460ac);
  background-image: linear-gradient(#12579d, #1460ac);
}
.btn.btn-gray {
  text-shadow: 0 -1px 0 white;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #ffffff), color-stop(100%, #999999));
  background-image: -webkit-linear-gradient(#ffffff, #999999);
  background-image: -moz-linear-gradient(#ffffff, #999999);
  background-image: -o-linear-gradient(#ffffff, #999999);
  background-image: -ms-linear-gradient(#ffffff, #999999);
  background-image: linear-gradient(#ffffff, #999999);
  border-color: #a8b0b3;
  color: #666;
  -moz-box-shadow: inset 0 3px 0 white, 0 1px 1px rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: inset 0 3px 0 white, 0 1px 1px rgba(0, 0, 0, 0.1);
  -o-box-shadow: inset 0 3px 0 white, 0 1px 1px rgba(0, 0, 0, 0.1);
  box-shadow: inset 0 3px 0 white, 0 1px 1px rgba(0, 0, 0, 0.1);
}

#plans table {
  border-collapse: separate;
  width: 100%;
  text-shadow: 1px 1px 0px #fff;
}

#plans thead th, #plans td {
  background-image: -moz-linear-gradient(top, transparent, rgba(0, 0, 0, .075));
  background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(transparent), to(rgba(0, 0, 0, .075)));
  background-image: linear-gradient(top, transparent, rgba(0, 0, 0, .075));
  border: 1px solid #ccc;
  border-top: 0;
  border-left: 0;
  -moz-box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .4);
  -webkit-box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .4);
  box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .4);
  width: 220px;
}

#plans tr th:first-child, #plans tr td:first-child { border-left: 1px solid #ccc; }

#plans thead th {
  background-image: -moz-linear-gradient(top, transparent, rgba(0, 0, 0, .1));
  background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(transparent), to(rgba(0, 0, 0, .1)));
  background-image: linear-gradient(top, transparent, rgba(0, 0, 0, .1));
  border-top: 1px solid #ccc;
  border-bottom: 1px solid #ccc;
  padding: 20px;
}
#plans th h3 {
    font-size: 18px;
    line-height: 1px;
}

#plans th h4 {
  color: #377b1e;
  font-size: 40px;
  margin:10px;
  margin-bottom:0px;
}

#plans th em {
  display: block;
  font-style: normal;
  font-weight: normal;
  margin-bottom: 10px;
}

#plans th .buttons { margin: 2px 0; }

#plans th .buttons .button {
  font-size: 15px;
  margin: 0;
  padding: 7px 0;
  text-transform: none;
  width: 196px;
}

#plans td { padding: 0; }

#plans td li {
  border-top: 1px solid rgba(255, 255, 255, .3);
  border-bottom: 1px solid rgb(204, 204, 204);
  border-bottom: 1px solid rgba(0, 0, 0, .05);
  line-height: 20px;
  padding: 4px 0;
  width:100%;
  text-align:center;
}

#plans td .additional_features li { padding: 0; }
#plans td .additional_features li:last-child { border-bottom: 0; }

#plans td strong {
  color: #646464;
  color: rgba(0, 0, 0, .6);
  font-size: 14px;
}

#plans td ul {
  list-style-type: none;
  margin: 0;
}

#plans td .additional_features a {
  display: block;
  font-weight: normal;
  padding: 4px 0 5px;
  text-decoration: none;
}

.most_popular {
  background-color: rgb(234, 240, 245);
  background-color: rgba(98, 153, 197, .15);
}

.most_popular h3 { color: #444; color: rgba(0, 0, 0, .8); }

.most_popular .button {
  background-color: #4aa527;
  background-image: -moz-linear-gradient(top, transparent, rgba(0, 0, 0, .3));
  background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(transparent), to(rgba(0, 0, 0, .3)));
  background-image: linear-gradient(top, transparent, rgba(0, 0, 0, .3));
  border-color: #377b1e;
  color: #fff;
  text-shadow: 0 -1px rgba(0, 0, 0, .4);
}

.most_popular .button:hover {
  background-color: #4989bc;
  border-color: #396e99;
}
</style>
<div style="position:relative;">
  <ul class="eventTabs">
    <!--<li><a href="#history">Billing History</a></li>-->
    <li class="first active"><a href="#upgrade">Upgrade Plan</a></li>
  </ul>
  <div style="position:absolute; right:20px; top:20px;">Your current plan is: <strong><?TPLVAR_SUBSCRIPTION?></strong></div>
</div>

<div id="tabContainer" class="tabContainer">
  <!--<div id="history" class="tabContent">
    <div style="padding:10px;">
      <table width="100%" border="0" cellpadding="10" cellspacing="0" class="dataTable">
        <thead>
          <tr class="dataTableBar">
            <th width="30%"><strong>Payment Date</strong></th>
            <th><strong>Invoice Download</strong></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td width="30%"><strong>Payment Date</strong></td>
            <td><strong>Invoice Download</strong></td>
          </tr>
          <tr>
            <td width="30%"><strong>Payment Date</strong></td>
            <td><strong>Invoice Download</strong></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>-->
  <div id="upgrade" class="tabContent">
    <div style="padding:10px;">
      <table id="plans" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th>
              <h3>Lite</h3>
              <h4>$29</h4>
              <em>monthly</em>
              <form action="https://www.paypal.com/cgi-bin/webscr" id="lite" method="post" target="_blank">
                <input type="hidden" name="cmd" value="_xclick-subscriptions">
                <input type="hidden" name="business" value="sales@markaxis.com">
                <input type="hidden" name="item_name" value="Package Lite">
                <input type="hidden" name="return" value="<?TPLVAR_ROOT_URL?>admin/billing/success/lite/<?TPLVAR_LITE_USER?>">
                <input type="hidden" name="a3" value="29">
                <input type="hidden" name="p3" value="1">
                <input type="hidden" name="t3" value="M">
                <input type="hidden" name="src" value="1">
                <input type="hidden" name="sra" value="1">
                <div class="buttons button1">
                  <a class="btn btnAction upgradeBtn <?TPLVAR_BTN_LITE?>" id="1" href="lite"><?LANG_SELECT?></a>
                </div>
              </form>

              
            </th>
            <th class="most_popular">
              <h3>Business</h3>
              <h4>$49</h4>
              <em>monthly</em>
              <form action="https://www.paypal.com/cgi-bin/webscr" id="business" method="post" target="_blank">
                <input type="hidden" name="cmd" value="_xclick-subscriptions">
                <input type="hidden" name="business" value="sales@markaxis.com">
                <input type="hidden" name="item_name" value="Package Business">
                <input type="hidden" name="return" value="<?TPLVAR_ROOT_URL?>admin/billing/success/business/<?TPLVAR_BIZ_USER?>">
                <input type="hidden" name="a3" value="49">
                <input type="hidden" name="p3" value="1">
                <input type="hidden" name="t3" value="M">
                <input type="hidden" name="src" value="1">
                <input type="hidden" name="sra" value="1">
                <div class="buttons button2">
                  <a class="btn btnAction upgradeBtn <?TPLVAR_BTN_BUSINESS?>" id="2" href="business"><?LANG_SELECT?></a>
                </div>
              </form>           
            </th>
            <th>
              <h3>Corporate</h3>
              <h4>$99</h4>
              <em>monthly</em>
              
              <form action="https://www.paypal.com/cgi-bin/webscr" id="corporate" method="post" target="_blank">
                <input type="hidden" name="cmd" value="_xclick-subscriptions">
                <input type="hidden" name="business" value="sales@markaxis.com">
                <input type="hidden" name="item_name" value="Package Business">
                <input type="hidden" name="return" value="<?TPLVAR_ROOT_URL?>admin/billing/success/corporate/<?TPLVAR_CORP_USER?>">
                <input type="hidden" name="a3" value="99">
                <input type="hidden" name="p3" value="1">
                <input type="hidden" name="t3" value="M">
                <input type="hidden" name="src" value="1">
                <input type="hidden" name="sra" value="1">
                <div class="buttons button3">
                  <a class="btn btnAction upgradeBtn <?TPLVAR_BTN_CORPORATE?>" id="3" href="corporate"><?LANG_SELECT?></a>
                </div>
              </form> 
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <ul class="noList">
                <li><strong>300</strong> <?LANG_CLIENTS?></li>
                <li><strong>300</strong> <?LANG_KEYWORDS_DOMAINS?></li>
              </ul>
            </td>
            <td class="most_popular">
              <ul class="noList">
                <li><strong>1000</strong> <?LANG_CLIENTS?></li>
                <li><strong>1000</strong> <?LANG_KEYWORDS_DOMAINS?></li>
              </ul>
            </td>
            <td>
              <ul class="noList">
                <li><strong>2000</strong> <?LANG_CLIENTS?></li>
                <li><strong>2000</strong> <?LANG_KEYWORDS_DOMAINS?></li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
      <div style="padding:10px; background:#fffcf0; border:1px solid #ccc; margin-top:10px; text-align:center;">
        <?LANG_FOR_CANCELLATION?>
      </div>
      <div style="margin-top:20px; text-align:center;">
        <img src="<?TPLVAR_ROOT_URL?>www/themes/admin/aurora/billing/img/<?TPLVAR_THEME?>/payment.gif" />
      </div>
    </div>
  </div>
</div>