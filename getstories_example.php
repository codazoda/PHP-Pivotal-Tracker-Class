<?php

	// Include the file that defines the class
	require 'pivotal.php';

	// Create an instance of the class
	$pivotal = new pivotal;
	
	// Set our API token and project number
	$pivotal->token = 'your_token_goes_here';
	
	// Get an existing story
	$story = $pivotal->getStories('the_project_id');
	
	// Display some details
	print_r($story);
	
?>
