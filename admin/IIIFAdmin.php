<?php

defined("ABSPATH") or die("Nothing to see here.");

class IIIFAdmin
{
	private $adminOwner;
	
	public function setAdminOwner($owner) {
		$this->adminOwner = $owner;
	}
	
	public function getAdminOwner() {
		return $this->adminOwner;
	}

	public function adminMenuRegister() {
		add_menu_page(
			'IIIF UV Plugin Options',
			'IIIF UV',
			'manage_options',
			'iiif-uv',
			array($this,'generateAdminPage'),
			get_site_url() . '/wp-content/plugins/folger_iiif_uv/include/uv/favicon.ico'
		);
	}

	public function generateAdminPage() {
	    wp_enqueue_style('iiif-admin-css',$this->getAdminOwner()->getPluginPath() . 'include/iif_admin.css');
		?>
        <script type="text/javascript">
            var iiif_Root = "<?php echo $this->getAdminOwner()->getPluginPath() . 'include/iiif/';?>";
        </script>
		<div class="wrap">
			<div class="wrap-settings" >
				<h1>IIIF UV Plugin Options</h1>
			</div>
            <hr/>
            <div class="miranda-documentation">
                <span class="miranda-doc-bold miranda-doc-sec">IIIF Presentation Endpoint:</span>
                <p>
                <span class="miranda-doc-bold miranda-doc-sec">Using this plugin:</span>
                <p>
                    <span class="miranda-doc-para">To use this plugin all that needs to be done is to insert a "shortcode" into the page/post that IIIF content is desired to display.
                        This short code takes 1 value only for Universal Viewer, and that is the presentation API URI of the desired IIIF manifest.
                    </span>
                </p>
                <span class="miranda-doc-bold miranda-doc-sec">Short Code:</span><br/>
                    <pre>
                        [iiif_uv manifest="https://example.org/iiif/1/manifest.json"]
                    </pre>
                <p>
                    <span class="miranda-doc-para">
                        Copy and paste this short code into the desired page/post and replace manifest with the actual URI of the desired IIIF manifest.
                        Please be sure to leave the "" marks around the manifest . Example:
                    </span>
                </p>
                    <pre>
                        [iiif_uv manifest="https://example.org/iiif/1/manifest.json"]
                    </pre>
                <p>
                    <span class="miranda-doc-para">
                        The above is how the shortcode should look inserted into the post.  Please insert the code in the rich editor at the place where it is desired to have the content appear.
                    </span>
                </p>
            </div>

		</div>
		<?php
	}

	public function registerSettings() {
	}

    function __construct($owner)
    {
	    add_action('admin_menu', array($this, 'adminMenuRegister'));
//	    add_action('admin_init', array($this, 'registerSettings'));

        $this->adminOwner = $owner;
    }
}
