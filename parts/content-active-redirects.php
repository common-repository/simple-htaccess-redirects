<div id="advgb-settings-container">

	<div class="profiles-list-wrapper">
	
                   	 <form id="" method="get" >

                                    <table id="profiles-list">
                                       
                                        <tbody>
											
										<?php
											
											$activeRedirectsArray = get_option('_PK_Active_Redirect');

											if(empty($activeRedirectsArray)){
												$activeRedirectsArray = array();
											}
											
											
											if(count($activeRedirectsArray) == 0 || $activeRedirectsArray[0] == ''){
												
												echo "<h3>There Are No Active Redirects</h3>"; 
												
												
											} else {
								
												
												$keys = array_keys($activeRedirectsArray);
												for($i = 0; $i < count($activeRedirectsArray); $i++) {
													?>
												<tr class="advgb-profile redirect-<?php echo $i;?>">
												
														<td class="profile-author">
															Delete This Redirect? <input type="checkbox" id="active-redirect-checkbox-<?php echo $i;?>" onclick="showMe('active-redirect-checkbox-<?php echo $i;?>', this)"  class="select-all-profiles ju-checkbox ">
														</td>
													<?php
													
													
													foreach($activeRedirectsArray[$keys[$i]] as $key => $value) {
														
														?>
																	<td class="profile-title <?php echo $key ?>-key-<?php echo $i;?>">
																		<p><?php echo $key ?></p>
																	</td>
																	<td class="profile-author <?php echo $key ?>-value-<?php echo $i;?>">
																		<p><?php echo $value; ?></p>
																	</td>
															
													<?php
													}
													?>
													

													</tr>
													<?php
												}
									
											}
		
										?>
											
                                           
										</tbody>
										
										<script type="text/javascript">
										function showMe (it, box) {
											
											var vis = (box.checked) ? "none" : "block";
											
											var id = it.substr(25, 26);

											if (confirm("Do You Want To Remove This Redirect?") == true) {


												var data = {
													'action': 'PK_remove_active_redirect',
													'id' : id,
												};

											}

											jQuery.post(ajaxurl, data, function(response) {

													var res = response;

													console.log(res);

													if(res != ''){
														document.getElementById(it).parentNode.parentNode.style.display = vis;
													}


												});
										}
										</script>
                                       
                                    </table>
									   
								</form>

			</div>
			

</div>
