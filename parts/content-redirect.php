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
                        								<span>Rule</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
                                                <th class="profile-header-author">
                                                    <span>
                       								 <span>Old Url</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
												<th class="profile-header-author">
                                                    <span>
                       								 <span>New Url</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
												
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="advgb-profile">
                                                <td class="profile-checkbox select-box">
													<input name="Write301" type="checkbox" id="myCheck" value="1" <?php checked( '1', get_option( 'Write301' ) ); ?> />
                                                </td>
                                                <td class="profile-title">
                                                    <a href="#" class="advgb_qtip">
                           								 301 Redirect                        
													</a>
													
                                                    
                                                </td>
                                                <td class="profile-author">
													<input type="text" placeholder="/redirect-from-url/" name="_PK_301_old_setting" value="<?php echo esc_attr( get_option('_PK_301_old_setting') ); ?>" />
												</td>
												<td class="profile-author">
													<input type="text" placeholder="test.com/redirect-to-url" name="_PK_301_new_setting" value="<?php echo esc_attr( get_option('_PK_301_new_setting') ); ?>" />
												</td>
                                            </tr>
											<tr class="advgb-profile">
                                                <td class="profile-checkbox select-box">
													<input name="Write302" type="checkbox" id="myCheck2" value="1" <?php checked( '1', get_option( 'Write302' ) ); ?> />
                                                </td>
                                                <td class="profile-title">
                                                    <a href="#" class="advgb_qtip">
                           								 302 Redirect                        
													</a>
                                                    
                                                </td>
                                                <td class="profile-author">
													<input type="text" placeholder="/redirect-from-url/" name="_PK_302_old_setting" value="<?php echo esc_attr( get_option('_PK_302_old_setting') ); ?>" />
												</td>
												<td class="profile-author">
													<input type="text" placeholder="test.com/redirect-to-url" name="_PK_302_new_setting" value="<?php echo esc_attr( get_option('_PK_302_new_setting') ); ?>" />
												</td>
                                            </tr>
											
											<tr class="advgb-profile">
                                                <td class="profile-checkbox select-box">
													<input name="Write404" type="checkbox" id="myCheck4" value="1" <?php checked( '1', get_option( 'Write404' ) ); ?> />
                                                </td>
                                                <td class="profile-title">
                                                    <a href="#" class="advgb_qtip">
                           								 400 Redirect                        
													</a>
                                                    
                                                </td>
                                                <td class="profile-author">
													
												</td>
												<td class="profile-author">
													<input type="text" placeholder="test.com/redirect-to-url" name="_PK_404_setting" value="<?php echo esc_attr( get_option('_PK_404_setting') ); ?>" />
												</td>
                                            </tr>
											
											<tr class="advgb-profile">
                                                <td class="profile-checkbox select-box">
													<input name="Write500" type="checkbox" id="myCheck3" value="1" <?php checked( '1', get_option( 'Write500' ) ); ?> />
                                                </td>
                                                <td class="profile-title">
                                                    <a href="#" class="advgb_qtip">
                           								 500 Redirect                        
													</a>
                                                    
                                                </td>
                                                <td class="profile-author">
													
												</td>
												<td class="profile-author">
													<input type="text" placeholder="test.com/redirect-to-url" name="_PK_500_setting" value="<?php echo esc_attr( get_option('_PK_500_setting') ); ?>" />
												</td>
                                            </tr>
											
											<tr class="advgb-profile">
                                                <td class="profile-checkbox select-box">
													<input name="ForceHttps" type="checkbox" id="myCheck5" value="1" <?php checked( '1', get_option( 'ForceHttps' ) ); ?> />
                                                </td>
                                                <td class="profile-title">
                                                    <a href="#" class="advgb_qtip">
                           								 Force Https                       
													</a>
                                                    
                                                </td>
                                                <td class="profile-author">
													
												</td>
												<td class="profile-author">
													
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
                        								<span>Rule</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
                                                <th class="profile-header-author">
                                                    <span>
                       								 <span>Old Url</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
												<th class="profile-header-author">
                                                    <span>
                       								 <span>New Url</span>
                                                    <i class="dashicons"></i>
                                                    </span>
                                                </th>
												
                                            </tr>
                                        </tfoot>
                                    </table>
										    <?php submit_button(__( 'Save Changes', 'textdomain' ), 'ju-button orange-button waves-effect waves-light'); ?>
								</form>
									
                                </div>