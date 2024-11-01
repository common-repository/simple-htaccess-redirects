<div id="advgb-settings-container">

	<div class="profiles-list-wrapper">
	
                   	 <form id="" method="get" >

                                    <table id="profiles-list">
                                       
                                        <tbody>
											
										<?php
											

											$optionsArray = get_option('_PK_404');

											if(empty($optionsArray)){
												$optionsArray = array();
											}
											
											if(count($optionsArray) == 0 || $optionsArray[0] == ''){
												
												echo "<h3>You have been keeping up with your 404 errors. Good Job!</h3>"; 
												
												
											} else {
												
												for ($i = 0; $i < count($optionsArray); $i++)  {
													
													?>
													 <tr class="advgb-profile">

														<td class="profile-title">
															URL
														</td>

														<td class="profile-author">
															<input type="text" min="0" id="optionvalue<?php echo $i; ?>" value="<?php echo $optionsArray[$i]; ?>">
														</td>


													</tr>
											

													<?php
												}
												
												?>
												<?php
											}
		
										?>
											
                                           
                                        </tbody>
                                       
                                    </table>
									   
								</form>

			</div>
				<?php
	if(count($optionsArray) == 0 || $optionsArray[0] == ''){?>
		
	<?php }else{ ?>
	<form id="404Captures" action="" style="float: left; margin: 25px auto">
			<input type="submit" class="PK_404_Captures ju-rect-button" name="insert" value="Add Redirects" />
		</form>
	<?php } ?>

</div>
