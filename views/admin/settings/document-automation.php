<div class="wrap">
    <h1 class='wp-heading-inline'>WP Document Automation</h1>
    <hr class="wp-header-end"/>

    <?php
        if (isset($message)) {
            $class = 'notice notice-info';

            printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
        }
    ?>

    <form action='<?php echo home_url("/wp-admin/admin.php?page=wp-doc-automation-os-admin-page.php") ?>' method='POST' enctype="multipart/form-data">
        <input type="hidden" name="__inv_action" value='upload_template'>
        <table style="width:100%;padding:3em 0;font-size:1.5em; background:white;padding:2em;">
            <tbody>
                <tr>
                    <td>
                        <label for="">Choose Document Template&nbsp;&nbsp;</label>
                        &nbsp;<input type="file" name='template_file' accept='.fodt'></td>
                        <td>&nbsp;</td>
                    </tr>

                    <tr style="width:100%;">
                        <td colspan="2" style="font-size:0.5em; color:grey">
                            <p>
                                Select .fodt file, a Flat XML OpenDocument Template. You can use <a href="https://www.libreoffice.org/download/download/" target="_blank">Libre Office</a>, a free software, to create a document template. Its work on Windows, OSX and Linux. 
</p>
<p>
A sample fodt file, <a href="https://www.dropbox.com/s/0bsvnmp4ro4owbn/hdfc-neft-rtgs.fodt?dl=0" target="_blank">hdfc-neft-rtgs.fodt</a>, is available for your reference. This document template is created from a pdf file. 
</p>


                        </td>
                    </tr>

                    <tr style="width:100%">
                        <td style="padding-top:1.5em;" colspan="2">
                            <button type="submit" name='upload' value='wpda-os-upload' style="height:2em;font-size:1em;padding: 0 3em;" class='button button-primary'>
                                Upload
                            </button>
	
                <?php if (isset($template_url)): ?>
                            <p>
                                Uploaded template : <a href="<?php echo $template_url ?>"><?php echo pathinfo($template_url, PATHINFO_BASENAME) ?></a>
                            </p>
                <?php endif;?>
                        </td>
                    </tr>

        <?php if (isset($error)): ?>
                        <tr style="width:100%;">
                            <td colspan="2" style="padding-top:0.5em;text-align: center;font-size:0.5em; color:red"><?php echo $error; ?></td>
                        </tr>
        <?php endif;?>

                </tbody>
            </table>
        </form>

    </div> <!-- end wrap -->

    <?php if (isset($data['fields'])): ?>
        <div class="wrap" style='background-color: white; padding: 2em;'>

            <strong style="font-size: 1.5em; margin: 1em 0; display: block;">Create Document </strong>

            <form action='<?php echo home_url("/wp-admin/admin.php?page=wp-doc-automation-os-admin-page.php") ?>' method='POST'>
                <input type="hidden" name="__inv_action" value='create_document'>
                <table style="width:100%;">
                    <tbody>
                        <?php $fields = array_slice($data['fields'], 0, 5)?>

                        <?php foreach ($fields as $field): ?>
                            <tr>
                                <td style="width:300px;">
                                    <label><strong><?php echo $this->container['template']->convertFieldNameToLabel($field); ?><strong></label>
                                </td>
                                <td><input type="text" name="<?php echo $field; ?>"></td>
                            </tr>
                        <?php endforeach?>

                        <td style="padding-top:1.5em;" colspan="2">
                            <p style="color:#dc3232">This form supports a maximum of 5 document fields. Our <a href="">premium version</a> supports unlimited document fields using gravity forms integration, multiple file creation per form using document categories and much more.</p>
                            <button type="submit" name='__action' value='wpda-os-create-doc' style="height:2em;font-size:1.5em;padding: 0 3em;" class='button button-primary'>
                                Create Document
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>

            <p>
                <strong>Your document template has the following                                                                                                                                 <?php echo count($data['fields']) ?> fields</strong>
                <ul style="list-style-type: disc; margin-left: 1em;">
                    <?php foreach ($data['fields'] as $field): ?>
                        <li><?php echo $field; ?></li>
                    <?php endforeach?>
                </ul>
            </p>
        </div>

    <?php endif?>
