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
	 * Make a GET request to the Deepgram API.
	 *
	 * @param string $endpoint The endpoint to request.
	 * @return mixed|Deepgram_Error Either decoded JSON or a Deepgram_Error on error.
	 */
	public function get( $endpoint ) {
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

		$response_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );

		$curl_error = curl_errno( $ch );

		if ( 0 !== $curl_error ) {
			return new Deepgram_Error( 'GET_CURL_ERROR', "cURL error: " . $curl_error );
		}

		curl_close( $ch );

		if ( ! $response ) {
			return new Deepgram_Error( 'GET_RESPONSE_BLANK', "Request response was blank." );
		}

		$json = json_decode( $response );

		if ( ! $json ) {
			return new Deepgram_Error( 'GET_RESPONSE_INVALID', "Response was not valid JSON.", $response );
		}

		if ( isset( $json->err_code ) ) {
			return new Deepgram_Error( $json->err_code, $json->err_msg );
		}

		if ( isset( $json->error ) ) {
			return new Deepgram_Error( $json->error, $json->reason );
		}

		return $json;
	}

	/**
	 * Make a PATCH request to the Deepgram API.
	 *
	 * @param string $endpoint The endpoint to request.
	 * @param array[string] $args An array of arguments to send in the request body.
	 * @return mixed|Deepgram_Error Either decoded JSON or a Deepgram_Error on error.
	 */
	public function patch( $endpoint, $args ) {
		$version = "https://api.deepgram.com/v1";

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $version . $endpoint );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Token " . $this->api_key,
			"Content-Type: application/json",
		) );

		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PATCH' );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $args ) );

		$response = curl_exec( $ch );

		$curl_error = curl_errno( $ch );

		if ( 0 !== $curl_error ) {
			return new Deepgram_Error( 'PATCH_CURL_ERROR', "cURL error: " . $curl_error );
		}

		$response_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );

		curl_close( $ch );

		if ( 200 !== $response_code ) {
			return new Deepgram_Error( 'PATCH_REQUEST_FAILED', "Response status was not 200 (" . $response_code . ")", $response );
		}

		if ( ! $response ) {
			return new Deepgram_Error( 'PATCH_RESPONSE_BLANK', "Request response was blank." );
		}

		$json = json_decode( $response );

		if ( ! $json ) {
			return new Deepgram_Error( 'PATCH_RESPONSE_INVALID', "Response was not valid JSON.", $response );
		}

		if ( isset( $json->err_code ) ) {
			return new Deepgram_Error( $json->err_code, $json->err_msg );
		}

		if ( isset( $json->error ) ) {
			return new Deepgram_Error( $json->error, $json->reason );
		}

		return $json;
	}

	/**
	 * Make a DELETE request to the Deepgram API.
	 *
	 * @param string $endpoint The endpoint to request.
	 * @return mixed|Deepgram_Error Either decoded JSON or a Deepgram_Error on error.
	 */
	public function delete( $endpoint ) {
		$version = "https://api.deepgram.com/v1";

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $version . $endpoint );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Token " . $this->api_key,
			"Content-Type: application/json",
		) );

		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );

		$response = curl_exec( $ch );

		$curl_error = curl_errno( $ch );

		if ( 0 !== $curl_error ) {
			return new Deepgram_Error( 'DELETE_CURL_ERROR', "cURL error: " . $curl_error );
		}

		$response_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );

		curl_close( $ch );

		if ( 200 !== $response_code ) {
			return new Deepgram_Error( 'DELETE_REQUEST_FAILED', "Response status was not 200 (" . $response_code . ")", $response );
		}

		if ( ! $response ) {
			return new Deepgram_Error( 'DELETE_RESPONSE_BLANK', "Request response was blank." );
		}

		$json = json_decode( $response );

		if ( ! $json ) {
			return new Deepgram_Error( 'DELETE_RESPONSE_INVALID', "Response was not valid JSON.", $response );
		}

		if ( isset( $json->err_code ) ) {
			return new Deepgram_Error( $json->err_code, $json->err_msg );
		}

		if ( isset( $json->error ) ) {
			return new Deepgram_Error( $json->error, $json->reason );
		}

		return $json;
	}

	/**
	 * Returns a list of projects that the supplied API key has access to.
	 *
	 * @endpoint GET /projects
	 * @return array[Deepgram_Project]|Deepgram_Error Either an array of Deepgram_Project objects or Deepgram_Error on failure.
	 */
	public function projects() {
		$rv = $this->get( "/projects" );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		$projects = array();

		foreach ( $rv->projects as $project_json ) {
			$project = new Deepgram_Project( $project_json, $this );
			$projects[] = $project;
		}

		return $projects;
	}

	/**
	 * Retrieves basic information about the specified project.
	 *
	 * @endpoint GET /project/{project_id}
	 *
	 * @param string $project_id The project ID.
	 * @return Deepgram_Project|Deepgram_Error Either a Deepgram_Project or Deepgram_Error on failure.
	 */
	public function project( $project_id ) {
		$rv = $this->get( "/projects/" . urlencode( $project_id ) );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		$project = new Deepgram_Project( $rv, $this );

		return $project;
	}
}

/**
 * A simple wrapper for reporting errors.
 *
 * You can check $error->code for a unique code that identifies where in this file it was generated.
 * $error->message should contain a descriptive error messsage, and $error->details may contain
 * some additional context for the error message.
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
	public $company;

	private $deepgram;

	public function __construct( $data, $deepgram ) {
		$this->project_id = $data->project_id;
		$this->name = $data->name;
		$this->company = $data->company ?? '';

		$this->deepgram = $deepgram;
	}

	/**
	 * Update the project metadata.
	 *
	 * @endpoint PATCH /projects/{project_id}
	 * @param array[string] $data An associative array of fields to update.
	 *             ['name'] The project name.
	 *             ['company'] The company associated with the project.
	 * @return bool|Deepgram_Error Either true on success or a Deepgram_Error on faillure.
	 */
	public function update( $data ) {
		$args = array();

		$arg_whitelist = array( 'name', 'company' );

		foreach ( $arg_whitelist as $arg_key ) {
			if ( isset( $data[ $arg_key ] ) ) {
				$args[ $arg_key ] = $data[ $arg_key ];
			}
		}

		// @todo Should an unsupported arg trigger an error?

		if ( empty( $args ) ) {
			return true;
		}

		$rv = $this->deepgram->patch( '/projects/' . urlencode( $this->project_id ), $args );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		foreach ( $args as $key => $val ) {
			$this->{ $key } = $val;
		}

		return true;
	}

	/**
	 * Delete the project.
	 *
	 * @endpoint DELETE /projects/{project_id}
	 * @return bool|Deepgram_Error Either true on success or a Deepgram_Error on faillure.
	 */
	public function delete() {
		$rv = $this->deepgram->delete( "/projects/" . urlencode( $this->project_id ) );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return true;
	}
}