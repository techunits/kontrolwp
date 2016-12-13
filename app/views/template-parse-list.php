<table>
    <tbody>
    <tr>
        <th class="main-title" colspan="2"><?php echo __('Site Information','kontrolwp')?></th>
     </tr>
     <tr>
        <th>[[sitename]]</th>
        <td><?php echo __("The site's name",'kontrolwp')?></td>
    </tr>
    <tr class="alt">
        <th>[[sitedesc]]</th>
        <td><?php echo __("The site's tagline / description",'kontrolwp')?></td>
    </tr>
     <tr>
        <th class="main-title" colspan="2"><?php echo __("Post Information",'kontrolwp')?></th>
     </tr>
    <tr>
        <th>[[date(d/m/Y)]]</th>
        <td><?php echo sprintf(__('Replaced with the date of the post/page - change the <b>d/m/Y</b> to the <a href="%s" target="_blank">format</a> you wish the date to appear in.','kontrolwp'), 'http://php.net/manual/en/function.date.php')?></td>
    </tr>
    <tr class="alt">
        <th>[[title]]</th>
        <td><?php echo __('Replaced with the title of the post/page','kontrolwp')?></td>
    </tr>
    <tr>
        <th>[[excerpt]]</th>
        <td><?php echo __('Replaced with the post/page excerpt (auto-generated if it does not exist)','kontrolwp')?></td>
    </tr>
    <tr class="alt">
        <th>[[excerpt_only]]</th>
        <td><?php echo __('Replaced with the post/page excerpt (without auto-generation)','kontrolwp')?></td>
    </tr>
    <tr>
        <th>[[tags]]</th>
        <td><?php echo __('Replaced with the current tag/tags applied to the current post (comma separated)','kontrolwp')?></td>
    </tr>
    <tr class="alt">
        <th>[[categories]]</th>
        <td><?php echo __('Replaced with the post categories (comma separated)','kontrolwp')?></td>
    </tr>
    <tr>
        <th>[modified(d/m/Y)]]</th>
        <td><?php echo sprintf(__('Replaced with the post/page modified time - change the <b>d/m/Y</b> to the <a href="%s" target="_blank">format</a> you wish the date to appear in.','kontrolwp'), 'http://php.net/manual/en/function.date.php')?></td>
    </tr>
    <tr class="alt">
        <th>[[id]]</th>
        <td><?php echo __('Replaced with the post/page ID','kontrolwp')?></td>
    </tr>
    <tr>
        <th class="main-title" colspan="2"><?php echo __('Author Information','kontrolwp')?></th>
     </tr>
    <tr>
        <th>[[author_name]]</th>
        <td><?php echo __("Replaced with the post/page author's",'kontrolwp')?> '<?php echo __("nicename",'kontrolwp')?>'</td>
    </tr>
    <tr>
        <th>[[author_firstname]]</th>
        <td><?php echo __("Replaced with the post/page author's",'kontrolwp')?> <?php echo __("first name",'kontrolwp')?></td>
    </tr>
    <tr>
        <th>[[author_surname]]</th>
        <td><?php echo __("Replaced with the post/page author's",'kontrolwp')?> <?php echo __("surname",'kontrolwp')?></td>
    </tr>
    <tr class="alt">
        <th>[[author_id]]</th>
        <td><?php echo __("Replaced with the post/page author's",'kontrolwp')?> <?php echo __("user id",'kontrolwp')?></td>
    </tr>
   <tr>
        <th class="main-title" colspan="2"><?php echo __("Date &amp; Time",'kontrolwp')?></th>
     </tr>
    <tr class="alt">
        <th>[[current_date_time(d/m/Y)]]</th>
        <td><?php echo sprintf(__('Replaced with the current date/time in the format specified. Change <b>d/m/Y</b> to your desired date/time <a href="%s" target="_blank">format</a>.','kontrolwp'), 'http://php.net/manual/en/function.date.php')?></td>
    </tr>
    <?php if(isset($type) && $type == 'frontend') { ?>
        <tr>
            <th class="main-title" colspan="2"><?php echo __("Search Information",'kontrolwp')?></th>
         </tr>
        <tr>
            <th>[[search_phrase]]</th>
            <td><?php echo __("Replaced with the current search phrase",'kontrolwp')?></td>
        </tr>
   <?php } ?>
</tbody>
</table>