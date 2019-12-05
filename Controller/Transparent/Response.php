<?php

namespace MMA\CustomApi\Controller\Transparent;

use Magento\Framework\Registry;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Payment\Block\Transparent\Iframe;
use Magento\Paypal\Model\Payflow\Service\Response\Transaction;
use Magento\Paypal\Model\Payflow\Service\Response\Validator\ResponseValidator;
use Magento\Paypal\Model\Payflow\Transparent;
use Magento\Paypal\Model\Payflowpro;
use Magento\Quote\Api\PaymentMethodManagementInterface;
use Magento\Quote\Model\Quote\Payment;
use Magento\Sales\Api\Data\OrderPaymentInterface;
use Magento\Sales\Api\PaymentFailuresInterface;
use Magento\Framework\Session\Generic as Session;

/**
 * Class Response
 */
class Response extends \Magento\Framework\App\Action\Action
{
    /**
     * Core registry
     *
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @var ResponseValidator
     */
    private $responseValidator;

    /**
     * @var LayoutFactory
     */
    private $resultLayoutFactory;

    /**
     * @var Transparent
     */
    private $transparent;

    /**
     * @var PaymentFailuresInterface
     */
    private $paymentFailures;

    /**
     * @var Session
     */
    private $sessionTransparent;

    /**
     * @var PaymentMethodManagementInterface
     */
    private $paymentManagement;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param Transaction $transaction
     * @param ResponseValidator $responseValidator
     * @param LayoutFactory $resultLayoutFactory
     * @param Transparent $transparent
     * @param Session|null $sessionTransparent
     * @param PaymentFailuresInterface|null $paymentFailures
     * @param PaymentMethodManagementInterface $paymentManagement
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        Transaction $transaction,
        ResponseValidator $responseValidator,
        LayoutFactory $resultLayoutFactory,
        Transparent $transparent,
        Session $sessionTransparent = null,
        PaymentFailuresInterface $paymentFailures = null,
        PaymentMethodManagementInterface $paymentManagement,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->transaction = $transaction;
        $this->responseValidator = $responseValidator;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->transparent = $transparent;
        $this->sessionTransparent = $sessionTransparent ? : $this->_objectManager->get(Session::class);
        $this->paymentFailures = $paymentFailures ? : $this->_objectManager->get(PaymentFailuresInterface::class);
        $this->paymentManagement = $paymentManagement;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $parameters = [];
        try {
            $response = $this->transaction->getResponseObject($this->getRequest()->getPostValue());
            $this->responseValidator->validate($response, $this->transparent);
            $quoteId = $this->getRequest()->getParam('quoteId');

// ----  $this->transaction->savePaymentInQuote($response);
//            $payment = $this->paymentManagement->get($quoteId);
            $quote = $this->quoteRepository->get($quoteId);
            $payment = $quote->getPayment();
            $payment->setMethod('payflowpro');

            if (!$payment instanceof Payment) {
                throw new \InvalidArgumentException("Variable must contain instance of \\Quote\\Payment.");
            }

            $payment->setData(OrderPaymentInterface::CC_TYPE, $response->getData(OrderPaymentInterface::CC_TYPE));
            $payment->setAdditionalInformation(Payflowpro::PNREF, $response->getData(Payflowpro::PNREF));

//            $this->errorHandler->handle($payment, $response);

            $this->paymentManagement->set($quoteId, $payment);

// ----  $this->transaction->savePaymentInQuote($response);
        } catch (LocalizedException $exception) {
            $parameters['error'] = true;
            $parameters['error_msg'] = $exception->getMessage();
            $this->paymentFailures->handle((int)$this->sessionTransparent->getQuoteId(), $parameters['error_msg']);
        }

        return;
//        $this->coreRegistry->register(Iframe::REGISTRY_KEY, $parameters);
//
//        $resultLayout = $this->resultLayoutFactory->create();
//        $resultLayout->addDefaultHandle();
//        $resultLayout->getLayout()->getUpdate()->load(['transparent_payment_response']);
//
//        return $resultLayout;
    }
}
