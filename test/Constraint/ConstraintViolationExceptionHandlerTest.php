<?php

namespace ValidatorExceptionHandler\Constraint;

use Phake;

class ConstraintViolationExceptionHandlerTest extends \PHPUnit_Framework_TestCase {

    private $exception_handler;

    public function setUp() {
        $this->exception_handler = new ConstraintViolationExceptionHandler();
    }

    public function testHandleExceptionsChecksViolationCount() {
        $violation_list = Phake::mock('Symfony\Component\Validator\ConstraintViolationList');

        $this->exception_handler->handleExceptions($violation_list);

        Phake::verify($violation_list)->count();
    }

    public function testHandleExceptionsGetsFirstConstraintViolationIfCountOfViolationsListIsGreaterThanZero() {
        $violation_list = Phake::mock('Symfony\Component\Validator\ConstraintViolationList');
        $violation = Phake::mock('Symfony\Component\Validator\ConstraintViolation');

        Phake::when($violation_list)->count()->thenReturn(1);
        Phake::when($violation_list)->get(0)->thenReturn($violation);

        try {
            $this->exception_handler->handleExceptions($violation_list);
        } catch (\Exception $e) {

        }

        Phake::verify($violation_list)->get(0);
    }

    public function testHandleExceptionsPassesFirstViolationToThrowAnException() {
        $violation_list = Phake::mock('Symfony\Component\Validator\ConstraintViolationList');
        $violation = Phake::mock('Symfony\Component\Validator\ConstraintViolation');
        $exception = "You're doing it wrong.";

        Phake::when($violation_list)->count()->thenReturn(1);
        Phake::when($violation_list)->get(0)->thenReturn($violation);
        Phake::when($violation)->getMessage()->thenReturn($exception);

        try {
            $this->exception_handler->handleExceptions($violation_list);
            $this->fail();
        }catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), $exception);
        }

    }

    public function testthrowValidationExceptionThrowsNewExceptionWithConstraintViolationMessage() {
        $violation = Phake::mock('Symfony\Component\Validator\ConstraintViolation');
        $exception = "Stop doing it wrong.";

        Phake::when($violation)->getMessage()->thenReturn($exception);

        try {
            $this->exception_handler->throwValidationException($violation);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), $exception);
        }

        Phake::verify($violation)->getMessage();
    }
}