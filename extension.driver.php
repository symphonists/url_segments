<?php
  Class extension_url_segments extends Extension
  {  
    public function about()
    {

      /*-------------------------------------------------------------------------
        Extension definition
      -------------------------------------------------------------------------*/
      return array('name' => 'URL Segments',
                   'version' => '1.0.0',
                   'release-date' => '2009-09-16',
                   'author' => array('name' => 'Max Wheeler',
                      'website' => 'http://makenosound.com/',
                      'email' => 'max@makenosound.com'),
                   'description' => 'Outputs all URL segments as params.'
             );
    }
  
    # Delegate
    public function getSubscribedDelegates()
    {
      return array(
        array(
          'page' => '/frontend/',
          'delegate' => 'FrontendParamsResolve',
          'callback' => 'segments_to_params'
        ),            
      );
    }
    
    # Adds URL segments to page parameters based on $current-page param
    public function segments_to_params($context)
    {
      # Get current path from page params
      $needle = "?";
      $current_path = $context['params']['current-path'];
      if ( strpos($current_path, $needle) != 0) $current_path = substr(strrev(strstr(strrev($current_path), strrev($needle))), 0, -strlen($needle));
      $current_path = ltrim( $current_path, "/");
      $segments = split("/",  $current_path);
      
      
      # Add to context array
      foreach ($segments as $key => $segment)
      {
        if (empty($segment)) return;
        $context['params']['url-segment-' . ($key + 1)] = $segment;
      }
    }
  }