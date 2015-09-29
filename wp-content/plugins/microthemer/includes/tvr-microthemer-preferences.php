<?php
// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
	die('Please do not call this page directly.'); 
}

// is edge mode active?
if ($this->edge_mode['available'] and !empty($this->preferences['edge_mode'])){
    $this->edge_mode['active'] = true;
}

?>

<!-- Edit Preferences -->
<form id="tvr-preferences" name='preferences_form' method="post" autocomplete="off"
      action="admin.php?page=<?php echo $page_context;?>" >
    <?php wp_nonce_field('tvr_preferences_submit'); ?>
	<?php echo $this->start_dialog('display-preferences', esc_html__('Edit your Microthemer preferences', 'tvr-microthemer'), 'small-dialog',
		array(
			esc_html__('General', 'tvr-microthemer'),
			esc_html__('CSS Units', 'tvr-microthemer'),
            esc_html__('Inactive', 'tvr-microthemer')
		)
	); ?>

<div class="content-main dialog-tab-fields">

    <?php
    $tab_count = -1; // start at -1 so ++ can be used for all tabs
    ?>

	<!-- Tab 1 (General Preferences) -->
	<div class="dialog-tab-field dialog-tab-field-<?php echo ++$tab_count; ?> hidden show">
		<ul class="form-field-list">
			<?php
			if (!$this->edge_mode['available']){
			   ?>
				<li class="edge-mode-unavailable"><?php esc_html_e('Nothing to try in Edge mode.', 'tvr-microthemer'); ?>
					<a target="_blank" href="<?php echo $this->edge_mode['edge_forum_url']; ?>"><?php esc_html_e('Learn about the last pilot', 'tvr-microthemer'); ?></a>.</li>
			   <?php
			}
			// yes no options
			$yes_no = array(
				'edge_mode' => array(
					'label' => esc_html__('Enable edge mode. ', 'tvr-microthemer') . ' <a title="' .
						__('Read a full explanation of the changes and give us constructive feedback on this forum thread.', 'tvr-microthemer') .
						'" href="'.$this->edge_mode['edge_forum_url'].'" target="_blank">' . esc_html__('Read about/comment here', 'tvr-microthemer') . '</a>',
					'explain' => $this->edge_mode['cta'],
				),
				'first_and_last' => array(
					'label' => esc_html__('Add "first" and "last" classes to menu items', 'tvr-microthemer'),
					'explain' => esc_attr__('Microthemer can insert "first" and "last" classes on WordPress menus so that you can style the first or last menu items a bit differently from the rest. Note: this only works with "Custom Menus" created on the  Appearance > Menus page.', 'tvr-microthemer')
				),

				'gzip' => array(
					'label' => esc_html__('Gzip the Microthemer UI page for faster loading', 'tvr-microthemer'),
					'explain' =>esc_attr__('The Microthemer interface generates quite a bit of HTML. Having this gzip option enabled will speed up the initial page loading.', 'tvr-microthemer')
				),
				'ie_notice' => array(
					'label' => esc_html__('Display "Chrome is faster" notice', 'tvr-microthemer'),
					'explain' => esc_attr__('Microthemer advises using Chrome if you are using an alternative because the interface runs noticeably faster in Chrome. But you can turn this off if you want.' , 'tvr-microthemer')
				),
				'safe_mode_notice' => array(
					'label' => 'Display PHP safe mode warnings',
					'explain' => esc_attr__('If your server has the PHP settings "safe mode" on, you may encounter permission errors when Microthemer tries to create directories. Microthemer will alert you to safe-mode being on. But if that\'s old news to you, you may want to disable the warnings about it.', 'tvr-microthemer')
				),
				'css_important' => array(
					'label' => esc_html__('Always add !important to CSS styles', 'tvr-microthemer'),
					'label_no' => '(configure manually)',
					'explain' => esc_attr__('Always add the "!important" CSS declaration to CSS styles.This largely solves the issue of having to understand how CSS specificity works. But if you prefer, you can disable this functionality and still apply "!important" on a per style basis by clicking the faint "i\'s" that will appear to the right of every style input.', 'tvr-microthemer')
				),
				'pie_by_default' => array(
					'label' => esc_html__('Always use CSS3 PIE polyfill where relevant', 'tvr-microthemer'),
					'label_no' => esc_html__('(configure manually)', 'tvr-microthemer'),
					'explain' => esc_attr__('Always include to the CSS3 PIE htc file if gradients, rounded corners, or box-shadow have been applied to make them work in Internet Explorer 6-8. Note: a "position" value of "relative" will automatically be applied to the selector unless you explicitly set the position property to "static" or some other value. Set this option to "No" if you would like to enable this polyfill on a per selector basis.', 'tvr-microthemer')
				),
				'admin_bar_shortcut' => array(
					'label' => esc_html__('Add a Microthemer shortcut to the WP admin bar', 'tvr-microthemer'),
					'explain' => esc_attr__('Include a link to the Microthemer interface from the WordPress admin toolbar at the top of every page.', 'tvr-microthemer')
				),
				'top_level_shortcut' => array(
					'label' => esc_html__('Include admin bar shortcut as a top level link', 'tvr-microthemer'),
					'explain' => esc_attr__('If you are enabling the Microthemer shortcut in the admin bar, you can either have it as a top level menu link or as a sub-menu item of the main menu.', 'tvr-microthemer')
				),
                /*'admin_bar_main_ui' => array(
                    'label' => esc_html__('Display WP admin bar on Microthemer page', 'tvr-microthemer'),
                    'explain' => esc_html__('Display the WordPress admin bar at the top of the main Microthemer interface page')
                ),*/
                'admin_bar_preview' => array(
                    'label' => esc_html__('Display WP admin bar on site preview', 'tvr-microthemer'),
                    'explain' => esc_attr__('Display the WordPress admin bar at the top of every page in the site preview', 'tvr-microthemer')
                ),
				/*'boxsizing_by_default' => array(
					'label' => __('Always use the box-sizing polyfill where relevant', 'tvr-microthemer'),
					'label_no' => __('(configure manually)', 'tvr-microthemer'),
					'explain' => __('Always include to the box-sizing htc file if the box-sizing property has been applied to make it work in Internet Explorer 6 and 7. Set this option to "No" if you would like to enable this polyfill on a per selector basis. Note: this polyfill doesn\'t work on text inputs.', 'tvr-microthemer')
				)*/
			);
			// text options
			$text_input = array(
				'preview_url' => array(
					'label' => esc_html__('Frontend preview URL Microthemer should load', 'tvr-microthemer'),
					'explain' => esc_attr__('Manually specify a link to the page you would like Microthemer to load for editing when it first starts. By default Microthemer will load your home page or the last page you visited. This option is useful if you want to style a page that can\'t be navigated to from the home page or other pages.', 'tvr-microthemer')
				),
				'gfont_subset' => array(
                    'label' => esc_html__('Google Font subset URL parameter', 'tvr-microthemer'),
                    'explain' => esc_html__('You can instruct Google Fonts to include a font subset by entering an URL parameter here. For example "&subset=latin,latin-ext" (without the quotes). Note: Microthemer only generates a Google Font URL if it detects that you have applied Google Fonts in your design.', 'tvr-microthemer'),
				),
                'tooltip_delay' => array(
                    'label' => esc_html__('Tooltip delay time (in milliseconds)', 'tvr-microthemer'),
                    'explain' => esc_html__('Control how long it takes for a Microthemer tooltip to display. Set to "0" for instant, "native" to use the browser default tooltip on hover, or some value like "2000" for a 2 second delay (so it never shows when you don\'t need it to). The default is 500 milliseconds.', 'tvr-microthemer')
				)

			);

			// display form fields
			$this->output_radio_input_lis($yes_no);
			$this->output_text_combo_lis($text_input);

			?>
		</ul>
        <div class="explain">
            <div class="heading link explain-link"><?php _e("About this feature", "tvr-microthemer"); ?></div>

            <div class="full-about">
                <p><?php _e("Set your global Microthemer preferences on this page. Hover your mouse over the option labels for further information on each option.", "tvr-microthemer"); ?></p>
                <?php
                if (!$this->preferences['buyer_validated']){
                    ?>
                    <p><?php printf(
						wp_kses(
							esc_html__('Please unlock the full program by entering your PayPal email address on <span %s>this page</span>.', 'tvr-microthemer'),
							array( 'span' => array() )
						),
						'class="link show-dialog" rel="unlock-microthemer"'
                    ); ?></p>
                <?php
                }
                ?>
                <p><?php printf(
					wp_kses(
                        esc_html__('You may also wan to customise the default media queries Microthemer suggests on <span %s>this page</span>.', 'tvr-microthemer'),
						array( 'span' => array() )
					),
                    'class="link show-dialog" rel="edit-media-queries"'
                    ); ?></p>
            </div>
        </div>
	</div>

	<!-- Tab 2 (CSS Units)  -->
	<div class="dialog-tab-field dialog-tab-field-<?php echo ++$tab_count; ?> hidden">

		<ul class="form-field-list css_units">

            <li><span class="reveal-hidden-form-opts link reveal-unit-sets" rel="css-unit-set-opts">
                    <?php esc_html_e('Load a full set of suggested CSS units', 'tvr-microthemer'); ?></span></li>
            <?php
            $css_unit_sets = array(
                'load_css_unit_sets' => array(
                    'input_id' => 'css_unit_set',
                    'combobox' => 'css_unit_sets',
                    'label' => __('Select a set of default units', 'tvr-microthemer'),
                    'explain' => __('Pixels are easier to work with. Consequently, pixels are the default CSS unit Microthemer applies. But many consider it best practice to use em (or rem) units in most instances. You can quickly load a full set of suggested CSS units here.', 'tvr-microthemer')
                )
            );

            $this->output_text_combo_lis($css_unit_sets, 'hidden css-unit-set-opts');

            // output CSS unit options
            foreach($this->preferences['my_props'] as $prop_group => $array){

                // loop through default unit props
                if (!empty($this->preferences['my_props'][$prop_group]['pg_props'])){
                    $first = true;
                    foreach ($this->preferences['my_props'][$prop_group]['pg_props'] as $prop => $arr){
                        unset($units);
                        // user doesn't need to set all padding (for instance) individually
                        $box_model_rel = false;
                        $first_in_group = false;
                        $label = $arr['label'];
                        if (!empty($this->propertyoptions[$prop_group][$prop]['rel'])){
                            $box_model_rel = $this->propertyoptions[$prop_group][$prop]['rel'];
                        }
                        if (!empty($this->propertyoptions[$prop_group][$prop]['sub_label'])){
                            $first_in_group = $this->propertyoptions[$prop_group][$prop]['sub_label'];
                        }
                        // only output unit eligable props
                        if ( empty($arr['default_unit']) or ($box_model_rel and !$first_in_group)  ){
                            continue;
                        }
                        // use group sub label if first box model e.g. padding, margin, border width, border radius
                        if ($box_model_rel and $first_in_group){
                            $label = $first_in_group . ' (all)';
                        }
                        // we don't need position repeated all the time
                        $label = str_replace(' (Position)', '', $label);

                        // output pg group heading if new group
                        if ($first){
                            echo
                            '<li class="section_title">' .
                            $this->preferences['my_props'][$prop_group]['pg_label']
                            . '</li>';
                            $first = false;
                        }
                        // output form fields
                        $units['cssu_'.$prop] = array(
                            'input_class' => 'custom_css_unit',
                            'arrow_class' => 'custom_css_unit',
                            'combobox' => 'css_units',
                            'input_name' => 'tvr_preferences[new_css_units]['.$prop_group.']['.$prop.']',
                            'input_value' => $this->preferences['my_props'][$prop_group]['pg_props'][$prop]['default_unit'],
                            'label' => $label,
                            'explain' => 'Set the default CSS unit for ' . $arr['label']
                        );
                        $this->output_text_combo_lis($units);
                    }
                }
            }
			?>
		</ul>

        <div class="explain">
            <div class="heading link explain-link"><?php _e("About this feature", "tvr-microthemer"); ?></div>

            <div class="full-about">
                <p><?php _e("Set your default CSS units here. On initial install, 'px (implicit)' (simple pixels set) is the standard setting for all fields that accept numerical values. This means that if you enter a number (with no CSS unit) pixels will be added behind the scenes. Other options include ems, rems, % and more. If you set one of these, your numeric value will be given a unit automatically just before saving.", "tvr-microthemer"); ?></p>
                <p><?php _e("There are also some options for auto-converting pixels to ems, rems, or percentages: 'px to em' or 'px to rem' or 'px to %'. For instance, if you set 'px to em' on the font-size property and then enter '32', Microthemer will obtain the font-size context and convert 32 pixels into an equivalent em value. So if the font-size context was 16px, Microthemer would convert this to '2em'.", "tvr-microthemer"); ?></p>
                <p><?php _e("Finally, Excel-like formulas can now be used in style fields for auto converting pixels to percentages or ems. Enter =%(200) into the width field (for instance) and Microthemer will calculate 200 pixels as a percentage of the parent element's width. You can also use =em(36, 2). If the font-size context was 12, Microthemer would convert this to 3em. The extra '2' parameter is optional. If specified, the context of the nth element would be used if the selector matches multiple elements (rather the defaulting to the first element in the selection).", "tvr-microthemer"); ?></p>
                <p><?php _e("These auto-conversion options can save you from having to use a calculator in combination with a browser inspector. They are particularly useful when converting a pixel based PSD file into a fluid or elastic website design.", "tvr-microthemer"); ?></p>
            </div>
        </div>

	</div>

    <!-- Tab 3 (Inactive)  -->
    <div class="dialog-tab-field dialog-tab-field-<?php echo ++$tab_count; ?> hidden">

        <ul class="form-field-list css_units">
            <?php
            // yes no options
            $yes_no = array(
                'clean_uninstall' => array(
                    'label' => esc_html__('Upon Uninstall, Delete ALL Microthemer Data', 'tvr-microthemer'),
                    'explain' => esc_html__('Microthemer database settings and the contents of the /micro-themes folder are not deleted by default when you uninstall Microthemer. But they can be if you set this option to Yes.', 'tvr-microthemer'),
                )
            );
            $this->output_radio_input_lis($yes_no);

            ?>
        </ul>

        <div id="functions-php">
            <div class="heading"><?php echo esc_html__('Manually Load Microthemer Styles', 'tvr-microthemer'); ?></div>
            <p><?php echo esc_html__('As long as you don\'t set the above option to Yes, you can uninstall Microthemer and still use the customisations you made with it. Simply copy and paste the code below at the bottom of your theme\'s functions.php file. The code will not cause any problems when Microthemer is active. It simply won\'t run. So you can safely paste and forget.', 'tvr-microthemer'); ?></p>
            <textarea><?php
                echo esc_html(
                    file_get_contents(
                        $this->thisplugindir . '/includes/functions.php-code.txt',
                        FILE_USE_INCLUDE_PATH
                    )
                );
                ?></textarea>
        </div>
    </div>

    <?php // echo $this->dialog_button(__('Save Preferences', 'tvr-microthemer'), 'input', 'save-preferences'); ?>


</div>

<?php echo $this->end_dialog(esc_html__('Save Preferences', 'tvr-microthemer'), 'input', 'save-preferences'); ?>
</form>
