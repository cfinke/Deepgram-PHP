<?php

/**
 * https://developers.deepgram.com/api-reference/
 */

class Deepgram {
	private $api_key;

	public function __construct( $api_key ) {
		$this->api_key = $api_key;
	}

	/**
	 * Make a request to the Deepgram API.
	 *
	 * @param string $endpoint The endpoint to request.
	 * @param string $method The HTTP method to use.
	 * @return mixed|Deepgram_Error Either decoded JSON or a Deepgram_Error on error.
	 */
	private function request( $endpoint, $method = "GET" ) {
		$version = "https://api.deepgram.com/v1";

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $version . $endpoint );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Token " . $this->api_key,
			"Content-Type: application/json",
		) );

		$response = curl_exec( $ch );

		$curl_error = curl_errno( $ch );

		if ( 0 !== $curl_error ) {
			return new Deepgram_Error( 1, "cURL error: " . $curl_error );
		}

		curl_close( $ch );

		if ( ! $response ) {
			return new Deepgram_Error( 2, "Request response was blank." );
		}

		$json = json_decode( $response );

		if ( ! $json ) {
			return new Deepgram_Error( 3, "Response was not valid JSON.", $response );
		}

		return $json;
	}

	/**
	 * Returns a list of projects that the supplied API key has access to.
	 *
	 * @endpoint /projects
	 * @return array[Deepgram_Project]|Deepgram_Error Either an array of Deepgram_Project objects or Deepgram_Error on failure.
	 */
	public function projects() {
		$rv = $this->request( "/projects" );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		$projects = array();

		foreach ( $rv->projects as $project_json ) {
			$project = new Deepgram_Project( $project_json, $this->api_key );
			$projects[] = $project;
			$project = new Deepgram_Project( $project_json, $this->api_key );
			$projects[] = $project;
		}

		return $projects;
	}

	/**
	 * Retrieves basic information about the specified project.
	 *
	 * @endpoint /project/{project_id}
	 *
	 * @param string $project_id The project ID.
	 * @return Deepgram_Project|Deepgram_Error Either a Deepgram_Project or Deepgram_Error on failure.
	 */
	public function project( $project_id ) {
		$rv = $this->request( "/projects/" . urlencode( $project_id ) );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		$project = new Deepgram_Project( $rv, $this->api_key );

		return $project;
	}
}

/**
 * A simple wrapper for reporting errors.
 */
class Deepgram_Error {
	var $code;
	var $message;
	var $details;

	public function __construct( $code, $message, $details = null ) {
		$this->code = $code;
		$this->message = $message;

		if ( $details ) {
			$this->details = $details;
		}
	}
}

/**
 * A representation of a Deepgram project.
 */
class Deepgram_Project {
	public $project_id;
	public $name;

	private $api_key;

	public function __construct( $data, $api_key ) {
		$this->project_id = $data->project_id;
		$this->name = $data->name;

		$this->api_key = $api_key;
	}
}