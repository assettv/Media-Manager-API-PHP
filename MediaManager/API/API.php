<?php

namespace MediaManager\API;

use \MediaManager\HTTP\HTTP as HTTP;

/**
 * Description of API
 *
 * @author Dale
 */
class API {

    /**
     * The HTTP Object
     * @var HTTP 
     */
    private $HTTP;

    /**
     * The Client Shortname
     * @var type 
     */
    private $client;

    /**
     * The API Version.
     * @var type 
     */
    private $apiVersion = 1;

    /**
     * The API Key
     * @var type 
     */
    private $apiKey;

    /**
     * The Base URI for the API
     * @var type 
     */
    private $BASE_URI = "{client}.dev.mediamanager.io/api/v{version}";

    /**
     * Filters to apply to API calls
     * @var type 
     */
    private $filters = array();

    /**
     * A API Object
     * @param type $client
     * @param type $version
     */
    public function __construct($client, $apiKey, $version = 1) {

        $this->client = $client;
        $this->apiVersion = $version;
        $this->apiKey = $apiKey;

        //UPDATEA THE BASE URI TO MATCH CLIENTS CREDS
        $this->BASE_URI = str_replace(array("{client}", "{version}"), array($client, $version), $this->BASE_URI);

        //ATTACH THE HTTP OBJECT
        $this->HTTP = new HTTP();

        //SET THE API KEY TO BE PASSED TO ALL REQUESTS.
        $this->HTTP->setGlobalParams(array("_apikey" => $apiKey));
    }

    /**
     * Add a filter to API calls
     * @param type $filterName
     * @param type $filterValue
     */
    public function addFilter($filterName, $filterValue) {
        $this->filters[$filterName] = $filterValue;
    }

    /**
     * Filter down by a playlist
     * @param type $playlist
     */
    public function addPlaylistFilter($playlist) {
        $this->addFilter("playlist", $playlist);
    }

    /**
     * Add a template filter
     * @param type $template
     */
    public function addTemplateFilter($template) {
        $this->addFilter("templateID", $template);
    }

    /**
     * Get client data
     * @return type
     */
    public function getClient() {

        $api = "/client";

        //GET CLIENT DATA
        $response = $this->HTTP->Get($this->BASE_URI . $api);

        return $response;
    }

    public function getTemplates() {

        $api = "/templates";

        //GET CLIENT DATA
        $response = $this->HTTP->Get($this->BASE_URI . $api);

        return $response;
    }

    /**
     * Get Video data
     * @param type $videoid
     * @return type
     */
    public function getVideo($videoid) {

        $api = "/video/" . $videoid;

        //GET CLIENT DATA
        $response = $this->HTTP->Get($this->BASE_URI . $api);

        return $response;
    }

    public function getPlaylists() {
        $api = "/playlists";

        //GET CLIENT DATA
        $response = $this->HTTP->Get($this->BASE_URI . $api);

        return $response;
    }

    /**
     * Get client videos. This will be paged.
     * @return type
     */
    public function getVideos() {

        $api = "/videos";

        //ADD ANY FILTERS
        $this->HTTP->setGlobalParams($this->filters);

        //GET CLIENT DATA
        $response = $this->HTTP->Get($this->BASE_URI . $api);

        return $response;
    }

}
