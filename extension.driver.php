<?php
  Class extension_url_segments extends Extension
  {
    
    /*-------------------------------------------------------------------------
      Extension definition
    -------------------------------------------------------------------------*/
    public function about()
    {
      return array('name' => 'URL Segments',
                   'version' => '1.0.1',
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
      # Get current path from page params, replacement for lack of "before_needle" in strstr
      $needle = "?";
      $current_path = $context['params']['current-path'];
      if ( strpos($current_path, $needle) != 0)
      {
        $current_path = substr(strrev(strstr(strrev($current_path), strrev($needle))), 0, -strlen($needle));
      }
      $current_path = ltrim( $current_path, "/");
      $segments = split("/",  $current_path);
      
      # Add to context['params'] array
      foreach ($segments as $key => $segment)
      {
        if (empty($segment))
        {
          unset($segments[$key]);
          continue;
        }
        $context['params']['url-segment-' . ($key + 1)] = $segment;
      }
      # If no segment (i.e. index page)
      if (count($segments) == 0) {
        $context['params']['url-segment-last'] = $context['params']['url-segment-1'] = $context['params']['current-page'];
        $context['params']['url-segment-active'] = 1;
      } else {
        $context['params']['url-segment-last'] = end($segments);
        $context['params']['url-segment-active'] = count($segments); 
      }
    }
  }