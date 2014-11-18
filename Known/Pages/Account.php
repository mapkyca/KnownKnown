<?php

    /**
     * Known pages
     */

    namespace IdnoPlugins\Known\Pages {

        /**
         * Default class to serve Known-related account settings
         */
        class Account extends \Idno\Common\Page
        {

            function getContent()
            {
                $this->gatekeeper(); // Logged-in users only
                if ($known = \Idno\Core\site()->plugins()->get('Known Crosspost')) {
                    if (!$known->hasKnown()) {
                        if ($knownAPI = $known->connect()) {
                            $login_url = $knownAPI->getAuthenticationUrl(
				\IdnoPlugins\Known\Main::$AUTHORIZATION_ENDPOINT,
				\IdnoPlugins\Known\Main::getRedirectUrl(),
				['response_type' => 'code', 'state' => \IdnoPlugins\Known\Main::getState()] 
                            );
			    
                        }
                    } else {
                        $login_url = '';
                    }
                }
                $t = \Idno\Core\site()->template();
                $body = $t->__(['login_url' => $login_url])->draw('account/known');
                $t->__(['title' => 'Known Crosspost', 'body' => $body])->drawPage();
            }

            function postContent() {
                $this->gatekeeper(); // Logged-in users only
                if (($this->getInput('remove'))) {
                    $user = \Idno\Core\site()->session()->currentUser();
                    $user->known = [];
                    $user->save();
                    \Idno\Core\site()->session()->addMessage('Your Known Crosspost settings have been removed from your account.');
                }
                $this->forward('/account/known/');
            }

        }

    }