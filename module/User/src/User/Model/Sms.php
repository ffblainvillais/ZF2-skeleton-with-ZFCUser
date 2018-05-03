<?php
namespace Sms\Model;

class Sms
{
    protected $config;
    public function __construct($config)
    {
        if (isset($config['SMS'])) {
            $sms_conf            = $config['SMS'];
            $this->loginOVH      = $sms_conf['login'];
            $this->passwordOVH   = $sms_conf['password'];
            $this->SMSaccountOVH = $sms_conf['account'];
            $this->numberFrom    = $sms_conf['numberFrom'];
            $this->smsValidity   = $sms_conf['smsValidity'];
            $this->smsClass      = $sms_conf['smsClass'];
            $this->smsDeferred   = $sms_conf['smsDeferred'];
            $this->smsPriority   = $sms_conf['smsPriority'];
            $this->smsCoding     = $sms_conf['smsCoding'];
            $this->tag           = $sms_conf['tag'];
            $this->noStop        = $sms_conf['noStop'];
        }


    }
    private $loginOVH = '';
    private $passwordOVH = null;
    private $SMSaccountOVH = '';
    private $numberFrom = 'LEGALLAIS';
    //the maximum time -in minute(s)- before the message is dropped, defaut is 48 hours
    private $smsValidity = '30';
    //the sms class: flash(0),phone display(1),SIM(2),toolkit(3)
    private $smsClass = '0';
    //smsDeferred : the time -in minute(s)- to wait before sending the message, default is 0
    private $smsDeferred = '0';
    //smsPriority : the priority of the message (0 to 3), default is 3
    private $smsPriority = '3';
    //smsCoding : the sms coding : 1 for 7 bit or 2 for unicode, default is 1
    private $smsCoding = '1';
    //tag : an optional tag;
    private $tag = '';
    //noStop : do not display STOP clause in the message, this requires that this is not an advertising message
    private $noStop = '1';

    public function send($numberTo, $message){
        $result = false;
        try {
            $soap = $this->_getSoapClient();
            $session = $soap->login($this->loginOVH, $this->passwordOVH,"fr", false);
            $result = $soap->telephonySmsSend(
                                                $session,
                                                $this->SMSaccountOVH,
                                                $this->numberFrom,
                                                $numberTo,
                                                $message,
                                                $this->smsValidity,
                                                $this->smsClass,
                                                $this->smsDeferred,
                                                $this->smsPriority,
                                                $this->smsCoding,
                                                $this->tag,
                                                $this->noStop
                                            );
            $soap->logout($session);
        } catch(\SoapFault $fault) {
            throw new \Exception($fault, 1);
        }
        return $result;
    }

    public function getCreditLeft(){
    //$session = $soap->login("$loginOVH", "$passwordOVH","fr", false);
        $soap = $this->_getSoapClient();
        $session = $soap->login($this->loginOVH, $this->passwordOVH,"fr", false);
        $result = $soap->telephonySmsCreditLeft($session, $this->SMSaccountOVH);
        return $result;
    }

    private function _getSoapClient(){
        $soap = new \SoapClient("https://www.ovh.com/soapi/soapi-re-1.52.wsdl");
        return $soap;
    }
}
