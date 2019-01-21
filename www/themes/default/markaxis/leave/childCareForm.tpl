<fieldset>
    <legend class="text-semibold">Child-Care Leave</legend>

    <div class="row">
        <div class="col-md-4">
            <label>Child Must Be Born In:</label>
            <?TPL_CHILD_COUNTRY_LIST?>
        </div>

        <div class="col-md-2">
            <label class="display-block">Qualifying Age Limit:</label>
            <input type="number" name="leaveTypeName" id="leaveTypeName" class="form-control" value=""
                   placeholder="7" />
        </div>

        <div class="col-md-3">
            <label class="display-block">&nbsp;</label>
            <?TPL_PAID_LEAVE?>
        </div>

        <div class="col-md-3">
            <label class="display-block">&nbsp;</label>
            <?TPL_ALLOW_HALF_DAY_RADIO?>
        </div>
    </div>
</fieldset>
