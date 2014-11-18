<?php

namespace IdnoPlugins\Known {
    
    class Client {
	
	private $key;
	private $secret;
	private $site;
	
	public $access_token;
	
	function __construct($apikey, $secret, $site) {
	    $this->key = $apikey;
	    $this->secret = $secret;
	    $this->site = $site;
	}
	
	public function getAuthenticationUrl($baseURL,  $parameters = []) {
	    	    
	    $url = $baseURL . "?client_id={$this->key}";
	    foreach ($parameters as $key => $value)
		$url .= '&' . urlencode($key) . '=' . urlencode($value);
	    
	    return $url;
	}
	
	public function getAccessToken($grant_type = 'authorization_code', array $parameters) {
	    
	    if ($parameters['state'] != \Idno\Core\site()->plugins()->get('Known')->getState())
		throw new \Exception('State value not correct, possible CSRF attempt.');
		
	    unset($parameters['state']);
	    
	    
	    // TODO verify code
	    
	    
	    $parameters['client_id'] = $this->key;
	    $parameters['client_secret'] = $this->secret;
	    $parameters['grant_type'] = $grant_type;
	    	    
	    return \Idno\Core\Webservice::post(\Idno\Core\site()->config()->known['site'] . 'oauth2/token', $parameters);
	    
	}
	
	public function setAccessToken($token) {
	    $this->access_token = $token;
	}
	
    }
}