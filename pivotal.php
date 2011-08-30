<?php

	class pivotal {

		// Public properties
		var $token;
		var $project;

		// ---------
		// getStory
		// -----
		// Get a story from an existing project
		public function getStory($story, $project = '') {
		
			// If the project wasn't set, use the class project
			if ($project == '') {
				$project = $this->project;
			}

			// Encode the description
			$desc = htmlentities($desc);

			// Create the new story
			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X GET http://www.pivotaltracker.com/services/v3/projects/{$project}/stories/{$story}";
			$xml = shell_exec($cmd);
			
			// Return an object
			$story = new SimpleXMLElement($xml);
			return $story;
	
		}

		// ---------
		// addStory
		// -----
		// Add a story to an existing project
		public function addStory($type, $name, $desc) {

			// Encode the description
			$desc = htmlentities($desc);

			// Create the new story
			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X POST -H \"Content-type: application/xml\" "
				 . "-d \"<story>"
				 . "<story_type>$type</story_type>"
				 . "<name>$name</name>"
				 . "<description>$desc</description>"
				 . "</story>\" "
				 . "http://www.pivotaltracker.com/services/v3/projects/{$project}/stories";
			$xml = shell_exec($cmd);
			
			// Return an object
			$story = new SimpleXMLElement($xml);
			return $story;
	
		}
	
		// ----------
		// addTask
		// -----
		// Add a task to an existing story.
		public function addTask($story, $desc) {
	
			// Create the new task
			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X POST -H \"Content-type: application/xml\" "
				 . "-d \"<task><description>$desc</description></task>\" "
				 . "http://www.pivotaltracker.com/services/v3/projects/{$this->project}/stories/$story/tasks";
			$xml = shell_exec($cmd);
		
		}
	
	}

?>
