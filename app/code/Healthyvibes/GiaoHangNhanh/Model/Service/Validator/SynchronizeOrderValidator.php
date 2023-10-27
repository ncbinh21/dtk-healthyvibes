<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Validator;

use Healthyvibes\GiaoHangNhanh\Model\Service\Helper\SubjectReader;
use Healthyvibes\GiaoHangNhanh\Model\Service\Request\AbstractDataBuilder;
use Healthyvibes\IntegrationBase\Model\Service\Validator\ResultInterface;

/**
 * Class SynchronizeOrderValidator
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Validator
 */
class SynchronizeOrderValidator extends AbstractResponseValidator
{
    /**
     * @param array $validationSubject
     * @return ResultInterface
     */
    public function validate(array $validationSubject)
    {
        $errorMessages = [];
        $response = SubjectReader::readResponse($validationSubject);
        $responseData = SubjectReader::readResponseData($response);
        $validationResult = $this->validateResponseMsg($response) && $this->validateOrderCode($responseData);

        if (!$validationResult) {
            $errorMessages = [__('Something went wrong when synchronize order.')];
        }

        return $this->createResult($validationResult, $errorMessages);
    }

    /**
     * @param array $responseData
     * @return bool
     */
    private function validateOrderCode(array $responseData)
    {
        return isset($responseData[AbstractDataBuilder::ORDER_CODE]) && $responseData[AbstractDataBuilder::ORDER_CODE];
    }
}
