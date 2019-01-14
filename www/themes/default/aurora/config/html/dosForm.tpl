    <div id="auroraDoSForm" class="config">
       <div class="formTitle">Denial of Service (DoS) Layer 7 Shield</div>
       The objective of this DoS Layer 7 Shield is to protect valuable server resources from being
       abused by illegitimate request (i.e. Robot). While it tries to prevent application
       level calls from being abused, it does not prevent the server from going down on non-service URLs
       attacks.
       <br /><br />
       <ul class="noList configList">
          <li class="columnDescript"><div class="formTitle">Enable DoS Layer 7 Shield</div>
          <span class="formDesc">Select Yes to enable the DoS Layer 7 Shield.</span></li>
          <li class="formField formRadio"><?TPLVAR_ENABLE_DOS?></li>
        </ul>
       
       <fieldset style="margin-bottom:10px;">
          <legend>Configure Shield Policy</legend>
          <ul class="noList configList">
            <li class="columnDescript" style="width:270px;"><div class="formTitle">Send Email Alert</div>
              <span class="formDesc">Send an email alert to Webmaster for any DoS attempted (Only once).</span></li>
              <li class="formField formRadio"><?TPLVAR_DOS_ALERT?></li>
            <li class="columnDescript" style="width:270px;"><div class="formTitle">Send JavaScript Challenge Response</div>
              <span class="formDesc">Inject JavaScript challenge response to the user to make sure request is
              coming from a real browser.</span></li>
            <li class="formField formRadio"><input type="radio" checked="checked" class="alignMiddle" /> Yes
              <input type="radio" class="alignMiddle" /> No</li>
            <li class="columnDescript" style="width:270px;"><div class="formTitle">Maximum Seconds per Hit Rate</div>
              <span class="formDesc">Set the number of milliseconds to allow per hit request.</span></li>
            <li class="formField"><select name="sdf" id="dsdf" class="selectList">
            <option value="">0.2 Milliseconds</option>
            <option value="">0.3 Milliseconds</option>
            <option value="">0.4 Milliseconds</option>
            <option value="">0.5 (Approx. 2 hits / sec)</option>
            <option value="">0.6 Milliseconds</option>
            <option value="">0.7 Milliseconds</option>
            <option value="">0.8 Milliseconds</option>
            <option value="">0.9 Milliseconds</option>
            <option value="">1 Second (1 hit / sec)</option>
            </select>
            </li>
            <li class="columnDescript" style="width:270px;"><div class="formTitle">Automatically Blacklist IP Addresses</div>
              <span class="formDesc">Automatically set the IP addresses to Blacklist if DoS is detected.
              Auto-blacklist will be stopped if Hit Rate is reached.
              (Work together with IP Restrictions.</span></li>
            <li class="formField formRadio"><input type="radio" checked="checked" class="alignMiddle" /> Yes
              <input type="radio" class="alignMiddle" /> No</li>
            <li class="columnDescript" style="width:270px;"><div class="formTitle">Ignore White List IP Addresses</div>
              <span class="formDesc">DoS Shield will allow all White List IP Addresses to pass through
              regardless of the hit rate.</span></li>
            <li class="formField formRadio"><input type="radio" checked="checked" class="alignMiddle" /> Yes
              <input type="radio" class="alignMiddle" /> No</li>
          </ul>
        </fieldset>
    </div>