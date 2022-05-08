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
	 * Make a POST request to the Deepgram API.
	 *
	 * @param string $endpoint The endpoint to request.
	 * @param array[string] $args An array of arguments to send in the request body.
	 * @return mixed|Deepgram_Error Either decoded JSON or a Deepgram_Error on error.
	 */
	public function post( $endpoint, $args ) {
		$version = "https://api.deepgram.com/v1";

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $version . $endpoint );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Token " . $this->api_key,
			"Content-Type: application/json",
		) );

		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $args ) );

		$response = curl_exec( $ch );

		$curl_error = curl_errno( $ch );

		if ( 0 !== $curl_error ) {
			return new Deepgram_Error( 'POST_CURL_ERROR', "cURL error: " . $curl_error );
		}

		$response_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );

		curl_close( $ch );

		// @todo The documentation says that the status code should be 201, but it is 200 for now.
		if ( 200 !== $response_code ) {
			return new Deepgram_Error( 'POST_REQUEST_FAILED', "Response status was not 200 (" . $response_code . ")", $response );
		}

		if ( ! $response ) {
			return new Deepgram_Error( 'POST_RESPONSE_BLANK', "Request response was blank." );
		}

		$json = json_decode( $response );

		if ( ! $json ) {
			return new Deepgram_Error( 'POST_RESPONSE_INVALID', "Response was not valid JSON.", $response );
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

	public $deepgram;

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

	/**
	 * Retrieve the keys associated with this project.
	 *
	 * @endpoint GET /projects/{project_id}/keys
	 * @return array[Deepgram_Key]|Deepgram_Error Either an array of Deepgram_Key objects or a Deepgram_Error on failure.
	 */
	public function keys() {
		$rv = $this->deepgram->get( "/projects/" . urlencode( $this->project_id ) . "/keys" );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		$keys = array();

		foreach ( $rv->api_keys as $key_json ) {
			// @todo There's also a member member here.
			$key = new Deepgram_Key( $key_json->api_key, $this );
			$keys[] = $key;
		}

		return $keys;
	}

	/**
	 * Retrieve the keys associated with this project.
	 *
	 * @endpoint GET /projects/{project_id}/keys/{key_id}
	 * @return Deepgram_Key|Deepgram_Error Either a Deepgram_Key or a Deepgram_Error on failure.
	 */
	public function key( $key_id ) {
		$rv = $this->deepgram->get( "/projects/" . urlencode( $this->project_id ) . "/keys/" . urlencode( $key_id ) );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return new Deepgram_Key( $rv->api_key, $this );
	}

	/**
	 * Create a new key for this project.
	 *
	 * @endpoint POST /projects/{project_id}/keys
	 * @param array[mixed] The request body parameters.
	 * @return Deepgram_Key|Deepgram_Error Either a Deepgram_Key or a Deepgram_Error on failure.
	 */
	public function create_key( $data = array() ) {
		$args = array(
			'comment' => null,
			'scopes' => array(),
			'expiration_date' => null,
			'time_to_live_in_seconds' => null,
		);

		$args = array_merge( $args, $data );
		$args = array_filter( $args );

		if ( ! isset( $args['comment'] ) ) {
			return new Deepgram_Error( 'CREATE_KEY_MISSING_ARG', 'comment argument is requred' );
		}

		if ( empty( $args['scopes'] ) ) {
			return new Deepgram_Error( 'CREATE_KEY_MISSING_ARG', 'scopes argument is requred' );
		}

		$rv = $this->deepgram->post( "/projects/" . urlencode( $this->project_id ) . "/keys", $args );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return new Deepgram_Key( $rv, $this );
	}

	/**
	 * Retrieve an individual balance.
	 *
	 * @endpoint GET /projects/{project_id}/balances
	 * @param string $balance_id The balance ID.
	 * @return array[Deepgram_Balance]|Deepgram_Error Either an array of Deepgram_Balance objects or a Deepgram_Error on failure.
	 */
	public function balances() {
		$rv = $this->deepgram->get( "/projects/" . urlencode( $this->project_id ) . "/balances" );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		$balances = array();

		foreach ( $rv->balances as $balance ) {
			$balance_object = new Deepgram_Balance( $balance, $this );
			$balances[] = $balance;
		}

		return $balances;
	}

	/**
	 * Retrieve an individual balance.
	 *
	 * @endpoint GET /projects/{project_id}/balances
	 * @param string $balance_id The balance ID.
	 * @return Deepgram_Balance|Deepgram_Error Either a Deepgram_Balance or a Deepgram_Error on failure.
	 */
	public function balance( $balance_id ) {
		$rv = $this->deepgram->get( "/projects/" . urlencode( $this->project_id ) . "/balances/" . urlencode( $balance_id ) );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return new Deepgram_Balance( $rv, $this );
	}
}

/**
 * A representation of a Deepgram key.
 */
class Deepgram_Key {
	public $api_key_id;
	public $api_key;
	public $comment;
	public $scopes = array();
	public $created;

	private $project;

	public function __construct( $data, $project ) {
		$this->api_key_id = $data->api_key_id;
		$this->comment = $data->comment;
		$this->scopes = $data->scopes;
		$this->created = $data->created;

		// The actual API key is only available immediately after key creation.
		if ( isset( $data->api_key ) ) {
			$this->api_key = $data->api_key;
		}

		$this->project = $project;
	}

	/**
	 * Delete the key.
	 *
	 * @endpoint DELETE /projects/{project_id}/keys/{key_id}
	 * @return bool|Deepgram_Error Either true on success or a Deepgram_Error on faillure.
	 */
	public function delete() {
		$rv = $this->project->deepgram->delete( "/projects/" . urlencode( $this->project->project_id ) . "/keys/" . urlencode( $this->api_key_id ) );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return true;
	}
}

/**
 * A representation of a Deepgram credit balance.
 */
class Deepgram_Balance {
	var $balance_id;
	var $amount;
	var $units;
	var $purchase_order_id;

	public function __construct( $data, $project ) {
		$this->balance_id = $data->balance_id;
		$this->amount = $data->amount;
		$this->units = $data->units;
		$this->purchase_order_id = $data->purchase_order_id;

		$this->project = $project;
	}
}