Validator Exception Handler
=========================

A very simple exception handler for Symfony's Validator.

Installation
-----

To install with composer simply require:

    "kwamaking/validator-exception-handler": "dev-master"

Usage
-----

For documentation on how to use Symfony's Validator please see:

http://symfony.com/doc/2.4/book/validation.html

Note:  You can pull the annotation style validator from the service locator using the "Validator" key.

The usage is pretty simple.  If you follow Symfony's documentation for validating a full object, you can take the response from that and pass it into the exception handler.

    $exception_handler = $this->service_locator->get('ValidatorExceptionHandler');//or
    $exception_handler = new ConstraintViolationExceptionHandler();
    $exception_handler->handleException($violation_list); //this will throw a validation exception if there is one

When you validate an object with Symfony's Validator, it will hand back a constraint violation list, full of constraint violation objects.  This simple tool just grabs the first object in that list, and throws an exception with the violation message.

Why?
-----

The philosophy on user input is that it's prone to error, which makes that expected.  The way that I use Symfony's Validator is by filling a model from a restful request.  I need to validate the data being sent to me before i persist it to a database.  I need to return certain response codes or json response objects if one of the constraints isn't met.  This simple utility is designed to handle that.

Final Thoughts
-----

I eventually want to add to this. I'll add custom exceptions based on the individual constraints being violated.