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

		if ( 200 !== $response_code ) {
			return new Deepgram_Error( 'GET_REQUEST_FAILED', "Response status was not 200 (" . $response_code . ")", $response );
		}

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
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->{ $key } = $value;
			}
		}

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
	 * Retrieve project request data.
	 *
	 * @endpoint GET /projects/{project_id}/requests
	 * @param array[mixed] Pagination and filter parameters.
	 * @return Either an array that includes a 'requests' member, which is itself an array of Deepgram_Request objects, or Deepgram_Error on failure.
	 */
	public function requests( $arguments = array() ) {
		$default_arguments = array(
			'start' => null,
			'end' => null,
			'limit' => null,
			'status' => null,
		);

		$arguments = array_merge( $default_arguments, $arguments );
		$arguments = array_filter( $arguments );

		$query_string = http_build_query( $arguments, '', '&' );

		$rv = $this->deepgram->get( "/projects/" . urlencode( $this->project_id ) . "/requests" . "?" . $query_string );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		$requests = array();
		$requests['limit'] = $rv->limit;
		$requests['page'] = $rv->page;
		$requests['requests'] = array();

		foreach ( $rv->requests as $request ) {
			$request_object = new Deepgram_Request( $request, $this );
			$requests['requests'][] = $request_object;
		}

		return $requests;
	}

	/**
	 * Retrieve an individual project request.
	 *
	 * @endpoint GET /projects/{project_id}/requests/{request_id}
	 * @param string $request_id The request ID.
	 * @return Deepgram_Request|Deepgram_Error Either a Deepgram_Request or a Deepgram_Error on failure.
	 */
	public function request( $request_id ) {
		$rv = $this->deepgram->get( "/projects/" . urlencode( $this->project_id ) . "/requests/" . urlencode( $request_id ) );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return new Deepgram_Request( $rv, $this );
	}

	/**
	 * Retrieve a usage summary for the project.
	 *
	 * @endpoint GET /projects/{project_id}/usage
	 * @param array[mixed] $arguments Query parameters for the API request.
	 * @return Deepgram_Usage_Summary|Deepgram_Error Either a Deepgram_Usage_Summary or a Deepgram_Error on failure.
	 */
	public function usage( $arguments = array() ) {
		$default_arguments = array(
			'start' => null,
			'end' => null,
			'accessor' => null,
			'tag' => null,
			'method' => null,
			'model' => null,
			'multichannel' => null,
			'interim_results' => null,
			'punctuate' => null,
			'ner' => null,
			'utterances' => null,
			'replace' => null,
			'profanity_filter' => null,
			'keywords' => null,
			'diarize' => null,
			'search' => null,
			'redact' => null,
			'alternatives' => null,
			'numerals' => null,
		);

		$arguments = array_merge( $default_arguments, $arguments );
		$arguments = array_filter( $arguments );

		$query_string = http_build_query( $arguments, '', '&' );

		$rv = $this->deepgram->get( "/projects/" . urlencode( $this->project_id ) . "/usage?" . $query_string );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return new Deepgram_Usage_Summary( $rv, $this );
	}

	/**
	 * Lists the features, models, tags, languages, and processing method used for requests in the specified project.
	 *
	 * @endpoint GET /projects/{project_id}/usage/fields
	 * @param array[mixed] $arguments Query parameters for the API request.
	 * @return Deepgram_Fields|Deepgram_Error Either a Deepgram_Fields or a Deepgram_Error on failure.
	 */
	public function fields( $arguments = array() ) {
		$default_arguments = array(
			'start' => null,
			'end' => null,
		);

		$arguments = array_merge( $default_arguments, $arguments );
		$arguments = array_filter( $arguments );

		$query_string = http_build_query( $arguments, '', '&' );

		$rv = $this->deepgram->get( "/projects/" . urlencode( $this->project_id ) . "/usage/fields?" . $query_string );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return new Deepgram_Fields( $rv, $this );
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

	/**
	 * Retrieve the members of this project.
	 *
	 * @endpoint GET /projects/{project_id}/members
	 * @return array[Deepgram_Member]|Deepgram_Error Either an array of Deepgram_Members or a Deepgram_Error on failure.
	 */
	public function members() {
		$rv = $this->deepgram->get( "/projects/" . urlencode( $this->project_id ) . "/members" );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		$members = array();

		foreach ( $rv->members as $member ) {
			$member_object = new Deepgram_Member( $member, $this );
			$members[] = $member_object;
		}

		return $members;
	}
}

/**
 * A representation of a Deepgram key.
 */
class Deepgram_Key {
	public $api_key_id;
	public $comment;
	public $scopes = array();
	public $created;

	/**
	 * The actual API key is only available immediately after key creation.
	 */
	public $api_key;

	private $project;

	public function __construct( $data, $project ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->{ $key } = $value;
			}
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
	public $balance_id;
	public $amount;
	public $units;
	public $purchase_order_id;

	private $project;

	public function __construct( $data, $project ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->{ $key } = $value;
			}
		}

		$this->project = $project;
	}
}

/**
 * A representation of a Deepgram request.
 */
class Deepgram_Request {
	public $request_id;
	public $created;
	public $path;
	public $api_key_id;
	public $response;
	public $callback;

	private $project;

	public function __construct( $data, $project ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->{ $key } = $value;
			}
		}

		$this->project = $project;
	}
}

/**
 * A representation of a Deepgram usage summary.
 */
class Deepgram_Usage_Summary {
	public $start;
	public $end;
	public $resolution;
	public $results;

	public function __construct( $data, $project ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->{ $key } = $value;
			}
		}

		$this->project = $project;
	}
}


/**
 * A representation of Deepgram fields.
 */
class Deepgram_Fields {
	public $tags;
	public $models;
	public $processing_methods;
	public $languages;
	public $features;

	public function __construct( $data, $project ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->{ $key } = $value;
			}
		}

		$this->project = $project;
	}
}

/**
 * A Deepgram project member.
 */
class Deepgram_Member {
	public $member_id;
	public $first_name;
	public $last_name;
	public $scopes;
	public $email;

	public function __construct( $data, $project ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->{ $key } = $value;
			}
		}

		$this->project = $project;
	}

	/**
	 * Retrieve the scopes assigned to a project member.
	 *
	 * @endpoint GET /projects/{project_id}/members/{member_id}/scopes
	 * @return array[string] An array of scopes.
	 */
	public function scopes() {
		$rv = $this->project->deepgram->get( "/projects/" . urlencode( $this->project->project_id ) . "/members/" . urlencode( $this->member_id ) . "/scopes" );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return $rv->scopes;
	}

	/**
	 * Remove the member from the project. Note that this also deletes API keys created by this member for this project.
	 *
	 * @endpoint DELETE /projects/{project_id}/members/{member_id}
	 * @return bool|Deepgram_Error Either true on success or a Deepgram_Error on faillure.
	 */
	public function remove() {
		$rv = $this->deepgram->delete( "/projects/" . urlencode( $this->project_id ) . "/members/" . urlencode( $this->member_id ) );

		if ( is_a( $rv, 'Deepgram_Error' ) ) {
			return $rv;
		}

		return true;
	}
}