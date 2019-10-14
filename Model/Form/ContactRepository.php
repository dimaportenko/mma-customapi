<?php

namespace MMA\CustomApi\Model\Form;

use Psr\Log\LoggerInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use MMA\CustomApi\Api\ContactRepositoryInterface;
use MMA\CustomApi\Model\Data\ResponseModel;

class ContactRepository implements ContactRepositoryInterface {

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var Context
     */
    private $context;

    /**
     * @var MailInterface
     */
    private $mail;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Context $context
     * @param MailInterface $mail
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        MailInterface $mail,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger = null
    ) {
        $this->context = $context;
        $this->mail = $mail;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger ?: ObjectManager::getInstance()->get(LoggerInterface::class);
    }

    /**
     * @param array $post Post data from contact form
     * @return void
     */
    private function sendEmail($post)
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function validatedParams($name, $comment, $email)
    {
        if (trim($name) === '') {
            throw new LocalizedException(__('Name is missing'));
        }
        if (trim($comment) === '') {
            throw new LocalizedException(__('Comment is missing'));
        }
        if (false === \strpos($email, '@')) {
            throw new LocalizedException(__('Invalid email address'));
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function contact($name, $comment, $phone, $email)
    {
        try {
            $this->validatedParams($name, $comment, $email);
            $this->sendEmail([
                'email' => $email,
                'name' => $name,
                'comment' => $comment,
                'telephone' => $phone,
            ]);
            $response = [
                'message' => 'Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.',
                'status' => true
            ];
        } catch (LocalizedException $e) {
            $response = [
                'message' => $e->getMessage(),
                'status' => false
            ];
        } catch (\Exception $e) {
            $response = [
                'message' => 'An error occurred while processing your form. Please try again later.',
                'status' => false
            ];
        }
        return $response;
    }
}