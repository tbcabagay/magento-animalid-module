<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Razoyo\AnimalProfile\Controller\Profile;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Response\Http;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;
use Psr\Log\LoggerInterface;
use Razoyo\AnimalProfile\Animal;
use Razoyo\AnimalProfile\Animal\AnimalHandler;

class Photo extends \Magento\Framework\App\Action\Action implements HttpGetActionInterface
{
    /**
     * @var ScustomerSession
     */
    private $customerSession;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var Json
     */
    protected $serializer;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var Http
     */
    protected $http;

    /**
     * @var AnimalHandler
     */
    protected $animalHandler;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     * @param Json $json
     * @param LoggerInterface $logger
     * @param Http $http
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Json $json,
        LoggerInterface $logger,
        Http $http,
        Session $customerSession,
        AnimalHandler $animalHandler
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->serializer = $json;
        $this->logger = $logger;
        $this->http = $http;
        $this->customerSession = $customerSession;
        $this->animalHandler = $animalHandler;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        try {
            $photo = $this->getSelectedAnimalIdType();
            return $this->jsonResponse(['photo' => $photo->getContent()]);
        } catch (LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
        }
    }

    /**
     * Create json response
     *
     * @return ResultInterface
     */
    public function jsonResponse($response = '')
    {
        $this->http->getHeaders()->clearHeaders();
        $this->http->setHeader('Content-Type', 'application/json');
        return $this->http->setBody(
            $this->serializer->serialize($response)
        );
    }

    private function getSelectedAnimalIdType()
    {
        $animal = $this->getRequest()->getParam('animalIdType');
        $animalType = $this->animalHandler->getAnimal($animal);
        if ($animalType === false) {
            throw new \Exception('The animalid type is invalid.');
        }

        $this->customerSession->setAnimalidPhoto($animal);
        return $animalType;
    }
}

