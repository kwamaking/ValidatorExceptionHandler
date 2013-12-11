<?php
namespace ValidatorExceptionHandler;

use Symfony\Component\Validator\Validation;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'ValidatorExceptionHandler' => function() {
                    return new Constraint\ConstraintViolationExceptionHandler();
                },
                'Validator' => function() {
                    $validator = Validation::createValidatorBuilder()
                        ->enableAnnotationMapping()
                        ->getValidator();
                    return $validator;
                }
            )
        );
    }
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
