<?php

namespace ValidatorExceptionHandler\Constraint;

use ValidatorExceptionHandler\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationExceptionHandler {

    public function handleExceptions(ConstraintViolationListInterface $violations) {
        if ($violations->count() > 0) {
            $violation = $violations->get(0);
            $this->throwValidationException($violation);
        }
    }

    public function throwValidationException(ConstraintViolationInterface $violation) {
        $exception_message = $violation->getMessage();

        throw new ValidationException($exception_message);
    }
}