<?php

	// Include the file that defines the class
	require 'pivotal.php';

	// Create an instance of the class
	$pivotal = new pivotal;
	
	// Set our API token and project number
	$pivotal->token = 'your_token_goes_here';
	$pivotal->project = 'your_project_goes_here';
	
	// Insert a new story
	$story = $pivotal->addStory('chore', 'Clean the Kitchen', 'Need to deep clean the kitchen.');
	
	// Insert some tasks, using the story id returned
	$pivotal->addTask($story->id, 'Wash the dishes');
	$pivotal->addTask($story->id, 'Sweep the floor');
	
	// Add a label to the story
	$pivotal->addLabels($story->id, 'kitchen');
	
?>
