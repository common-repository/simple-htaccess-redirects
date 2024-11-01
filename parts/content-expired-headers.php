<div id="advgb-settings-container">

<div class="profiles-list-wrapper">
                                   <form id="redirectForm" method="post" action="options.php">
							
								  <?php settings_fields( 'PK-redirect-settings-group' ); ?>
								  <?php do_settings_sections( 'PK-redirect-settings-group' ); ?>
                                    <table id="profiles-list">
                                        <thead>
                                            <tr>
                                                <th class="profile-header-checkbox select-box">
                                                    <input type="checkbox" class="select-all-profiles ju-checkbox">
                                                </th>
                                                <th class="profile-header-titler">
                                                    <span>
                        								<span>Type</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
                                                <th class="profile-header-author">
                                                    <span>
                       								 <span>Value</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
												<th class="profile-header-author">
                                                    <span>
                       								 <span>Length</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="advgb-profile">
                                                <td class="profile-checkbox select-box">
													<input name="WriteCSS" type="checkbox" id="myCSSCheck" value="1" <?php checked( '1', get_option( 'WriteCSS' ) ); ?>>
                                                </td>
                                                <td class="profile-title">
                                                    <a href="#" class="advgb_qtip">
                           								 CSS                    
													</a>
													
                                                    
                                                </td>
                                                <td class="profile-author">
													<input type="number" min="0" name="_PK_css_value" value="<?php echo esc_attr( get_option('_PK_css_value') ); ?>">
												</td>
												    <?php
													$defaultArray = Array (
														'select_field_0' => 'seconds'
													);
													if(!get_option( '_PK_css_options' )){
														
														update_option('_PK_css_options', $defaultArray);
													}
												

												
													$CSS_options = get_option( '_PK_css_options' );
													$CSS_selectedOption = $CSS_options['select_field_0'];
				
												
													?>
												  <td class="profile-author">
													 <select class="_PK_css_value" name='_PK_css_options[select_field_0]'>
													  <option value="seconds" <?php selected( $CSS_options['select_field_0'], 'seconds' ); ?>>Seconds</option>
													  <option value="hour" <?php selected( $CSS_options['select_field_0'], 'hours' ); ?>>Hours</option>
													  <option value="week" <?php selected( $CSS_options['select_field_0'], 'weeks' ); ?>>Weeks</option>
													  <option value="month" <?php selected( $CSS_options['select_field_0'], 'months' ); ?>>Months</option>
													  <option value="year" <?php selected( $CSS_options['select_field_0'], 'years' ); ?>>Years</option>
													</select>
												</td>
                                            </tr>
											
											<tr class="advgb-profile">
                                                <td class="profile-checkbox select-box">
													<input name="WriteJS" type="checkbox" id="myJSCheck" value="1" <?php checked( '1', get_option( 'WriteJS' ) ); ?>>
                                                </td>
                                                <td class="profile-title">
                                                    <a href="#" class="advgb_qtip">
                           								 JS                        
													</a>
                                                    
                                                </td>
                                                <td class="profile-author">
													<input type="number" min="0" name="_PK_js_value" value="<?php echo esc_attr( get_option('_PK_js_value') ); ?>">
												</td>
												  <td class="profile-author">
													   <?php
													  	if(!get_option( '_PK_js_options' )){
														
														update_option('_PK_js_options', $defaultArray);
														}
														$JS_options = get_option( '_PK_js_options' );
														$JS_selectedOption = $JS_options['select_field_0'];
														
														?>
													  <select class="_PK_js_value" name='_PK_js_options[select_field_0]'>
														  <option value="seconds" <?php selected( $JS_options['select_field_0'], 'seconds' ); ?>>Seconds</option>
														  <option value="hour" <?php selected( $JS_options['select_field_0'], 'hours' ); ?>>Hours</option>
														  <option value="week" <?php selected( $JS_options['select_field_0'], 'weeks' ); ?>>Weeks</option>
														  <option value="month" <?php selected( $JS_options['select_field_0'], 'months' ); ?>>Months</option>
														  <option value="year" <?php selected( $JS_options['select_field_0'], 'years' ); ?>>Years</option>
														</select>
												</td>
                                            </tr>
											
											<tr class="advgb-profile">
                                                <td class="profile-checkbox select-box">
													<input name="WritePNG" type="checkbox" id="myPNGCheck" value="1" <?php checked( '1', get_option( 'WritePNG' ) ); ?>>
                                                </td>
                                                <td class="profile-title">
                                                    <a href="#" class="advgb_qtip">
                           								 PNG                        
													</a>
                                                    
                                                </td>
                                                <td class="profile-author">
													<input type="number" min="0" name="_PK_png_value" value="<?php echo esc_attr( get_option('_PK_png_value') ); ?>">
												</td>
												  <td class="profile-author">
													  
													    <?php
													 	 if(!get_option( '_PK_png_options' )){
														
															update_option('_PK_png_options', $defaultArray);
														}
													  
														$PNG_options = get_option( '_PK_png_options' );
														$PNG_selectedOption = $PNG_options['select_field_0'];
													  
													
														?>
													 <select class="_PK_png_value" name='_PK_png_options[select_field_0]'>
													  <option value="seconds" <?php selected( $PNG_options['select_field_0'], 'seconds' ); ?>>Seconds</option>
													  <option value="hour" <?php selected( $PNG_options['select_field_0'], 'hours' ); ?>>Hours</option>
													  <option value="week" <?php selected( $PNG_options['select_field_0'], 'weeks' ); ?>>Weeks</option>
													  <option value="month" <?php selected( $PNG_options['select_field_0'], 'months' ); ?>>Months</option>
													  <option value="year" <?php selected( $PNG_options['select_field_0'], 'years' ); ?>>Years</option>
													</select>
												</td>
                                            </tr>
											
											<tr class="advgb-profile">
                                                <td class="profile-checkbox select-box">
													<input name="WriteJPG" type="checkbox" id="myJPGCheck" value="1" <?php checked( '1', get_option( 'WriteJPG' ) ); ?>>
                                                </td>
                                                <td class="profile-title">
                                                    <a href="#" class="advgb_qtip">
                           								 JPG                        
													</a>
                                                    
                                                </td>
                                                <td class="profile-author">
													<input type="number" min="0" name="_PK_jpg_value" value="<?php echo esc_attr( get_option('_PK_jpg_value') ); ?>">
												</td>
												  <td class="profile-author">
													  <select class="_PK_jpg_value" name='_PK_jpg_options[select_field_0]'>
														    <?php
														   if(!get_option( '_PK_jpg_options' )){
														
																update_option('_PK_jpg_options', $defaultArray);
															}
														  
															$JPG_options = get_option( '_PK_jpg_options' );
															$JPG_selectedOption = $JPG_options['select_field_0'];
														 
															?>
														  <option value="seconds" <?php selected( $JPG_options['select_field_0'], 'seconds' ); ?>>Seconds</option>
														  <option value="hour" <?php selected( $JPG_options['select_field_0'], 'hours' ); ?>>Hours</option>
														  <option value="week" <?php selected( $JPG_options['select_field_0'], 'weeks' ); ?>>Weeks</option>
														  <option value="month" <?php selected( $JPG_options['select_field_0'], 'months' ); ?>>Months</option>
														  <option value="year" <?php selected( $JPG_options['select_field_0'], 'years' ); ?>>Years</option>
														</select>
												</td>
                                            </tr>

											
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="profile-header-checkbox select-box">
                                                    <input type="checkbox" class="select-all-profiles ju-checkbox">
                                                </th>
                                                <th class="profile-header-titler">
                                                    <span>
                        								<span>Type</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
                                                <th class="profile-header-author">
                                                    <span>
                       								 <span>Value</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
												<th class="profile-header-author">
                                                    <span>
                       								 <span>Length</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
												
                                            </tr>
                                        </tfoot>
                                    </table>
									       <input type="hidden" name="_PK_301_new_setting" value="<?php echo esc_attr( get_option('_PK_301_new_setting') ); ?>" />
											<input type="hidden" name="_PK_301_old_setting" value="<?php echo esc_attr( get_option('_PK_301_old_setting') ); ?>" />
											<input type="hidden" name="_PK_302_old_setting" value="<?php echo esc_attr( get_option('_PK_302_old_setting') ); ?>" />
											<input type="hidden" name="_PK_302_new_setting" value="<?php echo esc_attr( get_option('_PK_302_new_setting') ); ?>" />
											<input type="hidden" name="_PK_404_setting" value="<?php echo esc_attr( get_option('_PK_404_setting') ); ?>" />
											<input type="hidden" name="_PK_500_setting" value="<?php echo esc_attr( get_option('_PK_500_setting') ); ?>" />
											<input type="hidden" name="_PK_500_setting" value="<?php echo esc_attr( get_option('_PK_redirect_old_urls') ); ?>" />
											<input type="hidden" name="_PK_500_setting" value="<?php echo esc_attr( get_option('_PK_redirect_new_urls') ); ?>" />


									     <?php submit_button( __( 'Save Changes', 'textdomain' ), 'ju-button orange-button waves-effect waves-light', 'expiredForm', false ); ?>
								</form>
									
                                </div>

<div class="wrap container">



 <!-- png -->
   <?php if(get_option('WritePNG') == '1' && get_option('WriteJPG') == '1' && get_option('WriteCSS') == "1" && get_option('WriteJS') == "1") {  // png, jpg, css, js?>
     <?php

     $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');


     $contentPNG = PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on"
     . PHP_EOL . "ExpiresByType " . "image/png" . ' "access plus ' . get_option('_PK_png_value'). " " . $PNG_selectedOption .'"'
     . PHP_EOL . "ExpiresByType " . "image/jpg" . ' "access plus ' . get_option('_PK_jpg_value'). " " . $JPG_selectedOption . '"'
     . PHP_EOL . "ExpiresByType " . "text/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"'
     . PHP_EOL . "ExpiresByType " . "application/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"'
     . PHP_EOL . "ExpiresByType " . "text/css" . ' "access plus ' . get_option('_PK_css_value'). " " . $CSS_selectedOption . '"'
     . PHP_EOL .  "</IfModule>" . PHP_EOL;
     $content = $content . $contentPNG;

     fwrite($accessfilewrite, $contentPNG);
     update_option( 'WritePNG' , "0" );
     update_option( 'WriteJPG' , "0" );
     update_option( 'WriteJS' , "0" );
     update_option( 'WriteCSS' , "0" );
     fclose($accessfilewrite);

   ?>
   <?php

      ?>

   <?php } else if(get_option('WritePNG') == '1' && get_option('WriteJPG') != '1' && get_option('WriteCSS') != '1' && get_option('WriteJS') != "1"){ //png

    $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

    $contentPNG =
    PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on"
    . PHP_EOL . "ExpiresByType " . "image/png" . ' "access plus ' . get_option('_PK_png_value'). " " . $PNG_selectedOption .'"'
    . PHP_EOL .  "</IfModule>" . PHP_EOL;
    $content = $content . $contentPNG;

    fwrite($accessfilewrite, $contentPNG);
    update_option( 'WritePNG' , "0" );
    fclose($accessfilewrite);

  ?>
  <script type="text/javascript">
     document.getElementById("myPNGCheck").checked = false;
     //window.location.reload();
  </script>
  <?php

} else if(get_option('WritePNG') != '1' && get_option('WriteJPG') != '1' && get_option('WriteCSS') == '1' && get_option('WriteJS') != "1"){ //css

    $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

    $contentJPG =
    PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
    PHP_EOL . "ExpiresByType " . "text/css" .  ' "access plus ' . get_option('_PK_css_value'). " " . $CSS_selectedOption .'"' .
    PHP_EOL . "</IfModule>" . PHP_EOL;
    $content = $content . $contentJPG;

    fwrite($accessfilewrite, $contentJPG);
    update_option( 'WriteCSS' , "0" );
    fclose($accessfilewrite);

  ?>
  <script type="text/javascript">
     document.getElementById("myCSSCheck").checked = false;
     //window.location.reload();
  </script>
  <?php
} else if(get_option('WritePNG') != '1' && get_option('WriteJPG') == '1' && get_option('WriteCSS') != '1' && get_option('WriteJS') != "1"){ //jpg

      $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

      $contentJPG =
      PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
      PHP_EOL . "ExpiresByType " . "image/jpg" .  ' "access plus ' . get_option('_PK_jpg_value'). " " . $JPG_selectedOption .'"' .
      PHP_EOL . "</IfModule>" . PHP_EOL;
      $content = $content . $contentJPG;

      fwrite($accessfilewrite, $contentJPG);
      update_option( 'WriteJPG' , "0" );
      fclose($accessfilewrite);

    ?>
    <script type="text/javascript">
       document.getElementById("myJPGCheck").checked = false;
       //window.location.reload();
    </script>
    <?php
  }else if(get_option('WritePNG') != '1' && get_option('WriteJPG') == '1' && get_option('WriteCSS') == '1' && get_option('WriteJS') != "1"){ // css, jpg

        $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

        $contentJPG =
        PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
        PHP_EOL . "ExpiresByType " . "text/css" .  ' "access plus ' . get_option('_PK_css_value'). " " . $CSS_selectedOption .'"' .
        PHP_EOL . "ExpiresByType " . "image/jpg" .  ' "access plus ' . get_option('_PK_jpg_value'). " " . $JPG_selectedOption .'"' .
        PHP_EOL . "</IfModule>" . PHP_EOL;
        $content = $content . $contentJPG;

        fwrite($accessfilewrite, $contentJPG);
        update_option( 'WriteJPG' , "0" );
        update_option( 'WriteCSS' , "0" );
        fclose($accessfilewrite);

      ?>
      <script type="text/javascript">
         document.getElementById("myJPGCheck").checked = false;
         //window.location.reload();
      </script>
      <?php
    }else if(get_option('WritePNG') == '1' && get_option('WriteJPG') == '1' && get_option('WriteCSS') != '1' && get_option('WriteJS') != "1"){ // png, jpg

          $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

          $contentJPG =
          PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
          PHP_EOL . "ExpiresByType " . "image/png" .  ' "access plus ' . get_option('_PK_png_value'). " " . $PNG_selectedOption .'"' .
          PHP_EOL . "ExpiresByType " . "image/jpg" .  ' "access plus ' . get_option('_PK_jpg_value'). " " . $JPG_selectedOption .'"' .
          PHP_EOL . "</IfModule>" . PHP_EOL;
          $content = $content . $contentJPG;

          fwrite($accessfilewrite, $contentJPG);
          update_option( 'WritePNG' , "0" );
          update_option( 'WriteJPG' , "0" );
          fclose($accessfilewrite);

        ?>
        <script type="text/javascript">
           document.getElementById("myPNGCheck").checked = false;
           document.getElementById("myJPGCheck").checked = false;
           //window.location.reload();
        </script>
        <?php
      }else if(get_option('WritePNG') == '1' && get_option('WriteJPG') != '1' && get_option('WriteCSS') == '1' && get_option('WriteJS') != "1"){ // css, png

            $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

            $contentJPG =
            PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
            PHP_EOL . "ExpiresByType " . "text/css" .  ' "access plus ' . get_option('_PK_css_value'). " " . $CSS_selectedOption .'"' .
            PHP_EOL . "ExpiresByType " . "image/png" .  ' "access plus ' . get_option('_PK_png_value'). " " . $PNG_selectedOption .'"' .
            PHP_EOL . "</IfModule>" . PHP_EOL;
            $content = $content . $contentJPG;

            fwrite($accessfilewrite, $contentJPG);
            update_option( 'WritePNG' , "0" );
            update_option( 'WriteCSS' , "0" );
            fclose($accessfilewrite);

          ?>
          <script type="text/javascript">
             document.getElementById("myPNGCheck").checked = false;
             document.getElementById("myCSSCheck").checked = false;
             //window.location.reload();
          </script>
      <?php
    }else if(get_option('WritePNG') != '1' && get_option('WriteJPG') == '1' && get_option('WriteCSS') != '1' && get_option('WriteJS') == "1"){ // js, jpg

          $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

          $contentJPG =
          PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
          PHP_EOL . "ExpiresByType " . "image/jpg" .  ' "access plus ' . get_option('_PK_jpg_value'). " " . $JPG_selectedOption .'"' .
          PHP_EOL . "ExpiresByType " . "text/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
          PHP_EOL . "ExpiresByType " . "application/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
          PHP_EOL . "</IfModule>" . PHP_EOL;
          $content = $content . $contentJPG;

          fwrite($accessfilewrite, $contentJPG);
          update_option( 'WriteJS' , "0" );
          update_option( 'WriteJPG' , "0" );
          fclose($accessfilewrite);

        ?>
        <script type="text/javascript">
           document.getElementById("myJSCheck").checked = false;
           document.getElementById("myJPGCheck").checked = false;
           //window.location.reload();
        </script>
        <?php
  }else if(get_option('WritePNG') != '1' && get_option('WriteJPG') != '1' && get_option('WriteCSS') != '1' && get_option('WriteJS') == "1"){ // js

        $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

        $contentJPG =
        PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
        PHP_EOL . "ExpiresByType " . "text/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "ExpiresByType " . "application/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "</IfModule>" . PHP_EOL;
        $content = $content . $contentJPG;

        fwrite($accessfilewrite, $contentJPG);
        update_option( 'WriteJS' , "0" );
        fclose($accessfilewrite);

      ?>
      <script type="text/javascript">
         document.getElementById("myJSCheck").checked = false;
         //window.location.reload();
      </script>
      <?php
}else if(get_option('WritePNG') == '1' && get_option('WriteJPG') != '1' && get_option('WriteCSS') != '1' && get_option('WriteJS') == "1"){ // js, png

        $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

        $contentJPG =
        PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
        PHP_EOL . "ExpiresByType " . "image/png" .  ' "access plus ' . get_option('_PK_png_value'). " " . $PNG_selectedOption .'"' .
        PHP_EOL . "ExpiresByType " . "text/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "ExpiresByType " . "application/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "</IfModule>" . PHP_EOL;
        $content = $content . $contentJPG;

        fwrite($accessfilewrite, $contentJPG);
        update_option( 'WritePNG' , "0" );
        update_option( 'WriteJS' , "0" );
        fclose($accessfilewrite);

      ?>
      <script type="text/javascript">
         document.getElementById("myJSCheck").checked = false;
         document.getElementById("myPNGCheck").checked = false;
         //window.location.reload();
      </script>
      <?php
  }else if(get_option('WritePNG') != '1' && get_option('WriteJPG') != '1' && get_option('WriteCSS') == '1' && get_option('WriteJS') == "1"){ // js, css

        $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

        $contentJPG =
        PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
        PHP_EOL . "ExpiresByType " . "text/css" .  ' "access plus ' . get_option('_PK_css_value'). " " . $CSS_selectedOption .'"' .
        PHP_EOL . "ExpiresByType " . "text/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "ExpiresByType " . "application/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "</IfModule>" . PHP_EOL;
        $content = $content . $contentJPG;

        fwrite($accessfilewrite, $contentJPG);
        update_option( 'WriteCSS' , "0" );
        update_option( 'WriteJS' , "0" );
        fclose($accessfilewrite);

      ?>
      <script type="text/javascript">
         document.getElementById("myJSCheck").checked = false;
         document.getElementById("myCSSCheck").checked = false;
         //window.location.reload();
      </script>
      <?php
  }else if(get_option('WritePNG') == '1' && get_option('WriteJPG') != '1' && get_option('WriteCSS') == '1' && get_option('WriteJS') == "1"){ // js, css, png

        $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

        $contentJPG =
        PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
        PHP_EOL . "ExpiresByType " . "image/png" .  ' "access plus ' . get_option('_PK_png_value'). " " . $PNG_selectedOption .'"' .
        PHP_EOL . "ExpiresByType " . "text/css" .  ' "access plus ' . get_option('_PK_css_value'). " " . $CSS_selectedOption .'"' .
        PHP_EOL . "ExpiresByType " . "text/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "ExpiresByType " . "application/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "</IfModule>" . PHP_EOL;
        $content = $content . $contentJPG;

        fwrite($accessfilewrite, $contentJPG);
        update_option( 'WriteCSS' , "0" );
        update_option( 'WriteJS' , "0" );
        update_option( 'WritePNG' , "0" );
        fclose($accessfilewrite);

      ?>
      <script type="text/javascript">
         document.getElementById("myJSCheck").checked = false;
         document.getElementById("myPNGCheck").checked = false;
         document.getElementById("myCSSCheck").checked = false;
         //window.location.reload();
      </script>
      <?php
  }else if(get_option('WritePNG') != '1' && get_option('WriteJPG') == '1' && get_option('WriteCSS') == '1' && get_option('WriteJS') == "1"){ // js, css, jpg

        $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

        $contentJPG =
        PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
        PHP_EOL . "ExpiresByType " . "image/jpg" .  ' "access plus ' . get_option('_PK_jpg_value'). " " . $JPG_selectedOption .'"' .
        PHP_EOL . "ExpiresByType " . "text/css" .  ' "access plus ' . get_option('_PK_css_value'). " " . $CSS_selectedOption .'"' .
        PHP_EOL . "ExpiresByType " . "text/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "ExpiresByType " . "application/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "</IfModule>" . PHP_EOL;
        $content = $content . $contentJPG;

        fwrite($accessfilewrite, $contentJPG);
        update_option( 'WriteCSS' , "0" );
        update_option( 'WriteJS' , "0" );
        update_option( 'WriteJPG' , "0" );
        fclose($accessfilewrite);

      ?>
      <script type="text/javascript">
         document.getElementById("myJSCheck").checked = false;
         document.getElementById("myJPGCheck").checked = false;
         document.getElementById("myCSSCheck").checked = false;
         //window.location.reload();
      </script>
      <?php
  }else if(get_option('WritePNG') == '1' && get_option('WriteJPG') == '1' && get_option('WriteCSS') != '1' && get_option('WriteJS') == "1"){ // js, png, jpg

        $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');

        $contentJPG =
        PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on" .
        PHP_EOL . "ExpiresByType " . "image/jpg" .  ' "access plus ' . get_option('_PK_jpg_value'). " " . $JPG_selectedOption .'"' .
        PHP_EOL . "ExpiresByType " . "image/png" .  ' "access plus ' . get_option('_PK_png_value'). " " . $PNG_selectedOption .'"' .
        PHP_EOL . "ExpiresByType " . "text/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "ExpiresByType " . "application/javascript" . ' "access plus ' . get_option('_PK_js_value'). " " . $JS_selectedOption . '"' .
        PHP_EOL . "</IfModule>" . PHP_EOL;
        $content = $content . $contentJPG;

        fwrite($accessfilewrite, $contentJPG);
        update_option( 'WriteJPG' , "0" );
        update_option( 'WriteJS' , "0" );
        update_option( 'WriteJPG' , "0" );
        fclose($accessfilewrite);

      ?>
      <script type="text/javascript">
         document.getElementById("myJSCheck").checked = false;
         document.getElementById("myJPGCheck").checked = false;
         document.getElementById("myPNGCheck").checked = false;
         //window.location.reload();
      </script>
      <?php
  } else if(get_option('WritePNG') == '1' && get_option('WriteJPG') == '1' && get_option('WriteCSS') == '1' && get_option('WriteJS') != "1"){ //css,png,jpg

    $accessfilewrite = fopen($accessfileurl, 'a') or die('Unable to open the file. Sorry');


    $contentPNG = PHP_EOL . "<IfModule mod_expires.c>". PHP_EOL . "ExpiresActive on"
    . PHP_EOL . "ExpiresByType " . "image/png" . ' "access plus ' . get_option('_PK_png_value'). " " . $PNG_selectedOption .'"'
    . PHP_EOL . "ExpiresByType " . "image/jpg" . ' "access plus ' . get_option('_PK_jpg_value'). " " . $JPG_selectedOption . '"'
    . PHP_EOL . "ExpiresByType " . "text/css" . ' "access plus ' . get_option('_PK_css_value'). " " . $CSS_selectedOption . '"'
    . PHP_EOL .  "</IfModule>" . PHP_EOL;
    $content = $content . $contentPNG;

    fwrite($accessfilewrite, $contentPNG);
    update_option( 'WritePNG' , "0" );
    update_option( 'WriteJPG' , "0" );
    update_option( 'WriteCSS' , "0" );
    fclose($accessfilewrite);


}

    if(get_option('WritePNG') != '1' ){
    ?>
    <script type="text/javascript">
       document.getElementById("myPNGCheck").checked = false;
    </script>
    <?php
    } ?>

  <!-- jpg -->
  <?php
 if(get_option('WriteJPG') != '1' ){
  ?>
  <script type="text/javascript">
     document.getElementById("myJPGCheck").checked = false;
  </script>
  <?php
  } ?>

  <?php
 if(get_option('WriteJS') != '1' ){
  ?>
  <script type="text/javascript">
     document.getElementById("myJSCheck").checked = false;
  </script>
  <?php
  } ?>

<!-- css -->
  <?php
 if(get_option('WriteCSS') != '1' ){
  ?>
  <script type="text/javascript">
     document.getElementById("myCSSCheck").checked = false;
  </script>
  <?php
  } ?>



</div>
