<?php
namespace Coordino\Controller\Component;

use Cake\Controller\Component;
use \Parsedown;

class Markdown extends Component 
{
    /**
     * @var \Parsedown
     */
    private $parsedown;
    
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->parsedown = Parsedown::instance();
    }
    
    public function parse($input) 
    {
        return $this->parsedown->text($input);
    }
    
    
}

