<?php
/**
 * MultiSafepay Rest Api Fetch Payments Methods Request.
 */

namespace Omnipay\MultiSafepay\Message;

/**
 * MultiSafepay Rest Api Fetch Payments Methods Request.
 *
 * The MultiSafepay API supports multiple payment gateways, such as
 * iDEAL, Paypal or CreditCard. This request provides a list
 * of all supported payment methods.
 *
 * ### Example
 *
 * <code>
 *    $request = $gateway->fetchPaymentMethods();
 *    $response = $request->send();
 *    $paymentMethods = $response->getPaymentMethods();
 *    print_r($paymentMethods);
 * </code>
 *
 * @link https://www.multisafepay.com/documentation/doc/API-Reference
 * @link https://docs.multisafepay.com/api/#gateways
 */
class RestFetchPaymentMethodsRequest extends RestAbstractRequest
{
    /**
     * Get the country.
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->getParameter('country');
    }

    /**
     * Set the country.
     *
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }
    
    
    /**
     * Set include (Specify comma delimited additional payment method types. Options: coupons)
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setInclude($value)
    {
        return $this->setParameter('include', $value);
    }

    /**
     * Get include
     * @return string|null
     */
    public function getInclude()
    {
        return $this->getParameter('include');
    }
    
    /**
     * Get the required data for the API request.
     *
     * @return array
     */
    public function getData()
    {
        parent::getData();

        $data = array(
            'amount' => $this->getAmountInteger(),
            'country' => $this->getCountry(),
            'currency' => $this->getCurrency(),
            'include' => $this->getInclude()
        );

        return array_filter($data);
    }

    /**
     * Execute the API request.
     *
     * @param mixed $data
     * @return RestFetchPaymentMethodsResponse
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('GET', '/gateways?' . http_build_query($data));

        $this->response = new RestFetchPaymentMethodsResponse(
            $this,
            json_decode($httpResponse->getBody()->getContents(), true)
        );

        return $this->response;
    }
}
