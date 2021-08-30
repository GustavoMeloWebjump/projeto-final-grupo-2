<?php
namespace Webjump\Backend\App;

use Magento\Framework\App\State;

class CustomState extends State
{
    public function validateAreaCode()
    {
        if (!isset($this->_areaCode)) {
            return false;
        }
        return true;
    }
}
