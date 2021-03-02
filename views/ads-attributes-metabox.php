<?php
/**
 * View with the attributes fields of an ad.
 */
?>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row">
                <label for="bam-ad-type"><?= __('Type', 'bam-ads-system') ?></label>
            </th>
            <td>
                <select name="ad-atts[type]" id="bam-ad-type">
                    <?php foreach($types as $slug => $label): ?>
                    <option value="<?= $slug ?>" <?php selected($slug, $ad->getType()) ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="bam-ad-template"><?= __('Template', 'bam-ads-system') ?></label>
            </th>
            <td>
                <select name="ad-atts[template]" id="bam-ad-template">
                    <?php foreach($templates as $slug => $path): ?>
                    <option value="<?= $slug ?>" <?php selected($slug, $ad->getTemplate()) ?>><?= $slug ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="bam-bg-color"><?= __('Background color', 'bam-ads-system') ?></label>
            </th>
            <td>
                <input id="bam-bg-color" type="color" name="ad-atts[bg-color]" value="<?= $ad->getBackgroundColor() ?>">
            </td>
        </tr>
    </tbody>
</table>

<?php foreach($types as $slug => $label): ?>
    <div class="bam-ads-attributes" id="bam-atts-<?= $slug ?>">
    <?php do_action("bam_{$slug}_ads_attributes", $ad); ?>
    </div>
<?php endforeach; ?>