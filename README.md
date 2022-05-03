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
GET    /projects                            => Deepgram::projects()
GET    /projects/{project_id}               => Deepgram::project()
PATCH  /projects/{project_id}               => Deepgram_Project::update()
DELETE /projects/{project_id}               => Deepgram_Project::delete()
GET    /projects/{project_id}/keys          => Deepgram_Project::keys()
GET    /projects/{project_id}/keys/{key_id} => Deepgram_Project::key()
```