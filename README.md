## Checklist
* RESTful API - Done
* JWT authentication - Not Done
* List of endpoints - Done
  * Get a list of football teams in given league: GET /league/{id}/team HTTP/1.1
  * Create a football team: PUT /league/{id}/team HTTP/1.1
  * Replace all attributes of a football team: PATCH /league/{leagueId}/team/{teamId} HTTP/1.1
  * Delete a football league: DELETE /league/{id} HTTP/1.1

> Postman collection provided in root of project

### Todo
 - Create custom Token Auth using Symfony Security Component
 - Move Annotations from Controller and Entities to Yaml file for skinnier controller 