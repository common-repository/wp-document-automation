<?php
namespace WP\Plugin\DocumentAutomation\Document;

use OA\OpenDocument\FlatXML\DOM;

/**
 *
 */
class Template
{
    protected $container;

    protected $gf_options_key;

    protected $gf_title;

    protected $template_file_options_key;

    protected $template_path;

    public function __construct($container)
    {
        $this->container                 = $container;
        $this->gf_options_key            = 'wpda_gf_id';
        $this->gf_title                  = 'WP Documentation Automation Input Form';
        $this->template_file_options_key = 'wpda_template_file';
    }

    /**
     * Convert a given field name to a label.
     *
     * @param  [type] $fieldName      [description]
     * @return [type] [description]
     */
    public function convertFieldNameToLabel($fieldName)
    {
        return ucwords(str_replace('_', ' ', $fieldName));
    }

    /**
     * Get document templates DOM object.
     *
     * @param  [type] $template_path  [description]
     * @return [type] [description]
     */
    public function get_template_dom($template_path = null)
    {
        if (is_null($template_path)) {
            $template_path = $this->get_template_path();
        }

        $dom = new DOM();
        try {
            $dom->loadXMLFile($template_path);
            return $dom;
        } catch (Exception $e) {
            return new WP_Error($e->getMessageCode(), $e->getMessage());
        }
    }

    /**
     * Get the fields in the document object.
     *
     * @param  [type] $template_path  [description]
     * @return [type] [description]
     */
    public function get_template_fields($template_path = null)
    {
        if (is_null($template_path)) {
            $template_path = $this->get_template_path();
        }
        $dom = $this->get_template_dom($template_path);

        if (is_wp_error($dom)) {
            return $dom;
        }

        $fields = $dom->extractFields();
        unset($dom);
        return $fields;
    }

    /**
     * File path of template
     *
     * @return [type] [description]
     */
    public function get_template_path()
    {
        if (!$this->template_path) {
            return ABSPATH . '/' . get_option($this->template_file_options_key, '');
        }

        return $this->template_path;
    }

    /**
     * URL of the template
     *
     * @return [type] [description]
     */
    public function get_template_url()
    {
        $path = get_option($this->template_file_options_key, '');
        if (!$path) {
            return '';
        }
        return site_url('/' . $path);
    }

    public function process_file_create_request()
    {
        // Create document
        if (isset($_POST['__action'])
            && ($_POST['__action'] == 'wpda-os-create-doc')
        ) {
            $dom                = $this->container['template']->get_template_dom();
            $dom_fields         = $dom->extractFields();
            $dom_field_defaults = [];
            foreach ($dom_fields as $dom_field) {
                $dom_field_defaults[$dom_field] = '';
            }

            $submitted_data = [];
            foreach ($_POST as $key => $value) {
                $submitted_data[str_replace('_', ' ', $key)] = $value;
            }
            $submitted_data = array_merge($submitted_data, $_POST);

            // merge defaults.
            $field_key_values = array_merge($dom_field_defaults, $submitted_data);
            $dom->overwriteFields($field_key_values);

            $xml = $dom->saveXML();
            unset($dom);
            do_action('wp-single-template-on-gf-save', [$xml]);
            $file = $this->container['template']->get_template_path();
            $file = time() . '-' . pathinfo($file, PATHINFO_BASENAME);

            @header("Content-type: application/x-msdownload", true, 200);
            @header("Content-Disposition: attachment; filename={$file}");
            @header("Pragma: no-cache");
            @header("Expires: 0");
            echo $xml;
            exit();

        }
    }

    /**
     * Set template file path in options
     *
     * @param [type] $relative_path [description]
     */
    public function set_template_options_path($relative_path)
    {
        update_option($this->template_file_options_key, $relative_path);
    }

    /**
     * Get template path
     *
     * @param [type] $path [description]
     */
    public function set_template_path($path)
    {
        $this->template_path = $path;
    }
}
