<div class="field-<?php echo $type?> field-settings">
	<div class="item">
        <div class="label"><?php echo __('Include Time Picker?','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][date_time_picker]" class="sixty">
              <option value="false" <?php echo isset($data['date_time_picker']) && $data['date_time_picker'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
              <option value="true" <?php echo isset($data['date_time_picker']) && $data['date_time_picker'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('After the user has selected a date, you can give them the option of selecting a time','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Pick Only','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][date_pick_only]" class="sixty">
              <option value="false" <?php echo isset($data['date_pick_only']) && $data['date_pick_only'] == false ? 'selected="selected"':''?>><?php echo __('Normal','kontrolwp')?></option>
              <option value="time" <?php echo isset($data['date_pick_only']) && $data['date_pick_only'] == 'time' ? 'selected="selected"':''?>><?php echo __('Time','kontrolwp')?></option>
              <option value="days" <?php echo isset($data['date_pick_only']) && $data['date_pick_only'] == 'days' ? 'selected="selected"':''?>><?php echo __('Days','kontrolwp')?></option>
              <option value="months" <?php echo isset($data['date_pick_only']) && $data['date_pick_only'] == 'months' ? 'selected="selected"':''?>><?php echo __('Months','kontrolwp')?></option>
              <option value="years" <?php echo isset($data['date_pick_only']) && $data['date_pick_only'] == 'years' ? 'selected="selected"':''?>><?php echo __('Years','kontrolwp')?></option>
            </select>  
        </div>
        <div class="desc"><?php echo __('You can limit the type of dates to be picked if needed','kontrolwp')?>.</div>
    </div>
    <div class="item">
        <div class="label"><?php echo __('Date Range','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][date_range]" class="sixty">
              <option value="false" <?php echo isset($data['date_range']) && $data['date_range'] == false ? 'selected="selected"':''?>><?php echo __('Disabled','kontrolwp')?></option>
              <option value="true" <?php echo isset($data['date_range']) && $data['date_range'] == true ? 'selected="selected"':''?>><?php echo __('Enabled','kontrolwp')?></option>
            </select> <div class="inline kontrol-tip" title="<?php echo __('Date Range','kontrolwp')?>" data-text="<?php echo htmlentities(__('The values (start date &amp; end date) for this field will be returned as an array using the <b>get_cf()</b> command if you enable this.','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
        </div>
        <div class="desc"><?php echo __('You can allow the user to select a date range (start &amp; end date)','kontrolwp')?>.</div>
    </div>
    <!-- Restrict Ranges -->
    <div class="item">
        <div class="label"><?php echo __('Restrict Dates Available','kontrolwp')?><span class="req-ast">*</span></div> 
        <div class="field">
            <select name="field[<?php echo $fkey?>][settings][date_restricted]" data-hide-show-parent=".field-<?php echo $type?>" class="hide-show sixty">
                <option value="false" data-hide-classes="restrict-dates-group" <?php echo isset($data['date_restricted']) && $data['date_restricted'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                <option value="range" data-show-classes="restrict-dates-group,date-range"  data-hide-classes="date-specific"  <?php echo isset($data['date_restricted']) && $data['date_restricted'] == 'range' ? 'selected="selected"':''?>><?php echo __('Min Date &amp; Max Dates','kontrolwp')?></option>
                <option value="specific" data-show-classes="restrict-dates-group,date-specific"  data-hide-classes="date-range" <?php echo isset($data['date_restricted']) && $data['date_restricted'] == 'specific' ? 'selected="selected"':''?>><?php echo __('Specific Dates','kontrolwp')?></option>
            </select>
        </div>
        <div class="desc"><?php echo __('You can limit the dates available to the user buy selecting a min &amp; max range or a set of specific dates they can pick from.','kontrolwp')?></div>
    </div>
        <div class="restrict-dates-group subgroup">
            <div class="item date-range">
                <div class="label"><?php echo __('Limit Date Selection Between','kontrolwp')?> <span class="req-ast">*</span></div> 
                <div class="field">
                    <div><input type="text" name="field[<?php echo $fkey?>][settings][date_limit_min]" value="<?php echo isset($data['date_limit_min']) ? $data['date_limit_min']:""?>" class="date-picker required" /> <?php echo __('Min Date','kontrolwp')?></div>
                    <div><input type="text" name="field[<?php echo $fkey?>][settings][date_limit_max]" value="<?php echo isset($data['date_limit_max']) ? $data['date_limit_max']:""?>" class="date-picker required" /> <?php echo __('Max Date','kontrolwp')?></div>
                </div>
                <div class="desc"><?php echo __('Select the min and max dates available to the user for picking dates','kontrolwp')?>.</div>
            </div>
            <div class="item date-specific">
                <div class="label"><?php echo __('Specific Dates','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <input type="text" name="field[<?php echo $fkey?>][settings][date_limit_specific]" value="<?php echo isset($data['date_limit_specific']) ? $data['date_limit_specific']:""?>" class="required sixty" />
                </div>
                <div class="desc"><?php echo __('When only a few dates should be selectable. Enter a javascript object like','kontrolwp')?>...<br /><b>{2012: {1: [19, 29, 31], 3: [5, 19, 24]}}</b> &nbsp; (<?php echo __('with all the dates <b>year -> months -> days</b>','kontrolwp')?>).</div>
            </div>
            <div class="item date-specific">
                <div class="label"><?php echo __('Invert Specific Dates','kontrolwp')?><span class="req-ast">*</span></div> 
                <div class="field">
                    <select name="field[<?php echo $fkey?>][settings][date_limit_specific_invert]" class="sixty">
                      <option value="false" <?php echo isset($data['date_limit_specific_invert']) && $data['date_limit_specific_invert'] == false ? 'selected="selected"':''?>><?php echo __('No')?></option>
                      <option value="true" <?php echo isset($data['date_limit_specific_invert']) && $data['date_limit_specific_invert'] == true ? 'selected="selected"':''?>><?php echo __('Yes')?></option>
                    </select> 
                </div>
                <div class="desc"><?php echo __('If you invert your specific dates, only dates which you have not entered will be available to pick from','kontrolwp')?>.</div>
            </div>
        </div>
    <div class="item">
        <div class="label"><?php echo __('Date Label Format','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][date_format]" value="<?php echo isset($data['date_format']) ? $data['date_format']:"%d/%m/%Y"?>" class="required sixty" />
        </div>
        <div class="desc"><?php echo __('The date shown can be formatted in a variety of ways. Default is %d/%m/%Y eg. 31/12/2012.','kontrolwp')?> <span data-toggle-classes="date-options" data-hide-show-parent=".item" class="hide-show" style="cursor: pointer; font-weight:bold;"><?php echo __('Click here to view all formatting options','kontrolwp')?>.</span>
        	<div class="date-options" style="display:none">
        	    <p>
                a - <?php echo __('short day ("Mon", "Tue")','kontrolwp')?><br />
                A - <?php echo __('full day ("Monday")','kontrolwp')?><br />
                b - <?php echo __('short month ("Jan", "Feb")','kontrolwp')?><br />
                B - <?php echo __('full month ("January")','kontrolwp')?><br />
                c - <?php echo __('the full date to string ("Mon Dec 10 14:35:42 2007";','kontrolwp')?> %a %b %d %H:%m:%S %Y)<br />
                d - <?php echo __('the date to two digits (01, 05, etc)','kontrolwp')?><br />
                e - <?php echo __('the date as one digit (1, 5, 12, etc)','kontrolwp')?><br />
                H - <?php echo __('the hour to two digits in military time (24 hr mode) (00, 11, 14, etc)','kontrolwp')?><br />
                I - <?php echo __('the hour as a decimal number using a 12-hour clock (range 01 to 12)','kontrolwp')?>.<br />
                j - <?php echo __('the day of the year to three digits (001 to 366, is Jan 1st)','kontrolwp')?><br />
                k - <?php echo __('the hour (24-hour clock) as a digit (range 0 to 23). Single digits are preceded by a blank space','kontrolwp')?>.<br />
                l - <?php echo __('the hour (12-hour clock) as a digit (range 1 to 12). Single digits are preceded by a blank space','kontrolwp')?>.<br />
                L - <?php echo __('the time in milliseconds (three digits; "081")','kontrolwp')?><br />
                m - <?php echo __('the numerical month to two digits (01 is Jan, 12 is Dec)','kontrolwp')?><br />
                M - <?php echo __('the minutes to two digits (01, 40, 59)','kontrolwp')?><br />
                o - <?php echo __('the ordinal of the day of the month in the current language ("st" for the 1st, "nd" for the 2nd, etc.)','kontrolwp')?><br />
                p - <?php echo __('the current language equivalent of either AM or PM','kontrolwp')?><br />
                s - <?php echo __('the Unix Epoch Time timestamp','kontrolwp')?><br />
                S - <?php echo __('the seconds to two digits (01, 40, 59)','kontrolwp')?><br />
                T - <?php echo __('the time as','kontrolwp')?> %H:%M:%S<br />
                U - <?php echo __('the week to two digits (01 is the week of Jan 1, 52 is the week of Dec 31)','kontrolwp')?><br />
                w - <?php echo __('the numerical day of the week, one digit (0 is Sunday, 1 is Monday)','kontrolwp')?><br />
                x - <?php echo __('the date in the current language preferred format. en-US: %m/%d/%Y (12/10/2007)','kontrolwp')?><br />
                X - <?php echo __('the time in the current language preferred format. en-US: %I:%M%p (02:45PM)','kontrolwp')?><br />
                y - <?php echo __('the short year (two digits; "07")','kontrolwp')?><br />
                Y - <?php echo __('the full year (four digits; "2007")','kontrolwp')?><br />
                z - <?php echo __('the GMT offset ("-0800")','kontrolwp')?><br />
                Z - <?php echo __('the time zone ("GMT")','kontrolwp')?><br />
                % - <?php echo __('returns','kontrolwp')?> % (<?php echo __('example','kontrolwp')?>: %y%% = 07%)
                </p>
                <p>
                <?php echo __('Shortcuts -  These shortcuts are NOT preceded by the percent sign','kontrolwp')?>.
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
        <div class="label"><?php echo __('Date Value Format','kontrolwp')?><span class="req-ast">*</span></div>
        <div class="field">
            <input type="text" name="field[<?php echo $fkey?>][settings][date_value_format]" value="<?php echo isset($data['date_value_format']) ? $data['date_value_format']:"%d/%m/%Y"?>" class="required sixty" /> <div class="inline kontrol-tip" title="Date Value Format" data-text="<?php echo htmlentities(__('You can show the user the <b>%d/%m/%Y</b> format as a label above, but have the selected date stored as a <b>Unix timestamp</b> by entering <b>%s</b> here.','kontrolwp'), ENT_QUOTES, 'UTF-8')?>"></div>
        </div>
        <div class="desc"><?php echo __('The date value refers to the date format that is stored, not the one shown to the user','kontrolwp')?>.</div>
   </div>
    
</div>