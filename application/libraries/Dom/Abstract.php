<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
require_once("Http/Client/Adapter/Curl.php");
require_once "parselogger.php";
abstract class Dom_Abstract{
    
    protected  $baseArr = array
                (
                     'image'    => null,
                     'url'      => null,
                     'comment'     => null
                );
    protected  $query = array
                (
                    'image' => 'image',
                    'comment'=>'text',
                    'url'   => 'url'
                );
    protected $basetag = null;
    protected $dompath=null,$connection=null;
    
    public function parse($type='HTML',$xml=null,$call_save_method=null)
    {
        $doc = new DOMDocument();
        $method = strtoupper($type)=='XML'?'loadXML':'loadHTML';
        @$doc->$method($xml);
        $domxpath = new DOMXpath($doc);
        $this->dompath = new DOMXpath($doc);
            
        $data = array();
        $xNodes =  $this->domquery($this->basetag,$doc,true);
        if( ($xNodes instanceof DOMNodeList and $xNodes->length > 0)
		    or ($xNodes = (array) $xNodes)
		  )
		{
		    $i= 0;
		    
		    foreach ($xNodes as $Node)
		    {
		        
		        
		        $tmp = $this->baseArr;
		        foreach ($this->query as $key=>$query)
                {
                    if($query !=null)
                    {
                        
                        $tmp[$key] = $this->domquery($query, $Node);                                            
                    }
                    else 
                    {
                        $callmethod = "_get".ucfirst($key);
                        if(method_exists($this, $callmethod))
                        {
                            $tmp[$key] = $this->$callmethod($Node);
                        }
                        else 
                        {
                            $tmp[$key] = null;
                        }
                    }
                }
                /* call save method per node*/
                if ($call_save_method!=null)
                {
                    if( method_exists($this, $call_save_method) )
                    {
                        $this->$call_save_method($tmp);
                    }
                }
                else 
                {
                    /*construct a 2 dimentional array to return*/
                    $data[++$i] = $tmp;
                }
                        
		        
		    }
		    
		}
		else 
		{
		    if(defined('DEBUG_MODE') && DEBUG_MODE)
            {
		      Parserlogger::logger("Sorry no nodes found".PHP_EOL);
            }
		}
		if( !method_exists($this, $call_save_method) )
        {
            return $data;
        }
		
    }
    
    public function getHtml($url=null,$method='GET',$data=null,$persistent=false,$new=true)
    {
        if ($new && !isset($this->connection))
        {
            if(defined('DEBUG_MODE') && DEBUG_MODE)
            {
               Parserlogger::logger("start connection initialization....".PHP_EOL);
            }
            $this->initializeconn();	
        }
        $this->connection->write($method,$url,$data);
        $html = $this->connection->read();
        if (!$persistent)
        {
           $this->closeconn(); 
        }
        return $html;
        
    }
    public function initializeconn()
    {
        $this->connection = new Cinema_Http_Client_Adapter_Curl();
        $this->connection->connect();       
    }
    public function closeconn()
    {
        if(defined('DEBUG_MODE') && DEBUG_MODE)
        {
            Parserlogger::logger("close url connection....".PHP_EOL);
        }
        $this->connection->close();
        unset($this->connection);
    }
    
    protected final function domquery( $query, DOMNode $domNode, $asNodeList = false )
    {
        $result=null;
        $result = $this->dompath->query($query, $domNode);
        if( $asNodeList )
        {
          return $result;
        }
        else
        {
          $text = '';    
          for( $i = 0; $i < $result->length; ++$i )
          {
             $text .= $result->item($i)->textContent;
          }    
          return trim($text);
        }
  }
  
  protected function preprocess($html)
  {
  	return $html;
  }   
}