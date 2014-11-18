<?php

    /**
     * Known pages
     */

    namespace IdnoPlugins\Known\Pages {

        /**
         * Default class to serve Known settings in administration
         */
        class Admin extends \Idno\Common\Page
        {

            function getContent()
            {
                $this->adminGatekeeper(); // Admins only
                $t = \Idno\Core\site()->template();
                $body = $t->draw('admin/known');
                $t->__(['title' => 'Known Crosspost', 'body' => $body])->drawPage();
            }

            function postContent() {
                $this->adminGatekeeper(); // Admins only
                $appId = $this->getInput('appId');
                $secret = $this->getInput('secret');
		$site = rtrim($this->getInput('site'), ' /') . '/';
				
                \Idno\Core\site()->config->config['known'] = [
		    'site' => $site,
                    'appId' => $appId,
                    'secret' => $secret
                ];
                \Idno\Core\site()->config()->save();
                \Idno\Core\site()->session()->addMessage('Your Known Crosspost application details were saved.');
                $this->forward('/admin/known/');
            }

        }

    }