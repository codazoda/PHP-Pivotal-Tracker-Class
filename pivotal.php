<?php

	class pivotal {

		// Public properties
		var $token;
		var $project;

		// ---------
		// addStory
		// -----
		// Add a story to an existing project
		public function addStory($type, $name, $desc) {

			// Encode the description
			$desc = htmlentities($desc);
			
			// Make the fields safe
			$type = escapeshellcmd($type);
			$name = escapeshellcmd($name);

			// Create the new story
			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X POST -H \"Content-type: application/xml\" "
				 . "-d \"<story>"
				 . "<story_type>$type</story_type>"
				 . "<name>$name</name>"
				 . "<description>$desc</description>"
				 . "</story>\" "
				 . "https://www.pivotaltracker.com/services/v3/projects/{$this->project}/stories";
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

			// Encode the description
			$desc = htmlentities($desc);

			// Make the fields safe
			$story = escapeshellcmd($story);
	
			// Create the new task
			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X POST -H \"Content-type: application/xml\" "
				 . "-d \"<task><description>$desc</description></task>\" "
				 . "https://www.pivotaltracker.com/services/v3/projects/{$this->project}/stories/$story/tasks";
			$xml = shell_exec($cmd);
		
		}
		
		
		// ----------
		// addAttachment
		// -----
		// Add an attachment to an existing story.
		public function addAttachment($story, $filePath) {

			// Make the fields safe
			$story = escapeshellcmd($story);
				
			// Create the new attachment
			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X POST -F Filedata=@$filePath "
				 . "https://www.pivotaltracker.com/services/v3/projects/{$this->project}/stories/$story/attachments";
				 
			$xml = shell_exec($cmd);
		
		}
		

		// ----------
		// addLabels
		// -----
		// Add a label to an existing story.
		public function addLabels($story, $labels) {

			// Make the fields safe
			$story = escapeshellcmd($story);
			$labels = escapeshellcmd($labels);
	
			// Create the new task
			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X PUT -H \"Content-type: application/xml\" "
				 . "-d \"<story><labels>$labels</labels></story>\" "
				 . "https://www.pivotaltracker.com/services/v3/projects/{$this->project}/stories/$story";
			$xml = shell_exec($cmd);
	
		}
		
		// ---------
		// getStories
		// -----
		// Get a list of stories from a project, optionaly filter
		public function getStories($project, $filter = '') {

			// Encode the filter
			$filter = urlencode($filter);

			// Make the fields safe
			$filter = escapeshellcmd($filter);
			$project = escapeshellcmd($project);

			// Request the stories
			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X GET "
				 . "https://www.pivotaltracker.com/services/v3/projects/$project/stories";
			// Add the filter, if it was specified
			if ($filter != '') $cmd .= "?filter=$filter";
			$xml = shell_exec($cmd);
			
			// Return an object
			$story = new SimpleXMLElement($xml);
			return $story;
	
		}

		// ---------
		// getProjects
		// -----
		// Get a list of your projects
		public function getProjects() {

			// Request the projects
			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X GET "
				 . "https://www.pivotaltracker.com/services/v3/projects";
			$xml = shell_exec($cmd);
			
			// Return an object
			$projects = new SimpleXMLElement($xml);
			return $projects;
	
		}
		
		// ----------
		// getToken
		// -----
		public function getToken($username, $password) {

			// Make the fields safe
			$username = escapeshellcmd($username);
			$password = escapeshellcmd($password);

			// Request the token
			$cmd = "curl -u $username:$password "
				 . "-X GET "
				 . "https://www.pivotaltracker.com/services/v3/tokens/active";
			$xml = shell_exec($cmd);
			
			// Return an object
			$token = new SimpleXMLElement($xml);
			return $token->guid;
			
		}


		// ----------
		// getProjectActivity
		// -----
		//Get Activity Feed of a project. Number of activities is 50 by default
		public function getProjectActivity($project, $limit=50) {

			// Make the fields safe
			$project = escapeshellcmd($project);

			$cmd = "curl -H \"X-TrackerToken: {$this->token}\" "
				 . "-X GET "
				 . "https://www.pivotaltracker.com/services/v3/projects/$project/activities?limit=$limit";
			$xml = shell_exec($cmd);

			$activity = new SimpleXMLElement($xml);			
			return $xml;			
		}
	
	}

?>
