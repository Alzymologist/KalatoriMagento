<?php
/**
 * @category    Alzymologist
 * @package     Alzymologist_KalatoriMax
 * @author      Alzymologist
 * @copyright   Alzymologist (https://alzymologist.com)
 * @license     https://github.com/alzymologist/kalatori/blob/master/LICENSE The MIT License (MIT)
 */

declare(strict_types=1);

namespace Alzymologist\KalatoriMax\Controller\Payment;

use Alzymologist\KalatoriMax\Model\Config;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\Controller\Result\JsonFactory as ResultJsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class Index extends Action
{
    private ResultJsonFactory $resultJsonFactory;
    private Config $config;
    private CheckoutSession $checkoutSession;
    private StoreManagerInterface $storeManager;

    public function __construct(
        Context $context,
        ResultJsonFactory $resultJsonFactory,
        Config $config,
        CheckoutSession $checkoutSession,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->config = $config;
        $this->checkoutSession = $checkoutSession;
        $this->storeManager = $storeManager;
    }

    /**
     * @return ResultJson
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        /** @var ResultJson $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        $response = [];

        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->checkoutSession->getQuote();

        $response['quote_id'] = $this->checkoutSession->getQuoteId();
        $response['quote_grand_total'] = $quote->getGrandTotal();
        $response['quote_currency'] = $quote->getQuoteCurrencyCode();

        /** @var \Magento\Store\Api\Data\StoreInterface $store */
        $store = $this->storeManager->getStore();
        $response['store_base_url'] = $store->getBaseUrl();

        $response['config_title'] = $this->config->getTitle();
        $response['config_daemon_url'] = $this->config->getDaemonUrl();

//        $r = ajax('');
//
//        if ($r['result'] == 'paid') {
//            // SET_MAGENTO_ORDER.comlite();
//            $r['location'] = '/fihish/tpl.html';
//        }
//
//        $r = ['result' => 'waiting'];
//        jdie($r); // "waiting"

        return $resultJson->setData($response);
    }
}

/*
function ejdie($s) { jdie(array('error'=>1,'error_message'=>$s)); }
  function jdie($j) { die(json_encode($j)); }

  function ajax($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FAILONERROR => true,
        CURLOPT_CONNECTTIMEOUT => 2, // only spend 3 seconds trying to connect
        CURLOPT_TIMEOUT => 2 // 30 sec waiting for answer
    ));
    $r = curl_exec($ch);
    if(curl_errno($ch) || empty($r)) return array('error'=>'connect','error_message'=>curl_error($ch),'url'=>$url);

    $r = (array)json_decode($r);
    if(empty($r)) return array('error'=>'json','error_message'=>'Wrong json format','url'=>$url);
    curl_close($ch);

    // Йобаные патчи для kalatori
    if(isset($r['order'])) $r['order_id']=$r['order'];
    if(isset($r['price'])) $r['price']=1*$r['price'];
    $r['order_id']=preg_replace("/^.*\_/s",'',$r['order_id']);
    if( isset($r['mul']) && $r['mul'] < 20 ) $r['mul']=pow(10, $r['mul']);
    return $r;
  }
*/