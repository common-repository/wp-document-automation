<?php
namespace WP\Plugin\DocumentAutomation\WP;

/**
 *
 */
class Admin
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Admin menu for document automation.
     *
     * @return [type] [description]
     */
    public function admin_menu()
    {
        add_menu_page(
            'Document Automation Template Management',
            'Document Automation',
            'manage_options',
            'wp-doc-automation-os-admin-page.php',
            [$this, 'settings_page'],
            'dashicons-media-document',
            6
        );
    }

    /**
     * Settings page.
     *
     * @return [type] [description]
     */
    public function settings_page()
    {
        $data = [];

        // Upload document template
        if (isset($_POST['upload'])
            && ($_POST['upload'] == 'wpda-os-upload')
        ) {
            if ($_FILES && isset($_FILES['template_file']) && !$_FILES['template_file']['error']) {
                $upload_dir = wp_upload_dir();
                $dir        = $upload_dir['basedir'] . '/wp-document-automation';

                if (!file_exists($dir)) {
                    wp_mkdir_p($dir);
                }

                $allow     = ['fodt'];
                $extension = strtolower(pathinfo($_FILES['template_file']['name'], PATHINFO_EXTENSION));
                if (in_array($extension, $allow)) {
                    $file_path = $dir . '/' . $_FILES['template_file']['name'];
                    move_uploaded_file($_FILES['template_file']['tmp_name'], $file_path);
                    $relative_path = str_replace(ABSPATH, '', $file_path);
                    $this->container['template']->set_template_options_path($relative_path);
                    $data['message'] = 'Document template file uploaded.';
                } else {
                    $data['error'] = 'File type not supported';
                }

            } else {
                $data['error'] = 'Error uploading file';
            }
        }

        $data['template_url'] = $this->container['template']->get_template_url();

        if ($data['template_url']) {
            $data['fields'] = $this->container['template']->get_template_fields();
        }

        echo $this->container['view']->render('admin.settings.document-automation', $data);
    }
}
