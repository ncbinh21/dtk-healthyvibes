<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Validator;

use Healthyvibes\GiaoHangNhanh\Model\Service\Helper\SubjectReader;
use Healthyvibes\IntegrationBase\Model\Service\Validator\ResultInterface;

/**
 * Class CancelOrderValidator
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Validator
 */
class CancelOrderValidator extends AbstractResponseValidator
{
    /**
     * @param array $validationSubject
     * @return ResultInterface
     */
    public function validate(array $validationSubject)
    {
        $errorMessages = [];
        $response = SubjectReader::readResponse($validationSubject);
        $validationResult = $this->validateResponseMsg($response);

        if (!$validationResult) {
            $errorMessages = [__('Something went wrong when cancel order.')];
        }

        return $this->createResult($validationResult, $errorMessages);
    }
}
