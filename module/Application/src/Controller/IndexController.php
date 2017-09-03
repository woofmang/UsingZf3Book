<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Barcode\Barcode;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    /**
     * We override the parent class' onDispatch() method to
     * set an alternative layout for all actions in this controller.
     */
    public function onDispatch(MvcEvent $e)
    {
        // Call the base class' onDispatch() first and grab the response
        $response = parent::onDispatch($e);

        // Set alternative layout
        $this->layout()->setTemplate('layout/layout2');

        // Return the response
        return $response;
    }
    public function indexAction()
    {
        return new ViewModel();
    }

    public function partialDemoAction()
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Digital Camera',
                'price' => 99.95,
            ],
            [
                'id' => 2,
                'name' => 'Tripod',
                'price' => 29.95,
            ],
            [
                'id' => 3,
                'name' => 'Camera Case',
                'price' => 2.99,
            ],
            [
                'id' => 4,
                'name' => 'Batteries',
                'price' => 39.99,
            ],
            [
                'id' => 5,
                'name' => 'Charger',
                'price' => 29.99,
            ],
        ];

        return new ViewModel(['products' => $products]);
    }

    public function aboutAction()
    {
        $appName = 'HelloWorld';
        $appDescription = 'A sample application for the Using Zend Framework 3 book';

        // Return variables to view script with the help of
        // ViewModel variable container
        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription
        ]);
    }

    public function getJsonAction()
    {
        return new JsonModel([
            'status' => 'SUCCESS',
            'message'=>'Here is your data',
            'data' => [
                'full_name' => 'John Doe',
                'address' => '51 Middle st.'
            ]
        ]);
    }

    public function barcodeAction()
    {
        // Get parameters from route.
        $type = $this->params()->fromRoute('type', 'code39');
        $label = $this->params()->fromRoute('label', 'HELLO-WORLD');

        // Set barcode options.
        $barcodeOptions = ['text' => $label];
        $rendererOptions = [];

        // Create barcode object
        $barcode = Barcode::factory($type, 'image',
            $barcodeOptions, $rendererOptions);

        // The line below will output barcode image to standard
        // output stream.
        $barcode->render();

        // Return Response object to disable default view rendering.
        return $this->getResponse();
    }

    /**
     * This is the "static" action which displays a static documentation page.
     */
    public function staticAction()
    {
        // Get path to view template from route params
        $pageTemplate = $this->params()->fromRoute('page', null);
        if ($pageTemplate==null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Render the page
        $viewModel = new ViewModel([
            'page'=>$pageTemplate
        ]);
        $viewModel->setTemplate($pageTemplate);
        return $viewModel;
    }

    public function docAction()
    {
        $pageTemplate = 'application/index/doc'.
            $this->params()->fromRoute('page', 'documentation.phtml');

        $filePath = __DIR__.'/../../view/'.$pageTemplate.'.phtml';
        if(!file_exists($filePath) || !is_readable($filePath)) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $viewModel = new ViewModel([
            'page'=>$pageTemplate
        ]);
        $viewModel->setTemplate($pageTemplate);

        return $viewModel;
    }
}
