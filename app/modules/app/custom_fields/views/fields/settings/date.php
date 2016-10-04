<div class="field-<?=$type?> field-settings">
	<div class="item">
        <div class="label"><?=__('Include Time Picker?','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][date_time_picker]" class="sixty">
              <option value="false" <?=isset($data['date_time_picker']) && $data['date_time_picker'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
              <option value="true" <?=isset($data['date_time_picker']) && $data['date_time_picker'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?=__('After the user has selected a date, you can give them the option of selecting a time','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?=__('Pick Only','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][date_pick_only]" class="sixty">
              <option value="false" <?=isset($data['date_pick_only']) && $data['date_pick_only'] == false ? 'selected="selected"':''?>><?=__('Normal','kontrolwp')?></option>
              <option value="time" <?=isset($data['date_pick_only']) && $data['date_pick_only'] == 'time' ? 'selected="selected"':''?>><?=__('Time','kontrolwp')?></option>
              <option value="days" <?=isset($data['date_pick_only']) && $data['date_pick_only'] == 'days' ? 'selected="selected"':''?>><?=__('Days','kontrolwp')?></option>
              <option value="months" <?=isset($data['date_pick_only']) && $data['date_pick_only'] == 'months' ? 'selected="selected"':''?>><?=__('Months','kontrolwp')?></option>
              <option value="years" <?=isset($data['date_pick_only']) && $data['date_pick_only'] == 'years' ? 'selected="selected"':''?>><?=__('Years','kontrolwp')?></option>
            </select>  
        </div>
        <div class="desc"><?=__('You can limit the type of dates to be picked if needed','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?=__('Date Range','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?=$fkey?>][settings][date_range]" class="sixty">
              <option value="false" <?=isset($data['date_range']) && $data['date_range'] == false ? 'selected="selected"':''?>><?=__('Disabled','kontrolwp')?></option>
              <option value="true" <?=isset($data['date_range']) && $data['date_range'] == true ? 'selected="selected"':''?>><?=__('Enabled','kontrolwp')?></option>
            </select> <div class="inline kontrol-tip" title="<?=__('Date Range','kontrolwp')?>" data-text="<?=htmlentities(__('The values (start date &amp; end date) for this field will be returned as an array using the <b>get_cf()</b> command if you enable this.','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
        </div>
        <div class="desc"><?=__('You can allow the user to select a date range (start &amp; end date)','kontrolwp')?>.</div>
    </div>
    <!-- Restrict Ranges -->
    <div class="item">
        <div class="label"><?=__('Restrict Dates Available','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <select name="field[<?=$fkey?>][settings][date_restricted]" data-hide-show-parent=".field-<?=$type?>" class="hide-show sixty">
                <option value="false" data-hide-classes="restrict-dates-group" <?=isset($data['date_restricted']) && $data['date_restricted'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                <option value="range" data-show-classes="restrict-dates-group,date-range"  data-hide-classes="date-specific"  <?=isset($data['date_restricted']) && $data['date_restricted'] == 'range' ? 'selected="selected"':''?>><?=__('Min Date &amp; Max Dates','kontrolwp')?></option>
                <option value="specific" data-show-classes="restrict-dates-group,date-specific"  data-hide-classes="date-range" <?=isset($data['date_restricted']) && $data['date_restricted'] == 'specific' ? 'selected="selected"':''?>><?=__('Specific Dates','kontrolwp')?></option>
            </select>
        </div>
        <div class="desc"><?=__('You can limit the dates available to the user buy selecting a min &amp; max range or a set of specific dates they can pick from.','kontrolwp')?></div>
    </div>
        <div class="restrict-dates-group subgroup">
            <div class="item date-range">
                <div class="label"><?=__('Limit Date Selection Between','kontrolwp')?> <span class="req-ast">*</span></div> 
                <div class="field">
                    <div><input type="text" name="field[<?=$fkey?>][settings][date_limit_min]" value="<?=isset($data['date_limit_min']) ? $data['date_limit_min']:""?>" class="date-picker required" /> <?=__('Min Date','kontrolwp')?></div>
                    <div><input type="text" name="field[<?=$fkey?>][settings][date_limit_max]" value="<?=isset($data['date_limit_max']) ? $data['date_limit_max']:""?>" class="date-picker required" /> <?=__('Max Date','kontrolwp')?></div>
                </div>
                <div class="desc"><?=__('Select the min and max dates available to the user for picking dates','kontrolwp')?>.</div>
            </div>
            <div class="item date-specific">
                <div class="label"><?=__('Specific Dates','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <input type="text" name="field[<?=$fkey?>][settings][date_limit_specific]" value="<?=isset($data['date_limit_specific']) ? $data['date_limit_specific']:""?>" class="required sixty" />
                </div>
                <div class="desc"><?=__('When only a few dates should be selectable. Enter a javascript object like','kontrolwp')?>...<br /><b>{2012: {1: [19, 29, 31], 3: [5, 19, 24]}}</b> &nbsp; (<?=__('with all the dates <b>year -> months -> days</b>','kontrolwp')?>).</div>
            </div>
            <div class="item date-specific">
                <div class="label"><?=__('Invert Specific Dates','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <select name="field[<?=$fkey?>][settings][date_limit_specific_invert]" class="sixty">
                      <option value="false" <?=isset($data['date_limit_specific_invert']) && $data['date_limit_specific_invert'] == false ? 'selected="selected"':''?>><?=__('No')?></option>
                      <option value="true" <?=isset($data['date_limit_specific_invert']) && $data['date_limit_specific_invert'] == true ? 'selected="selected"':''?>><?=__('Yes')?></option>
                    </select> 
                </div>
                <div class="desc"><?=__('If you invert your specific dates, only dates which you have not entered will be available to pick from','kontrolwp')?>.</div>
            </div>
        </div>
    <div class="item">
        <div class="label"><?=__('Date Label Format','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][date_format]" value="<?=isset($data['date_format']) ? $data['date_format']:"%d/%m/%Y"?>" class="required sixty" />
        </div>
        <div class="desc"><?=__('The date shown can be formatted in a variety of ways. Default is %d/%m/%Y eg. 31/12/2012.','kontrolwp')?> <span data-toggle-classes="date-options" data-hide-show-parent=".item" class="hide-show" style="cursor: pointer; font-weight:bold;"><?=__('Click here to view all formatting options','kontrolwp')?>.</span>
        	<div class="date-options" style="display:none">
        	    <p>
                a - <?=__('short day ("Mon", "Tue")','kontrolwp')?><br />
                A - <?=__('full day ("Monday")','kontrolwp')?><br />
                b - <?=__('short month ("Jan", "Feb")','kontrolwp')?><br />
                B - <?=__('full month ("January")','kontrolwp')?><br />
                c - <?=__('the full date to string ("Mon Dec 10 14:35:42 2007";','kontrolwp')?> %a %b %d %H:%m:%S %Y)<br />
                d - <?=__('the date to two digits (01, 05, etc)','kontrolwp')?><br />
                e - <?=__('the date as one digit (1, 5, 12, etc)','kontrolwp')?><br />
                H - <?=__('the hour to two digits in military time (24 hr mode) (00, 11, 14, etc)','kontrolwp')?><br />
                I - <?=__('the hour as a decimal number using a 12-hour clock (range 01 to 12)','kontrolwp')?>.<br />
                j - <?=__('the day of the year to three digits (001 to 366, is Jan 1st)','kontrolwp')?><br />
                k - <?=__('the hour (24-hour clock) as a digit (range 0 to 23). Single digits are preceded by a blank space','kontrolwp')?>.<br />
                l - <?=__('the hour (12-hour clock) as a digit (range 1 to 12). Single digits are preceded by a blank space','kontrolwp')?>.<br />
                L - <?=__('the time in milliseconds (three digits; "081")','kontrolwp')?><br />
                m - <?=__('the numerical month to two digits (01 is Jan, 12 is Dec)','kontrolwp')?><br />
                M - <?=__('the minutes to two digits (01, 40, 59)','kontrolwp')?><br />
                o - <?=__('the ordinal of the day of the month in the current language ("st" for the 1st, "nd" for the 2nd, etc.)','kontrolwp')?><br />
                p - <?=__('the current language equivalent of either AM or PM','kontrolwp')?><br />
                s - <?=__('the Unix Epoch Time timestamp','kontrolwp')?><br />
                S - <?=__('the seconds to two digits (01, 40, 59)','kontrolwp')?><br />
                T - <?=__('the time as','kontrolwp')?> %H:%M:%S<br />
                U - <?=__('the week to two digits (01 is the week of Jan 1, 52 is the week of Dec 31)','kontrolwp')?><br />
                w - <?=__('the numerical day of the week, one digit (0 is Sunday, 1 is Monday)','kontrolwp')?><br />
                x - <?=__('the date in the current language preferred format. en-US: %m/%d/%Y (12/10/2007)','kontrolwp')?><br />
                X - <?=__('the time in the current language preferred format. en-US: %I:%M%p (02:45PM)','kontrolwp')?><br />
                y - <?=__('the short year (two digits; "07")','kontrolwp')?><br />
                Y - <?=__('the full year (four digits; "2007")','kontrolwp')?><br />
                z - <?=__('the GMT offset ("-0800")','kontrolwp')?><br />
                Z - <?=__('the time zone ("GMT")','kontrolwp')?><br />
                % - <?=__('returns','kontrolwp')?> % (<?=__('example','kontrolwp')?>: %y%% = 07%)
                </p>
                <p>
                <?=__('Shortcuts -  These shortcuts are NOT preceded by the percent sign','kontrolwp')?>.
                </p>
                <p>
                    db = "%Y-%m-%d %H:%M:%S",<br />
                    compact = "%Y%m%dT%H%M%S",<br />
                    iso8601 = "%Y-%m-%dT%H:%M:%S%z",<br />
                    rfc822 = "%a, %d %b %Y %H:%M:%S %Z",<br />
                    rfc2822 = "%a, %d %b %Y %H:%M:%S %z",<br />
                    short = "%d %b %H:%M",<br />
                    long = "%B %d, %Y %H:%M"
                </p>
       		</div>
        
        </div>
    </div>
    <div class="item">
        <div class="label"><?=__('Date Value Format','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <input type="text" name="field[<?=$fkey?>][settings][date_value_format]" value="<?=isset($data['date_value_format']) ? $data['date_value_format']:"%d/%m/%Y"?>" class="required sixty" /> <div class="inline kontrol-tip" title="Date Value Format" data-text="<?=htmlentities(__('You can show the user the <b>%d/%m/%Y</b> format as a label above, but have the selected date stored as a <b>Unix timestamp</b> by entering <b>%s</b> here.','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
        </div>
        <div class="desc"><?=__('The date value refers to the date format that is stored, not the one shown to the user','kontrolwp')?>.</div>
   </div>
    
</div>