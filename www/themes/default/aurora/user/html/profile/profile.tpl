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
    height:381px;
    padding-left:9px;
    margin-top: 2px;
    border-top:1px solid #999;
}

.tabContent { float:left; width:100%; }

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
</style>
<ul class="eventTabs">
  <?TPL_TAB?>
</ul>

<div id="tabContainer" class="tabContainer">
  <form id="profileForm">
  <?TPL_DATA?>
  </form>
</div>