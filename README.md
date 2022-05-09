An unofficial PHP SDK for [Deepgram's audio transcription API](https://developers.deepgram.com/api-reference/).

Getting Started
---------------
Grab `src/deepgram.php` and include it in your project.

Then:

```
$deepgram = new Deepgram( [your API key here] );
```

Now, you have access to the Deepgram API endpoints. For example,

```
$projects = $deepgram->projects();

var_dump( $projects );
```

displays

```
array(2) {
	[0]=>
	object(Deepgram_Project)#2 (3) {
		[...]
	}
	[1]=>
	object(Deepgram_Project)#3 (3) {
		[...]
	}
}
```

(if your API key has two projects).

Supported Endpoints
-------------------

```
GET    /projects                                         => Deepgram::projects()
GET    /projects/{project_id}                            => Deepgram::project()
PATCH  /projects/{project_id}                            => Deepgram_Project::update()
DELETE /projects/{project_id}                            => Deepgram_Project::delete()
GET    /projects/{project_id}/keys                       => Deepgram_Project::keys()
GET    /projects/{project_id}/keys/{key_id}              => Deepgram_Project::key()
POST   /projects/{project_id}/keys                       => Deepgram_Project::create_key()
DELETE /projects/{project_id}/keys/{key_id}              => Deepgram_Key::delete()
GET    /projects/{project_id}/balances                   => Deepgram_Project::balances()
GET    /projects/{project_id}/balances/{balance_id}      => Deepgram_Project::balance()
GET    /projects/{project_id}/requests                   => Deepgram_Project::requests()
GET    /projects/{project_id}/requests/{request_id}      => Deepgram_Project::request()
GET    /projects/{project_id}/usage                      => Deepgram_Project::usage()
GET    /projects/{project_id}/usage/fields               => Deepgram_Project::fields()
GET    /projects/{project_id}/members                    => Deepgram_Project::members()
DELETE /projects/{project_id}/members/{member_id}        => Deepgram_Member::remove()
GET    /projects/{project_id}/members/{member_id}/scopes => Deepgram_Member::scopes()
PUT    /projects/{project_id}/members/{member_id}/scopes => Deepgram_Member::scopes()
DELETE /projects/{project_id}/leave                      => Deepgram_Project::leave()
```