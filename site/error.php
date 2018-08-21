<?php
    
    class Error
    {
        private $form = '';
        public function __construct($form)
        {
            $this->form = $form;
        }

        public function Error($message)
        {
            return Error::Build('error', $message, NULL);
        }

        public static function Redirect($location)
        {
            return Error::Build('redirect', NULL, $location);
        }

        public static function Success($message = '')
        {
            return Error::Build('success', $message, NULL);
        }

        private static function Build($action, $message, $redirectLocation)
        {
            $json = [
                'form' => $this->form,
                'action' => $action
            ];
            
            if ($message !== NULL)
                $json['message'] = $message;
            
            if ($redirectLocation !== NULL)
                $json['location'] = $redirectLocation

            return json_encode($json);
        }
    }


?>
