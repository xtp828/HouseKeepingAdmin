<?php
namespace Aunt\Controller;
use Aunt\Controller\CommonService;
class IndexController extends CommonService
{
    public function index()
    {
        $this->display();
    }
}