<?php

	// Include the file that defines the class
	require 'pivotal.php';

	// Create an instance of the class
	$pivotal = new pivotal;
	
	// Set our API token and project number
	$pivotal->token = 'your_token_goes_here';
	$pivotal->project = 'your_project_goes_here';
	
	// Get an existing story
	$story = $pivotal->getStory('the_story_id');
	
	// Display some details
	echo $story->name;
	
?>
