<?php
/**
 * Meta box attributes for the Pick ads.
 */
?>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row">
                <label><?= __('Stop Date', 'bam-ads-system') ?></label>
            </th>
            <td>
                <input type="text" name="ad-atts[stop-date]" value="<?= $ad->getProperty('stop-date') ?>">
            </td>
        </tr>
    </tbody>
</table>
