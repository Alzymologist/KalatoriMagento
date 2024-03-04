<?php

namespace Alzymologist\KalatoriMax\Controller\Payment;

class Index extends \Magento\Framework\App\Action\Action
{

    // https://magento.zymologia.fi/alzymologist/payment/index


public $scopeConfig;

 public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }
    public function getConfigValue($sku) {
        return $this->scopeConfig->getValue(
        'section/group/field',
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
     );
    }

    public function execute(){

	$order_id='111';

	$total='sdsd';

	$currences='USD';

	// admin settings
	$daemon_url='http://localhost:17268'; // ??
	$store_name='My Magento';

// 
	$r=ajax('');

	if($r['result']=='paid') {
	    // SET_MAGENTO_ORDER.comlite();
	    $r['location']='/fihish/tpl.html';
	}

	$r=array('result'=>'waiting');
	jdie($r); // "waiting"

//	die("sssssssssssssssssssssssssssssssssss");
//	echo "Hello World";
//	exit;
    }

}




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


?>