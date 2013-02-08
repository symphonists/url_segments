<?php

  require_once(TOOLKIT . '/class.datasource.php');
  
  Class datasourceurl_segments extends Datasource{
    
    public $dsParamROOTELEMENT = 'url-segments';

    public function __construct(&$parent, $env=NULL, $process_params=true)
    {
      parent::__construct($parent, $env, $process_params);
      $this->_dependencies = array();
    }
    
    public function about()
    {
      return array(
           'name' => 'URL Segments as XML',
           'author' => array(
              'name' => 'Symphonists',
              'website' => 'https://github.com/symphonists'),
           'version' => '1.1',
           'release-date' => '2012-10-05');
    }
      
    public function allowEditorToParse()
    {
      return false;
    }
    
    public function grab(&$param_pool)
      {
      $result = new XMLElement($this->dsParamROOTELEMENT);
      
      foreach ($this->_env as $key => $value)
      { 
        switch ($key) {
          case 'param':
            foreach ($this->_env[$key] as $key => $value)
            {
              if (substr($key, 0, 12) == "url-segment-")
              {
                switch (substr($key, 12)) {
                  case 'last':
                    $result->setAttribute("last", $value);
                    break;
                  case 'active':
                    $result->setAttribute("active", $value);
                    break;
                  default:
                    $param = new XMLElement("segment", General::sanitize($value));
                    $result->appendChild($param);
                    break;
                }
              }
            }
            break;
          case 'env':
            foreach ($this->_env[$key]['pool'] as $key => $value)
            {
              if (substr($key, 0, 12) == "url-segment-")
              {
                switch (substr($key, 12)) {
                  case 'last':
                    $result->setAttribute("last", $value);
                    break;
                  case 'active':
                    $result->setAttribute("active", $value);
                    break;
                  default:
                    $param = new XMLElement("segment", General::sanitize($value));
                    $result->appendChild($param);
                    break;
                }
              }
            }
            break;
        }
      }
      return $result;
    }
  }