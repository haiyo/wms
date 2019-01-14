<style>
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
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #ffffff), color-stop(100%, #e0e0e0));
  background-image: -webkit-linear-gradient(#ffffff, #e0e0e0);
  background-image: -moz-linear-gradient(#ffffff, #e0e0e0);
  background-image: -o-linear-gradient(#ffffff, #e0e0e0);
  background-image: -ms-linear-gradient(#ffffff, #e0e0e0);
  background-image: linear-gradient(#ffffff, #e0e0e0);
  border-color: #a8b0b3;
  color: #666;
  -moz-box-shadow: inset 0 3px 0 white, 0 1px 1px rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: inset 0 3px 0 white, 0 1px 1px rgba(0, 0, 0, 0.1);
  -o-box-shadow: inset 0 3px 0 white, 0 1px 1px rgba(0, 0, 0, 0.1);
  box-shadow: inset 0 3px 0 white, 0 1px 1px rgba(0, 0, 0, 0.1);
}
.btn.btn-gray:hover {
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #f6f6f6), color-stop(100%, #e0e0e0));
  background-image: -webkit-linear-gradient(#f6f6f6, #e0e0e0);
  background-image: -moz-linear-gradient(#f6f6f6, #e0e0e0);
  background-image: -o-linear-gradient(#f6f6f6, #e0e0e0);
  background-image: -ms-linear-gradient(#f6f6f6, #e0e0e0);
  background-image: linear-gradient(#f6f6f6, #e0e0e0);
  -moz-box-shadow: inset 0 3px 0 #f6f6f6, 0 1px 1px rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: inset 0 3px 0 #f6f6f6, 0 1px 1px rgba(0, 0, 0, 0.1);
  -o-box-shadow: inset 0 3px 0 #f6f6f6, 0 1px 1px rgba(0, 0, 0, 0.1);
  box-shadow: inset 0 3px 0 #f6f6f6, 0 1px 1px rgba(0, 0, 0, 0.1);
}
.btn.btn-gray:active {
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #e6e6e6), color-stop(100%, #dcdcdc));
  background-image: -webkit-linear-gradient(#e6e6e6, #dcdcdc);
  background-image: -moz-linear-gradient(#e6e6e6, #dcdcdc);
  background-image: -o-linear-gradient(#e6e6e6, #dcdcdc);
  background-image: -ms-linear-gradient(#e6e6e6, #dcdcdc);
  background-image: linear-gradient(#e6e6e6, #dcdcdc);
  -moz-box-shadow: inset 0 1px 2px #aaaaaa, 0 1px 1px rgba(0, 0, 0, 0.1);
  -webkit-box-shadow: inset 0 1px 2px #aaaaaa, 0 1px 1px rgba(0, 0, 0, 0.1);
  -o-box-shadow: inset 0 1px 2px #aaaaaa, 0 1px 1px rgba(0, 0, 0, 0.1);
  box-shadow: inset 0 1px 2px #aaaaaa, 0 1px 1px rgba(0, 0, 0, 0.1);
}
/* =PRICING */
article {
  background: #fff;
  -moz-box-shadow: 0 0 15px rgba(0, 0, 0, .2);
  -webkit-box-shadow: 0 0 15px rgba(0, 0, 0, .2);
  box-shadow: 0 0 15px rgba(0, 0, 0, .2);
}
.pricing article { margin-bottom: 20px; }

table {
  border-collapse: separate;
  width: 100%;
  text-shadow: 1px 1px 0px #fff;
}

thead th, td {
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

tr th:first-child, tr td:first-child { border-left: 1px solid #ccc; }

thead th {
  background-image: -moz-linear-gradient(top, transparent, rgba(0, 0, 0, .1));
  background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(transparent), to(rgba(0, 0, 0, .1)));
  background-image: linear-gradient(top, transparent, rgba(0, 0, 0, .1));
  border-top: 1px solid #ccc;
  border-bottom: 1px solid #ccc;
  padding: 20px;
}
th h3 {
    font-size: 18px;
    line-height: 1px;
}

th h4 {
  color: #377b1e;
  font-size: 40px;
  margin:10px;
  margin-bottom:0px;
}

th em {
  display: block;
  font-style: normal;
  font-weight: normal;
  margin-bottom: 10px;
}

th .buttons { margin: 2px 0; }

th .buttons .button {
  font-size: 15px;
  margin: 0;
  padding: 7px 0;
  text-transform: none;
  width: 196px;
}

td { padding: 0; }

td li {
  border-top: 1px solid rgba(255, 255, 255, .3);
  border-bottom: 1px solid rgb(204, 204, 204);
  border-bottom: 1px solid rgba(0, 0, 0, .05);
  color: #828282;
  color: rgba(0, 0, 0, .4);
  line-height: 20px;
  padding: 4px 0;
  width:100%;
  text-indent:20px;
}

td .additional_features li { padding: 0; }
td .additional_features li:last-child { border-bottom: 0; }

td strong {
  color: #646464;
  color: rgba(0, 0, 0, .6);
  font-size: 14px;
}

td .extra {
  color: #6299c5;
  display: none; /* Needs work */
  font-weight: bold;
}

td ul {
  list-style-type: none;
  margin: 0;
}

td .additional_features a {
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

  <div id="auroraUpgradeForm" class="config">
    <div><h1>Subscription Details</h1>
      <span class="formDesc">Below is the information related to your current subscription. You can choose
      to upgrade your subscription package if you need to add more user accounts, storage space and customer support.</span></div>

    <fieldset style="margin-bottom:10px;">
      <legend>Current Subscription Plan</legend>
      <ul class="noList configList">
        <li class="columnDescript" style="width:270px;"><div class="formTitle">Subscription Plan</div></li>
        <li>Free ($0.00 per month)</li>
        <li class="columnDescript" style="width:270px;"><div class="formTitle">Number of Accounts</div></li>
        <li>Limit 2</li>
        <li class="columnDescript" style="width:270px;"><div class="formTitle">Storage Space</div></li>
        <li>500 MB</li>
        <li class="columnDescript" style="width:270px;"><div class="formTitle">Application Features</div></li>
        <li>Minimum</li>
        <li class="columnDescript" style="width:270px;"><div class="formTitle">24/7 Customer Support</div></li>
        <li>Not Applicable</li>
      </ul>
    </fieldset>

    <section class="pricing pane">
    <article>
      <table id="plans" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th>
              <h3>Small</h3>
              <h4>$29</h4>
              <em>monthly</em>
              <div class="buttons">
                <a class="btn btnAction" href="">Upgrade</a>
              </div>
            </th>
            <th class="most_popular">
              <h3>Medium</h3>
              <h4>$49</h4>
              <em>monthly</em>
              <div class="buttons">
                <a class="btn btnAction" href="">Upgrade</a>
              </div>
            </th>
            <th>
              <h3>Corporate</h3>
              <h4>$99</h4>
              <em>monthly</em>
              <div class="buttons">
                <a class="btn btnAction" href="">Upgrade</a>
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <ul class="noList">
                <li><strong>10</strong> accounts <a href="#" class="extra">+</a></li>
                <li><strong>5 GB</strong> of storage</li>
                <li><strong>All</strong> application features</li>
                <li><strong>24/7 Support</strong> available</li>
              </ul>
            </td>
            <td class="most_popular">
              <ul class="noList">
                <li><strong>30</strong> accounts <a href="#" class="extra">+</a></li>
                <li><strong>20 GB</strong> of storage</li>
                <li><strong>All</strong> application features</li>
                <li><strong>24/7 Support</strong> available</li>
              </ul>
            </td>
            <td>
              <ul class="noList">
                <li><strong>Unlimited</strong> accounts <a href="#" class="extra">+</a></li>
                <li><strong>100 GB</strong> of storage</li>
                <li><strong>All</strong> application features</li>
                <li><strong>24/7 Support</strong> available</li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
    </article>

    <h5>30-day money back guarantee. Cancel your account within 30 days and we'll refund any charges. No questions asked.</h5>
  </section>
  </div>