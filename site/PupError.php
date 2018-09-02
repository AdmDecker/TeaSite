<?php
    
    class PupError
    {
        private $form = '';
        public function __construct($form)
        {
            $this->form = $form;
        }

        public function Error($message)
        {
            return $this->Build('error', $message, NULL);
        }

        public function Redirect($location)
        {
            return $this->Build('redirect', NULL, $location);
        }

        public function Success($message = '')
        {
            return $this->Build('success', $message, NULL);
        }

        public function SetLoginCookie($cookieValue)
        {
            return $this->Build('setLoginCookie', $message, NULL);
        }

        private function Build($action, $message, $redirectLocation)
        {
            $json = [
                'form' => $this->form,
                'action' => $action
            ];
            
            if ($message !== NULL)
                $json['message'] = $message;
            
            if ($redirectLocation !== NULL)
                $json['location'] = $redirectLocation;

            return json_encode($json);
        }
    }
?>
